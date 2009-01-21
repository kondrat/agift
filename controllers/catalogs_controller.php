<?php
class CatalogsController extends AppController {
	var $name = 'Catalog';
	var $uses = array('Category');
//--------------------------------------------------------------------	
  	function beforeFilter() {
        $this->Auth->allow('index','add','view');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
    }
//--------------------------------------------------------------------
    function index(){
   		$this->data = $this->Category->generatetreelist(null, null, null, '&nbsp;&nbsp;&nbsp;');
       	debug ($this->data);
       // $parents = $this->Category->getpath(23);
        //debug($parents);

       	 die;  
    }

	function add(){
		$data['Category']['parent_id'] =  1;
		$data['Category']['name'] =  'softtoys';
		$this->Category->save($data);
		$this->redirect('index');
	}

	function delete( $id = null){

	}

	function edit( $id = null ){
	}

	function view( $id = null){
	}


}

?>