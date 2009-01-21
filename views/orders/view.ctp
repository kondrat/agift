<?php debug($orderToShow); ?>
<?php debug($orderToShow['fileUploads']); ?>
	<?php foreach($orderToShow['fileUploads'] as $logo): ?>
			<? //echo $html->link($logo['file_name'], array('controller'=>'Orders','action'=>'history','dir:'.$logo['subdir'],'down:'.$logo['file_name']) );?>
			<? echo $html->link($logo['file_name'], array('controller'=>'Orders','action'=>'history','file:'.$logo['id']) );?>
			<br />
	<?php endforeach ?>