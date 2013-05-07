<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class users extends MX_Controller {

    function __construct(){
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            redirect('login/error'); // Denied! 
        }

        if($this->session->userdata('permission') > 1){
            $access = check_master_access(); //check if master access is on
            if($access){
                redirect('login/insufficient'); // Denied! 
            }
        }
    }

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

/* Main Pages functions
***************************************************************/

    public function index() {
        redirect('users/view');
    }

    public function add() {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/add', $data);
        $this->load->view('common/footer', $data);
    }

    public function editor($id) {
        $this->load->model('model_users');
        $user = $this->model_users->get_this_user(decrypt($id));
        
        if($user){
            $data['u'] = $user[0];
        }else{
            redirect('users/view');
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : Editor';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/editor', $data);
        $this->load->view('common/footer', $data);
    }

    public function view() {
        $this->load->model('model_users');
        // $this->load->library('users_parent_tools');

        //In order to see all our lovely users entries
        $data['users'] = $this->model_users->get_all_users();
        
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : View';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $data);
        $this->load->view('users/view', $data);
        $this->load->view('common/footer', $data);
    }

    function search(){
        $name = $_POST['search'];
        $this->load->model('model_users');
        $qry = $this->model_users->search_users($name);

        if($qry){
            $data['results'] = $qry;
        }else{
            $data['results'] = 'error';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : Search';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $data);
        $this->load->view('users/search', $data);
        $this->load->view('common/footer', $data);
    }

    public function settings() {
        $this->load->model('model_users_settings');
        $settings = $this->model_users_settings->get_settings();

        //Auto-Authorization
        $aa = $settings[0]->setting_state;
        if($aa == 1){
            $data['autoAuth'] = 'checked="checked"';
        }else{
            $data['autoAuth'] = '';
        }

        //Public Profiles
        $pp = $settings[1]->setting_state;
        if($pp == 1){
            $data['pubProfile'] = 'checked="checked"';
        }else{
            $data['pubProfile'] = '';
        }

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users : Settings';

        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('users/extras', $data);
        $this->load->view('users/users_menu', $users);
        $this->load->view('users/settings', $data);
        $this->load->view('common/footer', $data);
    }

/* Invisible
***************************************************************/

    public function unc($name) {
        if($name > ''){
            $this->load->model('model_users');
            $query = $this->model_users->unc_validate($name);
            
            echo $query;
        }else{
            redirect('login');
        }
    }

/* Add User
***************************************************************/

    public function add_user() {
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

        $this->load->model('model_users');
        $qry = $this->model_users->add_user($img);
        
        if($qry){
            redirect('users/view');
        }else{
            echo 'duplicate user';
        }
    }

/* Edit User
***************************************************************/

    public function update_user() {
        $this->load->library('cryptography');
        //load the form helper to help with the image upload
        $this->load->helper(array('form', 'url'));
        
        if($this->input->post('userfile')){
            //first we run through this function and drop the old image to save space
            $this->load->model('model_users');
            $profile = $this->model_users->get_this_user($this->input->post('user_id'));
            foreach($profile as $myprofileImg): endforeach;
            
            $oldimg = $myprofileImg->user_img;
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

        if ( ! $this->upload->do_upload() ){
            // $this->load->model('modelaccounts');
            // $profile = $this->modelaccounts->this_account($_POST['user_id']);
            // foreach($profile as $myprofileImg): endforeach;
            
            // $img = $myprofileImg->img;

            // //Send the data to the model page to update the profile
            // $this->load->model('modelaccounts');
            // $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            // redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');

            $this->load->model('model_users');
            $profile = $this->model_users->get_this_user($this->input->post('user_id'));
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->user_img;

        }else{
            $this->make_thumb($img);
            $this->make_medium($img);
            //Send the data to the model page to update the profile
            // $this->load->model('modelaccounts');
            // $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            // if($query){
            //     redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');
            // }else{
            //     redirect('accounts/editor/'.encrypt($_POST['user_id']).'?error');
            // }

            
        }

        $this->load->model('model_users');
        $qry = $this->model_users->update_user($img);
        
        if($qry){
            redirect('users/view?success');
        }else{
            redirect('users/view?efail');
        }
    }    

/* Delete User
***************************************************************/

    public function delete_user($id) {
        $this->load->model('model_users');
        $qry = $this->model_users->delete_user(decrypt($id));
        
        if($qry){
            redirect('users/view');
        }else{
            redirect('users/view?dfail');
        }
    }

/* Enable User
***************************************************************/
    
    public function enable_user($id) {
        $this->load->model('model_users');
        $qry = $this->model_users->enable_user(decrypt($id));
        
        if($qry){
            redirect('users/view');
        }else{
            redirect('users/view?fail');
        }
    }

/* Disable User
***************************************************************/
    
    public function disable_user($id) {
        $this->load->model('model_users');
        $qry = $this->model_users->disable_user(decrypt($id));
        
        if($qry){
            redirect('users/view');
        }else{
            redirect('users/view?fail');
        }
    }

/* Settings
***************************************************************/

    public function update_settings(){
        $this->load->model('model_users_settings');
        $qry = $this->model_users_settings->update_settings();

        if($qry){
            redirect('users/settings?success');
        }else{
            redirect('users/settings?fail');
        }
    }

}

/* End of file users.php */
// /* Location: ./application/modules/users/controllers/ */