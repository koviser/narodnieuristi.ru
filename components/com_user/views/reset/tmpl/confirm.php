<?php defined('_JEXEC') or die; ?>

<div class="componentheading">
	<?php echo JText::_('Confirm your Account'); ?>
</div>
<div id="userEdit">
<form action="<?php echo JRoute::_( 'index.php?option=com_user&task=confirmreset' ); ?>" method="post" class="josForm form-validate">
	<p class="white"><?php echo JText::_('RESET_PASSWORD_CONFIRM_DESCRIPTION'); ?></p>
    <table cellpadding="8" cellspacing="0" border="0">
		<tr>
			<td>
				<label for="token" class="hasTip" title="<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TITLE'); ?>::<?php echo JText::_('RESET_PASSWORD_TOKEN_TIP_TEXT'); ?>"><?php echo JText::_('Token'); ?>:</label>
			</td>
			<td>
				<input id="token" name="token" type="text" class="inputbox required" size="36" />
			</td>
		</tr>
        <tr>
			<td colspan="2" align="right">
				<button type="submit" class="button"><?php echo JText::_('Submit'); ?></button>
			</td>
		</tr>
	</table>
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
