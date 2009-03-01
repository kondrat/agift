

<table cellspacing="0" cellpadding="0" border="0" width="819" class="text">
    <tr>
    	<td colspan="3" class="h">
    	
		<div align="center">ВАША КОРЗИНА ПУСТА</div>
		
			 <br><br><br>

    	</td>
    </tr>
</table>

	<?php 	if( isset($files) && $files != array() ) {
		echo '<p>Загруженные логотипы</p>';
				foreach ( $files as $file ) {
					 echo '<p class= "file">'.$html->link($file['FileUpload']['file_name'], array('controller'=>'Orders','action'=>'history','file:'.$file['FileUpload']['id']) ).'</p>';
					 echo '<p class= "delFile">'.$html->link('Удалить',array('controller'=>'uploads','action'=>'delete',$file['FileUpload']['id']), array(), 'Подтверждаете удаление ?' ).'</p>';
				}
			}
	?>
