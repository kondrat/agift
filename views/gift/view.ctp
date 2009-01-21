<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">
    <tr>
    	<td colspan="3" class="h">
    	
    <font color="#000000"> 
    <?php echo '// Артикул '.$gift['Gift']['code'] ?><br>
    <?php //debug($gift); ?>
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
    	
    	$crumbClass = null;
    	$crumbPath = array();
    	if( $CategoryPass != false ) {
    		foreach ($CategoryPass as $Pass) {
    			foreach ( $Pass as $pas) {
    				if ( $pas['Category']['id'] > 3 ) {
    					//if ( $html->here != $html->webroot)
    						$crumbPath = array( 'controller' => 'categories', 'action' => $supplierType,$pas['Category']['id'],$pas['Category']['name']);
    						$crumbClass = 'menu2';
    					 $html->addCrumb( $pas['Category']['description'], $crumbPath, array('class' => $crumbClass) ); 
     				}
				
    			}
    			$a = $html->getCrumbs( ' '.$html->image( 'str2.jpg', array('alt' => 'arrow',  'border' => 0) ).' ' );
    			echo $a;
    			unset($html->_crumbs);
    			echo '<br />';
    		}
    	}
    	//debug($session->read());
    ?>
	</font><br> 
    <br><?php echo $gift['Gift']['name'] ?></td>
    </tr>
    <tr>
    	<td id="large_img" height="250px"><br><br><?php echo  $html->image( $supplierType.'/b/'.$gift['Image'][0]['img'], array('border' => 0) ); ?></td>
    	<td rowspan="2" width="80"></td>
    	<td rowspan="2">
    	<br>
    	

    	<?php echo  $html->link( $html->image('proekt/b_icon.gif', array('border' => 0) ).'<br />Добавить товар в корзину',  array( 'controller' => 'orders', 'action' => 'add',$gift['Gift']['id']), array('class' => 'text'), false, false ); ?>
    	<br><br>
    	<b>Характеристики предмета</b>
     <br><br>
    <?php if ( $gift['Gift']['supplier'] == 3 ): ?>
    <br><b>Габариты:</b><?php echo ' '. $gift['Gift']['size'];?> см
    <br><b>Материал:</b> <?php echo $gift['Gift']['material'];?>
 	<?php elseif ( $gift['Gift']['supplier'] == 2 ): ?>
          <?php 
          	 if ( $gift['Gift']['packsize'] != null && $gift['Gift']['packsize'] != 0) {
          		echo '<b>Размер упаковки: </b>'.$gift['Gift']['packsize'].' см<br>';
          	}
          ?>
          <?php
          	if ($gift['Gift']['packtype'] != null && $gift['Gift']['packtype'] != 0 ) { 
          		echo '<b>Тип упаковки: </b>'.$gift['Gift']['packtype'].'<br>';
          	}
          ?>
          <?php
          	if ($gift['Gift']['packqty'] != null && $gift['Gift']['packqty'] != 0 ) { 
          		echo '<b>Количество предметов в  упаковке: </b>'.$gift['Gift']['packqty'].' шт.<br>';
          	}
          ?>
          <?php
          	if ( trim($gift['Gift']['weight']) != null && $gift['Gift']['weight'] != 0) { 
          		echo '<b>Вес: </b>'.$gift['Gift']['weight'].' кг.<br>';
          	}
          ?>
 	<?php endif ?>
 	
    <?php if ( $gift['Gift']['supplier'] == 4 ): ?>
    

    <br><b>Материал:</b> <?php echo $gift['Gift']['material'].'<br />';?>

          <?php 
          	 if ( $gift['Gift']['packsize'] != null && $gift['Gift']['packsize'] != 0) {
          		echo '<b>Размер упаковки: </b>'.$gift['Gift']['packsize'].' см<br>';
          	}
          ?>
          <?php
          	if ($gift['Gift']['packtype'] != null && $gift['Gift']['packtype'] != 0 ) { 
          		echo '<b>Тип упаковки: </b>'.$gift['Gift']['packtype'].'<br>';
          	}
          ?>
          <?php
          	if ($gift['Gift']['packqty'] != null && $gift['Gift']['packqty'] != 0 ) { 
          		echo '<b>Количество предметов в  упаковке: </b>'.$gift['Gift']['packqty'].' шт.<br>';
          	}
          ?>
          <?php
          	if ( trim($gift['Gift']['weight']) != null && $gift['Gift']['weight'] != 0) { 
          		echo '<b>Вес: </b>'.$gift['Gift']['weight'].' г.<br>';
          	}
          	if ( trim($gift['Gift']['content1']) != null && $gift['Gift']['content1'] != 0) { 
          		echo '<b>Объем памяти: </b>'.$gift['Gift']['content1'].' Гб.<br>';
          	}
          ?>
 	<?php endif ?>
 
    <br><b>Цена:</b> <?php echo $gift['Gift']['price'];?> руб.

     <br><br>
	<?php if ( in_array($gift['Gift']['supplier'], array(2, 3)  ) ): ?>
    	<?php echo $gift['Gift']['content1'];?>
    	<?php echo '<br />'.$gift['Gift']['content2'];?>
    <?php endif ?>
    	
    	</td>
    </tr>
    <tr>
    	<td height="30"></td>
    </tr>
    <tr>
    	<td class=" <?php echo 'small_img ' .$supplierType?>" >
    		<?php if( is_array( $gift['Image'] ) && count($gift['Image'])> 1 ) :?>
	    		<?php foreach( $gift['Image'] as $thumb ): ?>
	    			<a href=
	    			<?php echo '"/za/img/'.$supplierType.'/b/'.$thumb['img'].'"' ?>
	    			 
	    			<?php  echo $html->image($supplierType.'/s/'.$thumb['img'],  array('border' => 0, 'id' => $thumb['img']) );?> 
	    			</a>
	    			&nbsp;&nbsp;
	    		<?php endforeach ?>
    		<?php endif ?>
    	</td>
    </tr>
</table>


