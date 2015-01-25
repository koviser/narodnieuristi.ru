<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  
	JHTML::_('behavior.tooltip');
	$document = &JFactory::getDocument();
	$document->addStyleSheet(JURI::root(true).'/media/system/css/modal.css');
	$document->addScript(JURI::root(true).'/media/system/js/modal.js');
	$document->addScript(JURI::root(true).'/administrator/components/com_mocskidka/js/coordinates.js');
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'OPTION' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {		
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}			
?>
  <script type="text/javascript">
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});

			$$('a.modal-button').each(function(el) {
				el.addEvent('click', function(e) {
					new Event(e).stop();
					SqueezeBox.fromElement(el);
				});
			});
		});
  </script>

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
                            <label for="category">
                                <?php echo JText::_( 'Category' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['category']; ?>
                        </td>
                    </tr>
                    <tr>
						<?php if ( $edit ) { ?>
                            <td width="350" class="key">
                                <?php echo JText::_('HAVE'); ?> <a title="<?php echo JText::_('Set variants'); ?>" href="index.php?option=com_coupon&amp;controller=variant&amp;option_id=<?php echo $this->item->get('id'); ?>&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 840, y: 600}}" id="total"><?php echo $this->total; ?></a> <?php echo JText::_('VARIANTS'); ?>
                            </td>
                            <td>
                                <div class="button2-left" style="display:inline">
                                <div class="image">
                                    <a class="modal-button" title="<?php echo JText::_('Set variants'); ?>" href="index.php?option=com_coupon&amp;controller=variant&amp;option_id=<?php echo $this->item->get('id'); ?>&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 840, y: 600}}"><?php echo JText::_('Set variants'); ?></a>
                                </div>
                            </div>
                            </td>
                        <?php }else{ ?>
                            <td colspan="2">   	
                                <?php echo JText::_('PRESS APPLY FOR OPTIONS SET'); ?>
                            </td>
                        <?php } ?>
                    </tr>
                </table>
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="option" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
    </fieldset>
    </div>
</form>

	


	