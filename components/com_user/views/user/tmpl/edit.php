<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
	window.addEvent('domready', function () { 
		document.saveForm = new JSaveForm();
	});
</script>
<div id="round">
	<div id="rt"><div id="rb">
	<div class="paymentTitle"><?php echo $this->escape($this->params->get('page_title')); ?></div>
    <div id="tabPanel">
    	<a href="index.php?option=com_user"><?php echo JText::_( 'My coupons' ); ?></a>
        <a href="index.php?option=com_user&layout=billing"><?php echo JText::_( 'Billing' ); ?></a>
        <span><?php echo JText::_( 'Personal info' ); ?></span>
        
<a href="index.php?option=com_user&layout=giftcard"><?php echo JText::_('Gift card');?></a>
        <?php if($this->user->advertiser==1){ ?>
        <a href="index.php?option=com_user&layout=myevents"><?php echo JText::_( 'My events' ); ?></a>
        <?php } ?>
        <?php if($this->user->partner){ ?>
         <a href="index.php?option=com_user&layout=partner"><?php echo JText::_( 'My partner' ); ?></a>
        <?php } ?>
    </div>
	<div id="personalText">
<form method="post" name="userform" autocomplete="off" id="userform">
    <table cellpadding="7" cellspacing="0" id="tableForm">
        <tr>
            <td width="120px">
                <label for="name">
                    <?php echo JText::_( 'Your Name' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="text" id="nameF" name="name" value="<?php echo $this->escape($this->user->get('name'));?>" size="20" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="family">
                    <?php echo JText::_( 'Family' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="text" id="familyF" name="family" value="<?php echo $this->escape($this->user->get('family'));?>" size="20" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="birthDay">
                    <?php echo JText::_( 'Birthday' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $this->lists['birthDay']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="city">
                    <?php echo JText::_( 'City' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $this->lists['city']; ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="subscribed">
                    <?php echo JText::_( 'Subscribe' ); ?>:
                </label>
            </td>
            <td>
            	<div id="selectSubscribe">
                <?php echo $this->lists['subscribe']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
            	<br/><br/><b><?php echo JText::_( 'CHANGE PASSWORD' ); ?></b>
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">
                    <?php echo JText::_( 'Password' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="password" id="passwordF" name="password" value="" size="20" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="password2">
                    <?php echo JText::_( 'Verify Password' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="password" id="password2F" name="password2" size="20" />
            </td>
        </tr>
        <tr class="gray2">
            <td></td>
            <td>
                <input type="button" class="Submit saveProfile" value="<?php echo JText::_('Save'); ?>" />
            </td>
        </tr>
    </table>
    <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
	<input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="save" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
	</div>
</div></div></div>