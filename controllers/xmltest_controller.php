<?php
class XmltestController extends AppController {
	var $name = 'Xmltest';
	var $uses = array('Gift', 'Category', 'Image');

	
//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow('index','parse','xml');
        parent::beforeFilter();
    }
//--------------------------------------------------------------------

    function index(){

    }
//--------------------------------------------------------------------
	function xml(){
		
    // import XML class
    App::import('Xml');

    // your XML file's location
    $file = TMP.'uploads'.DS."product.xml";

    // now parse it
    $parsed_xml =& new XML($file);
    $parsed_xml = Set::reverse($parsed_xml); // this is what i call magic

    // see the returned array
   // debug($parsed_xml);
   		//$i = 0;
   		
   		foreach ($parsed_xml['Doct']['Product'] as $for_img ) {
   			
   			//$newImage[$i]['old_id'] = $for_img['product_id'];
   			if ( isset($for_img['BigImage']['src']) ) {
   					
   				//$newImage[$for_img['product_id']] = $for_img['BigImage']['src'];
   				$this->Gift->recursive = -1;
   				
   				$giftId = $this->Gift->find('first', array( 'conditions' => array('Gift.old_id' => $for_img['product_id'] ) ) );
   				
   				
   				$this->data['Image']['gift_id'] = $giftId['Gift']['id'];
   				$this->data['Image']['img'] = $for_img['BigImage']['src'];
   				debug($this->data['Image']);
   				
   				$this->Image->create();
   				$this->Image->save($this->data['Image']);
   				$this->Image->id = null;
   				
   				
   				
   				//$newImage[$i]['SmallImage'] = $for_img['SmallImage']['src'];
   			} 
			//$i++;
		}
   		debug($newImage);
   		
	}

	
	//---------------------------------------------
	function _save_parent( $content_new_and_paths = null ) {
		
		foreach( $content_new_and_paths as $content_new_and_path ) {
				$this->data['Gift']['suplayer'] = 1;
				$this->data['Gift']['code'] = $content_new_and_path[1];
				$this->data['Gift']['name'] = $content_new_and_path[2];
				$this->data['Gift']['color'] = $content_new_and_path[4];
				$this->data['Gift']['packsize'] = $content_new_and_path[8];
				$this->data['Gift']['packtype'] = $content_new_and_path[5];
				$this->data['Gift']['packqty'] = $content_new_and_path[7];
				$this->data['Gift']['weight'] = $content_new_and_path[6];
				$this->data['Gift']['content1'] = $content_new_and_path[10];
				$this->data['Gift']['price'] =  str_replace(",", ".", $content_new_and_path[11]);
				
				$this->data['Category']['Category'] = $this->_save_category($content_new_and_path[3]);
				
				
			//case unique code ( gift code + suplaer code );
			$a = $this->Gift->find('all', array( 'conditions' => array('Gift.code' => $content_new_and_path[1], 'Gift.suplayer' => 1 ), 'fields' => array('Gift.code', 'Gift.id') ) );
			if( $a ) {
				$this->Gift->id = $a[0]['Gift']['id'];				
			}
			 
			$this->Gift->save($this->data);
			
			$this->Gift->id = null;
						 
			
		}
	
	}
	//--------------------------------------------------------------------
	function _save_category($categoty_arrays = null) {
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
        				$data['Category']['parent_id'] =  $parent;
        				$data['Category']['name'] = trim($category_array[$i]);
        				//debug($data);
        				$a = $this->Category->find('all', array( 'conditions' => array('Category.name' => trim($category_array[$i]), 'Category.parent_id' => $parent ), 'fields'=> array('Category.id', 'Category.name', 'Category.parent_id') ) );
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
	function delete( $id = null) {

	}

	function edit( $id = null ) {
	}

	function view( $id = null) {
	}


}

?>