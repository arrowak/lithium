<?php
namespace app\controllers;

session_start();

use app\models\Users;
use app\models\Hows;
use app\models\Wheres;
use app\models\Whichs;
use app\models\Whats;

use lithium\security\Auth;
use lithium\g11n\Message;
use lithium\storage\Session;

class AdminController extends \lithium\action\Controller 
{
	public function index()
	{
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
	}

	public function manage()
	{
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
	
		if(isset($_SESSION['role']) && $_SESSION['role'] != 'admin' )
		{
			return $this->redirect('User::index');
		} 
		else 
		{
			$temp = $this->request->data;
			if($temp) 
			{
			  // var_dump($temp);
			  // $users = Users::first(array('conditions' => 'user_email'=>$temp['user_email']));
			  $users = Users::first(array('conditions' => array('email'=>$temp['email'])));
				if(isset($users) && $users['email']==$temp['email']) {
					return "Error: User with email id ".$temp['email']." already exists";
				} else {
					$random = substr(number_format(time() * rand(),0,'',''),0,10);
					$temp['uniqueno'] = $random;///substr($temp['user_email'],0,strpos($temp['user_email'],'@'))
					$temp['roles']=array(array('value'=>$temp['roles']));
					$adm = Users::create($temp);
					if($adm->save())
						return $this->redirect('Admin::manage');
					else return "Error: Unable to save user";
				}
			}
		}
	}

	public function success()
	{
		if($_SESSION['loginSuccess'] != 1)
			return $this->redirect('Login::login');
				
	}
	
	public function addInterests(){
		if($_SESSION['role'] != "admin")
		{
			return $this->redirect('User::profile');
		}
	}
	
	public function getHows(){
		$hows = Hows::getHows('all',array('conditions' => array('status' => '1')));
		$howsArray = array();
		
		foreach($hows as $how)
		{
			array_push($howsArray,array('name' => $how['name'],'id' => $how['_id']));
		}
		
		return json_encode($howsArray);
	}
	
	public function getWheres(){
		$wheres = Wheres::getWheres('all',array('conditions' => array('status' => '1')));
		$wheresArray = array();
		
		foreach($wheres as $where)
		{
			array_push($wheresArray,array('name' => $where['name'],'id' => $where['_id']));
		}
		
		return json_encode($wheresArray);
	}
	
	public function deleteHow(){
		$howId = $_POST['id'];
		$result = Hows::updateHow(array('status' => '0'),array('_id' => new \MongoId($howId)));
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
	
	public function deleteWhere(){
		$whereId = $_POST['id'];
		$result = Wheres::updateWhere(array('status' => '0'),array('_id' => new \MongoId($whereId)));
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
	
	public function createHow(){
		$howName = $_POST['name'];
		$result = Hows::create(array('name' => $howName,'status' => '1'))->save();
		
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
	
	public function createWhere(){
		$whereName = $_POST['name'];
		$result = Wheres::create(array('name' => $whereName,'status' => '1'))->save();
		
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
	
	public function editWhere(){
		$whereName = $_POST['name'];
		$id = $_POST['id'];
		$result = Wheres::updateWhere(array('name' => $whereName),array('_id' => new \MongoId($id)));
		
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
	
	public function editHow(){
		$howName = $_POST['name'];
		$id = $_POST['id'];
		$result = Hows::updateHow(array('name' => $howName),array('_id' => new \MongoId($id)));
		
		if($result)
		{
			return '1';
		} 
		else
		{
			return '0';
		}
	}
}


?>
