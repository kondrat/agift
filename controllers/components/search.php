<?php
/*
* small component search
*
*/
        ini_set('include_path', ini_get('include_path') . '/za/app' . '/vendors'); 
        // Require the Lucene Class
        //require_once( 'Zend'.DS.'Search'.DS.'Lucene.php');
        App::import('vendor', 'Zend' . DS . 'Search' . DS . 'Lucene');
        //App::import('vendor', 'Zend' . DS . 'Search' . DS . 'Exception');
        //App::import('vendor', 'Zend/Search/Exception');
        //App::import('vendor', 'Zend' . DS .'Exception');
        //App::import('vendor', 'Zend' . DS . 'Search' . DS . 'Exception');
        

class SearchComponent extends Object {
    var $controller = null;
	var $index = null;
	 
    function startup(&$controller) {
        $this->controller = $controller;
    }
/*
	function search($query = "cake") {
		// Add your vendor directory to the includepath. ZF needs this.
		//App::import('Vendors', 'Zend/Exception');
 		//App::import('Vendors', 'Zend/Search/tess');
		//App::import('Vendors', 'Zend/Search/Lucene');
		

		//App::import('Vendor', 'Zend/Search/Lucene/Exception');
 
		if ($query == "build") {
			$index = Zend_Search_Lucene::create('/tmp/index');
 
			$url = "http://cakephp.agoris.nl/";
			$doc = Zend_Search_Lucene_Document_Html::loadHTMLFile($url);
			$doc->addField(Zend_Search_Lucene_Field::Text('url', $url));
			$index->addDocument($doc);
 
			$i = 1;
			foreach($doc->getLinks() as $link) {
					$current_doc = Zend_Search_Lucene_Document_Html::loadHTMLFile($url.$link);
					$current_doc->addField(Zend_Search_Lucene_Field::Text('url', $url.$link));
					echo "{$link}<br />";
					$index->addDocument($current_doc);
					$i++;
					if ($i >= 10) break;
			}
		}
 
 
		$index = Zend_Search_Lucene::open('/tmp/index');
		$hits = $index->find($query);
		$this->set('hits', $hits);
 
	}
*/
/*
	function index2() {
       // Add your vendor directory to the includepath. ZF needs this.
        //ini_set('include_path', ini_get('include_path') . '/za/app' . '/vendors');
        
        // Require the Lucene Class
        //require_once( 'Zend'.DS.'Search'.DS.'Lucene.php');
        //require_once( 'Zend'.DS.'Exception.php');
        //App::import('Vendors', 'Zend/Exception');
        // Establish your connection to the database
        mysql_connect('localhost', 'root', '1234');
        mysql_select_db('za');
        
        // Create a new index. This folder has to be readable by the httpd user
        // I will use the cache directory to store the index data
        $indexPath = APP . 'tmp\cache\index';
        //debug($indexPath);
        $index = new Zend_Search_Lucene($indexPath, true);
        
        // Lets get some records to add to the index
        $documents_rs = mysql_query('SELECT * FROM artest');
        while($document = mysql_fetch_object($documents_rs)) {
            // Create a new searchable document instance
            $doc = new Zend_Search_Lucene_Document();
        
            // Add some information
            $doc->addField(Zend_Search_Lucene_Field::UnIndexed('document_id', $document->id));
            //$doc->addField(Zend_Search_Lucene_Field::UnIndexed('document_created', $document->created));
           // $doc->addField(Zend_Search_Lucene_Field::UnIndexed('document_updated', $document->updated));
            $doc->addField(Zend_Search_Lucene_Field::Text('document_title', $document->title) );
            $doc->addField(Zend_Search_Lucene_Field::Text('document_body', $document->body) );
            
            // Add the document to the index
            $index->addDocument($doc);
        }
        
        // Commit the index
        $index->commit();
    }
    
// Get the index object
    function &getIndex() {
          	
        if( !$this->index ) {
            $this->index = new Zend_Search_Lucene(TMP . DS . 'cache'.DS.'index');
        }
        return $this->index;
    }  
    
    // Executes a query to the index and returns the results
    function query($query) {
 //       ini_set('include_path', ini_get('include_path') . '/za/app' . '/vendors');
 //          require_once( 'Zend'.DS.'Search'.DS.'Lucene.php');     
        $index =& $this->getIndex();
        $results = $index->find($query);
        return $results;
    }   
 */   
}
?>