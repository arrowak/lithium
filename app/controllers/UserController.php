<?php
namespace app\controllers;
session_start();

use app\models\Users;

use lithium\security\Auth;

use lithium\g11n\Message;
use lithium\storage\Session;
use lithium\security\Password;

class UserController extends \lithium\action\Controller {

	public function register()
	{
		var_dump($_SESSION['tempuserId']);
		if(isset($this->request->data['email'])) {
			$condition = array('_id'=>new \MongoId($_SESSION['tempuserId']));
			$this->request->data['password'] = Password::hash($this->request->data['password']);
			Users::update($this->request->data,$condition);
			unset($_SESSION['tempuserEmail']);
			unset($_SESSION['tempuserId']);
			return $this->redirect('User::success');
		}
		else
		{
			$uniqueno = substr($_SERVER['REQUEST_URI'],10);
			//var_dump($uniqueno);
			$tempuser = Users::first(array('conditions'=> array('uniqueno'=>$uniqueno)));
			$_SESSION['tempuserId'] = $tempuser['_id'];
			$_SESSION['tempuserEmail'] = $tempuser['email'];
			var_dump($_SESSION['tempuserEmail']);
		}
		
	}
	public function profile()
	{
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
	}
		
	public function welcome() {
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
	}
	public function participate() {
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
	}	
	public function index()
	{
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
		
	}
	public function success()
	{
     	
	}
	
	public function getLink(){
		$email = $_POST['email'];
		$user = Users::getUsers('all', array('conditions' => array('email' => $email), 'fields' => array('uniqueno')));
		$uniqueno = $user[0]['uniqueno'];
		return json_encode(array('link' => $uniqueno));
	}

	public function forgot()
	{
		
			$privatekey = "6Lcb8tsSAAAAAJcxKb5f0AzH2fvKx1zjnlFHPqon";
                $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid && $this->request->data) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("<h2>The reCAPTCHA wasn't entered correctly.</h2> Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } 
  else {
    // Your code here to handle a successful verification
    
  }
	}

}

?>
