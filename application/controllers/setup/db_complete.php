<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class db_complete extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if($qry){
            redirect('login');
        }
    }

/* Initial Setup and Install
***************************************************************/

    public function index() {
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
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$active_record variables lets you determine whether or not to load
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
\$db['default']['cache_on'] = TRUE;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
\$db['default']['swap_pre'] = '';
\$db['default']['autoinit'] = TRUE;
\$db['default']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */";

        $this->load->model('modelsetup');

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

                redirect("setup/connect_to_database/now/".encrypt($name)."/".encrypt($password)."/".encrypt($db));
            
        }
    }

}
/* End of file db_complete.php */
/* Location: ./application/controllers/setup */