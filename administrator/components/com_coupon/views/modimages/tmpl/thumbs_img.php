<?php defined('_JEXEC') or die('Restricted access'); ?>
   
   		<div class="imgOutline">
			<div class="imgTotal">
				<div align="center" class="imgBorder">
					<a class="img-preview" href="#" title="<?php echo $this->_tmp_img->name; ?>" style="display: block; width: 100%; height: 100%" onclick="window.top.document.forms.adminForm.elements.bgimage.value = '<?php echo $this->_tmp_img->path_relative2; ?>';window.parent.document.getElementById('sbox-window').close();">
						<div class="image">
							<img src="<?php echo COM_SHOP_BASEURL.'/'.$this->_tmp_img->path_relative; ?>" width="<?php echo $this->_tmp_img->width_60; ?>" height="<?php echo $this->_tmp_img->height_60; ?>" alt="<?php echo $this->_tmp_img->name; ?> - <?php echo MediaHelper::parseSize($this->_tmp_img->size); ?>" border="0" />
						</div></a>
				</div>
			</div>
			<div class="imginfoBorder">
				<a href="#" onclick="window.top.document.forms.adminForm.elements.bgimage.value = '<?php echo $this->_tmp_img->path_relative2; ?>';window.parent.document.getElementById('sbox-window').close();" class="preview"><?php echo $this->escape( substr( $this->_tmp_img->name, 0, 10 ) . ( strlen( $this->_tmp_img->name ) > 10 ? '...' : '')); ?></a>
			</div>
		</div>