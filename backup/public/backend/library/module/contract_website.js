var time = 100;
var module = 'ContractWebsite';
$(document).on('click','.setting_action', function(){
	let _this = $(this);
	$('#insert_general')[0].reset();
	let form_URL = 'ajax/'+module+'/getDisplayCatalogue';
	$.post(form_URL, {
	},
	function(data){
		$('.select-parent-body').html(data);
		if($('.select2').length){
			$('.select2').select2();
		}
	});	
	return false;
});
$('#popup_store').on("submit", function(event) {
    event.preventDefault();
    let title = $('#title').val();
    let keyword = $('#keyword').val();
    let parentid = $('#parentid').val();
    let id = $('#id').val();
    let status = $('input[name="status"]:checked').val();
    if (title == "") {
        alert("Vui lòng nhập vào trường Tiêu đề !");
    } else if (keyword == '') {
        alert("Vui lòng nhập vào trường Từ khóa!");
    } else {
        let form_URL = 'ajax/'+module+'/insertFunction';
    	$.post(form_URL, {
			title : title, keyword: keyword, parentid: parentid, id: id,status :status
		},
		function(data){
			window.location.reload();
		});	
    }
});

$(document).on('click','.display_update', function(){
	// $('#insert_general')[0].reset();
	let _this = $(this);
	let val = _this.attr('data-display')
	console.log(val);
	let form_URL = 'ajax/'+module+'/updateDisplayCatalogue';
	$.post(form_URL, {
		data: val
	},
	function(data){
		let json = JSON.parse(data);
			console.log(json);

		$('#id').val(json.id);
		$('#title').val(json.title);
		$('#keyword').val(json.keyword);
		$('#parentid').val(json.parentid);
		// $('#parentid').trigger('change')
		$('input[name="status"][value="' + json.status + '"]').prop('checked', true);
	});	
	return false;
});

