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
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if(form.dateStart.value>form.dateUsed.value){
			alert( "<?php echo JText::_( 'DateEnd MORE DateUsed'); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
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
                        <td>
                            <input type="text" name="title" id="title" class="inputbox" size="50" value="<?php echo $this->escape($this->event->get('title')); ?>" />
                        </td>
                        <td class="key">
                            <label for="price">
                                <?php echo JText::_( 'Price' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="price" id="price" class="inputbox" size="10" value="<?php echo $this->event->get('price'); ?>" /> <?php echo JText::_( 'BON' ); ?>
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
                            <label for="bgcolor">
                                <?php echo JText::_( 'Bgcolor' ); ?>
                            </label>
                        </td>
                        <td>
                            #<input type="text" name="bgcolor" id="bgcolor" class="inputbox" size="10" value="<?php echo $this->event->get('bgcolor'); ?>" />
                        </td>
                        <td class="key">
                            <label for="bgimage">
                                <?php echo JText::_( 'Bgimage' ); ?>
                            </label>
                        </td>
                        <td>
                        	<div><input class="text_area" type="text" name="bgimage" id="bgimage" value="<?php echo $this->event->get('bgimage'); ?>" size="40" maxlength="250" /></div>
                            <div class="button2-left" style="float:left;">
                                <div class="image">
                                    <a class="modal-button" title="<?php echo JText::_( 'SET BGIMAGE' ); ?>" href="index.php?option=com_coupon&amp;controller=modimage&amp;view=modimages&amp;tmpl=component" rel="{handler: 'iframe', size: {x: 760, y: 520}}"  >
                                        <?php echo JText::_( 'SET BGIMAGE' ); ?>
                                    </a>
                                </div>
                            </div> 
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="horizontal">
                                <?php echo JText::_( 'BG horizontal' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['horizontal']; ?>
                        </td>
                        <td class="key">
                            <label for="published">
                                <?php echo JText::_( 'BG vertical' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['vertical']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="repeat">
                                <?php echo JText::_( 'BG REPEAT' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['repeat']; ?>
                        </td>
                        <td class="key"></td>
                        <td></td>
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
					echo $pane->startPanel( JText::_("Terms"), "cdetail-detail-terms" );
				?>
				<table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'terms',  $this->event->get('terms') , '97%', '400', '60', '20', array('readmore', 'pagebreak'), array() ) ;
							?>
                        </td>

					</tr>
				</table>
                <?php	
					echo $pane->endPanel();																						
					echo $pane->startPanel( JText::_("Features"), "cdetail-detail-features" );
				?>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'features',  $this->event->get('features') , '100%', '400', '60', '20', array('readmore', 'pagebreak'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
                <?php	
					echo $pane->endPanel();																						
					echo $pane->startPanel( JText::_("Contacts"), "cdetail-detail-contacts" );
				?>
                <table class="adminform">
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'contacts',  $this->event->get('contacts') , '100%', '400', '60', '20', array('readmore', 'pagebreak'), array() ) ;
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
				</table>
                <table width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
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
				</table>
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
                        <tr>
                            <td colspan="2">
                            	<textarea id="clock" name="clock" cols="40" rows="10" style="width:100%"><?php echo $this->event->get('clock'); ?></textarea>
                            </td>					
                        </tr>
                        <tr>
                            <td class="key" colspan="2" style="text-align:center;">
                                <strong><?php echo JText::_( 'IMAGE' ); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            	<center>
                                <?php if($this->event->get('image')!=''){ ?>
                                    <img src="../images/events/<?php echo $this->event->get('image'); ?>" /><br/>
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
	<input type="hidden" name="controller" value="bonus" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
	


	