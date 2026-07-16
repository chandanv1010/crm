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
			</div>
			<div class="col-lg-9">
				<div class="ibox" style="margin-bottom:0 !important;">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<div class="uk-flex uk-flex-middle">
								<h5>Chi tiết nâng cấp dịch vụ</h5>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<table class="table table-bordered">
                                <tr>
                                    <td>Tên miền</td>
                                    <td><?php echo (isset($contract_hosting['domain'])) ? $contract_hosting['domain'] : ''; ?></td>
                                </tr>
                                <tr>
                                    <td>IP VPS</td>
                                    <td><?php echo (isset($contract_hosting['ip_name'])) ? $contract_hosting['ip_name'] : ''; ?></td>
                                </tr>
                                <tr>
                                    <td>Thông tin dịch vụ trước đây</td>
                                    <td><?php echo (isset($contract_hosting['service_name'])) ? $contract_hosting['service_name'] : ''; ?> -  <?php echo (isset($contract_hosting['price'])) ? number_format($contract_hosting['price'], 0, ',', '.') : ''; ?> VNĐ</td>
                                </tr>
                                <tr>
                                    <td>Ngày hết hạn</td>
                                    <td><?php echo (isset($contract_hosting['date_end'])) ? gettime($contract_hosting['date_end'], 'd/m/Y') : ''; ?></td>
                                </tr>
                            </table>
						</div>
						<div class="row mt20">
							<table class="table table-bordered">
                            	<thead>
			                        <tr>
			                            <th>Thời gian sử dụng </th>
			                            <th>Số ngày sử dụng còn lại</th>
			                            <th>Số tiền trên 1 ngày</th>
			                            <th>Số tiền còn lại</th>
			                        </tr>
		                        </thead>
		                        <tbody>
		                        	<tr>
		                        		<td>
		                        			<?php echo (isset($contract_hosting['date_start'])) ? gettime($contract_hosting['date_start'], 'd/m/Y') : ''; ?> - <?php echo (isset($contract_hosting['date_end'])) ? gettime($contract_hosting['date_end'], 'd/m/Y') : ''; ?>
		                        		</td>
		                        		<td>
		                        			<?php echo (isset($contract_hosting['day']) && $contract_hosting['day'] > 0)? $contract_hosting['day']: 0 ?>
		                        		</td>
		                        		<?php 
		                        			$price_day = round($contract_hosting['price']/30);
		                        			if($contract_hosting['day'] > 0){
		                        				$refund = $contract_hosting['day']*$price_day;
		                        			}else{
		                        				$refund = 0;
		                        			}	

		                        		?>
		                        		<td>
		                        			<?php echo (isset($price_day)? number_format($price_day, 0, ',', '.'): '') ?> VNĐ
		                        		</td>
		                        		<td id="refund">
		                        			<?php echo (isset($refund)? number_format($refund, 0, ',', '.'): '') ?> VNĐ
		                        		</td>
		                        	</tr>
		                        </tbody>
                            </table>
						</div>
						<div class="row mt20">
							<div class="col-lg-4 mb10">
								<div class="form-row lta-select2 form-staff uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Người Phụ Trách</span>
									</label>
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
									<?php echo form_input('date_start', set_value('date_end', gettime(currentTime(), 'd/m/Y')), 'class="form-control input" data-mask="99/99/9999" readonly  placeholder="ví dụ: 28/2/2020" autocomplete="off"');?>
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
									<?php echo form_input('price', set_value('total', (isset($contract_hosting['price'])) ? number_format($contract_hosting['price'],0,',','.') : ''), 'class="form-control input int " readonly  placeholder="" autocomplete="off"');?>
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
						<script type="text/javascript">
							var postid = '<?php echo (isset($contract_hosting['id'])) ? $contract_hosting['id'] : '' ?>'
						</script>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tổng Giá Trị Gói Mới (VNĐ)</span>
									</label>
									<?php echo form_input('total','', 'class="form-control input int "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom search-advance-contract">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Số tiền phải trả thêm  (VNĐ)</span>
									</label>
									<?php echo form_input('totalFinal','0', 'class="form-control input int "  placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Ngày hết hạn</span>
									</label>
									<?php echo form_input('date_end','', 'class="form-control input" data-mask="99/99/9999" readonly  placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Chi nhánh</span>
									</label>
									<?php 
				                        $branchList = get_data([
				                            'select' => 'id, title',
				                            'table'  => 'branch',
				                            'where' => ['publish' => 1, 'deleted_at' => 0],
				                            'order_by' => 'id desc'
				                        ]);  
				                        $branchList = convert_array([
				                            'data' => $branchList,
				                            'field' => 'id',
				                            'value' => 'title',
				                            'text' => 'chi nhánh',
				                        ]);
				                    ?>
			                        <?php if(isset($branchList) && is_array($branchList) && count($branchList)){ ?>
			                        <?php echo form_dropdown('branchid',$branchList,(isset($contract_hosting['branchid']) ? $contract_hosting['branchid'] : ''),' class="form-control input "') ?>
			                        <?php } ?>
								</div>
							</div>
							<div class="col-lg-4 mb10">
								<div class="form-row uk-flex uk-flex-bottom ">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tạo QL tiền mặt</span>
									</label>
									<?php 
										$default = [
											0 => 'Không cho phép',
											1 => 'Cho phép'
										]
									 ?>
									<?php echo form_dropdown('money_default', $default,(isset($contract_hosting['money_default']) ? $contract_hosting['money_default'] : ''), 'class="form-control   input" ');?>
								</div>
							</div>
						</div>
						<div class="row mt20">
							<div class="col-lg-12 mb10">
								<div class="form-row">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Mô tả về hợp đồng: </span>
									</label>
									<?php echo form_textarea('description','', 'class="form-control mt10"  placeholder="" autocomplete="off" style="background:#fafafa;color:#1c84c6;"');?>
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
