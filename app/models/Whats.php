<?php 
namespace app\models;

class Whats extends \lithium\data\Model {
	protected function _init() {
        	$this->_render['negotiate'] = true;
        	parent::_init();
   }	
	
	/* for retrieval from whats collection */
	public function getWhats($type,$options){					
		$hows = Whats::find($type,$options);
		return $hows;
	}
	
	
	/* for updating whats collection */
	public function updateWhat($query, $condition){
		$result = Whats::update($query,$condition, array('atomic' => false));		
		return $result;	
	}

}
 
 
?>
