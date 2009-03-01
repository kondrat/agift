<?php //debug($orders); ?>
<?php if( $orders != null ): ?>
<?php $i = 0; ?>
<?php foreach($orders as $order): ?>
	<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">
		<?php echo $form->create('Orders', array( 'action' => 'checkout', 'type' => 'file') ); ?>
	
		<tr>
			<td width="170" class="text">
			<?php 
	    		//switching the supplier type
	        	$supplierType = null;
	        	if ( isset($order['Gift']['supplier'] ) ) {
	    			switch ( $order['Gift']['supplier'] ) {        
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
	        	
				if ( isset($order['Gift']['Image'][0]['img']) ) {
					$giftImage = $order['Gift']['Image'][0]['img'];
				} elseif(isset($order['Image'][0]['img'])) {
					$giftImage = $order['Image'][0]['img'];
				} else {
					$giftImage = null;
				}
				echo $html->link( $html->image($supplierType.'/s/'.$giftImage, array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$order['Gift']['id'])  , array(), false, false ); 
			?>
			</td>
			<td width="200">
		
			<br>	
			<?php echo '<b>Арт. </b>'.$order['Gift']['code']; ?>
			<br>
			<?php echo '<b>'.$order['Gift']['name'].'</b>'; ?>
			<br>
			<?php echo '<b>Размер: </b>'.$order['Gift']['size']; ?>
			<br>
	
			<?php echo '<b>Материал: </b>'.$order['Gift']['size']; ?>
			<br>
	
			<?php echo '<b>Цена: </b>'.$order['Gift']['price']; ?>
		<br><br>	
		
		</td>
		
		<td width="99"></td>
		
		<td class="text" width="250">
		
	    	<table cellspacing="0" cellpadding="0" border="0" class="text" width="250">
	    		<tr>
	    			<td height="40" width="170"><b>Тираж:</b></td>
	    			<td>
	    				<?php echo $form->input('lineItem]'."[$i]".'[qty', array('size' => 10, 'label' => false,  'value' => $order['LineItem']['quantity'] ) ); ?>	
	    				<?php echo $form->hidden('lineItem]'."[$i]".'[price', array('value'=> $order['Gift']['price'])) ; ?>  
	    				<?php echo $form->hidden('lineItem]'."[$i]".'[item', array('value'=> $order['Gift']['id'])) ; ?>				
	    			</td>
	    		</tr>
	    		<tr>
	    			<td height="40"><b>Цена без нанесения:</b></td>
	    			<td>
	    				<?php echo $total_price[] = $order['Gift']['price']*(int)$order['LineItem']['quantity']; ?>
	    				руб.
	    			</td>
	    		</tr>
	    	</table>
			<?php echo $html->link('Отчистить', array('controller'=>'orders','action'=>'clean',$order['Gift']['id']) );?>
		</td>
	
		</tr>
	</table>
	
	<br /><br />
	
	<hr />
	
	<br /><br />
	<?php $i++; ?>
<?php endforeach ?>
	<div style="float: right">
	<?php echo $form->submit('Пересчитать', array('name' => 'recalculate','div' => false) ); ?>
	</div>
	<div style="clear: both;" />
<?php endif ?>
<!-- end of block -->

	<b>Если Вы хотите сделать нанесение на выбранных позициях,<br> уточните пожалуйста информацию о цветности и количестве<br> размещаемых лототипов:</b>
<br>
<?php 
	if( isset($addInfo) ) {
		$addInfoValue = $addInfo;
	} else {
		$addInfoValue = null;
	}
	echo $form->textarea('addInfo', array ('rows' => 6, 'cols' => 48, 'value' => $addInfoValue ) ) ; 
?>



<br><br>

	<?php 	if( $session->check('userCart.uploadData') && $session->read('userCart.uploadData') != array() ) {
				foreach ( $session->read('userCart.uploadData') as $uploadDataFile ) {
					 echo '<p class= "file">'.$html->link($uploadDataFile['file_name'], array('controller'=>'Orders','action'=>'history','file:'.$uploadDataFile['file_id']) ).'</p>';
					 echo '<p class= "delFile">'.$html->link('Удалить',array('controller'=>'uploads','action'=>'delete',$uploadDataFile['file_id']), array(), 'Подтверждаете удаление ?' ).'</p>';
				}
			}
	?>
<b>Загрузка логотипа:</b> 

		<input type="file" size="28" name="userfile[]"/>
			<br/>
			<br/>
	<?php echo $form->submit('Загрузить логотип', array('name' => 'logo') );?>
	
	
<br><br>

	<b>
		Цена без нанесения: 
		<?php echo array_sum($total_price); ?>
		руб.
	</b>
	<br><br>




	
	<?php 
		if ( $session->check('Auth.User.id') ) {
			echo $form->submit('Отправить запрос', array('name' => 'checkout') );
			echo $form->end();
		} else {
			echo $form->submit('Далее ->', array('name' => 'next_page') );
			echo $form->end();
		}
	?>	
	
	
	
	
	

 
	</td>
	<td width="60"></td>
</tr>
</table>

