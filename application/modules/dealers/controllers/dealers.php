<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class dealers extends MX_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1 && $this->session->userdata('permission') < 50){
            $access = check_master_access(); //check if master access is on
            if($access){
                redirect('login/insufficient'); // Denied! 
            }
        }
    }

/* Main Dealers functions
***************************************************************/

    function index() {
        redirect('dealers/view/all');
    }

    function profile_updater() {
    
        $this->load->helper(array('form', 'url'));
        
        //set the parameters of the files new name
        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');
        
        //setting the configuration for the file uploads
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        //we make this variable for the make_thumb function
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        //Check for advanced accounts
        $opts = $this->quarxsetup->account_opts();

        if ( ! $this->upload->do_upload() )
        {
            $this->load->model('model_dealers');
            $profile = $this->model_dealers->this_account($this->session->userdata('user_id'));
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            //Send the data to the model page to update the profile
            $this->load->model('model_dealers');
            $query = $this->model_dealers->profile_update($img, $opts);
            
             // $this->index();
            
            redirect('/accounts?profilesuccess');
        }
        else{
            $this->make_thumb($img);
            $this->make_medium($img);

            /* Clean out the old
            ***************************************************************/

            //first we run through this function and drop the old image to save space
            $this->load->model('model_dealers');
            $profile = $this->model_dealers->this_account($this->session->userdata('user_id'));
            foreach($profile as $myprofileImg): endforeach;

            $oldimg = $myprofileImg->img;
            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
                $x_img = str_replace(site_url().'uploads/img/thumb/', '', $oldimg);

                unlink('./uploads/img/full/'.$x_img);
                unlink('./uploads/img/medium/'.$x_img);
                unlink('./uploads/img/thumb/'.$x_img);
            }
            
            //Send the data to the model page to update the profile
            $this->load->model('model_dealers');
            $query = $this->model_dealers->profile_update($img, $opts);

            /*
            ***************************************************************/
            
            if($query){
                redirect('dealers?profilesuccess');

            }else{
                $data['error'] = 'Sorry, but were unable to update your profile.';
                
                redirect('dealers?error');
            }
        }
    }

/* General Tools
***************************************************************/ 

