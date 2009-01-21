


<div class="">
<?php echo $form->create('News');?>
	<fieldset>
 		<legend>Добавить новость</legend>
	<?php

		
		//echo $form->dateTime('created', 'DMY', 'NONE', array( 'day' => date('D'), 'month' => date('M'), 'year' => date('Y')) );
		echo $form->input('created', array('dateFormat' => 'DMY','timeFormat' => 'NONE', 'minYear' => 2007, 'maxYear' => 2020, 'label' => 'Дата&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;') );
		//echo $form->input('user_id', array('type' => 'select', 'empty' => 'None', 'options' => $users));
		echo $form->input('name', array('label' => 'Заголовок ', 'style' => 'width: 259px') );
		echo $form->input('shortbody', array('label' => 'Часть1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'height: 40px') );
		echo $form->input('mainbody', array('label' => 'Часть2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 'style' => 'height: 140px'));
	?>
	</fieldset>
<?php echo $form->end('Сохранить');?>
</div>
<p>
	<?php echo $html->link('Все новости', array('action'=>'index')); ?>
</p>

