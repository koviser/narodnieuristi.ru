<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	JToolBarHelper::title(JText::_('MASSMAIL MANAGER'), 'frontpage' );
	JToolBarHelper::customX( 'test', 'send.png', 'send_f2.png', JText::_( 'test send' ), false );		
	JToolBarHelper::customX( 'send', 'send.png', 'send_f2.png', JText::_( 'Send' ), false );
?>
<form action="index.php" name="adminForm" method="post">
		<div class="col">
			<fieldset class="adminform">
				<legend><?php echo JText::_( 'Message' ); ?></legend>

				<table class="admintable">
				<tr>
					<td class="key">
						<label for="mm_subject">
							<?php echo JText::_( 'Subject' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox" type="text" name="mm_subject" id="mm_subject" value="" size="150" />
					</td>
				</tr>
                <tr>
					<td class="key" nowrap="nowrap">
						<label for="group">
							<?php echo JText::_( 'SEND Group' ); ?>:
						</label>
					</td>
					<td>
						<?php echo $this->lists['group'];?>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<label for="mm_message">
							<?php echo JText::_( 'Message' ); ?>:
						</label>
					</td>
					<td id="mm_pane" >
						<?php
							$editor = &JFactory::getEditor();
							echo $editor->display( 'mm_message' , '', '100%', '600', '60', '20', array('readmore', 'pagebreak', 'block', 'image'), array() ) ;
						?>
					</td>
				</tr>
				</table>
			</fieldset>
		</div>
		<div class="clr"></div>

		<input type="hidden" name="option" value="com_coupon" />
        <input type="hidden" name="controller" value="massmail" />
		<input type="hidden" name="task" value="" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>


