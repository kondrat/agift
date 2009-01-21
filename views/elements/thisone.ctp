<?php
	//debug($data);
	extract ($data);
	$param = strtolower($this->params['pass'][0]);
	//debug($data);
	$class = null;
    if ( $Category['id'] == $param   ) {
         $tree->addItemAttribute('class', 'menuliStr'); // highlight this li
         $class = 'redbold';
  		
			
    } else {
        // $tree->addTypeAttribute('style', 'display', 'none'); // hide this ul completely
        $tree->addItemAttribute('class', 'menuliStr2');
    }
    
    	if ( isset($Category['supplier'] ) ) {
			switch ( $Category['supplier'] ) {        
       	 		case 2:
       	 //CASE 2 oasis
       	 	$supplierType = 'oasis';	
       	 		break;
       	 		case 3:
       	 //CASE 3 proekt111
       	 	$supplierType = 'proekt111';
       	 		break;
       	 		case 4:
       	 //CASE 4 usb
       	 	$supplierType = 'usb';
       	 		break;
       	 	}
    	}
    	
    echo $html->link( $Category['description'], array( 'action' => $supplierType, $Category['id'],$Category['name'] ), array('class' => $class) );

	
?>