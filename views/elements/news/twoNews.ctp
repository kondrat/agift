<?php 
	//App::import('Core', 'Flay');
	$twoNews = $this->requestAction('news/index');	
?>						
							
		<div class="news">
			НОВОСТИ
			<div class="newsimg"><?php echo $html->image('a_type_ag.jpg', array( 'border' => '0') ); ?></div>
		</div>		
		<?php foreach($twoNews as $singlNews ): ?>
			<div class="newsblock">
				<div>
					<?php echo $html->link( date( 'd.m.y', strtotime($singlNews['News']['created']) ).' '. $singlNews['News']['name'], array('controller'=>'news', 'action'=>'view', $singlNews['News']['id'] ), array('class' => 'headernews') ); ?>
				</div>
				<div>
					<?php echo $html->link( $singlNews['News']['shortbody'].' '.$html->image('str2.jpg',array('border' => '0') ), array('controller'=>'news', 'action'=>'view', $singlNews['News']['id'] ), array('class' =>'bodynews' ),null, null ) ?>				
				</div>
			</div>
		<?php endforeach ?>								
		<div class="arhiv">
			<br>
			<?php echo $html->link('Архив новостей &nbsp;'.$html->image('str2.jpg', array('border' => '0') ), array('controller'=>'news', 'action'=>'index'), array('class' => 'arhiv'),null,null ); ?>
		</div>