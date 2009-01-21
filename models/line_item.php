<?php
class LineItem extends AppModel {
    var $name = 'LineItem';
    var $belongsTo = array('Order'=> array('className'=> 'Order', 'counterCache' => true ),
    						'Gift' => array('className'=> 'Gift') 
    					);


//--------------------------------------------------------------------
	function saveLineItems( $items = array(), $orderId = null ) {
		$i = 0;
		foreach( $items as $item ) {
			if ( isset($item['id']) ) {//mb one day we will edit
 				$this->data['LineItem']['id'] =  $item['id'];
 			}
 			$this->data['LineItem']['quantity'] = $item['qty'];
 			$this->data['LineItem']['gift_id'] = $item['item'];
 			$this->data['LineItem']['order_id'] = $orderId;
 			//debug($this->data);
 			//$this->save( $this->data['LineItem'] );
 			$outPut[$i] = $this->data['LineItem'];
 			if ($this->save( $this->data['LineItem'] ) ) {
 				
 				$this->id = null;
 			}
 			
 			$a = $this->Gift->find('first', array( 'conditions' => array('Gift.id'=> $outPut[$i]['gift_id']) ) ) ;
 			$outPut[$i]['code'] = $a['Gift']['code'];
 			$i++;
		}
		return $outPut;			
	}

/**
 * add product to cart
 *
 * @protected
 */
/*
	function addToCart($data) {
		if(!isset($data['subproduct_id'])) {
			$data['subproduct_id'] = '0';
		}
		if(!isset($data['quantity'])) {
			$data['quantity'] = '1';
		}
		$current_quantity = $this->getQuantity(
			$data['order_id'],
			$data['product_id'],
			$data['subproduct_id']
		);
		$data['quantity'] = $data['quantity'] + $current_quantity;
		
		if($current_quantity > 0) {
			$this->addQuantity(
				$data['order_id'],
				$data['product_id'],
				$data['quantity'],
				$data['subproduct_id']
			);
		} else {
			$this->data['LineItem'] = $data;
			$this->save($this->data);
		}		
	}
*/
/**
 * get quantity of one product in shopping cart
 *
 * @protected
 */
/*
	function getQuantity($order_id, $product_id, $subproduct_id) {
		$data = $this->find('first', 
			array('conditions' => 
				array('order_id' => $order_id,
					'product_id' => $product_id,	
					'subproduct_id' => $subproduct_id
				), 'recursive' => -1));
		if(!$data) {
			return '0';
		} else {
			return $data['LineItem']['quantity'];		
		}		
	}
*/
/**
 * add quantity of an existing product
 * @protected
 */
/*
	function addQuantity($order_id, $product_id, $new_quantity, $subproduct_id) {
		$data = $this->find('first', 
			array('conditions' => 
				array('order_id' => $order_id,
					'product_id' => $product_id,	
					'subproduct_id' => $subproduct_id
				), 'recursive' => -1));
		
		$this->id = $data['LineItem']['id'];
		$this->saveField('quantity', $new_quantity);
	}
*/
/**
 * edit multiple line_item quantities
 */
/*
	function editQuantities($data) {
		foreach ($data['LineItem'] as $row) {
			if($row['quantity'] == 0) {
				$this->del($row['id']);
			} else {
				$this->recursive = -1;
				$this->id = $row['id'];
				$this->saveField('quantity', $row['quantity']);
				
			}
		}
	}
*/
/**
 * 
 */
/*
	function convert($data) {
		foreach ($data as $row) {
			$row['product'] = $row['Product']['name'];
			$row['subproduct'] = $row['Subproduct']['name'];
			$this->save($row);
		}
	}
*/
}
?>