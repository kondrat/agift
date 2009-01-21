
<div class="" style="">

<p>
    <?php
    	echo $paginator->counter( array( 'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true) ));
    ?>
</p>
<div class="paging">
	<table>
		<tr>
			<td><?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?></td>
  			<td><?php echo $paginator->numbers();?></td>
			<td><?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?></td>
		</tr>
	</table>
</div>
<table cellpadding="4" cellspacing="0" border="1">
<tr>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('mainbody');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($gifts as $gift):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $new['News']['name']; ?>
		</td>
		<td>
			<?php echo $new['News']['mainbody']; ?>
		</td>
		<td>
			<?php echo date( 'd.m.y', strtotime($new['News']['created']) ); ?>
		</td>
		
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $new['News']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $new['News']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $new['News']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $new['News']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('More News', true), array('action'=>'add')); ?></li>
	</ul>
</div>



