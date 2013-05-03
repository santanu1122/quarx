<?php
/*
    Filename:   modelaccounts.php
    Location:   /application/models/
    Author:     Matt Lantz
*/

class modelaccounts extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
//grab all the data for the current user account
    function my_account() {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id='.$this->session->userdata('user_id'));
        if($qry) {
            return $qry->result();
        }
    }

//username checker extrordinary
    function unc_validate($name) {
        $this->db->where('user_name', mysql_real_escape_string($name));
        $query = $this->db->get('users');
        if($query->num_rows == 1){
            return 1;
        }else{
            return 0;
        }
    }
    
//grab all the data for this account
    function this_account($id) {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id='.$id);        
        if($qry){
            return $qry->result();
        }
    }
    
//simple task of updating the master profile based on the new inputs
    function profile_update($img, $opts){
        if($opts[0]->option_title === 'advanced accounts'){
            $optional = "
                `address` = '".mysql_real_escape_string($_POST['address'])."',
                `city` = '".mysql_real_escape_string($_POST['city'])."',
                `state` = '".mysql_real_escape_string($_POST['state_prov'])."',
                `country` = '".mysql_real_escape_string($_POST['country'])."',
                `phone` = '".mysql_real_escape_string($_POST['phone'])."',
                `fax` = '".mysql_real_escape_string($_POST['fax'])."',
                `website` = '".mysql_real_escape_string($_POST['website'])."',
                `company` = '".mysql_real_escape_string($_POST['company'])."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".mysql_real_escape_string($_POST['email'])."',
                    `full_name` = '".mysql_real_escape_string($_POST['full_name'])."',
                    `location` = '".mysql_real_escape_string($_POST['location'])."',
                    ".$optional."
                    `lat` = '".mysql_real_escape_string($_POST['latitude'])."',
                    `lng` = '".mysql_real_escape_string($_POST['longitude'])."',
                    `img` = '".$img."'
                WHERE 
                    user_id=".$this->session->userdata('user_id');
                    
        $qry = mysql_query($sql);
        
        if($qry){
            $this->session->set_userdata('email', $_POST['email']);
            return true;
        }
    }
    
//add a new user 
    function profile_adder($img, $opts) {
        $permission = 2;
        
        $rand = rand(10000001,99999999);
        
        $password = sha1($rand);

            if($opts[0]->option_title === 'advanced accounts'){
                $optional_inserts = "address, city, state, country, phone, fax, website, company, ";

                $optional_vals = "
                    '".mysql_real_escape_string($_POST['address'])."',
                    '".mysql_real_escape_string($_POST['city'])."',
                    '".mysql_real_escape_string($_POST['state_prov'])."',
                    '".mysql_real_escape_string($_POST['country'])."',
                    '".mysql_real_escape_string($_POST['phone'])."',
                    '".mysql_real_escape_string($_POST['fax'])."',
                    '".mysql_real_escape_string($_POST['website'])."',
                    '".mysql_real_escape_string($_POST['company'])."',";
            }

        //Just to make sure we have a reason to add stuff to the db!
        if(mysql_real_escape_string($_POST['user_name']) > ''){
        
            $sql = "INSERT INTO 
                    users(user_name, user_email, user_pass, owner, permission, status, ".$optional_inserts."lat, lng, location, full_name, user_state, img) 
                VALUES( '".mysql_real_escape_string($_POST['user_name'])."', 
                        '".mysql_real_escape_string($_POST['user_email'])."',
                        '".mysql_real_escape_string($password)."',
                        '".$this->session->userdata('user_id')."',
                        '".$permission."',
                        'authorized',
                        ".$optional_vals."
                        '".mysql_real_escape_string($_POST['latitude'])."',
                        '".mysql_real_escape_string($_POST['longitude'])."',
                        '".mysql_real_escape_string($_POST['location'])."',
                        '".mysql_real_escape_string($_POST['full_name'])."',
                        'enabled',
                        '".mysql_real_escape_string($img)."'
                        )";
            $qry = mysql_query($sql);
        
        }

        if($qry){
            return $rand;
        }
    }
    
//the main function to pull in all the users and thier profiles
    function account_manager() {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission = 2');      
        if($qry){
            return $qry->result();
        }
    }
    
//Just tp verify that there are no others
    function username_checker() {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name = "'.$_POST['user_name'].'"');       
        if($qry){
            return $qry->result();
        }
    }
    
//drop it like its hot!
    function profile_deleter($id) {
        $qry = $this->db->query('DELETE FROM users WHERE user_id ='.$id.' AND permission > 0');     
        
        if($qry){
            return true;
        }
    }
    
//Simple search name function
    function search_accounts($term) {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$term.'%" AND user_id != 1 ORDER BY full_name ASC');      
        if($qry){
            return $qry->result();
        }
    }
    
