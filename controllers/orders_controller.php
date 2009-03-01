<?php
class OrdersController extends AppController {

    var $name = 'Orders';
    var $uses = array('Order', 'LineItem', 'Gift', 'Image','FileUpload');
    var $components = array('Email', 'Search', 'shopping', 'FileHandler');
    var $helpers = array('Time','Number');
    var $email;
	var $paginate = array('limit' => 5); 

/**
 * Set up required cart info
 */

	function beforeFilter () {
        $this->Auth->allow('index','add','clean','history', 'checkout', 'step2');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;

		$this->subheaderTitle = 'КОРЗИНА';
	}
	
	//----------------------------------------------------------------
	function index() {
		$files = array();
		if ( $tempSession = $this->Session->read('userCart.tempSession') ) {
			$files = $this->FileUpload->find('all', array('conditions'=> array('FileUpload.session_id'=> $tempSession ),'fields'=>array('FileUpload.id','FileUpload.file_name'),'contain'=>false ) );
			if ( $files != array() ) {
				$this->set('files' ,$files );
			}
		}
			
		if( $orders = $this->Session->read('Order') ) {
			$i=0;
			foreach( $orders as $order) {
				$output[$i] = $this->Gift->find('first', array('conditions' => array('Gift.id' => $order['item']),'contain'=>'Image.img' ) ) ;
				$output[$i]['LineItem']['quantity'] = $order['qty'];
				$i++;
			}
			// resetting field addinfo if it was set by the user
			$addInfoToSave = $this->Session->read('userCart.addInfo');
			if ( isset($addInfoToSave ) ) {
				$this->set('addInfo', $addInfoToSave );
			}
			
			
			
			$this->set('orders', $output );
			//$this->set('count', count($output) );//to show the in basket items
		} else {
			$this->render('noitem');
		}
		
	}	
	//---------------------------------------------------------------
	function clean($id) {
		if( !is_numeric($id) || !$id ){
			$this->Session->setFlash('Invalid Order');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}

			if ( $orders = $this->Session->read('Order') ) {
				foreach( $orders as $k => $order ) {
					if( $order['item'] == $id ) {
						unset($orders[$k]);
						$this->Session->del('Order.'.$k);
					}
				}
				$this->Session->write('userCart.countTempOrders',count($orders) );
				$this->redirect(array('controller'=>'orders','action'=>'index'),null,true);
			}
			$this->redirect(array('controller'=>'pages','action'=>'index'),null,true);
	}
	//---------------------------------------------------------------
	function add() {
		App::import('Sanitize');
		$order = array();
		
		if ( !empty($this->params['pass'][0]) ) {//param with the gift id
    		$param = Sanitize::paranoid($this->params['pass'][0]);
    		
    		$paramChecked = $this->Gift->find('first', array('conditions' => array('Gift.id' => $param), 'fields' => array('Gift.id', 'Gift.code','Gift.price'),'contain'=>false ) );
    		//debug($paramChecked);
    		if ( isset($paramChecked['Gift']['id']) && $paramChecked['Gift']['id'] != null && $paramChecked['Gift']['price'] != null ) {
    				$this->shopping->sessionShopping($paramChecked['Gift']['id'], $paramChecked['Gift']['code'], $paramChecked['Gift']['price']);
					$this->redirect( $this->referer() );  
    		//User want to user param dierctly and wrong param. fuck him/her.
    		} else {
    			$this->Session->setFlash( 'Данный товар в настоящее время отсутствует', 'default', array('class' => null) );
    			$this->redirect( $this->referer() );
    		}
		} else {
			$this->redirect( '/' );
		}
				
	}

	//----------------------------------------------------------------

