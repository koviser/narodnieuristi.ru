var order = new Class({
	initialize: function(options){
		$$('input#moneyback').each(function(el) { 
			el.addEvent('click', function(event) {
				event.stop();
				var reqPaymentEnd = new Request({
					method: 'post', 
					url: 'index.php?option=com_coupon&task=newOrder',
					data: {'id_type':$('id_type').get('value'), 'id_roo':$('id_roo').get('value'), 'client_name':$('client_name').get('value'), 'client_phone':$('client_phone').get('value')}, 
					onComplete: function(response) {
						$('mb_result').set('html', response)
					}
				}).send();
				return false;
			}); 
		});
	}		
});