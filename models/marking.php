<?php
// app/models/marking.php
class Marking extends AppModel {
	var $name = 'Marking';


//--------------------------------------------------------------------
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
			'Gift' => array('className' => 'Gift',
						'joinTable' => 'gifts_markings',
						'foreignKey' => 'marking_id',
						'associationForeignKey' => 'gift_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			)
	);
//-------------------------------------------------------------------
}
?>
