	(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	var module = 'CashPeriodic';
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
 	 		$('.object-form').on('submit', function(){
				let _this = $(this);
 	 			let title = $('input[name=title]').val();
 	 			let date_end = $('input[name=date_end]').val();
 	 			let money_end = $('.money_end').val();
 	 			let id_newest = $('input[name=id]').val();
 	 			let date_start = '';
 	 			if($('.date_start').length){
 	 				date_start = $('.date_start').text();
 	 			}else{
 	 				date_start = $('input[name=date_start]').val();
 	 			}

 	 			let money_start = '';
 	 			if($('.money_start').length){
 	 				money_start = $('.money_start').text();
 	 			}else{
 	 				money_start = $('input[name=money_start]').val();
 	 			}

 	 			let data = _this.serializeArray();

 	 			var formURL = 'ajax/'+module+'/save';
				$.post(formURL, {
					title: title,
					id_newest: id_newest,
					date_start: date_start,
					date_end:date_end,
					money_start:money_start,
					money_end: money_end,
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


    $(document).ready(function() {
    	HT.addObject();
    });

})(jQuery);
