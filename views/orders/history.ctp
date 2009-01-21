<?php //debug($session->read()); ?>


	<?php //debug($historyOrderUser); ?>
<table cellspacing="2" cellpadding="2" border="0" width="800" class="text">
	<?php foreach ($historyOrderUser as $singlOrder ) : ?>
	<tr>
		<td>Дата оформления: <?php echo date( 'd.m.y', strtotime( $singlOrder['Order']['created'] ) );?></td>
		<td>Сумма заказа: <?php $singlOrder['Order']['total_price'];?> руб.</td>
		<td><?php echo $html->link('Просмотр заказа', array('action' => 'view',$singlOrder['Order']['id']) ); ?></td>
		<td><?php echo $html->link('Удалить заказ', array('action' => 'delete',$singlOrder['Order']['id']) ); ?></td>
	</tr>
			<?php //debug($up); ?>
			<? //echo $html->link('To get file', array('controller'=>'Orders','action'=>'history','dir:'.$up['subdir'],'down:'.$up['file_name']) );?>
	<?php endforeach ?>


</table>