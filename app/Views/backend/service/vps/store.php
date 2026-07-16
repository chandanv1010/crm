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
								<h5>Thông tin vps</h5>
							</div>
							<div class="uk-flex uk-flex-middle">
								<div class="js_edit_all text-success m-r"><button class="btn btn-sm btn-success saveButton">Lưu lại</button></div>
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
										<span class="mr10">Tên Vps</span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($vps['title'])) ? $vps['title'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', (isset($vps['id'])) ? $vps['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Dung lượng </span>
									</label>
									<?php echo form_input('disk_space', set_value('disk_space', (isset($vps['disk_space'])) ? $vps['disk_space'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Địa Chỉ IP</span>
									</label>
									<?php echo form_input('ip', set_value('ip', (isset($vps['ip'])) ? $vps['ip'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form> 
