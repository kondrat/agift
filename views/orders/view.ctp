<?php // debug($orderToShow); ?>
<?php echo $html->link('История заказов',array('contorller'=>'orders','action'=>'history'));?>
<br /><br />
<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">
     	
    <tr><td>Номер заказа:&nbsp;<?php echo $orderToShow['Order']['id'];?></td></tr>
    <tr><td>Дата заказа:&nbsp;<?php echo date( 'd.m.y', strtotime($orderToShow['Order']['modified']) );?></td></tr>
    <tr><td>Стоимость заказа:&nbsp;	<?php echo $number->format($orderToShow['Order']['total_price'], array(
							    'places' => 2,
							    'before' => false,
							    'escape' => false,
							    'decimals' => '.',
							    'thousands' => false,
							));
						?>
						руб
	</td></tr>
</table>
<hr />
<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">
	<?php foreach($orderToShow['LineItem'] as $item ):?>
		<tr>
			<td width="170" class="text">
				<?php 
		    		//switching the supplier type
		        	$supplierType = null;
		        	if ( isset($item['Gift']['supplier'] ) ) {
		    			switch ( $item['Gift']['supplier'] ) {        
		           	 		case 2:
		           	 //CASE 2 oasis
		           	 	$supplierType = 'oasis';	
		           	 		break;
		           	 		case 3:
		           	 //CASE 3 proekt111
		           	 	$supplierType = 'proekt111';
		           	 		break;
		           	 	}
		        	}
		        	
					if ( isset($item['Gift']['Image'][0]['img']) ) {
						$giftImage = $item['Gift']['Image'][0]['img'];
					} else {
						$giftImage = null;
					}
					echo $html->link( $html->image($supplierType.'/s/'.$giftImage, array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$item['Gift']['id'])  , array(), false, false ); 
				?>
			</td>
			<td width="200">		
				<br>	
				<?php echo '<b>Арт. </b>'.$item['Gift']['code']; ?>
				<br>
				<?php if ($item['Gift']['name'] != null): ?>
					<?php echo '<b>'.$item['Gift']['name'].'</b>'; ?>
					<br>
				<?php endif ?>
				<?php if ($item['Gift']['size'] != null): ?>
					<?php echo '<b>Размер: </b>'.$item['Gift']['size']; ?>
					<br>
				<?php endif ?>
				<?php if ($item['Gift']['material'] != null): ?>
					<?php echo '<b>Материал: </b>'.$item['Gift']['size']; ?>
					<br>
				<?php endif ?>
		
				<?php echo '<b>Цена: </b>'.$item['Gift']['price']; ?>
					<br />
				<?php echo '<b>Количество: </b>'.$item['quantity']; ?>
					<br /><br /><br />	
			</td></tr>
		<?php endforeach ?>
</table>
	<p> Логотипы: </p>
	<?php if($orderToShow['FileUpload'] != null):?>
		<?php foreach($orderToShow['FileUpload'] as $logo): ?>
				<? echo $html->link($logo['file_name'], array('controller'=>'Orders','action'=>'history','file:'.$logo['id']) );?>
				<br />
		<?php endforeach ?>
	<?php else: ?>
		<p>Логотипы не загружены</p>
	<?php endif ?>