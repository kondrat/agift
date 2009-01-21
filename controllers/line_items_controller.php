<?php

class LineItemsController extends AppController
{
    var $name = 'LineItems';
	var $uses = array('LineItem', 'Order');

/**
 * add product to shopping cart
 */
	
	function add() {
		$data['order_id'] = $this->Order->cartId($this->Session->read('Config.rand'));
		$data = array_merge($this->data['LineItem'], $data);
		$this->LineItem->addToCart($data);
		$this->redirect(array('controller' => 'products', 'action' => 'show', 'id' => $data['product_id'], 'cart' => 'added'));
	}

/**
 * Update quantities in shopping cart
 * 
 */

    function edit_quantities() {
		$this->LineItem->editQuantities($this->data);
		$this->redirect($_SERVER['HTTP_REFERER']);
    }		


/**
 * Delete product from shopping cart
 * 
 * @param id int
 * The ID field of the order_product to remove.
 */

    function delete($id) {
		$this->LineItem->del($id);
		$this->redirect($_SERVER['HTTP_REFERER']);
    }		

/**
 * Moves products from shopping cart to order.
 *
 * @param $order_id int Order ID
 */

	function convert($order_id) {
		$data = $this->requestAction('/orders/get_products/');
		foreach($data['LineItem'] as $row) {
			$this->_stockControl($row);		
			$this->data['LineItem'] = array_merge(
				$row['Product'],
				$this->_generatedOrderInfo($order_id, $row)
			);
			$this->LineItem->create();
			$this->LineItem->save($this->data);
			unset($this->data);
		}
	}

/**
 * Stock controller
 * Removes stock from the inventory (<code>/subproducts/stock_remove/</code>)
 * @private
 */

	function _stockControl($data) {
		if(Configure::read('Shop.stock_control') == '1') {
			$controller = 'products';
			$array = 'product';
			if(!empty($data['Subproduct']['name'])) {
				$controller = 'subproducts';
				$array = 'subproduct';
			} 
			$this->requestAction($controller . '/stock_remove/' . $data[$array . '_id'] . '/' . $data['quantity']);
		}
	}

/**
 * 
 *
 * @private
 */

	function _generatedOrderInfo($order_id, $data) {
		$subproduct = '';
		if(!empty($data['Subproduct']['name'])) {
			$subproduct = $data['Subproduct']['name'];
		}
		$generated = array(
    		'order_id' => $order_id,
			'product_id' => $data['Product']['id'],
			'product' => $data['Product']['name'],
			'subproduct' => $subproduct,
			'quantity' => $data['quantity'],
			'price' => $data['price']
		);
		return $generated;
	}


/**
 * Adds new product in order.
 *
 * Redirects the user to the <code>/admin/orders/edit</code> view after adding the product.
 *
 * @param $order_id int Order ID
 */

	function admin_add() {
		if (!empty($this->data)) {
            if ($this->LineItem->save($this->data)) {
                $this->redirect('/admin/orders/edit/' . $this->data['LineItem']['order_id']);
            }
        }
	}

/**
 * Adds new product in order.
 *
 * Redirects the user to the <code>/admin/orders/edit</code> view after adding the product.
 *
 * @param $order_id int Order ID
 */

	function admin_edit($id) {
		if (!empty($this->data)) {
            if ($this->LineItem->save($this->data)) {
                $this->redirect('/admin/orders/edit/' . $this->data['LineItem']['order_id']);
            }
        } else {
			$this->data = $data = $this->LineItem->read(null, $id);
			$this->set(compact('data'));
			$this->render('admin_add');
		}
	}


}
?>
