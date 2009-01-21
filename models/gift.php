<?php
// app/models/gift.php
class Gift extends AppModel {
	var $name = 'Gift';
	
	var $validate = array(
        'priceMin' => array(
            'rule' => 'date',  
            'message' => 'Неправильная сумма'
        ),
      	'priceMax' => array(
            'rule' => 'numeric',  
            'message' => 'Неправильная сумма'
        )
    
	);

	
//--------------------------------------------------------------------	

	var $hasAndBelongsToMany = array(
			'Category' => array('className' => 'Category',
						'joinTable' => 'categories_gifts',
						'foreignKey' => 'gift_id',
						'associationForeignKey' => 'category_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			/*
			'Marking' => array('className' => 'Marking',
						'joinTable' => 'gifts_markings',
						'foreignKey' => 'gift_id',
						'associationForeignKey' => 'marking_id',
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
			*/
	);
	
    var $hasMany = array('Image' => array('className' => 'Image',
								'foreignKey' => 'gift_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => '')
                        );

}
?>
