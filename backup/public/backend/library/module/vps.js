(function($) {
	"use strict";
    var HT = {};

    var time = 100;
	/* MAIN VARIABLE */

    var $window            		= $(window),
		$document           	= $(document),
		saveButton        	= $(".saveButton");

	// Check if element exists
    $.fn.elExists = function() {
        return this.length > 0;
    };


    HT.addCustomer = () => {
 	 	if(saveButton.elExists){
 	 		$(saveButton).on('click', function(){

 	 			let title = $('input[name=title]').val()
 	 			let ip = $('input[name=ip]').val()
 	 			let disk_space = $('input[name=disk_space]').val()
 	 			let id = $('input[name=id]').val()
 	 			var formURL = 'ajax/vps/save';
				$('#customer-store .ibox-content').addClass('sk-loading');

				$.post(formURL, {
					title: title, ip: ip, disk_space: disk_space, id: id},
					function(data){
						$('#customer-store .ibox-content').removeClass('sk-loading');
						let response = JSON.parse(data);
						if(response.code == 10){
							toastr.success(response.message);
							$('.response-message').html('').hide();
							if(id == 0){
								$('#customer-store input').val('');
								$('#customer-store select').val(0);
							}
							if(id > 0){
								$('input[name=phone_original]').val(response.phone)
								$('input[name=email_original]').val(response.email)
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

    $(document).ready(function() {
    	HT.addCustomer();
        
    });

})(jQuery);

