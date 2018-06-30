<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice_model extends CI_Model {

	 function __construct() {
        parent::__construct();
        
    }



    public function userInsert($data){

$count = $this->check_useremail_exists($data['email']);

if(!$count){
 $query = $this->db->insert('tbl_users',$data);
$last_id = $this->db->insert_id();

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$last_id);
$result= $this->db->get();

$final = $result->row_array();
return $final;

}
else {
	return false;
}
    	
    }



    public function check_useremail_exists($email=flase){
 $this->db->select('COUNT(email) as usercount ');
             $this->db->from('tbl_users');
             $this->db->where('email', $email);
             $query = $this-> db->get();
             $result    = $query->row_array();
             $user_count = 0;
             if($query->num_rows()>0) {
             $user_count = $result['usercount']; 
             }
             return $user_count;
    }


    public function makeNewUser($data, $newPassword=true){

    	$this->load->helper('common_helper');
    	$record = $data;
    	$username = $data['firstname'].''.$data['lastname'];
 $record['username'] = helpers::uniqueUsername($username);
   $salt = helpers::createSalt();
    if($newPassword){

    	$password= helpers::createPassword($data['password'],$salt);
    	 $record['password'] = $password;
    	 $record['salt'] = $salt;
    }
   
     

  
 return $record;

    }


    public function loginUser($data){

    	$this->db->select('*');
    	$this->db->from('tbl_users');
    	 $this->db->where('email', $data['email']);
   
 		$query = $this->db->get();
          $result = $query->row_array();
          $password = $data['password'];
 $salt = $result['salt'];
            $pass_from_db = $result['password'];
            $pass_from_user = sha1($salt . sha1($salt . sha1($password)));
          if( $pass_from_db ==  $pass_from_user){

            $userRecords = $result;
            return $userRecords;

          }
    }
}
