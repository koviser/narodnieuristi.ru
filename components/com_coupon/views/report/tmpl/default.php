<?php defined('_JEXEC') or die; ?>

<div class="componentheading">
	<?php echo $this->escape($this->params->get('page_title')); ?>
</div>
<script type="text/javascript">
window.addEvent('domready', function () { 
	$$('button.validate').each(function(el) { 
		  el.addEvent('click', function() {
		      var value = $('email2').value;
			  var value2 = $('password').value;
		  	  regex=/^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
			  regex2=/^\S[\S ]{2,98}\S$/;
			  if(regex.test(value)){
			      if(regex2.test(value2)){
					  $('adminForm').submit();   
				  }else{
					  $('password').tween('background-color', ['#f00', '#fff000']);
					  return false; 
				  }  
			  }else{
				  $('email2').tween('background-color', ['#f00', '#fff000']);
				  return false; 
			  }
		}); 
	}); 
});
</script>
<div id="userEdit">
<form method="post" class="josForm form-validate" id="adminForm" name="adminForm">
<p class="white f18"><?php echo JText::_('Report desc'); ?></p>
        <table cellpadding="8" cellspacing="0" border="0">
        <tr>
            <td>
                <label for="password">
                    <?php echo JText::_( 'E-mail' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="text" id="email2" name="email" value="" size="30" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="password2">
                    <?php echo JText::_( 'Password' ); ?>:
                </label>
            </td>
            <td>
                <input class="inputbox" type="password" id="password" name="password" size="30" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="right">
                <button class="button validate" style="padding:6px;"><?php echo JText::_('Submit'); ?></button>
            </td>
        </tr>
    </table>
	<input type="hidden" name="option" value="com_coupon" />
    <input type="hidden" name="task" value="report" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
