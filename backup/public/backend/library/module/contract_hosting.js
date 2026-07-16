	(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	var module = 'ContractHosting';
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

    // bat/tat form tim kiem nang cao 
    $(document).on('click','.form-advanced',function(){
    	let _this = $(this);
    	let text = _this.text();
    	if(text == 'Tìm kiếm nâng cao'){
    		text = 'Thu gọn';
    	}else{
    		text = 'Tìm kiếm nâng cao';
    	}
    	_this.text(text);
    	$('.form-search').find('.box-advanced').toggle();
		return false;
    });

    $(document).ready(function(){
    	let staff = $('select[name=staff]').val();
    	let city = $('select[name=city]').val();
    	let timeFrom = $('input[name=timeFrom]').val();
    	let timeTo = $('input[name=timeTo]').val();

    	if(staff != 0 || city != 0 || timeFrom != '' || timeTo != ''){
    		$('.form-advanced').trigger('click');
    	}
    });
    // reset form
    // $(document).on('click', '.form-reset',function(){
    // 	let _this = $(this);
    // 	let form = _this.closest('.form-search');
    // 	form.find('input').val('');
    // 	form.find('select:not(select.perpage)').val(0);
    // 	return false;
    // });



    // lay gia cua goi dich vu
    HT.price = () =>{
    	$(document).on('change','select[name=service]',function(){
    		let _this = $(this);
    		let method = $('input[name=method]').val();
    		let count = _this.attr('data-count');
    		if(method == 'update' && count == 0){
    			count = count + 1;
    			_this.attr('data-count',count);
    		}else{
	    		let service = _this.val();
	    		$('select[name=price-hidden]').val(service).trigger('change');
	    		let price = $('select[name=price-hidden] option:selected').text();
	    		$('input[name=price]').val(price).trigger('change');
    		}
    	});
    };

    //lay thoi gian het han
    HT.timeEnd = () =>{
    	$(document).on('change','input[name=date_start], select[name=timeline] ',function(){
    		let date_start = $('input[name=date_start]').val();
    		let long_time = $('select[name=timeline]').val();
    		let from = date_start.split("/");
    		let date = new Date(from[2],from[1] - 1,from[0]);
    		let currentDay = date.getDate();
    		date.setMonth(date.getMonth()+ +long_time);
		    if (date.getDate() != currentDay) {
		      date.setDate(0);
		    }
    		date =  $.datepicker.formatDate('dd/mm/yy', date);
    		$('input[name=date_end]').val(date).trigger('change');
    	});
    };

    //tinh tong tien
    HT.money = () =>{
    	$(document).on('change', 'input[name=price], select[name=timeline]', function(){
    		let price = $('input[name=price]').val();
    		price = price.replace(/\./gi, "");
    		let timeline = $('select[name=timeline]').val();
    		$('input[name=total]').val(price*timeline).trigger('change');
    	});
    };

    // tiền trả thêm
    HT.moneyMore = () =>{
    	$(document).on('change', 'input[name=total]', function(){
    		let refund = $('#refund').text();
    		refund = refund.replace(/\./gi, "");
    		let total = $('input[name=total]').val();
    		total = total.replace(/\./gi, "");
    		if(parseInt(total) - parseInt(refund) > 0){
    			$('input[name=totalFinal]').val(parseInt(total) - parseInt(refund)).trigger('change');
    		}
    	});
    };

    HT.renderFormSelect = (array, text) =>{
    	let html = '';
    	
    	if(text == 'price-hidden'){
    		html= html +'<select name="'+text+'" class="form-control hidden" disabled >'
		    	if(typeof(array) != 'undefined'){
					$.each(array, function(index, value){
						html= html + '<option value="'+index+'">'+value+'</option>'
					})
				}
			html= html +'</select>'
    	}else{
	    	html= html +'<select name="'+text+'" class="form-control input select2" data-count="0"   placeholder="" autocomplete="off">'
		    	if(typeof(array) != 'undefined'){
					$.each(array, function(index, value){
						html= html + '<option value="'+index+'">'+value+'</option>'
					})
				}
			html= html +'</select>'
    	}

		return html;
    };

    var time = 0;
    HT.showContract = () => {
		$(document).on('click','.show-infor', function(){
			let _this = $(this);
			let id = _this.closest('tr').attr('data-id');
			if($('.show-ojectid-'+id+'').length){
				$('.hosting-infor').remove();
			}else{
				$('.hosting-infor').remove();
				let formURL = 'ajax/ContractHosting/getInforContract';
				clearTimeout(time);
				time = setTimeout(function(){
					$.post(formURL,{id:id},
						function(data){
							let response = JSON.parse(data);
							console.log(response.data);
							if(response.code == 10){
								let html = HT.renderHostingInfor(response.data, id);
								let tr_parent = _this.closest('tr');
								$(html).insertAfter(tr_parent);
							}else{
								toastr.error(response.message);
							}
						})
				},200);
			}
		});
	}

	HT.renderHostingInfor = (infor, id) =>{
		console.log(infor);
		let html = '';
		let upgrade = '';
		 if(infor.length > 0 ){
		 	html= html + '<tr class="hosting-infor show-ojectid-'+id+'">'
                    html= html + '<td>Lần</td>'
                    html= html + '<td> Tên gói</td>'
                    html= html + '<td> Giá gói</td>'
                    html= html + '<td> IP- VPS</td>'
                    html= html + '<td> Người phụ trách</td>'
                    html= html + '<td> Ngày bắt đầu</td>'
                    html= html + '<td> Ngày kết thúc</td>'
                    html= html + '<td> Tổng tiền</td>'
            html= html + '</tr>'
        	infor.forEach(function(item, index, array){
        		if(item.type == 'nâng cấp'){
    				upgrade= upgrade + '<div class="tooltip"> - <i class="fa fa-arrow-up" aria-hidden="true"></i>'
				  		upgrade= upgrade + '<span class="tooltiptext">Tiền trả thêm: '+item.add_payment+' VNĐ</span>'
					upgrade= upgrade + '</div>'
        		}
                html= html + '<tr class="hosting-infor show-ojectid-'+item.objectid+'">'
                    html= html + '<td>'+(index + 1)+'</td>'
                    html= html + '<td>'+item.service+ upgrade+'</td>'
                    html= html + '<td>'+item.price+' VNĐ</td>'
                    html= html + '<td>'+item.ip_vps+'</td>'
                    html= html + '<td>'+item.userid+'</td>'
                    html= html + '<td>'+item.date_start+'</td>'
                    html= html + '<td>'+item.date_end+'</td>'
                    html= html + '<td>'+item.total+' VNĐ</td>'
                html= html + '</tr>'
			})
		}else{
			html= html + '<tr class="hosting-infor show-ojectid-'+id+'">'
				html = html + '<td class="text-danger" colspan="100%">Hosting chưa được gian hạn lần nào!</div>';
			html= html + '</tr>'
		}
		return html;
	}


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

    // thong tin khách hàng
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
 	 			let customerid = $('input[name=customerid]').val();
 	 			let domain = $('input[name=domain]').val();
 	 			let ip_vps = $('select[name=ip_vps]').val();
 	 			let service = $('select[name=service]').val();
 	 			let userid = $('select[name=userid]').val();
 	 			let timeline = $('select[name=timeline]').val();
 	 			let date_start = $('input[name=date_start]').val();
 	 			let id = $('input[name=id]').val();
 	 			let method = $('input[name=method]').val();
				let data = _this.serializeArray();
				

 	 			var formURL = 'ajax/'+module+'/save';
				$('#customer-store .ibox-content').addClass('sk-loading');
				$.post(formURL, {
					customerid: customerid, 
					domain:domain, 
					ip_vps:ip_vps,
					service:service,
					userid:userid,
					timeline:timeline,
					date_start:date_start,
					id: id, 
					method:method, 
					post: data},
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
	  	HT.showContract();
    	HT.addObject();
    	HT.showCustomerList();
        HT.chooseCustomer();
        HT.price();
        HT.timeEnd();
        HT.money();
        HT.moneyMore();
		if($('.object-form').length){
			setTimeout(function(){
				let formURL = 'ajax/'+module+'/getDataBeforeInsert';
				$.post(formURL,{id:postid},function(data){
					let response = JSON.parse(data);
					if(response.code == 10){
						var staff = HT.renderFormSelect(response.data.staff, 'userid');
						var service = HT.renderFormSelect(response.data.service, 'service');
						var timeline = HT.renderFormSelect(response.data.timeline, 'timeline');
						var ip_vps = HT.renderFormSelect(response.data.ip_vps, 'ip_vps');
						var price = HT.renderFormSelect(response.data.price, 'price-hidden');
						let dataUpdate = response.data.selectUpdate;

						if($('#id').val() != 0){
							let method = $('input[name=method]').val();
							let userid = dataUpdate.userid;
							let _service = dataUpdate.service;
							let _ip_vps = dataUpdate.ip_vps;
							let _timeline = dataUpdate.timeline;

							$('.form-staff').append(staff);
							$('.form-ip').append(ip_vps);
							$('.form-price-hidden').append(price);
							$('.form-service').append(service);
							$('.form-timeline').append(timeline);

							$('.form-staff').find('.select2').val(userid).trigger('change');
							$('.form-ip').find('.select2').val(_ip_vps).trigger('change');
							$('select[name=service]').val(_service).trigger('change');
							$('select[name=timeline]').val(_timeline).trigger('change');
						}
						else{
							$('.form-staff').append(staff);
							$('.form-ip').append(ip_vps);
							$('.form-service').append(service);
							$('.form-price-hidden').append(price);
							$('.form-timeline').append(timeline);
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
