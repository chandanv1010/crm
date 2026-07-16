	(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	var module = 'CashCatalogue';
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
 	 			let id = $('input[name=id]').val();
 	 			let data = _this.serializeArray();

 	 			var formURL = 'ajax/'+module+'/save';
				$.post(formURL, {
					title: title,
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


    $(document).ready(function() {
    	HT.addObject();
    });

})(jQuery);