/* Generate a thumbnail img
*************************************/
    function make_thumb($img){
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');
        //set the configuration to make a new file
        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/thumb/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 250;
        $config['height'] = 188;
        //initialize the function
        $this->image_lib->initialize($config);
        //run the function
        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Generate a medium img
*************************************/
    function make_medium($img){
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');
        //set the configuration to make a new file
        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/medium/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;
        //initialize the function
        $this->image_lib->initialize($config);
        //run the function
        $this->image_lib->resize();
        $this->image_lib->clear();
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
        $this->load->view('dealers/insufficient', $data);
        $this->load->view('common/footer', $data);
    }
    
    function emailme($to, $name, $from, $subject, $message) {
        $this->load->library('email');

        $config['charset'] = 'utf-8';
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from($from);
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
        $this->load->view('dealers/password_changer', $data);
        $this->load->view('common/footer', $data);
    }   

    function changepassword() {   
        if($this->input->post('password') == $this->input->post('confirm')) {
            //Hop, skip, and jump our way through
            $this->load->model('modellogin');
            $query = $this->modellogin->changepassword();
            
            if($query){
                redirect('dealers?success');
            }else{
                redirect('dealers?error');
            }
        }
    }  
    
/* Add/Remove Profiles
***************************************************************/  

    function add() {   
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
        $this->load->view('dealers/dealer_menu', $data);
        $this->load->view('dealers/add_account', $data);
        $this->load->view('common/footer', $data);
    }   

    public function unc($name) {
        if($name > ''){
            //load the preliminary parts
            $this->load->model('model_dealers');
            $query = $this->model_dealers->unc_validate($name);
            
            //check the data
            echo $query;
        }else{
            redirect('login');
        }
    }

    function add_profile() {                   
        $this->load->model('model_dealers');
        $qry = $this->model_dealers->username_checker();
        
        if($qry){
            redirect('dealers/add?error');
        }else{
            //load the form helper to help with the image upload
            $this->load->helper(array('form', 'url'));
            
            //set the parameters of the files new name
            $id = 'img';
            $now = time();
            
           ini_set('memory_limit','128M');
        
            //setting the configuration for the file uploads
            $config['upload_path'] = './uploads/img/full/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['max_size'] = '4000';
            $config['max_width'] = '4000';
            $config['max_height'] = '4000';
            $config['file_name'] = $id.'_'.$now.'.jpg';
            
            //we make this variable for the make_thumb function
            $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';
    
            $this->load->library('upload', $config);
    
            if ( ! $this->upload->do_upload() ){
                $img = site_url().'uploads/img/thumb/default.jpg';
            }else{
                $this->make_thumb($img);
                $this->make_medium($img);
            }

            $opts = $this->quarxsetup->account_opts();    
            $this->load->model('model_dealers');
            $rand = $this->model_dealers->profile_adder($img, $opts);
        
            if($rand){
                //send the new user some information
                $to = $this->input->post('user_email');
                $name = $this->input->post('user_name');
                $from = 'do-not-reply@'.$_SERVER['HTTP_HOST'];
                $subject = 'Your New Account';
                $message = '
<h3>Congratulations, you have a new account on '.$_SERVER['HTTP_HOST'].'.</h3>
<p>Username: '.$this->input->post('user_name').'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the next time you login. Thank you.</p>';

            $this->emailme($to, $name, $from, $subject, $message);

            redirect('dealers/view/all');

            }else{
                redirect('dealers/add?error');
            }
        }
    }
    
    function delete_user($id) {
        $this->load->model('model_dealers');
        //get the users image name and delete the actual image!
        //first we run through this function and drop the old image to save space
        $profile = $this->model_dealers->this_account($id);
        foreach($profile as $myprofileImg): endforeach;
        
        $oldimg = $myprofileImg->img;
        if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
            unlink('./uploads/img/full/'.$oldimg);
            unlink('./uploads/img/thumb/'.$oldimg);
        }
        
        //now we delete the user
        $query = $this->model_dealers->profile_deleter($id);
        
        if($query) {
            redirect('dealers/view/all');
        }
    }

    function authorize_user($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->authorize_user($id);
        
        if($query){
            redirect('dealers/view/all');
        }
    }

    function enable_user($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->enable_user($id);
        
        if($query){
            redirect('dealers/view/all');
        }
    }

    function enable_user_editor($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->enable_user($id);
        
        if($query){
            redirect('dealers/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade($id) {
        $this->load->model('model_dealers');
        $query = $this->model_dealers->master_user_upgrade($id);
        
        if($query){
            redirect('dealers/editor/'.encrypt($id));
        }
    }

    function master_user_downgrade($id) {
        $this->load->model('model_dealers');
        $query = $this->model_dealers->master_user_downgrade($id);
        
        if($query){
            redirect('dealers/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade_view($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->master_user_upgrade($id);
        
        if($query){
            redirect('dealers/view/all');
        }
    }

    function master_user_downgrade_view($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->master_user_downgrade($id);
        
        if($query){
            redirect('dealers/view/all');
        }
    }

    function disable_user($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->disable_user($id);
        
        if($query){
            redirect('dealers/view/all');
        }
    }

    function disable_user_editor($id) {
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->disable_user($id);
        
        if($query){
            redirect('dealers/editor/'.encrypt($id));
        }
    }

/* Edit User Profiles
***************************************************************/   

    function editor($type) {
        if(isset($_GET['success'])){
            $data['success'] = "This profile was successfully updated.";
        }

        if(isset($_GET['error'])){
            $data['error'] = "There was an error updating this profile.";
        }
        
        $this->load->library('account_tools');
        $this->load->library('cryptography');

        $this->load->library('dealer_tools');
        $type = decrypt($type);
        
        $data['opts'] = $this->quarxsetup->account_opts(); 

        //grab the profile from the database
        $this->load->model('model_dealers');
        $data['profile'] = $this->model_dealers->editor($type);

        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Edit an Account';
        $data['sub_menu_title'] = 'Edit an Account';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('dealers/dealer_menu', $data);
        $this->load->view('dealers/editor', $data);
        $this->load->view('common/footer', $data);
    }  
        
    function profile_editor() {       
        $this->load->library('cryptography');
        //load the form helper to help with the image upload
        $this->load->helper(array('form', 'url'));
        
        if($this->input->post('userfile')){
            //first we run through this function and drop the old image to save space
            $this->load->model('model_dealers');
            $profile = $this->model_dealers->this_account($_POST['user_id']);
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
            $this->load->model('model_dealers');
            $profile = $this->model_dealers->this_account($_POST['user_id']);
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            //Send the data to the model page to update the profile
            $this->load->model('model_dealers');
            $query = $this->model_dealers->this_profile_update($img, $_POST['user_id'], $opts);
            
            redirect('dealers/editor/'.encrypt($_POST['user_id']).'?success');
        }else{
            $this->make_thumb($img);
            
            //Send the data to the model page to update the profile
            $this->load->model('model_dealers');
            $query = $this->model_dealers->this_profile_update($img, $_POST['user_id'], $opts);
            
            if($query){
                redirect('dealers/editor/'.encrypt($_POST['user_id']).'?success');
            }else{
                redirect('dealers/editor/'.encrypt($_POST['user_id']).'?error');
            }
        }
    }


/* View User Profiles
***************************************************************/

    function view($sorter) {
        // $this->output->cache(9);
        $permission = $this->session->userdata('permission');

        //Grab the tools
        $this->load->library('toolbelt'); 
        $this->load->library('dealer_tools'); 
        
        //just to load up the pagination tools and model
        $this->load->library('pagination'); 
        $this->load->model('model_dealers');
        
        $config['base_url'] = site_url('dealers/view').'/'.$sorter;
        $config['total_rows'] = $this->model_dealers->all_profiles_tally($permission);
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->cur_page = $this->uri->segment(3);
        $this->pagination->initialize($config);
        
        //Send the data to the model page to update the profile
        $data['profiles'] = $this->model_dealers->all_profiles($this->uri->segment(3), $config['per_page'], $sorter, $permission);

        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Accounts';
        $data['sub_menu_title'] = 'Accounts;';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('dealers/dealer_menu', $data);
        $this->load->view('dealers/view', $data);
        $this->load->view('common/footer', $data);       
    }

/* Account Relations
***************************************************************/

    function relations() {
        // $this->output->cache(9);
        if($this->session->userdata('permission') != 1){
            redirect('dealers');
        }

        //Grab the tools
        $this->load->library('toolbelt'); 
        $this->load->library('dealer_tools'); 
        
        //just to load up the pagination tools and model
        // $this->load->library('pagination'); 
        $this->load->model('model_dealers');
        
        // $config['base_url'] = site_url('dealers/view').'/'.$sorter;
        // $config['total_rows'] = $this->model_dealers->all_profiles_tally();
        // $config['per_page'] = 20;
        // $config['num_links'] = 10;
        // $config['uri_segment'] = 3;
        // $config['full_tag_open'] = '<div id="pagination">';
        // $config['full_tag_close'] = '</div>';
        
        // $this->cur_page = $this->uri->segment(3);
        // $this->pagination->initialize($config);
        
        //Send the data to the model page to update the profile
        $data['profiles'] = $this->model_dealers->get_tms();

        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Accounts';
        $data['sub_menu_title'] = 'Accounts;';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('dealers/extras', $data);
        $this->load->view('dealers/dealer_menu', $data);
        $this->load->view('dealers/relations', $data);
        $this->load->view('common/footer', $data);       
    }

/* Search User Profiles
***************************************************************/

    function search($id = null){
        $this->load->library('cryptography');
        $this->load->library('toolbelt');

        if($id == null){ $id = $this->input->post('search', true); }
        $offset = $this->uri->segment(3);
        
        $this->load->library('pagination');
        $this->load->model('model_dealers');
        
        $config['base_url'] = site_url('accounts/search/'.$id);
        $config['total_rows'] = $this->model_dealers->full_search_totals($id);
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->cur_page = $this->uri->segment(3);
        $this->pagination->initialize($config);
        
        $qry = $this->model_dealers->search_accounts_full($id, $offset, $config['per_page']);
        
        // Search Term
        $data['searchTerm'] = $this->input->post('search');

        // Results
        $data['totals'] = $config['total_rows'];
        $data['results'] = $qry;

        if(count($qry) == 0){
            $data['empty_result'] = 'Sorry, we were unable to find any one';
        }
        
        //configure the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Search Accounts';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('dealers/dealer_menu', $data);
        $this->load->view('dealers/search', $data);
        $this->load->view('common/footer', $data);  
    }

    function tm_option_list(){
        $res = '';

        $this->load->model('model_dealers');
        $list = $this->model_dealers->get_tms();

        foreach($list as $a):

        $res .= '<option value="'.$a->user_id.'">'.$a->company.'</option>';

        endforeach;

        echo $res;
    }

/* Special Functions for the Relations
***************************************************************/

    public function get_encrypted_string(){
        echo encrypt($_GET['key']);
    }

    function switch_owners() {
        $owner = $this->input->post('owner');
        $id = $this->input->post('dealer');
        //Set their user_status to enabled!
        $this->load->model('model_dealers');
        $query = $this->model_dealers->switch_owners($owner, $id);
        
        if($query){
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    function tm_tracker(){
        $id = $this->input->post('id');
        $this->load->model('model_dealers');
        $query = $this->model_dealers->tm_tracker($id);
        
        if($query){
            echo 'success';
        }else{
            echo 'fail';
        }
    }
    
}

/* End of file dealers.php */
/* Location: ./application/modules/dealers/controllers/ */