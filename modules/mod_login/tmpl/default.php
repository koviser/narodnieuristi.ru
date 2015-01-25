<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if($type == 'logout') : ?>
<div id="login">
<form action="index.php" method="post" name="login" id="form-login">
	<div id="avatar"><?php echo $user->email; ?></div>
    <div id="money"><?php echo $user->balance.' ' .JText::_('RUB'); ?></div>
	<a href="index.php?option=com_user&view=user&layout=billing" class="loginL lb"><?php echo JText::_('Update balance'); ?></a>
    <a href="index.php?option=com_user" class="loginL lb"><?php echo JText::_('Private office'); ?></a>
    <a href="javascript:document.forms.login.submit();" class="loginL" id="logout"><?php echo JText::_('Logout'); ?></a>
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="logout" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
</form>
</div>
<?php else : ?>
<div id="login">
<form action="<?php echo JRoute::_( 'index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
	<a href="index.php?option=com_coupon&view=registration" class="loginL lb"><?php echo JText::_('REGISTER'); ?></a>
    <div class="input"><input id="modlgn_username" type="text" name="username" class="inputbox" alt="username" size="18" value="<?php echo JText::_('E-mail'); ?>"  onblur="if(this.value=='') this.value='<?php echo JText::_('E-mail'); ?>';" onfocus="if(this.value=='<?php echo JText::_('E-mail'); ?>') this.value='';" /></div>
	<div class="input"><input id="modlgn_passwd" type="password" name="passwd" class="inputbox" size="18" alt="password" value="password"  onblur="if(this.value=='') this.value='password';" onfocus="if(this.value=='password') this.value='';"/></div>
	<div class="inputbutton">
    	<a class="vkLogin"><img src="<?php echo JUri::base()?>/images/vk.png" align="absmiddle"/></a>
        <a class="mailLogin"><img src="<?php echo JUri::base()?>/images/mail.png" align="absmiddle"/></a>
        <a class="fbLogin"><img src="<?php echo JUri::base()?>/images/fb.png" align="absmiddle"/></a>
    	<input type="submit" name="Submit" class="button" value="" />
    </div>
    <a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>" class="loginL"><?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>

	<input type="hidden" name="remember" value="yes" />
    <input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<form name="socForm" id="socForm" method="post" action="<?php echo JURI::root();?>">
   	<input type="hidden" name="socType" id="socType" value=""/>
    <input type="hidden" name="socName" id="socName" value=""/>
    <input type="hidden" name="socFamily" id="socFamily" value=""/>
    <input type="hidden" name="socLogin" id="socLogin" value=""/>
    <input type="hidden" name="socBdate" id="socBdate" value=""/>
    <input type="hidden" name="option" value="com_user"/>
    <input type="hidden" name="task" value="social"/>
</form>
<script type="text/javascript">
	window.addEvent('domready', function () {
		document.vkAuth = new vkAuth({id:<?php echo $mainframe->getCfg('vk_id'); ?>});
		document.mailAuth = new mailAuth({id:<?php echo $mainframe->getCfg('mail_ru_id'); ?>, key: '<?php echo $mainframe->getCfg('mail_ru_key'); ?>'});
		document.fbAuth = new fbAuth({id:<?php echo $mainframe->getCfg('fb_id'); ?>});
	});
</script>
<?php endif; ?>