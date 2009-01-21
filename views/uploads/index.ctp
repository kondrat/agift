<?php

/***********************************************
 * IMPORTANT * 
 * for file handler component, do not use any
 * helpers ($html->file('userfile')) - this will
 * not work.  use standard html
 * <input type="file" name="userfile">
 */
?>
<?php echo $form->create( 'Uploads', array('action' => 'index' ,'type' => 'file') ); ?>

<input type="file" name="userfile[]"/>
<br/>
<input type="file" name="userfile[]"/>
<br/>
extra info
<?php echo $form->input('data/extra_field'); ?>
<br/>
<?php echo $form->end('Upload');?>

<?php
if (isset($uploadData)) {
    debug($uploadData);
}

if (isset($errorMessage)) {
   debug ($errorMessage);
}
?>
</form>
