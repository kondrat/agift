<?php
App::import('Sanitize');

class OrdersController extends AppController {

    var $name = 'Orders';
    var $uses = array('Order', 'LineItem', 'Gift', 'Image','FileUpload');
    var $components = array('Email', 'Search', 'shopping', 'FileHandler');
    var $helpers = array('Time');
    var $email;
	var $paginate = array('limit' => 20); 

/**
 * Set up required cart info
 */

	function beforeFilter () {
        $this->Auth->allow('index','view','add', 'logo', 'checkout', 'step2', 'history');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;

		$this->subheaderTitle = 'КОРЗИНА';
	}
	
	//----------------------------------------------------------------
	function index() {
			
		if( $orders = $this->Session->read('Order') ) {
			$i=0;
			foreach( $orders as $order) {
				$output[$i] = $this->Gift->find('first', array('conditions' => array('Gift.id' => $order['item']) ) ) ;
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
	function add() {
		
		$order = array();
		
		if ( !empty($this->params['pass'][0]) ) {//param with the gift id
    		$param = Sanitize::paranoid($this->params['pass'][0]);
    		
    		$paramChecked = $this->Gift->find('first', array('conditions' => array('Gift.id' => $param), 'fields' => array('Gift.id', 'Gift.code'),'contain'=>false ) );
    		//debug($paramChecked);
    		if ( isset($paramChecked['Gift']['id']) && $paramChecked['Gift']['id'] != null ) {
    				$this->shopping->sessionShopping($paramChecked['Gift']['id'], $paramChecked['Gift']['code']);
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
		//debug( $this->params );
		if ( $this->Session->check('Auth.User.id') ) {
			//$historyOrderUser = $this->Order->find('all', array( 'conditions' => array('Order.user_id' => $this->Session->read('Auth.user.id') ) ) );
			if( isset($this->params['named']['file']) ) {
				
				$temp = $this->params['named']['file'];
				
				$logos = $this->FileUpload->find('first', array('conditions' => array('FileUpload.id' => $temp) ) );
				//debug($logos);
				//$file = $this->params['named']['file'].'.pdf';
				
				/*
				header("Content-Disposition: attachment; filename=$file");
				header("Content-Type: application/x-force-download; name=$file");
				readfile(TMP.'uploads'.DS.'today.pdf');
				*/
				
					$filename = $logos['FileUpload']['file_name'];
					$myFile = TMP.'uploads'.DS.$logos['FileUpload']['subdir'].DS.$logos['FileUpload']['file_name'];
				
					$mm_type = $logos['FileUpload']['mime_type'];
				if ( file_exists($myFile)  ) {
					header("Cache-Control: public, must-revalidate");
					header("Pragma: hack");
					header("Content-Type: " . $mm_type.'"');
					header("Content-Length: " .(string)(filesize($myFile)) );
					header('Content-Disposition: attachment; filename="'.$filename.'"');
					header("Content-Transfer-Encoding: binary\n");
				
					readfile($myFile);
				} else {
					$this->Session->setFlash( 'Нету такого файла', 'default', array('class' => null) );
				}
				
				
	
			}
			$this->Order->recursive = 0;
			$this->set( 'historyOrderUser', $this->paginate('Order', array('Order.user_id' => $this->Session->read('Auth.User.id') ) ) );
			
		
		
		} else {
			$this->redirect( $this->Auth->redirect() );
		}
	}

    /**
     * handle upload of files and submission info
     */
    function checkout() {
		
			//making session ID for temp user;
			if ( $this->Session->check('userCart.tempSession') == false ) {
				$this->Session->write ('userCart.tempSession', $this->Session->read('Config.time') );
			}
			//making temp order ID for unreged user.

			/*
			if ( $this->Session->check('userCart.tempOrderID') == false  ) {
			
				if ( $this->Session->check('Auth.user.id') != false ) {
					$tempOrderID = $this->Order->currentOrder($this->Session->read('Auth.user.id'), null, $this->RequestHandler->getClientIP() );
				} else {
					$tempOrderID = $this->Order->currentOrder(null, $this->Session->read('userCart.tempSession'), $this->RequestHandler->getClientIP() );				
				}
				
				$this->Session->write('userCart.tempOrderID', $tempOrderID);
			}
			*/
				
	
			

		
			
			//form prossessing
			if ( !empty($this->data) && $this->Session->check('Order') ) {
				//basic data cleaning	
				$dataToWorkClean = Sanitize::clean( $this->params );
				//debug($dataToWorkClean);
				//Updating the ammount of orders pre item. if 0 - deleting the item form the list
				$this->__orderUpdate($dataToWorkClean['data']['Orders']);


				if ( isset($this->params['form']['checkout']) && $this->Session->check('Auth.User.id') ) {// reged user, so final for order
				
						//$this->data['Order']['status'] = 2;
						$this->data['Order']['user_id'] = $this->Auth->user('id');
						//$this->data['Order']['addInfo'] = $this->Session->read('userCart.addInfo');
						$this->Order->create();
						if ( $this->Order->save($this->data['Order']) ) {
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
									$this->redirect('/',null,true);
								}
							} else {
								$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
								$this->redirect('/');
							}

							$this->Session->del('Order');
        					$this->Session->del('userCart');
						} else {
							$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
							$this->redirect( $this->referer(),null,true );
						}
					//}
					//$this->render('success');
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
                    if ( $this->Session->check('userCart.tempOrderID') ) {
                    	$dbFields = array('order_id'  => $this->Session->read('userCart.tempOrderID') );
                	} else {
                		
                		
                    	$dbFields = array();
                    }
        
                    // set the upload directory
                    //$uploadDir = realpath(TMP);
                    $uploadDir = TMP. 'uploads' . DS;
                    //$uploadDir = 'c:'.DS.'x';
        
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
                        
                        
                        //echo 'upload succeeded';
                        //$this->set('uploadData', $this->FileHandler->getLastUploadData());
         				$this->Session->setFlash("Логотип загружен",'default', array('class' => 'nomargin flash'));
                        $this->redirect( array('action' => 'index') );
                    } else {
                        //echo 'upload failed';
                        $this->Session->setFlash("Файл не был загружен",'default', array('class' => 'nomargin flash'));
                        $this->set('errorMessage', $this->FileHandler->errorMessage);
                        $this->redirect( array('action' => 'index') );
                        
                    }
        			//$this->Session->setFlash("Логотип не загружен",'default', array('class' => 'nomargin flash'));
                    //$this->set('errorMessage', $this->FileHandler->errorMessage);
                    //$this->redirect( array('action' => 'index') );
                } //upload 
  
			}
			
    }//checkout
    //----------------------------------------------------------------
    //checkout for unreged user.
	function step2() {
		if ( !empty($this->data) && isset($this->params['form']['next_step']) ) {
			//debug($this->data);
			$this->data['Order']['addInfo'] = $this->Session->read('userCart.addInfo');
			$this->data['Order']['id'] = $this->Session->read('userCart.tempOrderID');
			$this->data['Order']['status'] = 2;
			
			if ( $orderId = $this->Order->find('first', array('conditions' => array('Order.session_id' => $this->Session->read('userCart.tempSession'), 'Order.status' => 1 ) ) ) ) {
				
				if ( $this->Order->save($this->data['Order']) ) {
					$forEmailLineItems = $this->LineItem->saveLineItems( $this->Session->read('Order'),$orderId['Order']['id'] );
					$this->Session->del('Order');
					$this->Session->del('userCart');							
					
					if($forEmailLineItems != array() ) {
						$this->__sendOrderEmail($forEmailLineItems, null, $this->RequestHandler->getClientIP() );
						$this->Session->del('Order');
						$this->Session->del('userCart');
						$this->Session->setFlash( 'Заказ был успешно сформирован', 'default', array('class' => null) );
						$this->redirect('/');
						
						//$this->render('success');
					} else {
						$this->Session->setFlash( 'Заказ не был сформирован', 'default', array('class' => null) );
						$this->redirect( '/' );
					}


				} else {
					//echo 'Order wasn\'t saved';
					$this->render('checkout');
				}
			}				
			//To save line Items , to kill all the session info;
			//krome temp session Id.
		}
	}
//--------------------------------------------------------------------
	function view($id = null) {
		$orderToShow = $this->Order->find('first', array('conditions' => array('Order.id' => $id) ) );
		$this->set('orderToShow', $orderToShow);
		
	}
//--------------------------------------------------------------------
	function __orderUpdate( $dataToWork = array() ) {
		//Additional user's info block
		if ( $dataToWork['addInfo'] != null ) {
			$this->Session->write('userCart.addInfo', $dataToWork['addInfo'] );
		}
		//order update
		if ($dataToWork['lineItemQty']) {
			//debug($dataToWork['lineItemQty']);
			$i = 0;
			foreach($dataToWork['lineItemQty'] as $k => $v ) {						
				$newOrder[$i]['item'] = $k;
				$newOrder[$i]['qty'] = $v;
				if ( $v == 0 || $k == 0) {
					unset ($newOrder[$i]) ;
				}
				$i++;
			
			}
			$this->Session->write('Order', $newOrder);
			$this->Session->write('userCart.countTempOrders', count($newOrder) );
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
/**
 * Lists all orders in the administrator page.
 *
 * Uses the PaginationComponent class to do the pagination.
 */
 /*
    function admin_index() {
		$data = $this->paginate('Order', array('session' => ''));
		foreach($data as $key => $row) {		
			$data[$key] = $this->Order->countTotal($row);
		}
		$this->set(compact('data')); 
    }
*/
/**
 *
 */
/*
    function admin_search($keywords = '') {
		$keywords = $this->params['url']['keywords'];
		$searchFields = array('Order.email', 'Order.firstname', 'Order.lastname', 'Order.number');
		$data = $this->Search->query($this->Order, $keywords, $searchFields, ANY, ANYWHERE, '*', 500);
		$this->set(compact('data'));
    }
*/
/**
 * Edit order
 *
 */
/* 
    function admin_edit($id) {
		$this->data = $data = $this->Order->finalized($id);
		$this->set(compact('data'));
    }
*/
/**
 * View order.
 *
 *
 * @param $id int Order ID. This is the ID of the order to edit.
 */

/*
    function admin_view($id) {
		$this->data = $data = $this->Order->finalized($id);
		$this->set(compact('data'));
    }
*/

/**
 * Get cart contents with totals
 */
/*
	function cart_contents () {
		$dataTemp = $this->Order->fullBySession($this->Session->read('Config.rand'));
		if($dataTemp) {
			$data = $this->totals($dataTemp);
			return $data;
		}
	}
*/
/**
 * Show shopping cart page
 */
/*
	function show () {
		$data = $this->cart_contents();
		$this->set(compact('data'));
	}
*/
/**
 * add totals to shopping cart contents
 */
/*
	function totals($data) {
		$checkout = $this->Session->read('Order');
		$dataTemp['Order'] = array(
			'shipping_price' => $this->ShippingMethod->getQuote($checkout['shipping_method_id'], $data),
			'payment_price' => $this->PaymentMethod->getQuote($checkout['payment_method_id']),
		);
		$data['Order']['shipping_handling'] = $dataTemp['Order']['shipping_price'] + $dataTemp['Order']['payment_price'];
		$data['Order']['total'] = $data['Order']['shipping_handling'] + $data['Order']['subtotal'];
		$data = array_merge($dataTemp, $data);
		return $data;
    }
*/
/**
 * show checkout page
 */
/*
	function checkout($id = false) {
		$httpsUrl = Configure::read('Site.https_url');
		if(!empty($httpsUrl)) {
			$this->redirect($httpsUrl . '/orders/checkout/');
		}
		if (!empty($this->data)) {
			$this->Session->del('Order');
			$this->Session->write('Order', $this->data['Order']);
			$action = 'process';
			if(isset($_POST['verify'])) {
				$action = 'checkout';
				$this->redirect(array('action' => $action));
			} else {
				if($this->data['Order']['same'] == '1') {
					$this->__billingToShipping();
				}
				$this->__refreshOrder();
				$this->process();
			}
			
		} else {
			$this->_indexVariables();
		}
    }
*/
/**
 * Set view variables for checkout page
 */
/* 
	function _indexVariables() {
		$this->data['Order'] = $this->Session->read('Order');
		$data = $this->cart_contents();
		if($data) {
			$countries = $this->Country->find('list', array('conditions' => array('active' => '1')));
			$country = $this->Country->getCountryData($this->data['Order']['country_id']);
			$country['ShippingMethod'] = $this->ShippingMethod->getAllQuotes($country['ShippingMethod'], $data);
			$paymentMethods = $this->PaymentMethod->bsFindAllactive();
			$shippingFields = $this->shippingFields;
			$billingFields = $this->billingFields;
			$this->set(compact('data', 'countries', 'paymentMethods', 'country', 'shippingFields', 'billingFields'));
		} else {
			$this->redirect(array('action' => 'show'));
		}
	}
*/
/**
 * Check where to redirect after submitting the checkout form
 */
/*
	function process() {
		$processor = $this->PaymentMethod->getProcessor($this->Session->read('Order.payment_method_id'));
		$this->redirect(array('plugin' => 'payment', 'controller' => $processor, 'action' => 'index'));
	}
*/
/**
 * Finalize order
 */
/*
	function success() {
		$data = $this->cart_contents();
		if(!empty($data)) {
			$data['Order'] = array_merge($data['Order'], $this->Session->read('Order'));
			$data['Order']['session'] = '';
			$data['Order'] = $this->convert($data['Order']);
			$this->Order->save($data);
			$this->LineItem->convert($data['LineItem']);
			$this->__emailOrder($data['Order']['id']);
			$this->set(compact($data));
		}
	}
*/
/**
 * Finalize order
 */
/*
	function convert($data) {
		if(isset($data['shipping_method_id'])) {
			$this->ShippingMethod->recursive = -1;
			$shipping = $this->ShippingMethod->findById($data['shipping_method_id']);
		}
		if(isset($data['payment_method_id'])) {
			$this->ShippingMethod->recursive = -1;
			$payment = $this->PaymentMethod->findById($data['payment_method_id']);
		}
		$country = $this->Country->findById($data['country_id']);
		$number = $this->Order->find('first', array('order' => 'number DESC'), -1);		
		$order = array(
				'number' => (int)$number['Order']['number'] + 1,
    			'shipping_method' => $shipping['ShippingMethod']['name'],
    			'payment_method' => $payment['PaymentMethod']['name'],
    			'payment_price' => $payment['PaymentMethod']['price'],
    			'shipping_price' => $data['shipping_handling'] - $payment['PaymentMethod']['price'],				
				'country' => $country['Country']['name'],
				'created' => date('Y-m-d H:i:s'),
		);
		return array_merge($data, $order);
	}

*/

/*
	function __billingToShipping() {
		$billingFields = array_merge($this->billingFields, array('country_id'));
		foreach($billingFields as $row) {
			$this->Session->write('Order.s_' . $row, $this->Session->read('Order.' . $row));
		}
	}
*/
}

?>