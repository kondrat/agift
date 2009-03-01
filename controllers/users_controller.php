<?php
class UsersController extends AppController {
	var $uses = array('User','Order', 'LineItem', 'Gift');
	var $name = 'Users';
	var $helpers = array('Form', 'Html');
	var $components = array( 'userReg', 'shopping');
	var $pageTitle = 'Данные пользователя';
	var $paginate = array('limit' => 5);

//--------------------------------------------------------------------	
  function beforeFilter() {
        $this->Auth->allow( 'logout', 'reg', 'password_reset');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        //debug($this->Session->read() );
    }
    
  	function isAuthorized() {
  		if( $this->Auth->user('group_id') && $this->Auth->user('group_id') == 1 ) {
  			return true;
  		}
        if ($this->action == 'view' || $this->action == 'edit' || $this->action == 'newpassword') {
            if( $this->Auth->user('group_id') && $this->Auth->user('group_id') > 1 ) {
                if( $this->params['pass']['0'] === $this->Auth->user('id') ) {
                	return true;
                } else {
                	return false;
                }
            } else {
                return false;
            }
        }

        return false;
    }
//--------------------------------------------------------------------
	function index() {
		$this->User->recursive = 0;
		if ( isset($this->params['named']['u']) && $this->params['named']['u'] == 'customer') {
			$this->paginate['conditions'] = array('Group.id >'=>'1');
		} elseif ( isset($this->params['named']['u']) && $this->params['named']['u'] == 'admin' ) {
			$this->paginate['conditions'] = array('Group.id'=>'1');
		}
		$this->set('users', $this->paginate() );
	}
//--------------------------------------------------------------------
	function login() {
		$this->pageTitle = 'ВХОД В ЛИЧНЫЙ КАБИНЕТ';
		$this->subheaderTitle = 'ВХОД В ЛИЧНЫЙ КАБИНЕТ';
	
		if( !empty($this->data) ) {

			if( $this->Auth->login() ) {
				// Retrieve user data

					if ( $this->Auth->user() ) {
 						//merging orders which was made before reg in session 
 						
 						//not used for the moment

             			//$this->shopping->mergeOrders( $this->Session->read('Order'), $this->Session->read('Auth.User.id') );
             			// to remove
             			$this->data['User']['remember_me'] = true;
						if ( !empty($this->data) && $this->data['User']['remember_me'] ) {
							$cookie = array();
							$cookie['username'] = $this->data['User']['username'];
							$cookie['password'] = $this->data['User']['password'];
							$this->Cookie->write('Auth.User', $cookie, true, '+3 hours');
							unset($this->data['User']['remember_me']);
						}

         			}

					if (isset($this->data['User']['onfly']) && $this->data['User']['onfly'] == true ) {
						$this->redirect( $this->referer() );
					} elseif (isset($this->params['form']['log_checkout']) ) {
						$this->redirect( array('controller'=>'orders','action'=>'index'), null, true );	
					} else {
						$this->redirect( $this->Auth->redirect() );
					}
			
			} else {
				$this->data['User']['password'] = null;
				$this->Session->setFlash("Проверьте ваш логин и пароль",'default', array('class' => 'nomargin flash'));
			}
		} else {
			if( !is_null( $this->Session->read('Auth.User.username') ) ){
				
				$this->redirect( $this->Auth->redirect() );			
			}
		}
		
	}

//--------------------------------------------------------------------
    function logout() {
    	//$tempUserName = ucwords($this->Session->read('Auth.User.username')). ' logged out now';
    	$tempUserName = $this->Session->read('Auth.User.username'). ' вышел из системы';
    	//$this->Session->del();
        $this->Auth->logout();
        $this->Session->del('Order');
        $this->Session->del('userCart');
        $this->Cookie->del('Auth.User');
        $this->Session->setFlash( $tempUserName, 'default', array('class' => 'nomargin flash') );
        $this->redirect( $this->Auth->redirect() );        
    }
//--------------------------------------------------------------------
	function reg() {
		//debug($this->data);
		$this->pageTitle = 'Регистрация';
		$this->subheaderTitle = 'РЕГИСТРАЦИЯ';
		
		

		if ( !empty($this->data) ) {
			App::import('Sanitize');
			$this->data = Sanitize::clean($this->data);
			$this->data['User']['group_id'] = 4;			
			$this->User->create();

				if ( $this->User->save( $this->data) ) {
					$a = $this->User->read();
					//debug($a);
					$this->Auth->login($a);
					$this->Session->setFlash('Регистрация прошла успешно',null,true);
					$this->redirect( array('controller' => 'pages', 'action' => 'index') );
	               	//$this->redirect('/users/thanks');
	         	} else {
	         		// Failed, clear password field
					$this->data['User']['password1'] = null;
					$this->data['User']['password2'] = null;
					$this->Session->setFlash('Новый аккаунт не был создан');
				}
		} else {
			if( !is_null( $this->Session->read('Auth.User.username') ) ) {
				$this->redirect($this->Auth->redirect());
			}				
		}

	}

//--------------------------------------------------------------------
    function password_reset() {
    	$this->subheaderTitle = 'ВОССТАНОВЛЕНИЕ ПАРОЛЯ';
    	if( empty($this->data) ) {
    		return;    		
    	}

		// Check email is correct
		$user = $this->User->find( array('User.email' => $this->data['User']['email']) , array('id', 'username', 'email'), null, 0 );
		if(!$user) {
			$this->User->invalidate('email', 'Этот E-mail не зарегистрирован' );
			return;
		}
		
		// Generate new password
		$password = $this->userReg->createPassword();
		//$data['User']['password1'] = $this->Auth->password($password);
		$data['User']['password'] = $this->Auth->password($password);
		$this->User->id = $user['User']['id'];
		if(!$this->User->saveField('password', $this->Auth->password($password) ) ) {
			return;
		}
		
		// Send email
		if(!$this->__sendNewPasswordEmail( $user, $password) ) {
			$this->flash('Internal server error during sending mail', 'password_reset', 10);
		}
		else {
			$this->flash('New password sent to '.$user['User']['email'].'. Please login', '/users/login', 10);
		}
    }
//--------------------------------------------------------------------
    /**
     * Send out an password reset email to the user email
     * 	@param Array $user User's details.
     *  @param Int $password new password.
     *  @return Boolean indicates success
    */
    function __sendNewPasswordEmail($user, $password) {

        // Set data for the "view" of the Email
        $this->set('password', $password );
        $this->set( 'username', $user['User']['username'] );
       
        $this->Email->to = $user['User']['username'].'<'.$user['User']['email'].'>';
        $this->Email->subject = env('SERVER_NAME') . ' - New password';
        $this->Email->from = 'noreply@' . env('SERVER_NAME');
        $this->Email->template = 'user_password_reset';
        $this->Email->sendAs = 'text';   // you probably want to use both :)   
        return $this->Email->send();
	}     
//--------------------------------------------------------------------
	function edit($id = null) {
		App::import('Sanitize');
		$this->data = Sanitize::clean($this->data);
		$id = (int)Sanitize::paranoid($id);
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid User');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}
		if ($this->Auth->user('group_id') > 1) {
			$id = $this->Auth->user('id');
		}
			if (!empty($this->data)) {
				if ($this->User->save($this->data)) {
					$this->Session->setFlash('Изменения сохранены');
					$this->redirect(array('action'=>'view',$id ), null, true);
				} else {
					$this->Session->setFlash('Изменения не были сохранены');
				}
			}
		
		
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

	}
//--------------------------------------------------------------------
	function newpassword($id = null) {
		App::import('Sanitize');
		$this->data = Sanitize::clean($this->data);
		$id = (int)Sanitize::paranoid($id);
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid User');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}
		if ($this->Auth->user('group_id') > 1) {
			$id = $this->Auth->user('id');
		}
			if (!empty($this->data)) {
				if( $this->User->save( $this->data, true, array( 'password','password1','password2') ) ) {
					$this->Session->setFlash('Пароль изменен');
					$this->redirect(array('action'=>'view',$id ), null, true);
				} else {
					$this->Session->setFlash('Пароль не был изменен');
				}
			}
		
		
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

	}
//-------------------------------------------------------------------- 
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for User');
			$this->redirect(array('action'=>'index'), null, true);
		}
		
		
		if ( $this->User->del($id) ) {
			$this->Session->setFlash('Пользователь #'.$id.' удален');
			$this->redirect(array('action'=>'index'), null, true);
		}
	}
//--------------------------------------------------------------------
	function view($id = null) {
		App::import('Sanitize');
		$id = (int)Sanitize::paranoid($id);
		if (!$id) {
			$this->Session->setFlash('Invalid User.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ($this->Auth->user('group_id') > 1) {
			$id = $this->Auth->user('id');
		}
		$this->set('user', $this->User->read(null, $id));
//		$temp = $this->User->read(null, $id);


	}
//--------------------------------------------------------------------

}
?>