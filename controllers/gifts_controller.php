<?php
App::import('Sanitize');
class GiftsController extends AppController {
	var $name = 'Gift';
	var $uses = array('Gift','Category','Image', 'CategoriesGift');
	//var $helpers = array('Paginator');
	var $paginate = array( 'limit' => 9 );

//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow('view', 'index', 'search', 'extsearch');
        parent::beforeFilter();
       // $this->params['pass'] = $this->data['Gift']['string'];
       //$this->params['pass'][0] = $this->params['url']['string'];
    }
//--------------------------------------------------------------------
	function add() {
		if (!empty($this->data)) {
			$this->Gift->create();
			if ($this->Gift->save($this->data)) {
				$this->Session->setFlash( __('The Gift has been saved', true) );
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Gift could not be saved. Please, try again.', true));
			}
		}
		//This use for the find('list') if we use smthname instead of name.
		//$this->User->displayField = 'username';
		//$users = $this->User->find('list');
		//$this->set( compact('users') );
	}
//--------------------------------------------------------------------
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Gift', true));
			$this->redirect( array('action'=>'index') );
		}
		if ($this->Gift->del($id)) {
			$this->Session->setFlash(__('Gift deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
//--------------------------------------------------------------------
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Gift->save($this->data)) {
				$this->Session->setFlash(__('The Product has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
		if ( empty($this->data) ) {
			$this->data = $this->Gift->read(null, $id);
		}
		//$dealers = $this->News->User->find('list');
		//$this->set(compact('dealers'));
	}
//--------------------------------------------------------------------
	function view($id = null) {
		$CategoryPass = array();
		$id = Sanitize::paranoid($id);
		$gifts = $this->Gift->read(null, (int)$id);
		if ( (!$id) ||  ( $gifts == array() ) ) {
			//$this->Session->setFlash(__('Invalid Gift.', true));
			$this->redirect('/');			
		} else {
			//debug($this->Gift->read(null, $id) );
			if (isset( $gifts['Category'] ) ) {
				foreach ( $gifts['Category'] as $giftCat ) {
					$CategoryPass[] = $this->Category->getpath( $giftCat['id'], array('id','name','description') );
					//debug($CategoryPass);
				}
			}
			$this->set('CategoryPass', $CategoryPass);
			$this->set('gift', $gifts);
			$this->set('referer', $this->referer() );
		}
	}
//--------------------------------------------------------------------

    function search() {
    	//debug($this->params);
    	$this->subheaderTitle = 'РЕЗУЛЬТАТЫ ПОИСКА';
    	// function vars ini.
    	
		$searchCleanString = null; 
		$searchCleanType = null;
		$categoryToSearch = array();
		$CategoryToSearchNew = array();
		$CategoryToSearchFinal = array();
		$searchBlockTrimed  = null;
    	$searchResult = array();
		$giftsSet = array();
    	$giftsSetUnique = array();
    	$paramNamedToPass = array();
    	$inputCheck = null;

    	
    	//datas cleaning.
		$this->params = Sanitize::clean( $this->params );    	
																		//to activate late $searchClean = Sanitize::paranoid( ( $this->data['Gift']['string'] ), array(' ',',', '.','-', 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ') );
		//checking of presents of the params for search
    	if( !empty($this->data) ) {
    		$case = 0; 		
    	} elseif ( empty($this->data) && !empty($this->passedArgs) ) {
			$case = 1;
    	} else {
    		// nothing in form, nothing in url, so : $this->render('noresult');
    		$case = 2 ;
    	}

		switch ( $case ) {
			case 0: 
				//echo 'case 0';
    			if ( $this->data['Gift']['string'] != null ) {
    				$searchCleanString = $this->data['Gift']['string'];
    				$paramConditions[] = 'string:'.$searchCleanString;
    				$inputCheck = 1;
    			}
    			
    			if ( $this->data['Gift']['type'] != null ) {
    				$searchCleanType = $this->data['Gift']['type'];
    				$paramConditions[] = 'type:'.$searchCleanType;
    				//$inputCheck = 1;
    			}  
    			  				
    			if ( isset($this->data['priceMin']) && $this->data['priceMin'] != null ) {
    				//$this->Gift->set($this->data['priceMin']);
    				if ( is_numeric($this->data['priceMin']) )  {
    					$seachCleanPriceMin = $this->data['priceMin'];
    					$paramConditions[] = 'priceMin:'.$seachCleanPriceMin;
    					$inputCheck = 1;
    				} else {
    					$this->data['priceMin'] = null;
						$this->Session->setFlash( 'Неправильная минимальная цена товара!' );
						$this->redirect( array('controller' => 'Gifts', 'action' => 'extsearch') );	
    				}

    			}
    			
    			if ( isset($this->data['priceMax']) && $this->data['priceMax'] != null ) {
    				if ( is_numeric($this->data['priceMax']) )  {
    					$seachCleanPriceMax = $this->data['priceMax'];
    					$paramConditions[] = 'priceMax:'.$seachCleanPriceMax;
    					$inputCheck = 1;
    				} else {
    					$this->data['priceMax'] = null;
						$this->Session->setFlash( 'Неправильная максимальная цена товара!' );
						$this->redirect( array('controller' => 'Gifts', 'action' => 'extsearch') );	
    				}
    			}   			

    			if ( isset($this->data['priceOrder']) && $this->data['priceOrder'] != null ) {
    				$seachCleanPriceOrder = $this->data['priceOrder'];
    				$paramConditions[] = 'sort:Gift.price/direction:'.$seachCleanPriceOrder;
    				//sort:name/direction:asc
    				$this->paginate['Gift']['order']['price'] = $seachCleanPriceOrder;
    				$this->paginate['Gift']['limit'] = 9;
    			}    			
    			 			
    			$categoryToSearch = array();// Making array of selected categories
    			if ( isset($this->data['Checkbox']['oasisBG']) && $this->data['Checkbox']['oasisBG'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['oasisBG'];
    				$searchCleanOasisBG = $this->data['Cat']['oasisBG'];
    				$paramConditions[] = 'oasisBG:'.$searchCleanOasisBG;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['oasisEX']) && $this->data['Checkbox']['oasisEX'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['oasisEX'];
    				$searchCleanOasisEX = $this->data['Cat']['oasisEX'];
    				$paramConditions[] = 'oasisEX:'.$searchCleanOasisEX;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['penoteka']) && $this->data['Checkbox']['penoteka'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['penoteka'];
    				$searchCleanPenoteka = $this->data['Cat']['penoteka'];
    				$paramConditions[] = 'penoteka:'.$searchCleanPenoteka;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['ferre']) && $this->data['Checkbox']['ferre'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['ferre'];
    				$searchCleanFerre = $this->data['Cat']['ferre'];
    				$paramConditions[] = 'ferre:'.$searchCleanFerre;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['15days']) && $this->data['Checkbox']['15days'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['15days'];
    				$searchClean15days = $this->data['Cat']['15days'];
    				$paramConditions[] = '15days:'.$searchClean15days;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['proekt111']) && $this->data['Checkbox']['proekt111'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['proekt111'];
    				$searchCleanProekt111 = $this->data['Cat']['proekt111'];
    				$paramConditions[] = 'proekt111:'.$searchCleanProekt111;
    				$inputCheck = 1;
    			}
    			if ( isset($this->data['Checkbox']['usb']) && $this->data['Checkbox']['usb'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['usb'];
    				$searchCleanUsb = $this->data['Cat']['usb'];
    				$paramConditions[] = 'usb:'.$searchCleanUsb;
    				$inputCheck = 1;
    			} 
    			if ( isset($this->data['Checkbox']['toys']) && $this->data['Checkbox']['toys'] == 1 ) {
    				$categoryToSearch[] = $this->data['Cat']['toys'];
    				$searchCleanToys = $this->data['Cat']['toys'];
    				$paramConditions[] = 'toys:'.$searchCleanToys;
    				$inputCheck = 1;
    			}
    			//rendering the nessesary view 
    			if ($inputCheck == null) {
					//$renderOuput = 'extsearch';
					$this->Session->setFlash( 'Вы не ввели ни одного параметра!' );
					$this->redirect( array('controller' => 'Gifts', 'action' => 'extsearch') );	
    			} 			   			
    			$renderOuput = 'search';   			
    			debug($paramConditions);
    			$this->set('toSearch', $paramConditions );
				break;
			case 1: 
				//echo 'case 1';
				
				if ( isset($this->params['named']['string']) ) {
					$searchCleanString = $this->params['named']['string'];
					$paramNamedToPass['string'] =  $this->params['named']['string']; 
				}
				
				if ( isset($this->params['named']['type']) ) {
					$searchCleanType = $this->params['named']['type'];
					$paramNamedToPass['type'] =  $this->params['named']['type']; 
				}
				
				if ( isset($this->params['named']['priceMin']) ) {
					$seachCleanPriceMin = $this->params['named']['priceMin'];
					$paramNamedToPass['priceMin'] =  $this->params['named']['priceMin'];
				}

				if ( isset($this->params['named']['priceMax']) ) {
					$seachCleanPriceMax = $this->params['named']['priceMax'];
					$paramNamedToPass['priceMax'] =  $this->params['named']['priceMax'];
				}


				
				if (isset($this->params['named']['oasisBG']) ) {
					$categoryToSearch[] = $this->params['named']['oasisBG'];
					$paramNamedToPass['oasisBG'] =  $this->params['named']['oasisBG'];
				}
				if ( isset($this->params['named']['oasisEX']) ) {
					$categoryToSearch[] = $this->params['named']['oasisEX'];
					$paramNamedToPass['oasisEX'] =  $this->params['named']['oasisEX'];
				}
				if ( isset($this->params['named']['penoteka']) ) {
					$categoryToSearch[] = $this->params['named']['penoteka'];
					$paramNamedToPass['penoteka'] =  $this->params['named']['penoteka'];
				}
				if ( isset($this->params['named']['ferre']) ) {
					$categoryToSearch[] = $this->params['named']['ferre'];
					$paramNamedToPass['ferre'] =  $this->params['named']['ferre'];
				}
				if ( isset($this->params['named']['15days']) ) {
					$categoryToSearch[] = $this->params['named']['15days'];
					$paramNamedToPass['15days'] =  $this->params['named']['15days'];
				}
				if ( isset($this->params['named']['proekt111']) ) {
					$categoryToSearch[] = $this->params['named']['proekt111'];
					$paramNamedToPass['proekt111'] =  $this->params['named']['proekt111'];
				}
				if ( isset($this->params['named']['usb']) ) {
					$categoryToSearch[] = $this->params['named']['usb'];
					$paramNamedToPass['usb'] =  $this->params['named']['usb'];
				}
				if ( isset($this->params['named']['toys']) ) {
					$categoryToSearch[] = $this->params['named']['toys'];
					$paramNamedToPass['toys'] =  $this->params['named']['toys'];
				}				

				
				$renderOuput = 'search';
			//To show the values in the input fields.
				$this->data['Gift']['string'] = $searchCleanString;
				$this->data['Gift']['type'] = $searchCleanType;
				
				//debug($paramNamedToPass);
				$this->set('toSearch', $paramNamedToPass );
				break;
			case 2:
				//debug($this->data);
				$renderOuput = 'extsearch';
				$this->redirect( array('controller' => 'Gifts', 'action' => 'extsearch') );			
				break;
		}

		// preparation of the array of the categories for searching
			debug($categoryToSearch);
    		if ( $categoryToSearch != array() ) {
    			foreach($categoryToSearch as $allCategoryToSearch) {
    				
    				if ( in_array($allCategoryToSearch, array(143,137,149,228,210,6 ) ) ) {					
    					$CategoryToSearchNew = $this->Category->children( $allCategoryToSearch, false );
    					foreach( $CategoryToSearchNew as $CategoryToSearchNew2 ) {
    						$CategoryToSearchFinal[] = $CategoryToSearchNew2['Category']['id'];
    					}
    				} else {
    					$CategoryToSearchFinal[] = $allCategoryToSearch;
    				}
    				
    			}
    			//debug($CategoryToSearchFinal);
    			$tt = $this->CategoriesGift->find('all', array( 'conditions' => array('category_id' => $CategoryToSearchFinal) ) );
    			$giftsScope = array(); 
    			if ( $tt != array() ) {
    				foreach ( $tt as $v ) {
    					$temGiff[] = $v['CategoriesGift']['gift_id'];
    				}
    			
    				//debug(count($temGiff));
    				$giftsScope = array_unique($temGiff);//all Gifts id's belong to the selected categories.
    			}
    		} 
    		//debug($giftsScope);	
    		
			//$a =  preg_split("/[\s,]+/" , $searchCleanString );

			//separation cleaned string by the ',';
			$searchBlocks = explode(',', $searchCleanString);
			//Trimming of the search Blocks.
			foreach ( $searchBlocks as $searchBlockTemp ) {			
				if (trim($searchBlockTemp) != null ) {
					$searchBlockTrimed [] = trim($searchBlockTemp);
				}				
			}		
			//cleaning the array. if user add the same  word: ex. 'word,word'
			$searchBlockTrimed = array_unique( (array)$searchBlockTrimed );

			foreach ( $searchBlockTrimed as $searchBlock ) {
				if ( $searchCleanType == 1 ) { //gift's code search mode

					if ( strpos($searchBlock, '.') == (strlen($searchBlock)-1) ) {

						$searchBlock = str_replace('.','',$searchBlock);//cut out the last point if it exists. case the code is corecet, but no extention.

					}
					
					if ( strpos($searchBlock, '.') ) { //we have point, but not at the last position. we take all the extentions

						$this->Gift->recursive = -1;
						$searchResult = $this->Gift->find('all', array( 'conditions' => array( 'Gift.code like' => $searchBlock.'%' ), 'fields' => array('Gift.id', 'Gift.code', 'Gift.name')  ) ) ;						

					} else { // no point in the request.
						
						// looking for the exact code without point
						$this->Gift->recursive = -1;
						$searchResult = $this->Gift->find('all', array( 'conditions' => array( 'Gift.code like' => $searchBlock ), 'fields' => array('Gift.id', 'Gift.code', 'Gift.name')  ) ) ;
							
						if ($searchResult == null ) {//no code without point at the end. User hasn't made a mistake. We add point back and looking again.	
    						$this->Gift->recursive = -1;
    						$searchResult = $this->Gift->find('all', array( 'conditions' => array( 'Gift.code like' => $searchBlock.'.%' ), 'fields' => array('Gift.id', 'Gift.code', 'Gift.name')  ) ) ;
    					}
						
						
						
					}
					
					foreach($searchResult as $giftSet) {
						
						$giftsSet[] = $giftSet['Gift']['id'];
					}

    				
				} else { //case seaching Gifts name.
					$searchLine = null;
					$searchLine2 = array();
					$searchCondFulltext = null;
					$searchCondThreeLetter = null;
					
					//importing stemmer, cutting out the words ends.
					App::import('Vendor', array('Stem','stem') );
					$stemmer = new Lingua_Stem_Ru();
					
					//extracting words out of the search block.
					$words = explode(' ', $searchBlock);
					foreach ( $words as $word ) {
						if ( $word == null ) {
							unset($word);
							continue;
						}
						$word = trim($word);
						$wordLower = mb_strtolower ( $word,'utf8' );
						$wordResult = $stemmer->stem_word($wordLower);
						//debug($wordResult);
						//debug($word);
						if ( mb_strlen($word,'utf8') > 3 ) {
							
							if( $wordResult == $word) {
								$searchLine .='+'.$wordResult;// we haven't cut the end of the word( ex: футбол футболк
							} else {
								$searchLine .='+'.$wordResult.'* ';
							}
						} else {
							$searchLine2[] = $word;
						}
						// AND ( `name` LIKE '% òîï %' OR `name` LIKE 'òîï %' )
					}
					if ( $searchLine2 != null ) {
						$searchCondThreeLetter = " (`name` LIKE '% ".$searchLine2[0]." %' OR `name` LIKE '".$searchLine2[0]."%' )";
						for ($i = 1; $i < count($searchLine2) ; $i++) {
							$searchCondThreeLetter .= " AND ( `name` LIKE '% ".$searchLine2[$i]." %' OR `name` LIKE '".$searchLine2[$i]."%' )";
						}
					}
					//`name` LIKE '%женс%' AND ( `name` LIKE '% топ %' OR `name` LIKE 'топ %' ) And ( `name` LIKE '%син%' or `name` like '%бел%')					
					if ($searchLine != null) {
						$searchCondFulltext = " MATCH (name, material) AGAINST ('".$searchLine."' IN BOOLEAN MODE) ";
					}
					
					if ( $searchCondFulltext != null && $searchCondThreeLetter != null) { 
						$toSearchCond = $searchCondFulltext.' AND '.$searchCondThreeLetter;
					} elseif ($searchCondFulltext != null && $searchCondThreeLetter == null) {
						$toSearchCond = $searchCondFulltext;
					} elseif ($searchCondFulltext == null && $searchCondThreeLetter != null) {
						$toSearchCond = $searchCondThreeLetter;
					} else {
						$toSearchCond = null;
					}

					debug($toSearchCond );
					//adding the rest of conditions: price, order...
					


				}// end of case seaching Gifts name.
			} 
			
			// More conditions preparation
			if ( $searchCleanType == 0 ) {
    				$this->Gift->recursive = -1;
    																						//$searchResult = $this->Gift->find('all', array( 'conditions' => array( " concat(`name`,`material`) LIKE '%ручка%' AND concat(`name`,`material`) LIKE '%рез%' " ), 'fields' => array('Gift.id', 'Gift.code', 'Gift.name')  ) ) ;
    				// Preparation of the final conditions for the pagination
    				$toSerachCondFinal = array();
    				if ( isset($toSearchCond) ) {
    					$toSerachCondFinal = array($toSearchCond);
    				}
    				if ( isset($giftsScope) && $giftsScope != array() ) {
    					$toSerachCondFinal = array_merge($toSerachCondFinal, array('Gift.id' => $giftsScope) );
    				}
    				if (isset($seachCleanPriceMin) && $seachCleanPriceMin != null) {
    					$toSerachCondFinal = array_merge($toSerachCondFinal, array('Gift.price >=' => $seachCleanPriceMin) );
    				}
    				if (isset($seachCleanPriceMax) && $seachCleanPriceMax != null) {
    					$toSerachCondFinal = array_merge($toSerachCondFinal, array('Gift.price <=' => $seachCleanPriceMax) );
    				}
    				//debug($toSerachCondFinal);
    				if ( $toSerachCondFinal != array() ) {
    					$searchResult = $this->Gift->find('all', array( 'conditions' => $toSerachCondFinal, 'fields' => array('Gift.id', 'Gift.code', 'Gift.name', 'Gift.price')  ) ) ;
    				} else {
    					$searchResult = null;
    				}
    				//debug( $searchResult );
    				
    				if ( $searchResult != null ) {// looking if match to whole frase
    					foreach($searchResult as $giftSet) {
    						$giftsSet[] = $giftSet['Gift']['id'];
    					}											
    				} 
			}




			
			$giftsSetUnique = array_unique($giftsSet);// to replace by the condition DINSTINCT			
			$this->Gift->recursive = 1;
 		// the result output.   	
    	if ($giftsSetUnique != array() ) {	
    			
    		$this->set( 'gifts', $this->paginate( 'Gift', array('Gift.id' => $giftsSetUnique ) ) );
    		$renderOuput = 'search';
    	} else {
    		//echo 'hhi';
    		$renderOuput = 'noresult';
    	}
    	$this->render($renderOuput);
    }


//--------------------------------------------------------------------
	function extsearch() {
    	$this->subheaderTitle = 'РАСШИРЕННЫЙ ПОИСК';
    	
    	//Oasis Business gifts
    	$OasisBGs = $this->Category->children(143, false );
    	
    	foreach ($OasisBGs as $tempCat) {
    		$OasisBG[143] = 'Поиск по всему каталогу';
    		$OasisBG[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
    	
    	$this->set('OasisBG', $OasisBG);
    	
    	//Oasis Exclusive	
    	$OasisEXs = $this->Category->children(137, false );
   
    	foreach ($OasisEXs as $tempCat) {
    		$OasisEX[137] = 'Поиск по всему каталогу';
    		$OasisEX[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
    	
    	$this->set('OasisEX', $OasisEX);
			
		
    	//Oasis PENOTEKA	
    	$PENOTEKAs = $this->Category->children(149, true );
    	
    	foreach ($PENOTEKAs as $tempCat) {
    		$PENOTEKA[149] = 'Поиск по всему каталогу';
    		$PENOTEKA[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
    	
    	$this->set('PENOTEKA', $PENOTEKA);
    	
    	//Oasis FERRE	
    	$FERREs = $this->Category->children(228, true );
    	$FERRE[228] = 'Поиск по всему каталогу';
    	foreach ($FERREs as $tempCat) {  		
    		$FERRE[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
   
    	$this->set('FERRE', $FERRE);			
	
    	//Oasis 15days	
    	$days15s = $this->Category->children( 210, true );
    	
    	foreach ($days15s as $tempCat) {
    		$days15[210] = 'Поиск по всему каталогу';
    		$days15[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
    	
    	$this->set('days15', $days15);
    	
    	//Oasis proekt111	
    	$proekt111s = $this->Category->children( 6, true );
    	
    	foreach ($proekt111s as $tempCat) {
    		$proekt111[6] = 'Поиск по всему каталогу';
    		$proekt111[ $tempCat['Category']['id'] ] = $tempCat['Category']['description'];
    	}
    	
    	$this->set('proekt111', $proekt111);
		
		
	}
}

?>
