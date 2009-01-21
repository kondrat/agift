<?php $items = array(
	'Главная' => '/',
	'О компании' => '/pages/company/',
	'Отзывы' => '/pages/feedback/',
	'Корзина' => array('controller' => 'orders', 'action' => 'index'),
	'Контакты' => '/pages/contacs/'
	); 
?>

	<tr align="center">
		<td width="386" height="19"><?php echo $html->image('menu1.jpg')?></td>
		
		<td width="183"><?php echo $html->image('menu2.jpg')?></td>
		
                      <? $here = Router::url(substr($this->here, strlen($this->webroot)-1)) ?>
                      <? foreach ($items as $name => $link): ?>
                          <? if (Router::url($link) == $here): ?>

		<td width="74" class= "menuImgUp"> <?php echo $html->link( $name, $link, array('class' => 'menuup' ) )  ?></td>		

                              
                          <? else: ?>
		<td width="74" class= "menuImg"> <?php echo $html->link( $name, $link, array('class' => 'menu' ) )  ?></td>		
		
                              
                          <? endif ?>
                 		  	<? if ( $name != 'Контакты'): ?>
								<td width="4"></td>
							<? endif ?>
                          
                      <? endforeach ?>
		<td width="60"></td>	
	</tr>