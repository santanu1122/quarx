<?php

/*
    Filename:   model_users_settings.php
    Location:   /application/models/
*/

class model_users_settings extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
/* Update Settings
***************************************************************/

    function update_settings(){
        if( $this->input->post('autoAuth') == 1 ){ $aa = 1; }else{ $aa = 0; }
        if( $this->input->post('pubProfile') == 1 ){ $pp = 1; }else{ $pp = 0; }

        $sql = "UPDATE atomic_user_settings SET `setting_state` = ".$aa." WHERE setting_name = 'auto_auth'";
        $qry = $this->db->query($sql);

        $sql2 = "UPDATE atomic_user_settings SET `setting_state` = ".$pp." WHERE setting_name = 'pub_profile'";
        $qry2 = $this->db->query($sql2);

        if($qry && $qry2){
            return true;
        }else{
            return false;
        }
    }

/* Gets
***************************************************************/

    function get_settings(){
        $sql = "SELECT * FROM atomic_user_settings";
        $qry = $this->db->query($sql);

        if($qry){
            return $qry->result();
        }else{
            return false;
        }
    }

}
// End of File
?>