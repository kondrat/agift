
<div class="">
<?php echo $form->create( array(  'action' => 'search') ) ;?>
	<fieldset>
 		<legend><?php __('Search');?></legend>
	<?php
		echo $form->input('keyword');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="">
	<?php 
		if( isset($res) ) {
			echo '<p>';
			echo count($res);
			echo ' results';
			echo '</p>';
			//debug($res);
			foreach ($res as $re) {
				echo '<div style="border: 1px solid red">';
				echo '<p>';
				echo ($re[0]);
				echo '</p>';
				echo '<p>';
				echo ($re[3]);
				echo '</p>';
				echo '</div><br />';
				
			}
			
			
		}
	?>
</div>
