				Личный кабинет:
				<?php echo '<span style=" font-weight: bold">'. $session->read('Auth.User.username').'</span>'; ?>						
					<br />			
				<?php echo $html->link('История заказов', array('controller' => 'orders', 'action' => 'history') ); ?>
					<br />
				<?php echo $html->link('Персональные данные', array('controller' => 'users', 'action' => 'view',$session->read('Auth.User.id')) ); ?>
					<br />
				<?php if( $session->read('Auth.User.group_id') && $session->read('Auth.User.group_id') == 1): ?>
					<?php echo $html->link('Данные пользователей', array('controller' => 'users', 'action' => 'index','user:customer') ); ?>
						<br />
				<?php endif ?>
				<?php echo $html->link('Выход', array('controller' => 'users', 'action' => 'logout') ); ?>		