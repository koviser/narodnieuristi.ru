<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $pane = &JPane::getInstance('sliders', array('allowAllClose' => false, 'startOffset' => 0)); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$document = &JFactory::getDocument();
	$document->addStyleSheet(JURI::root(true).'/media/system/css/modal.css');
	$document->addScript(JURI::root(true).'/media/system/js/modal.js');
	$document->addScript(JURI::root(true).'/administrator/components/com_coupon/js/coordinates.js');
	
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Event' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
	if ( $edit ) {
		
		JToolBarHelper::customX( 'preview', 'preview.png', 'preview_f2.png', "Демо", false );
		JToolBarHelper::customX( 'map', 'map.png', 'map_f2.png', JText::_( 'Map' ), false );
		JToolBarHelper::customX( 'image', 'image.png', 'image_f2.png', JText::_( 'Image' ), false );		
	}
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
<script type="text/javascript">
	function jSelectArticle(id, title, object) {
		document.getElementById('advertiser').value = id;
		$(object + '_name').setHTML(title);
		document.getElementById('sbox-window').close();
	}
</script>
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
                            <input type="text" name="title" id="title" class="inputbox" size="70" value="<?php echo $this->escape($this->event->get('title')); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="sale">
                                <?php echo JText::_( 'Sale' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="sale" id="sale" class="inputbox" size="10" value="<?php echo $this->event->get('sale'); ?>" /> %
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
                    <tr>
                        <td class="key">
                            <label for="free">
                                Беспалатная акция
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['free']; ?>
                        </td>
                        <td class="key">
                            <label for="day">
                                Акция дня
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['day']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="price">
                                <?php echo JText::_( 'Price' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="price" id="price" class="inputbox" size="10" value="<?php echo $this->event->get('price'); ?>" /> <?php echo JText::_( 'Currency' ); ?>
                        </td>
                        <td class="key">
                            <label for="realPrice">
                                <?php echo JText::_( 'Real Price' ); ?> 
                            </label>
                        </td>
                        <td>
                            <input type="text" name="realPrice" id="realPrice" class="inputbox" size="10" value="<?php echo $this->event->get('realPrice'); ?>" /> <?php echo JText::_( 'Currency' ); ?>
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
                        <td class="key">
                            <label for="count_people">
                                Кол-во человек
                            </label>
                        </td>
                        <td>
                            от <?php echo $this->lists['min']; ?> до <?php echo $this->lists['max']; ?>
                        </td>
                    </tr>
                </table>
                <?php													
					echo $pane->startPane("jpane-detail");
					echo $pane->startPanel( JText::_("Description"), "cdetail-detail-description" );
				?>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'info',  $this->event->get('info') , '100%', '600', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INTRO TEXT"), "cdetail-detail-intro" );
				?>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'intro',  $this->event->get('intro') , '100%', '400', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
                <?php	
					echo $pane->endPanel();																						
					echo $pane->startPanel( JText::_("Terms"), "cdetail-detail-terms" );
				?>
				<table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'terms',  $this->event->get('terms') , '97%', '400', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>

					</tr>
				</table>
                <?php
					echo $pane->endPanel();																						
					echo $pane->startPanel( JText::_("Options"), "cdetail-detail-options" );
				?>
					<?php echo $this->lists['options'];?>
                <?php	
					echo $pane->endPanel();																						
					echo $pane->startPanel( JText::_("Contacts"), "cdetail-detail-contacts" );
				?>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'contacts',  $this->event->get('contacts') , '100%', '400', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
                <?php	
					echo $pane->endPanel();	
					echo $pane->endPane();	
				?>
			</td>
			<td valign="top" width="320" style="padding: 7px 0 0 5px">
				<table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
					<tr>
                        <td>
							<?php echo JText::_('Number purchased'); ?>
                        </td>
                        <td>
							<?php echo $this->event->get('count'); ?>
                        </td>
                    </tr>
				</table>
                 <table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
					<tr>
                        <td colspan="2">
							<strong>Дополнительное описание :</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
							Подзаголовок
                        </td>
                        <td>
							<input type="text" name="subtitle" id="meta_title" class="inputbox" size="30" value="<?php echo $this->event->get('subtitle'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							Условия
                        </td>
                        <td>
							<textarea name="subterms" cols="30" rows="10"><?php echo $this->event->get('subterms'); ?></textarea>
                        </td>
                    </tr>
          
				</table>
                
                <table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
					<tr>
                        <td colspan="2">
							<strong>Meta описание :</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
							Заголовок
                        </td>
                        <td>
							<input type="text" name="meta_title" id="meta_title" class="inputbox" size="30" value="<?php echo $this->event->get('meta_title'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							Описание
                        </td>
                        <td>
							<textarea name="meta_desc" cols="30" rows="10"><?php echo $this->event->get('meta_desc'); ?></textarea>
                        </td>
                    </tr>
          
				</table>
                <table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
					<tr>
                        <td width="1%" nowrap="nowrap">
							<strong><?php echo JText::_('customer'); ?> :</strong>
                        </td>
                        <td>
							<span id="advertiser_name"><?php if($this->user->username!=""){?><?php echo $this->user->name; ?> <?php echo $this->user->family; ?> (<a href="index.php?option=com_users&view=user&task=edit&cid[]=<?php echo $this->user->id; ?>"><?php echo $this->user->username; ?></a>)<?php } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>	
                        <div class="button2-left">
                        	<div class="blank">
                            	<a class="modal" href="index.php?option=com_coupon&amp;task=advertiser&amp;controller=event&amp;tmpl=component&amp;object=advertiser" rel="{handler: 'iframe', size: {x: 650, y: 375}}">
                                	<?php echo JText::_( 'Select' ); ?>
                                </a>
                            </div>
                        </div>
						<input type="hidden" id="advertiser" name="advertiser" value="<?php echo $this->event->get('advertiser'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php echo JText::_('customer email'); ?>
                        </td>
                        <td>
							<input type="text" name="email" id="email" class="inputbox" size="30" value="<?php echo $this->event->get('email'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php echo JText::_('customer password'); ?>
                        </td>
                        <td>
							<input type="text" name="password" id="password" class="inputbox" size="30" value="<?php echo $this->event->get('password'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php echo JText::_('Company'); ?>
                        </td>
                        <td>
							<input type="text" name="company" id="company" class="inputbox" size="30" value="<?php echo $this->escape($this->event->get('company')); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php echo JText::_('Site urls'); ?>
                        </td>
                        <td>
							<input type="text" name="url" id="url" class="inputbox" size="30" value="<?php echo $this->event->get('url'); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
							<?php echo JText::_('phone'); ?>
                        </td>
                        <td>
							<input type="text" name="phone" id="phone" class="inputbox" size="30" value="<?php echo $this->event->get('phone'); ?>" />
                        </td>
                    </tr>
				</table>
                <table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
					<tr>
                        <td nowrap="nowrap">
							<strong><?php echo JText::_('metro'); ?> :</strong>
                        </td>
					</tr>
                    <tr>
                        <td>
                        	<?php echo $this->lists['metro']; ?>
                        </td>
                    </tr>
                   </table>
                   <!--
                	<table class="admintable" width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
                    	<tr>
                        	<td class="key">
                            	<label for="dateStart">
                                	<?php echo JText::_( 'DATE START' ); ?>
                                </label>
                            </td>
                            <td>
                            	<?php echo $this->lists['dateStart']; ?>
                            </td>					
                        </tr>
                        <tr>
                       		<td class="key">
                            	<label for="dateEnd">
                                	<?php echo JText::_( 'DATE END' ); ?>
                                </label>
                            </td>
                            <td>
                            	<?php echo $this->lists['dateEnd']; ?>
                            </td>					
                        </tr>
                        <tr>
                        	<td class="key">
                            	<label for="dateUsed">
                                	<?php echo JText::_( 'DATE USED' ); ?>
                                </label>
                            </td>
                            <td>
                            	<?php echo $this->lists['dateUsed']; ?>
                            </td>					
                        </tr>
                    	<tr>
                        	<td class="key" colspan="2" style="text-align:center;">
                            	<label for="clock">
                                	<?php echo JText::_( 'Clock' ); ?>
                                </label>
                            </td>				
                        </tr>
                         -->
                        <tr>
                            <td class="key" colspan="2" style="text-align:center;">
                                <strong><?php echo JText::_( 'IMAGE' ); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            	<center>
                                <?php if($this->event->get('image')!=''){ ?>
                                    <img src="../images/events/med_<?php echo $this->event->get('image'); ?>" /><br/>
                                <?php } ?>	
                                <input type="file" name="image" id="image" class="inputbox"/>
                                </center>
                            </td>
                        </tr>
        			</table>
			</td>
		</tr>
	</table>					   	
	<input type="hidden" name="id" value="<?php echo $this->event->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->event->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="event" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	