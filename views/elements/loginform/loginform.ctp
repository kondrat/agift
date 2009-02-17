				<?php echo $form->create('User', array( 'action' => 'login' ), array('id' => 'rec2') ); ?>		
					<div class="headerfield">Вход в личный кабинет</div>
					<div class="formfield">Логин:</div>
						<?php echo $form->input('username', array('type' => 'text', 'size' => 20, 'div'=> null, 'label' => false, 'error' => false) );?>
						<br />
					<div class="formfield">Пароль:</div>
						<?php echo $form->input('password', array( 'size' => 11,  'label' => false, 'div' => false) );?>
						<?php echo $form->hidden('onfly', array('value' => true));?>
						<?php echo $form->submit( "Вход", array( 'class' => 'submit','div' => false) ); ?>
						<br/>
						<?php echo $html->link("Забыли пароль?", array( 'controller' => 'users', 'action' => 'password_reset') ); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php echo $html->link( 'Регистрация', array( 'controller' => 'users', 'action' => 'reg' ) ); ?>
				<?php echo $form->end(); ?>