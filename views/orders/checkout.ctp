
<?php //debug($session->read()); ?>

<table cellspacing="0" cellpadding="0" border="0" width="819">
<tr>
	<td width="400" class="text2" valign="top">
	
	<?php echo $form->create('Order', array('action' => 'step2' ) ); ?>
	<fieldset>
		<legend>Вход без регистрации:</legend>
	<table cellspacing="0" cellpadding="0" border="0" class="text3" width="400">

<tr>
	<td height="40" width="120"><b>Имя:</b></td>
	<td width="280">
		
		<?php echo $form->input('firstname', array('size' => 36, 'label' => false, 'class' => 'form','error' => false ) ); ?>
		<?php echo $form->error( 'firstname', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Телефон:</b></td>
	<td width="280">
		<?php echo $form->input('phone', array('size' => 36, 'label' => false, 'class' => 'form', 'error' => false ) ); ?>
		<?php echo $form->error( 'phone', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>E-mail:</b></td>
	<td width="280">
		<?php echo $form->input('email', array('size' => 36, 'label' => false, 'class' => 'form', 'error' => false ) ); ?>
		<?php echo $form->error( 'email', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
</table>
</fieldset>
<br><br>
	<?php echo $form->submit('Завершить заказ', array('name' => 'next_step') ); ?>
	<?php echo $form->end(); ?>
	
	</form>
	</td>
	
	
	
	
	
	<td width="49"></td>
	<td width="370" class="text2" valign="top">
	
	<?php echo $form->create('User', array('action' => 'login' ) ); ?>
	
	<fieldset>
	<legend>Вход в личный кабинет:</legend>
	<table cellspacing="0" cellpadding="0" border="0" class="text3" width="370">

<tr>
	<td height="40" width="120"><b>Логин:</b></td>
	<td width="250">
		<?php echo $form->input('username', array('type' => 'text', 'size' => 20,'class' => 'form',  'label' => false) );?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Пароль:</b></td>
	<td width="250">
		<?php echo $form->input('password', array( 'size' => 20,'class' => 'form',  'label' => false) );?>
	</td>
</tr>
<tr>
	<td height="40" colspan="2">
		<?php echo $html->link("Забыли пароль?", array( 'action' => 'password_reset'), array('class' => 'dm' ) ); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link( 'Регистрация', array( 'action' => 'reg' ), array('class' => 'dm' ) ); ?>

	</td>
</tr>
</table>
</fieldset>
<br><br>

	<?php echo $form->submit('Войти и завершить заказ', array('name' => 'log_checkout') ); ?>
	<?php echo $form->end(); ?>	
	</form>
	</td>
</tr>
</table>