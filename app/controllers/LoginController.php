<?php

namespace app\controllers;
session_start();

use app\models\Users;
use lithium\security\Auth;
use lithium\stoarge\Session;

class LoginController extends \lithium\action\Controller 
{

	public function login()
	{	
			if($_SESSION['loginSuccess'] == 1 && $_SESSION['role'] == "admin")
				return $this->redirect('Admin::manage');
			else if($_SESSION['loginSuccess'] == 1 && $_SESSION['role'] == "member")
				return $this->redirect('User::index');
			else
			{
			$data = $this->request->data;

			 if ($data && $data['email'] != "" && $data['password'] != "")
			 { 
				 
				if($_POST["recaptcha_challenge_field"]) {
					$privatekey = "6Lcb8tsSAAAAAJcxKb5f0AzH2fvKx1zjnlFHPqon";
               $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
					if(!$resp->is_valid) {
						$_SESSION['loginFailed'] = 1;
						return;
					}
				}
			   if(Auth::check('loginauth', $this->request))
				{	
					$_SESSION['loginFailed'] = 0;
					$_SESSION['loginSuccess'] = 1;
					$_SESSION['email'] = $data['email'];
					$myId = Users::getUsers('all',array('conditions' => array('email' => $data['email']), 'fields' => array('_id')));
					$loggedId = $myId[0]['_id'];
					$_SESSION['loggedInUserId'] = $loggedId;		
					
					if($data['email'] == "admin@youdyog.in") {
						$_SESSION['role'] = "admin";
						return $this->redirect('Admin::manage');
					}
					else {
						$_SESSION['role'] = "member";
						return $this->redirect('User::profile');
					}
				}			
				else
				{
					$_SESSION['loginFailed'] = 1;
					
				}
			}
			
			}
		}


		public function delete() 
		{
			Auth::clear('loginauth');
			unset($_SESSION['loginSuccess']);
			unset($_SESSION['loginFailed']);
			unset($_SESSION['count']);
			session_destroy();
			return $this->redirect('/login');
		}

}

?>
