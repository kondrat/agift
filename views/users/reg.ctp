<table cellspacing="0" cellpadding="0" border="0" width="819">
<tr>
	<td width="385" class="text2" valign="top">
	
	<?php echo $form->create('User', array('action' => 'reg' ) ); ?>
	<fieldset>
	<legend>Регистрационная форма:</legend>
	<table cellspacing="0" cellpadding="0" border="0" class="text3" width="385">

<tr>
	<td colspan="2" height="25"></td>
</tr>
<tr>
	<td height="40" width="120"><b>Логин:</b></td>
	<td width="265">
		<?php echo $form->text('username', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'username', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>

<tr>
	<td height="40" width="120"><b>Пароль:</b></td>
	<td width="265">
        <?php echo $form->password('password1' , array('class' => 'form', 'size' => 36) ); ?>
        <?php echo $form->error( 'password1', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Подтверждение пароля:</b></td>
	<td width="265">
		<?php echo $form->password('password2', array('class' => 'form', 'size' => 36 ) ); ?>
     	<?php echo $form->error( 'password2', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td colspan="2" height="12"></td>
</tr>
</table>
</fieldset>
<br><br><br>
<fieldset>
<legend>Контактная информация:</legend>
	<table cellspacing="0" cellpadding="0" border="0" class="text3" width="385">
<tr>
	<td colspan="2" height="25"></td>
</tr>
<tr>
	<td height="40" width="120"><b>Контактное лицо:</b></td>
	<td width="265">
		<?php echo $form->text('contact', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'contact', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Телефон:</b></td>
	<td width="265">
		<?php echo $form->text('phone', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'phone', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>E-mail:</b></td>
	<td width="265">
		<?php echo $form->text('email', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'email', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr><tr>
	<td colspan="2" height="12"></td>
</tr>
</table>
	
	
	</fieldset>
<br><br>
	
	
	
	</td>
	<td width="49"></td>
	<td width="385" class="text2" valign="top">
	
	
	<fieldset>
	<legend>Дополнительная форма для юридических лиц:</legend>
	<table cellspacing="0" cellpadding="0" border="0" class="text3" width="385">

<tr>
	<td height="40" width="120"><b>Компания:</b></td>
	<td width="265">
		<?php echo $form->text('company', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'company', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Сфера деятельности:</b></td>
	<td width="265">
		<?php echo $form->text('business', array('class' => 'form', 'size' => 36 ) ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Факс:</b></td>
	<td width="265">
		<?php echo $form->text('fax', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'fax', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Адрес сайта:</b></td>
	<td width="265">
		<?php echo $form->text('website', array('class' => 'form', 'size' => 36 ) ); ?>
		<?php echo $form->error( 'website', array('class' => 'error', 'style' => 'color: red') ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Юридический адрес:</b></td>
	<td width="265">
		<?php echo $form->text('address1', array('class' => 'form', 'size' => 36 ) ); ?>
	</td>
</tr>
<tr>
	<td height="40" width="120"><b>Фактический адрес:</b></td>
	<td width="265">
		<?php echo $form->text('address2', array('class' => 'form', 'size' => 36 ) ); ?>
	</td>
</tr>
<tr>
	<td height="140" width="120"><b>Банковские реквизиты:</b></td>
	<td width="265">
		<?php echo $form->input('bank_detail', array( 'type' => 'textarea', 'class' => 'form', 'rows' => 6, 'cols' => 27, 'label' => false ) ); ?>
	</td>
</tr>
</table>
</fieldset>
<br><br>

	
	
	
	</td>
</tr>
</table>
	<div align="left">
		<?php echo $form->submit('Регистрация' ); ?>
	</div>
		<?php echo $form->end(); ?>


 
	</td>
	<td width="60"></td>
</tr>
</table>