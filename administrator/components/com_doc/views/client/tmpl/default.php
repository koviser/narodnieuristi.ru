<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php $pane = &JPane::getInstance('sliders', array('allowAllClose' => false, 'startOffset' => 0)); ?>
<?php  JHTML::_('behavior.tooltip');  ?>
<?php
	$document = &JFactory::getDocument();
	//$document->addStyleSheet(JURI::root(true).'/media/system/css/modal.css');
	//$document->addScript(JURI::root(true).'/media/system/js/modal.js');
	//$document->addScript(JURI::root(true).'/administrator/components/com_doc/js/coordinates.js');
	
	$cid = JRequest::getVar( 'cid', array(0) );
	$edit		= JRequest::getVar('edit',true);
	$text = intval($edit) ? JText::_( 'Edit' ) : JText::_( 'New' );

	JToolBarHelper::title( JText::_( 'Client' ) . ': <small><small>[ '. $text .' ]</small></small>' , 'frontpage' );	
	if ( $edit ) {
		
		if($this->item->get('id_category')==1){
			JToolBarHelper::customX( 'bill', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD BILL' ), false );
			
			JToolBarHelper::customX( 'akt_pay', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD AKT' ), false );
			JToolBarHelper::customX( 'forma_pay', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD FORMA' ), false );
			JToolBarHelper::customX( 'statement_absence_pay', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD statement absence' ), false );
		}else{
			JToolBarHelper::customX( 'akt_free', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD AKT' ), false );
			JToolBarHelper::customX( 'forma_free', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD FORMA' ), false );
			JToolBarHelper::customX( 'statement_absence_free', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD statement absence' ), false );
		}
		
		JToolBarHelper::customX( 'receipt', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD receipt' ), false );
		
		if($this->item->get('id_type')==1){
			JToolBarHelper::customX( 'application_commission', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD application' ), false );
			JToolBarHelper::customX( 'complaint_commission', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD complaint' ), false );
		}else if($this->item->get('id_type')==4){
			JToolBarHelper::customX( 'application_developers', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD application' ), false );
			JToolBarHelper::customX( 'complaint_developers', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD complaint' ), false );
		}else if($this->item->get('id_type')==2){
			JToolBarHelper::customX( 'application_osago', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD application' ), false );
			JToolBarHelper::customX( 'complaint_osago', 'upload.png', 'upload_f2.png', JText::_( 'UNLOAD complaint' ), false );
		}
	}
	JToolBarHelper::save();
	JToolBarHelper::apply();
	if ( $edit ) {	
		JToolBarHelper::cancel( 'cancel', 'Close' );
	} else {
		JToolBarHelper::cancel();
	}	
?>
<style type="text/css">
	#slideform td{background:#fff;}
	#slideform td.key{background:#F6F6F6;}
</style>
<script type="text/javascript">
	window.addEvent('domready', function() {
		$$('#id_category').each(function(el) { 
			el.addEvent('change', function() {
				if(this.get('value')==1){
					$$('#label_date_admission').setHTML('<?php echo JText::_('DATE_CONTRACT');?>');
				}else{
					$$('#label_date_admission').setHTML('<?php echo JText::_('DATE_ADMISSION');?>');
				}
			});
		});	
	});
</script>
<!--
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
-->
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
	<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top" width="50%">
            	<fieldset class="adminform">
                    <legend><?php echo JText::_( 'CLIENT INFO' ) ?></legend>
                    <table class="admintable" width="100%">
                        <tr>
                    	<td class="key" style="width:200px;">
                            <label for="client_name">
                                <?php echo JText::_( 'NAME' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_name" id="client_name" size="50" maxlength="250" value="<?php echo $this->item->get('client_name'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="client_phone">
                                <?php echo JText::_( 'PHONE' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_phone" id="client_phone" size="50" maxlength="250" value="<?php echo $this->item->get('client_phone'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="client_registration">
                                <?php echo JText::_( 'CLIENT_REGISTRATION' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_registration" id="client_registration" size="50" maxlength="250" value="<?php echo $this->item->get('client_registration'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="client_passport">
                                <?php echo JText::_( 'CLIENT_PASSPORT' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_passport" id="client_passport" size="50" maxlength="250" value="<?php echo $this->item->get('client_passport'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="client_issued">
                                <?php echo JText::_( 'CLIENT_ISSUED' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_issued" id="client_issued" size="50" maxlength="250" value="<?php echo $this->item->get('client_issued'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    <tr>
                    	<td class="key">
                            <label for="client_bithday">
                                <?php echo JText::_( 'CLIENT_BITHDAY' ); ?>
                            </label>
                        </td>
                        <td>
                            <input type="text" name="client_bithday" id="client_bithday" size="50" maxlength="250" value="<?php echo $this->item->get('client_bithday'); ?>" style="width:98%;"/>
                        </td>
                    </tr>
                    </table>
            	</fieldset>
                <fieldset class="adminform" id="slideform">
                    <legend><?php echo JText::_( 'INFO' ) ?></legend>
                <?php													
					echo $pane->startPane("jpane-detail");
					echo $pane->startPanel( JText::_("INFO_1"), "pane-1" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_filing">
                                    <?php echo JText::_( 'DATE FILLING' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="id_wrote_complaint">
                                    <?php echo JText::_( 'NAME_WROTE_COMPLAINT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_response">
                                    <?php echo JText::_( 'DATE_RESPONSE' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="note_returned_sums">
                                    <?php echo JText::_( 'NOTE_RETURNED_SUMS' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_filing'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['wrote_complaint'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['date_response'];?>
                            </td>
                            <td>
                                <input type="text" name="note_returned_sums" id="note_returned_sums" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('note_returned_sums'); ?>"/>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_2"), "pane-2" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="id_wrote_petition_court">
                                    <?php echo JText::_( 'NAME_WROTE_PRETITION' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_filling_court">
                                    <?php echo JText::_( 'DATE FILLING COURT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="cost_action">
                                    <?php echo JText::_( 'COST ACTION' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="claimed_legal_costs">
                                    <?php echo JText::_( 'CLAIMED LEGAL COSTS' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['wrote_petition_court'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['date_filling_court'];?>
                            </td>
                            <td>
                                <input type="text" name="cost_action" id="cost_action" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('cost_action'); ?>"/>
                            </td>
                            <td>
                                <input type="text" name="claimed_legal_costs" id="claimed_legal_costs" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('claimed_legal_costs'); ?>"/>
                            </td>
                    	</tr>
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="name_court">
                                    <?php echo JText::_( 'NAME COURT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_court">
                                    <?php echo JText::_( 'DATE COURT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="id_representing_court">
                                    <?php echo JText::_( 'NAME REPRESENTING COURT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="file_number">
                                    <?php echo JText::_( 'FILE NUMBER' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="name_court" id="name_court" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('name_court'); ?>"/>
                            </td>
                            <td>
                                <?php echo $this->lists['date_court'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['representing_court'];?>
                            </td>
                            <td>
                                <input type="text" name="file_number" id="file_number" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('file_number'); ?>"/>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_3"), "pane-3" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_pending_cases">
                                    <?php echo JText::_( 'DATE' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="pending_cases_court">
                                    <?php echo JText::_( 'CAUSE' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_pending_cases'];?>
                            </td>
                            <td>
                            	<textarea name="pending_cases_court" id="pending_cases_court" cols="30" rows="5" style="width:98%;"><?php echo $this->item->get('pending_cases_court'); ?></textarea>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_4"), "pane-4" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_first_instance">
                                    <?php echo JText::_( 'DATE' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="decision_first_instance">
                                    <?php echo JText::_( 'DECISION' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="comment_judgment">
                                    <?php echo JText::_( 'COMMENT JUDGMENT' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_first_instance'];?>
                            </td>
                            <td>
                            	<input type="text" name="decision_first_instance" id="decision_first_instance" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('decision_first_instance'); ?>"/>
                            </td>
                            <td>
                            	<textarea name="comment_judgment" id="comment_judgment" cols="30" rows="5" style="width:98%;"><?php echo $this->item->get('comment_judgment'); ?></textarea>
                            </td>
                    	</tr>
                        
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="collected_client">
                                    <?php echo JText::_( 'COLLECTED CLIENT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="collected_roo">
                                    <?php echo JText::_( 'COLLECTED ROO' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="legal_costs_roo">
                                    <?php echo JText::_( 'LEGAL COSTS ROO' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="collected_client" id="collected_client" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('collected_client'); ?>"/>
                            </td>
                            <td>
                            	<input type="text" name="collected_roo" id="collected_roo" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('collected_roo'); ?>"/>
                            </td>
                            <td>
                            	<input type="text" name="legal_costs_roo" id="legal_costs_roo" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('legal_costs_roo'); ?>"/>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_5"), "pane-5" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_receipt_writ">
                                    <?php echo JText::_( 'DATE RECEIPT WRIT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="number_writ">
                                    <?php echo JText::_( 'NUMBER WRIT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="writ_filed">
                                    <?php echo JText::_( 'WRIT FILED' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_filing_writ">
                                    <?php echo JText::_( 'DATE FILING WRIT' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_receipt_writ'];?>
                            </td>
                            <td>
                                <input type="text" name="number_writ" id="number_writ" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('number_writ'); ?>"/>
                            </td>
                            <td>
                                <input type="text" name="writ_filed" id="writ_filed" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('writ_filed'); ?>"/>
                            </td>
                            <td>
                                <?php echo $this->lists['date_filing_writ'];?>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_6"), "pane-6" );
				?>
                	<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_filing_appeal">
                                    <?php echo JText::_( 'DATE FILING' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_receipt_appeal">
                                    <?php echo JText::_( 'DATE RECEIPT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="appeal_who">
                                    <?php echo JText::_( 'WHO' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_filing_appeal'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['date_receipt_appeal'];?>
                            </td>
                            <td>
                            	<input type="text" name="appeal_who" id="appeal_who" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('appeal_who'); ?>"/>
                            </td>
                    	</tr>
                        
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_case">
                                    <?php echo JText::_( 'DATE CASE' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;" colspan="2">
                                <label for="appeal_result">
                                    <?php echo JText::_( 'APPEAL RESULT' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_case'];?>
                            </td>
                            <td colspan="2">
                            	<textarea name="appeal_result" id="appeal_result" cols="30" rows="5" style="width:98%;"><?php echo $this->item->get('appeal_result'); ?></textarea>
                            </td>
                    	</tr>
                    </table>
                <?php													
					echo $pane->endPanel();	
					echo $pane->startPanel( JText::_("INFO_7"), "pane-7" );
				?>
					<table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_filing_cassation">
                                    <?php echo JText::_( 'DATE FILING' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="date_receipt_cassation">
                                    <?php echo JText::_( 'DATE RECEIPT' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;">
                                <label for="cass_who">
                                    <?php echo JText::_( 'WHO' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_filing_cassation'];?>
                            </td>
                            <td>
                                <?php echo $this->lists['date_receipt_cassation'];?>
                            </td>
                            <td>
                            	<input type="text" name="cass_who" id="cass_who" size="30" maxlength="250" style="width:98%;" value="<?php echo $this->item->get('cass_who'); ?>"/>
                            </td>
                    	</tr>
                        
                        <tr>
                            <td class="key" style="text-align:center;">
                                <label for="date_case_appeal">
                                    <?php echo JText::_( 'DATE CASS CASE' ); ?>
                                </label>
                            </td>
                            <td class="key" style="text-align:center;" colspan="2">
                                <label for="cass_result">
                                    <?php echo JText::_( 'CASS RESULT' ); ?>
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->lists['date_case_appeal'];?>
                            </td>
                            <td colspan="2">
                            	<textarea name="cass_result" id="cass_result" cols="30" rows="5" style="width:98%;"><?php echo $this->item->get('cass_result'); ?></textarea>
                            </td>
                    	</tr>
                    </table>
                <?php	
					echo $pane->endPanel();	
					echo $pane->endPane();	
				?>
                </fieldset>
			</td>
            <td valign="top" width="50%">
				<fieldset class="adminform">
                    <legend><?php echo JText::_( 'CONTRACT INFO' ) ?></legend>
                    <table class="admintable" width="100%">
                        <tr>
                            <td class="key" style="width:250px">
                                <label for="id_type">
                                    <?php echo JText::_( 'Type' ); ?>
                                </label>
                            </td>
                            <td>
                                <?php echo $this->lists['type']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width:250px">
                                <label for="id_category">
                                    <?php echo JText::_( 'Category' ); ?>
                                </label>
                            </td>
                            <td>
                                <?php echo $this->lists['category']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="key" style="width:250px">
                                <label for="id_roo">
                                    <?php echo JText::_( 'ROO' ); ?>
                                </label>
                            </td>
                            <td>
                                <?php echo $this->lists['roo']; ?>
                            </td>
                        </tr>
                        <?php if($this->item->id_category!=2){ ?>
                        <tr>
                            <td class="key">
                                <label for="number">
                                    <?php echo JText::_( 'Number' ); ?>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="number" id="number" size="50" maxlength="250" value="<?php echo $this->item->get('number'); ?>" style="width:98%;"/>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="key">
                                <label for="date_admission" id="label_date_admission">
                                    <?php echo $this->item->get('id_category')<2 ? JText::_( 'DATE_CONTRACT' ) : JText::_( 'DATE_ADMISSION' ); ?>
                                </label>
                            </td>
                            <td>
                                <?php echo $this->lists['date_admission']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <label for="id_consultant">
                                    <?php echo JText::_( 'N_CONSULTANT' ); ?>
                                </label>
                            </td>
                            <td>
                                <?php echo $this->lists['consultant']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <label for="defendant">
                                    <?php echo JText::_( 'NAME_DEFENDANT' ); ?>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="defendant" id="defendant" size="50" maxlength="250" value="<?php echo $this->item->get('defendant'); ?>" style="width:98%;"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <label for="docs">
                                    <?php echo JText::_( 'DOCS' ); ?>
                                </label>
                            </td>
                            <td>
                                <textarea name="docs" id="docs" cols="30" rows="10" style="width:98%;"><?php echo $this->item->get('docs'); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <label for="adocs">
                                    <?php echo JText::_( 'AKTDOCS' ); ?>
                                </label>
                            </td>
                            <td>
                                <textarea name="adocs" id="adocs" cols="30" rows="10" style="width:98%;"><?php echo $this->item->get('adocs'); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="key">
                                <label for="service">
                                    <?php echo JText::_( 'SERVICES' ); ?>
                                </label>
                            </td>
                            <td>
								<?php echo $this->lists['service']; ?>
                            </td>
                        </tr>
                        <?php if($this->item->id_type==5){?>
                        <tr>
                            <td class="key">
                                <label for="details">
                                    <?php echo JText::_( 'DETAILS' ); ?>
                                </label>
                            </td>
                            <td>
                                <textarea name="details" id="details" cols="30" rows="10" style="width:98%;"><?php echo $this->item->get('details'); ?></textarea>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td class="key">
                                <label for="price">
                                    <?php echo JText::_( 'PRICE' ); ?>
                                </label>
                            </td>
                            <td>
                                <input type="text" name="price" id="price" size="50" maxlength="250" value="<?php echo $this->item->get('price'); ?>" style="width:98%;"/>
                            </td>
                        </tr>
                    </table>
            	</fieldset>
			</td>
		</tr>
	</table>					   	
	<input type="hidden" name="id" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="cid[]" value="<?php echo $this->item->get('id'); ?>" />
	<input type="hidden" name="option" value="com_doc" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="client" />
	
	<?php echo JHTML::_( 'form.token' ); ?>
</form>	