<?php defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
	function populate(aYear,aMonth,aDay) 
	{
		var curYear=aYear.selectedIndex;
		var curMonth=aMonth.selectedIndex;
		var curDay=aDay.selectedIndex;
		var timeA = new Date(aYear[curYear].text, aMonth[curMonth].value,1);
		var timeDifference = timeA - 86400000+3600000;
		var timeB = new Date(timeDifference);
	
		var daysInMonth = timeB.getDate();
		for (var i = 0; i < aDay.length; i++) aDay[0] = null;
		for (var i = 0; i < daysInMonth; i++) aDay[i] = new Option(i+1);
		aDay.selectedIndex=curDay;
	}
// -->
</script>
<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" name="userform" autocomplete="off" class="form-validate">
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<div id="userEdit">
    <table cellpadding="8" cellspacing="0" border="0">
        <tr>
            <td width="120">
                <label for="name">
                    <?php echo JText::_( 'Your Name' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="text" id="name" name="name" value="<?php echo $this->escape($this->user->get('name'));?>" size="20" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="gender">
                    <?php echo JText::_( 'Gender' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $this->lists['gender']; ?>
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
            <td colspan="2" align="right">
                <button class="button" type="submit"><?php echo JText::_('Save'); ?></button>
            </td>
        </tr>
    </table>
    <input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
	<input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="save" />
	<?php echo JHTML::_( 'form.token' ); ?>
</div>
</form>
	


