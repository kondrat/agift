<?php
class CategoriesController extends AppController {
	var $name = 'Categories';
	var $uses = array('Category', 'Gifts', 'Image');
	var $paginate = array('limit' => 9);
//--------------------------------------------------------------------	
  	function beforeFilter() {
        $this->Auth->allow('index','add','view','proekt111', 'oasis', 'usb');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
    }
//--------------------------------------------------------------------
	 function index(){
	 	$this->redirect('/') ;
	}
//--------------------------------------------------------------------
    function proekt111(){
		$this->cacheAction = "10000 hours";
		$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "ПРОЕКТ 111"';
    	//some vars init.
		$cat = array();
		$pageOutput = null;
		$currentCategoryId = array();
		$currentCategoryPass = null;
		$gifts = array();
		$giftsID = null;
		// params preparation
        // 1). Short vars for params. [0] - username, [1] - tagname. might be sanitized
        if ( isset( $this->params['pass'][0] ) ) {
        	$catalogParamID =  strtolower( $this->params['pass'][0] );
        } else {
        	$catalogParamID = null;
        }
		
		// getting id of the current category.
		$currentCategoryId = $this->Category->find('all', array('conditions' => array( 'Category.id' => $catalogParamID ) , 'fields' => array('id'),'contain'=>false ) );

		//getting path to the current category from the root

		if ( $currentCategoryId != null ) {
			$currentCategoryPass = $this->Category->getpath( $currentCategoryId[0]['Category']['id'], array('id') );
		} else {
			//default 
			$currentCategoryId[0]['Category']['id'] = 3;
			$currentCategoryPass[0]['Category']['id'] = 3;
		}
		// menu preparation and creation.	
		foreach( $currentCategoryPass as $val) {
			if ( $val['Category']['id'] >= 3 ) {
				$cat[] = $val['Category']['id'];
			}
		}		
		$id = array('id' => $cat );
		$showMeChildren = true;
		$stuff = $this->Category->children($id, $showMeChildren,array('id','name','description','supplier','parent_id','lft','rght') );
		$this->set('stuff', $stuff);
		
		//main loginc block.------------------------------
		if ( $currentCategoryId[0]['Category']['id'] == 3 ) {
			$case = 0;					
		} elseif ( $currentCategoryId[0]['Category']['id'] == 6 ) {
			$case = 1;		
		} else {
			$case = 2;
		}
						
		switch ($case) {        
       	 case 0:
       	 //CASE 0 main proekt111 page without menu.
       	 	$pageOutput = 'proekt111_main';	
       	 	break;
       	 case 1:
       	 //CASE 1
       	 	$pageOutput = 'proekt111_2008';
       	 	break;
       	 case 2:
       	 //CASE 1 gifts outputing
       	 	$pageOutput = 'proekt111_gifts';
        		if ( isset( $currentCategoryId[0]['Category']['id'] ) && $currentCategoryId[0]['Category']['id'] > 6 ) {
            		$gifts = $this->Category->children( $currentCategoryId[0]['Category']['id'], false,  false, null, null, null, 1, 1 );
            		//if the categori has no children category.
            		if ( $gifts == array() ) {
            			$gifts = $this->Category->find('all', array('conditions' => array('Category.id' => $currentCategoryId[0]['Category']['id'] ),'fields'=>array('id'),'contain'=>'Gift.id' ) );			

            		}
            			   		
        			foreach($gifts as $gift) {
        				foreach( $gift['Gift'] as $gif ) {        
        					if ( $gif != array() ) {
        					 	$giftsID[] = $gif['id']; 
        					}
        				}		
        			}
            	}
            	$this->paginate['contain'] = 'Image.img';
				$this->set( 'gifts', $this->paginate('Gift', array('Gift.id' => $giftsID ) ) ) ;
       	 	break;       	 	
       	}		
		

		
		$this->render($pageOutput);	// rendering the view	
    }
//--------------------------------------------------------------------

