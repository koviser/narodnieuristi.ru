jQuery(document).ready(function(){
	
	// scroll to request form
	jQuery('.help-button .order').click(function(){
		var dest = jQuery('.request-block').offset().top;
		jQuery('body').animate({ scrollTop: dest }, 1000);
	});
	
	// yandex maps
	jQuery(".fancybox-maps").fancybox({
		type: 'iframe',
		width: 500,
		height: 500,
		afterClose: function(){
			var desctMaps = jQuery('.how-to-find-us').offset().top;
			jQuery('html').animate({ scrollTop: desctMaps }, 1000);
		},
	});
	
	// selects
	jQuery("#id_type").selectbox({
		onChange: function(){
			jQuery("#id_type + .sbHolder .sbSelector ").css('color','#000');
		}
	});
	
	jQuery("#id_roo").selectbox({
		onChange: function(){
			jQuery("#id_roo + .sbHolder .sbSelector ").css('color','#000');
		}
	});
	
	jQuery('.slider ul').cycle({
			fx: 'fade',
			speed: 700, 
			timeout: 12000,
			next: '.slider a.right',
			prev: '.slider a.left'
	});

	(function( $ ) {
	  $.fn.ziro = function() {
	  	if(this.val()){
	  		return true;
	  	}
	  	return false;
	  };
	})(jQuery);
	
	jQuery("#moneyback").click(function(){
		var form = jQuery(this).parent().parent();
		if(
			form.find("input[name='client_name']").ziro() &&
			form.find("input[name='client_phone']").ziro() &&
			jQuery(form.find('a.sbSelector')[0]).text()!="-Выберите тему-" &&
			jQuery(form.find('a.sbSelector')[1]).text()!="-Выберите регион-"
			){
			yaCounter27961860.reachGoal('zayavka'); 
			return true;
		}
	});
	
});