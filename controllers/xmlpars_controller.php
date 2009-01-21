<?php
class XmlparsController extends AppController {
	var $name = 'Xmlpar';
	var $uses = array('Gift', 'Category', 'Marking');

	
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
		//echo 'tesss';	
		$file = 'catalogue.xml';

		$dom  = new DomDocument();
		$dom->load(TMP.'uploads'.DS.$file);
		$root = $dom->documentElement;
		$root2 = $root;
		
		
		$k = 0;
		$project111_gifts = array();
		$this->process_children($root, &$project111_gifts);
		
		//echo '<p>end of process childern</p>';
	
		$project111_tree = array();
		$i = 0;	
		$this->make_tree($root, &$project111_tree, &$i);
	
		
		//echo '<div style="color: red">';
		$project111_gifts_tree = array();		
		$j = 0;	

		
		$page_root2 = $root2->getElementsByTagName('page')->item(0);	
		$this->make_prod_struc($page_root2, &$project111_gifts_tree , &$j);
		
		
		//debug($k);
		//debug($project111_gifts);		
		//debug($project111_tree);		
		//debug($project111_gifts_tree);
		debug($i);
		debug($j);
				
		//$this->_save_marking($project111_gifts);
		//$this->_save_category($project111_tree);
		$this->_save_gift($project111_gifts, $project111_gifts_tree);

	}

		function process_children($node, &$cc) {
			
			
			$childern = $node->childNodes;
				$k = 0;
    			foreach ($childern as $elem ) {
    				if ($elem->nodeName ) {
    					
    				
        				if ( strlen(trim($elem->nodeValue) ) && $elem->nodeName =='product' ) {
        					
        					//echo '<b>'.$elem->nodeName.'</b><br /> Old id: ';
        					$code = $elem->getElementsByTagName('product_id')->item(0);
        					if ( isset($code->nodeValue) ) {
        						 $cc[$k]['old_id'] = $code->nodeValue;
        						//echo '<br />';
        					}
        					
        					$code = $elem->getElementsByTagName('code')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'Code : ';
        						 $cc[$k]['code'] = $code->nodeValue;
        						//echo '<br />';
        					}
        					
        					$code = $elem->getElementsByTagName('name')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'Name : ';
        						 $cc[$k]['name'] =$code->nodeValue;
        						//echo '<br />';
        					} 
        					$code = $elem->getElementsByTagName('product_size')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'product_size : ';
        						 $cc[$k]['size'] = $code->nodeValue;
        						//echo '<br />';
        					} 
        					$code = $elem->getElementsByTagName('matherial')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'material : ';
        						 $cc[$k]['material'] = $code->nodeValue;
        						//echo '<br />';
        					}        
        					$code = $elem->getElementsByTagName('content')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'content : ';
        						 $cc[$k]['content'] = $code->nodeValue;
        						//echo '<br />';
        					}        
        					$code = $elem->getElementsByTagName('content2')->item(0);
        					if ( isset($code->nodeValue) ) {
        						//echo 'content2 : ';
        						 $cc[$k]['content2'] = strip_tags($code->nodeValue, '<br><span>' );
        						//echo '<br />';
        					} 
        					$price = $elem->getElementsByTagName('price')->item(1);
        					if ( isset($price->nodeValue) ) {
        						//echo 'price : ';
        						 $cc[$k]['price'] = $price->nodeValue;
        						//echo '<br />';
        					} 
        					
        					
        				//photo
        					$small_image = $elem->getElementsByTagName('small_image')->item(0);
        					if ( isset( $small_image->getAttributeNode('src')->value ) ) {
        						//echo 'small_image : ';
        						 $cc[$k]['small_image'] = $small_image->getAttributeNode('src')->value;
        						//echo '<br />';
        					}
        					         				
        					$big_image = $elem->getElementsByTagName('big_image')->item(0);
        					if ( isset( $big_image->getAttributeNode('src')->value ) ) {
        						//echo 'big_image : ';
        						 $cc[$k]['big_image'] = $big_image->getAttributeNode('src')->value;
        						//echo '<br />';
        					}         			        				
        				
        				 
        					
 						//marking
 							$marking_types = $elem->getElementsByTagName('print');
 							$n = 0;
 							foreach( $marking_types as $marking ) {
 								$name = $marking->getElementsByTagName('name')->item(0);
        						if ( isset($name->nodeValue) ) {
        							//echo '--- Marking name : ';
        							 $cc[$k]['marking'][$n]['marking_type'] = $name->nodeValue;
        							//echo '<br />';
        						}
 								$description = $marking->getElementsByTagName('description')->item(0);
        						if ( isset($description->nodeValue) ) {
        							//echo '--- Marking description : ';
        							 $cc[$k]['marking'][$n]['marking_desc'] = $description->nodeValue;
        							//echo '<br />';
        						}
								$note = $marking->getElementsByTagName('note')->item(0);
        						if ( isset($note->nodeValue) ) {
        							//echo '--- Marking note : ';
        							 $cc[$k]['marking'][$n]['marking_note'] = $note->nodeValue;
        							//echo '<br />';
        						}
        						$n++;  
 							}
 
 
 
 
 
        				//product_attachment	block
        				$product_attachments = $elem->getElementsByTagName('product_attachment');
        				
        				$l = 0;
        				
        				foreach ($product_attachments as $product_attachment) {
        					if ( isset($product_attachment) ) {
        						
            					if (  ($product_attachment->nodeType) && $product_attachment->nodeType == XML_ELEMENT_NODE ) {
            						//echo 'Product_attachment : <br />';
            						
            						
            						$name = $product_attachment->getElementsByTagName('name')->item(0);
            						if ( isset($name->nodeValue) ) {        							
            							//echo '--- Name: ';
            							 $cc[$k]['product_attachment'][$l]['name'] = $name->nodeValue;
            							//echo '<br />';
            						}
            						$file = $product_attachment->getElementsByTagName('file')->item(0);
            						if ( isset($file->nodeValue) ) {        							
            							//echo '--- file: ';
            							 $cc[$k]['product_attachment'][$l]['file'] = $file->nodeValue;
            							//echo '<br />';
            						}        					
            						$image = $product_attachment->getElementsByTagName('image')->item(0);
            						if ( isset($image->nodeValue) ) {        							
            							//echo '--- image: ';
            							 $cc[$k]['product_attachment'][$l]['second_image'] = $image->nodeValue;
            							//echo '<br />';
            						}        			        					
            					
            					} 
        					}
        					$l++; 
        				}      					       					       					              					
        					//----------------------------------------       					
        					//echo '<br /><p style="color: green">Just for test</p>';
        					//echo trim($elem->nodeValue).'<br />';
        					//echo '<hr />';
        					$k++;
        				}
       											
    				}
    				
				}
				//echo $k.'<br />';
			 

			
		}	
	//--------------------------------------------
		function make_tree($node_page=null, &$cat = null, &$i) {
			
				$childern_page = $node_page->childNodes;

    			foreach ($childern_page as $elem ) {
    				 		   				    					    				
        				if ( strlen(trim($elem->nodeValue) && $elem->nodeName == 'page' )  ) {
         					        				
        						
        					if ($elem->nodeType == XML_ELEMENT_NODE ) {

       							$page_id = $elem->getElementsByTagName('page_id')->item(0);
        						if ( ($page_id->nodeValue) ) {
        							//echo 'Page_id : ';
        							 $cat[$i]['page_id'] = $page_id->nodeValue;
        							//echo '<br />';
        						}
        						        						
        						$par = $elem->parentNode;        						
       							$parent_page_id = $par->getElementsByTagName('page_id')->item(0);
        						if ( ($parent_page_id->nodeValue) ) {
        							//echo 'parent page id : ';
        							 $cat[$i]['parent_page_id'] = $parent_page_id->nodeValue;
        							//echo '<br />';
        						}        						
        						
       							$uri = $elem->getElementsByTagName('uri')->item(0);
        						if ( ($uri->nodeValue) ) {
        							//echo 'uri : ';
        							 $cat[$i]['uri'] = $uri->nodeValue;
        							//echo '<br />';
        						}
        						
       							$name = $elem->getElementsByTagName('name')->item(0);
        						if ( ($name->nodeValue) ) {
        							//echo 'uri : ';
        							 $cat[$i]['name'] = $name->nodeValue;
        							//echo '<br />';
        						}        						

        						$i++;
        						//echo $i.'<br />';        
        						$this->make_tree($elem, $cat, $i);        						
        					}

        				}

        			}
				
	
		}
	//--------------------------------------------
		function make_prod_struc($page_root2, &$bb, &$j) {
		
    		$page_root_childern = $page_root2->getElementsByTagName('product');
    		
    		foreach ($page_root_childern as $chi ) {
    			
    			
    			if ( $chi->nodeName == 'product' && $chi->nodeType == XML_ELEMENT_NODE ) {
    				
          							$product_id = $chi->getElementsByTagName('product')->item(0);
          							if ( $product_id ) {
                							if (($product_id->nodeValue) ) {
                								//echo '<p style="color: blue">product_id : ';
                								 ( $bb[$j]['product_id'] = $product_id->nodeValue );
                								//echo '</p>';
                							}
              							$page_id = $chi->getElementsByTagName('page')->item(0);
                							if (($page_id->nodeValue) ) {
                								//echo '<p style="color: blue">page_id : ';
                								 $bb[$j]['page_id'] = $page_id->nodeValue;
                								//echo '</p>';
                								$j++;
                							}
            						}						
    						
    			
    			}
    			
    		}
    		//echo $j.'<br />';
    		//echo '</p>';
		}
	//--------------------------------------------------------
	function _save_gift( $project111_gifts = null , $project111_gifts_tree = null ) {
		
		$project111_gifts_tree = $project111_gifts_tree;
		
		//debug ($project111_gifts_tree);
		
		
						
						
		foreach( $project111_gifts as $project111_gift ) {
				$this->data['Gift']['supplier'] = 3;
				$this->data['Gift']['old_id'] = $project111_gift['old_id'];
				$this->data['Gift']['code'] = $project111_gift['code'];
				$this->data['Gift']['name'] = $project111_gift['name'];
				$this->data['Gift']['material'] = $project111_gift['material'];
				//$this->data['Gift']['color'] = $project111_gift[4];
				//$this->data['Gift']['packsize'] = null;
				$this->data['Gift']['size'] = $project111_gift['size'];
				//$this->data['Gift']['packtype'] = $project111_gift[5];
				//$this->data['Gift']['packqty'] = $project111_gift[7];
				//$this->data['Gift']['weight'] = $project111_gift[6];
				$this->data['Gift']['content1'] = $project111_gift['content'];
				$this->data['Gift']['content2'] = $project111_gift['content2'];
				//price saving
				if ( empty($project111_gift['price']) ) {
					$project111_gift['price'] = 0.0;
				}
				$this->data['Gift']['price'] =  trim( str_replace(",", ".", $project111_gift['price']) );
				//marking id getting
				$mark = array();
				if ( isset($project111_gift['marking']) && $project111_gift['marking'] != null ) {
					foreach ($project111_gift['marking'] as $marking ) {
						$this->Marking->Behaviors->attach('Containable');
						$this->Marking->contain();
						$c = $this->Marking->find('all', array( 'conditions' => array('Marking.name' => $marking['marking_type'], 'Marking.supplier' => 3) ,'fields' => array('Marking.id') ) ) ;
						$mark[] = $c[0]['Marking']['id'];
						
					}
				} 
				//debug ($mark);
				$this->data['Marking']['Marking'] = $mark;
				
				
				$this->data['Category']['Category'] = $this->_get_gift_tree($project111_gifts_tree, $project111_gift['old_id'] );
				
				
			//case unique code ( gift code + suplaer code );
			$this->Gift->Behaviors->attach('Containable');
			$this->Gift->contain();
			$a = $this->Gift->find('all', array( 'conditions' => array('Gift.code' => $project111_gift['code'], 'Gift.supplier' => 3 ), 'fields' => array('Gift.code', 'Gift.id') ) );
			if( $a ) {
				$this->Gift->id = $a[0]['Gift']['id'];				
			}
			 
			$this->Gift->save($this->data);
			
			$this->Gift->id = null;
						 
			
		}
	
	}
	//--------------------------------------------------------------------
	function _save_category($categoty_arrays = null ) {
		
		/*
			ex:
            [0] => Array
                (
                    [page_id] => 10
                    [parent_page_id] => 10
                    [uri] => catalogue
                    [name] => Каталог
                )
         */

			//debug($categoty_arrays);
		//foreach( $project111_tree  as $category_array ) {
			//debug($category_array);
				// for log file
				//$b =  'Attantion: new category'.$category_array[0].'has been created';
        			//$parent = null;
        			//debug($parent);
        			//debug(count($category_array));
    			for($i = 1 ; $i < count($categoty_arrays) ;$i++ ) {
    								
    				$data['Category']['page'] = trim($categoty_arrays[$i]['page_id']);
    				$data['Category']['name'] = trim($categoty_arrays[$i]['uri']);
    				$data['Category']['description'] = trim($categoty_arrays[$i]['name']);
    				//$data['Category']['description'] = trim($categoty_arrays[$i]['name']);
    				
    				$a = $this->Category->find('all', array( 'conditions' => array('Category.page' => trim($categoty_arrays[$i]['parent_page_id']) ), 'fields'=> array('Category.id', 'Category.name', 'Category.parent_id') ) );
    				//debug($a);
   					if ( $a != null ) {
   						$parent = $a[0]['Category']['id'];
   					}
   					//debug ($parent);
					$data['Category']['parent_id'] =  $parent;
    				
    				//update if we already have such category
    				$b = $this->Category->find('all', array( 'conditions' => array('Category.page' => trim($categoty_arrays[$i]['page_id']) ), 'fields'=> array('Category.id') ) );
   					if ( $b != null ) {
   						$this->Category->id = $b[0]['Category']['id'];
   					}        				
    				
    				if( $this->Category->save($data) ) {
    					
    						$this->Category->id = null;
    						//echo 'new Category has been saved';							
    				} 
    				
    				
    			}
        			//$parent_for_gift[] = $parent;
        			
	}
	//--------------------------------------------------------------------
	function _save_marking($project111_gifts = null) {
	//echo '<hr />';
		foreach( $project111_gifts  as $project111_gift ) {
			//debug($project111_gift);
			
					$supplier = 3;

        			if ( isset ($project111_gift['marking']) ) {
        				foreach ( $project111_gift['marking'] as $dat ) {
            				$data['supplier'] =  $supplier;
            				$data['name'] =  trim($dat['marking_type']);
            				$data['description'] = trim($dat['marking_desc']);
            				//debug($data);
            				$a = null;
            				$a = $this->Marking->find('all', array( 'conditions' => array('Marking.name' => trim($data['name']) ), 'fields'=> array('Marking.id', 'Marking.name', 'Marking.supplier') ) );
            				//debug($a);
            				if( $a != null ) {
            					$this->Marking->id = $a[0]['Marking']['id'];
            				} 
            					//debug($data);
            					
            					if( $this->Marking->save($data) ) {            						
            						$this->Marking->id = null;
            					}
            					
            					
            				 
 
        				}
        			}			

        			
		}
		

	}		
//--------------------------------------------------------------------
	function _get_gift_tree($project111_gifts_tree = null, $old_id = null ) {
		
		$for_save_category_id = array();
		
		$this->Category->Behaviors->attach('Containable');
		
		foreach( $project111_gifts_tree as $gifts_tree ) {
			
			if ( $gifts_tree['product_id'] == $old_id ) {
				$this->Category->contain();
        		$aa = $this->Category->find('all', array( 'conditions' => array('Category.page' => $gifts_tree['page_id'] ), 'fields'=> array('Category.id' ) ) );
        		//debug($aa);
        		if ( $aa != null ) {
        			//foreach ($aa as $a) {
        				$for_save_category_id[] = $aa[0]['Category']['id'];
        			//}
        		}
 			
				 
			}
			
		}
		return ($for_save_category_id );
	}
	//-------------------------------------------------------------------
	function delete( $id = null) {
		
	}

	function edit( $id = null ) {
	}

	function view( $id = null) {
	}


}

?>