<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<?php //echo $html->docType('html4-trans'); ?> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<?php echo $html->charset(); ?>
	<title>
		<?php __('Alfa Gifts - сувенирная продукция: '); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		echo $html->css('ag');
		/*
		echo $html->css('reset');
		echo $html->css('typography');
		echo $html->css('grid');
		echo $html->css('forms');
		echo $html->css('za');
		*/
		//echo $html->css('print');
		/*
		echo '<!--[if IE]>';
		echo $html->css('ie');
		echo '<![endif]-->';
		*/	
		
		echo $javascript->link('jquery-1.2.6');	
		echo $javascript->link('ag');

		echo $scripts_for_layout;
	?>

<?php debug($session->read('userCart'));?>
<?php debug($session->read('Order'));?>

</head>
<body topmargin="0" bgcolor="#949599">
<center>

<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015">
	<tr>
	<td colspan="6">
		<?php echo $html->image('up1.jpg')?></td>
	
	<?php if( $session->check('Auth.User.id') == false ): ?>
	<td colspan="5" background="/za/img/up2.jpg" align="right" />
	
	<!-- to make an element and if for the log and not loged -->
	
    	<table cellspacing="0" cellpadding="0" border="0" width="200">
    		<tr>
    			
    			<td width="200" class="logup" valign="top">
    	
    			
					<?php echo $form->create('User', array( 'action' => 'login' )  ); ?>	
    				<legend>Вход в личный кабинет:</legend>
    				<table cellspacing="0" cellpadding="0" border="0" class="log" width="200">
        				<tr>
        					<td height="20" width="60">Логин:</td>
        					<td width="90">
        						<?php echo $form->input('username', array('type' => 'text', 'size' => 9, 'div'=> null, 'label' => false, 'error' => false) );?>
        					</td>
        					<td width="50"></td>
        				</tr>
        				<tr>
        					<td colspan="3" height="3"></td>
        				</tr>
        				<tr>
        					<td height="20" width="60">Пароль:</td>
        					
        					<td width="90">
        						<?php echo $form->input('password', array( 'size' => 9,  'label' => false) );?>
        						<?php echo $form->hidden('onfly', array('value' => true));?>
        					</td>
        					<td width="50">
        					<?php echo $form->submit( "Войти", array( 'class' => 'submit') ); ?>	
        						
        					</td>
        				</tr>
    				</table>
    
    				<?php echo $html->link("Забыли пароль?", array( 'controller' => 'users', 'action' => 'password_reset'), array('class' => 'log' ) ); ?>
    					&nbsp;&nbsp;
    				<?php echo $html->link( 'Регистрация', array( 'controller' => 'users', 'action' => 'reg' ), array('class' => 'log' ) ); ?>
					<?php echo $form->end(); ?>
    			</td>
    		</tr>
    	</table>

	</td>
	<?php else: ?>
		<td colspan="5" background="images/up2.jpg" align="right" class="logup">
		Личный кабинет:
 		<?php echo '<span style=" font-weight: bold">'. $session->read('Auth.User.username').'</span>'; ?>		
		
		<br><br>
	
		<?php echo $html->link('История заказов', array('controller' => 'orders', 'action' => 'history'), array('class' => 'log' ) ); ?>
			<br />
		<?php echo $html->link('Выход', array('controller' => 'users', 'action' => 'logout'), array('class' => 'log' ) ); ?>

	</td>
	<?php endif ?>

	
	</tr>
	
	

	
	<?php echo $this->element('menu/menu'); ?>
		
</table>
<?php echo $form->create('Gift', array( 'action' => 'search' )  ); ?>
<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015">
<tr>
	<td rowspan="3" width="136" height="17"><?php echo $html->image('se1.jpg')?></td>
	<td width="9"><?php echo $html->image('se2.jpg')?></td>
	<td width="41"><?php echo $html->image('se3.jpg')?></td>
	<td width="58"></td>
	<td width="9"></td>
	<td width="49"><?php echo $html->image('se4.jpg')?></td>
	<td width="13"><?php echo $html->image('se5.jpg')?></td>
	<td rowspan="3" width="71"><?php echo $html->image('se6.jpg')?></td>
	<td width="12"><?php echo $html->image('se7.jpg')?></td>
	<td width="166" background="/za/img/se8.jpg"></td>
	<td width="391" background="/za/img/se8.jpg"></td>
	
	<td width="60"></td>
</tr>


	
    <tr valign="middle">
    	
    	<td height="27"></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td><?php echo $html->image('se92.jpg')?></td>
    	<td></td>
    	<td><?php echo $html->image('se102.jpg')?></td>
    	<td bgcolor="#231f20">
    		<span class="searchform">
    			<?php echo $form->text('string', array( 'size' => '50') ); ?>
    		</span>
    		<span class="search">
    			
    			<?php echo $form->submit('/img/button.jpg', array ('class' => 'searchbutton', 'div' => false) ); ?>
    		</span>
    	</td>
    		<td></td>
    </tr>
    
    <tr>
    	<td height="34"><?php echo $html->image('sekat1.jpg')?></td>
    	<td colspan="2" background="/za/img/sekat2.jpg" class="catalog">КАТАЛОГИ</td>
    	<td><?php echo $html->image('sekat3.jpg')?></td>
    	<td background="/za/img/se123.jpg"></td>
    	<td><?php echo $html->image('se133.jpg')?></td>
    	<td></td>
    	<td><?php echo $html->image('se143.jpg')?></td>
    	<td background="/za/img/se153.jpg" class="menu3">
    		<span class="box">
    			<?php echo $form->checkbox('type'); ?>
    		</span>
    		<span class="box2">
    			Поиск по артикулам &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    			<?php echo $html->link('Расширенный поиск', array('controller' => 'Gifts', 'action' => 'extsearch'), array('class'=>'menu3') ); ?>
    			&nbsp;&nbsp;&nbsp;
    		</span>
    	</td>
    	
    	<td></td>

    	
    </tr>
	


