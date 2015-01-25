<?php
defined('JPATH_BASE') or die();

jimport('joomla.filesystem.path');

class JFile
{
	function getExt($file) {
		$dot = strrpos($file, '.') + 1;
		return substr($file, $dot);
	}

	/**
	 * Strips the last extension off a file name
	 *
	 * @param string $file The file name
	 * @return string The file name without the extension
	 * @since 1.5
	 */
	function stripExt($file) {
		return preg_replace('#\.[^.]*$#', '', $file);
	}

	/**
	 * Makes file name safe to use
	 *
	 * @param string $file The name of the file [not full path]
	 * @return string The sanitised string
	 * @since 1.5
	 */
	function makeSafe($file) {
		$regex = array('#(\.){2,}#', '#[^A-Za-z0-9\.\_\- ]#', '#^\.#');
		return preg_replace($regex, '', $file);
	}

	/**
	 * Copies a file
	 *
	 * @param string $src The path to the source file
	 * @param string $dest The path to the destination file
	 * @param string $path An optional base path to prefix to the file names
	 * @return boolean True on success
	 * @since 1.5
	 */
	function copy($src, $dest, $path = null)
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');

		// Prepend a base path if it exists
		if ($path) {
			$src = JPath::clean($path.DS.$src);
			$dest = JPath::clean($path.DS.$dest);
		}

		//Check src path
		if (!is_readable($src)) {
			JError::raiseWarning(21, 'JFile::copy: ' . JText::_('Cannot find or read file') . ": '$src'");
			return false;
		}

		if ($FTPOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);

			// If the parent folder doesn't exist we must create it
			if (!file_exists(dirname($dest))) {
				jimport('joomla.filesystem.folder');
				JFolder::create(dirname($dest));
			}

