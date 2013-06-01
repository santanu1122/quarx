<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular CMS built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://quarx.ottacon.co
 * @since       Version 1.0
 * 
 */
     
class cloudcatcher extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->userdata('logged_in'))
        {
            redirect('login/error');
        }

        if($this->session->userdata('permission') > 1)
        {
            $setup = $this->quarxsetup->account_opts();

            if($setup[2]->option_title === 'master access')
            {
                redirect('accounts/permission');
            }
        }

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index()
    {  
        $this->load->model('modelsetup');

        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'CloudCatcher';
        
        $this->load->view('common/header', $data);
        $this->load->view('core/admin/cloudcatcher', $data);
        $this->load->view('common/footer', $data);
    }

    /* Backup Action
    *************************************/
    function backup()
    {
        $this->load->model('modeladmin');
        $qry = $this->modeladmin->get_db_info();

        if($qry->db_uname > '' && $this->input->post('backup'))
        {

            $date = date('m-d-y');
            $server = 'localhost';
            $db_uame = $qry->db_uname;
            $db_upass = $qry->db_password;
            $db_name = $qry->db_uname.'_'.$qry->db_name;
        
            $source = './';
            $target = 'backup/'.$date;

            $this->duplicate($source, $target);
            
            $this->backup_models($server, $db_uame, $db_upass, $db_name, $target);
            
            $this->zip_backup($target, $target.'.zip');

            echo 1;
        }
    }

    /* Delete Backup Action
    *************************************/
    function deletebackup()
    {
        unlink('backup/'.$_GET['date'].'.zip');
        $goodbye = $this->delete_directory('backup/'.$_GET['date']);

        if($goodbye)
        {
            redirect('admin/cloudcatcher?success');
        }
    }

/* Cloud Catcher Actions
*************************************************************/
    
    /* Full Copy Action
    *************************************/
    function duplicate( $source, $target ) 
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

                $Entry = $source . '/' . $entry; 
                
                if ( is_dir( $Entry ) && $entry != 'backup' ) 
                {
                    $this->duplicate( $Entry, $target . '/' . $entry );
                    continue;
                }
                
                if($entry != 'backup')
                {
                    copy( $Entry, $target . '/' . $entry );
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
    function backup_models($host, $user, $pass, $name, $target, $tables = '*')
    {
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
      
        foreach($tables as $table)
        {
            
            $r = $this->db->query('SELECT * FROM '.$table);
            $result = $r->result();
            $num_fields = $r->num_fields();
            
            $ret.= 'DROP TABLE '.$table.';';
            
            $r2 = $this->db->query('SHOW CREATE TABLE '.$table);
            $row2 = $r2->num_fields();

            $ret.= "\n\n".$row2[1].";\n\n";
        
            for ($i = 0; $i < $num_fields; $i++)
            {  
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
                            $ret.= '"'.ereg_replace("\n","\\n", addslashes( $row->$resName )).'"' ; 
                        }
                        else 
                        { 
                            $ret.= '""'; 
                        }
                        if ($j < ($num_fields-1)) { $ret.= ','; }
                    }

                    $ret.= ");\n";
                }
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
    function zip_backup($source, $destination)
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

    function delete_directory($dirname)
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

}
/* End of file cloudcatcher.php */
/* Location: ./application/controllers/admin/ */