<?php

class Order extends AppModel {

    var $name = 'Order';
	var $hasMany = array('LineItem' =>
	                   		array('className' => 'LineItem',
							'dependent' =>  true),
						'FileUpload' =>
	                   		array('className' => 'FileUpload',
	                   		'dependent'=> true),
						);

	var $actsAs = array('Containable');
	var $validate = array(
							
							'firstname' => array( 
												/*
												'alphaNumeric' => array( 
																		'rule' => 'alphaNumeric',
																		'required' => true,
																		'message' => 'Только буквы и цифры'
																		),
												*/
												'betweenRus' => array(
																	'rule' => array( 'betweenRus', 3, 15, 'firstname'),
																	'message' => 'От 3 до 15 букв'
																	),
												),
							'phone' => array(
												/*
												'phone' => array( 
														
															'rule' => array('phone', '/\((\d{3,5})\)?[-. ]?(\d{3}[-. ]?\d{2}[-. ]?\d{2})/'),
																						'/(?:8|\+7)? ?\(?(\d{3})\)? ?(\d{3})[ -]?(\d{2})[ -]?(\d{2})/'
															'message' => 'Неправильный телефон',
															),
												
												*/
												'between' => array(
																	'rule' => array( 'between', 3, 20),
																	'message' => 'Неправильный телефон'
																	)
											),
							'email' => array( 'email' => array( 
															'rule' => array( 'email', false), //check the validity of the host. to set true.
															'message' => 'Этот Email не существует',
															),
											),
							
						);




//--currnet order create----------------------------------------------
	function currentOrder ($currntUserId = null, $tempSessionId = null, $ip = null) {
		
		$conditions = array();
		//checking if we working with reged user or temp user
		if ( $currntUserId != null ) {
			
			$conditions = array('conditions' => array('Order.user_id' => $currntUserId, 'Order.status' => 1) );
			
		} elseif ($currntUserId == null && $tempSessionId != null) {
			$conditions = array('conditions' => array('Order.session_id' => $tempSessionId, 'Order.status' => 1) );
		}
		//debug($tempSessionId);
		$currntOrderId = false;//value to return
		$currentOrder = array();
		$currentOrder = $this->find('first', $conditions );
		//debug($currentOrder);
		if ( ($currntUserId != null || $tempSessionId != null) && $currentOrder == null ) {
    		// we have user but we haven't yet active order, so new current order
			$this->data['Order']['user_id'] =  $currntUserId;
			$this->data['Order']['session_id'] =  $tempSessionId;
			$this->data['Order']['ip'] = $ip;
    		$this->data['Order']['status'] = 1;
    		//$this->create();
    		if ( $this->save($this->data['Order'], false) ) {
    			$currntOrderId = $this->getLastInsertID();
    		}
    	} elseif ( ($currntUserId != null || $tempSessionId != null) && $currentOrder != null) {
    		$currntOrderId = $currentOrder['Order']['id'];
    	}
    		return $currntOrderId;
	}
	
//--------------------------------------------------------------------
	function betweenRus($data, $min, $max, $key) {
		//debug($data);
		$length = mb_strlen($data[$key], 'utf8');

		if ($length >= $min && $length <= $max) {
			return true;
		} else {
			return false;
		}
	}
//--------------------------------------------------------------------	
	function beforedelete () {
		
		$orderToDel = array();
		$orderToDel = $this->find('first',array('conditions'=> array('Order.id'=> $this->id ) ) );
		if ($orderToDel['FileUpload'] != array() ) {
			foreach ($orderToDel['FileUpload'] as $v) {
				if( $v != array() && isset($v['id']) && $v['id'] != null ) {
					//debug($orderToDel);
					//$myFile = TMP.'uploads'.DS.$orderToDel['FileUpload']['subdir'].DS.$orderToDel['FileUpload']['file_name'];
					$directory = TMP.'uploads'.DS.$v['subdir'];
					$this->__recursive_remove_directory($directory);
				}
			}
		}
		return true;
	}