			//Translate the destination path for the FTP account
			$dest = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $dest), '/');
			if (!$ftp->store($src, $dest)) {
				// FTP connector throws an error
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
		return $ret;
	}

	/**
	 * Delete a file or array of files
	 *
	 * @param mixed $file The file name or an array of file names
	 * @return boolean  True on success
	 * @since 1.5
	 */
	function delete($file)
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');

		if (is_array($file)) {
			$files = $file;
		} else {
			$files[] = $file;
		}

		// Do NOT use ftp if it is not enabled
		if ($FTPOptions['enabled'] == 1)
		{
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);
		}

		foreach ($files as $file)
		{
			$file = JPath::clean($file);

			// Try making the file writeable first. If it's read-only, it can't be deleted
			// on Windows, even if the parent folder is writeable
			@chmod($file, 0777);

			// In case of restricted permissions we zap it one way or the other
			// as long as the owner is either the webserver or the ftp
			if (@unlink($file)) {
				// Do nothing
			} elseif ($FTPOptions['enabled'] == 1) {
				$file = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $file), '/');
				if (!$ftp->delete($file)) {
					// FTP connector throws an error
					return false;
				}
			} else {
				$filename	= basename($file);
				JError::raiseWarning('SOME_ERROR_CODE', JText::_('Delete failed') . ": '$filename'");
				return false;
			}
		}

		return true;
	}

	/**
	 * Moves a file
	 *
	 * @param string $src The path to the source file
	 * @param string $dest The path to the destination file
	 * @param string $path An optional base path to prefix to the file names
	 * @return boolean True on success
	 * @since 1.5
	 */
	function move($src, $dest, $path = '')
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');

		if ($path) {
			$src = JPath::clean($path.DS.$src);
			$dest = JPath::clean($path.DS.$dest);
		}

		//Check src path
		if (!is_readable($src) && !is_writable($src)) {
			JError::raiseWarning(21, 'JFile::move: ' . JText::_('Cannot find, read or write file') . ": '$src'");
			return false;
		}

		if ($FTPOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);

			//Translate path for the FTP account
			$src	= JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $src), '/');
			$dest	= JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $dest), '/');

			// Use FTP rename to simulate move
			if (!$ftp->rename($src, $dest)) {
				JError::raiseWarning(21, JText::_('Rename failed'));
				return false;
			}
		} else {
			if (!@ rename($src, $dest)) {
				JError::raiseWarning(21, JText::_('Rename failed'));
				return false;
			}
		}
		return true;
	}

	/**
	 * Read the contents of a file
	 *
	 * @param string $filename The full file path
	 * @param boolean $incpath Use include path
	 * @param int $amount Amount of file to read
	 * @param int $chunksize Size of chunks to read
	 * @param int $offset Offset of the file
	 * @return mixed Returns file contents or boolean False if failed
	 * @since 1.5
	 */
	function read($filename, $incpath = false, $amount = 0, $chunksize = 8192, $offset = 0)
	{
		// Initialize variables
		$data = null;
		if($amount && $chunksize > $amount) { $chunksize = $amount; }
		if (false === $fh = fopen($filename, 'rb', $incpath)) {
			JError::raiseWarning(21, 'JFile::read: '.JText::_('Unable to open file') . ": '$filename'");
			return false;
		}
		clearstatcache();
		if($offset) fseek($fh, $offset);
		if ($fsize = @ filesize($filename)) {
			if($amount && $fsize > $amount) {
				$data = fread($fh, $amount);
			} else {
				$data = fread($fh, $fsize);
			}
		} else {
			$data = '';
			$x = 0;
			// While its:
			// 1: Not the end of the file AND
			// 2a: No Max Amount set OR
			// 2b: The length of the data is less than the max amount we want
			while (!feof($fh) && (!$amount || strlen($data) < $amount)) {
				$data .= fread($fh, $chunksize);
			}
		}
		fclose($fh);

		return $data;
	}

	/**
	 * Write contents to a file
	 *
	 * @param string $file The full file path
	 * @param string $buffer The buffer to write
	 * @return boolean True on success
	 * @since 1.5
	 */
	function write($file, $buffer)
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');

		// If the destination directory doesn't exist we need to create it
		if (!file_exists(dirname($file))) {
			jimport('joomla.filesystem.folder');
			JFolder::create(dirname($file));
		}

		if ($FTPOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);

			// Translate path for the FTP account and use FTP write buffer to file
			$file = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $file), '/');
			$ret = $ftp->write($file, $buffer);
		} else {
			$file = JPath::clean($file);
			$ret = file_put_contents($file, $buffer);
		}
		return $ret;
	}

	/**
	 * Moves an uploaded file to a destination folder
	 *
	 * @param string $src The name of the php (temporary) uploaded file
	 * @param string $dest The path (including filename) to move the uploaded file to
	 * @return boolean True on success
	 * @since 1.5
	 */
	function upload($src, $dest)
	{
		// Initialize variables
		jimport('joomla.client.helper');
		$FTPOptions = JClientHelper::getCredentials('ftp');
		$ret		= false;

		// Ensure that the path is valid and clean
		$dest = JPath::clean($dest);

		// Create the destination directory if it does not exist
		$baseDir = dirname($dest);
		if (!file_exists($baseDir)) {
			jimport('joomla.filesystem.folder');
			JFolder::create($baseDir);
		}

		if ($FTPOptions['enabled'] == 1) {
			// Connect the FTP client
			jimport('joomla.client.ftp');
			$ftp = & JFTP::getInstance($FTPOptions['host'], $FTPOptions['port'], null, $FTPOptions['user'], $FTPOptions['pass']);

			//Translate path for the FTP account
			$dest = JPath::clean(str_replace(JPATH_ROOT, $FTPOptions['root'], $dest), '/');

			// Copy the file to the destination directory
			if (is_uploaded_file($src) && $ftp->store($src, $dest))
			{
			            $ret = true;
                		unlink($src);
			} else {
				JError::raiseWarning(21, JText::_('WARNFS_ERR02'));
			}
		} else {
			if (is_writeable($baseDir) && move_uploaded_file($src, $dest)) { // Short circuit to prevent file permission errors
				if (JPath::setPermissions($dest)) {
					$ret = true;
				} else {
					JError::raiseWarning(21, JText::_('WARNFS_ERR01'));
				}
			} else {
				JError::raiseWarning(21, JText::_('WARNFS_ERR02'));
			}
		}
		return $ret;
	}

	/**
	 * Wrapper for the standard file_exists function
	 *
	 * @param string $file File path
	 * @return boolean True if path is a file
	 * @since 1.5
	 */
	function exists($file)
	{
		return is_file(JPath::clean($file));
	}

	/**
	 * Returns the name, sans any path
	 *
	 * param string $file File path
	 * @return string filename
	 * @since 1.5
	 */
	function getName($file) {
		$slash = strrpos($file, DS);
		if ($slash !== false) {
			return substr($file, $slash + 1);
		} else {
			return $file;
		}
	}
	
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
		JFile::imagecopymerge_alpha($image, $watermark, $dest_x, $dest_y, 0, 0, $width, $height, $alpha_level);
		
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
		$filename = explode('.', $image_name);
		$format = $filename[count($filename)-1];
		$thumb = imagecreatetruecolor((int)$newwidth, (int)$newheight);
		if($format == 'jpeg' || $format == 'jpg'){
			$source = imagecreatefromjpeg($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, $cropw / 2, $croph / 2, $newwidth, $newheight, $width - $cropw, $height - $croph);
			imagejpeg($thumb, $file_name_cache, 90);
		}else if($format == 'png'){
			$source = imagecreatefrompng($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, $cropw / 2, $croph / 2, $newwidth, $newheight, $width - $cropw, $height - $croph);
			imagepng($thumb, $file_name_cache);			
		}else if($format == 'gif'){
			$source = imagecreatefromgif($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, $cropw / 2, $croph / 2, $newwidth, $newheight, $width - $cropw, $height - $croph);
			imagegif($thumb, $file_name_cache);			
		}
	}
	function resizeImage2($image_name, $file_name_cache, $mw, $mh) {
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
		
		$filename = explode('.', $image_name);
		$format = $filename[count($filename)-1];
		$thumb = imagecreatetruecolor((int)$newwidth, (int)$newheight);
		if($format == 'jpeg' || $format == 'jpg'){
			$source = imagecreatefromjpeg($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg($thumb, $file_name_cache, 90);
		}else if($format == 'png'){
			$source = imagecreatefrompng($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagepng($thumb, $file_name_cache);
		}else if($format == 'gif'){
			$source = imagecreatefromgif($image_name);
			imagecopyresampled($thumb, $source, 0 , 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagegif($thumb, $file_name_cache);
		}
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
					JFile::resizeImage($dest, $dest, $mw, $mh);
					if($watermark!=""){
						JFile::addWatermark($dest, $watermark);
					}
				}
				if ($mw != 0 && $mh != 0 ) {
					JFile::resizeImage($dest, $dest, $mw, $mh);
					if($watermark!=""){
						JFile::addWatermark($dest, $watermark);
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
		JFile::resizeImage($dest, $dest, $mw, $mh);
		if($watermark!=""){
			JFile::addWatermark($dest, $watermark);
		}
		return $ret;
	}
	function getFileName($id, $filename){
		$filename = explode('.', $filename);
		$format = strtolower($filename[count($filename)-1]);
		$file=$id.'_'.time().'.'.$format;
		
		return $file;
	}
	
	function format($file){
		$filename = explode('.', $file);
		$format = strtolower($filename[count($filename)-1]);
		if(($format=='jpeg' || $format=='png' || $format=='jpg' || $format=='gif') && $file['size'] < 10485760){
			return true;	
		}else{
			return false;
		}
	}
}
