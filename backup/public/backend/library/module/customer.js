(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
		saveCustomer        	= $(".saveCustomer");

	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };


    HT.addCustomer = () => {
 	 	if(saveCustomer.elExists){
 	 		$(saveCustomer).on('click', function(){
 	 			let fullname = $('input[name=fullname]').val()
 	 			let phone = $('input[name=phone]').val()
 	 			let email = $('input[name=email]').val()
 	 			let catalogueid = $('select[name=catalogueid]').val()
 	 			let email_original = $('input[name=email_original]').val()
 	 			let phone_original = $('input[name=phone_original]').val()
 	 			let id = $('input[name=id]').val()

 	 			let param = {
 	 				'address' : $('input[name=address]').val(),
 	 				'cityid' : $('select[name=cityid]').val(),
 	 				'birthday' : $('input[name=birthday]').val(),
 	 				'gender' : $('select[name=gender]').val(),
 	 				'company' : $('input[name=company]').val(),
 	 				'company_mst' : $('input[name=company_mst]').val(),
 	 				'company_address' : $('input[name=company_address]').val(),
 	 				'code': $('input[name=code]').val()
 	 			}

 	 			var formURL = 'ajax/customer/save';

				$('#customer-store .ibox-content').addClass('sk-loading');

				$.post(formURL, {
					post: param,fullname: fullname, phone: phone, email: email, catalogueid: catalogueid, email_original: email_original, phone_original: phone_original, id: id},
					function(data){
						$('#customer-store .ibox-content').removeClass('sk-loading');
						let response = JSON.parse(data);
						console.log(response);
						if(response.code == 10){
							toastr.success(response.message);
							$('.response-message').html('').hide();
							$('input[name=phone_original]').val(response.phone);
							$('input[name=email_original]').val(response.email);
							$('input[name=id]').val(response.id)
							$('#incident-store').removeClass('hidden');

						}else{
							if(response.code == 22){
								$('.response-message').html('<div class="alert alert-danger">'+response.message+'</div>').show();
								toastr.error('Có lỗi xảy ra! Vui lòng thử lại');
							}else{
								toastr.error(response.message);
							}
						}


					});
 	 			return false;
 	 		});

 	 	}
    };

    HT.deleteOject = () =>{
    	$(document).on('click', '.lta-delete', function(){
    		let _this = $(this);
    		let id = _this.attr('href');
    		if(id > 0){
			swal({
					title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
					text: 'Xóa mục được chọn',
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Thực hiện!",
					cancelButtonText: "Hủy bỏ!",
					closeOnConfirm: false,
					closeOnCancel: false },
				function (isConfirm) {
					if (isConfirm) {
						var formUrl = 'ajax/customer/delete';
							$.post(formUrl, {
								id: id,},
								function(data){
									let response = JSON.parse(data);
									if(response.code == 10){
										_this.closest('tr').toggle();
										swal("Xóa thành công!", "Các bản ghi đã được xóa khỏi danh sách.", "success");
										
									}else{
										sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
									}
							});
					} else {
						swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
					}
				});
			}

			return false;
    	});
    };

    HT.displayBox = () =>{
    	$(document).on('click', '.showbox', function(){
    		let _this = $(this);
    		let target = _this.attr('data-target');
    		$(target).toggleClass('hidden');

    		return false;
    	});
    };

    HT.saveIncident = () =>{
    	$(document).on('click', '.saveIncident',function(){
    		let description = $('textarea[name=description]').val();
    		let user_catalogueid = $('select[name=user_catalogueid]').val();
    		let customerid = $('input[name=id]').val();
    		var formURL = 'ajax/incident/save';
    		$('#customer-store .ibox-content').addClass('sk-loading');
    		$.post(formURL, {
					description: description,user_catalogueid: user_catalogueid, status: status, customerid: customerid},
					function(data){
						$('#customer-store .ibox-content').removeClass('sk-loading');
						let response = JSON.parse(data);
						if(response.code == 10){
							toastr.success(response.message);
							$('.response-message').html('').hide();
							let html = HT.htmlIncident(response.department, response.description, response.created_at );
							console.log(html);
							if($('.incident-list li ').length){
								$('.incident-list li ').first().before(html);
							}else{
								$('.incident-list').append(html);
							}

						}else{
							if(response.code == 22){
								$('.response-message').html('<div class="alert alert-danger">'+response.message+'</div>').show();
								toastr.error('Có lỗi xảy ra! Vui lòng thử lại');
							}else{
								toastr.error(response.message);
							}
						}


					});
    		return false;
    	});
    };

    HT.htmlIncident = (department, description, time) => {
    	console.log(department);
    	let html  = "";
    	html= html + '<li>'
			html= html + '<div class="incident-item gh pending showbox" data-target= "#process-store" >'
				html= html + department + ': ' +description+' - <span>'+time+'</span>'
			html= html + '</div>'
		html= html + '</li>'

		return html;
    };


    $(document).ready(function() {
    	HT.addCustomer();
    	HT.displayBox();
    	HT.saveIncident();
    	HT.deleteOject();
    });

})(jQuery);
