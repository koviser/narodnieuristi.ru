<?php defined('_JEXEC') or die; ?>
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
<div class="componentheading">
	<?php echo JText::_('Reset your Password'); ?>
</div>
<div id="userEdit">
<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=completereset' ); ?>" method="post" class="josForm form-validate" id="passwordForm">
<p class="white"><?php echo JText::_('RESET_PASSWORD_COMPLETE_DESCRIPTION'); ?></p>
	<table cellpadding="8" cellspacing="0" border="0">
		<tr>
			<td>
				<label for="password1" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD1_TIP_TEXT'); ?>"><?php echo JText::_('Password'); ?>:</label>
			</td>
			<td>
				<input id="password1" name="password1" type="password" class="inputbox required validate-password" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="password2" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_PASSWORD2_TIP_TEXT'); ?>"><?php echo JText::_('Verify Password'); ?>:</label>
			</td>
			<td>
				<input id="password2" name="password2" type="password" class="inputbox required validate-password" />
			</td>
		</tr>
        <tr>
            <td colspan="2" align="right">
                <button class="button validate"><?php echo JText::_('Save'); ?></button>
            </td>
        </tr>
	</table>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>