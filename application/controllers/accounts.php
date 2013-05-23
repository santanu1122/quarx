<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class accounts extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        
        if(!$this->session->userdata('logged_in')){
            redirect('login/error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

/* Main Account
***************************************************************/  

    function index() 
    {   
        if(isset($_GET['success']))
        {
            $data['profilesuccess'] = 'Your password has been changed successfully.';
        }
        if(isset($_GET['profilesuccess']))
        {
            $data['profilesuccess'] = 'Your profile has been updated successfully.';
        }

        $this->load->model('modelaccounts');
        
        if($this->session->userdata('logged_in'))
        {
            $data['account'] = $this->modelaccounts->account_manager();
            $data['myprofile'] = $this->modelaccounts->my_account();
        }

        $data['opts'] = $this->quarxsetup->account_opts();
        $data['page'] = base_url().'accounts';
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'My Account';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/accounts', $data);
        $this->load->view('common/footer', $data);
    }

    function profile_updater() 
    {
        $this->load->helper(array('form', 'url'));

        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');
        
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        $opts = $this->quarxsetup->account_opts();

        if ( ! $this->upload->do_upload() )
        {
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($this->session->userdata('user_id'));
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->profile_update($img, $opts);
            
            redirect('/accounts?profilesuccess');
        }
        else
        {
            $this->make_thumb($img);
            $this->make_medium($img);

            /* Clean out the old
            ***************************************************************/

            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($this->session->userdata('user_id'));
            foreach($profile as $myprofileImg): endforeach;

            $oldimg = $myprofileImg->img;
            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg'){
                $x_img = str_replace(site_url().'uploads/img/thumb/', '', $oldimg);

                unlink('./uploads/img/full/'.$x_img);
                unlink('./uploads/img/medium/'.$x_img);
                unlink('./uploads/img/thumb/'.$x_img);
            }
            
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->profile_update($img, $opts);

            /*
            ***************************************************************/
            
            if($query)
            {
                redirect('accounts?profilesuccess');

            }
            else
            {
                $data['error'] = 'Sorry, but were unable to update your profile.';    
                redirect('accounts?error');
            }
        }
    }

/* General Tools
***************************************************************/ 

/* Generate a thumbnail img
*************************************/
    function make_thumb($img)
    {
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/thumb/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 250;
        $config['height'] = 188;

        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Generate a medium img
*************************************/
    function make_medium($img)
    {
        $img_root = str_replace(site_url().'uploads/img/thumb/', "", $img);
        $this->load->library('image_lib');

        $config['image_library'] = 'gd2';
        $config['source_image'] = './uploads/img/full/'.$img_root;
        $config['new_image'] = './uploads/img/medium/'.$img_root;
        $config['thumb_marker'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 800;
        $config['height'] = 600;

        $this->image_lib->initialize($config);

        $this->image_lib->resize();
        $this->image_lib->clear();
    }

/* Denied Access
***************************************************************/

    function insufficient()
    {   
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Login';
        $data['date'] = date("m-d-y");

        $plugin_qry = $this->menusetup->plugins();
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/insufficient', $data);
        $this->load->view('common/footer', $data);
    }

/* Email tool
***************************************************************/
    
    function emailme($to, $name, $from, $subject, $message) 
    {
        $this->load->library('email');

        $config['charset'] = 'utf-8';
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from('do-not-reply@'.$_SERVER['HTTP_HOST']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        $this->email->send();
    }

/* Change Password
***************************************************************/

    function password() 
    {

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Change my Password';
        $data['sub_menu_title'] = 'Change my Password';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/password_changer', $data);
        $this->load->view('common/footer', $data);
    }   

    function changepassword() 
    {   
        if($this->input->post('password') == $this->input->post('confirm')) 
        {
            $this->load->model('modellogin');
            $query = $this->modellogin->changepassword();
            
            if($query)
            {
                redirect('accounts?success');
            }
            else
            {
                redirect('accounts?error');
            }
        }
    }  
    
/* Add/Remove Profiles
***************************************************************/  

    function add() 
    {   
        if($this->session->userdata('permission') > 1){
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }

        if(isset($_GET['error'])){
            $data['error'] = 'Sorry, we were unable to add that account.';
        }
        
        $data['opts'] = $this->quarxsetup->account_opts();
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Add an Account';
        $data['sub_menu_title'] = 'Add an Account';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/add_account', $data);
        $this->load->view('common/footer', $data);
    }   

    function unc($name) 
    {
        if($name > '')
        {
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->unc_validate($name);
            
            echo $query;
        }
        else
        {
            redirect('login');
        }
    }

    function add_profile()
    {   
        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();

            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }
                
        $this->load->model('modelaccounts');
        $qry = $this->modelaccounts->username_checker();
        
        if($qry)
        {
            redirect('accounts/add?error');
        }
        else
        {
            $this->load->helper(array('form', 'url'));
            
            $id = 'img';
            $now = time();
            
            ini_set('memory_limit','128M');
        
            $config['upload_path'] = './uploads/img/full/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
            $config['max_size'] = '4000';
            $config['max_width'] = '4000';
            $config['max_height'] = '4000';
            $config['file_name'] = $id.'_'.$now.'.jpg';
            
            $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';
    
            $this->load->library('upload', $config);
    
            if ( ! $this->upload->do_upload() )
            {
                $img = site_url().'uploads/img/thumb/default.jpg';
            }
            else
            {
                $this->make_thumb($img);
                $this->make_medium($img);
            }

            $opts = $this->quarxsetup->account_opts();
            $this->load->model('modelaccounts');
            $rand = $this->modelaccounts->profile_adder($img, $opts);
        
            if($rand)
            {
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

            }
            else
            {
                redirect('accounts/add?error');
            }
        }
    }
    
    function delete_user($id) 
    {
        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }

        $this->load->model('modelaccounts');

        $profile = $this->modelaccounts->this_account($id);
        foreach($profile as $myprofileImg): endforeach;
        
        $oldimg = $myprofileImg->img;
        if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg')
        {
            unlink('./uploads/img/full/'.$oldimg);
            unlink('./uploads/img/thumb/'.$oldimg);
        }
        
        $query = $this->modelaccounts->profile_deleter($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function authorize_user($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->authorize_user($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function enable_user($id)
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->enable_user($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function enable_user_editor($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->enable_user($id);
        
        if($query)
        {
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_upgrade($id);
        
        if($query){
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_downgrade($id)
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_downgrade($id);
        
        if($query)
        {
            redirect('accounts/editor/'.encrypt($id));
        }
    }

    function master_user_upgrade_view($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_upgrade($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function master_user_downgrade_view($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->master_user_downgrade($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function disable_user($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->disable_user($id);
        
        if($query)
        {
            redirect('accounts/view');
        }
    }

    function disable_user_editor($id) 
    {
        $this->load->model('modelaccounts');
        $query = $this->modelaccounts->disable_user($id);
        
        if($query)
        {
            redirect('accounts/editor/'.encrypt($id));
        }
    }

/* Edit User Profiles
***************************************************************/   

    function editor($type)
    {
        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }

        if(isset($_GET['success']))
        {
            $data['success'] = "This profile was successfully updated.";
        }

        if(isset($_GET['error']))
        {
            $data['error'] = "There was an error updating this profile.";
        }
        
        $this->load->model('modelaccounts');
        $this->load->library('account_tools');
        $this->load->library('cryptography');
        $type = decrypt($type);
        
        $data['opts'] = $this->quarxsetup->account_opts(); 
        $data['profile'] = $this->modelaccounts->editor($type);
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Edit an Account';
        $data['sub_menu_title'] = 'Edit an Account';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/editor', $data);
        $this->load->view('common/footer', $data);
    }  
        
    function profile_editor() 
    {       
        $this->load->library('cryptography');
        $this->load->helper(array('form', 'url'));
        
        if($this->input->post('userfile'))
        {
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($_POST['user_id']);
            
            foreach($profile as $myprofileImg): endforeach;
            
            $oldimg = $myprofileImg->img;
            
            if($oldimg && $oldimg != site_url().'uploads/img/thumb/default.jpg')
            {
                unlink('./uploads/img/full/'.$oldimg);
                unlink('./uploads/img/medium/'.$oldimg);
                unlink('./uploads/img/thumb/'.$oldimg);
            }
        }
        
        $id = 'img';
        $now = time();
        
        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        
        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);
        $opts = $this->quarxsetup->account_opts(); 

        if ( ! $this->upload->do_upload() )
        {        
            $this->load->model('modelaccounts');
            $profile = $this->modelaccounts->this_account($_POST['user_id']);
            foreach($profile as $myprofileImg): endforeach;
            
            $img = $myprofileImg->img;

            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');

        }
        else
        {
            $this->make_thumb($img);
                
            $this->load->model('modelaccounts');
            $query = $this->modelaccounts->this_profile_update($img, $_POST['user_id'], $opts);
            
            if($query)
            {
                redirect('accounts/editor/'.encrypt($_POST['user_id']).'?success');
            }
            else
            {
                redirect('accounts/editor/'.encrypt($_POST['user_id']).'?error');
            }
        
        }
    }


/* View User Profiles
***************************************************************/

    function view() 
    {
        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }

        $this->load->library('toolbelt'); 
        $this->load->library('pagination'); 
        $this->load->model('modelaccounts');
        
        $config['base_url'] = site_url('accounts/view');
        $config['total_rows'] = $this->modelaccounts->all_profiles_tally();
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->cur_page = $this->uri->segment(2);
        $this->pagination->initialize($config);
        
        $data['profiles'] = $this->modelaccounts->all_profiles($this->uri->segment(2), $config['per_page']);
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Accounts';
        $data['sub_menu_title'] = 'Accounts;';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/view', $data);
        $this->load->view('common/footer', $data);       
    }

/* Search User Profiles
***************************************************************/

    function search($id = null)
    {
        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();
            if($setup[2]->option_title !== 'master access')
            {
                redirect('login/insufficient');
            }
        }

        $this->load->library('cryptography');
        $this->load->library('toolbelt');

        if($id == null){ $id = $this->input->post('search', true); }
        $offset = $this->uri->segment(3);
        
        $this->load->library('pagination');
        $this->load->model('modelaccounts');
        
        $config['base_url'] = site_url('accounts/search/'.$id);
        $config['total_rows'] = $this->modelaccounts->full_search_totals($id);
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';
        
        $this->cur_page = $this->uri->segment(3);
        $this->pagination->initialize($config);
        
        $qry = $this->modelaccounts->search_accounts_full($id, $offset, $config['per_page']);
        
        $data['searchTerm'] = $this->input->post('search');
        $data['totals'] = $config['total_rows'];
        $data['results'] = $qry;

        if(count($qry) == 0)
        {
            $data['empty_result'] = 'Sorry, we were unable to find any one';
        }
        else
        {
            $data['empty_result'] = '';
        }
        
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Search Accounts';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/accounts/search', $data);
        $this->load->view('common/footer', $data);  
    }
}
/* End of file accounts.php */
/* Location: ./application/controllers/ */