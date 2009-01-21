<?php
class UploadsController extends AppController
{

    var $name = 'Uploads';
    var $components = array('FileHandler');
    var $uses = array('FileUpload');


//--------------------------------------------------------------------	
	function beforeFilter() {
        $this->Auth->allow( 'index');
        parent::beforeFilter();
    }
//--------------------------------------------------------------------


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
