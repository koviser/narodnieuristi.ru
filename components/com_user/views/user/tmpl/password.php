<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
	window.addEvent('domready', function () { 
		$$('button.validate').each(function(el) { 
		  el.addEvent('click', function() {
		      var value_1 = $('password').value;
		      var value_2 = $('password2').value;
			  regex=/^\S[\S ]{2,98}\S$/;
			  if(regex.test(value_1)){
				   if(value_1!=value_2){
					   $('password2').tween('background-color', ['#f00', '#fff000']);
				       return false; 
				   }else{
				       $('passwordForm').submit();   
				   }
			  }else{
				  $('password').tween('background-color', ['#f00', '#fff000']);
				  return false; 
			  }
		}); 
	  }); 
	});
</script>
<div class="blueF">
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="userform" autocomplete="off" id="passwordForm" class="form-validate">
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<div id="userEdit">
    <table cellpadding="8" cellspacing="0" border="0">
        <tr>
            <td>
                <label for="password">
                    <?php echo JText::_( 'Password' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="password" id="password" name="password" value="" size="20" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="password2">
                    <?php echo JText::_( 'Verify Password' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="password" id="password2" name="password2" size="20" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <button class="button validate"><?php echo JText::_('Save'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
	<input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="savePassword" />
	<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>
</div>