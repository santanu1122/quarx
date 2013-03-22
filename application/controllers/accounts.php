<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class accounts extends CI_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

/* Main Account
***************************************************************/  

    function index() {   
        if($this->session->userdata('user_id') == 1){
            $this->load->model('modelsetup');
            $version = $this->modelsetup->current_version();
            $data['current_quarx_version'] = $version[0]->option_title;

            $version_list = file_get_contents('http://ottacon.co/_quarx_/version_list.json');
            $version_list = json_decode($version_list);
            $data['latest_quarx_version'] = $version_list->quarx->ver;

            $this->load->library('plugin_tools');

            //Check active plugins
            $this->load->model('modelsetup');
            $plugin_qry = $this->modelsetup->installed_plugins();

            $data['plugin_updates_available'] = false;

            if($plugin_qry){
                foreach ($plugin_qry as $plugin) {
                    if($plugin->plugin_version < latest_plugin_version($plugin->plugin_id_tag)){ 
                        $data['plugin_updates_available'] = true;
                    }
                }
            }
        }

        if(isset($_GET['success'])){
            $data['profilesuccess'] = 'Your password has been changed successfully.';
        }
        if(isset($_GET['profilesuccess'])){
            $data['profilesuccess'] = 'Your profile has been updated successfully.';
        }
        //load up the model
        $this->load->model('modelaccounts');
        
        if($this->session->userdata('logged_in')){
            //Pull in the accounts to manage
            $data['account'] = $this->modelaccounts->account_manager();
            
            //Pull in the accounts to manage
            $data['myprofile'] = $this->modelaccounts->my_account();
        }

        $data['opts'] = $this->quarxsetup->account_opts();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Accounts';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/accounts', $data);
        $this->load->view('common/footer', $data);
    }

    function profile_updater() {
        if($this->input->post('userfile')){
            //first we run through this function and drop the old image to save space
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($_POST['user_id']);
            foreach($profile as $myprofileImg): endforeach;
            
            $oldimg = $myprofileImg->img;
            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
                unlink('./uploads/img/full/'.$oldimg);
                unlink('./uploads/img/thumb/'.$oldimg);
                }
            }
            
        //load the form helper to help with the image upload
        $this->load->helper(array('form', 'url'));
        
        //set the parameters of the files new name
        $id = 'img';
        $now = time();
        
        //setting the configuration for the file uploads
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        //we make this variable for the make_thumb function
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        //Check for advanced accounts
        $opts = $this->quarxsetup->account_opts();

        if ( ! $this->upload->do_upload() )
        {
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($this->session->userdata('user_id'));
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            //Send the data to the model page to update the profile
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->profile_update($img, $opts);
            redirect('accounts?profilesuccess');
        }
        else{
            $this->make_thumb($img);
            
            //Send the data to the model page to update the profile
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->profile_update($img, $opts);
            
            if($query) 
            {
                redirect('accounts?profilesuccess');
            }
            else
            {
                $data['error'] = 'Sorry, but were unable to update your profile.';
                
                //configure the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Accounts';
                $data['sub_menu_title'] = 'Accounts';

                $plugin_qry = $this->menusetup->plugins();
                if($plugin_qry){
                    foreach ($plugin_qry as $plugin) {
                        $data[$plugin->plugin_name] = $plugin->plugin_title;
                    }
                }
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/accounts/accounts', $data);
                $this->load->view('common/footer', $data);
            }
        }
    }

