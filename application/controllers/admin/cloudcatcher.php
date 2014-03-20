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

class Cloudcatcher extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('logged_in'))
        {
            redirect('error/login'); // Denied!
        }

        if ($this->session->userdata('permission') > 1)
        {
            $this->session->set_flashdata('error', 'You do not have sufficient permission to access this');
            redirect('error');
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    }

    public function index()
    {
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'CloudCatcher';

        $this->load->view('common/header', $data);
        $this->load->view('core/admin/cloudcatcher', $data);
        $this->load->view('common/footer', $data);
    }

    public function backup()
    {
        $this->load->model('model_admin');
        $qry = $this->model_admin->get_db_info();

        $db_info = json_decode($qry->option_data);

        ini_set('memory_limit','128M');

        if ($db_info[0] > '' && $this->input->post('backup'))
        {
            $date = date('m-d-y');
            $server = 'localhost';
            $db_uame = $db_info[0];
            $db_upass = $db_info[1];
            $db_name = $db_info[2];

            $source = './';

            chmod('backup', 0777);

            $target = 'backup/'.$date;

            $this->duplicate($source, $target);

            $this->backup_models($server, $db_uame, $db_upass, $db_name, $target);

            $this->zip_backup($target, $target.'.zip');

            echo 1;
        }
        else
        {
            echo "huh";
        }
    }

    /* Delete Backup Action
    *************************************/
    public function deletebackup()
    {
        unlink('backup/'.$_GET['date'].'.zip');
        $goodbye = $this->delete_directory('backup/'.$_GET['date']);

        if ($goodbye)
        {
            redirect('admin/cloudcatcher?success');
        }
    }

/* Cloud Catcher Actions
*************************************************************/

    /* Full Copy Action
    *************************************/
    private function duplicate( $source, $target )
    {
        if(!file_exists($target))
        {
            mkdir($target, 0755);
        }

        if ( is_dir( $source ) )
        {
            @mkdir( $target );
            $d = dir( $source );
            while( FALSE !== ($entry = $d->read()) )
            {
                if( $entry == '.' || $entry == '..' )
                {
                    continue;
                }

                $mainEntry = $source . '/' . $entry;

                if ( is_dir( $mainEntry ) && $entry != 'backup' && $entry != 'db' )
                {
                    $this->duplicate( $mainEntry, $target . '/' . $entry );
                    continue;
                }

                if($entry != 'backup' && $entry != 'db')
                {
                    copy( $mainEntry, $target . '/' . $entry );
                }
            }

            $d->close();
        }
        else
        {
            copy( $source, $target );
        }
    }

    /* Backup Model
    *************************************/
    private function backup_models($host, $user, $pass, $name, $target, $tables = '*')
    {
        if ($user == "sqlite" && $pass == "pdo")
        {
            return $this->backup_sqlite($name, $target);
        }

        $ret = '';

        if($tables == '*')
        {
            $tables = array();
            $r = $this->db->query('SHOW TABLES');
            $result = $r->result_array();
            $identifier = 'Tables_in_'.$name;
            $n = 0;

            foreach ($result as $row)
            {
                $tables[$n] = $row[$identifier];
                $n++;
            }
        }
        else
        {
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        foreach ($tables as $table)
        {
            $r = $this->db->query('SELECT * FROM '.$table);
            $result = $r->result();
            $num_fields = $r->num_fields();

            $ret.= 'DROP TABLE '.$table.';';

            foreach ($result as $row)
            {
                $ret.= 'INSERT INTO '.$table.' VALUES(';

                for($j=0; $j < $num_fields; $j++)
                {
                    $vars = new ReflectionObject($row);
                    $res = $vars->getProperties();
                    $resName = $res[$j]->name;

                    if ( isset( $row->$resName ) )
                    {
                        $ret.= '"'.str_replace("\n","\\n", addslashes( $row->$resName )).'"' ;
                    }
                    else
                    {
                        $ret.= '""';
                    }
                    if ($j < ($num_fields-1)) { $ret.= ','; }
                }

                $ret.= ");\n";
            }

            $ret.="\n\n\n";
        }

        $filename = $target.'/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';

        $handle = fopen($filename,'w+');
        fwrite($handle,$ret);
        fclose($handle);
    }

    /* Zip the backup
    *************************************/
    private function zip_backup($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();

        if (!$zip->open($destination, ZIPARCHIVE::CREATE))
        {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true)
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file)
            {
                $file = str_replace('\\', '/', realpath($file));

                if (is_dir($file) === true)
                {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                }
                else if (is_file($file) === true)
                {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        }
        else if (is_file($source) === true)
        {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    /* Delete the backup folder and zip
    *************************************/

    private function delete_directory($dirname)
    {
        if (is_dir($dirname))
        {
            $dir_handle = opendir($dirname);
        }

        if (!$dir_handle)
        {
            return false;
        }

        while($file = readdir($dir_handle))
        {
            if ($file != "." && $file != "..")
            {
                if (!is_dir($dirname."/".$file))
                {
                    unlink($dirname."/".$file);
                }
                else
                {
                    $this->delete_directory($dirname.'/'.$file);
                }
            }
        }

        closedir($dir_handle);
        rmdir($dirname);

        return true;
    }

    private function backup_sqlite($db, $target)
    {
        $db_file = str_replace("sqlite:", "", $db);
        $db_copy = "sqlite-backup-".time().'.sqlite';

        if ( ! copy($db_file, $target.'/'.$db_copy)) return false;
        return true;
    }

}
/* End of file Cloudcatcher.php */
/* Location: ./application/controllers/admin/ */