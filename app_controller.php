<?php
uses('L10n');
class AppController extends Controller {
	var $components      = array('Acl', 'Auth', 'RequestHandler', 'Email', 'Cookie','DebugKit.Toolbar');
    var $helpers         = array('Javascript', 'Html', 'Form', 'Menu', 'Tree');
    var $publicControllers = array('pages', 'test');
    var $uses = array('News', 'Order');
   	var $subheaderTitle = 'Alfa Gifts - сувенирная продукция';
//--------------------------------------------------------------------
	function beforeFilter() {
        if(isset($this->Auth)) {
        	
        	if( is_null($this->Auth->User() ) ) {
        		$cookie = $this->Cookie->read('Auth.User');
        		
				if (!is_null($cookie)) {
					//debug($cookie);
					if ($this->Auth->login($cookie)) {
					//  Clear auth message, just in case we use it.
						$this->Session->del('Message.auth');
						$this->redirect('/users/index');
					} else { // Delete invalid Cookie
						$this->Cookie->del('Auth.User');
					}
				}
			}
								
            if($this->viewPath == 'pages') {
                $this->Auth->allow('*');
            } else {
                $this->Auth->authorize = 'actions';
	            if ( in_array( low($this->params['controller']), $this->publicControllers) ) {
                	$this->Auth->allow('*');	
                }
            }
        } 
		
		//$this->Auth->actionPath = 'controllers/';

	}
//--------------------------------------------------------------------

	function beforeRender() {
		$a = $this->News->find('all', array( 'conditions' => array(), 'order' => array( 'News.created' => 'desc'), 'limit' => 2 ) );
		//debug($a);		
		$this->set('twoNews', $a );
		
		//title for subheader. default Alfa gifts
		$this->set('subheaderTitle', $this->subheaderTitle);
		
		//set count orders for reged User
		if ($currentUser =$this->Session->read('Auth.User.id') ) {
			$this->Order->recursive = -1;
			$currentOrder = $this->Order->find('first', array( 'conditions' => array('Order.user_id' => $currentUser, 'Order.status' => 1) ) );
			//debug($currentOrder);
			if( isset($currentOrder['Order']['line_item_count']) && $currentOrder['Order']['line_item_count'] > 0 ) {
				$this->set('currentOrderTotal', $currentOrder['Order']['line_item_count'] );
			}
		}
		
		if (Configure::read('debug') == 0){
		                        @ob_start ('ob_gzhandler');
		                        header('Content-type: text/html; charset: UTF-8');
		                        header('Cache-Control: must-revalidate');
		                        $offset = -1;
		                        $ExpStr = "Expires: " .gmdate('D, d M Y H:i:s',time() + $offset) .' GMT';
		                        header($ExpStr);
		                } 
		


	}


//--------------------------------------------------------------------

}
?>