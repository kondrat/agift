
<table cellspacing="0" cellpadding="0" border="0" width="819">

	
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
		<?php echo $form->error( 'username', array('class' => 'error', 'style' => 'color: red') ); ?>
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


	<?php echo $form->end( "Войти" ); ?>
	
	</form>
	</td>
</tr>
</table>


