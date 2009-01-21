<?php
// app/models/category.php
class Category extends AppModel {
	var $name = 'Category';
	var $actsAs = array('Tree');

//--------------------------------------------------------------------
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasAndBelongsToMany = array(
			'Gift' => array('className' => 'Gift',
						'joinTable' => 'categories_gifts',
						'foreignKey' => 'category_id',
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