    function oasis(){
    	//$this->cacheAction = "10000 hours";
    	//some vars init.
		$cat = array();
		$pageOutput = null;
		$currentCategoryId = array();
		$currentCategoryPass = null;
		$gifts = array();
		$giftsID = null;
		// params preparation
        // 1). Short vars for params. [0] - category, [1] - subcategory
        if ( isset( $this->params['pass'][0] ) ) {
        	$catalogParamID =  strtolower( $this->params['pass'][0] );
        } else {
        	$catalogParamID = null;
        }
		
		// getting id of the current category.
		$currentCategoryId = $this->Category->find('all', array('conditions' => array( 'Category.id' => $catalogParamID ) , 'fields' => array('id'),'contain'=>false ) );
		//getting path to the current category from the root
		if ( $currentCategoryId != null ) {
			$currentCategoryPass = $this->Category->getpath( $currentCategoryId[0]['Category']['id'], array('id') );
			//debug($currentCategoryPass);
		} else {
			//default 
			$currentCategoryId[0]['Category']['id'] = 2;
			$currentCategoryPass[0]['Category']['id'] = 2;
		}
		
		
		// menu preparation and creation.	
		foreach( $currentCategoryPass as $val) {
			if ( $val['Category']['id'] >= 3 ) {
				$cat[] = $val['Category']['id'];
				if ( in_array( $val['Category']['id'] ,array(143,137,210,228,149) ) ) {
					switch($val['Category']['id']) {
						case 143:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "OASIS BUSINESS GIFTS"';
							$case = 1;	
							break;
						case 137:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "OASIS EXCLUSIVE"';
							$case = 1;	
							break;
						case 210:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "15 days"';
							$case = 1;	
							break;
						case 228:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "FERRE"';
							$case = 1;	
							break;
						case 149:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "PENOTEKA"';
							$case = 1;	
							break;
						default:
							$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "OASIS"';
							$case = 1;
							break;						
					}
				}
			}
		}
		if(	$cat != array() ) {	
			$id = array('id' => $cat );
			$showMeChildren = true;
			$stuff = $this->Category->children($id, $showMeChildren,array('id','name','description','supplier','parent_id') );
			$this->set('stuff', $stuff);
		}
		
		
		//main logic block.------------------------------
		if ( $currentCategoryId[0]['Category']['id'] == 2 ) {
			$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "OASIS"';
			$case = 0;					
		} 

		switch ($case) {        
       	 case 0:
       	 //CASE 0 main oasis page without menu.
       	 	$pageOutput = 'oasis_main';	
       	 	break;
 
       	 case 1:
       	 //CASE 1 gifts outputing
       	 	$pageOutput = 'oasis_gifts';
        		if ( isset( $currentCategoryId[0]['Category']['id'] ) && $currentCategoryId[0]['Category']['id'] > 6 ) {
            		$gifts = $this->Category->children( $currentCategoryId[0]['Category']['id'], false,  'id', null, null, 1, 1 );
            		//if the category has no children category.
            		if ( $gifts == array() ) {
            			$gifts = $this->Category->find('all', array('conditions' => array('Category.id' => $currentCategoryId[0]['Category']['id'] ),'fields'=>array('id'),'contain'=>'Gift.id' ) );			
            		}
            		//$giftsID = Set::extract('/Gift/id', $gifts);
            		//debug($results);
            			   		
        			foreach($gifts as $gift) {
        				foreach( $gift['Gift'] as $gif ) {        
        					if ( $gif != array() ) {
        					 	$giftsID[] = $gif['id']; 
        					}
        				}		
        			}
        			
            	}
            	$this->paginate['contain'] = 'Image.img';
				$this->set( 'gifts', $this->paginate('Gift', array('Gift.id' => $giftsID ) ) ) ;
       	 	break;       	 	
       	}		
		

		
		$this->render($pageOutput);	// rendering the view	
    }
//--------------------------------------------------------------------
    function usb(){
    	$this->cacheAction = "10000 hours";
    	//some vars init.
		$cat = array();
		$pageOutput = null;
		$currentCategoryId = array();
		$currentCategoryPass = null;
		$gifts = array();
		$giftsID = null;
		// params preparation
        // 1). Short vars for params. [0] - category, [1] - subcategory
        if ( isset( $this->params['pass'][0] ) ) {
        	$catalogParamID =  strtolower( $this->params['pass'][0] );
        } else {
        	$catalogParamID = null;
        }
		
		// getting id of the current category.
		$currentCategoryId = $this->Category->find('all', array('conditions' => array( 'Category.id' => $catalogParamID ) , 'fields' => array('id') ) );
		//getting path to the current category from the root

		if ( $currentCategoryId != null ) {
			$currentCategoryPass = $this->Category->getpath( $currentCategoryId[0]['Category']['id'], array('id') );
		} else {
			//default 
			$currentCategoryId[0]['Category']['id'] = 4;
			$currentCategoryPass[0]['Category']['id'] = 4;
		}
		
		// menu preparation and creation.	
		foreach( $currentCategoryPass as $val) {
			if ( $val['Category']['id'] >= 3 ) {
				$cat[] = $val['Category']['id'];
			}
		}		
		$id = array('id' => $cat );
		$showMeChildren = true;
		$stuff = $this->Category->children($id, $showMeChildren );
		$this->set('stuff', $stuff);
		
		//main logic block.------------------------------
		if ( $currentCategoryId[0]['Category']['id'] == 4 ) {
			$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "USB"';
			$case = 1;					
		} else {
			$this->subheaderTitle = 'КАТАЛОГ СУВЕНИРОВ "USB"';
			$case = 1;
		}
						
		switch ($case) {        
       	 case 0:
       	 //CASE 0 main oasis page without menu.
       	 	$pageOutput = 'oasis_main';	
       	 	break;
 
       	 case 1:
       	 //CASE 1 gifts outputing
       	 	$pageOutput = 'usb_gifts';
        		if ( isset( $currentCategoryId[0]['Category']['id'] ) && $currentCategoryId[0]['Category']['id'] > 3 ) {
            		$gifts = $this->Category->children( $currentCategoryId[0]['Category']['id'], false,  false, null, null, null, 1, 1 );
            		//if the categori has no children category.
            		if ( $gifts == array() ) {
            			$this->Category->recursive = 2;
            			$gifts = $this->Category->find('all', array('conditions' => array('Category.id' => $currentCategoryId[0]['Category']['id'] ) ) );
            		}
            			   		
        			foreach($gifts as $gift) {
        				foreach( $gift['Gift'] as $gif ) {        
        					if ( $gif != array() ) {
        					 	$giftsID[] = $gif['id']; 
        					}
        				}		
        			}
            	}
				$this->set( 'gifts', $this->paginate('Gift', array('Gift.id' => $giftsID ) ) ) ;
       	 	break;       	 	
       	}		
		

		
		$this->render($pageOutput);	// rendering the view	
    }
//--------------------------------------------------------------------
	function add(){

	}

	function delete( $id = null){

	}

	function edit( $id = null ){
	}

	function view( $id = null){
	}


}

?>