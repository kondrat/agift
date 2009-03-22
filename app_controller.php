<?php
class AppController extends Controller {
	var $components      = array( 'Auth', 'RequestHandler', 'Email', 'Cookie','DebugKit.Toolbar');
    var $helpers         = array('Javascript', 'Html', 'Form', 'Menu', 'Tree', 'Cache');
    var $publicControllers = array('pages', 'test');
   // var $uses = array('Order');
   	var $subheaderTitle = 'Alfa Gifts - сувенирная продукция';
	var $persistModel = true;
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
                $this->Auth->authorize = 'controller';
	            if ( in_array( low($this->params['controller']), $this->publicControllers) ) {
                	$this->Auth->allow('*');	
                }
            }
        } 

		
		
	}
	
		function isAuthorized() {
		    if ($this->Auth->user('group_id') == '1') {
		        return true;
		    } else {
		        return false;
		    }
			return true;
		}

//--------------------------------------------------------------------

	function beforeRender() {
		//title for subheader. default Alfa gifts
		$this->set('subheaderTitle', $this->subheaderTitle);
		

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