	function history() {
		$this->subheaderTitle = 'ИСТОРИЯ ЗАКАЗОВ';
		if ( $this->Session->check('Auth.User.id') ) {
			if( isset($this->params['named']['file']) ) {
				
				$temp = $this->params['named']['file'];
				
				$logos = $this->FileUpload->find('first', array('conditions' => array('FileUpload.id' => $temp) ) );
				//debug($logos);					
					$filename = $logos['FileUpload']['file_name'];
					$myFile = TMP.'uploads'.DS.$logos['FileUpload']['subdir'].DS.$logos['FileUpload']['file_name'];				
					$mm_type = $logos['FileUpload']['mime_type'];
					$this->__getFile($myFile,$mm_type,$filename );
								
		}
			$this->paginate['order']['created'] = 'desc';
			if( $this->Auth->user('group_id') > 1 ) {
				$this->Order->recursive = 0;
				$this->set( 'historyOrderUser', $this->paginate('Order', array('Order.user_id' => $this->Session->read('Auth.User.id') ) ) );
			} elseif( $this->Auth->user('group_id') == 1 ) {
				$this->Order->recursive = 0;
				$this->set( 'historyOrderUser', $this->paginate() );				
			}
			
		}elseif ( $this->Session->check('userCart.tempSession') && !$this->Auth->user('id') ) {
			if( isset($this->params['named']['file']) ) {
				$temp = $this->params['named']['file'];
				$logos = $this->FileUpload->find('first', array('conditions' => array('FileUpload.id' => $temp,'FileUpload.session_id' => $this->Session->read('userCart.tempSession') ) ) );
				$filename = $logos['FileUpload']['file_name'];
				$myFile = TMP.'uploads'.DS.$logos['FileUpload']['subdir'].DS.$logos['FileUpload']['file_name'];				
				$mm_type = $logos['FileUpload']['mime_type'];
				$this->__getFile($myFile,$mm_type,$filename );
			}
		} else {
			$this->redirect( $this->Auth->redirect() );
		}
	}
	//-------------------------
	function __getFile($myFile,$mm_type,$filename ) {
			/*
			$this->view = 'Media';
			$params = array(
						'id' => $logos['FileUpload']['file_name'],
						'name' => 'example',
						'download' => true,
						'extension' => 'JPG',
						'path' => TMP.'uploads'.DS.$logos['FileUpload']['subdir'].DS.$logos['FileUpload']['file_name'],
						'mimeType' => array('JPG' => 'image/jpeg'),
					);
			$this->set($params);
			*/
		//* old vresion we are using media-view instead
		if ( file_exists($myFile)  ) {
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");
			header("Expires: 0");
			header("Content-Type: " . $mm_type.'"');
			header("Content-Length: " .(string)(filesize($myFile)) );
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header("Content-Transfer-Encoding: binary\n");
			
			readfile($myFile);
			$this->redirect($this->referer(),null, true );
			//*/
		} else {
			$this->Session->setFlash( 'Данный файл был удален', 'default', array('class' => null) );
		}
		
	}
	
	
	//----------------------------------------------------------------
    /**
     * handle upload of files and submission info
     * status 2 - active order
     * status 1 - order made, email wasn't sent.
     */
    function checkout() {
    	App::import('Sanitize');
			//making session ID for temp user;
			if ( $this->Session->check('userCart.tempSession') == false ) {
				$this->Session->write ('userCart.tempSession', $this->Session->read('Config.time') );
			}
			
			//form prossessing
			if ( !empty($this->data) && $this->Session->check('Order') ) {
				//basic data cleaning	
				$dataToWorkClean = Sanitize::clean( $this->params );
				//Updating the ammount of orders pre item. if 0 - deleting the item form the list
				$this->__orderUpdate($dataToWorkClean['data']['Orders']);


				if ( isset($this->params['form']['checkout']) && $this->Session->check('Auth.User.id') ) {  // reged user, so final for order
				
						$this->data['Order']['status'] = 2;
						$this->data['Order']['user_id'] = $this->Auth->user('id');
						$this->data['Order']['ip'] = $this->RequestHandler->getClientIP();
						$this->data['Order']['addInfo'] = $this->Session->read('userCart.addInfo');
						$this->data['Order']['total_price'] = $this->Session->read('userCart.totalPrice');
						$this->Order->create();
						if ( $this->Order->save($this->data['Order'],false) ) {
							$uploaded = array();
							if( $uploaded = $this->Order->FileUpload->find('all',array('conditions'=> array('FileUpload.session_id'=> $this->Session->read('userCart.tempSession')),'fields'=> array('FileUpload.id'),'contain'=>false ) ) ) {
								foreach($uploaded as $v) {
									$this->data['FileUpload']['id'] = $v['FileUpload']['id'];
									$this->data['FileUpload']['order_id'] = $this->Order->id;
									$this->FileUpload->save($this->data['FileUpload']);
									$this->FileUpload->id = null;
								}
							}
							$forEmailLineItems = $this->LineItem->saveLineItems( $this->Session->read('Order'),$this->Order->id );
							$this->Session->del('Order');
        					$this->Session->del('userCart');						
							//debug($forEmailLineItems);
							if($forEmailLineItems != array() ) {
								if ($this->__sendOrderEmail($forEmailLineItems, null, $this->Session->read('Auth.User.id') ) ) {
									$this->Session->setFlash( 'Заказ был успешно сформирован', 'default', array('class' => null) );
									$this->redirect('/');
								} else {
									$this->Session->setFlash( 'Заказ не был сформирован, приносим извинения', 'default', array('class' => null) );
									unset($this->data);
									$this->data['Order']['id'] = $this->Order->id;
									$this->data['Order']['status'] = 1;
									$this->Order->save($this->data,false);
									$this->redirect('/',null,true);
								}
							} else {
								$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
								$this->redirect('/');
							}
 
						} else {
							$this->Session->del('Order');
        					$this->Session->del('userCart');
							$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
							$this->redirect( $this->referer(),null,true );
						}
				}
				
				
				
				//recalculating order number.				
				if( isset($this->params['form']['recalculate'] ) ) {
					$this->redirect( array('action' => 'index'),null, true );
				}//end of number recalculating					

				
				//Logo uploading
                if (  isset($this->params['form']['logo']) ) {
                    // allowed mime types for upload
                    $allowedMime = array( 
                                      'image/jpeg',          // images
                                      'image/pjpeg', 
                                      'image/png', 
                                      'image/gif', 
                                      
                                      'application/pdf',     // pdf
                                      'application/x-pdf', 
                                      'application/acrobat', 
                                      'text/pdf',
                                      'text/x-pdf', 
                                      
                                      'text/plain',          // text
                                      
                                      'application/x-msexcel',          // excel
                                      'application/excel',
                                      'application/x-excel',
                                      'application/vnd.ms-excel',
                                      
                                      'application/postscript',
        							  'application/eps',
        							  'application/x-eps',
        							  'image/eps',
        							  'image/x-eps',
                                );
        
        			
                    // extra database field 
                    if ( $this->Session->check('userCart.tempSession') ) {
                    	$dbFields = array('session_id'  => $this->Session->read('userCart.tempSession') );
                	} else {
                    	$dbFields = array();
                    	$this->Session->setFlash("Файл не был загружен",'default', array('class' => 'nomargin flash'));
                    	$this->redirect( array('action' => 'index'),null,true );
                    }
        
                    // set the upload directory
                    //$uploadDir = realpath(TMP);
                    $uploadDir = TMP. 'uploads' . DS;     
                    // settings for component
                    //$this->FileHandler->setAllowedMime($allowedMime);
                    $this->FileHandler->setDebugLevel(1);
                    $this->FileHandler->setRequired(1);
                    $this->FileHandler->setHandlerType('db');
                    $this->FileHandler->setDbModel('FileUpload');
                    $this->FileHandler->addDbFields($dbFields);
                    $this->FileHandler->setMaxSize(10000);
        
                    if ($this->FileHandler->upload('userfile', $uploadDir)) {
        
                        /* if nothing is submitted and required is set to 0
                         * upload() will return true so you need to handle 
                         * empty uploads in your own way
                         */
                        //$this->set('uploadData', $this->FileHandler->getLastUploadData());
                        //$uploadData = $this->FileHandler->getLastUploadData();
                        
         				$this->Session->setFlash("Логотип загружен",'default', array('class' => 'nomargin flash'));
                        $this->redirect( array('action' => 'index'),null,true );
                    } else {
                        //echo 'upload failed';
                        $this->Session->setFlash("Файл не был загружен",'default', array('class' => 'nomargin flash'));
                        //$this->set('errorMessage', $this->FileHandler->errorMessage);
                        $this->Session->write('userCart.errorMessage', $this->FileHandler->errorMessage);
                        $this->redirect( array('action' => 'index'),null,true );
                        
                    }
                } //upload 
  
			}
			
    }//checkout
    //----------------------------------------------------------------
    //checkout for unreged user.
	function step2() {
		if ( !empty($this->data) && isset($this->params['form']['next_step']) ) {

			$this->data['Order']['addInfo'] = $this->Session->read('userCart.addInfo');
			$this->data['Order']['status'] = 2;
			$this->data['Order']['ip'] = $this->RequestHandler->getClientIP();
			$this->data['Order']['session_id'] = $this->Session->read('userCart.tempSession');
			$this->data['Order']['total_price'] = $this->Session->read('userCart.totalPrice');
			
			if ( $this->Order->save($this->data['Order']) ) {	
					$uploaded = array();
					if( $uploaded = $this->Order->FileUpload->find('all',array('conditions'=> array('FileUpload.session_id'=> $this->Session->read('userCart.tempSession')),'fields'=> array('FileUpload.id'),'contain'=>false ) ) ) {
						foreach($uploaded as $v) {
							$this->data['FileUpload']['id'] = $v['FileUpload']['id'];
							$this->data['FileUpload']['order_id'] = $this->Order->id;
							$this->FileUpload->save($this->data['FileUpload']);
							$this->FileUpload->id = null;
						}
					}
											
				$forEmailLineItems = $this->LineItem->saveLineItems( $this->Session->read('Order'),$this->Order->id );
				$this->Session->del('Order');
				$this->Session->del('userCart');							
				
				if($forEmailLineItems != array() ) {
					if ($this->__sendOrderEmail($forEmailLineItems, null, $this->RequestHandler->getClientIP() ) ) {
						$this->Session->setFlash( 'Заказ был успешно сформирован', 'default', array('class' => null) );
						$this->redirect( '/',null,true ); 
					} else {	 
						$this->Session->setFlash( 'Заказ не был сформирован, приносим извинения', 'default', array('class' => null) );
						unset($this->data);
						$this->data['Order']['id'] = $this->Order->id;
						$this->data['Order']['status'] = 1;
						$this->Order->save($this->data,false);
						$this->redirect('/',null,true);
					}
					
					//$this->render('success');
				} else {
					$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
					$this->redirect( '/',null,true );
				}


			} else {
				$this->Session->del('Order');
        		$this->Session->del('userCart');
				$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
				$this->redirect( '/',null,true );;
				$this->render('checkout');
			}
		}				
	}
//--------------------------------------------------------------------
	function view($id = null) {
		if( !is_numeric($id) || !$id ){
			$this->Session->setFlash('Invalid Order');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}
		
		$this->subheaderTitle = 'ИСТОРИЯ ЗАКАЗОВ';
		$orderToShow  = array();
		if ($this->Auth->user('id')) {
			if($this->Auth->user('group_id') > 1 ) {
				$orderToShow = $this->Order->find('first', array('conditions' => array('Order.id' => $id ,'Order.user_id'=>$this->Auth->user('id')),'contain'=> array('FileUpload','LineItem'=> array('Gift'=> array('Image') ) ) ) );			
			} elseif($this->Auth->user('group_id') == 1) {
				$orderToShow = $this->Order->find('first', array('conditions' => array('Order.id' => $id ),'contain'=> array('FileUpload','LineItem'=> array('Gift'=> array('Image') ) ) ) );			
			}
			if( $orderToShow != array() ) {
				$this->set('orderToShow', $orderToShow);
			} else {
				$this->Session->setFlash('Invalid Order');
				$this->redirect(array('controller'=>'orders','action'=>'history'), null, true);
			}
		}
	}
//--------------------------------------------------------------------
	function __orderUpdate( $dataToWork = array() ) {
		//Additional user's info block
		if ( $dataToWork['addInfo'] != null ) {
			$this->Session->write('userCart.addInfo', $dataToWork['addInfo'] );
		}
		//debug($dataToWork);
		//order update
		if ($dataToWork['lineItem']) {
			foreach($dataToWork['lineItem'] as $k => $v) {
				if ($v['qty']<1) {				
					unset($dataToWork['lineItem'][$k]);
				}
				$totalPrice[] = $v['qty']*$v['price'];
			}
			$this->Session->write('Order', $dataToWork['lineItem']);
			$this->Session->write('userCart.countTempOrders', count($dataToWork['lineItem']) );
			$this->Session->write('userCart.totalPrice', array_sum($totalPrice) );
		}	
	}	
//--------------------------------------------------------------------
    /**
     * Send out an order conformation email to the alfagifts email
     * 	@param Array $forEmailLineItems Order's details.
     *  @param Array $attachment attached logos array.
     *  @param Array $userName name of the customer.
     *  @return Boolean indicates success
    */
    function __sendOrderEmail( $forEmailLineItems = array() , $attachment = array(), $userName = null ) {
    	// Set data for the "view" of the Email
		$this->set('userName', $userName );
		
		if ( $forEmailLineItems != array() ) {			
			$this->set('forEmailLineItems', $forEmailLineItems );
		}
       
        $this->Email->to = 'dep'.'<info@tehnoavia.ru>';
        //$this->Email->to = 'отдел'.'<a_kondrat@tehnoavia.ru>';
        //$this->Email->cc = 'a_kondrat@tehnoavia.ru';
       // $this->Email->bcc = array('info@tehnoavia.ru'); 
        $this->Email->subject = env('SERVER_NAME') . ' - New Order';
        $this->Email->from = 'noreply@' . env('SERVER_NAME');
        $this->Email->template = 'new_order';
        $this->Email->sendAs = 'text';   // you probably want to use both :) 
        $this->Email->attachments = $attachment;
        //$this->Email->delivery = 'debug';  
        return $this->Email->send();
	}   
//-------------------------------------------------------------------- 
  	function isAuthorized() {
        if ($this->action == 'delete' ) {
            if ($this->Auth->user('id')) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
 
//--------------------------------------------------------------------
	function delete ($id) {
		if( !is_numeric($id) || !$id ){
			$this->Session->setFlash('Invalid Order');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}	

			if ($this->Auth->user('group_id') > 1 ) {
				if ( !$this->Order->find('count',array('conditions'=> array('Order.id'=> $id, 'Order.user_id'=> $this->Auth->user('id') ) , 'contain'=>false) ) ) {
					$this->redirect('/',null,true);
				}
			}
			
					
			if($this->Order->del($id) ) {
				$this->Session->setFlash( 'Заказ  был удален', 'default', array('class' => null) );
				$this->redirect($this->referer(),null,true );
			} else {
				$this->Session->setFlash( 'Заказ не был удален', 'default', array('class' => null) );
				$this->redirect($this->referer(),null,true );				
			}
	
	}
//--------------------------------------------------------------------   
/**
 * Lists all orders in the administrator page.
 */
 /*
    function admin_index() {
    }
*/
/**
 *
 */
/*
    function admin_search($keywords = '') {
    }
*/
/**
 * Edit order
 *
 */
/* 
    function admin_edit($id) {
    }
*/
/**
 * View order.
 */

/*
    function admin_view($id) {
    }
*/

}

?>