<script>
	var catalogue = <?php echo (isset($_POST['catalogueid'])) ? json_encode($_POST['catalogueid']) : ((isset($deadline['catalogueid']))? $deadline['catalogueid'] : 0) ?>;	
</script>
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
								<h5>Thông tin thời gian xử lý</h5>
							</div>
							<div class="uk-flex uk-flex-middle">
								<div class="js_edit_all text-success m-r"><button class="btn btn-sm btn-success saveButton">Lưu lại</button></div>
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
										<span class="mr10">Tên thời gian xử lý: </span>
									</label>
									<?php echo form_input('title', set_value('title', (isset($deadline['title'])) ? $deadline['title'] : ''), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
									<?php echo form_hidden('id', set_value('id', (isset($deadline['id'])) ? $deadline['id'] : 0), 'class="form-control input js_input" placeholder="" autocomplete="off"');?>
								</div>
							</div>
							<?php 
								$catalogueList = get_data([
									'select' => 'id, title',
									'table' => 'deadline_catalogue',
									'where' => ['publish' => 1, 'deleted_at' => 0],
									'order_by' => 'id desc',
								]); 
								$catalogueList  = convert_array([
									'text' => '',
									'data' => $catalogueList,
									'field' => 'id',
									'value' => 'title',
								]);
							?>
							<div class="col-lg-6">
								<div class="form-row lta-select2 uk-flex uk-flex-bottom">
									<label class="control-label text-left">
										<span>Nhóm xử lý</span>
									</label>
									<?php
										echo form_dropdown('catalogueid[]', $catalogueList,NULL ,' multiple="multiple" class="form-control select2 input-sm selectMultiple" style="width:100%" data-module ="deadline_catalogue" data-select="title"');  ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-6">
								<div class="form-row uk-flex uk-flex-bottom">
									<label class="control-label special text-left ">
										<span class="mr10">Thời gian xử lý: </span>
									</label>
									<?php echo form_input('timeline', set_value('timeline', (isset($deadline['timeline'])) ? $deadline['timeline'] : ''), 'class="form-control input int" placeholder="Nhập số phút" style="width: 100px" autocomplete="off"');?>
									<span>phút</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form> 
