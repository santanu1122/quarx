<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
     
class install extends CI_Controller {

/* General Tools
***************************************************************/

    public function unPackAndDeliver($path, $dir, $type) {
        $zip = new ZipArchive;
        $zipfile = $zip->open($path);

         if($zipfile === true){

            $zip->extractTo('plugins/'.$dir.'/');
            $zip->close();

            // delete the zip
            unlink($path);

            //mmake the directory of views
            mkdir('application/views/'.$dir, 0755);
            mkdir('../application/views/'.$dir, 0755);

            /* copy the views
            ***************************************************************/

            // create an array to hold directory list
            $results = array();
            $handler = opendir('plugins/'.$dir.'/'.$dir);

            // open directory and walk through the filenames
            while ($file = readdir($handler)) {
                // if file isn't this directory or its parent, add it to the results
                if ($file != "." && $file != ".."){
                    //only grab the non-hidden files
                    if(substr($file, 0, 1) != '.'){
                        $results[] = $file;
                    }
                }
            }

            // tidy up: close the handler
            closedir($handler);

            // done!
            foreach ($results as $xfile) {
                copy('plugins/'.$dir.'/'.$dir.'/'.$xfile, 'application/views/'.$dir.'/'.$xfile);
                unlink('plugins/'.$dir.'/'.$dir.'/'.$xfile);
            }

            /* copy the atomic views
            ***************************************************************/

            if(!$type){
                // create an array to hold directory list
                $results = array();
                $handler = opendir('plugins/'.$dir.'/atomic/'.$dir);

                // open directory and walk through the filenames
                while ($file = readdir($handler)) {
                    // if file isn't this directory or its parent, add it to the results
                    if ($file != "." && $file != ".."){
                        //only grab the non-hidden files
                        if(substr($file, 0, 1) != '.'){
                            $results[] = $file;
                        }
                    }
                }

                // tidy up: close the handler
                closedir($handler);

                // done!
                foreach ($results as $xfile) {
                    copy('plugins/'.$dir.'/atomic/'.$dir.'/'.$xfile, '../application/views/'.$dir.'/'.$xfile);
                    unlink('plugins/'.$dir.'/atomic/'.$dir.'/'.$xfile);
                }
            }

            /* copy model and controller
            ***************************************************************/
            
            //copy over the model
            $old_model = 'plugins/'.$dir.'/model'.$dir.'.php';
            $new_model = 'application/models/model'.$dir.'.php';
            copy($old_model, $new_model) or die("Unable to copy $old to $new."); 
            unlink($old_model);

            if(!$type){
                //copy over the atomic controller
                $old_atomic_model = 'plugins/'.$dir.'/atomic/model'.$dir.'.php';
                $new_atomic_model = '../application/models/model'.$dir.'.php';
                copy($old_atomic_model, $new_atomic_model) or die("Unable to copy $old to $new."); 
                unlink($old_atomic_model);
            }

            //copy over the controller
            $old_controller = 'plugins/'.$dir.'/'.$dir.'.php';
            $new_controller = 'application/controllers/'.$dir.'.php';
            copy($old_controller, $new_controller) or die("Unable to copy $old to $new.");            
            unlink($old_controller);

            if(!$type){
                //copy over the atomic controller
                $old_atomic_controller = 'plugins/'.$dir.'/atomic/'.$dir.'.php';
                $new_atomic_controller = '../application/controllers/'.$dir.'.php';
                copy($old_atomic_controller, $new_atomic_controller) or die("Unable to copy $old to $new.");            
                unlink($old_atomic_controller);
            }

            /* clean up
            ***************************************************************/

            function rmdir_recursive($dir) {
                foreach(scandir($dir) as $file) {
                    if ('.' === $file || '..' === $file) continue;
                    if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
                    else unlink("$dir/$file");
                }
                rmdir($dir);
            }

            rmdir_recursive('plugins/'.$dir);

            /* run the plugins install script
            ***************************************************************/
            if(!$type){
                redirect($dir.'/install');
            }else{
                return true;
            }
        }
    }

