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




<div class="products form">
<?php echo $form->create('News');?>
	<fieldset>
 		<legend><?php __('Add News');?></legend>
	<?php

		
		//echo $form->dateTime('created', 'DMY', 'NONE', array( 'day' => date('D'), 'month' => date('M'), 'year' => date('Y')) );
		echo $form->input('created', array('dateFormat' => 'DMY','timeFormat' => 'NONE', 'minYear' => 2007, 'maxYear' => 2020) );
		//echo $form->input('user_id', array('type' => 'select', 'empty' => 'None', 'options' => $users));
		echo $form->input('name');
		echo $form->input('shortbody', array('style' => 'height: 40px') );
		echo $form->input('mainbody', array('style' => 'height: 140px'));
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List News', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('delete', true), array('action'=>'delete')); ?> </li>
		<li><?php echo $html->link(__('edit', true), array( 'action'=>'edit')); ?> </li>
	</ul>
</div>







		</td>
	</tr>
</table>
