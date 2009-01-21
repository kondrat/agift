<?php
class Group extends AppModel {
	var $name   = 'Group';
    var $hasMany = array('User' => array('className' => 'User',
								'foreignKey' => 'group_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => '')
                        );
                        
	var $actsAs = array('Acl' => 'requester');

//--------------------------------------------------------------------    
	function parentNode() {
   		return null;
	}
//--------------------------------------------------------------------    

}
?>