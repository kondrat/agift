<?php if( isset($forEmailLineItems) ): ?>
	
	<b>Дата формирования заказа:</b> <?php echo $forEmailLineItems['Order']['Order']['created']; ?>
	<br/><br/>
	<table cellspacing="2" cellpadding="2" border="1">
	<tr>
		<td><b>Артикул</b></td>
		<td><b>Наименование</b></td>
		<td><b>Цена</b></td>
		<td><b>Количество</b></td>
		<td><b>Стоимость</b></td>
	</tr>
	<?php foreach($forEmailLineItems['items'] as $item): ?>
		<tr>
			<td>Арт <?php echo $item['code']; ?></td>
			<td><?php echo $item['name']; ?></td>
			<td><?php echo $item['price']; ?></td>
			<td><?php echo $item['quantity']; ?></td>
			<td><?php echo $item['quantity']*$item['price']; ?></td>
		</tr>
	<?php endforeach ?>	
	</table>
	
	<br/>
	<b>Наличие логотипа:</b>
	<?php if( $forEmailLineItems['Order']['FileUpload'] != array() ): ?>
		 есть
	<?php else: ?>
		нет
	<?php endif ?>
	<br/><br/>
	<b>Описание заказа:</b> 
	<br/>
	<?php echo $forEmailLineItems['Order']['Order']['addInfo']; ?>
	<br/><br/>
	<b>Общая сумма заказа:</b> <?php echo round($forEmailLineItems['Order']['Order']['total_price']); ?> руб
	
	
	
	<br/><br/>
	<font color="#ff0000"><b>КОНТАКТНАЯ ИНФОРМАЦИЯ</b></font>
	<br/>
	<?php if( $session->check('Auth.User.username') ): ?>
		<?php echo '<b>Имя: </b>'.$userName; ?>
	 		<br/>
		<b>Телефон:</b> <?php echo $forEmailLineItems['Order']['User']['phone'];?> <br />
		<b>E-mail:</b> <?php echo $forEmailLineItems['Order']['User']['email'];?> <br />					
	<?php else: ?>
		<?php echo '<b>Имя: </b>'.$forEmailLineItems['Order']['Order']['firstname'].' IP - '. $userName.' . Не зарегистрирован'; ?>
	 		<br/>
		<b>Телефон:</b> <?php echo $forEmailLineItems['Order']['Order']['phone'];?> <br />
		<b>E-mail:</b> <?php echo $forEmailLineItems['Order']['Order']['email'];?> <br />
	<?php endif ?>
	
<?php endif ?>


