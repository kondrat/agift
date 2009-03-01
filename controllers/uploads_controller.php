<?php
class UploadsController extends AppController
{

    var $name = 'Uploads';
    var $components = array('FileHandler');
    var $uses = array('FileUpload');


//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow('delete');
        parent::beforeFilter();
    }
    
	//----------------------------------------------	
	function isAuthorized() {
	    if ($this->Auth->user('group_id') == '1') {
	        return true;
	    } 
        if ($this->action == 'delete' ) {
                return true;
        }	    
		return false;
	}
//--------------------------------------------------------------------
	function delete($id) {
		if( !is_numeric($id) || !$id ){
			$this->Session->setFlash('Invalid File');
			$this->redirect(array('controller'=>'pages','action'=>'index'), null, true);
		}
			$fileToDel = $this->FileUpload->find('first',array('conditions' => array('FileUpload.id'=> $id, 'FileUpload.session_id'=> $this->Session->read('userCart.tempSession') ) ) ) ;
			
			if ($this->FileUpload->del($id) ) {
						
					$directory = TMP.'uploads'.DS.$fileToDel['FileUpload']['subdir'];
					$this->__recursive_remove_directory($directory);
						
				$this->redirect($this->referer(),null,true );
			} else {
				//$this->Session->setFlash( 'Файл не был удален', 'default', array('class' => null) );
				$this->redirect($this->referer(),null,true );				
			}		
		
		
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
     * handle upload of files and submission info
     */
    function index() {

        if ( isset($this->data) ) {

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
                              
                              
                              'application/cdr', //coreldraw
							  'application/coreldraw',
							  'application/x-cdr',
      						  'application/x-coreldraw',
							  'image/cdr',
							  'image/x-cdr',
							  'zz-application/zz-winassoc-cdr',
                        );

            // extra database field 
            $dbFields = array('extra_field'  => $this->data['data']['extra_field']);

            // set the upload directory
            //$uploadDir = realpath(TMP);
            //$uploadDir .= DS . 'uploads' . DS;
            $uploadDir = 'c:'.DS.'x';

            // settings for component
            //$this->FileHandler->setAllowedMime($allowedMime);
            $this->FileHandler->setDebugLevel(1);
            $this->FileHandler->setRequired(0);
            $this->FileHandler->setHandlerType('db');
            $this->FileHandler->setDbModel('FileUpload');
            $this->FileHandler->addDbFields($dbFields);
            $this->FileHandler->setMaxSize(10000);

            if ($this->FileHandler->upload('userfile', $uploadDir)) {

                /* if nothing is submitted and required is set to 0
                 * upload() will return true so you need to handle 
                 * empty uploads in your own way
                 */
                echo 'upload succeeded';
                $this->set('uploadData', $this->FileHandler->getLastUploadData());
            } else {
                echo 'upload failed';
            }

            $this->set('errorMessage', $this->FileHandler->errorMessage);
        }

    }//index()

}//UploadsController
?>
