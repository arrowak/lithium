<?php 
namespace app\models;
use \lithium\data\connections;

class Wheres extends \lithium\data\Model {

	protected function _init() {
        	$this->_render['negotiate'] = true;
        	parent::_init();
   }	
	
	/* for retrieval from wheres collection */
	public function getWheres($type,$options){					
		$wheres = Wheres::find($type,$options);
		return $wheres;
	}
	
	
	/* for updating wheres collection */
	public function updateWhere($query, $condition){
		$result = Wheres::update($query,$condition, array('atomic' => false));		
		return $result;	
	}
	
	/* for deleting a where record */
	public function deleteWhere($condition){
		$result = Wheres::remove($condition);
		return $result;
	}
	

}
 
 
?>
