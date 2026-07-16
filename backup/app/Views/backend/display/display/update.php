<?php
    $baseController = new App\Controllers\BaseController();
    $language = $baseController->currentLanguage();
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Cập nhật Giao diện</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url('admin'); ?>">Trang chủ</a>
			</li>
			<li class="active"><strong>Cập nhật Giao diện</strong></li>
		</ol>
	</div>
</div>
<?php echo view('backend/display/display/store',  ['method' => $method]) ?>