	function __recursive_remove_directory($directory, $empty=FALSE) {
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/') {
			$directory = substr($directory,0,-1);
		}

		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory)) {
			// ... we return false and exit the function
			return FALSE;
		// ... if the path is not readable
		}elseif(!is_readable($directory)) {
			// ... we return false and exit the function
			return FALSE;
			// ... else if the path is readable
		}else{
			// we open the directory
			$handle = opendir($directory);
			// and scan through the items inside
			while (FALSE !== ($item = readdir($handle))) {
				// if the filepointer is not the current directory
				// or the parent directory
				if($item != '.' && $item != '..') {
					// we build the new path to delete
					$path = $directory.'/'.$item;
					// if the new path is a directory
					if(is_dir($path)) {
						// we call this function with the new path
						recursive_remove_directory($path);
						// if the new path is a file
					}else{
							// we remove the file
						@unlink($path);
					}
				}
			}
			// close the directory
			closedir($handle);
			// if the option to empty is not set to true
			if($empty == FALSE) {
				// try to delete the now empty directory
				if(!rmdir($directory)) {
				// return false if not possible
					return FALSE;
				}
			}
			// return success
			return TRUE;
		}
	}
/**
 * get cart id by session. if no existing cart, make a new one
 */
/*
	function cartId($session) {
		$data = $this->findBySession($session);
		if($data) {
			return $data['Order']['id'];
		} else {
			$this->data['Order']['session'] = $session;
			$this->save($this->data);
			return $this->getLastInsertID();
		}
	}

*/
/**
 * Get full cart contents by session
 */
/*
	function fullBySession($session) {
		$base = $this->find('first', array('conditions' => array('session' => $session), 'recursive' => 3));
		$data = $this->totals($base);
		return $data;
	}

*/
/**
 * Add totals to order and line items
 */
/*
	function totals($data){
		if(!empty($data['Order'])) {
			$data['Order']['subtotal'] = '';
			$data['Order']['weight'] = '';
			$data['Order']['quantity'] = '';
		}		
		if(!empty($data['LineItem'])) {
			$data = $this->stock($data);
			$data = $this->price($data);
			$data = $this->weight($data);
		}
		return $data;
	}
*/
/**
 * Strip tags to prevent XSS attacks
 */
/*
	function beforeSave() {
		foreach ($this->data['Order'] as $key => $row) {
			$this->data['Order'][$key] = strip_tags($row);
		}
		return true;
	}
*/
/**
 * Count quantity for line items
 */
/*
	function stock($data){
		foreach($data['LineItem'] as $key => $row) {
			$out_of_stock = false;
			if (!empty($row['Subproduct'])) { 
				$quantity = $row['Subproduct']['quantity'];
	        } else {
				$quantity = $row['Product']['quantity'];
	        }
			 if ($row['quantity'] > $quantity) {
				$out_of_stock = true;
				$data['Order']['error'] = 'quantity';
			}
			$data['LineItem'][$key]['out_of_stock'] = $out_of_stock;
			$data['LineItem'][$key]['quantity_available'] = $quantity;
			$data['Order']['quantity'] += $row['quantity'];
		}
		return $data;
	}
*/
/**
 * Count price for line items
 */
/*
	function price($data){
		foreach($data['LineItem'] as $key => $row) {
			if ($row['Product']['special_price'] > 0) { 
				$price = $row['Product']['special_price'];
	        } else {
				$price = $row['Product']['price'];
	        }
			if (!empty($row['Subproduct'])) {
				if($row['Subproduct']['price'] != 0) {
					$price = $row['Subproduct']['price'];
				}
	        }
			$data['LineItem'][$key]['price'] = $price;
			$data['LineItem'][$key]['subtotal'] = $row['quantity'] * $price;
			$data['Order']['subtotal'] += $row['quantity'] * $price;
		}
		return $data;
	}
*/
/**
 * Count weight for line items
 */
