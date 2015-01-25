<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );	
	$document = &JFactory::getDocument();
	$document->addStyleSheet('templates/system/css/system.css');
	$document->addStyleSheet('templates/khepri/css/template.css');		
?>
<script type="text/javascript">
		window.addEvent('domready', function() {
			var total = window.parent.$('total');
			total.setHTML(<?php echo $this->total; ?>);
		});
</script>

<form action="index.php" method="post" name="adminForm">
<div class="m">
	<div class="toolbar" id="toolbar">
		<table class="toolbar">
        	<tr>
                <td class="button" id="toolbar-save">
                    <a href="#" onclick="javascript: submitbutton('save')" class="toolbar">
                        <span class="icon-32-save" title="<?php echo JText::_('Save'); ?>">
                        </span>
                        <?php echo JText::_('Save'); ?>
                    </a>
                </td>
                <td class="button" id="toolbar-apply">
                    <a href="#" onclick="javascript: submitbutton('apply')" class="toolbar">
                        <span class="icon-32-apply" title="<?php echo JText::_('Apply'); ?>">
                        </span>
                        <?php echo JText::_('Apply'); ?>
                    </a>
                </td>       
                <td class="button" id="toolbar-cancel">
                    <a href="#" onclick="javascript: submitbutton('cancel')" class="toolbar">
                        <span class="icon-32-cancel" title="<?php echo JText::_('Cancel'); ?>">
                        </span>
                        <?php echo JText::_('Cancel'); ?>
                    </a>
                </td>
            </tr>
		</table>
	</div>
	<div class="header icon-48-pict">
		<?php echo JText::_( 'VARIANT' ) . ': <small><small>[ '. $text .' ]</small></small>'; ?>
	</div>
</div>
	
<div>
		<fieldset class="adminform" style="width:790px;">
		<legend><?php echo JText::_( 'DESCRIPTION' ) ?></legend>
			<table class="admintable" cellspacing="1" width="100%">
				
				<tr>
					<td width="350" class="key">
						<label for="name">
							<?php echo JText::_( 'VARIANT NAME' ); ?>
						</label>
					</td>
					<td>
						<input type="text" name="title" id="title" class="inputbox" size="90" value="<?php echo $this->item->get('title'); ?>" />
					</td>
				</tr> 
				
			</table>					
		</fieldset>
				
	</div>    			   	
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="variant" />
    <input type="hidden" name="option_id" value="<?php echo $this->option_id; ?>" />
    <input type="hidden" name="tmpl" value="component" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>