<div class="header_catalog">
	<?php echo $html->image('logo_usb.jpg', array('border'=>'0'));?>
	<div class="page">
	<?php 
		//<!--          -----------------------Catalog output ---------------------------------   -->
		$this->params['pass'][1] = null;
	?>
			<?php if( isset($this->params['paging']['Gift']['pageCount']) && $this->params['paging']['Gift']['pageCount'] > 1 ): ?>
				<?php echo $paginator->prev('Назад', array('url' => array( $this->params['pass'][0] ), 'class' => 'menu2' ) , null,  array('class'=>'menu2'));?>
  				<?php echo $paginator->numbers( array('modulus'=>'5','separator'=>' ','url' => array( $this->params['pass'][0] ), 'class' => 'menu2' ), null );?>
				<?php echo $paginator->next('Вперед', array('url' => array( $this->params['pass'][0] ), 'class' => 'menu2' ), null, array('class'=>'menu2'));?>
			<?php endif ?>

	</div>
	<div class="menu_catalog">
		<? echo $tree->generate($stuff , array('element' => 'thisone') ); ?>
	</div>	
	
	<div class="giftsList" style="margin-left:250px;">
		<?php $i = 0; ?>
		<?php foreach ($gifts as $gift): ?>
		
		<div class="catalog">
			<div class="artikul">
				Арт. <?php echo $gift['Gift']['code'];?>
			</div>
			<br />
			<div align="center" class="product">
			<?php echo $html->link( $html->image('usb/s/'.$gift['Image'][0]['img'], array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$gift['Gift']['id'])  , array(), false, false );?>
				<br>
			<?php echo $gift['Gift']['name']; ?>
				<br>
			<?php if (isset($gift['Gift']['packsize']) && $gift['Gift']['packsize'] != null): ?>
				Габариты: <?php echo $gift['Gift']['packsize'];?> см <br>
			<?php endif ?>
			<?php if (isset($gift['Gift']['material']) && $gift['Gift']['material'] != null): ?>
				Материал: <?php echo $gift['Gift']['material'];?> <br>
			<?php endif ?>
				<br>
				<b>Цена: <?php echo $gift['Gift']['price'];?> руб.</b> 
				&nbsp;&nbsp;&nbsp;
				<?php echo  $html->link( $html->image('proekt/b_icon.gif', array('border' => 0) ),  array( 'controller' => 'orders', 'action' => 'add',$gift['Gift']['id']), array(), false, false ); ?>
				<br />
			</div>
		</div>
		<?php endforeach ?>

		
	</div><!-- giftsList -->
</div>