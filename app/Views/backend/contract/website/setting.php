<div class="row wrapper border-bottom white-bg page-heading">
	<div class="uk-flex uk-flex-middle uk-flex-space-between">
	   	<div class="col-lg-8">
	      	<h2>Quản lý hiển thị</h2>
	      	<ol class="breadcrumb" style="margin-bottom:10px;">
	         	<li>
		            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Trang chủ</a>
	         	</li>
	         	<li class="active"><strong>Quản lý hiển thị</strong></li>
	      	</ol>
	   	</div>
	   	<div class="col-lg-4 clearfix">
	   		<button type="button" name="setting_action"  data-toggle="modal" data-target="#popup_store" class="btn btn-danger setting_action pull-right m0">Thêm mới</button>
	   	</div>
		
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
        	<div class="va-block-display">
        		<form action="" method="post" class="clearfix">
		        	<table class="table table-striped table-bordered table-hover table_display_function dataTables-example mb10">
		                <thead>
			                <tr>
			                    <th>Tiêu đề</th>
			                    <th class="text-center" style="width:200px;">Module</th>
                                <th class="text-center" style="width:88px;">Trạng thái</th>
		                        <th class="text-center" style="width:120px;">Thao tác</th>
			                </tr>
		                </thead>
		                <tbody>
		                	<?php 
		                		if(isset($system) && is_array($system) && count($system)){
		                			foreach ($system as $key => $value) {
                                        $data= base64_encode(json_encode($value));
		                	 ?>
			                	<tr id="post-<?php echo $value['id'] ?>">
				                    <th <?php echo ($value['level'] == 1) ? 'class="text-success text-bold"' : '' ?>>
	                                    <input type="text" name="id[]" value="<?php echo $value['id'] ?>" style="display: none;">
	                                    <input type="text" name="keyword[]" value="<?php echo $value['keyword'] ?>" style="display: none;">
                                        <?php echo str_repeat('|----', (($value['level'] > 0)?($value['level'] - 1):0)).$value['title']; ?> 
                                    </th>
				                    <th class="text-center"><?php echo $value['keyword'] ?></th>
			                        <th class="text-center" style="width:88px;">
                                        <div class="switch">
                                            <div class="onoffswitch" style="margin: auto;">
                                                <?php 
                                                    $set = 0;
                                                    if(isset($status['function']) && is_array($status['function']) && count($status['function'])){
                                                        foreach ($status['function'] as $keyStatus => $valueStatus) {
                                                            if($value['id'] == $valueStatus['id']) {
                                                                $set = $valueStatus['status'];
                                                            }
                                                        }
                                                    } 

                                                 ?>
                                                    <input type="checkbox" <?php echo ($set == 1) ? 'checked' : '' ?> class="onoffswitch-checkbox" id="status-<?php echo $value['id'] ?>" name="display[<?php echo $value['id'] ?>]" >
                                                <label class="onoffswitch-label" for="status-<?php echo $value['id'] ?>">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch" ></span>
                                                </label>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center">
                                        <button type="button" data-toggle="modal" data-target="#popup_store" data-display="<?php echo  $data ?>" class="btn setting_action btn-primary display_update m0"><i class="fa fa-edit"></i></button>
                                        <button type="button"  class="btn btn-danger display_delete" data-id="<?php echo $value['id']; ?>" data-display="<?php echo  $data ?>"><i class="fa fa-trash"></i></button>
                                    </th>
				                </tr>
			            	<?php }} ?>
		                </tbody>
		            </table>
        			<button type="submit" class="btn btn-success pull-right mt10">Lưu lại</button>
        		</form>
        	</div>
        </div>
    </div>
</div>

<div id="popup_store" class="modal fade va-general in" >  
      <div class="modal-dialog">  
           <div class="modal-content">  
                <div class="modal-header">
                    <div class="uk-flex uk-flex-space-between uk-flex-middle">
                        <h4 class="modal-title">Thêm mới Chức năng</h4>  
                        <button type="button" class="close" data-dismiss="modal">×</button>  
                    </div>  
                </div>  
                <div class="modal-body">  
                    <form method="post" id="insert_general" class="uk-clearfix" data-max-0="3">  
                        <div class="uk-grid uk-grid-width-large-1-2 uk-clearfix">
                            <input type="text" name="id" id="id" style="display: none;">
                            <div class="va-input-general mb10">
                                <label>Tiêu đề</label>  
                                <input type="text" name="title" id="title" value="" placeholder="Quản lý..." class="form-control va-uppercase">  
                            </div>
                            <div class="va-input-general mb10">
                                <label>Từ khóa <span class="text-danger">(module)</span></label>  
                                <input type="text" name="keyword" id="keyword" value="" placeholder="" class="form-control va-uppercase">  
                            </div>
                            <div class="select-parent mb10">
                            	<label> Chọn chức năng cha</label>
                            	<div class="select-parent-body">
                            		
                            	</div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" name="insert" id="insert" value="Lưu thay đổi" class="btn btn-success  float-right">  
                    </form>  
                </div>   
           </div>  
      </div>  
 </div>