</table>

		<?php 
			if ($this->params['action'] != 'extsearch') {
				echo $form->end();
			} 
		?>
			
			
			
	
<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015">
<tr>
	<td rowspan="12" width="136" valign="top"><?php echo $html->image('kat1.jpg')?></td>
	<td height="19" width="18"><?php echo $html->image('point.jpg', array('name' => 'im1') )?></td>
	<td width="99" align="left">
		<?php echo $html->link( $html->image('oasis.jpg', array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ), array('controller' => 'categories','action' => 'oasis') , array(), false, false ) ?></td>
	<td rowspan="12" width="77"></td>
	<td rowspan="2" colspan="3"></td>
	<td rowspan="12" width="60"></td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td height="2" bgcolor="#a1aea7"></td>
</tr>
<tr>
	<td height="19"><img src="/za/img/point.jpg"  name="im2"></td>
	<td align="left">
		<?php echo $html->link( $html->image('ferre.jpg',  array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ), array('controller' => 'categories','action' => 'oasis', 228,'t') , array(), false, false ) ?></td>
	<td rowspan="2" height="21"><img src="/za/img/newsl.jpg"></td>
	<td rowspan="2" background="/za/img/newsc.jpg" width="607" height="21" class="catalog">НОВОСТИ</td>
	<td rowspan="2" height="21"><img src="/za/img/newsr.jpg"></td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td bgcolor="#a1aea7"></td>
</tr>
<tr>
	<td height="19"><img src="/za/img/point.jpg"  name="im3"></td>
	<td align="left">

		<?php echo $html->link( $html->image('15days.jpg',  array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ), array('controller' => 'categories','action' => 'oasis', 210,'t') , array(), false, false ) ?></td>
	<td rowspan="8" colspan="3">
	
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
	
	</td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td bgcolor="#a1aea7"></td>
</tr>
<tr>
	<td height="19"><img src="/za/img/point.jpg" name="im4"></td>
	<td align="left">
		
		<?php echo $html->link( $html->image('proekt111.jpg', array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ), array('controller' => 'categories','action' => 'proekt111') , array(), false, false ) ?></td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td bgcolor="#a1aea7"></td>
</tr>
<tr>
	<td height="19"><img src="/za/img/point.jpg" name="im5"></td>
	<td align="left">
		<?php echo $html->link( $html->image('usb.jpg', array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ), array('controller' => 'categories','action' => 'usb', 4,'t') , array(), false, false ) ?></td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td bgcolor="#a1aea7"></td>
</tr>
<tr>
	<td height="19"><img src="/za/img/point.jpg" name="im6"></td>
	<td align="left">
		<?php echo $html->link( $html->image('toys.jpg', array('border' => 0, 'onMouseOver' => "show('im4')", 'onMouseOut' => "hide()", 'class' => 'menu' ) ),'/' , array(), false, false ) ?></td>
</tr>
<tr>
	<td height="2" bgcolor="#a1aea7"></td>
	<td bgcolor="#a1aea7"></td>
</tr>
</table>

<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015">

<tr>
	<td width="136"></td>
	<td width="819" class="h"><br><br><?php echo $subheaderTitle; ?></td>
	<td width="60"></td>
</tr>
<tr>
	<td width="136"></td>
	<td width="819" height="2" bgcolor="#a1aea7"></td>
	<td width="60"></td>
</tr>

<tr>
	<td width="136"></td>
	<td width="819" class="text">

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
	<br><br><br>
			<?php echo $content_for_layout; ?>


	</td>
	<td width="60"></td>
</tr>
</table>				
				
<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015" height="140">
<tr>
	<td height="84" width="196"></td>
	<td rowspan="4" width="14" height="117"><?php echo $html->image('downa1.jpg')?></td>
	<td colspan="2" height="84"></td>
	<td rowspan="3" width="220"></td>
	<td rowspan="6" width="324" height="140"><?php echo $html->image('downpazl.jpg')?></td>
</tr>
<tr>
	<td background="/za/img/downline.jpg" height="6"></td>
	<td background="/za/img/downline.jpg" height="6"></td>
	<td rowspan="4" width="14" height="44"><img src="/za/img/downa2.jpg"></td>
	
</tr>
<tr>
	<td rowspan="4" height="50"></td>
	<td width="250" height="21">
		 <?php echo $html->link( 'Главная', '/', array('class' =>'dm' ) )  ?>

		  | <?php echo $html->link( 'Корзина', '/', array('class' =>'dm' ) )  ?>
		  | <?php echo $html->link( 'Контакты', '/', array('class' =>'dm' ) )  ?>
		  | <?php echo $html->link( 'Карта сайта', '/', array('class' =>'dm' ) )  ?>
	</td>
	
</tr>
<tr>
	<td background="/za/img/downline.jpg" height="6"></td>
	<td background="/za/img/downline.jpg" height="6"></td>
	
</tr>
<tr>
	<td colspan="2"></td>
	<td height="11"></td>
	
</tr>
<tr>
	<td colspan="4" height="13"></td>
	
</tr>
</table>

<?php // echo ROOT; ?>

</center>

</body>

	<?php echo $cakeDebug; ?>

</html>
