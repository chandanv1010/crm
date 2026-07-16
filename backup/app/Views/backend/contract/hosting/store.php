<?php helper(['mystring','mydata']); ?>
<form method="post" action="" class="form-horizontal box customer-profile fix object-form" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body response-message">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-3">
				<div class="ibox m10 mb20" id="customer-store">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
							<div class="uk-flex uk-flex-middle">
								<h5>Thông tin Khách Hàng</h5>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-cube-grid">
                            <div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div>
                        </div>

						<div class="row">
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Khách Hàng</span>
									</label>
									<?php echo form_input('fullname', set_value('fullname', (isset($contract_hosting['fullname'])) ? $contract_hosting['fullname'] : ''), 'class="form-control input js_fullname"  placeholder="" autocomplete="off"');?>
									<div id="customer-result">

									</div>

                                    <?php echo form_input('id', set_value('id', (isset($contract_hosting['id'])) ? $contract_hosting['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>
                                    
									<?php echo form_input('method', set_value('method', (isset($method)) ? $method : ''), 'class="form-control input js_input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>

                                	<?php echo form_hidden('customerid', set_value('customerid', (isset($contract_hosting['customerid'])) ? $contract_hosting['customerid'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="customer_id"');?>

								</div>
							</div>

							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Số điện thoại</span>
									</label>
									<?php echo form_input('phone', set_value('phone', (isset($contract_hosting['phone'])) ? $contract_hosting['phone'] : ''), 'class="form-control input js_input" readonly placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Email</span>
									</label>
									<?php echo form_input('email', set_value('email', (isset($contract_hosting['email'])) ? $contract_hosting['email'] : ''), 'class="form-control input js_input " placeholder="" readonly autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Địa chỉ </span>
									</label>
									<?php echo form_input('address', set_value('address', (isset($contract_hosting['address'])) ? $contract_hosting['address'] : ''), 'class="form-control input js_input" readonly placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>

					</div>
				</div>
				<a href="<?php echo base_url('backend/customer/customer/create') ?>" title="Tạo khách hàng" target="_blank" class="va-btn open-window">Tạo khách hàng mới</a>
			</div>
			<div class="col-lg-9">
				<div class="ibox" style="margin-bottom:0 !important;">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<div class="uk-flex uk-flex-middle">
								<h5>Thông tin Hợp Đồng</h5>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label  special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tên Miền</span>
									</label>
									<?php echo form_input('domain', set_value('domain', (isset($contract_hosting['domain'])) ? $contract_hosting['domain'] : ''), 'class="form-control input "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-ip uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">IP VPS</span>
									</label>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày khởi tạo</span>
									</label>
									<?php echo form_input('date_start', set_value('date_start', (isset($contract_hosting['date_start'])) ? gettime($contract_hosting['date_start'], 'd/m/Y') : ''), 'class="form-control input" data-mask="99/99/9999"  placeholder="ví dụ: 28/2/2020" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-service uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Loại dịch vụ</span>
									</label>
								</div>
							</div> 
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Giá tiền (VNĐ)</span>
									</label>
									<?php echo form_input('price', set_value('price', (isset($contract_hosting['price'])) ? number_format($contract_hosting['price'],0,',','.') : ''), 'class="form-control input int " readonly  placeholder="" autocomplete="off"');?>
								</div>
								<div class="form-price-hidden"></div>
							</div> 
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-timeline uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Thời gian dịch vụ</span>
									</label>
								</div>
							</div> 
						</div>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-staff uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Người Phụ Trách</span>
									</label>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<script type="text/javascript">
									var postid = '<?php echo (isset($contract_hosting['id'])) ? $contract_hosting['id'] : '' ?>'
								</script>
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tổng Giá Trị</span>
									</label>
									<?php echo form_input('total', set_value('total', (isset($contract_hosting['total'])) ? number_format($contract_hosting['total'],0,',','.') : ''), 'class="form-control input int "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày hết hạn</span>
									</label>
									<?php echo form_input('date_end', set_value('date_end', (isset($contract_hosting['date_end'])) ? gettime($contract_hosting['date_end'], 'd/m/Y') : ''), 'class="form-control input" data-mask="99/99/9999" readonly  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-lg-12 mb10">
								<div class="form-row">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Mô tả về hợp đồng: </span>
									</label>
									<?php echo form_textarea('description', set_value('description', (isset($contract_hosting['description'])) ? $contract_hosting['description'] : ''), 'class="form-control mt10"  placeholder="" autocomplete="off" style="background:#fafafa;color:#1c84c6;"');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-flex uk-flex-right mt10">
			<div class="js_edit_all text-success"><button class="btn btn-sm btn-success saveButton">Lưu lại</button></div>
		</div>
	</div>

</form>
