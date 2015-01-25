<?php defined('_JEXEC') or die('Restricted access');
	$uri = &JFactory::getURI();
	$url = $uri->toString( array('scheme', 'host', 'port'));
?>
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
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<div id="wB">
	<table cellpadding="0" cellspacing="0" width="100%">
    	<tr>
        	<td width="1%" valign="top">
            	<img src="images/bonus.jpg" alt="<?php echo JText::_('Invite friend'); ?>" />
            </td>
            <td class="invite">
            	<?php echo JText::_('Condition invite friend'); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="10" cellspacing="0" width="100%">
    	<tr>
        	<td width="50%" valign="top">
            	<div class="tS"><?php echo JText::_('Invite friend email'); ?></div>
                <div class="sendFriend">
                <form method="post" class="josForm form-validate" id="adminForm" name="adminForm">
                    <input type="text" name="email" id="email" value="<?php echo JText::_('Enter E-mail 2');?>" onblur="if(this.value=='') this.value='<?php echo JText::_('Enter E-mail 2');?>';" onfocus="if(this.value=='<?php echo JText::_('Enter E-mail 2');?>') this.value='';"/>
                    <button class="button validate" style="padding:6px;"><?php echo JText::_('Submit'); ?></button>
                    <input type="hidden" name="option" value="com_coupon" />
                    <input type="hidden" name="task" value="invite" />
                    <input type="hidden" name="friend" value="<?php echo base64_encode('user'.$this->user->id); ?>" />
                    <?php echo JHTML::_( 'form.token' ); ?>
                </form>
                </div>
            </td>
            <td width="50%" valign="top">
            	<div class="tS"><?php echo JText::_('Invite friend link'); ?></div>
                <div class="sendFriend">
                	<input type="text" name="link" id="link" onclick='this.select();' readonly='readonly' value="<?php echo $url.JRoute::_('index.php?option=com_coupon&view=registration&friend='.base64_encode('user'.$this->user->id)); ?>"/>
                	<div id="invite"><?php echo JEventsCommon::InviteFriend(base64_encode('user'.$this->user->id)); ?></div>
                </div>
            </td>
        </tr>
    </table>
</div>