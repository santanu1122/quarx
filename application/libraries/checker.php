<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */ 

class checker {
    
    public function checker()
    {
        function foldersize($path) 
        {
            $total_size = 0;
            $files = scandir($path);
            $cleanPath = rtrim($path, '/'). '/';
        
            foreach($files as $t) {
                if ($t<>"." && $t<>"..") {
                    $currentFile = $cleanPath . $t;
                    if (is_dir($currentFile)) {
                        $size = foldersize($currentFile);
                        $total_size += $size;
                    }
                    else {
                        $size = filesize($currentFile);
                        $total_size += $size;
                    }
                }   
            }
        
            return $total_size;
        }
    
        function format_size($size)
        {
            $mod = 1024;
            for ($i = 0; $size > $mod; $i++) {
                $size /= $mod;
            }
            
            $units = explode(' ','B KB MB GB TB PB');
            $endIndex = strpos($size, ".")+2;
        
            return substr( $size, 0, $endIndex).' '.$units[$i];
        }
        
    }
}
//End of File
?>