<div style="float:left">
	
	<?php echo $form->create('Order', array('action' => 'step2' ) ); ?>
	<fieldset>
		<legend>Вход без регистрации:</legend>
		
		<?php echo $form->input('firstname', array('size' => 36, 'label' => 'Name', 'error' => false ) ); ?>
		<?php echo $form->error( 'firstname', array('class' => 'error', 'style' => 'color: red') ); ?>

		<?php echo $form->input('phone', array('size' => 36, 'label' => 'Phone',  'error' => false ) ); ?>
		<?php echo $form->error( 'phone', array('class' => 'error', 'style' => 'color: red') ); ?>

		<?php echo $form->input('email', array('size' => 36, 'label' => 'Email',  'error' => false ) ); ?>
		<?php echo $form->error( 'email', array('class' => 'error', 'style' => 'color: red') ); ?>

<br><br>
	<?php echo $form->submit('Завершить заказ', array('name' => 'next_step') ); ?>
	<?php echo $form->end(); ?>
	</fieldset>
</div>

	
	
	
<div style="float:left">	
	<fieldset>
		<legend>Вход в личный кабинет:</legend>
	
	<?php echo $form->create('User', array('action' => 'login' ) ); ?>
	


		<?php echo $form->input('username', array('type' => 'text', 'size' => 20,'class' => '',  'label' => 'Name') );?>

		<?php echo $form->input('password', array( 'size' => 20,'class' => '',  'label' => 'Password') );?>

		<?php echo $html->link("Забыли пароль?", array( 'action' => 'password_reset'), array('class' => 'dm' ) ); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link( 'Регистрация', array( 'action' => 'reg' ), array('class' => 'dm' ) ); ?>



	<?php echo $form->submit('Войти и завершить заказ', array('name' => 'log_checkout') ); ?>
	<?php echo $form->end(); ?>	
	</fieldset>
</div>
<div style="clear:both;"></div>
