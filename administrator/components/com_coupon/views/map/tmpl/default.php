<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$document = &JFactory::getDocument();
	$document->addStyleSheet(JURI::root(true).'/media/system/css/modal.css');
	$document->addScript(JURI::root(true).'/media/system/js/modal.js');
	$document->addScript(JURI::root(true).'/administrator/components/com_coupon/js/coordinates.js');

	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Map' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
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

<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">	
<div>
		<fieldset class="adminform">
		<legend><?php echo JText::_( 'DESCRIPTION' ) ?></legend>
			<table class="admintable" cellspacing="1" style="width:624px">
				<tr>
                	<td class="key">
                    	<label for="title"><?php echo JText::_('Title'); ?></label>
                    </td>
                    <td>
                    	<input type="text" name="title" id="title" size="50" maxlength="250" value="<?php echo $this->map->get('title');; ?>"/>
                    </td>
                </tr>
                <tr>
                	<td class="key">&nbsp;</td>
                	<td>
                        <div class="button2-left" style="display:inline">
                            <div class="image">
                                <a class="modal-button" title="<?php echo JText::_('Set XY'); ?>" href="index.php?option=com_coupon&amp;controller=yandexmap&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 640, y: 600}}"><?php echo JText::_('Set XY'); ?></a>
                            </div>
                        </div>
					</td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="latitude"><?php echo JText::_('X'); ?></label>
                    </td>
                    <td>
                        <input type="text" name="latitude" id="latitude" value="<?php echo $this->map->get('latitude');; ?>" size="50" maxlength="50" />
                    </td>
                </tr>
                <tr>
                    <td class="key">
                        <label for="longitude"><?php echo JText::_('Y'); ?></label>
                    </td>
                    <td>
                        <input class="text_area" type="text" name="longitude" id="longitude" size="50" maxlength="50" value="<?php echo $this->map->get('longitude'); ?>"   />
                    </td>
                </tr>
			</table>					
		</fieldset>
				
	</div>    			   	
	<input type="hidden" name="id" value="<?php echo $this->map->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->map->get('id'); ?>" />
    <?php if ( $edit ) {?>
        <input type="hidden" name="id_event" value="<?php echo $this->map->get('id_event'); ?>" />
	<?php } else { ?>
        <input type="hidden" name="id_event" value="<?php echo JRequest::getVar('id_event') ; ?>" />
	<?php }	?>
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="map" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>