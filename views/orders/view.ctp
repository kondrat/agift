<?php debug($orderToShow); ?>
	<?php foreach($orderToShow['FileUpload'] as $logo): ?>
			<? echo $html->link($logo['file_name'], array('controller'=>'Orders','action'=>'history','file:'.$logo['id']) );?>
			<br />
	<?php endforeach ?>