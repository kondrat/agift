<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>

	<?php echo $html->charset(); ?>
	<title>
		Alfa Gifts - сувенирная продукция:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('style');
		
		echo $javascript->link('jquery-1.2.6');	
		echo $javascript->link('ag');

		echo $scripts_for_layout;
	?>

<?php debug($session->read('userCart'));?>
<?php debug($session->read('Order'));?>

</head>
<body topmargin="0">
	
	
	<div class="header">
		<?php echo $this->element('menu/menu'); ?>
		<div class="form">
			<?php if( $session->check('Auth.User.id') == false ): ?>
				<?php echo $form->create('User', array( 'action' => 'login' ), array('id' => 'rec2') ); ?>		
					<div class="headerfield">Вход в личный кабинет</div>
					<div class="formfield">Логин:</div>
						<?php echo $form->input('username', array('type' => 'text', 'size' => 20, 'div'=> null, 'label' => false, 'error' => false) );?>
						<br />
					<div class="formfield">Пароль:</div>
						<?php echo $form->input('password', array( 'size' => 11,  'label' => false, 'div' => false) );?>
						<?php echo $form->hidden('onfly', array('value' => true));?>
						<?php echo $form->submit( "Вход", array( 'class' => 'submit','div' => false) ); ?>
						<br/>
						<?php echo $html->link("Забыли пароль?", array( 'controller' => 'users', 'action' => 'password_reset') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $html->link( 'Регистрация', array( 'controller' => 'users', 'action' => 'reg' ) ); ?>
				<?php echo $form->end(); ?>
			<?php else: ?>
				Личный кабинет:
		 		<?php echo '<span style=" font-weight: bold">'. $session->read('Auth.User.username').'</span>'; ?>						
					<br />			
				<?php echo $html->link('История заказов', array('controller' => 'orders', 'action' => 'history') ); ?>
					<br />
				<?php echo $html->link('Выход', array('controller' => 'users', 'action' => 'logout') ); ?>		
			<?php endif ?>
		</div>
	</div>


	<div class="contentleft"></div>

	<div class="contentcenter">
		<div class="menu_oasis">
			<?php echo $html->link( $html->image('menu_oasis.jpg', array('border' => '0' ) ), array('controller' => 'categories','action' => 'oasis') , array( 'class' => 'opacity'), false, false ) ?>
		</div>
		<div class="menu_ferre">
			<?php echo $html->link( $html->image('menu_ferre.jpg',  array('border' => '0') ), array('controller' => 'categories','action' => 'oasis', 228,'t') , array('class' => 'opacity'), false, false ) ?>
		</div>
		<div class="menu_15">
			<?php echo $html->link( $html->image('menu_15.jpg',  array('border' => '0') ), array('controller' => 'categories','action' => 'oasis', 210,'t') , array('class' => 'opacity'), false, false ) ?>
		</div>
		<div class="menu_proekt">
			<?php echo $html->link( $html->image('menu_proekt.jpg', array('border' => '0') ), array('controller' => 'categories','action' => 'proekt111') , array('class' => 'opacity'), false, false ) ?>
		</div>
		<div class="menu_usb">
			<?php echo $html->link( $html->image('menu_usb.jpg', array('border' => '0' ) ), array('controller' => 'categories','action' => 'usb', 4,'t') , array('class' => 'opacity'), false, false ) ?>
		</div>
		<div class="menu_toys">
			<?php echo $html->link( $html->image('menu_toys.jpg', array('border' => '0') ),'/' , array('class' => 'opacity'), false, false ) ?>
		</div>
	</div>


	<div class="contentright">
		<?php echo $form->create('Gift', array( 'action' => 'search' )  ); ?>
		<?php echo $form->text('string', array( 'size' => '85') ); ?>&nbsp;&nbsp;&nbsp;
		<?php echo $form->submit('button.jpg', array ( 'div' => false) ); ?>
			<br />
		<span class="searchtext">
			<?php echo $form->checkbox('type'); ?>
				Поиск по артикулам &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $html->link('Расширенный поиск', array('controller' => 'Gifts', 'action' => 'extsearch'), array() ); ?>
		</span>
		<?php 
			if ($this->params['action'] != 'extsearch') {
				echo $form->end();
			} 
		?>
	</div>

<!-- news 

	<table valign="top" cellspacing="0" cellpadding="0" border="0" width="625" height="84">
		<tr>
			<?php if( $twoNews != null && count($twoNews) == 2): ?>
        	<td class="news1" width="11"></td>	
        		<td class="news2 menulup" width="299" >
        			
        			<?php echo date( 'd.m.y', strtotime($twoNews[0]['News']['created']) ).' '. $twoNews[0]['News']['name'] ?>
        			
        			<br>
        			
        			<?php echo $html->link( $twoNews[0]['News']['shortbody'].' »', array('controller'=>'news', 'action'=>'view', $twoNews[0]['News']['id'] ), array('class' =>'menul' ) ) ?>
        				

        		</td>
        	
        		
        	<td width="5"></td>
        	
        	<td class="news1" width="11"></td>	
        		<td class="news2 menulup" width="299" >
        			
        			<?php echo date( 'd.m.y', strtotime($twoNews[1]['News']['created']) ).' '. $twoNews[1]['News']['name'] ?>
        			
        			<br>
        			
        			<?php echo $html->link( $twoNews[1]['News']['shortbody'].' »', array('controller'=>'news', 'action'=>'view', $twoNews[1]['News']['id'] ), array('class' =>'menul' ) ) ?>

        		</td>
        	
			<?php endif ?>
		</tr>
	</table>
-->
	<div class="alfagifts">		
			<div class="left3col"></div>
		
			<div class="center3col">
				<span><?php echo $subheaderTitle; ?></span>
			</div>

			<div class="right3col">
				<div class="a_type_ag"><?php echo $html->image('a_type_ag.jpg', array('border' => '0') );?></div>
			</div>
	</div>
		

	<div class="maincontent">

		<div class="leftcontent3col"></div>


		<div class="maincontent3col">	


			<?php 

					if( $session->check('userCart.countTempOrders')  ) {
						echo '<div class="add" >';
						echo $html->link( 'Товаров в корзине: ', array('controller' => 'orders', 'action' => 'index'), array('style' => "text-decoration: none; color: red;" ) );
						echo $session->read('userCart.countTempOrders');
						echo '</div';
					}

				?>		





			<?php
			
				if ($session->check('Message.flash')):
				
						echo '<br /><div class="add">';
						$session->flash();
						echo '</div>';
						
				endif;
				
			?>

			<?php echo $content_for_layout; ?>

		</div>


		<div class="rightcontent3col">
			<div class="pen"><?php echo $html->image('pen.gif', array('border' => '0') );?></div>
		</div>

	</div>








	<div class="footer">
		<div class="textfooter">Наш адрес: 109052, г. Москва, ул.Нижегородская, д. 29-33, стр. 15, офис 336. Тел./факс: (495) 589-88-09, 665-61-32</div>
		<div class="menu_down">
			<?php echo $html->link( 'Главная', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'КАТАЛОГИ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'О КОМПАНИИ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'Корзина', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'ОТЗЫВЫ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'Контакты', '/' ); ?>
		</div>
	</div>




</body>

	<?php echo $cakeDebug; ?>

</html>
