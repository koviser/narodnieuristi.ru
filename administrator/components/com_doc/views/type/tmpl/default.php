<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Type' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
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
                            <label for="title">
                                <?php echo JText::_( 'Title' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $this->item->get('title'); ?>"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="description">
                                <?php echo JText::_( 'DESCRIPTION' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="description" id="description" size="50" maxlength="250" value="<?php echo $this->item->get('description'); ?>"/>
                        </td>
                    </tr>
                </table>
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="type" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
    </fieldset>
    </div>
</form>

	


	