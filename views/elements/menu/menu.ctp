<?php $items = array(
	'Каталоги' => '/',
	'Главная' => '/',
	'О компании' => '/pages/company/',
	'Корзина' => array('controller' => 'orders', 'action' => 'index'),
	'Отзывы' => '/pages/feedback/',
	'Контакты' => '/pages/contacs/'
	); 
?>

		<div class="menu">				
		    <? $here = Router::url(substr($this->here, strlen($this->webroot)-1)) ?>
		    		<?php $i = 0;?>
		    <? foreach ($items as $name => $link): ?>
		        <? if (Router::url($link) == $here): ?>	
		  		 <?php echo $html->link( '<span>'.$name.'</span>', $link, array('class' => 'menu_button', 'id' => 'left'.$i ), false, false )  ?>
		        <? else: ?>
		  			 <?php echo $html->link( '<span>'.$name.'</span>', $link, array('class' => 'menu_button', 'id' => 'left'.$i ), false, false )  ?>		
		        <? endif ?>
		  		<?php $i++;?>
		    <? endforeach ?>
		</div>