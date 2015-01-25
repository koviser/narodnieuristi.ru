<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Competition' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
	if ($this->competition->type == 2) {
		JToolBarHelper::customX( 'image', 'image.png', 'image_f2.png', JText::_( 'Moderation Images' ), false );
	}
	if ($this->competition->dateEnd < date('Y-m-d') && $this->competition->status==0 && $edit) {
		JToolBarHelper::customX( 'pay', 'pay.png', 'pay_f2.png', JText::_( 'Pay' ), false );
	}
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {	
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}	
?>
<?php if(!$this->competition->status){ ?>
<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
		if(form.dateStart.value > form.dateEnd.value){
			alert( "<?php echo JText::_( 'DateStart MORE DateEnd'); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<?php } ?>
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
                            <input type="text" name="title" id="title" class="inputbox" size="70" value="<?php echo $this->escape($this->competition->get('title')); ?>" />
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="published">
                                <?php echo JText::_( 'Published' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['published']; ?>
                        </td>
                    <tr>
                       	<td class="key">
                           	<label for="dateStart">
                               	<?php echo JText::_( 'DATESTART' ); ?>
                               </label>
                        </td>
                        <td>
                        	<?php if($this->competition->status==1){ ?>
                         		<?php echo $this->competition->dateStart; ?>
                            <?php }else{ ?>
								<?php echo $this->lists['dateStart']; ?>
							<?php } ?>
                        </td>					
                    </tr>
                    <tr>
                    	<td class="key">
                           	<label for="dateEnd">
                               	<?php echo JText::_( 'DATEEND' ); ?>
                            </label>
                        </td>
                        <td>
                          	<?php if($this->competition->status==1){ ?>
                         		<?php echo $this->competition->dateEnd; ?>
                            <?php }else{ ?>
								<?php echo $this->lists['dateEnd']; ?>
							<?php } ?>
                        </td>					
                    </tr>
                    <tr>
						<td class="key">
                            <label for="type">
                                <?php echo JText::_( 'COMTYPE' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['type']; ?>
                        </td>
                    </tr>
                    <tr>
						<td class="key">
                            <label for="bonusType">
                                <?php echo JText::_( 'BONUSTYPE' ); ?>
                            </label>
                        </td>
                        <td>
                            <?php echo $this->lists['bonuslist']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="key">
                            <label for="bonus">
                                <?php echo JText::_( 'Paytable' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="bonus" id="bonus" class="inputbox" size="70" value="<?php echo $this->competition->get('bonus'); ?>" /> <?php echo JText::_( 'Currency' ); ?><br/>
                            <?php echo JText::_( 'PAYDESC' ); ?>
                        </td>
                    </tr>
                </table>
                <table class="admintable" width="100%">
                	<tr>
                        <td class="key" style="text-align:left;">
                            <label for="description">
                                <?php echo JText::_( 'Description' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
								$editor = &JFactory::getEditor();
								echo $editor->display( 'description',  $this->competition->get('description') , '100%', '600', '60', '20', array('readmore', 'pagebreak', 'block'), array() ) ;
							?>
                        </td>
					</tr>
				</table>
			</td>
			<td valign="top" width="320" style="padding: 7px 0 0 5px">
                	<table class="admintable" width="100%" style="border: 1px dashed silver; padding: 5px; margin-bottom: 10px;">
                        <tr>
                            <td class="key" colspan="2" style="text-align:center;">
                                <strong><?php echo JText::_( 'IMAGE' ); ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                            	<center>
                                <?php if($this->competition->get('image')!=''){ ?>
                                    <img src="../images/competitions/<?php echo $this->competition->get('image'); ?>" /><br/>
                                <?php } ?>	
                                <input type="file" name="image" id="image" class="inputbox"/>
                                </center>
                            </td>
                        </tr>
        			</table>
			</td>
		</tr>
	</table>					   	
	<input type="hidden" name="id" value="<?php echo $this->competition->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->competition->get('id'); ?>" />
	<input type="hidden" name="option" value="com_coupon" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="competition" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	