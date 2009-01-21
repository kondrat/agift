<?php
//App::import('Session');
class shoppingComponent extends Object {
// Shopping of unregistered User.
	var $controller = null;
	var $components = array('Session');
	var $uses = array('Order');
	
	function startup(&$controller) {
		$this->controller = $controller;
	}

	function sessionShopping($giftID = null, $giftCode = null) {
        			//writing current order.
            		$this->Session->write( 'userCart.currentGift', $giftID );//setting very firs order in session
            		
            		$currentGift[0]['item'] = $this->Session->read('userCart.currentGift');
            		$currentGift[0]['qty'] = 1;

            		// if we haven't the first order we make it.
            		if ( !$this->Session->check('Order') ) {
            						
            			$this->Session->write('Order', $currentGift);
            			$this->Session->write('userCart.countTempOrders', 1 );
						$this->Session->setFlash( 'Товар '.$giftCode.' добавлен а кoрзину', 'default', array('class' => null) );
						
            		} else {// we adding current order to the existing orders.
            		
            			$totals = $this->Session->read('Order');
            			for ( $i=0; $i < count($totals); $i++ ) {
            				if ( $totals[$i]['item'] == $currentGift[0]['item'] ) {
            					$totals[$i]['qty'] = $totals[$i]['qty'] + 1;
            					unset($currentGift);
            					break;
            				}
            			}
            			
            			if ( isset($currentGift) ) {
            				$order =  array_merge( $currentGift, $totals );
            				$this->Session->setFlash( 'Товар '.$giftCode.' добавлен а кoрзину', 'default', array('class' => null) );
            			} else {
            				$order = $totals;
            				$this->Session->setFlash( 'Товар '.$giftCode.',был в кoрзине, увеличено количество', 'default', array('class' => null) );
            			}
						// creating the final session
            			$this->Session->write('Order', $order);
            			$this->Session->write('userCart.countTempOrders', count($order) );
            			
					}
				
				   
	}
	//----------------------------------------------------------------
	function mergeOrders($tempOrders = array(),$currentUserId = null ) {
		//getting temp order from session
		if ( $tempOrders ) {
		//getting current order ID of reged user
 		$currentOrderId = $this->controller->Order->currentOrder( $currentUserId  );
 			foreach ( $tempOrders as $tempOrder ) {
 				$LineItem = $this->controller->LineItem->find('first',  array( 'conditions' => array( 'LineItem.order_id' => $currentOrderId, 'LineItem.gift_id' => $tempOrder['item'] ) )  );
 
 				if ( $LineItem  ) {
 					$this->controller->LineItem->id = $LineItem['LineItem']['id'];
 					$this->controller->LineItem->saveField('quantity', ($LineItem['LineItem']['quantity'] + $tempOrder['qty']) );
 					//$this->data['LineItem']['id']= $LineItem['LineItem']['id'];
 					//$this->data['LineItem']['quantity'] = $LineItem['LineItem']['quantity'] + $tempOrder['qty'];
 					//$this->data['LineItem']['gift_id'] = 
 					//$this->controller->LineItem->create($this->data);
 					//$this->controller->LineItem->save();
 					$this->controller->LineItem->id = null;
 					//echo 'hi';
 				} else {
 					$this->data['LineItem']['quantity'] =  $tempOrder['qty'];
 					$this->data['LineItem']['gift_id'] = $tempOrder['item'];
 					$this->data['LineItem']['order_id'] = $currentOrderId;
					$this->controller->LineItem->create($this->data);
 					$this->controller->LineItem->save();
 					$this->controller->LineItem->id = null; 									
 				}
 			}
 		$this->Session->del('Order');
 		$this->Session->del('userCart.countOrders');
 		} else {
 			return true;
 		}	
	}
	//----------------------------------------------------------------	
}
?>