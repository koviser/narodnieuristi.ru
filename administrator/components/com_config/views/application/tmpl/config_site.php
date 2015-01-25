<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Site Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">
	<tbody>
		<tr>
			<td width="185" class="key">

			<span class="editlinktip hasTip" title="<?php echo JText::_( 'Site Offline' ); ?>::<?php echo JText::_( 'TIPSETYOURSITEISOFFLINE' ); ?>">

			<?php echo JText::_( 'Site Offline' ); ?>
			</span>
			</td>
			<td>
			<?php echo $lists['offline']; ?>
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Offline Message' ); ?>::<?php echo JText::_( 'TIPIFYOURSITEISOFFLINE' ); ?>">
					<?php echo JText::_( 'Offline Message' ); ?>
				</span>
			</td>
			<td>
				<textarea class="text_area" cols="60" rows="2" style="width:400px; height:40px" name="offline_message"><?php echo $row->offline_message; ?></textarea>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Site Name' ); ?>::<?php echo JText::_( 'TIPSITENAME' ); ?>">
				<?php echo JText::_( 'Site Name' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="sitename" size="50" value="<?php echo $row->sitename; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Default WYSIWYG Editor' ); ?>::<?php echo JText::_( 'TIPDEFWYSIWYG' ); ?>">
			<?php echo JText::_( 'Default WYSIWYG Editor' ); ?>
			</span>
			</td>
			<td>
				<?php echo $lists['editor']; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'List Length' ); ?>::<?php echo JText::_( 'TIPSETSDEFAULTLENGTHLISTS' ); ?>">
					<?php echo JText::_( 'List Length' ); ?>
				</span>
			</td>
			<td>
				<?php echo $lists['list_limit']; ?>
			</td>
		</tr>
		<tr>
			<td width="185" class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Feedlimit' ); ?>::<?php echo JText::_( 'TIPFEEDLIMIT' ); ?>">
					<?php echo JText::_( 'Feed Length' ); ?>
				</span>
			</td>
			<td>
				<?php echo $lists['feed_limit']; ?>
			</td>
		</tr>
		<tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Feed Email' ); ?>::<?php echo JText::_( 'TIPFEEDEMAIL' ); ?>">
			<?php echo JText::_( 'Feed Email' ); ?>
			</span>
			</td>
			<td>
				<?php echo $lists['feed_email']; ?>
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Robokassa login' ); ?>::<?php echo JText::_( 'TIPROBOKASSALOGIN' ); ?>">
				<?php echo JText::_( 'Robokassa login' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="wm_login" size="50" value="<?php echo $row->wm_login; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Robokassa password 1' ); ?>::<?php echo JText::_( 'TIPROBOKASSAPASSWORD1' ); ?>">
				<?php echo JText::_( 'Robokassa password 1' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="wm_password_1" size="50" value="<?php echo $row->wm_password_1; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Robokassa password 2' ); ?>::<?php echo JText::_( 'TIPROBOKASSAPASSWORD2' ); ?>">
				<?php echo JText::_( 'Robokassa password 2' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="wm_password_2" size="50" value="<?php echo $row->wm_password_2; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Robokassa server' ); ?>::<?php echo JText::_( 'TIPROBOKASSASERVER' ); ?>">
				<?php echo JText::_( 'Robokassa server' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="wm_url" size="50" value="<?php echo $row->wm_url; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Yandex key' ); ?>::<?php echo JText::_( 'TIPYANDEXKEY' ); ?>">
				<?php echo JText::_( 'Yandex key' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="yandex_key" size="50" value="<?php echo $row->yandex_key; ?>" />
			</td>
		</tr>
        
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Start bonus' ); ?>::<?php echo JText::_( 'TIPSTARTBONUS' ); ?>">
				<?php echo JText::_( 'Start bonus' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="start_bonus" size="50" value="<?php echo $row->start_bonus; ?>" />
			</td>
		</tr>
        
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Friend bonus' ); ?>::<?php echo JText::_( 'TIPFRIENDBONUS' ); ?>">
				<?php echo JText::_( 'Friend bonus' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="friend_bonus" size="50" value="<?php echo $row->friend_bonus; ?>" />
			</td>
		</tr>
        
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'User bonus' ); ?>::<?php echo JText::_( 'TIPUSERBONUS' ); ?>">
				<?php echo JText::_( 'User bonus' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="user_bonus" size="50" value="<?php echo $row->user_bonus; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Sms login' ); ?>::<?php echo JText::_( 'TIPSMSLOGIN' ); ?>">
				<?php echo JText::_( 'Sms login' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="sms_login" size="50" value="<?php echo $row->sms_login; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'Sms password' ); ?>::<?php echo JText::_( 'TIPSMSPASSWORD' ); ?>">
				<?php echo JText::_( 'Sms password' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="sms_password" size="50" value="<?php echo $row->sms_password; ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'VK ID' ); ?>::<?php echo JText::_( 'TIPVKID' ); ?>">
				<?php echo JText::_( 'VK ID' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="vk_id" size="50" value="<?php echo $row->vk_id ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'VK PASSWORD' ); ?>::<?php echo JText::_( 'TIPVKPASSWORD' ); ?>">
				<?php echo JText::_( 'VK PASSWORD' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="vk_password" size="50" value="<?php echo $row->vk_password ?>" />
			</td>
		</tr>
        
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'FB ID' ); ?>::<?php echo JText::_( 'TIPFBID' ); ?>">
				<?php echo JText::_( 'FB ID' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="fb_id" size="50" value="<?php echo $row->fb_id ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'FB PASSWORD' ); ?>::<?php echo JText::_( 'TIPFBPASSWORD' ); ?>">
				<?php echo JText::_( 'FB PASSWORD' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="fb_password" size="50" value="<?php echo $row->fb_password ?>" />
			</td>
		</tr>
        
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'MAILRU ID' ); ?>::<?php echo JText::_( 'TIPMAILRUID' ); ?>">
				<?php echo JText::_( 'MAILRU ID' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="mail_ru_id" size="50" value="<?php echo $row->mail_ru_id ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'MAILRU KEY' ); ?>::<?php echo JText::_( 'TIPMAILRUKEY' ); ?>">
				<?php echo JText::_( 'MAILRU KEY' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="mail_ru_key" size="50" value="<?php echo $row->mail_ru_key ?>" />
			</td>
		</tr>
        <tr>
			<td class="key">
				<span class="editlinktip hasTip" title="<?php echo JText::_( 'MAILRU PASSWORD' ); ?>::<?php echo JText::_( 'TIPMAILRUPASSWORD' ); ?>">
				<?php echo JText::_( 'MAILRU PASSWORD' ); ?>
				</span>
			</td>
			<td>
				<input class="text_area" type="text" name="mail_ru_password" size="50" value="<?php echo $row->mail_ru_password ?>" />
			</td>
		</tr>
	</tbody>
	</table>
</fieldset>
