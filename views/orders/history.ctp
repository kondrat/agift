	<div class="page">
	<?php 
		//<!--          -----------------------Catalog output ---------------------------------   -->

	?>
			<?php if( isset($this->params['paging']['Order']['pageCount']) && $this->params['paging']['Order']['pageCount'] > 1 ): ?>
				<?php echo $paginator->prev('Назад', array('class' => 'menu2' ) , null,  array('class'=>'menu2'));?>
  				<?php echo $paginator->numbers( array('modulus'=>'5','separator'=>' ','url' => array(  ), 'class' => 'menu2' ), null );?>
				<?php echo $paginator->next('Вперед', array('class' => 'menu2' ), null, array('class'=>'menu2'));?>
			<?php endif ?>

	</div>
<br />
<br />
<table cellspacing="2" cellpadding="2" border="0" width="800" class="text">
	<?php foreach ($historyOrderUser as $singlOrder ) : ?>
		<tr>
			<td>Дата оформления: <?php echo date( 'd.m.y', strtotime( $singlOrder['Order']['created'] ) );?></td>
			<td>Сумма заказа: <?php echo $number->format($singlOrder['Order']['total_price'], array(
							    'places' => 2,
							    'before' => false,
							    'escape' => false,
							    'decimals' => '.',
							    'thousands' => false,
							));
							?> руб.</td>
			<td><?php echo $html->link('Просмотр заказа', array('action' => 'view',$singlOrder['Order']['id']) ); ?></td>
			<td><?php echo $html->link('Удалить заказ', array('action' => 'delete',$singlOrder['Order']['id']), null, sprintf('Подтверждаете удаление %s?', $singlOrder['Order']['id']) ); ?></td>
		</tr>
	<?php endforeach ?>
	<?php if (count($historyOrderUser) == 0):?>
		<tr>
			<td>Заказы отсутствуют</td>
		</tr>
	<?php endif ?>

</table>