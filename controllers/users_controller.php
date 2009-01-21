<?php
uses('sanitize');
$mrClean = new Sanitize();

class UsersController extends AppController {
	var $uses = array('User','Order', 'LineItem', 'Gift');
	var $name = 'Users';
	var $helpers = array('Form', 'Html');
	var $components = array( 'userReg', 'shopping');
	var $pageTitle = 'Данные пользователя';
	var $paginate = array('limit' => 5);

//--------------------------------------------------------------------	
  function beforeFilter() {
        $this->Auth->allow( 'logout', 'reg', 'password_reset','view', 'acoset','buildAcl');
        parent::beforeFilter(); 
        $this->Auth->autoRedirect = false;
        //debug($this->Session->read() );
    }
//--------------------------------------------------------------------
	function index() {
		$this->User->recursive = 0;
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
			
			$this->data['User']['group_id'] = 4;			
			$this->User->create();

			if ( $this->User->save( $this->data) ) {
				$a = $this->User->read();
				//debug($a);
				$this->Auth->login($a);
				$this->redirect( array('controller' => 'orders', 'action' => 'index') );
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
			$this->flash('Internal server error during sending mail', 'restore', 10);
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
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid User');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if (!empty($this->data)) {
			$this->cleanUpFields();
			if ($this->User->save($this->data)) 
            {
                // we might have to reset the parent aro
                $this->InheritAcl->checkAroParent('User', $this->data['User']['id'], 'Role', $this->data['User']['role_id']);
				$this->Session->setFlash('The User has been saved');
				$this->redirect(array('action'=>'index'), null, true);
			} else {
				$this->Session->setFlash('The User could not be saved. Please, try again.');
			}
		}
		if (empty($this->data)) 
        {
			$this->data = $this->User->read(null, $id);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

//-------------------------------------------------------------------- 
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for User');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ( $this->User->del($id) ) {
			$this->Session->setFlash('User #'.$id.' deleted');
			$this->redirect(array('action'=>'index'), null, true);
		}
	}
//--------------------------------------------------------------------
	function view($id = null) {

		if (!$id) {
			$this->Session->setFlash('Invalid User.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		$this->set('user', $this->User->read(null, $id));
//		$temp = $this->User->read(null, $id);


	}
//--------------------------------------------------------------------

	function acoset() {
		$this->Acl->Aco->create(array('parent_id' => null, 'alias' => 'controllers'));
		$this->Acl->Aco->save();
		echo 'aro ok';
		die;
	}
	
	function aroset() {
		$this->Acl->Aro->create( array('parent_id' => 1, 'foreign_key' => 1, 'model'=> 'User') );
		$this->Acl->Aro->save();
		echo 'aro ok';
		die;
	}
	function permset() {
		
		$this->Acl->allow('admin', 'controllers');

		echo 'prem ok';
		die;
	}
	/**
 * Rebuild the Acl based on the current controllers in the application
 *
 * @return void
 */
    function buildAcl() {
        $log = array();
 
        $aco =& $this->Acl->Aco;
        $root = $aco->node('controllers');
        if (!$root) {
            $aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
            $root = $aco->save();
            $root['Aco']['id'] = $aco->id; 
            $log[] = 'Created Aco node for controllers';
        } else {
            $root = $root[0];
        }   
 
        App::import('Core', 'File');
        //$Controllers = Configure::listObjects('controller');
        $Controllers = array('Categories', 'Gifts', 'News','Users','Orders');
        /*
        							[0] => App
    								[1] => Pages
    								[2] => Catalogs
    								[3] => Categories
    								[4] => Datas
    								[5] => Gifts
    								[6] => LineItems
    								[7] => News
    								[8] => Orders
    								[9] => Uploads
    								[10] => Users
    								[11] => Xmlpars
    								[12] => Xmltest
    								[13] => Zends
		*/
        //my modification. taking array of controllers from my application;
        //debug($Controllers);
        //die;
        $appIndex = array_search('App', $Controllers);
        if ($appIndex !== false ) {
            unset($Controllers[$appIndex]);
        }
        $baseMethods = get_class_methods('Controller');
        $baseMethods[] = 'buildAcl';
 
        // look at each controller in app/controllers
        foreach ($Controllers as $ctrlName) {
            App::import('Controller', $ctrlName);
            $ctrlclass = $ctrlName . 'Controller';
            $methods = get_class_methods($ctrlclass);
 
            // find / make controller node
            $controllerNode = $aco->node('controllers/'.$ctrlName);
            if (!$controllerNode) {
                $aco->create(array('parent_id' => $root['Aco']['id'], 'model' => null, 'alias' => $ctrlName));
                $controllerNode = $aco->save();
                $controllerNode['Aco']['id'] = $aco->id;
                $log[] = 'Created Aco node for '.$ctrlName;
            } else {
                $controllerNode = $controllerNode[0];
            }
 
            //clean the methods. to remove those in Controller and private actions.
            foreach ($methods as $k => $method) {
                if (strpos($method, '_', 0) === 0) {
                    unset($methods[$k]);
                    continue;
                }
                if (in_array($method, $baseMethods)) {
                    unset($methods[$k]);
                    continue;
                }
                $methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
                if (!$methodNode) {
                    $aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => null, 'alias' => $method));
                    $methodNode = $aco->save();
                    $log[] = 'Created Aco node for '. $method;
                }
            }
        }
        debug($log);
    }
//-----------------------------
}
?>