<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Thông tin chung</h2>
					<div class="panel-description">
						Một số thông tin cơ bản của người sử dụng.
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Email <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('email', set_value('email', (isset($user['email'])) ? $user['email'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('email_original', set_value('email_original', (isset($user['email'])) ? $user['email'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Họ tên <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('fullname', set_value('fullname', (isset($user['fullname'])) ? $user['fullname'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">	
							<div class="col-lg-6">
								
								<script>
									var catalogue = <?php echo (isset($_POST['catalogue'])) ? json_encode($_POST['catalogue']) : ((isset($user['catalogue']) && $user['catalogue'] != null) ? $user['catalogue'] : '') ?>;	
								</script>
								<div class="form-row;">
									<label class="control-label text-left">
										<span>Chọn Phòng Ban</span>
									</label>
									
									<div class="form-row">
										<?php echo form_dropdown('catalogue[]', '', NULL, 'class="form-control selectMultiple" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.."  style="width: 100%;" data-module="'.$module.'_catalogue" data-select="title"'); ?>
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Giới tính</span>
									</label>
									 <?php   
                                         $gender = [
                                            -1 => 'Giới Tính',
                                            0 => 'Nữ',
                                            1 => 'Nam',
                                         ];
                                        echo form_dropdown('gender', $gender, set_value('gender', (isset($user['gender'])) ? $user['gender'] : -1),'class="form-control mr20 input-sm perpage filter" style="width:100%"');  
                                    ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ngày sinh <b class="text-danger"></b></span>
									</label>
									<?php echo form_input('birthday', set_value('birthday', (isset($user['birthday'])) ? $user['birthday'] : ''), 'class="form-control datetimepicker" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<?php if(isset($method) && $method == 'create' ){ ?>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Mật khẩu <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_password('password', set_value(''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<?php } ?>
							<div class="col-lg-6 <?php echo (isset($method) && $method == 'create' ) ? 'mt15' : '' ?>">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ảnh Đại diện</span>
									</label>
									<?php echo form_input('image', set_value('image', (isset($user['image'])) ? $user['image'] : ''), 'class="form-control" placeholder="" autocomplete="off" onclick="BrowseServer(this)"');?>
									<img src="" class="abc" alt="">
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Địa chỉ</h2>
					<div class="panel-description">
						Các thông tin liên hệ chính với người sử dụng này.
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0">
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<?php 
										$branchList = get_data([
											'select' => 'id, title',
											'table' => 'branch',
											'where' => ['publish' => 1, 'deleted_at' => 0],
											'order_by' => 'id desc',
										]); 
										$branchList  = convert_array([
											'text' => 'chi nhánh',
											'data' => $branchList,
											'field' => 'id',
											'value' => 'title',
										]);
									?>
									<label class="control-label text-left">
										<span>Chi nhánh làm việc</span>
									</label>
									<?php
										echo form_dropdown('branchid', $branchList, set_value('branchid', (isset($user['branchid'])) ? $user['branchid'] : 0),'class="form-control mr20 input-sm perpage filter" style="width:100%"');  ?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Số điện thoại</span>
									</label>
									<?php echo form_input('phone', set_value('phone', (isset($user['phone'])) ? $user['phone'] : ''), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Ghi chú</span>
									</label>
									<?php echo form_input('description', set_value('description'), 'class="form-control " placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-button pull-right">
								<button class="btn btn-primary btn-sm" name="create" value="create" type="submit">Lưu lại</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</form>