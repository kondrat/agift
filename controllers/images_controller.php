<?php
class ImagesController extends AppController {
	var $name = 'Images';
	var $uses = array();
//--------------------------------------------------------------------	
  	function beforeFilter() {
        $this->Auth->allow('index','add','view', 'img');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
    }
//--------------------------------------------------------------------
    function index(){
    }




	function img(){
		
		$filepath = WWW_ROOT.'img'.DS.'fortest'.DS.'8.jpg';
		//echo dirname($filepath); 
		//echo $filepath;
		//$fp = fopen($filepath, 'rb+');
		if ( !($size = getimagesize($filepath)) ) {
			echo 'No such file';
			
		} else {
			if ($size[2] == 1) $output_format = 'gif';
			if ($size[2] == 2) $output_format = 'jpg';
			if ($size[2] == 3) $output_format = 'png';
			$width = $size[0];
			$height = $size[1];
			
			if ( $width != 0 ) {
				$ratio = $height/$width;
				
				$newWidth = array(280, 132, 70);
				
				foreach ( $newWidth as $newTumbWidth ) {
					
    				switch ($newTumbWidth) {
                         case 280:
                         	$imgDir = 'img'.DS.'b';
                         	$newTumbHeight = ceil($ratio* $newTumbWidth);
                           break;
                         case 132:
                         	$imgDir = 'img'.DS.'s';
                         	$newTumbHeight = ceil($ratio* $newTumbWidth);
                           break;
                         case 70:
                         	$imgDir = 'img'.DS.'t';
                         	$newTumbHeight = 70;
                           break;
                  	}
                  	
                  	$thumb = imagecreatetruecolor( $newTumbWidth,  $newTumbHeight );
				
					$source = imagecreatefromjpeg($filepath);

					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newTumbWidth, $newTumbHeight, $width, $height);

					// Output
					switch ($size[2]) {
                     	case 1:
                       		imagegif($thumb, $imgDir.DS.'test-1'.'.gif');
                      	 	break;
                     	case 2:
                       		imagejpeg($thumb, $imgDir.DS.'test-1'.'.jpg', 95);
                      	 	break;
                     	case 3:
                      	 	imagepng($thumb, $imgDir.DS.'test-1'.'.png');
                       		break;
                    }
				
				}
				
				
			}
					
		}
		//debug($size);	
		
	}

	function delete( $id = null){

	}

	function edit( $id = null ){
	}

	function view( $id = null){
	}


}

?>