
n: <?php 
					
					if ( $session->check('Auth.User.username') ) {
						echo $userName;
					} else {
						echo 'IP - '. $userName; 
					}
				?>

<?php
	if ( isset($forEmailLineItems) ) { 
    	$i=0;
    	foreach ( $forEmailLineItems as $forEmailLineItems ) {
    		echo 'n ' .($i+1).' - ';
    		echo 'code: '.$forEmailLineItems['code']. ' adn qty: '. $forEmailLineItems['quantity']."\r\n";
    		$i++;
    	}
    }
?>