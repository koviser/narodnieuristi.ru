<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$document = &JFactory::getDocument();
	
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'BGIFTCARD' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {	
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}	
?>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top">
				<table class="admintable">
                                        <tr>
                        <td class="key">
                            <label for="password">
                                <?php echo JText::_( 'CARD PASSWORD' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="password" id="title" class="password" size="20" value="<?php echo $this->escape($this->gift->get('password')); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="dateStart">
                                <?php echo JText::_( 'CARD DATE START' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['dateStart']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="dateEnd">
                                <?php echo JText::_( 'CARD DATE END' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['dateEnd']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="nominal">
                                <?php echo JText::_( 'Nominal' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="nominal" id="nominal" class="inputbox" size="10" value="<?php echo $this->gift->get('nominal'); ?>" /> <?php echo JText::_( 'Bon' ); ?>
                        </td>
                   </tr>
        		</table>
			</td>
		</tr>
	</table>					   	
	<input type="hidden" name="id" value="<?php echo $this->gift->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->gift->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="bgiftcard" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	