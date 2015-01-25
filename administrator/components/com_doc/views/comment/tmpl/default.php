<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Comment' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
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
			<table class="admintable" cellspacing="1" style="width:800px">
				<tr>
					<td width="350" class="key">
						<label for="name">
							<?php echo JText::_( 'Name' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="name" id="name" class="inputbox" size="90" value="<?php echo $this->escape($this->item->get('name')); ?>" />
					</td>
				</tr>
                <tr>
                    <td valign="top" class="key">
                        <label for="image"><?php echo JText::_( 'IMAGE' ); ?></label>
                    </td>
                    <td>
                    	<?php if($this->item->get('image')!=""){ ?>
                        	<div><img src="../<?php echo $this->item->get('image'); ?>" /></div>
                        <?php } ?>
                        <input class="text_area" type="text" name="image" id="image" value="<?php echo $this->item->get('image'); ?>" size="70" maxlength="250" />
                        <div class="button2-left" style="float:left;">
							<div class="image">
								<a class="modal-button" title="<?php echo JText::_( 'IMAGE' ); ?>" href="index.php?option=com_doc&amp;controller=image&amp;view=images&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 760, y: 520}}"  >
									<?php echo JText::_( 'IMAGE' ); ?>
                                </a>
							</div>
						</div> 
                    </td>
                </tr>
				<tr>
					<td class="key" colspan="2" style="text-align:left;">
						<label for="text">
							<?php echo JText::_( 'Comment' ); ?>
						</label>
					</td>
				</tr>
                <tr>
					<td colspan="2">
						<?php
							$editor = &JFactory::getEditor();
							echo $editor->display( 'text',  $this->item->get('text') , '100%', '200', '60', '20', array() ) ;
						?>
					</td>
				</tr>
			</table>					
		</fieldset>
				
	</div>    			   	
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="comments" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
	


	