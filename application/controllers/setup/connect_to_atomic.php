<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class connect_to_atomic extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->is_installed();

        if(!$qry){
            redirect('setup/install');
        }
    }

/* Connect to Atomic
***************************************************************/

    public function index() { 
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
| The \$active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The \$active_record variables lets you determine whether or not to load
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
\$db['default']['db_debug'] = FALSE;
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

}
/* End of file setup.php */
/* Location: ./application/controllers/ */