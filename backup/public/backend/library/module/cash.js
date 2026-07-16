	(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	var module = 'Cash';
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
		saveButton        		= $(".saveButton");


	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };


    HT.addObject = () => {
 	 	if(saveButton.elExists){
 	 		$(document).on('click','.saveButton', function(){
				let _this = $(this);
				let parentTr = _this.closest('tr');
 	 			let title =parentTr.find('input[name=title]').val();
 	 			let id = parentTr.find('input[name=id]').val();
 	 			let catalogueid = parentTr.find('select[name=catalogueid]').val();
 	 			let branchid = parentTr.find('select[name=branchid]').val();
 	 			let data = {
 	 				'title' : title,
 	 				'money_collect' : parentTr.find('input[name=money_collect]').val(),
 	 				'money_pay' : parentTr.find('input[name=money_pay]').val(),
 	 				'description' : parentTr.find('input[name=description]').val(),
 	 				'catalogueid' : catalogueid,
 	 				'branchid' : branchid,
 	 				'created_at' : parentTr.find('input[name=created_at]').val(),
 	 				'periodicid' : parentTr.find('input[name=periodicid]').val(),
 	 			};
 	 			var formURL = 'ajax/'+module+'/save';
				$.post(formURL, {
					title: title,
					catalogueid: catalogueid,
					branchid: branchid,
					id:id,
					data:data},
					function(data){
						let response = JSON.parse(data);
						if(response.code == 10){
							toastr.success(response.message);
							location.reload();
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

 	var time = 0;
    HT.updateOject = () =>{
    	$(document).on('click','.lta-edit',function(){
    		let _this = $(this);
    		let id = _this.attr('href');
    		$('#tr-'+id+'').toggle();
    		let formURL = 'ajax/'+module+'/update';

    		clearTimeout(time);
    		time = setTimeout(function(){
    			$.post(formURL,{id:id},	
    				function(data){
    					let response = JSON.parse(data);
    					if(response.code == 10){
    						$(response.data.html).insertAfter('#tr-'+id+'');
    					}else{
							if(response.code == 22){
								$('.response-message').html('<div class="alert alert-danger">'+response.message+'</div>').show();
								toastr.error('Có lỗi xảy ra! Vui lòng thử lại');
							}else{
								toastr.error(response.message);
							}
						}
    				});
    		});


    		return false;
    	});
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
						var formUrl = 'ajax/'+module+'/delete';
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


    $(document).ready(function() {
    	HT.addObject();
    	HT.updateOject();
    	HT.deleteOject();
    });

})(jQuery);
