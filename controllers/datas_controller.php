<?php
class DatasController extends AppController {
	var $name = 'Data';
	var $uses = array('Gift', 'Category', 'Marking', 'Image');
	
//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow('index','parse');
        parent::beforeFilter();
    }
//--------------------------------------------------------------------

    function index(){

    }
//--------------------------------------------------------------------
	function parse(){
		//SUPPLIER = 2!! for Oasis
		//SUPPLIER = 4!! for USB
		//PARENT = 4!! for USB		
		$file = 'usb.txt';//SUPPLIER = 4!!
		$supplier = 4;
		//$file = 'ferre.txt';//SUPPLIER = 2!!
		$contents = file( TMP.'uploads'.DS.$file );
		//debug($contents);
		//parsing process
		$arrayUnique = array();
		$i = 0;
		foreach ($contents as $content) {			
			$content_new[$i] = explode("\t", $content);
			
			if (in_array($content_new[$i][1],$arrayUnique) ) {
					unset($content_new[$i]);
				continue;
			}
			$arrayUnique[] = $content_new[$i][1];
						
				//parse category (number is 3)
				$content_new_3 = explode(",", trim($content_new[$i][3]) );
				//debug($content_new_3);	
				$j=0;
				$content_new_cat = array();
				foreach ( $content_new_3 as $content_new_3_category ) {					
					$content_new_cat[$j] = $content_new_3_category;
					$j++;
				}
				$content_new[$i][3] = $content_new_cat;
				//end of parse category
				
				//-----------------------------------------------------------------
				
				// parse marking (number is 9)
				$content_new_9 = explode(",", $content_new[$i][9]);
				//debug($content_new_9);
				$j=0;
				$content_new_mark = array();
				foreach ( $content_new_9 as $content_new_9_marking ) {
					
					$content_new_mark[$j] = $content_new_9_marking;

					$j++;
				}
				$content_new[$i][9] = $content_new_mark;
				//end of parse marking
				
				//----------------------------------------------------------------			
			
				// parse photo (number is 12)
				$content_new_12 = explode(",", $content_new[$i][12]);
				//debug($content_new_12);
				$j=0;
				$content_new_phot = array();
				foreach ( $content_new_12 as $content_new_12_photo ) {
					
					if ($supplier == 2 ) {
						if ( strpos($content_new_12_photo,'ig' ) ) {
							$content_new_12_photo = str_replace( 'big\\','',trim($content_new_12_photo) );
							$content_new_phot[] = $content_new_12_photo;
						}
					} else {
						$content_new_phot[] = trim($content_new_12_photo);
					}

					$j++;
				}
				$content_new[$i][12] = $content_new_phot;
				
				//end of parse photo					
			
				//----------------------------------------------------------------
				
				$i++;

		}
		//debug($content_new);
		unset($content_new[0]);
		unset($content_new[1]);
		

		
		//debug($content_new);
		
		$content_new_and_paths = $this->_path_parse($content_new);
		
		//debug($content_new_and_paths);
		set_time_limit ( 0 );

		//$this->_save_parent($content_new_and_paths, $supplier);//first we saving gifts
		
		$this->_saveImage($content_new_and_paths, $supplier);//then we saving images
		echo 'end of script';
	}
	//---------------------------------------------
	function _path_parse( $content_new = null ) {		
		$g = 0;
		foreach($content_new as $content_new_3) {
			$path_temp = array();
			$n = 0;
			foreach($content_new_3[3] as $content_new_save_3 ) {
				$ggs = explode("\\", $content_new_save_3);
				$l = 0;
				foreach ($ggs as $gg) {
					if( trim($gg) != null) {
						$path_temp[$n][$l] = $gg;
					}
					$l++;
				}
				$n++;
			}
			
			$content_new_3[3]=$path_temp;
			$content_new[$g+2][3] = array();
			$content_new[$g+2][3] = $content_new_3[3];
			
			$g++;


		}
		
		return($content_new);
		
	}
	
	//---------------------------------------------
	function _save_parent( $content_new_and_paths = null , $supplier = null) {
		
		$this->Marking->Behaviors->attach('Containable');
		$supplierToSave = $supplier;
		foreach( $content_new_and_paths as $content_new_and_path ) {
				$this->data['Gift']['supplier'] = $supplierToSave;
				$this->data['Gift']['code'] = trim($content_new_and_path[1]);
				$this->data['Gift']['name'] = trim($content_new_and_path[2]);
				$this->data['Gift']['color'] = trim($content_new_and_path[4]);
				$this->data['Gift']['packsize'] = trim($content_new_and_path[8]);
				$this->data['Gift']['packtype'] = trim($content_new_and_path[5]);
				$this->data['Gift']['packqty'] = trim($content_new_and_path[7]);
				$this->data['Gift']['weight'] = trim($content_new_and_path[6]);
				$this->data['Gift']['content1'] = trim($content_new_and_path[10]);
				$this->data['Gift']['price'] =  str_replace(",", ".", trim($content_new_and_path[11]));
				if (isset($content_new_and_path[16]) ) {
					$this->data['Gift']['material'] = trim($content_new_and_path[16]);
				}
				
				//marking id getting
				
				/*
				$mark = array();
				if ( isset($content_new_and_path[9]) && $content_new_and_path[9] != null ) {
					foreach ($content_new_and_path[9] as $marking ) {
						
						
						$this->Marking->contain();

						$ccc = $this->Marking->find('all', array( 'conditions' => array('Marking.description' => trim($marking), 'Marking.supplier' => $supplierToSave) ,'fields' => array('Marking.id') ) ) ;
						
						if ($ccc == null ) {
							
							if ( trim($marking) != null ) {
								$data_marking['Marking']['description'] = trim($marking);
								$data_marking['Marking']['supplier'] = $supplierToSave;
								$this->Marking->save($data_marking);
								$mark[] = $this->Marking->getLastInsertID();
								$this->Marking->id = null;
							}
							
						} else {
							$mark[] = $ccc[0]['Marking']['id'];
						}
					}
				} 
				//debug ($mark);
				if ( $mark != array() ) {
					$this->data['Marking']['Marking'] = $mark;
				}
				*/				
				//marking id getting
				

				
				$this->data['Category']['Category'] = $this->_save_category($content_new_and_path[3], 4);
				debug($this->data);
				
			//case unique code ( gift code + suplaer code );
			$a = $this->Gift->find('all', array( 'conditions' => array('Gift.code' => $content_new_and_path[1], 'Gift.supplier' => $supplierToSave ), 'fields' => array('Gift.code', 'Gift.id') ) );
			if( $a ) {
				$this->Gift->id = $a[0]['Gift']['id'];
				//debug($this->Gift->id);				
			}
			 
			$this->Gift->save($this->data);
			
			$this->Gift->id = null;
						 
			
		}
	
	}
	//--------------------------------------------------------------------
	function _save_category($categoty_arrays = null, $supplier = null) {
		$supplierToSave = $supplier;
	//echo '<hr />';
			//debug($categoty_arrays);
		foreach( $categoty_arrays  as $category_array ) {
			//debug($category_array);
				// for log file
				//$b =  'Attantion: new category'.$category_array[0].'has been created';
			
        			$parent = 1;
        			//debug($parent);
        			//debug(count($category_array));
        			for($i = 0 ; $i < count($category_array) ;$i++ ) {
        				$data['Category']['supplier'] =  4;
        				$data['Category']['parent_id'] =  $parent;
        				$data['Category']['description'] = trim($category_array[$i]);
        				//debug($data);
        				$a = $this->Category->find('all', array( 'conditions' => array('Category.description' => trim($category_array[$i]), 'Category.parent_id' => $parent ), 'fields'=> array('Category.id', 'Category.name', 'Category.parent_id') ) );
        				//debug($a);
        				if( $a == null ) {
        					//debug($data);
        					//echo 'a=null';
        					if( $this->Category->save($data) ) {
        						$parent = $this->Category->getLastInsertID();
        						
        						$this->Category->id = null;
        						//echo 'new Category has been saved';
        					}
        				} else {
        					$parent = $a[0]['Category']['id'];       					
        				}
        							
        			}
        			$parent_for_gift[] = $parent;
        			
		}
		
		//echo '<hr />';
		return($parent_for_gift);
	}	
