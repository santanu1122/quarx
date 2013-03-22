<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class setup extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();

        if($qry !== false){

            if($this->session->userdata('user_id') != 1){
                redirect('accounts/permission');
            }

            if(!$this->session->userdata('logged_in')){
                redirect('login/error'); // Denied! 
            }

            if($this->session->userdata('permission') > 1){
                $setup = $this->quarxsetup->account_opts();
                //check if master access is on
                if($setup[2]->option_title === 'master access'){
                    redirect('accounts/permission'); // Denied! 
                }
            }
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index() {
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();
        if($qry !== false){
            $data['quarxInstalled'] = 'installed';
        }
    
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';

        $this->load->view('core/setup/header', $data);
        if($qry === false){
            $this->load->view('core/setup/db_setup', $data);
        }else{
            redirect('setup/master');
        }
        $this->load->view('core/setup/footer', $data);
    }

    public function error(){
        $data['error'] = $this->session->flashdata('error');
        $this->load->view('core/errors/general', $data);
    }

    public function db_complete() {
        // first we setup the database connection
        $db_file = 
"<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['hostname'] The hostname of your database server.
|   ['username'] The username used to connect to the database
|   ['password'] The password used to connect to the database
|   ['database'] The name of the database you want to connect to
|   ['dbdriver'] The database type. ie: mysql.  Currently supported:
                 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|   ['dbprefix'] You can add an optional prefix, which will be added
|                to the table name when using the  Active Record class
|   ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|   ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|   ['cache_on'] TRUE/FALSE - Enables/disables query caching
|   ['cachedir'] The path to the folder where cache files should be stored
|   ['char_set'] The character set used in communicating with the database
|   ['dbcollat'] The character collation used in communicating with the database
|                NOTE: For MySQL and MySQLi databases, this setting is only used
|                as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                (and in table creation queries made with DB Forge).
|                There is an incompatibility in PHP with mysql_real_escape_string() which
|                can make your site vulnerable to SQL injection if you are using a
|                multi-byte character set and are running versions lower than these.
|                Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|   ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|   ['autoinit'] Whether or not to automatically initialize the database.
|   ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                           - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'default';
\$active_record = TRUE;

\$db['default']['hostname'] = 'localhost';
\$db['default']['username'] = '".$_POST['db_uname']."';
\$db['default']['password'] = '".$_POST['db_password']."';
\$db['default']['database'] = '';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */";

        $db_connection = $this->modelsetup->connect_to_db( $_POST['db_uname'], $_POST['db_password'] );
        if(!$db_connection){
            $this->session->set_flashdata('error', 'We\'re unable to connect to your database with these credentials...');
            redirect('setup/error');
        }

        unlink('application/config/database.php');

        $this->load->helper('file');
        
        $path = 'application/config/database.php';

        if ( ! write_file($path, $db_file) ){
             
             echo 'Unable to set up the database. Please recheck your information and try agian.';
        
        }else{
            $db_array = array(
                'db_uname' => $_POST['db_uname'],
                'db_password' => $_POST['db_password'],
                'db_name' => $_POST['db_name'] 
            );

            $this->session->set_userdata('db_array', $db_array);

                $name = $_POST['db_uname'];
                $password = $_POST['db_password'];
                $db = $_POST['db_name'];

                redirect("setup/connect_to_database/".encrypt($name)."/".encrypt($password)."/".encrypt($db));
            
        }
    }

/* Connect to DB
***************************************************************/

    public function connect_to_database($name, $password, $db){

        $this->load->model('modelsetup');
        $query = $this->modelsetup->createdb(decrypt($name), decrypt($db));
        $db_exists = $this->modelsetup->find_db( decrypt($name), decrypt($password), decrypt($name).'_'.decrypt($db) );

        if($query == false){
            if(!$db_exists){
                $this->session->set_flashdata('error', 'You need to manually add your database due to a lack of permission, sorry...');
                redirect('setup/error');
            }
        }

        $db_connected_file = 
"<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['hostname'] The hostname of your database server.
|   ['username'] The username used to connect to the database
|   ['password'] The password used to connect to the database
|   ['database'] The name of the database you want to connect to
|   ['dbdriver'] The database type. ie: mysql.  Currently supported:
                 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|   ['dbprefix'] You can add an optional prefix, which will be added
|                to the table name when using the  Active Record class
|   ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|   ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|   ['cache_on'] TRUE/FALSE - Enables/disables query caching
|   ['cachedir'] The path to the folder where cache files should be stored
|   ['char_set'] The character set used in communicating with the database
|   ['dbcollat'] The character collation used in communicating with the database
|                NOTE: For MySQL and MySQLi databases, this setting is only used
|                as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                (and in table creation queries made with DB Forge).
|                There is an incompatibility in PHP with mysql_real_escape_string() which
|                can make your site vulnerable to SQL injection if you are using a
|                multi-byte character set and are running versions lower than these.
|                Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|   ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|   ['autoinit'] Whether or not to automatically initialize the database.
|   ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                           - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'default';
\$active_record = TRUE;

\$db['default']['hostname'] = 'localhost';
\$db['default']['username'] = '".decrypt($name)."';
\$db['default']['password'] = '".decrypt($password)."';
\$db['default']['database'] = '".decrypt($name).'_'.decrypt($db)."';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */";

        $db_path = 'application/config/database.php';

        if ( ! write_file($db_path, $db_connected_file ) ){
         
        echo 'Unable to set up the database. Please recheck your information and try agian.';
    
        }else{

            unlink('./index.html');

            redirect('setup/master');
        }
    }

    public function master() {
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();
        if($qry !== false){
            $data['quarxInstalled'] = 'installed';
            
            $this->load->model('modelsetup');
            $atomic = $this->modelsetup->is_connected_to('atomic');
            $data['atomic'] = $atomic[0]->option_title;

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
    
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Setup';

        $this->load->view('core/setup/header', $data);
        if($qry === false){
            $this->load->view('core/setup/initial', $data);
        }else{
            $this->load->view('core/setup/installed', $data);
        }
        $this->load->view('core/setup/footer', $data);
    }

    public function complete(){
        if($this->input->post('username') != '' && $this->input->post('username') != 'User name'){
            $data['result'] = $this->quarx_install($this->input->post('username'), $this->input->post('userpassword2'), $this->input->post('advancedAccounts'), $this->input->post('masterAccess'), $this->session->userdata('db_array'));

            $this->session->unset_userdata('db_array');

            $data['uname'] = $this->input->post('username');
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Setup Complete';
            
            //load the view elements
            $this->load->view('core/setup/header', $data);
            $this->load->view('core/setup/complete', $data);
            $this->load->view('core/setup/footer', $data);
        }else{
            redirect('setup');
        }
    }

    public function quarx_install($userName, $userPassword, $advancedAccounts, $masterAccess, $db_array){
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();
        if($qry !== false){
            $data['quarxInstalled'] = 'installed';
        }
    
        if($qry === false){

            if($advancedAccounts === '1'){
                $extras = true;
                $avdaccts = 'advanced accounts';
            }else{
                $extras = false;
                $avdaccts = 'simple accounts';
            }

            if($masterAccess === '1'){
                $extras = true;
                $master = 'master access';
            }else{
                $extras = false;
                $master = 'standard access';
            }

            $current_quarx = file_get_contents(site_url()."quarx.json");
            $current_quarx = json_decode($current_quarx);

            $version = $current_quarx->version;

            $this->load->model('modelsetup');

            // master user
            $table = $this->modelsetup->add_user_table($extras);
            if($table !== false){
                $this->modelsetup->add_master_user($userName, $userPassword);
            }

            // admin options
            $admin = $this->modelsetup->add_admin_table();
            if($admin !== false){
                $this->modelsetup->add_admin_opts($avdaccts, $master, $version, $db_array);
            }

            // image table
            $img_table = $this->modelsetup->add_img_table();

            return "Quarx has been successfully installed.";
        }else{
            return "It seems like you've already installed quarx.";
        }
    }

/* Edit Setup
***************************************************************/

    public function edit(){
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('user_id') == 1){

                $this->load->model('modellogin');
                $qry = $this->modellogin->is_installed();
                if($qry !== false){
                    $data['quarxInstalled'] = 'installed';
                }

                $state = $this->quarxsetup->account_opts();

                if($state[0]->option_title === 'advanced accounts'){
                    $data['accountStatus'] = 'checked="checked"';
                }else{
                    $data['accountStatus'] = '';
                } 

                if($state[1]->option_title === 'master access'){
                    $data['masterAccess'] = 'checked="checked"';
                }else{
                    $data['masterAccess'] = '';
                } 

                $data['uname'] = $this->input->post('username');
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup Edit';
                
                //load the view elements
                $this->load->view('core/setup/header', $data);
                $this->load->view('core/setup/edit', $data);
                $this->load->view('core/setup/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

    public function edit_setup(){
        $this->load->model('modellogin');
        $qry = $this->modellogin->is_installed();
        if($qry !== false){
            $data['quarxInstalled'] = 'installed';
        }

        if($qry !== false){
        // Regarding Advanced Accounts
            $advancedAccounts = $this->input->post('advancedAccounts');

            if($advancedAccounts === '1'){
                $avdaccts = 'advanced accounts';
            }else{
                $avdaccts = 'simple accounts';
            }

            $this->load->model('modelsetup');
            $this->modelsetup->edit_account_config($avdaccts);

        // Regarding Master Access
            $masterAccess = $this->input->post('masterAccess');
            if($masterAccess === '1'){
                $masterAccess = 'master access';
            }else{
                $masterAccess = 'standard access';
            }

            $this->load->model('modelsetup');
            $this->modelsetup->edit_master_access_config($masterAccess);
            
        redirect('setup');
        }else{
            redirect('setup');
        }
    }

/* Quarx Plugins
***************************************************************/
    public function plugins() {   
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('user_id') == 1){

                $this->load->model('modellogin');
                $qry = $this->modellogin->is_installed();
                if($qry !== false){
                    $data['quarxInstalled'] = 'installed';
                }

                $this->load->library('plugin_tools');

                $url  = 'http://ottacon.co/_quarx_/plugin_list.json';
                $plugin_data = file_get_contents($url);
                $plugin_array = json_decode($plugin_data);
                $j = 0;
                foreach ($plugin_array as $ap) {
                    $data['available_plugin'][$j] = $ap;
                    $j++;
                }

                //Check active plugins
                $this->load->model('modelsetup');
                $plugin_qry = $this->modelsetup->installed_plugins();

                if($plugin_qry){
                    if($qry !== false){
                        $i = 0;
                        foreach ($plugin_qry as $plugin) {
                            $data['plugin'][$i] = $plugin;
                            $i++;
                        }
                    }
                }

                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup : Plugins';
                
                //load the view elements
                $this->load->view('core/setup/header', $data);
                $this->load->view('core/setup/plugins', $data);
                $this->load->view('core/setup/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

/* Quarx Update
***************************************************************/
    public function update() {   
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('user_id') == 1){
                $this->load->model('modellogin');
                $qry = $this->modellogin->is_installed();
                if($qry !== false){
                    $data['quarxInstalled'] = 'installed';
                }

                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'Setup : Update';
                
                //load the view elements
                $this->load->view('core/setup/header', $data);
                $this->load->view('core/setup/update', $data);
                $this->load->view('core/setup/footer', $data);
            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

/* Deploy Atomic
***************************************************************/

    public function deploy_atomic(){
        //download the latest atomic build
        $url  = 'http://www.ottacon.co/_quarx_/atomic.latest.zip';
        $path = '../atomic.latest.zip';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        $data = curl_exec($ch);
     
        curl_close($ch);
     
        file_put_contents($path, $data);

        $zip = new ZipArchive;
        
        if ($zip->open($path) === TRUE) {
            $zip->extractTo('../');
            $zip->close();
        } else {
            echo 'failed';
        }

        exec('rm -rf ../atomic.latest.zip');
        redirect('setup/master?av');
    }

/* Connect to Atomic
***************************************************************/

    public function connect_to_atomic() { 
        $this->load->model('modelsetup');
        $db_info = $this->modelsetup->get_db_info();

        $db_file = 
"<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['hostname'] The hostname of your database server.
|   ['username'] The username used to connect to the database
|   ['password'] The password used to connect to the database
|   ['database'] The name of the database you want to connect to
|   ['dbdriver'] The database type. ie: mysql.  Currently supported:
                 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|   ['dbprefix'] You can add an optional prefix, which will be added
|                to the table name when using the  Active Record class
|   ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|   ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|   ['cache_on'] TRUE/FALSE - Enables/disables query caching
|   ['cachedir'] The path to the folder where cache files should be stored
|   ['char_set'] The character set used in communicating with the database
|   ['dbcollat'] The character collation used in communicating with the database
|                NOTE: For MySQL and MySQLi databases, this setting is only used
|                as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                (and in table creation queries made with DB Forge).
|                There is an incompatibility in PHP with mysql_real_escape_string() which
|                can make your site vulnerable to SQL injection if you are using a
|                multi-byte character set and are running versions lower than these.
|                Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|   ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|   ['autoinit'] Whether or not to automatically initialize the database.
|   ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                           - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'default';
\$active_record = TRUE;

\$db['default']['hostname'] = 'localhost';
\$db['default']['username'] = '".$db_info[0]->db_uname."';
\$db['default']['password'] = '".$db_info[0]->db_password."';
\$db['default']['database'] = '".$db_info[0]->db_uname.'_'.$db_info[0]->db_name."';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */";

        unlink('../application/config/database.php');

        $this->load->helper('file');
        
        $path = '../application/config/database.php';

        if ( ! write_file($path, $db_file) ){
             
            redirect('setup/master?e');
        
        }else{

            $auto_path = '../application/config/autoload.php';

            $str = read_file($auto_path);

            $part_1_end_pos = 20+strrpos($str, "libraries'] = array(", 2);
            $part_1 = substr($str, 0, $part_1_end_pos);
            $part_2 = substr($str, $part_1_end_pos);

            $inject = "'database', ";

            $auto_file = $part_1.$inject.$part_2;
            
            if ( ! write_file($auto_path, $auto_file) ){
                redirect('setup/master?e');
            }

            $this->modelsetup->connected_to("atomic");

            redirect('setup/master?s');

        }

    }

    function update_quarx(){
        //replace files with new ones from package on ottacon.co
        $url  = 'http://www.ottacon.co/_quarx_/quarx.latest.zip';
        $path = './update/quarx.latest.zip';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
        $data = curl_exec($ch);
     
        curl_close($ch);

        @mkdir('./update');
     
        file_put_contents($path, $data);

        $zip = new ZipArchive;
        
        if ($zip->open($path) === TRUE) {
            $zip->extractTo('./update');
            $zip->close();
        } else {
            echo 'failed';
        }

        unlink($path);

        $this->load->model('modelsetup');
        $db_info = $this->modelsetup->get_db_info();

        $db_file = 
"<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|   ['hostname'] The hostname of your database server.
|   ['username'] The username used to connect to the database
|   ['password'] The password used to connect to the database
|   ['database'] The name of the database you want to connect to
|   ['dbdriver'] The database type. ie: mysql.  Currently supported:
                 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|   ['dbprefix'] You can add an optional prefix, which will be added
|                to the table name when using the  Active Record class
|   ['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|   ['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|   ['cache_on'] TRUE/FALSE - Enables/disables query caching
|   ['cachedir'] The path to the folder where cache files should be stored
|   ['char_set'] The character set used in communicating with the database
|   ['dbcollat'] The character collation used in communicating with the database
|                NOTE: For MySQL and MySQLi databases, this setting is only used
|                as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|                (and in table creation queries made with DB Forge).
|                There is an incompatibility in PHP with mysql_real_escape_string() which
|                can make your site vulnerable to SQL injection if you are using a
|                multi-byte character set and are running versions lower than these.
|                Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|   ['swap_pre'] A default table prefix that should be swapped with the dbprefix
|   ['autoinit'] Whether or not to automatically initialize the database.
|   ['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|                           - good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

\$active_group = 'default';
\$active_record = TRUE;

\$db['default']['hostname'] = 'localhost';
\$db['default']['username'] = '".$db_info[0]->db_uname."';
\$db['default']['password'] = '".$db_info[0]->db_password."';
\$db['default']['database'] = '".$db_info[0]->db_uname.'_'.$db_info[0]->db_name."';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '';
\$db['default']['pconnect'] = TRUE;
\$db['default']['db_debug'] = TRUE;
\$db['default']['cache_on'] = FALSE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */";

        $this->load->helper('file');
        $update_path = './update/application/config/database.php';

        if ( ! write_file($update_path, $db_file) ){
            redirect('setup/master?e');
        }else{

            $url  = './update/quarx.json';
            $quarx = file_get_contents($url);
            $quarx = json_decode($quarx);

            $this->load->model('modelsetup');
            $qry = $this->modelsetup->update_version($quarx->version);
            if($qry){
                exec('rsync -rtv --exclude "./update" ./update/* ./');
                
                unlink('./index.html');

                exec('rm -rf ./update');
                
                redirect('setup/master?v');
            }
        }

    }

}
/* End of file setup.php */
/* Location: ./application/controllers/ */