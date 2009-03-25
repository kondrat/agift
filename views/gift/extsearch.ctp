
<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">

<tr>
	<td width="10" valign="top">
	<td width="410">
	
	<table cellspacing="0" cellpadding="0" border="0">
<tr>
	<td width="40" height="30" align="center">
		<?php echo $form->checkbox('Checkbox.oasisBG');?>
	</td>
	<td width="150"><?php echo $html->image('oasis.jpg' , array('border' => 0) ); ?>BG</td>
	<td>
		<?php echo $form->select( 'Cat.oasisBG',  $OasisBG , 0 ,array(), false );?>

	</td>
</tr>
<tr>
	<td width="40" height="30" align="center">
		<?php echo $form->checkbox('Checkbox.oasisEX');?>
	</td>
	<td width="150"><?php echo $html->image('oasis.jpg' , array('border' => 0) ); ?>EX</td>
	<td>
		<?php echo $form->select( 'Cat.oasisEX',  $OasisEX , 0 ,array(), false );?>

	</td>
</tr>
<tr>
	<td align="center" height="30">
		<?php echo $form->checkbox('Checkbox.ferre');?>
	</td>
	<td><?php echo $html->image('ferre.jpg' , array('border' => 0) ); ?></td>
	<td>
		<?php echo $form->select( 'Cat.ferre', array( $FERRE ), 0,array(), false );?>
	</td>
</tr>
<tr>
	<td align="center" height="30">
		<?php echo $form->checkbox('Checkbox.penoteka');?>
	</td>
	<td>Penoteka</td>
	<td>
		<?php echo $form->select( 'Cat.penoteka', array( $PENOTEKA ), 0,array(), false );?>
	</td>
</tr>
<tr>

	<td align="center" height="30">
		<?php echo $form->checkbox( 'Checkbox.15days');?>
	</td>
	<td><?php echo $html->image('15days.jpg' , array('border' => 0) ); ?></td>
	<td>
		<?php echo $form->select( 'Cat.15days', array( $days15 ), 0,array(), false );?>
	</td>
</tr>
<tr>
	<td align="center" height="30">
		<?php echo $form->checkbox( 'Checkbox.proekt111');?>
	</td>
	<td><?php echo $html->image('proekt111.jpg' , array('border' => 0) ); ?></td>
	<td>
		<?php echo $form->select( 'Cat.proekt111', array( $proekt111 ), 0,array(), false );?>
	</td>
</tr>
<tr>
	<td align="center" height="30">
		<?php echo $form->checkbox( 'Checkbox.usb');?>
	</td>
	<td><?php echo $html->image('usb.jpg' , array('border' => 0) ); ?></td>
	<td><select name="oasis1">
	<option value="1" SELECTED>Поиск по всему каталогу</option>
	<option value="2">Ручки</option>
	<option value="3">Зажигалки</option>
	<option value="4">Футболки</option>
</select></td>
</tr>
<tr>
	<td align="center" height="30">
		<?php echo $form->checkbox( 'Checkbox.toys');?>
	</td>
	<td><?php echo $html->image('toys.jpg' , array('border' => 0) ); ?></td>
	<td><select name="oasis2">
	<option value="1" SELECTED>Поиск по всему каталогу</option>
	<option value="2">Ручки</option>
	<option value="3">Зажигалки</option>
	<option value="4">Футболки</option>
</select></td>
</tr>
</table>
	
	</td>
	<td width="39"></td>
	<td width="370" valign="top">
	
	Цена от: &nbsp;&nbsp;
		<?php echo $form->text('priceMin', array('size' => 5, 'style' => 'height: 20') ); ?>
		<?php echo $form->error( 'priceMin', array('class' => 'error', 'style' => 'color: red') ); ?>
		 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;до: &nbsp;&nbsp;
		<?php echo $form->text('priceMax', array('size' => 5, 'style' => 'height: 20') ); ?> руб.
		<?php echo $form->error( 'priceMax', array('class' => 'error', 'style' => 'color: red') ); ?>
		
	<br><br>
		<?php echo $form->radio( 'priceOrder', array( 'asc' => 'Сортировать по возрастанию цены', 'desc' => 'Сортировать по убыванию цены' ), array('separator' => '<br />', 'label' => true)  );?>
		
	<br />
	<br />
	
	
		<?php echo $form->submit('/img/button.jpg', array ('class' => 'searchbutton', 'div' => false) ); ?>
		<?php 
			if ($this->params['action'] == 'extsearch') {
				
				echo $form->end();
			} 
		?>	
	</td>

</table>