/* General Tools
***************************************************************/ 

    function make_thumb($img) {
        //set the configuration to make a new file
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/thumb/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 450;
        $config['height'] = 338;
        //load the library tool
        $this->load->library('image_lib', $config);
        //run the function
        $this->image_lib->resize(); 
    }

    function insufficient() {   
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Login';
        $data['date'] = date("m-d-y");

        $plugin_qry = $this->menusetup->plugins();
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/insufficient', $data);
        $this->load->view('common/footer', $data);
    }
    
    function emailme($to, $name, $from, $subject, $message) {
        $this->load->library('email');

        $config['charset'] = 'utf-8';
        $config['protocol'] = 'sendmail';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from($from, $name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        $this->email->send();
    }

/* Change Password
***************************************************************/

    function password() {   
        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Change my Password';
        $data['sub_menu_title'] = 'Change my Password';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/password_changer', $data);
        $this->load->view('common/footer', $data);
    }   

    function changepassword() {   
        if($this->input->post('password')==$this->input->post('password2')) {
            //Hop, skip, and jump our way through
            $this->load->model('modellogin');
            $query = $this->modellogin->changepassword();
            
            if($query){
                redirect('accounts?success');
            }else{
                redirect('accounts?error');
            }
        }
    }  
    
/* Add/Remove Profiles
***************************************************************/  

    function add() {   
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        if(isset($_GET['error'])){
            $data['error'] = 'Sorry, we were unable to add that account.';
        }
        
        $data['opts'] = $this->quarxsetup->account_opts();

        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Add an Account';
        $data['sub_menu_title'] = 'Add an Account';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/add_account', $data);
        $this->load->view('common/footer', $data);
    }   

    public function unc($name) {
        if($name > ''){
            //load the preliminary parts
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->unc_validate($name);
            //check the data
            $data['result'] = $query;
            if($query == 1){
                $this->load->view('core/accounts/unc', $data);
            }else{
                $this->load->view('core/accounts/unc', $data);
            }
        }else{
            redirect('login');
        }
    }

    function add_profile() {   
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }
                
        $this->load->model('modelaccounts');
        $qry = $this->modelaccounts->username_checker();
        
        if($qry){
            redirect('accounts/add?error');
        }else{
            //load the form helper to help with the image upload
            $this->load->helper(array('form', 'url'));
            
            //set the parameters of the files new name
            $id = 'img';
            $now = time();
            
            //setting the configuration for the file uploads
            $config['upload_path'] = './uploads/img/full/';
            $config['allowed_types'] = 'gif|jpeg|jpg|png';
            $config['max_size'] = '4000';
            $config['file_name'] = $id.'_'.$now.'.jpg';
            
            //we make this variable for the make_thumb function
            $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';
    
            $this->load->library('upload', $config);
    
            if ( ! $this->upload->do_upload() ){
                $img = site_url().'uploads/img/thumb/default.jpg';
            }else{
                $this->make_thumb($img);
            }

            $opts = $this->quarxsetup->account_opts();    
            $this->load->model('modelaccounts');
            $rand = $this->modelaccounts->profile_adder($img, $opts);
        
            if($rand){
                //send the new user some information
                $to = $this->input->post('user_email');
                $name = $this->input->post('user_name');
                $from = 'do-not-reply';
                $subject = 'Your New Account';
                $message = '
<h3>Congratulations, you have a new account.</h3>
<p>Username: '.$this->input->post('user_name').'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the next time you login. Thank you.</p>';

            $this->emailme($to, $name, $from, $subject, $message);

            redirect('accounts/view');

            }else{
                redirect('accounts/add?error');
            }
        }
    }
    
    function delete_user($id) {
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        $this->load->model('modelaccounts');
        //get the users image name and delete the actual image!
        //first we run through this function and drop the old image to save space
        $profile = $this->modelaccounts->this_account($id);
        foreach($profile as $myprofileImg): endforeach;
        
        $oldimg = $myprofileImg->img;
        if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
            unlink('./uploads/img/full/'.$oldimg);
            unlink('./uploads/img/thumb/'.$oldimg);
        }
        
        //now we delete the user
        $query = $this->modelaccounts->profile_deleter($id);
        
        if($query) {
            redirect('accounts/view');
        }
    }

    function authorize_user($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->authorize_user($id);
        
        if($query){
            redirect('accounts/view');
        }
    }

    function enable_user($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->enable_user($id);
        
        if($query){
            redirect('accounts/view');
        }
    }

    function enable_user_editor($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->enable_user($id);
        
        if($query){
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_upgrade($id);
        
        if($query){
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_downgrade($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_downgrade($id);
        
        if($query){
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade_view($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_upgrade($id);
        
        if($query){
            redirect('accounts/view');
        }
    }

    function master_user_downgrade_view($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_downgrade($id);
        
        if($query){
            redirect('accounts/view');
        }
    }

    function disable_user($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->disable_user($id);
        
        if($query){
            redirect('accounts/view');
        }
    }

    function disable_user_editor($id) {
        //Set their user_status to enabled!
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->disable_user($id);
        
        if($query){
            redirect('accounts/editor/'.encrypt($id));
        }
    }

/* Edit User Profiles
***************************************************************/   

    function editor($type) {
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        if(isset($_GET['success'])){
            $data['success'] = "This profile was successfully updated.";
        }

        if(isset($_GET['error'])){
            $data['error'] = "There was an error updating this profile.";
        }
        
        $this->load->library('account_tools');
        $this->load->library('cryptography');
        $type = decrypt($type);
        
        $data['opts'] = $this->quarxsetup->account_opts(); 

        //grab the profile from the database
        $this->load->model('modelaccounts');
        $data['profile'] = $this->modelaccounts->editor($type);
        
        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Edit an Account';
        $data['sub_menu_title'] = 'Edit an Account';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/editor', $data);
        $this->load->view('common/footer', $data);
    }  
        
    function profile_editor() {       
        $this->load->library('cryptography');
        //load the form helper to help with the image upload
        $this->load->helper(array('form', 'url'));
        
        if($this->input->post('userfile')){
            //first we run through this function and drop the old image to save space
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($_POST['user_id']);
            foreach($profile as $myprofileImg): endforeach;
            
            $oldimg = $myprofileImg->img;
            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
                unlink('./uploads/img/full/'.$oldimg);
                unlink('./uploads/img/thumb/'.$oldimg);
            }
        }
        
        //set the parameters of the files new name
        $id = 'img';
        $now = time();
        
        //setting the configuration for the file uploads
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpeg|jpg|png';
        $config['max_size'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        //we make this variable for the make_thumb function
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);
        $opts = $this->quarxsetup->account_opts(); 

        if ( ! $this->upload->do_upload()){
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($_POST['user_id']);
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            //Send the data to the model page to update the profile
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');
        }else{
            $this->make_thumb($img);
            
            //Send the data to the model page to update the profile
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            if($query){
                redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');
            }else{
                redirect('accounts/editor/'.encrypt($_POST['user_id']).'?error');
            }
        }
    }


/* View User Profiles
***************************************************************/

    function view() {
        // $this->output->cache(9);
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        //Grab the tools
        $this->load->library('toolbelt'); 
        $this->load->library('cryptography'); 
        
        //just to load up the pagination tools and model
        $this->load->library('pagination'); 
        $this->load->model('modelaccounts');
        
        $config['base_url'] = site_url('accounts/view');
        $config['total_rows'] = $this->modelaccounts->all_profiles_tally();
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
            
        $this->pagination->initialize($config);
        
        //Send the data to the model page to update the profile
        $data['profiles'] = $this->modelaccounts->all_profiles($this->uri->segment(3), $config['per_page']);

        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Accounts';
        $data['sub_menu_title'] = 'Accounts;';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/view', $data);
        $this->load->view('common/footer', $data);       
    }

/* Search User Profiles
***************************************************************/

    function search($id = null){
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            //check if master access is on
            if($setup[2]->option_title === 'master access'){
                redirect('accounts/permission'); // Denied! 
            }
        }

        $this->load->library('cryptography');
        $this->load->library('toolbelt');

        if($id == null){ $id = $this->input->post('search', true); }
        $offset = $this->uri->segment(4);
        
        $this->load->library('pagination');
        $this->load->model('modelaccounts');
        
        $config['base_url'] = site_url('accounts/results/'.$id);
        $config['total_rows'] = $this->modelaccounts->full_search_totals($id);
        $config['per_page'] = 10;
        $config['num_links'] = 20;
        $config['uri_segment'] = 4;  
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
            
        $this->pagination->initialize($config);
        
        $qry = $this->modelaccounts->search_accounts_full($id, $offset, $config['per_page']);
        
        //we need to send the settings first to decide what we can do!
        $data['totals'] = $config['total_rows'];
        //load some data, and the pagination tool!
        $data['results'] = $qry;

        $plugin_qry = $this->menusetup->plugins();
        
        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Search Engine';
        $data['sub_menu_title'] = 'Search Engine';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/accounts/search', $data);
        $this->load->view('common/footer', $data);  
    }

// End of Class accounts
    
}
/* End of file accounts.php */
/* Location: ./application/controllers/ */