<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$document = &JFactory::getDocument();
	
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'GIFTCARD' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
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
                            <label for="title">
                                <?php echo JText::_( 'Title' ); ?>
                            </label>
                        </td>
                        <td colspan="3">
                            <input type="text" name="title" id="title" class="inputbox" size="70" value="<?php echo $this->escape($this->gift->get('title')); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="price">
                                <?php echo JText::_( 'Price card' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="price" id="price" class="inputbox" size="10" value="<?php echo $this->gift->get('price'); ?>" /> <?php echo JText::_( 'Currency' ); ?>
                        </td>
                        <td class="key">
                            <label for="published">
                                <?php echo JText::_( 'Published' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['published']; ?>
                        </td>
                    </tr>
                </table>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'info',  $this->gift->get('info') , '100%', '600', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
			</td>
			<td valign="top" width="320" style="padding: 7px 0 0 5px">
				<table width="100%" style="border:1px dashed silver; padding: 5px; margin-bottom: 10px;">
                    <tr>
                        <td>
							<?php echo JText::_('Number purchased'); ?>
                        </td>
                        <td>
                            <input type="text" name="count" id="count" class="inputbox" size="10" value="<?php echo $this->gift->get('count'); ?>" />
                        </td>
                    </tr>
				</table>
                <table class="admintable" width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
                    <tr>
                        <td class="key" colspan="2" style="text-align:center;">
                            <strong><?php echo JText::_( 'IMAGE' ); ?></strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                          	<center>
                                <?php if($this->gift->get('image')!=''){ ?>
                                    <img src="../images/events/<?php echo $this->gift->get('image'); ?>" /><br/>
                                <?php } ?>	
                                <input type="file" name="image" id="image" class="inputbox"/>
                            </center>
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
	<input type="hidden" name="controller" value="giftcard" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	