<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );
	
	$document = &JFactory::getDocument();
	$document->addStyleSheet(JURI::root(true).'/media/system/css/modal.css');
	$document->addScript(JURI::root(true).'/media/system/js/modal.js');
	$document->addScript(JURI::root(true).'/administrator/components/com_doc/js/coordinates.js');

	JToolBarHelper::title( JText::_( 'ROO' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'pict.png' );	
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
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div>
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
    	<td width="50%" valign="top">
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
                            <input type="text" name="title" id="title" size="50" maxlength="250" value='<?php echo $this->item->get('title'); ?>'/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="intro_title">
                                <?php echo JText::_( 'intro_title' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="intro_title" id="intro_title" size="50" maxlength="250" value='<?php echo $this->item->get('intro_title'); ?>'/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="full_title">
                                <?php echo JText::_( 'full_title' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="full_title" id="full_title" size="50" maxlength="250" value='<?php echo $this->item->get('full_title'); ?>'/>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="key">
                            <label for="full_adress">
                                <?php echo JText::_( 'full_adress' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="full_adress" id="full_adress" size="50" maxlength="250" value='<?php echo $this->item->get('full_adress'); ?>'/>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="key">
                            <label for="doc_number">
                                <?php echo JText::_( 'doc_number' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="doc_number" id="doc_number" size="50" maxlength="250" value='<?php echo $this->item->get('doc_number'); ?>'/>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="key">
                            <label for="doc_date">
                                <?php echo JText::_( 'doc_date' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['doc_date']; ?>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="key">
                            <label for="signature">
                                <?php echo JText::_( 'signature' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="signature" id="signature" size="50" maxlength="250" value='<?php echo $this->item->get('signature'); ?>'/>
                        </td>
                    </tr>
                    
                    <tr>
                    	<td class="key">
                            <label for="date_procuratory">
                                <?php echo JText::_( 'date_procuratory' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="date_procuratory" id="date_procuratory" size="50" maxlength="250" value='<?php echo $this->item->get('date_procuratory'); ?>'/>
                        </td>
                    </tr>
                    
                    
                    <tr>
                    	<td class="key">
                            <label for="director">
                                <?php echo JText::_( 'director' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="director" id="director" size="50" maxlength="250" value="<?php echo $this->item->get('director'); ?>"/>
                        </td>
                    </tr>
                </table>
    </fieldset>
    </td>
    <td width="50%" valign="top">
    <fieldset class="adminform">
		<legend><?php echo JText::_( 'Front info' ) ?></legend>
				<table class="admintable">
                    <tr>
                    	<td class="key">
                            <label for="front_title">
                                <?php echo JText::_( 'Front Title' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="front_title" id="front_title" size="50" maxlength="250" value='<?php echo $this->item->get('front_title'); ?>'/>
                        </td>
                    </tr>
                                        <tr>
                    	<td class="key">
                            <label for="time">
                                <?php echo JText::_( 'work time' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="time" id="time" size="50" maxlength="250" value='<?php echo $this->item->get('time'); ?>'/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="phone">
                                <?php echo JText::_( 'phone' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="phone" id="phone" size="50" maxlength="250" value="<?php echo $this->item->get('phone'); ?>"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="adress">
                                <?php echo JText::_( 'adress' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="adress" id="adress" size="50" maxlength="250" value='<?php echo $this->item->get('adress'); ?>'/>
                        </td>
                    </tr>
					
                    <tr>
                        <td class="key">&nbsp;</td>
                        <td>
                            <div class="button2-left" style="display:inline">
                                <div class="image">
                                    <a class="modal-button" title="<?php echo JText::_('Set XY'); ?>" href="index.php?option=com_doc&amp;controller=yandexmap&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 640, y: 600}}"><?php echo JText::_('Set XY'); ?></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="latitude"><?php echo JText::_('X'); ?></label>
                        </td>
                        <td>
                            <input type="text" name="latitude" id="latitude" value="<?php echo $this->item->get('latitude'); ?>" size="50" maxlength="50" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="longitude"><?php echo JText::_('Y'); ?></label>
                        </td>
                        <td>
                            <input class="text_area" type="text" name="longitude" id="longitude" size="50" maxlength="50" value="<?php echo $this->item->get('longitude'); ?>"   />
                        </td>
                    </tr>
                </table>

    </fieldset>
    </td>
    </tr>
</table>
    </div>
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="roo" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

	


	