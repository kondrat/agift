<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>   
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php __('ZAcss test pages:'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->meta('icon');
		/*
		echo $html->css('reset');
		echo $html->css('typography');
		echo $html->css('grid');
		echo $html->css('forms');
		echo $html->css('za');
		*/
		//echo $html->css('print');
		/*
		echo '<!--[if IE]>';
		echo $html->css('ie');
		echo '<![endif]-->';
		*/		
		echo $scripts_for_layout;
	?>
</head>
<body>
<div class="container showgrid">
	test
</div>
  <div class="container showgrid zaLayout">  
  	  	<div class="span-25 header last">
               	<div class="span-6 prepend-3 header1">
               		<h3>Catalogs</h3>
                	<ul class="left_menu">
						<?php $menu->testmenu('home', 'top');?>
                	</ul>
        		</div>
        		<div class="span-4 prepend-1">
        			<div class="header2">
        				
        				<p class="tel">(495) 9-600-800</p> 
        			</div>       			        			
        		</div>
        		<div class="span-10 header3 showgrid last">
                	<ul class="main_menu">
						<?php $menu->testmenu('home', 'top');?>
                	</ul>
                	
                	<div class="search">
                		
                	</div>        			
        		</div>
        </div><!--header-->
        
   		<div class="prepend-4">
    	<?php
    		if( $session->check('Auth.User.id') ) {
 				$root = __('ZA: ',true).'<span>'.ucwords( strtolower( $session->read('Auth.User.username') ) ).'</span>';
    		} else {
    			$root = __('ZA: Root',true);
    		}
  
    		echo $html->link( $root, array('controller'=>'users', 'action'=>'index'), array( 'class' => 'root' ), false, false );
    	?>
		</div>
    	<div class="container span-10 prepend-5">
			<?php
				if ($session->check('Message.flash')):
				
						echo '<div class="error">';
						$session->flash();
						echo '</div>';
						
				endif;
			?>

			<?php echo $content_for_layout; ?>
		</div>
		<div class="container">
	  	  	<div class="span-25 footer">
                	Footerr
	        </div>
	  	</div>
    </div>

</body>
	<?php echo $cakeDebug; ?>

</html>
