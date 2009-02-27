<?php
class FileUpload extends AppModel {
    var $name = 'FileUpload';
    var $actsAs = array('Containable');
    var $belongsTo = array('Order'=> array('className'=> 'Order'),
    					);
}
?>
