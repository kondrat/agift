<?php
class User extends AppModel {
	var $name = 'User';
//--------------------------------------------------------------------
	var $validate = array(
							'username' => array( 'alphaNumeric' => array( 
																		'rule' => 'alphaNumeric',
																		'required' => true,
																		'message' => 'Только буквы и цифры'
																		),
												'betweenRus' => array(
																	'rule' => array( 'betweenRus', 6, 15, 'username'),
																	'message' => 'От 6 до 15 букв'
																	),
												'checkUnique' => array( 
																		'rule' =>  array('checkUnique', 'username'),
																		'message' => 'Этот логин уже занят'
																	),
												),
																						
							'password1' => array( 'betweenRus' => array(
																	'rule' => array( 'betweenRus', 6, 15,'password1'),
																	'message' => 'От 6 до 15 букв'
																	)
												),
							'password2' => array( 'passidentity' => array(
																		'rule' => array( 'passidentity', '$this->data' ),
																		'message' => 'Пароли не совпадают'
																		)
												),
							
																																							
							'email' => array( 'email' => array( 
															'rule' => array( 'email', false), //check the validity of the host. to set true.
															'message' => 'Этот Email не существует',
															),
												'checkUnique' => array(           
																		'rule' =>  array('checkUnique', 'email'),
																		'message' => 'Этот Email уже занят'
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
																	'rule' => array( 'between', 6, 20),
																	'message' => 'Неправильный телефон'
																	)
											),

							'contact' => array( 'alphaNumeric' => array( 
																		'rule' => 'alphaNumeric',
																		'required' => true,
																		'message' => 'Только буквы и цифры'
																		),
												'betweenRus' => array(
																	'rule' => array( 'betweenRus', 3, 15, 'contact'),
																	'message' => 'От 3 до 15 букв'
																	)
												),
							'company' => array( 'alphaNumeric' => array( 
																		'rule' => array('custom', '/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd} ]+$/mu'),
																		'message' => 'Только буквы и цифры'
																		),
												'betweenRus' => array(
																	'rule' => array( 'betweenRus', 2, 15, 'company'),
																	'message' => 'От 2 до 15 букв'
																	)
												),
							'fax' => array(
												/*
												'phone' => array( 
														
															'rule' => array('phone', '/\((\d{3,5})\)?[-. ]?(\d{3}[-. ]?\d{2}[-. ]?\d{2})/'),
																						'/(?:8|\+7)? ?\(?(\d{3})\)? ?(\d{3})[ -]?(\d{2})[ -]?(\d{2})/'
															'message' => 'Неправильный телефон',
															),
												*/
												
												'between' => array(
																	'rule' => array( 'between', 6, 20),
																	'allowEmpty' => true,
																	'message' => 'Неправильный факс'
																	)
											),	
							'website' => array(
												'rule' => 'url',
												'allowEmpty' => true,
												'message' => 'Неправильный URL'
												),
																										 
						  );
//--------------------------------------------------------------------
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Group' => array('className' => 'Group',
								'foreignKey' => 'group_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => ''
							),
						);

//--------------------------------------------------------------------  
	/*  
    function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!$data['User']['group_id']) {
            return null;
        } else {
            return array('Group' => array('id' => $data['User']['group_id']));
        }
    }
    */

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
	function checkUnique($data, $fieldName) {
    	$valid = false;
    	if(isset($fieldName) && $this->hasField($fieldName)) {
      		$valid = $this->isUnique(array($fieldName => $data));
     	}
        return $valid;
   }
//--------------------------------------------------------------------														
	function passidentity($data) {
 		if ( $this->data['User']['password1'] != $this->data['User']['password2'] ) {		
        	return false;
    	}
    	return true;
   	}
//--------------------------------------------------------------------	
	function beforeSave() {
        if ( !empty($this->data['User']['password1']) ) {
        	$this->data['User']['password'] = sha1( Configure::read('Security.salt').$this->data['User']['password1'] ); 
        }  
        return true;    
    }
//--------------------------------------------------------------------	
	function getUserData( $userName=null ) {
		$userDataOutput = false;
 		$this->recursive = 0;
		$userData = $this->findByUsername( $userName, array('fildes' =>  'User.username' ) );
		if ( $userData ) {
			$userDataOutput['ID'] = $userData['User']['id'];
		} else {
			$userDataOutput['ID'] = null;
		}
        return $userDataOutput;    
    }
//--------------------------------------------------------------------
    /**
     * Creates an activation hash for the current user.
     *      @param Void
     *      @return String activation hash.
    */
    function getActivationHash() {
    	if ( !isset($this->id) ) {
   			return false;
 		}
  		return substr( Security::hash( Configure::read('Security.salt') . $this->field('created') . date('Ymd') ), 0, 8 );
    }
//--------------------------------------------------------------------
}
?>