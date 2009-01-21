<?php

class Image extends AppModel {

	public $name = 'Image';
	
    var $belongsTo = array('Gift'=> array('className'=> 'gift', 'counterCache' => false ),

    					);

}
?>
