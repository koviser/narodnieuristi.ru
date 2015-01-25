<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="blueF">
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="userform" autocomplete="off" id="passwordForm" class="form-validate">
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<div id="userEdit">
    <table cellpadding="8" cellspacing="0" border="0">
        <tr>
            <td>
                <label for="subscribed">
                    <?php echo JText::_( 'Subscribe' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $this->lists['subscribe']; ?>
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
	<input type="hidden" name="task" value="saveSubscribe" />
	<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>
</div>