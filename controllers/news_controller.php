<?php
class NewsController extends AppController {
	var $name = 'News';
	var $uses = array('News');
	var $paginate = array('limit' => 5, 'order' => array( 'News.created' => 'desc') );
	//var $uses = array('User');

//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow('view', 'index');
        parent::beforeFilter();
        $this->Auth->autoRedirect = false;
    }
//--------------------------------------------------------------------
    function index(){
		$this->subheaderTitle = 'НОВОСТИ';
		$this->News->recursive = 0;
		$this->set('listNews', $this->paginate());
    }
//--------------------------------------------------------------------
	function add() {
		$this->subheaderTitle = 'НОВОСТИ';
		if (!empty($this->data)) {
			$this->News->create();
			if ($this->News->save($this->data)) {
				$this->Session->setFlash( __('The News has been saved', true) );
				$this->redirect( array('action' => 'index') );
			} else {
				$this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
			}
		}
		//This use for the find('list') if we use smthname instead of name.
		//$this->User->displayField = 'username';
		//$users = $this->User->find('list');
		//$this->set( compact('users') );
	}
//--------------------------------------------------------------------
	function delete($id = null) {
		$this->subheaderTitle = 'НОВОСТИ';
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for News', true));
			$this->redirect( array('action'=>'index') );
		}
		if ($this->News->del($id)) {
			$this->Session->setFlash(__('Product deleted', true));
			$this->redirect( array('action' => 'index') );
		}
	}
//--------------------------------------------------------------------
	function edit($id = null) {
		$this->subheaderTitle = 'НОВОСТИ';
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid News', true));
			$this->redirect( $this->Auth->redirect() );
		}
		if (!empty($this->data)) {
			if ($this->News->save($this->data)) {
				$this->Session->setFlash(__('The News has been edited', true));
				$this->redirect( array('action' => 'index') );
			} else {
				$this->Session->setFlash(__('The PNews could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->News->read(null, $id);
		}
		//$dealers = $this->News->User->find('list');
		//$this->set(compact('dealers'));
	}
//--------------------------------------------------------------------
	function view($id = null) {
		$this->subheaderTitle = 'НОВОСТИ';
		if ( (!$id) ||  ($this->News->read(null, $id) == false ) ) {
			$this->Session->setFlash(__('Invalid News.', true));
			$this->redirect( $this->Auth->redirect() );			
		} else {
			$this->set('news', $this->News->read(null, $id));
			$listNews = $this->News->find('all',array('conditions' => array('News.id <>' => $id), 'limit' => 5, 'order' => array('News.created' => 'desc') ) ); 
			$this->set('listNews', $listNews);
			//$this->set('referer', $this->referer() );
		}
	}
//--------------------------------------------------------------------
}

?>
