<?php defined('_JEXEC') or die('Restricted access'); ?>
<div style="width:100%; clear:both;">
	<div class="manager">

		<?php for ($i=0,$n=count($this->images); $i<$n; $i++) :
			$this->setImage($i);
			echo $this->loadTemplate('img');
		endfor; ?>

	</div>
</div>
	<div style="width:100%; clear:both;">
    <form action="index.php" id="uploadForm" method="post" enctype="multipart/form-data">
					<fieldset>
						<legend><?php echo JText::_( 'Upload File' ); ?></legend>
						<fieldset class="actions">
							<input type="file" id="file-upload" name="image" />
							<input type="submit" id="file-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
							<span id="upload-clear"></span>
						</fieldset>
						<ul class="upload-queue" id="upload-queue">
							<li style="display: none" />
						</ul>
					</fieldset>
                        <input type="hidden" name="option" value="com_coupon" />
                        <input type="hidden" name="task" value="save" />
                        <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
                        <input type="hidden" name="<?php echo $this->session->getName();?>" value="<?php echo $this->session->getId(); ?>" />
                        <input type="hidden" name="<?php echo JUtility::getToken();?>" value="1" />
                        <input type="hidden" name="controller" value="modimage" />
                        
				</form>
     </div>