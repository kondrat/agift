<form id="UserLoginForm" method="post" action="/agift/users/login">
<?php //echo $form->create('User', array( 'action' => 'login' ), array('id' => 'rec2') ); ?>
	<fieldset style="display:none;">
		<input type="hidden" name="_method" value="POST" />
	</fieldset>		
	<div class="headerfield">Вход в личный кабинет</div>
	<div class="formfield">Логин:</div>
		<input name="data[User][username]" type="text" size="20" value="" id="UserUsername" />
		<?php //echo $form->input('username', array('type' => 'text', 'size' => 20, 'div'=> null, 'label' => false, 'error' => false) );?>
			<br />
	<div class="formfield">Пароль:</div>
		<input type="password" name="data[User][password]" size="11" value="" id="UserPassword" />
		<?php //echo $form->input('password', array( 'size' => 11,  'label' => false, 'div' => false) );?>
		<input type="hidden" name="data[User][onfly]" value="1" id="UserOnfly" />
		<?php //echo $form->hidden('onfly', array('value' => true));?>
		<input type="submit" class="submit" value="Вход" />
		<?php //echo $form->submit( "Вход", array( 'class' => 'submit','div' => false) ); ?>
			<br/>
		<?php echo $html->link("Забыли пароль?", array( 'controller' => 'users', 'action' => 'password_reset') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $html->link( 'Регистрация', array( 'controller' => 'users', 'action' => 'reg' ) ); ?>
</form>
<?php //echo $form->end(); ?>