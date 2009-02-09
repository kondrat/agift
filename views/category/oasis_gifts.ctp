<?php //debug($gifts);?>

	<div class="menu_catalog">
		<? echo $tree->generate($stuff , array('element' => 'thisone') ); ?>
	</div>	

	<?php //debug($gifts);?>
<?php 
	//<!--          -----------------------Catalog output ---------------------------------   -->
	$this->params['pass'][1] = null;
?>
				Страницы
				<?php echo $paginator->prev('Назад', array('url' => array( $this->params['pass'][0], $this->params['pass'][1] ), 'class' => 'menu2' ) , null,  array('class'=>'menu2'));?>
  				<?php echo $paginator->numbers( array('url' => array( $this->params['pass'][0], $this->params['pass'][1] ), 'class' => 'menu2' ), null, array('class'=>'menu2', 'span' => null) );?>
				<?php echo $paginator->next('Вперед', array('url' => array( $this->params['pass'][0], $this->params['pass'][1] ), 'class' => 'menu2' ), null, array('class'=>'menu2'));?>

	
	<div class="giftsList">
		




	
<?php 
		$i = 0;
		foreach ($gifts as $gift) {

			echo '<div class="gift">';
			
            echo '<table cellspacing="0" cellpadding="0" border="0" width="245"><tr>';

            echo '<td width="20" height="0">'.$html->link( $html->image('proekt/b_icon.gif', array('border' => 0) ), array( 'controller' => 'orders', 'action' => 'add',$gift['Gift']['id'])  , array(), false, false ).'</td>';

            echo '		<td width="230" align ="center"><br><br>';
          		echo $html->link( $html->image('oasis/s/'.$gift['Image'][0]['img'], array('border' => 0) ), array( 'controller' => 'gifts', 'action' => 'view',$gift['Gift']['id'])  , array(), false, false );
            echo '</td></tr><tr>';
            echo '		<td colspan="2" class="text"><br>';	
            echo '<b>Арт. </b>'.$gift['Gift']['code'].'<br>';
            echo '<b>'.$gift['Gift']['name'].'</b><br>';
            //echo '<b>Размер упаковки. </b>'.$gift['Gift']['packsize'].' см<br>';
            //echo '<b>Тип упаковки. </b>'.$gift['Gift']['packtype'].'<br>';
            //echo '<b>Материал </b>'.$gift['Gift']['material'].'<br>';
            echo '<b>Цена </b>'.$gift['Gift']['price'].' руб.<br>';		


            echo '<br>'. $html->link( '[Подробно о товаре]', array('controller' => 'Gifts', 'action' => 'view',$gift['Gift']['id']), array('class' => 'giftLink') ).'</td></tr></table>';
            		
            	
            			
			
				//debug($gift);

				
                            /*
                            [code] => 2872
                            [supplier] => 3
                            [name] => Папка
                            [color] => 
                            [material] => нейлон
                            [size] => 28,5х32,5х2,5
                            */





                            
                            
                            
			echo '</div><!-- gift -->';
			
				if ($i++ % 2 != 0) {
					echo '<div style="clear: both"></div>';
				}
		}
?>			

			
			
		
		</div><!-- giftsList -->
<?php 
	//<!--          -----------------------END of Catalog output --------------------------------- -->
?>
	

