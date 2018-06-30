<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


 class helpers{
 	
static function createSalt(){
		return substr(md5(uniqid(rand(), true)), 0, 9);
	}

static function createPassword($password, $salt){
		return sha1($salt . sha1($salt . sha1($password)));
	}

	static function generateRandomString($length = 10)
	{
		$characters=substr(round(microtime(true)), -4 );
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}


		//enter
		return $characters;
	}

	static function sqlDate(){
		return date("Y:m-d H:i:s");
	}



static function uniqueUsername($username){
$ci=&get_instance();
$result = $ci->db->get('tbl_users');
$row= $result->result_array();

// print_r($row);

foreach ($row as $key => $value) {
	# code...

	$prev_rows = $value['username'];

	if($prev_rows == $username){

		  $rand = rand(10,50);
         $username = $username."-".$rand;

         

	}
}
return $username;
	
}


static function SendEmails($userEmail,$emailTitle,$message){
$ci =& get_instance();



$ci->load->library('email');

$config = Array(
   'protocol' => 'smtp',
   'smtp_host' => 'ssl://smtp.googlemail.com',
   'smtp_port' => 465,
   'smtp_user' => 'ankitsharma@mansainfotech.com',
   'smtp_pass' => 'Sh@rmaAnk1tc0ol$',
   'mailtype'  => 'html', 
   'charset'   => 'utf-8',
   'wordwrap'=>true,
   'mailpath'=> '/usr/sbin/sendmail',
   'smtp_timeout'=>'30',
);

// var_dump($config);die;

//SMTP & mail configuration

$ci->email->initialize($config);
$ci->email->set_mailtype("html");
$ci->email->set_newline("\r\n");

//Email content

$ci->email->to($userEmail);
$ci->email->from('registration@newmail.com','new mail');
$ci->email->subject($emailTitle);
$ci->email->message($message);

//Send email
$ci->email->send();

// echo $ci->email->print_debugger(array('headers')); 
 return true;
}

	function generateOTPString($length = 5) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

}