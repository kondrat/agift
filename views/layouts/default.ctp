<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru-ru" lang="ru-ru" >
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

<?php //debug($session->read('userCart'));?>
<?php //debug($session->read('Order'));?>

</head>

<body topmargin="0">
		
	<div class="header">
		<cake:nocache>
			<?php echo $this->element('menu/menu', array('cache' => array('key' => 'topmenu', 'time' => '+360 days') ) ); ?>
		</cake:nocache>	
		<div class="form">
			<cake:nocache>
			<?php if( $session->check('Auth.User.id') == false ): ?>
				<?php echo $this->element('loginform/loginform', array('cache' => array('key' => 'loginform', 'time' => '+360 days') ) ); ?>
			<?php endif ?>
			</cake:nocache>
			<cake:nocache>
			<?php if( $session->check('Auth.User.id')): ?>
				<?php echo $this->element('menu/logedin', array('cache' => array('key' => 'logedin'.$session->read('Auth.User.id'), 'time' => '+360 days') ) ); ?>
			<?php endif ?>
			</cake:nocache>
			
		</div>
		</cake:nocache>	
	</div>

	<div class="menu_block">
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
		<div class="search">
			<?php echo $form->create('Gift', array( 'action' => 'search' )  ); ?>
			<?php echo $form->text('string', array( 'size' => '85') ); ?>&nbsp;&nbsp;&nbsp;<?php echo $form->submit('button.jpg', array ( 'div' => false) ); ?>
				<br />
			<span class="searchtext">
				<?php echo $form->checkbox('type'); ?>Поиск по артикулам &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $html->link('Расширенный поиск', array('controller' => 'Gifts', 'action' => 'extsearch'), array() ); ?>
			</span>
			<?php 
				if ($this->params['action'] != 'extsearch') {
					echo $form->end();
				} 
			?>
		</div>
		<cake:nocache>
			<?php if (isset($this->params['url']['url'])&&$this->params['url']['url']=='/'):?>
				<?php echo $this->element('news/twoNews', array('cache' => array('key' => 'twoNews', 'time' => '+300 days') ) ); ?>
			<?php endif ?>
		</cake:nocache>
	</div>
	
<!-- news 


			<?php if( $twoNews != null && count($twoNews) == 2): ?>
        			
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
	</div>
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
		

	<div class="mainblock">
	
		<div class="pen"><?php echo $html->image('pen.gif', array('border' => '0') );?></div>
		
		<div class="content">	


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


	</div>



	<br clear="all">




	<div class="footer">
		<div class="textfooter">Наш адрес: 109052, г. Москва, ул.Нижегородская, д. 29-33, стр. 15, офис 336. Тел./факс: (495) 589-88-09, 665-61-32</div>
		<div class="menu_down">
			<?php echo $html->link( 'ГЛАВНАЯ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'КАТАЛОГИ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'О КОМПАНИИ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'КОРЗИНА', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'ОТЗЫВЫ', '/' ); ?>&nbsp;&nbsp;&nbsp;<?php echo $html->link( 'КОНТАКТЫ', '/' ); ?>
		</div>
	</div>




</body>

	<?php echo $cakeDebug; ?>

</html>
