<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'IMAGE' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {		
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}			
?>

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
<div>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'DESCRIPTION' ) ?></legend>
			<table class="admintable" cellspacing="1" style="width:624px">
				<tr>
                    <td>
                        <strong><?php echo JText::_( 'IMAGE' ); ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php if($this->image->get('image')!=''){ ?>
                            <img src="<?php echo $this->image->get('image'); ?>" /><br/>
                        <?php } ?>	
                        <input type="file" name="image" id="image" class="inputbox"/>
                    </td>
                </tr>
			</table>					
		</fieldset>
				
	</div>    			   	
	<input type="hidden" name="id" value="<?php echo $this->image->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->image->get('id'); ?>" />
    <?php if ( $edit ) {?>
        <input type="hidden" name="id_event" value="<?php echo $this->image->get('id_event'); ?>" />
	<?php } else { ?>
        <input type="hidden" name="id_event" value="<?php echo JRequest::getVar('id_event'); ?>" />
	<?php }	?>
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="image" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
	


	