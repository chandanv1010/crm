 <form method="post" action="" class="form-horizontal box customer-profile" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body response-message">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox m0" id="customer-store">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
							<div class="uk-flex uk-flex-middle">
								<h5>Thông tin khách hàng</h5>
							</div>
							<div class="uk-flex uk-flex-middle">
								<div class="js_edit_all text-success m-r"><button class="btn btn-sm btn-success saveCustomer">Lưu lại</button></div>
								<div class="js_extend text-success pull-right cursor" data-expand="1"><u>Mở Rộng</u></div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-cube-grid">
                            <div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div>
                        </div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Họ Tên</span>
										<span style="font-weight:normal;" class="text-success">(anh / chị ) </span>
									</label>
									<?php echo form_input('fullname', set_value('fullname', (isset($customer['fullname'])) ? $customer['fullname'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', (isset($customer['id'])) ? $customer['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Địa chỉ </span>
									</label>
									<?php echo form_input('address', set_value('address', (isset($customer['address'])) ? $customer['address'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Số điện thoại </span>
									</label>
									<?php echo form_input('phone', set_value('phone', (isset($customer['phone'])) ? $customer['phone'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('phone_original', set_value('phone_original', (isset($customer['phone'])) ? $customer['phone'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Thành Phố</span>
									</label>
									<?php 
										$city = get_data(['select' => 'provinceid, name','table' => 'vn_province','order_by' => 'order desc, name asc']);
										$city = convert_array([
											'data' => $city,
											'field' => 'provinceid',
											'value' => 'name',
											'text' => 'Thành Phố',
										]);
									?>
									<?php echo form_dropdown('cityid', $city, set_value('cityid', (isset($customer['cityid'])) ? $customer['cityid'] : ''), 'class="form-control input city select2"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Email </span>
									</label>
									<?php echo form_input('email', set_value('email', (isset($customer['email'])) ? $customer['email'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('email_original', set_value('email_original', (isset($customer['email'])) ? $customer['email'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Nguồn Khách</span>
									</label>
									<?php 
										$city = get_data(['select' => 'id, title','table' => 'customer_catalogue','order_by' => 'title asc']);
										$city = convert_array([
											'data' => $city,
											'field' => 'id',
											'value' => 'title',
											'text' => 'Nguồn Khách',
										]);
									?>
									<?php echo form_dropdown('catalogueid', $city, set_value('catalogueid', (isset($customer['catalogueid'])) ? $customer['catalogueid'] : ''), 'class="form-control input select2"');?>
								</div>
							</div>
						</div>
						<div class="extend">
							
							<div class="row mb15">
								<div class="col-lg-6">
									<div class="form-row uk-flex uk-flex-bottom">
										<label class="control-label special text-left uk-flex uk-flex-middle">
											<span class="mr10">Công Ty</span>
											<span style="font-weight:normal;" class="text-warning">(nếu có ) </span>
										</label>
										<?php echo form_input('company', set_value('company', (isset($customer['company'])) ? $customer['company'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-row uk-flex uk-flex-bottom">
										<label class="control-label text-left uk-flex uk-flex-middle">
											<span class="mr10">Giới Tính</span>
										</label>
										 <?php   
					                         $gender = [
					                            0 => '[Chọn Giới Tính]',
					                            1 => 'Nữ',
					                            2 => 'Nam',
					                         ];
					                        echo form_dropdown('gender', $gender, set_value('gender', (isset($customer['gender'])) ? $customer['gender'] : ''),'class="form-control input select2" style="width:100%"');  
					                    ?>
									</div>
									
									
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-6">
									<div class="form-row uk-flex uk-flex-bottom">
										<label class="control-label special text-left uk-flex uk-flex-middle">
											<span>Địa chỉ CT</span>
										</label>
										<?php echo form_input('company_address', set_value('company_address', (isset($customer['company_address'])) ? $customer['company_address'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-row uk-flex uk-flex-bottom">
										<label class="control-label special text-left uk-flex uk-flex-middle">
											<span>Mã KH</span>
										</label>
										<?php echo form_input('code', set_value('code', (isset($customer['code'])) ? $customer['code'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ibox m0 <?php echo ($method == 'update')? '': 'hidden' ?>" id="incident-store">
					<section class="incident-wrapper">
						<div class="ibox-title">
							<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
								<div class="uk-flex uk-flex-middle">
									<h5>Vấn đề của khách hàng</h5>
								</div>
								<!-- <button class="btn btn-sm btn-success addIncident">
									Tạo vấn đề
								</button> -->
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#box-incident">
								  Tạo vấn đề
								</button>
							</div>
						</div>
						<div class="ibox-content">
							<div class="row mb15">
								<div class="col-lg-6 b-r">
									<div class="form-row">
										<ul class="uk-clearfix uk-list incident-list">
											<?php if(isset($incidentList) && is_array($incidentList) && count($incidentList)){ ?>
											<?php foreach ($incidentList as $key => $value) { ?>
											<li>
												<div class="incident-item gh showbox <?php echo ($value['status'] == 0)? 'pending': 'end' ?>" data-target= "#process-store">
													<?php echo $value['user_catalogue'] ?>:  <?php echo $value['description'] ?>- <span><?php echo $value['created_at'] ?></span>
												</div>
											</li>
											<?php }} ?>
											<!-- <li>
												<div class="incident-item kt">
													Phòng Kế Toán: Nguyễn Công Tuấn chuyển hợp đồng cho bộ phận gia hạn - 10:10 22/08/2019
												</div>
											</li> -->
										</ul>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="discussion">
										<!-- <div class="chat-message left">  
											<div class="message-item">
												<a class="message-author" href="#">phuongnt</a> (01-11-2019) :- Gia hạn thành công 2019
											</div>
										</div>
										<div class="chat-message left">  
											<div class="message-item">
												<a class="message-author" href="#">tuannc</a> (01-11-2019) :- Đã nhận yêu cầu gia hạn, khách hàng cần làm thêm website, đề nghị bên Sale Check lại.
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
				<div class="ibox m0 hidden" id="process-store">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
							<div class="uk-flex uk-flex-middle">
								<h5>Nội dung Vấn đề của khách hàng	</h5>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-8 b-r">
								<textarea class="form-control m-b-sm" name="" rows="5" cols="30"></textarea>
								<?php $time = ['Gọi lại sau 15 phút','Gọi lại sau 30 phút','Gọi lại sau 1 tiếng','Gọi lại sau 2 tiếng','Gọi lại sau 6 tiếng','Gọi lại sau 1 ngày','Gọi lại sau 3 ngày','Gọi lại sau 7 ngày'] ?>
								<div class="row m-b-sm time-list">
									<?php foreach($time as $key => $val){ ?>
									<div class="col-lg-3 mb10">
										<div class="uk-flex uk-flex-middle">
											<input type="radio" id="incident_time_<?php echo $key; ?>" value="" name="incident_time" class="mt0">
											<label style="margin:0;" for="incident_time_<?php echo $key; ?>" class="text-success"><?php echo $val; ?></label>
										</div>
									</div>
									<?php } ?>
									<div class="col-lg-12">
										<div class=" mt20">
											<div class="uk-flex uk-flex-middle uk-flex-space-between">
												<div class="m-r-sm close-incident uk-flex uk-flex-middle">
													<input class="" class="close-incident" type="checkbox" value="1" id="close-incident">
													<label class="" for="close-incident">Đóng Vấn Đề </label>
												</div>
												<div class="button-group">
													<button class="btn btn-primary saveIncident js_add_incident_rela m-r-sm" type="button"><i class="fa fa-check mr10"></i>Lưu </button>
													<button class="btn btn-danger  js_close_windown " type="button"><i class="fa fa-close mr10"></i>Đóng</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-row">
											<ul class="uk-list uk-clearfix list-type">
												<?php $array = [' Gia hạn hosting','Gia hạn tên miền','Lấy source','Chỉnh sửa giao diện','Tư vấn mua website','Không gia hạn']; ?>
												<?php foreach($array as $key => $val){ ?>
												<li>
													<div class="incident-type uk-flex uk-flex-middle">
														<input type="radio" id="incident_type_<?php echo $key; ?>" value="" name="incident_type" class="mt0">
														<label style="margin:0;" for="incident_type_<?php echo $key; ?>" class=""><?php echo $val; ?></label>
													</div>
												</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="modal fade" id="box-incident" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLongTitle">Nội dung vấn đề</h5>
      		</div>
	      	<div class="modal-body">
		        <textarea class="form-control m-b-sm" name="description" rows="5" cols="30" placeholder="Nội dung vấn đề"></textarea>
				 <?php echo form_dropdown('user_catalogueid', $user_catalogueList, 0 ,'class="form-control input select2" style="width:100%"');  
			    ?>
	      	</div>
      		<div class="modal-footer">
	        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
	        	<button type="button" class="btn btn-primary saveIncident">Lưu lại </button>
      		</div>
    	</div>
	</div>
</div> 
<?php /*
	<li class="mb20 ">
	
</li>
*/ ?>
