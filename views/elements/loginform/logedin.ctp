				Личный кабинет:
				<?php echo '<span style=" font-weight: bold">'. $session->read('Auth.User.username').'</span>'; ?>						
					<br />			
				<?php echo $html->link('История заказов', array('controller' => 'orders', 'action' => 'history') ); ?>
					<br />
				<?php echo $html->link('Выход', array('controller' => 'users', 'action' => 'logout') ); ?>		