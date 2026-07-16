 <form method="post" action="" class="form-horizontal box customer-profile fix" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body response-message">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-5">
				<div class="panel-head">
					<h2 class="panel-title">Dịch vụ Domain</h2>
					<div class="panel-description">
						<p><small class="text-danger">
							Yêu cầu điền đầy đủ các thông tin được mô tả phía bên phải.
						</small></p>
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="ibox m0" id="customer-store">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between js_change_text_to_input">
							<div class="uk-flex uk-flex-middle">
								<h5>Thông tin Domain</h5>
							</div>
						
						</div>
					</div>
					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-cube-grid">
                            <div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div><div class="sk-cube"></div>
                        </div>
						<div class="row">
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left uk-flex uk-flex-middle">
										<span class="mr10">Tên Domain</span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($domain['title'])) ? $domain['title'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', (isset($domain['id'])) ? $domain['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Giá Mua/ Năm</span>
									</label>
									<?php echo form_input('price_buy', set_value('price_buy', (isset($domain['price_buy'])) ? number_format($domain['price_buy'],0,',','.') : ''), 'class="form-control input js_input int" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Giá Bán / Năm</span>
									</label>
									<?php echo form_input('price_sell', set_value('price_sell', (isset($domain['price_sell'])) ? number_format($domain['price_sell'],0,',','.') : ''), 'class="form-control input js_input int" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<div class="col-lg-12 mb10">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label text-left uk-flex uk-flex-middle">
										<span class="mr10">Giá Gia Hạn / Năm</span>
									</label>
									<?php echo form_input('price_extend', set_value('price_extend', (isset($domain['price_extend'])) ? number_format($domain['price_extend'],0,',','.') : ''), 'class="form-control input js_input int" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
						<div class="uk-flex uk-flex-right mt10">
							<div class="js_edit_all text-success m-r"><button class="btn btn-sm btn-success saveButton">Lưu lại</button></div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</form> 
