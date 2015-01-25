<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Comment' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {	
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}			
?>

<form action="index.php" method="post" name="adminForm">
<div>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'DESCRIPTION' ) ?></legend>
				<table class="admintable">
                    <tr>
                    	<td class="key">
                            <label for="published">
                                <?php echo JText::_( 'Published' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['published']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" colspan="2" style="text-align:left;">
                            <label for="message">
                                <?php echo JText::_( 'Message' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea cols="80" rows="5" name="message" id="message"><?php echo $this->item->get('message'); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="key" colspan="2" style="text-align:left;">
                            <label for="message">
                                <?php echo JText::_( 'Answer' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea cols="80" rows="5" name="answer" id="answer"><?php echo $this->item->get('answer'); ?></textarea>
                        </td>
                    </tr>
                </table>
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="comments" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
    </fieldset>
    </div>
</form>

	


	