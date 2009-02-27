<div class="header_catalog">

	<div class="page">
			<?php
				if (isset($toSearch) && $toSearch != null ) {
					$this->passedArgs = $toSearch;	 
					$paginator->options(array('url' => $this->passedArgs )); 
				}
			?>
			<?php if( isset($this->params['paging']['Gift']['pageCount']) && $this->params['paging']['Gift']['pageCount'] > 1 ): ?>
				<?php echo $paginator->prev('Назад', array( 'class' => 'menu2' ) , null,  array('class'=>'menu2'));?>
  				<?php echo $paginator->numbers( array('modulus'=>'5','separator'=>' ' , 'class' => 'menu2' ), null );?>
				<?php echo $paginator->next('Вперед', array( 'class' => 'menu2' ), null, array('class'=>'menu2'));?>
			<?php endif ?>
	</div>
	<br />
	<br />
	<div class="giftsList" style="margin-left: 250px;">
	
		<?php $i = 0; ?>
		<?php foreach ($gifts as $gift): ?>

		<div class="catalog">
			<div class="artikul">
      	<?php
        	//switching the supplier type
        	$supplierType = null;
        	if ( isset($gift['Gift']['supplier'] ) ) {
    			switch ( $gift['Gift']['supplier'] ) {        
           	 		case 2:
           	 //CASE 2 oasis
           	 	$supplierType = 'oasis';	
           	 		break;
           	 		case 3:
           	 //CASE 3 proekt111
           	 	$supplierType = 'proekt111';
           	 		break;
           	 		case 4:
           	 //CASE 3 proekt111
           	 	$supplierType = 'usb';
           	 		break;
           	 	}
        	}
        ?>
				Арт. <?php echo $gift['Gift']['code'];?>
			</div>
			<br />
			<div align="center" class="product">
			<?php echo $html->link( $html->image($supplierType.'/s/'.$gift['Image'][0]['img'], array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$gift['Gift']['id'])  , array(), false, false );?>
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




