<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    // Author: Matt Lantz
     
class admin extends CI_Controller {

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
        if($this->session->userdata('logged_in')){    
                redirect('admin/manual');
        }else{
            redirect('login/error');
        }
    }

    public function manual() {
        if($this->session->userdata('logged_in')){ 
            $this->output->cache(2);
            //Check active plugins
            $this->load->model('modelsetup');
            $this->load->library('quarx_manual');

            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'Manual';
            
            //load the view elements
            $this->load->view('common/header', $data);
            $this->load->view('common/mainmenu', $data);
            $this->load->view('core/admin/manual', $data);
            $this->load->view('common/footer', $data);
        }else{
            redirect('login/error');
        }
    }
    
    public function cloudinfo() {
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                //Check active plugins
                $this->load->model('modelsetup');
                
                $this->load->library('checker');

                //configured the data to be transported to the view
                $data['root'] = base_url();
                $data['pageRoot'] = base_url().'index.php';
                $data['pagetitle'] = 'CloudInfo';
                $data['sub_menu_title'] = 'CloudInfo';
                
                //load the view elements
                $this->load->view('common/header', $data);
                $this->load->view('common/mainmenu', $data);
                $this->load->view('core/admin/cloudinfo', $data);
                $this->load->view('common/footer', $data);

            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

    public function cloudmail($state) {           
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                //Check active plugins
                $this->load->model('modelsetup');
                
                if($state === 'success'){
                    //configured the data to be transported to the view
                    $data['root'] = base_url();
                    $data['pageRoot'] = base_url().'index.php';
                    $data['pagetitle'] = 'CloudMail';
                    $data['sub_menu_title'] = 'CloudMail';
                    
                    //load the view elements
                    $this->load->view('common/header', $data);
                    $this->load->view('common/mainmenu', $data);
                    $this->load->view('core/admin/cloudmail_success', $data);
                    $this->load->view('common/footer', $data);
                }else{
                    $this->load->model('modelaccounts');
                    $data['account'] = $this->modelaccounts->all_profiles_unlimited();
                    
                    //configured the data to be transported to the view
                    $data['root'] = base_url();
                    $data['pageRoot'] = base_url().'index.php';
                    $data['pagetitle'] = 'CloudMail';
                    $data['sub_menu_title'] = 'CloudMail';
                    
                    //load the view elements
                    $this->load->view('common/header', $data);
                    $this->load->view('common/mainmenu', $data);
                    $this->load->view('core/admin/cloudmail', $data);
                    $this->load->view('common/footer', $data);
                }

            }else{
                redirect('accounts/insufficient');
            }
        }else{
            redirect('login/error');
        }
    }

    public function cloudcatcher($action) {
        
    /* Default
    *************************************/
        if(!$action){
            //Check active plugins
            $this->load->model('modelsetup');

            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'CloudCatcher';
            $data['sub_menu_title'] = 'CloudCatcher';
            
            //load the view elements
            $this->load->view('common/header', $data);
            $this->load->view('common/mainmenu', $data);
            $this->load->view('core/admin/cloudcatcher', $data);
            $this->load->view('common/footer', $data);
        }
    
    /* Backup iFrame
    *************************************/
        if($action == 'backuptool'){
            //Check active plugins
            $this->load->model('modelsetup');
            
            //configured the data to be transported to the view
            $data['root'] = base_url();
            $data['pageRoot'] = base_url().'index.php';
            $data['pagetitle'] = 'CloudCatcher';
            $data['sub_menu_title'] = 'CloudCatcher';
            
            //load the view elements
            $this->load->view('core/admin/cloudcatcher/ccatcher', $data);
        }

    /* Backup Action
    *************************************/
        if($action == 'backup'){
            $this->load->model('modeladmin');
            $qry = $this->modeladmin->get_db_info();

            if($qry){

                // echo '<div style="width: 100%;"><p style="text-align: center; font-family: Arial;">Loading</p></div>';   

                $date = date('m-d-y');
                $server = 'localhost';
                $db_uame = $qry['db_uname'];
                $db_upass = $qry['db_upass'];
                $db_name = $qry['db_name'];
            
                $source = './';
                $target = 'backup/'.$date;
                
                $this->duplicate($source, $target);
                
                $this->backup_models($server, $username, $password, $database, $target);
                
                $this->zip_backup($target, $target.'.zip');

                redirect('admin/cloudcatcher/backuptool?download');
            }
        }

        if($action == 'deletebackup'){
            unlink('backup/'.$_GET['date'].'.zip');
            $goodbye = $this->delete_directory('backup/'.$_GET['date']);

            if($goodbye){
                redirect('admin/cloudcatcher/backuptool?success');
            }
        }
    }   

    public function about() {
        //configured the data to be transported to the view
        $data['root'] = base_url();
        $data['pageRoot'] = base_url().'index.php';
        $data['pagetitle'] = 'Admin: About';
        $data['sub_menu_title'] = 'Admin: About';
        
        //load the view elements
        $this->load->view('common/header', $data);
        $this->load->view('common/mainmenu', $data);
        $this->load->view('core/admin/about', $data);
        $this->load->view('common/footer', $data);
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
            
            $return.= 'DROP TABLE '.$table.';';
            $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
        
            for ($i = 0; $i < $num_fields; $i++){
                while($row = mysql_fetch_row($result)){
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }
                    $return.= ");\n";
                }
            }
            
            $return.="\n\n\n";
        }
      
        //save file
        $filename = $target.'/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql';
      
        $handle = fopen($filename,'w+');
        fwrite($handle,$return);
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

/* Email
*************************************************************/
    
    public function email() {
        if($this->session->userdata('logged_in')){ 
            if($this->session->userdata('permission') == 1){
                $to = $_POST['to'];
                $from = 'do-not-reply';
                $subject = $_POST['subject'];
                $message = $_POST['message'];
                
                //load the email base class
                $this->load->library('email');

                $config['charset'] = 'utf-8';
                $config['protocol'] = 'sendmail';
                $config['mailtype'] = 'html';
                $config['wordwrap'] = TRUE;

                $this->email->initialize($config);
                
                //set the who, and from
                $this->email->from($from, $name);
                $this->email->to($to);
                //$this->email->cc('another@another-example.com');
                //$this->email->bcc('them@their-example.com');
            
                //set the subject, message, attachments etc.
                $this->email->subject($subject);
                $this->email->message($message);
                
                    /*foreach($attachment as $attach) :
                    
                        $this->email->attach($attach);
                
                    endforeach;*/
                
                //rocket that email into cyber space
                $this->email->send();
                
                //set the variable of the errors
                $data['email_errors'] = $this->email->print_debugger(); 
                
                //load the success viewer
                redirect('admin/cloudmail/success');
            }
        }
    }

}
/* End of file admin.php */
/* Location: ./application/controllers/ */