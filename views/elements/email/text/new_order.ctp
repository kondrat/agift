
Дружок, у тебя новый заказик.

Юзерка звать : <?php 
					
					if ( $session->check('Auth.User.username') ) {
						echo $userName;
					} else {
						echo 'Анонимчик, слал с IP - '. $userName; 
					}
				?>

<?php
	if ( isset($forEmailLineItems) ) { 
    	$i=0;
    	foreach ( $forEmailLineItems as $forEmailLineItems ) {
    		echo 'Вот номер ' .($i+1).' - ';
    		echo 'Артикул: '.$forEmailLineItems['code']. ' и их типа нада: '. $forEmailLineItems['quantity']."\r\n";
    		$i++;
    	}
    }
?>