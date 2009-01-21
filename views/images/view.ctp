


<div class="">
<div>
		<?php echo $html->link(__('Back', true), $referer ); ?>	
</div>

	<dl><?php $i = 0; $class = ' class="altrow"';?>

		
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $news['News']['name']; ?>
			&nbsp;
		</dd>
		<br />
		
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $news['News']['shortbody'].''.$news['News']['mainbody']; ?>
			&nbsp;
		</dd>
		
		
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo date( 'd.m.y', strtotime($twoNews[0]['News']['created']) ); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit News', true), array('action'=>'edit', $news['News']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete News', true), array('action'=>'delete', $news['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $news['News']['id'])); ?> </li>
		<li><?php echo $html->link(__('List News', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New News', true), array('action'=>'add')); ?> </li>
	</ul>
</div>



