$(document).ready(function(){
	$(document).on('click' ,'.update_price' ,function(){
		let _this = $(this);
		$('.index_update_price').hide();
		$('.view_price').show();


		_this.find('.view_price').hide();
		_this.find('input').show();
	})

	$(document).on('change' ,'.index_update_price' ,function(){
		let _this = $(this);
		let val = _this.val();
		let id = _this.attr('data-id')
		let field = _this.attr('data-field')
		let form_URL = 'ajax/display/update_price';
		$.post(form_URL, {
			val : val, id: id, field: field
		},
		function(data){
			let json = JSON.parse(data);
			_this.hide();
			_this.siblings('.view_price').show();
			_this.siblings('.view_price').html(json.val);
		});	
	})
})	