<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
class JImageExtend extends JFile
{
	function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
		if(!isset($pct)){
			return false;
		}
		$pct /= 100;
		$w = imagesx( $src_im );
		$h = imagesy( $src_im );
		imagealphablending( $src_im, false );
		$minalpha = 127;
		for( $x = 0; $x < $w; $x++ )
		for( $y = 0; $y < $h; $y++ ){
			$alpha = ( imagecolorat( $src_im, $x, $y ) >> 24 ) & 0xFF;
			if( $alpha < $minalpha ){
				$minalpha = $alpha;
			}
		}
		for( $x = 0; $x < $w; $x++ ){
			for( $y = 0; $y < $h; $y++ ){
				$colorxy = imagecolorat( $src_im, $x, $y );
				$alpha = ( $colorxy >> 24 ) & 0xFF;
				if( $minalpha !== 127 ){
					$alpha = 127 + 127 * $pct * ( $alpha - 127 ) / ( 127 - $minalpha );
				} else {
					$alpha += 127 * $pct;
				}
				$alphacolorxy = imagecolorallocatealpha( $src_im, ( $colorxy >> 16 ) & 0xFF, ( $colorxy >> 8 ) & 0xFF, $colorxy & 0xFF, $alpha );
				if( !imagesetpixel( $src_im, $x, $y, $alphacolorxy ) ){
					return false;
				}
			}
		}
		imagecopy($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
	}
	function addWatermark($file_name, $watermark_file ,$alpha_level = 100)
	{
		$image = imagecreatefromjpeg($file_name);
		static $watermark = false;
		static $width;
		static $height;
		$watermark = imagecreatefrompng($watermark_file);
		$width = imagesx($watermark);
		$height = imagesy($watermark);
		$dest_x = 0;
		$dest_y = 0;
		JImageExtend::imagecopymerge_alpha($image, $watermark, $dest_x, $dest_y, 0, 0, $width, $height, $alpha_level);
		
		imagejpeg($image, $file_name, 90);
	}
	function resizeImage($image_name, $file_name_cache, $mw, $mh) {
		list($width, $height) = getimagesize($image_name);
		$percent = 1.0;
		
		if ($width > $mw) {
			$percent = $mw / $width;
		} 
		if ($height * $percent > $mh) {
			$percent = $mh / $height;
		}
		$newwidth = (int)($percent * $width);
		$newheight = (int)($percent * $height);
		$cropw = 0; $croph = 0;
		if ($newheight < $mh) {
			$t1 = $mh / $newheight;
			$t2 = $newwidth * $t1;
			$t3 = $newwidth / $t2;
			$cropw = $width - ($width * $t3);
			$newheight = $mh;
		}
		if ($newwidth < $mw) {
			$t1 = $mw / $newwidth;
			$t2 = $newheight * $t1;
			$t3 = $newheight / $t2;
			$croph = $height - ($height * $t3);
			$newwidth = $mw;
		}

		$thumb = imagecreatetruecolor((int)$newwidth, (int)$newheight);
		$source = imagecreatefromjpeg($image_name);
		imagecopyresampled($thumb, $source, 0 , 0, $cropw / 2, $croph / 2, $newwidth, $newheight, $width - $cropw, $height - $croph);
		imagejpeg($thumb, $file_name_cache, 90);
	}
	function resizeImage2($image_name, $file_name_cache, $mw, $mh) {
		list($width, $height) = getimagesize($image_name);
		$percent = 1.0;
		if ($width > $mw) {
			$percent = $mw / $width;
		}
		$newwidth = (int)($percent * $width);
		$newheight = (int)($percent * $height);

		$thumb = imagecreatetruecolor((int)$newwidth, (int)$newheight);
		$source = imagecreatefromjpeg($image_name);
		imagecopyresampled($thumb, $source, 0 , 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagejpeg($thumb, $file_name_cache, 90);
	}
	function uploadAndResize($src, $dest, $mw, $mh,$watermark=null)
	{
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');
		$ret		= false;
		$dest = JPath::clean($dest);
		$baseDir = dirname($dest);
		if (!file_exists($baseDir)) {
			jimport('joomla.filesystem.folder');
			JFolder::create($baseDir);
		}

		if ($FTPOptions['enabled'] == 1) {
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);
			$dest = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $dest), '/');
			if (is_uploaded_file($src) && $ftp->store($src, $dest))
			{
				 $ret = true;
                 unlink($src);
			} else {
				JError::raiseWarning(21, JText::_('WARNFS_ERR02'));
			}
		} else {
			if (is_writeable($baseDir) && move_uploaded_file($src, $dest)) {
				if (JPath::setPermissions($dest)) {
					$ret = true;
				} else {
					JError::raiseWarning(21, JText::_('WARNFS_ERR01'));
				}
				if ($mw != 0 && $mh == 0 ) {
					JImageExtend::resizeImage2($dest, $dest, $mw, $mh);
					if($watermark!=""){
						JImageExtend::addWatermark($dest, $watermark);
					}
				}
				if ($mw != 0 && $mh != 0 ) {
					JImageExtend::resizeImage($dest, $dest, $mw, $mh);
					if($watermark!=""){
						JImageExtend::addWatermark($dest, $watermark);
					}
				}
			} else {
				JError::raiseWarning(21, JText::_('WARNFS_ERR02'));
			}
		}
		return $ret;
	}
	function copyAndResize($src, $dest, $mw, $mh, $watermark=null, $path = null)
	{
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');
		if ($path) {
			$src = JPath::clean($path.DS.$src);
			$dest = JPath::clean($path.DS.$dest);
		}
		if (!is_readable($src)) {
			JError::raiseWarning(21, 'JFile::copy: ' . JText::_('Cannot find or read file') . ": '$src'");
			return false;
		}

		if ($FTPOptions['enabled'] == 1) {
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);
			if (!file_exists(dirname($dest))) {
				jimport('joomla.filesystem.folder');
				JFolder::create(dirname($dest));
			}

			$dest = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $dest), '/');
			if (!$ftp->store($src, $dest)) {
				return false;
			}
			$ret = true;
		} else {
			if (!@ copy($src, $dest)) {
				JError::raiseWarning(21, JText::_('Copy failed'));
				return false;
			}
			$ret = true;
		}
		JImageExtend::resizeImage($dest, $dest, $mw, $mh);
		if($watermark!=""){
			JImageExtend::addWatermark($dest, $watermark);
		}
		return $ret;
	}
}
?>