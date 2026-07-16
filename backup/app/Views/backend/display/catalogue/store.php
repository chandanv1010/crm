<?php  
    helper('form', 'data');
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<form method="post" action="" class="form-horizontal box" >
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="box-body">
				<?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
			</div><!-- /.box-body -->
		</div>
		<div class="row">
			<div class="col-lg-8 clearfix">
				<div class="ibox mb20">
					<div class="ibox-title" style="padding: 9px 15px 0px;">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5>THÔNG TIN CƠ BẢN <small class="text-danger">điền đầy đủ các thông tin được mô tả dưới đây</small></h5>
							<div class="ibox-tools">
								<button type="submit" name="create" value="create" class="btn btn-primary block full-width m-b">Lưu</button>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<label class="control-label text-left">
										<span>Tiêu đề danh mục <b class="text-danger">(*)</b></span>
									</label>
									<?php echo form_input('title', validate_input(set_value('title', (isset($display_catalogue['title'])) ? $display_catalogue['title'] : '')), 'class="form-control '.(($method == 'create') ? 'title' : '').'"  placeholder="" id="title" autocomplete="off"'); ?>
								</div>
							</div>
						</div>
						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row form-description">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span>Mô tả ngắn</span>
										</label>
										<a href="" title="" data-target="description" class="uploadMultiImage">Upload hình ảnh</a>
									</div>
									<?php echo form_textarea('description', htmlspecialchars_decode(html_entity_decode(set_value('description', (isset($display_catalogue['description'])) ? $display_catalogue['description'] : ''))), 'class="form-control ck-editor" id="description" placeholder="" autocomplete="off"');?>

								</div>
							</div>
						</div>

						<div class="row mb15">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="uk-flex uk-flex-middle uk-flex-space-between">
										<label class="control-label text-left">
											<span>Nội dung</span>
										</label>
										<a href="" title="" data-target="content" class="uploadMultiImage">Upload hình ảnh</a>
									</div>
									<?php echo form_textarea('content', htmlspecialchars_decode(html_entity_decode(set_value('content', (isset($display_catalogue['content'])) ? $display_catalogue['content'] : ''))), 'class="form-control ck-editor" id="content" placeholder="" autocomplete="off"');?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ibox ibox-seo mb20">
					<div class="ibox-title">
						<div class="uk-flex uk-flex-middle uk-flex-space-between">
							<h5>Tối ưu SEO <small class="text-danger">Thiết lập các thẻ mô tả giúp khách hàng dễ dàng tìm thấy bạn.</small></h5>
							
							<div class="uk-flex uk-flex-middle uk-flex-space-between">
								<div class="edit">
									<a href="#" class="edit-seo">Chỉnh sửa SEO</a>
								</div>
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<?php  
									$metaTitle = (isset($_POST['meta_title'])) ? $_POST['meta_title'] : ((isset($display_catalogue['meta_title']) && $display_catalogue['meta_title'] != '') ? $display_catalogue['meta_title'] : 'Bạn chưa nhập tiêu đề SEO cho Danh mục') ;
									$googleLink = (isset($_POST['canonical'])) ? $_POST['canonical'] : ((isset($display_catalogue['canonical']) && $display_catalogue['canonical'] != '') ? BASE_URL.$display_catalogue['canonical'].HTSUFFIX : BASE_URL.'duong-dan-website'.HTSUFFIX) ;
									$metaDescription = (isset($_POST['meta_description'])) ? $_POST['meta_description'] : ((isset($display_catalogue['meta_description']) && $display_catalogue['meta_description'] != '') ? $display_catalogue['meta_description'] : 'Bạn Chưa nhập mô tả SEO cho Danh mục') ;
								?>
								<div class="google">
									<div class="g-title"><?php echo $metaTitle; ?></div>
									<div class="g-link"><?php echo $googleLink ?></div>
									<div class="g-description" id="metaDescription">
										<?php echo $metaDescription; ?>
										
									</div>
								</div>
							</div>
						</div>
						
						<div class="seo-group hidden">
							<hr>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span>Tiêu đề SEO</span>
											</label>
											<span style="color:#9fafba;"><span id="titleCount">0</span> trên 70 ký tự</span>
										</div>
										<?php echo form_input('meta_title', htmlspecialchars_decode(html_entity_decode(set_value('meta_title', (isset($display_catalogue['meta_title'])) ? $display_catalogue['meta_title'] : ''))), 'class="form-control meta-title" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span>Mô tả SEO</span>
											</label>
											<span style="color:#9fafba;"><span id="descriptionCount">0</span> 0 trên 320 ký tự</span>
										</div>
										<?php echo form_textarea('meta_description', set_value('meta_description', (isset($display_catalogue['meta_description'])) ? $display_catalogue['meta_description'] : ''), 'class="form-control meta-description" id="seoDescription" placeholder="" autocomplete="off"');?>
									</div>
								</div>
							</div>
							<div class="row mb15">
								<div class="col-lg-12">
									<div class="form-row">
										<div class="uk-flex uk-flex-middle uk-flex-space-between">
											<label class="control-label ">
												<span>Đường dẫn  <b class="text-danger">(*)</b></span>
											</label>
										</div>
										<div class="outer">
											<div class="uk-flex uk-flex-middle">
												<div class="base-url"><?php echo base_url(); ?></div>
												<?php echo form_input('canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($display_catalogue['canonical'])) ? $display_catalogue['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off" data-flag="0" ');?>
												<?php echo form_hidden('original_canonical', htmlspecialchars_decode(html_entity_decode(set_value('canonical', (isset($display_catalogue['canonical'])) ? $display_catalogue['canonical'] : ''))), 'class="form-control canonical" placeholder="" autocomplete="off"');?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					</div>
					
				</div>
				<button type="submit" name="create" value="create" class="btn btn-primary block m-b pull-right">Lưu</button>
				
			</div>
			<div class="col-lg-4">
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>LỰA CHỌN DANH MỤC CHA</h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row mb10">
									<small class="text-danger">Chọn [Root] Nếu không có danh mục cha</small>
								</div>
								<div class="form-row">
									<?php echo form_dropdown('parentid', $dropdown, set_value('parentid', (isset($display_catalogue['parentid'])) ? $display_catalogue['parentid'] : ''), 'class="form-control m-b select2" data-module="display_catalogue"'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ibox mb20">
					<div class="ibox-title">
						<h5 class="choose-image" style="cursor: pointer;">Ảnh đại diện  </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="avatar" style="cursor: pointer;"><img src="<?php echo (isset($_POST['image'])) ? $_POST['image'] : ((isset($display_catalogue['image']) && $display_catalogue['image'] != '') ? $display_catalogue['image'] : 'public/not-found.png') ?>" class="img-thumbnail" alt=""></div>
									<?php echo form_input('image', htmlspecialchars_decode(html_entity_decode(set_value('image', (isset($display_catalogue['image'])) ? $display_catalogue['image'] : ''))), 'class="form-control " placeholder="Đường dẫn của ảnh"  id="imageTxt"  autocomplete="off" style="display:none;" ');?>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="ibox mb20">
					<div class="ibox-title">
						<h5>HIỂN THỊ </h5>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-row">
									<div class="text-warning mb15">Quản lý thiết lập hiển thị cho blog này.</div>
									<div class="block clearfix">
										<div class="i-checks mr30" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 1), ((isset($_POST['publish']) && $_POST['publish'] == 1 || (isset($display_catalogue['publish']) && $display_catalogue['publish'] == 1)) ? true : (!isset($_POST['publish'])) ? true : false),'class=""  id="publish"  style="margin-top:0;margin-right:10px;" '); ?>
												<label for="publish" style="margin:0;cursor:pointer;">Cho phép hiển thị trên website</label>
											</span>
										</div>
									</div>
									<div class="block clearfix">
										<div class="i-checks" style="width:100%;">
											<span style="color:#000;" class="uk-flex uk-flex-middle"> 
												<?php echo form_radio('publish', set_value('publish', 0), ((isset($_POST['publish']) && $_POST['publish'] == 0 || (isset($display_catalogue['publish']) && $display_catalogue['publish'] == 0)) ? true : false),'class=""   id="no-publish" style="margin-top:0;margin-right:10px;" '); ?>
												
												<label for="no-publish" style="margin:0;cursor:pointer;">Không Cho phép hiển thị trên website</label>
											</span>
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

