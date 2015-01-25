<?php defined('_JEXEC') or die; ?>
<script type="text/javascript">
window.addEvent('domready', function () { 
	$$('button.validate').each(function(el) { 
		  el.addEvent('click', function() {
		      var value = $('email').value;
		  	  regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
			  if(regex.test(value)){
			      $('adminForm').submit();   
			  }else{
				  $('email').tween('background-color', ['#f00', '#fff000']);
				  return false; 
			  }
		}); 
	}); 
});
</script>
<div id="round">
    <div id="rt"><div id="rb">
        <?php if($this->social){?>
        	<div class="paymentTitle"><?php echo JText::_('Registration soc'); ?></div>
            <form method="post" class="josForm form-validate" id="adminForm" name="adminForm">
                <table cellpadding="5" cellspacing="0">
                    <tr>
                        <td>
                            <?php echo JText::_('Enter E-mail');?>
                        </td>
                        <td>
                            <input type="text" name="email" id="email" value="<?php echo $this->post['email']; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <button class="button validate" style="padding:6px;"><?php echo JText::_('RegOK'); ?></button>
                        </td>
                    </tr>
                </table>
                    
                    
                <input type="hidden" name="option" value="com_coupon" />
                <input type="hidden" name="task" value="registration" />
                <input type="hidden" name="friend" value="<?php echo $this->post['friend']; ?>" />
                <?php echo JHTML::_( 'form.token' ); ?>
            </form>
        <?php }else{ ?>
        <div class="paymentTitle"><?php echo JText::_('Enter site'); ?></div>
        <form method="post" name="login-two" id="form-login-two" >
        	<table cellpadding="5" cellspacing="0">
            	<tr>
                	<td>
                    	<?php echo JText::_('E-mail'); ?>
                    </td>
                    <td>
                    	<input type="text" name="username" class="inputbox" alt="username" size="18"  />
                    </td>
                </tr>
                <tr>
                	<td>
                    	<?php echo JText::_('Password'); ?>
                    </td>
                    <td>
                    	<input type="password" name="passwd" class="inputbox" size="18" alt="password" />
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="right">
                    	<a class="vkLogin"><img src="<?php echo JUri::base()?>/modules/mod_login/images/vk.png" align="absmiddle"/></a>
                        <a class="mailLogin"><img src="<?php echo JUri::base()?>/modules/mod_login/images/mail.png" align="absmiddle"/></a>
                        <a class="fbLogin"><img src="<?php echo JUri::base()?>/modules/mod_login/images/fb.png" align="absmiddle"/></a>
                    	<button class="button" style="padding:6px;"><?php echo JText::_('Enter'); ?></button>
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="right">
                    	<a href="<?php echo JRoute::_( 'index.php?option=com_user&view=reset' ); ?>"><?php echo JText::_('FORGOT_YOUR_PASSWORD'); ?></a>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="remember" value="yes" />
            <input type="hidden" name="return" value="<?php echo JRequest::getVar( 'return', '', 'get', 'string', JREQUEST_ALLOWRAW );?>" />
            <input type="hidden" name="option" value="com_user" />
            <input type="hidden" name="task" value="login" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
        <div class="spr"></div>
		<div class="paymentTitle"><?php echo JText::_('Registration'); ?></div>
        <form method="post" class="josForm form-validate" id="adminForm" name="adminForm">
        	<table cellpadding="5" cellspacing="0">
            	<tr>
                	<td>
                    	<?php echo JText::_('Enter E-mail');?>
                    </td>
                    <td>
                    	<input type="text" name="email" id="email" />
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="right">
                    	<button class="button validate" style="padding:6px;"><?php echo JText::_('RegOK'); ?></button>
                    </td>
                </tr>
            </table>
                
                
            <input type="hidden" name="option" value="com_coupon" />
            <input type="hidden" name="task" value="registration" />
            <input type="hidden" name="friend" value="<?php echo JRequest::getVar( 'friend', '', 'get', 'string', JREQUEST_ALLOWRAW );?>" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
        <?php } ?>
    </div></div>
</div>