/*
	function weight($data){
		foreach($data['LineItem'] as $key => $row) {
			$weight = $row['Product']['weight'];
			if (!empty($row['Subproduct'])) {
				if($row['Subproduct']['weight'] != 0) {
					$weight = $row['Subproduct']['weight'];
				}
	        }
			$data['LineItem'][$key]['weight'] = $weight;
			$data['Order']['weight'] += $row['quantity'] * $weight;
		}
		return $data;
	}
*/
/**
 *
 */
/*
	function afterFind($result){
		if(!empty($result[0]['Order']['id'])){
			foreach ($result as $key => $row) {
				if(empty($result[$key]['Order']['name'])) {
					$result[$key]['Order']['name'] = $result[$key]['Order']['firstname'] . ' ' . $result[$key]['Order']['lastname']; 
					$result[$key]['Order']['s_name'] = $result[$key]['Order']['s_firstname'] . ' ' . $result[$key]['Order']['s_lastname']; 
				}
			}
		}
		return $result;
	}
*/

/**
 * After find combine and count results to create pseudo fields
 */
/*
	function finalized($id){
		$data = $this->read(null, $id);
		if(!empty($data['Order']['id'])){
			$data['Order']['handling'] = $data['Order']['shipping_price'] + $data['Order']['payment_price'];
			$data['Order']['subtotal'] = ''; 
			
			if(!empty($data['LineItem'])) {
				foreach ($data['LineItem'] as $key2 => $row2) {
					$data['Order']['subtotal'] += $row2['price'] * $row2['quantity'];
					$data['LineItem'][$key2]['total'] = $data['LineItem'][$key2]['price'] * $data['LineItem'][$key2]['quantity'];
					$name = $row2['product'];
					if(!empty($row2['subproduct'])) {
						$name .= ' (' . $row2['subproduct'] . ')';
					}
					$data['LineItem'][$key2]['name'] = $name;
				}
			}
//EOF Refactor to new function

			$data['Order']['total_ex'] = $data['Order']['subtotal'] + $data['Order']['handling']; 
			$data['Order']['tax'] = $data['Order']['state_tax'] * $data['Order']['total_ex']; 
			$data['Order']['total'] = $data['Order']['total_ex'] + ($data['Order']['state_tax'] * $data['Order']['total_ex']); 
			$data['Order']['name'] = $data['Order']['firstname'] . ' ' . $data['Order']['lastname']; 
			$data['Order']['s_name'] = $data['Order']['s_firstname'] . ' ' . $data['Order']['s_lastname']; 
		}
		return $data;
	}
*/
/**
 * After find combine and count results to create pseudo fields
 */
/*
	function countTotal($data){
		if(!empty($data['Order']['id'])){
			$data['Order']['handling'] = $data['Order']['shipping_price'] + $data['Order']['payment_price'];
			$data['Order']['subtotal'] = ''; 
			
			if(!empty($data['LineItem'])) {
				foreach ($data['LineItem'] as $key2 => $row2) {
					$data['Order']['subtotal'] += $row2['price'] * $row2['quantity'];
					$data['LineItem'][$key2]['total'] = $data['LineItem'][$key2]['price'] * $data['LineItem'][$key2]['quantity'];
					$name = $row2['product'];
					if(!empty($row2['subproduct'])) {
						$name .= ' (' . $row2['subproduct'] . ')';
					}
					$data['LineItem'][$key2]['name'] = $name;
				}
			}
			$data['Order']['total_ex'] = $data['Order']['subtotal'] + $data['Order']['handling']; 
			$data['Order']['tax'] = $data['Order']['state_tax'] * $data['Order']['total_ex']; 
			$data['Order']['total'] = $data['Order']['total_ex'] + ($data['Order']['state_tax'] * $data['Order']['total_ex']); 
			$data['Order']['name'] = $data['Order']['firstname'] . ' ' . $data['Order']['lastname']; 
			$data['Order']['s_name'] = $data['Order']['s_firstname'] . ' ' . $data['Order']['s_lastname']; 
		}
		return $data;
	}
*/

}
?>