    public function success($path, $dir){
        redirect('setup/plugins');
    }

/* Members Installer
***************************************************************/

    public function members() {
        $this->load->model('modelsetup');
        $pluginChecker = $this->modelsetup->add_plugin_tables();
        
        if($pluginChecker === false){
            $qry = $this->modelsetup->install_members();
            if($qry !== false){
                redirect('setup/plugins?i');
            }
        }else{
            redirect('setup/plugins?e');
        } 
    }

/* Plugin Installer
***************************************************************/

    public function plugin($type, $id) {
        $this->load->model('modelsetup');
        $pluginChecker = $this->modelsetup->add_plugin_tables();

        $url  = 'http://ottacon.co/_quarx_/plugin_list.json';
        $plugin_data = file_get_contents($url);
        $plugin_array = json_decode($plugin_data);

        foreach ($plugin_array as $ap) {
            if($type == $ap->plugin_name && $id == $ap->id){
                $plugin_data = $ap;
            }
        }

        if($pluginChecker === false){
            $this->load->helper('file');

            $url = $plugin_data->plugin_location;
            $data = file_get_contents($url);

            $path = 'plugins/'.$type.'.zip';

            if ( ! write_file($path, $data) ){
                 echo 'Unable to write the file';
            }else{
                $this->unPackAndDeliver($path, $type);
            }
        }else{
            redirect('setup/plugins?e');
        } 
    }

/* Plugin Updater
***************************************************************/

    public function update($type, $id){
        $this->load->model('modelsetup');

        $url  = 'http://ottacon.co/_quarx_/plugin_list.json';
        $plugin_data = file_get_contents($url);
        $plugin_array = json_decode($plugin_data);

        foreach ($plugin_array as $ap) {
            if($type == $ap->plugin_name && $id == $ap->id){
                $plugin_data = $ap;
            }
        }

        $this->load->helper('file');

        $url = $plugin_data->plugin_location;
        $data = file_get_contents($url);

        $path = 'plugins/'.$type.'.zip';

        if ( ! write_file($path, $data) ){
             redirect('setup/plugins?eu');
        }else{
            $update = $this->unPackAndDeliver($path, $type, 'update');
            if($update){
                $this->modelsetup->update_plugin($type, $plugin_data->version);
                redirect('setup/plugins?us');
            }
        }
    }

/* Plugin Modifiers
***************************************************************/

    public function disable($plugin){
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->disable_plugin($plugin);

        if($qry){
            redirect('setup/plugins');
        }
    }

    public function enable($plugin){
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->enable_plugin($plugin);

        if($qry){
            redirect('setup/plugins');
        }
    }

/* Plugin Uninstaller
***************************************************************/
    public function uninstall($plugin) {
        $this->load->model('modelsetup');
        $qry = $this->modelsetup->remove_plugin_table($plugin);

        if($qry){
            // create an array to hold directory list
            $results = array();
            $handler = opendir('application/views/'.$plugin);

            // open directory and walk through the filenames
            while ($file = readdir($handler)) {
                // if file isn't this directory or its parent, add it to the results
                if ($file != "." && $file != ".."){
                    //only grab the non-hidden files
                    if(substr($file, 0, 1) != '.'){
                        $results[] = $file;
                    }
                }
            }
            // tidy up: close the handler
            closedir($handler);

            // done!
            foreach ($results as $xfile) {
                unlink('application/views/'.$plugin.'/'.$xfile);
            }

            //remove the directory of the plugin view
            rmdir('application/views/'.$plugin);

            //delete the model
            unlink('application/models/model'.$plugin.'.php');

            //delete the controller
            unlink('application/controllers/'.$plugin.'.php');

            redirect('setup/plugins?u');
        }
    }


}
/* End of file install.php */
/* Location: ./application/controllers/ */