$(document).on('click','.display_delete', function(){
	let _this = $(this);
	let data = _this.attr('data-display')
	let form_URL = 'ajax/'+module+'/deleteDisplayCatalogue';

	if(data.length > 0){
		swal({
			title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
			text: 'Xóa Chức năng được chọn',
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Thực hiện!",
			cancelButtonText: "Hủy bỏ!",
			closeOnConfirm: false,
			closeOnCancel: false },
		function (isConfirm) {
			if (isConfirm) {
				$.post(form_URL, {
					data: data,},
					function(data){
						let json = JSON.parse(data);
						if(json.length == 0){
							sweet_error_alert('Có vấn đề xảy ra','Vui lòng thử lại')
						}else{
							for(let i = 0; i < json.length; i++){
								$('#post-'+ json[i].id).hide().remove()				
							}
							swal("Xóa thành công!", "Bản ghi đã được xóa khỏi hệ thống.", "success");
						}
					});
			} else {
				swal("Hủy bỏ", "Thao tác bị hủy bỏ", "error");
			}
		});
	}
	else{
		sweet_error_alert('Thông báo từ hệ thống!', 'Bạn phải chọn 1 bản ghi để thực hiện chức năng này');
		return false;
	}
	return false;
});

	(function($) {
	"use strict";
    var HT = {};

    
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
		saveButton        		= $(".saveButton"),
		addBilling				= $(".add-billing"),
		closedBilling			= $(".lta-closed"),
		customerFullname 		= $('.js_fullname');


	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };

    // add  bill
    HT.showBilling = () =>{
    	if(addBilling.elExists){
    		$(addBilling).on('click', function(){
    			let response = $('#database').val();
				response = JSON.parse(response);
    			let content = HT.renderBillding(response.data.staff);
    			$('#place-billding .lta-report').hide();
    			$('#place-billding').append(content);

    			// chay select 2
				if($('.select2').length){
					$('.select2').select2();
				}
    			return false;
    		});
    	}
    };
    HT.removeBilling = () =>{
    	if(closedBilling.elExists){
    		$(document).on('click',".lta-closed", function(){
    			let _this = $(this);
    			_this.closest('.billing-item').remove();
    			if($('.billing-item').length == 0){
    				$('#place-billding .lta-report').show();
    			}
    			return false;
    		});
    	}
    };

    

    HT.renderFormSelect = (array, text) =>{
    	let html = '';
    	html= html +'<select name="'+text+'" class="form-control input select2 " placeholder="" autocomplete="off">'
	    	if(typeof(array) != 'undefined'){
				$.each(array, function(index, value){
					html= html + '<option value="'+index+'">'+value+'</option>'
				})
			}
		html= html +'</select>'

		return html;
    };

    // render html Billding
    HT.renderBillding = (staff) =>{
    	let html = '';
    	html= html + '<div class="row billing-item">'
			html= html + '<div class="col-lg-3 mb10">'
				html= html + '<div class="form-row uk-flex uk-flex-bottom search-advance-contract">'
					html= html + '<label class="control-label special text-left uk-flex uk-flex-middle">'
					html= html + '	<span class="mr10">Số Tiền</span>'
					html= html + '</label>'
					html= html + '<input type="text" name="billing[price][]" value="" class="form-control input int text-right billing-price" placeholder="" autocomplete="off">'
				html= html + '</div>'
			html= html + '</div>'
			html= html + '<div class="col-lg-4 mb10">'
				html= html + '<div class="form-row lta-select2 uk-flex uk-flex-bottom ">'
					html= html + '	<label class="control-label special text-left uk-flex uk-flex-middle">'
					html= html + '	<span class="mr10">Người Thu</span>'
					html= html + '</label>'
					html= html + '<select name="billing[cashierid][]" class="form-control input select2 billing_cashierid" placeholder="" autocomplete="off">'
						if(typeof(staff) != 'undefined'){
							$.each(staff, function(index, value){
								html= html + '<option value="'+index+'">'+value+'</option>'
							})
						}
					html= html + '</select>'
				html= html + '</div>'
			html= html + '</div>'
			html= html + '<div class="col-lg-4 mb10">'
				html= html + '<div class="form-row uk-flex uk-flex-bottom ">'
					html= html + '<label class="control-label special text-left uk-flex uk-flex-middle">'
						html= html + '<span class="mr10">Ngày Thu</span>'
					html= html + '</label>'
					html= html + '<input type="text" name="billing[date][]" value="" class="form-control input billing_date" data-mask="99/99/9999" placeholder="ví dụ: 28/2/2020" autocomplete="off">'
				html= html + '</div>'
			html= html + '</div>'
			html= html + '<div class="col-lg-1 text-right">'
				html= html + '<a href="" title="" class="lta-closed" >'
					html= html + 'Xóa bỏ'
					html= html + '</a>'
			html= html + '</div>'
		html= html + '</div>'
		return html;
    };



    HT.showCustomerList = () => {
    	if(customerFullname.elExists){
    		$(customerFullname).on('keyup', function(){
				let _this = $(this);
				let keyword = _this.val();
				let formURL = 'ajax/customer/list';
				let field = 'id, fullname, phone, email, address';
				let fieldKeyword = 'fullname';

				clearTimeout(time);
				if(keyword.length > 1){
					time = setTimeout(function(){
	    				$.get(formURL, {
						keyword: keyword, field: field, fieldKeyword: fieldKeyword},
						function(data){
							let response = JSON.parse(data);
							pre(response);
							if(response.code == 10){
								let html = HT.renderHtml(response.data);
								$('#customer-result').html(html);
							}else{
								toastr.error(response.message);
							}

						});
	    			}, 300)
				}
    		});
    	}
    };

    HT.chooseCustomer = () => {
    	$(document).on('click','#customer-result ul li', function(){
    		let _this = $(this);
    		let customerInfo = JSON.parse(_this.attr('data-info'));
    		$('input[name=fullname]').val(customerInfo.fullname);
    		$('input[name=phone]').val(customerInfo.phone);
    		$('input[name=email]').val(customerInfo.email);
    		$('input[name=address]').val(customerInfo.address);
    		$('input[name=customerid]').val(customerInfo.id);
    		$('.js_target_search_advance').hide().hide();
    	});
    }

    HT.renderHtml = (data) => {
    	let html = '';
    	html = html + '<ul class="uk-list list-data js_target_search_advance" style="">'
    	if(typeof(data) != 'undefined'){
    		data.forEach(function(item, index, array) {
    			let info = JSON.stringify(item);
			    html = html + '<li data-info=\''+info+'\'>'
			        html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between">'
			            html = html + '<div class="fullname">Họ và tên: '+item.fullname+'</div>'
			            html = html + '<div class="phone">'+item.phone+'</div>'
			        html = html + '</div>'
			        html = html + '<div class="uk-flex uk-flex-middle uk-flex-space-between"><div class="email">'+item.email+'</div></div>'
			        html = html + '<div class="address">'+item.address+'</div>'
			    html = html + '</li>'
			});
    	}else{
    		 html = html + '<li>'
    		 	html = html + '<div class="text-danger">Không có dữ liệu phù hợp!</div>'
    		 html = html + '</li>'
    	}
    	html = html + '</ul>'
		return html;
    }

    HT.addObject = () => {
 	 	if(saveButton.elExists){
 	 		$('.object-form').on('submit', function(){
				let _this = $(this);
 	 			let customerid = $('input[name=customerid]').val()
 	 			let id = $('input[name=id]').val()
				let data = _this.serializeArray();
				let billing = {
					'billingPrice' : HT.HandleMultipeClassValue('billing-price'),
					'billingCashierId' : HT.HandleMultipeClassValue('billing_cashierid'),
					'billingDate' : HT.HandleMultipeClassValue('billing_date')
				}

 	 			var formURL = 'ajax/'+module+'/save';
				$('#customer-store .ibox-content').addClass('sk-loading');
				$.post(formURL, {
					customerid: customerid, id: id, billing: billing, post: data},
					function(data){
						$('#customer-store .ibox-content').removeClass('sk-loading');
						let response = JSON.parse(data);
						if(response.code == 10){
							toastr.success(response.message);
							$('.response-message').html('').hide();
							if(id == 0){
								$('.object-form input').val('');
								$('.object-form select').val(0);
								$('.object-form textarea').val('');
								$('.select2').val(0).trigger('change');
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

 	 	}
    };

	HT.HandleMultipeClassValue = (string) => {
		let object = []
		$('.'+string).each(function(){
			object.push($(this).val())
		});
		return object;
	}

    $(document).ready(function() {

    	HT.addObject();
    	HT.showCustomerList();
        HT.chooseCustomer();
        HT.showBilling();
        HT.removeBilling();

		if($('.object-form').length){
			setTimeout(function(){
				let formURL = 'ajax/'+module+'/getDataBeforeInsert';
				$.post(formURL,{id:postid},function(data){
					let response = JSON.parse(data);
					$('#database').val(data);

					if(response.code == 10){
						let status = HT.renderFormSelect(response.data.status, 'status');
						let process = HT.renderFormSelect(response.data.process, 'process');
						var staff = HT.renderFormSelect(response.data.staff, 'userid');
						let dataUpdate = response.data.selectUpdate;

						if($('#id').val() != 0){
							let userid = dataUpdate.userid;
							let _process = dataUpdate.process;
							let _status = dataUpdate.status;
							$('.form-status').append(status);
							$('.form-process').append(process);
							$('.form-staff').append(staff);
							$('.form-process').find('.select2').val(_process).trigger('change');
							$('.form-staff').find('.select2').val(userid).trigger('change');
							$('.form-status').find('.select2').val(_status).trigger('change');
							//
						}
						else{
							$('.form-status').append(status);
							$('.form-process').append(process);
							$('.form-staff').append(staff);
						}

						// chay select 2
						if($('.select2').length){
							$('.select2').select2();
						}
					}else{
						toastr.error(response.message);
					}
				});
			}, 200);
		}


    });

})(jQuery);
