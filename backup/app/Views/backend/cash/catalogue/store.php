
<form method="post" action="" class="form-horizontal object-form">
	<div class="wrapper wrapper-content animated fadeInRight ">
		<div class="row">
			<div class="box-body response-message">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Thêm mới nhóm tiền mặt</h2>
					<div class="panel-description">
						<p><small class="text-danger">
							Yêu cầu điền đầy đủ các thông tin được mô tả phía bên phải.
						</small></p>
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox float-e-margins">
					<div class="ibox-content profile-content">
						<div class="form-group form_border_b">
							<div class="uk-flex uk-flex-middle">
								<label class="col-md-3 mb-0">
									<div class=" control-label mb-0">
										<span class="m-r">Tên nhóm tiền mặt</span>
									</div>
								</label>
								<div class="col-md-6">
									<?php echo form_input('title', set_value('title', (isset($cash_catalogue['title'])) ? $cash_catalogue['title'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off" ');?>
									<?php echo form_input('id', set_value('id', (isset($cash_catalogue['id'])) ? $cash_catalogue['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>
								</div>
							</div>
						</div>
						<div class="form-group form_border_b">
							<div class="uk-flex uk-flex-middle">
								<label class="col-md-3 mb-0">
									<div class=" control-label mb-0">
										<span class="m-r">Tên nhóm tiền mặt</span>
									</div>
								</label>
								<div class="col-md-6">
									<?php echo form_input('title', set_value('title', (isset($cash_catalogue['title'])) ? $cash_catalogue['title'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off" ');?>
									<?php echo form_input('id', set_value('id', (isset($cash_catalogue['id'])) ? $cash_catalogue['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>
								</div>
							</div>
						</div>
						<div class="form-group form_border_b">
							<div class="uk-flex uk-flex-middle">
								<label class="col-md-3 mb-0">
									<div class=" control-label mb-0">
										<span class="m-r">Mô tả</span>
									</div>
								</label>
								<div class="col-md-6">
									<?php echo form_input('description', set_value('description', (isset($cash_catalogue['description'])) ? $cash_catalogue['description'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off" ');?>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content profile-content">
						<div class="toolbox action clearfix">
							<div class="uk-flex uk-flex-middle uk-flex-space-between uk-button ">
								<div></div>
								<button class="btn btn-primary btn-sm saveButton" >Lưu</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
