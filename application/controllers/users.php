<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS application
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 *
 */

class Users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        if ( ! $this->session->userdata('logged_in')) redirect('error/login?r='.($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    /**
     * Replaces the index method and calls the needed method or errors
     *
     * @param  string $method
     * @param  mixed  $params
     *
     * @return method
     */
    public function _remap($method, $params = array())
    {
        if (method_exists(__CLASS__, $method)) {
            $this->$method($params);
        } else {
            $this->profile();
        }
    }

    /**
     * View current users profile
     *
     * @return null
     */
    public function profile()
    {
        $this->load->model('model_users');

        $data['myprofile'] = $this->model_users->my_profile();

        $data['page'] = base_url().'accounts';
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'My Profile';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/my-account', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * View the current users settings
     *
     * @return null
     */
    public function settings()
    {
        $this->load->model('model_users');

        $data['notifications_setting'] = ($this->user_tools->getUserNotificationSettings() ? "checked" : "");

        $data['myprofile'] = $this->model_users->my_profile();
        $data['page'] = base_url().'accounts';
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'User: Module Settings';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/settings', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * Update the current users settings
     *
     * @return redirect
     */
    public function settings_update()
    {
        $this->load->model('model_users');
        $update = $this->model_users->settings_update();

        $this->session->set_flashdata('message', array("error", "Your settings were not saved."));
        if ($update) $this->session->set_flashdata('message', array("info", "Your settings were saved."));

        redirect("users/settings");
    }

    /**
     * Update the current user's profile
     *
     * @return redirect
     */
    public function update()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_users');

        $my_profile = $this->model_users->get_this_user($this->session->userdata('user_id'));

        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');

        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';
        $this->load->library('upload', $config);

        $my_img = $my_profile->img;

        if ( ! $this->upload->do_upload())
        {
            $new_profile_img = $my_img;
        }
        else
        {
            $new_profile_img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

            $this->image_tools->make_thumb($new_profile_img);
            $this->image_tools->make_medium($new_profile_img);

            // Clean out the old images
            if ($my_img != site_url().'uploads/img/thumb/default.jpg')
            {
                $img_to_delete = str_replace(site_url().'uploads/img/thumb/', '', $my_img);
                @unlink('./uploads/img/full/'.$img_to_delete);
                @unlink('./uploads/img/medium/'.$img_to_delete);
                @unlink('./uploads/img/thumb/'.$img_to_delete);
            }
        }

        $profile_is_updated = $this->model_users->profile_update($new_profile_img);
        $message = array("error", "Your profile was not saved.");

        if ($profile_is_updated) $message = array("info", "Your profile was successfully saved.");

        $this->session->set_flashdata('message', $message);

        redirect('users/profile');
    }

    /**
     * Change password view
     *
     * @return null
     */
    public function password()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Change my Password';
        $data['sub_menu_title'] = 'Change my Password';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/password-update', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * Change password action
     *
     * @return redirect
     */
    public function password_change()
    {
        $this->load->model('model_users');

        if($this->input->post('password') == $this->input->post('confirm') && $this->input->post('confirm') !== '')
        {
            $query = $this->model_users->change_password();

            $message = array("Error", "Your profile failed to update.");
            if ($query) $message = array("Success", "Your profile was updated.");

            $this->session->set_flashdata('message', $message);
            redirect('users/profile');
        }

        $this->session->set_flashdata('message', array("Error", "Your profile failed to update."));
        redirect('users/profile');
    }

/*
|--------------------------------------------------------------------------
| CMS Related Functions
|--------------------------------------------------------------------------
*/

    /**
     * Add user
     */
    public function add()
    {
        if ($this->config->item("quarx-mode") == "application") redirect("users/profile");

        if ($this->session->userdata('permission') > 1)
        {
            if($this->quarx->get_option("access_type") !== 'master access') redirect('users/insufficient');
        }

        $js = array('views/users/add-user.js');
        $this->carabiner->group("quarx-add-users", array('js'=>$js));

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Add a User';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/add-account', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * Add new user data to Quarx
     */
    public function add_profile()
    {
        if ($this->config->item("quarx-mode") == "application") redirect("users/profile");

        if ($this->session->userdata('permission') > 1)
        {
            if ($this->quarx->get_option("access_type") !== 'master access') redirect('users/insufficient');
        }

        $this->load->model('model_users');

        if ($this->input->post('username') == '' || $this->input->post('email') == '')
        {
            $this->session->set_flashdata('message', array('Error', 'Failed to add a new user'));
            redirect('users/add');
        }

        $qry = $this->model_users->username_checker();

        if ( ! $qry)
        {
            $this->session->set_flashdata('message', array('Error', 'Failed to add a new user'));
            redirect('users/add');
        }

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

        $this->load->library('upload', $config);

        $img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

        if ( ! $this->upload->do_upload())
        {
            $img = site_url().'uploads/img/thumb/default.jpg';
        }
        else
        {
            $this->image_tools->make_thumb($img);
            $this->image_tools->make_medium($img);
        }

        $this->load->model('model_users');
        $rand = $this->model_users->add_profile($img, null, "on");

        if ($rand)
        {
            $to = $this->input->post('email');
            $name = $this->input->post('username');
            $from = 'do-not-reply';
            $subject = 'Your New '.$_SERVER['HTTP_HOST'].' Account';
            $message = '
<h3>Congratulations, you have a new account on '.$_SERVER['HTTP_HOST'].'.</h3>
<p>Username: '.$this->input->post('username').'</p>
<p>Password: '.$rand.'</p>
<p>Please be sure to change your password the next time you login. Thank you.</p>';

            $this->email($to, $name, $from, $subject, $message);

            $this->session->set_flashdata('message', array('Success', 'Successfully added a new user'));
            redirect('users/add');
        }

        $this->session->set_flashdata('message', array('Error', 'Failed to add a new user'));
        redirect('users/add');
    }

    /**
     * Edit a user
     *
     * @param  [type] $id [description]
     *
     * @return [type]     [description]
     */
    public function editor($id)
    {
        if ($this->config->item("quarx-mode") == "application") redirect("users/profile");

        if ($this->session->userdata('permission') > 1)
        {
            if($this->quarx->get_option("access_type") !== 'master access') redirect('users/insufficient');
        }
        $this->load->model('model_users');

        $id = $this->crypto->decrypt($id[0]);

        $js = array(
            array('views/quarx-loading.js'),
            array('views/users/quarx-users.js')
        );
        $this->carabiner->group("quarx-users-js", array('js'=>$js));

        if (intval($id) == 0) redirect("users");

        $profile = $this->model_users->get_this_user($id);

        $data['profile'] = $profile;
        $data['read_state'] = ($profile->account_status == 'inactive' ? 'readonly' : '');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Edit a User';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/edit-account', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * Delete the user
     *
     * @param  string $id
     *
     * @return redirect
     */
    public function delete_user($params)
    {
        if ($this->config->item("quarx-mode") == "application") redirect("users/profile");

        if ($this->session->userdata('permission') > 1)
        {
            if($this->quarx->get_option("access_type") !== 'master access') redirect('users/insufficient');
        }

        $this->load->model('model_users');

        $id = $this->crypto->decrypt($params[0]);
        $profile = $this->model_users->get_this_user($id);

        if ($profile) {

            $oldimg = $profile->img;

            if ($oldimg != site_url().'uploads/img/thumb/default.jpg')
            {
                @unlink('./uploads/img/full/'.$oldimg);
                @unlink('./uploads/img/thumb/'.$oldimg);
            }

            $query = $this->model_users->profile_deleter($id);

            if ($query) $message = array('Success', 'Successfully deleted a user');

        }
        else
        {
            $message = array('Error', 'Could not delete user');
        }

        $this->session->set_flashdata('message', $message);
        redirect("users/view");
    }

    /**
     * Modify the user's profile
     *
     * @param  string $field
     * @param  string $id
     *
     * @return redirect
     */
    public function modify_user($params)
    {
        $field = $params[0];
        $id = $this->crypto->decrypt($params[1]);

        if ($this->config->item("quarx-mode") == "application") redirect("users/profile");

        if ($this->session->userdata('permission') > 1)
        {
            if ($this->quarx->get_option("access_type") !== 'master access') redirect('users/insufficient');
        }

        $this->load->model('model_users');

        switch ($field) {
            case 'authorize':
                $this->load->library("express_mail");
                $this->express_mail->activated_account($this->user_tools->getUserEmail($id));
                $message = array("Success", "This user's account is authorized");
                break;

            case 'enable':
                $message = array("Success", "This user's account is enabled");
                break;

            case 'disable':
                $message = array("Success", "This user's account is disabled");
                break;

            case 'master':
                $message = array("Success", "This user is now a master user");
                break;

            case 'standard':
                $message = array("Success", "This user is now a standard user");
                break;
        }

        $query = $this->model_users->set_user_profile($id, $field);

        if ($query)
        {
            $this->session->set_flashdata('message', $message);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->session->set_flashdata('error', 'We encountered an error modifying this user');
        redirect("error");
    }

    /**
     * Update a users profile
     *
     * @return redirect
     */
    public function update_user_profile()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->model('model_users');

        $user_id = $this->crypto->decrypt($this->input->post('id'));
        $profile = $this->model_users->get_this_user($user_id);

        $id = 'img';
        $now = time();

        ini_set('memory_limit','128M');

        $config['upload_path'] = './uploads/img/full/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
        $config['max_size'] = '4000';
        $config['max_width'] = '4000';
        $config['max_height'] = '4000';
        $config['file_name'] = $id.'_'.$now.'.jpg';

        $this->load->library('upload', $config);

        $their_img = $profile->img;

        if ( ! $this->upload->do_upload())
        {
            $new_profile_img = $their_img;
        }
        else
        {
            $new_profile_img = site_url().'uploads/img/thumb/'.$id.'_'.$now.'.jpg';

            $this->image_tools->make_thumb($new_profile_img);
            $this->image_tools->make_medium($new_profile_img);

            // Clean out the old images
            if ($their_img != site_url().'uploads/img/thumb/default.jpg')
            {
                $img_to_delete = str_replace(site_url().'uploads/img/thumb/', '', $their_img);
                unlink('./uploads/img/full/'.$img_to_delete);
                unlink('./uploads/img/medium/'.$img_to_delete);
                unlink('./uploads/img/thumb/'.$img_to_delete);
            }
        }

        $profile_is_updated = $this->model_users->user_profile_update($new_profile_img, $user_id);
        $message = array("error", "This profile was not saved.");

        if ($profile_is_updated) $message = array("info", "This profile was successfully saved.");

        $this->session->set_flashdata('message', $message);
        redirect($_SERVER['HTTP_REFERER']);
    }

    /**
     * Insufficient permission view
     *
     * @return null
     */
    public function insufficient()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Limbo';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/insufficient', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * View all users that the current user has permission over
     *
     * @return null
     */
    public function view()
    {
        $this->load->model('model_users');

        if ($this->session->userdata('permission') > 1)
        {
            if($this->quarxsetup->get_option("access_type") !== 'master access')
            {
                redirect('users/insufficient');
            }
        }

        $js = array('views/users/quarx-users.js');
        $this->carabiner->group("quarx-users-js", array('js'=>$js));

        $this->load->library('tools');
        $this->load->library('pagination');

        $config['base_url'] = site_url('users/view');
        $config['total_rows'] = $this->model_users->all_profiles_tally();
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 2;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->cur_page = $this->uri->segment(2);
        $this->pagination->initialize($config);

        $data['profiles'] = $this->model_users->all_profiles($this->uri->segment(2), $config['per_page']);
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Users';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/view', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * User seach view
     *
     * @param  mised $params
     *
     * @return null
     */
    public function search($params)
    {
        $id = $params[0] ?: null;

        if($this->session->userdata('permission') > 1)
        {
            if($this->quarxsetup->get_option("access_type") !== 'master access')
            {
                redirect('users/insufficient');
            }
        }

        $this->load->library('pagination');

        $js = array('views/users/quarx-users.js');
        $this->carabiner->group("quarx-users-js", array('js'=>$js));

        $data['searchTerm'] = null;
        $data['totals'] = null;
        $data['results'] = null;
        $data['empty_result'] = 'Please enter user information in order to find someone.';

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Search Accounts';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/search', $data);
        $this->load->view('common/footer', $data);
    }

    /**
     * Search action method
     *
     * @param  mixed $params
     *
     * @return redirect
     */
    public function search_for($params)
    {
        $term = $params[0] ?: null;

        if($this->session->userdata('permission') > 1)
        {
            if($this->quarxsetup->get_option("access_type") !== 'master access')
            {
                redirect('users/insufficient');
            }
        }

        $this->load->model('model_users');
        $this->load->library('pagination');

        $term = $this->input->post('search', true);

        redirect("users/result/".$term);
    }

    /**
     * Search results view
     *
     * @param  mixed $params
     *
     * @return null
     */
    public function result($params)
    {
        $term = $params[0] ?: null;

        if($this->session->userdata('permission') > 1)
        {
            if($this->quarxsetup->get_option("access_type") !== 'master access')
            {
                redirect('users/insufficient');
            }
        }

        $this->load->model('model_users');
        $this->load->library('pagination');

        $js = array('views/users/quarx-users.js');
        $this->carabiner->group("quarx-users-js", array('js'=>$js));

        $offset = $this->uri->segment(3);

        $config['base_url'] = site_url('users/result/'.$term);
        $config['total_rows'] = $this->model_users->full_search_totals($term);
        $config['per_page'] = 20;
        $config['num_links'] = 10;
        $config['uri_segment'] = 3;
        $config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>';

        $this->cur_page = $this->uri->segment(3);
        $this->pagination->initialize($config);

        $users = $this->model_users->search_accounts_full($term, $offset, $config['per_page']);

        $data['searchTerm'] = $term;
        $data['totals'] = $config['total_rows'];
        $data['results'] = $users;
        $data['empty_result'] = '';

        if (count($qry) == 0) $data['empty_result'] = 'Sorry, we were unable to find any one';

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Search Accounts';

        $this->load->view('common/header', $data);
        $this->load->view('core/users/search', $data);
        $this->load->view('common/footer', $data);
    }

/*
|--------------------------------------------------------------------------
| Private Functions
|--------------------------------------------------------------------------
*/

    private function email($params)
    {
        $to = $params[0];
        $name = $params[1];
        $from = $params[2];
        $subject = $params[3];
        $message = $params[4];

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

}

/* End of file Users.php */
/* Location: ./application/controllers/ */