//Better search function
    function search_accounts_full($term, $offset=null, $limit=null){
        if($offset == null){ 
            $offset = 0; 
        }
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$term.'%" AND user_id != 1
                                || full_name LIKE "%'.$term.'%" AND user_id != 1
                                || user_email LIKE "%'.$term.'%" AND user_id != 1
                                || location LIKE "%'.$term.'%" AND user_id != 1
                                 ORDER BY full_name DESC LIMIT '.$offset.', '.$limit);     
        if($qry){
            return $qry->result();
        }
    }
    
//Search DB totals
    function full_search_totals($name){
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_name LIKE "%'.$name.'%" AND user_id != 1
                                || full_name LIKE "%'.$name.'%" AND user_id != 1
                                || user_email LIKE "%'.$name.'%" AND user_id != 1
                                || location LIKE "%'.$name.'%" AND user_id != 1
                                 ORDER BY full_name DESC');        
        if($qry){
            return count($qry->result());
        }
    }
    
//Just tp verify that there are no others
    function editor($id) {
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$id);      
        if($qry){
            return $qry->result();
        }
    }
    
//Edit this profile
    function this_profile_update($img, $id, $opts) {
        if($opts[0]->option_title === 'advanced accounts'){
            $optional = "
                `address` = '".mysql_real_escape_string($_POST['address'])."',
                `city` = '".mysql_real_escape_string($_POST['city'])."',
                `state` = '".mysql_real_escape_string($_POST['state_prov'])."',
                `country` = '".mysql_real_escape_string($_POST['country'])."',
                `phone` = '".mysql_real_escape_string($_POST['phone'])."',
                `fax` = '".mysql_real_escape_string($_POST['fax'])."',
                `website` = '".mysql_real_escape_string($_POST['website'])."',
                `company` = '".mysql_real_escape_string($_POST['company'])."',";
        }

        $sql = "UPDATE 
                    users 
                SET 
                    `user_email` = '".mysql_real_escape_string($_POST['user_email'])."',
                    `full_name` = '".mysql_real_escape_string($_POST['full_name'])."',
                    ".$optional."
                    `location` = '".mysql_real_escape_string($_POST['location'])."',
                    `lat` = '".mysql_real_escape_string($_POST['latitude'])."',
                    `lng` = '".mysql_real_escape_string($_POST['longitude'])."',
                    `img` = '".mysql_real_escape_string($img)."'
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }

//Authorize the user
    function authorize_user($id) {

        $sql = "UPDATE 
                    users 
                SET 
                    `status` = 'authorized'
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }

//Enable the user
    function enable_user($id) {

        $sql = "UPDATE 
                    users 
                SET 
                    `user_state` = 'enabled'
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }


//Make a user into master status
    function master_user_upgrade($id) {

        $sql = "UPDATE 
                    users 
                SET 
                    `permission` = 1,
                    `owner` = ".$this->session->userdata('user_id')."
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }

//Make a user into master status
    function master_user_downgrade($id) {

        $sql = "UPDATE 
                    users 
                SET 
                    `permission` = 2,
                    `owner` = 0
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }

//Disable the user
    function disable_user($id) {

        $sql = "UPDATE 
                    users 
                SET 
                    `user_state` = 'disabled'
                WHERE 
                    user_id =".$id;
                    
        $qry = mysql_query($sql);
        
        if($qry){
            return true;
        }
    }

/* GETS
***************************************************************/
    
//grab an account name for the account_tools library
    function get_a_name($id){
        $qry = $this->db->query('SELECT * FROM `users` WHERE user_id = '.$id.' ORDER BY user_name ASC LIMIT 1');
        if($qry){
            return $qry->result();
        }
    }

//collect all the user data we have
    function all_profiles($offset=null, $limit=null) {
        if($offset == null){ $offset = 0; }
        if($this->session->userdata('owner') == 0){
            $qry = $this->db->query('   SELECT * 
                                        FROM `users` 
                                        WHERE permission >= 1
                                        AND permission < 50
                                        AND user_id != 1
                                        ORDER BY user_name ASC LIMIT '.$offset.', '.$limit);
        }else{
            $qry = $this->db->query('   SELECT * 
                                        FROM `users` 
                                        WHERE permission > 1 
                                        AND permission < 50
                                        OR owner = '.$this->session->userdata('user_id').' 
                                        ORDER BY user_name ASC LIMIT '.$offset.', '.$limit);
        }

        if($qry){
            return $qry->result();
        }
    }
    
//collect all the sub users
    function all_profiles_unlimited() {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission > 1 AND permission < 50 ORDER BY user_name ASC');       
        if($qry){
            return $qry->result();
        }
    }
    
//collect the total number of users
    function all_profiles_tally() {
        $qry = $this->db->query('SELECT * FROM `users` WHERE permission > 1 AND permission < 50 ORDER BY user_name ASC');       
        if($qry){
            return count($qry->result());
        }
    }
    
}

// End of File
?>