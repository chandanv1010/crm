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
									<?php echo form_input('fullname', set_value('fullname', (isset($contract_website['fullname'])) ? $contract_website['fullname'] : ''), 'class="form-control input js_fullname"  placeholder="" autocomplete="off"');?>
									<div id="customer-result">

									</div>

                                    <?php echo form_input('id', set_value('id', (isset($contract_website['id'])) ? $contract_website['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>


                                	<?php echo form_hidden('customerid', set_value('customerid', (isset($contract_website['customerid'])) ? $contract_website['customerid'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="customer_id"');?>

								</div>
							</div>

							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Số điện thoại</span>
									</label>
									<?php echo form_input('phone', set_value('phone', (isset($contract_website['phone'])) ? $contract_website['phone'] : ''), 'class="form-control input js_input" readonly placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Email</span>
									</label>
									<?php echo form_input('email', set_value('email', (isset($contract_website['email'])) ? $contract_website['email'] : ''), 'class="form-control input js_input " placeholder="" readonly autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Địa chỉ </span>
									</label>
									<?php echo form_input('address', set_value('address', (isset($contract_website['address'])) ? $contract_website['address'] : ''), 'class="form-control input js_input" readonly placeholder="" autocomplete="off"');?>
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
								<script type="text/javascript">
									var postid = '<?php echo (isset($contract_website['id'])) ? $contract_website['id'] : '' ?>'
								</script>
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tổng Giá Trị</span>
									</label>
									<?php echo form_input('total', set_value('total', (isset($contract_website['total'])) ? number_format($contract_website['total'],0,',','.') : ''), 'class="form-control input int "  placeholder="" autocomplete="off"');?>
									<input type="hidden" id="database" value="" >
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-staff uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Người Phụ Trách</span>
									</label>
								</div>
							</div>
							<div class="col-lg-4 mb10">

								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày Ký</span>
									</label>
									<?php echo form_input('date_sign', set_value('date_sign', (isset($contract_website['date_sign'])) ? gettime($contract_website['date_sign'], 'd/m/Y') : ''), 'class="form-control input" data-mask="99/99/9999"  placeholder="ví dụ: 28/2/2020" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label  special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tên Miền</span>
									</label>
									<?php echo form_input('domain', set_value('domain', (isset($contract_website['domain'])) ? $contract_website['domain'] : ''), 'class="form-control input "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">File Hợp Đồng</span>
									</label>
									<?php echo form_input('contract_file', set_value('contract_file', (isset($contract_website['contract_file'])) ? $contract_website['contract_file'] : ''), 'class="form-control input"  placeholder="Click để Upload File Hợp Đồng" autocomplete="off" onClick="BrowseServer(this, File)"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-process uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Trạng Thái</span>
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label  special text-left uk-flex uk-flex-middle">
										<span class="mr10">Chi nhánh</span>
									</label>
									<?php echo form_dropdown('branchid', $branch,set_value('branchid',(isset($contract_website['branchid'])) ? $contract_website['branchid'] : ''), 'class="form-control input "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-lg-12 mb10">
								<div class="form-row">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Mô tả về hợp đồng: </span>
									</label>
									<?php echo form_textarea('description', set_value('description', (isset($contract_website['description'])) ? $contract_website['description'] : ''), 'class="form-control mt10"  placeholder="" autocomplete="off" style="background:#fafafa;color:#1c84c6;"');?>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="ibox">
					<div class="ibox-title" style="border-width:1px !important;background: #1c84c6;">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5 style="color:#fff;margin-bottom: 0;">Thông tin Thanh Toán</h5>
							<a href="" style="color:#fff;" class="add-billing">Thêm Lần Thu</a>
						</div>
					</div>
					<div class="ibox-content" id="place-billding">
						<?php
							helper('mydata');
							if(isset($PayInfo) && is_array($PayInfo) && count($PayInfo)){
							foreach ($PayInfo as $key => $value) {
						?>
						<div class="row billing-item">
							<div class="col-lg-3 mb10">
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Số Tiền</span>
									</label>
									<input type="text" name="billing[price][]" value="<?php echo (isset($value['money'])) ? number_format($value['money'],0,',','.') : '' ?>" class="form-control input int text-right billing-price" placeholder="" autocomplete="off">
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom ">
										<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Người Thu</span>
									</label>
									<select name="billing[cashierid][]" class="form-control input select2 billing_cashierid" placeholder="" autocomplete="off">
										<option value="0">[Chọn người phụ trách]</option>
										<?php if(staff() != 'undefined'){ ?>
										<?php foreach (staff() as $key => $val) { ?>
											<option value="<?php echo $val['id'] ?>" <?php echo ($value['cashierid'] == $val['id']) ? 'selected' : '' ?>><?php echo $val['fullname'] ?></option>
										<?php }} ?>
									</select>
								</div>
							</div>
							<script type="text/javascript">

							</script>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày Thu</span>
									</label>
									<input type="text" name="billing[date][]" value="<?php echo gettime($value['date'], 'd/m/Y') ?>" class="form-control input billing_date" data-mask="99/99/9999" placeholder="ví dụ: 28/2/2020" autocomplete="off">
								</div>
							</div>
							<div class="col-lg-1 text-right">
								<a href="" title="" class="lta-closed" >
									Xóa bỏ
									</a>
							</div>
						</div>
						<?php }}else{ ?>
							<div class="lta-report text-danger">Chưa có thông tin thanh toán....</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-flex uk-flex-right mt10">
			<div class="js_edit_all text-success"><button class="btn btn-sm btn-success saveButton">Lưu lại</button></div>
		</div>
	</div>

</form>
