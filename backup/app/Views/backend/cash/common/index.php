<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý thu chi mặc định</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý thu chi mặc định</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý thu chi mặc định </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb20">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <select name="perpage" class="form-control input-sm perpage filter mr10">
                                        <option value="20">20 bản ghi</option>
                                        <option value="30">30 bản ghi</option>
                                        <option value="40">40 bản ghi</option>
                                        <option value="50">50 bản ghi</option>
                                        <option value="60">60 bản ghi</option>
                                        <option value="70">70 bản ghi</option>
                                        <option value="80">80 bản ghi</option>
                                        <option value="90">90 bản ghi</option>
                                        <option value="100">100 bản ghi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-search uk-flex uk-flex-middle">
                                    <div class="input-group">
                                        <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                                        <span class="input-group-btn"> 
                                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                        </button> 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="box-body response-message">
                            <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                        </div><!-- /.box-body -->
                    </div>
                    <table class="table table-striped table-bordered table-hover dataTables-example object-list">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th >Diễn giải</th>
                            <th class="text-center" >Nhóm</th>
                            <th class="text-right">Thu</th>
                            <th class="text-right">Chi</th>
                            <th class="text-right">Ghi chú</th>
                            <th class="text-right">Người tạo</th>
                            <th class="text-center" style="width:100px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form class="object-form" action="" method="post">
                                    <th style="width: 35px;">
                                        <input type="checkbox" id="checkbox-all">
                                        <label for="check-all" class="labelCheckAll"></label>
                                    </th>
                                    <th>
                                        <input type="text" name="title" class="form-control input-sm" >
                                    </th>
                                    <?php $cash_catalogue = cash_catalogue();  ?>
                                    <th>
                                        <?php if(isset($cash_catalogue) && is_array($cash_catalogue) && count($cash_catalogue)){ ?>
                                        <?php echo form_dropdown('catalogueid',$cash_catalogue,'',' class="form-control input select2"') ?>
                                        <?php } ?>
                                    </th>
                                    <th>
                                        <input type="text" name="money_collect" class="form-control input-sm int text-center" >
                                    </th>
                                    <th>
                                        <input type="text" name="money_pay" class="int form-control input-sm text-center"> 
                                    </th>
                                    <th class="text-center">
                                        <input type="text" name="description" class="form-control input-sm" >
                                    </th>
                                    <th>
                                        
                                    </th>
                                    <th>
                                        <button class="btn btn-primary saveButton"><i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
                                    </th>
                                </form>
                            </tr>
                        <?php if(isset($commonList) && is_array($commonList) && count($commonList)){ ?>
                        <?php foreach($commonList as $key => $val){ ?>
                            <tr id='tr-<?php echo $val['id']?>' >
                                <th style="width: 35px;">
                                    <input type="checkbox" id="checkbox-all">
                                    <label for="check-all" class="labelCheckAll"></label>
                                </th>
                                <th class="text-success">
                                    <span><?php echo $val['title'] ?></span>
                                </th>
                                <th class="text-success">
                                    <span><?php echo $val['catalogue_title'] ?></span>
                                </th>
                                <th class="text-center text-success">
                                     <span>
                                        <?php echo ($val['money_collect'] != 0)?'+':'' ?>
                                        <?php echo number_format($val['money_collect'], 0, ',', '.') ?> VNĐ
                                    </span> 
                                </th>
                                <th class="text-center <?php echo ($val['money_pay'] != 0)?'text-danger':'text-success' ?>">
                                    <span>
                                        <?php echo ($val['money_pay'] != 0)?'-':'' ?>
                                        <?php echo number_format($val['money_pay'], 0, ',', '.') ?> VNĐ
                                    </span> 
                                </th>
                                <th>
                                    <span><?php echo $val['description'] ?></span>
                                </th>
                                <th>
                                    <span><?php echo $val['creator'] ?></span>
                                </th>
                                <th>
                                    <a type="button" href="<?php echo $val['id']?>" class="lta-edit btn btn-primary" title="Sửa"><i class="fa fa-edit"></i></a>
                                    <a type="button" href="<?php echo $val['id'] ?>" class="lta-delete btn btn-danger" title="Xóa"><i class="fa fa-trash"></i></a>
                                </th>
                            </tr>
                        <?php }}else{ ?>
                            <tr>
                                <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div id="pagination">
                        <?php echo (isset($pagination)) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>