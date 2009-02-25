<?php
class shoppingComponent extends Object {
// Shopping of unregistered User.
	//var $controller = null;
	var $components = array('Session');
	//var $uses = array('Order');
	
	function startup(&$controller) {
		$this->controller = $controller;
	}

	function sessionShopping($giftID = null, $giftCode = null) {
		//writing current order.
			$currentGift[0]['item'] = $giftID;
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

}
?>