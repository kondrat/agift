<div class="">
<?php echo $form->create('User',array('action'=>'newpassword'));?>
	<fieldset>
 		<legend>Редактирование данных</legend>
	<?php
		echo $form->input('id');
		echo $form->input('password1',array('type'=>'password','label'=>'Пароль','class'=>'x'));
		echo $form->input('password2',array('type'=>'password','label'=>'Повторить пароль','class'=>'x'));
	?>
	</fieldset>
<?php echo $form->end('Сохранить');?>
</div>
