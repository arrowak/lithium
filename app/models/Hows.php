<?php 
namespace app\models;
use \lithium\data\connections;

class Hows extends \lithium\data\Model {

	protected function _init() {
        	$this->_render['negotiate'] = true;
        	parent::_init();
   }	
	
	/* for retrieval from hows collection */
	public function getHows($type,$options){					
		$hows = Hows::find($type,$options);
		return $hows;
	}
	
	
	/* for updating hows collection */
	public function updateHow($query, $condition){
		$result = Hows::update($query,$condition, array('atomic' => false));		
		return $result;	
	}
	
	/* for deleting a how record */
	public function deleteHow($condition){
		$result = Hows::remove($condition);
		return $result;
	}

}
 
 
?>
