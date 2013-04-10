<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Author: Matt Lantz
     
class cloudcatcher extends CI_Controller {

    public function __construct(){
        parent::__construct();
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

        $this->lang->load(config_item('language_abbr'), config_item('language'));
    } 


/* Primary Tools
*****************************************************************/

    public function index(){  
        //Check active plugins
        $this->load->model('modelsetup');

        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'CloudCatcher';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('core/admin/cloudcatcher', $data);
        $this->load->view('common/footer', $data);
    }

    /* Backup Action
    *************************************/
    function backup(){
        $this->load->model('modeladmin');
        $qry = $this->modeladmin->get_db_info();

        if($qry->db_uname > '' && $this->input->post('backup')){

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
    function deletebackup(){
        unlink('backup/'.$_GET['date'].'.zip');
        $goodbye = $this->delete_directory('backup/'.$_GET['date']);

        if($goodbye){
            redirect('admin/cloudcatcher?success');
        }
    }

/* Cloud Catcher Actions
*************************************************************/
    
    /* Full Copy Action
    *************************************/
    function duplicate( $source, $target ) {
        if(!file_exists($target)){
            mkdir($target, 0755);
        }

        if ( is_dir( $source ) ) {
            @mkdir( $target );
            $d = dir( $source );
            while ( FALSE !== ( $entry = $d->read() ) ) {
                if ( $entry == '.' || $entry == '..' ) {
                    continue;
                }
                $Entry = $source . '/' . $entry; 
                if ( is_dir( $Entry ) && $entry != 'backup' ) {
                    $this->duplicate( $Entry, $target . '/' . $entry );
                    continue;
                }
                    if($entry != 'backup'){
                        copy( $Entry, $target . '/' . $entry );
                    }
            }   
     
            $d->close();
        }else {
            copy( $source, $target );
        }
    }

    /* Backup Model
    *************************************/
    
    /* backup the db OR just a table */
    function backup_models($host,$user,$pass,$name,$target,$tables = '*'){
        $link = mysql_connect($host,$user,$pass);
        mysql_select_db($name,$link);
        $ret = '';
        //get all of the tables
        if($tables == '*'){
            $tables = array();
            $result = mysql_query('SHOW TABLES');
            while($row = mysql_fetch_row($result)){
                $tables[] = $row[0];
            }
        }else{
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }
      
        //cycle through
        foreach($tables as $table){
            $result = mysql_query('SELECT * FROM '.$table);
            $num_fields = mysql_num_fields($result);
            
            $ret.= 'DROP TABLE '.$table.';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
            $ret.= "\n\n".$row2[1].";\n\n";
        
            for ($i = 0; $i < $num_fields; $i++){
                while($row = mysql_fetch_row($result)){
                    $ret.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $ret.= '"'.$row[$j].'"' ; } else { $ret.= '""'; }
                        if ($j<($num_fields-1)) { $ret.= ','; }
                    }
                    $ret.= ");\n";
                }
            }
            
            $ret.="\n\n\n";
        }
      
        //save file
        $filename = $target.'/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
      
        $handle = fopen($filename,'w+');
        fwrite($handle,$ret);
        fclose($handle);   
    }

    /* Zip the backup
    *************************************/
    function zip_backup($source, $destination){
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
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

    function delete_directory($dirname) {
        if (is_dir($dirname)){
            $dir_handle = opendir($dirname);
        }
        if (!$dir_handle){
            return false;
        }
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file)){
                    unlink($dirname."/".$file);
                }else{
                    $this->delete_directory($dirname.'/'.$file);    
                }
            }
        }
        
        closedir($dir_handle);
        rmdir($dirname);
        
        return true;
    }

}
/* End of file admin.php */
/* Location: ./application/controllers/admin/ */