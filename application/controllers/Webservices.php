<?php
class Webservices extends CI_Controller {

function __construct() {
        parent::__construct();
       $this->load->model('Webservice_model');
    }



// API for registeration by form//

       public function userRegister()
        {
        	
         $data= $this->get_JSON_Request();
             if(!empty($data)){

		if(!empty($data['firstname']) && !empty($data['lastname']) && !empty($data['email']) &&! empty($data['mobileno']) && !empty($data['password'])){

		
			$abc=$this->Webservice_model->makeNewUser($data); 
			$message = 'this is a dummy text';

			$result= $this->Webservice_model->userInsert($abc);

					$message = "hello Mr ".$result['firstname']." we welcomed you!.";

			 helpers::SendEmails($abc['email'],'just for testing',$message);


			if($result== false){
					$response = array('status'=>false, 'message'=>'User email already exist.','user_id'=> $result);
			}

			// var_dump($abc); die;
				else
				$response = array('status'=>true, 'message'=>'You have registered sucessfully.','user_id'=> $result);
		

		}

		else{
			$response = array('status'=>flase, 'message'=>'Please fill all the requied fields');
		}

		$this->print_response($response);

        }
    }


//Api for login
    public function userLogin(){

    	$data = $this->get_JSON_Request();

    	if(!empty($data['email']) && !empty($data['password'])){

    		$final = $this->Webservice_model->loginUser($data);

    		if($final== true){

    			$response = array('status'=>true, 'message'=>'You have loggedIn sucessfully.','result'=> $final);
    		}

    		else{
			$response = array('status'=>flase, 'message'=>'Either email or password is wrong');
		}

$this->print_response($response);
    	}
    }




// -------------------------------------------functions----------------------------//

function print_response($response)
	{
		header('Content-type: application/json');
		echo json_encode($response);
		exit;
		
	}

   function get_JSON_Request($isJson = true)
	{
		if($isJson)
			return json_decode($this->get_file_content(), true);
		return $_POST;
	}

	function get_file_content()
	{
		return file_get_contents('php://input');
	}

	function isJSON($string){
	   return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}
}