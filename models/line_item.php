<?php
class LineItem extends AppModel {
    var $name = 'LineItem';
    var $belongsTo = array('Order'=> array('className'=> 'Order', 'counterCache' => true ),
    						'Gift' => array('className'=> 'Gift') 
    					);

	var $actsAs = array('Containable');
//--------------------------------------------------------------------
	function saveLineItems( $items = array(), $orderId = null ) {
		$i = 0;
		foreach( $items as $item ) {
			
 			$this->data['LineItem']['quantity'] = $item['qty'];
 			$this->data['LineItem']['gift_id'] = $item['item'];
 			$this->data['LineItem']['price'] = $item['price'];
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


}
?>