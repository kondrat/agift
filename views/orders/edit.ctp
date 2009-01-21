<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="1015">
<tr>
	<td width="136"></td>
	<td width="819" class="h"><br><br>НОВОСТИ</td>
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



<div class="">
<?php echo $form->create('News');?>
	<fieldset>
 		<legend><?php __('Edit News');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('created', array('dateFormat' => 'DMY','timeFormat' => 'NONE', 'minYear' => 2007, 'maxYear' => 2020) );
		echo $form->input('name');
		echo $form->input('shortbody');
		echo $form->input('mainbody');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List News', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('Add News', true), array('action'=>'add')); ?> </li>
	</ul>
</div>







		</td>
	</tr>
</table>

