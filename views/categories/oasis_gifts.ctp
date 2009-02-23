<div class="header_catalog">
	<?php 
		if ( isset($stuff['0']['Category']['parent_id']) ) {
			$logoImage = null;
			switch($stuff['0']['Category']['parent_id']) {
				case 143:
					$logoImage = 'logo_oasis.jpg';
					break;
				case 137: 
					$logoImage = 'logo_oasis.jpg';
					break;
				case 228: 
					$logoImage = 'logo_ferre.jpg';
					break;
				case 210: 
					$logoImage = 'logo_15.jpg';
					break;
				default:
					$logoImage = 'logo_oasis.jpg';
					break;				
			}
			echo $html->image($logoImage, array('border'=>'0'));
		}
	?>
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
	
	<div class="giftsList">
	
		<?php $i = 0; ?>
		<?php foreach ($gifts as $gift): ?>
		
		<div class="catalog">
			<div class="artikul">
				Арт. <?php echo $gift['Gift']['code'];?>
			</div>
			<br />
			<div align="center" class="product">
			<?php echo $html->link( $html->image('oasis/s/'.$gift['Image'][0]['img'], array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$gift['Gift']['id'])  , array(), false, false );?>
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

	

