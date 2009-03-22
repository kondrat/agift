<div class="">
<?php echo $form->create('User');?>
	<fieldset>
 		<legend>Редактирование данных</legend>
	<?php
		echo $form->input('id');
		echo $form->input('username',array('label'=>'Логин  ','class'=>'x','div'=>false) );
		echo $form->input('email',array('label'=>'Email  ','class'=>'x'));
		//echo $form->input('password1',array('type'=>'password','label'=>'Пароль','class'=>'x'));
		//echo $form->input('password2',array('type'=>'password','label'=>'Повторить пароль','class'=>'x'));
		echo $form->input('contact',array('label'=>'Контактное лицо:  ','class'=>'x'));
		echo $form->input('phone',array('label'=>'Телефон:  ','class'=>'x'));
		echo $form->input('company',array('label'=>'Компания:  ','class'=>'x'));
		echo $form->input('business',array('label'=>'Сфера деятельности:  ','class'=>'x'));
		echo $form->input('fax',array('label'=>'Факс:  ','class'=>'x'));
		echo $form->input('website',array('label'=>'Адрес сайта:  ','class'=>'x'));
		echo $form->input('address1',array('label'=>'Юридический адрес:  ','class'=>'x'));
		echo $form->input('address2',array('label'=>'Фактический адрес:  ','class'=>'x'));
		echo $form->input('bank_detail',array('label'=>'Банковские реквизиты:  ','class'=>'x'));
	?>
	</fieldset>
<?php echo $form->end('Сохранить');?>
</div>