//--------------------------------------------------------------------
	//saving images for the OASIS.
	function _saveImage( $content_new_and_paths = null , $supplier = null) {
		$image = array();
		$supplierToGet = $supplier;
		foreach ( $content_new_and_paths as $content_new_and_path) {

			$parentGift = $this->Gift->find('first', array( 'conditions' => array('Gift.code' => trim($content_new_and_path[1]), 'Gift.supplier' => $supplierToGet) ) ) ;

			/*
			$parentImageCount = $this->Image->find('count', array( 'conditions' => array('Image.gift_id' => $parentGift) ) ) ;
			if ( $parentGiftCount > 0 ) {
				continue;
			}
			*/
			
    		if ( isset($content_new_and_path[12]) && $content_new_and_path[12] != null ) {
    			
    			foreach ( $content_new_and_path[12] as $image ) {
    				
    					
    					if ( trim($image) != null ) {
    						$data_image['Image']['img'] = trim($image);
    						$data_image['Image']['gift_id'] = $parentGift['Gift']['id'];
    						
    						//debug($data_image);
    						$imageCheck = $this->Image->find( 'first', array('conditions' => array('Image.gift_id' => $parentGift['Gift']['id'], 'Image.img' => trim($image) ) ) ) ;
    						if( $imageCheck == array() )	{
    							$this->Image->save($data_image);
    						} else {
    							
    								$this->Image->id = $imageCheck['Image']['id'];
    								$this->Image->save($data_image);
    							
    						}
    						
    						$this->Image->id = null;
    
    					}
    			}
    			
    		} else {
    			
    			$data_image['Image']['img'] = 'noimg.jpg';
    			$data_image['Image']['gift_id'] = $parentGift['Gift']['id'];
    			$this->Image->save($data_image);
    			$this->Image->id = null;		    			
    		}
    	} 
				
	}
	
//--------------------------------------------------------------------
	function edit( $id = null ) {
	}

	function view( $id = null) {
	}


}

?>