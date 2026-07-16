<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Kì</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Kì</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý Kì </h5>
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
                                <div class="uk-search uk-flex uk-flex-middle mr10">
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
                            <th >Tiêu đề</th>
                            <th class="text-center" >Ngày bắt đầu</th>
                            <th class="text-center">Ngày kết thúc</th>
                            <th class="text-center" style="width: 150px">Tiền đầu kì</th>
                            <th class="text-center" style="width: 150px">Tiền cuối kì</th>
                            <th class="text-center">Ghi chú</th>
                            <th class="text-center" style="width:100px;">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <form class="object-form" action="" method="post">
                                <?php if(isset($periodicNewest) && is_array($periodicNewest) && count($periodicNewest)){ ?>
                                <?php 
                                    $date_start = strtotime($periodicNewest['date_end']);
                                    $date_start = date('d/m/Y',strtotime("+1 day", $date_start));
                                    $money_start= $periodicNewest['money_start'] - $periodicNewest['money_end'];
                                 ?>
                                <tr>
                                    <th style="width: 35px;">
                                        <input type="checkbox" id="checkbox-all">
                                        <label for="check-all" class="labelCheckAll"></label>
                                    </th>
                                    <th>
                                        <input type="text" name="title" class="form-control input-sm" placeholder="Nhập tiêu đề">
                                        <?php echo form_input('id', set_value('id', (isset($periodicNewest['id'])) ? $periodicNewest['id']  : ''), 'class="form-control input" placeholder="" autocomplete="off" id="id" style="display:none;"');?>
                                    </th>
                                    <th>
                                        <span class="date_start"><?php echo $date_start ?></span>
                                    </th>
                                    <th>
                                        <input type="text" name="date_end" class="form-control input-sm " data-mask="99/99/9999"  placeholder="ví dụ: 28/2/2020" autocomplete="off">
                                    </th>
                                    <th class="text-right">
                                        <span class="money_start">0 VNĐ</span>
                                    </th>
                                    <th class="text-right">
                                        <span class="money_end">0 VNĐ</span>
                                    </th>
                                    <th>
                                        <input type="text" name ="description" class="form-control input-sm" placeholder="Nhập ghi chú">
                                    </th>
                                    <th>
                                        <button class="btn btn-primary saveButton">Kết chuyển</button>
                                    </th>
                                </tr>
                                <?php }else{ ?>
                                <tr>
                                    <th style="width: 35px;">
                                        <input type="checkbox" id="checkbox-all">
                                        <label for="check-all" class="labelCheckAll"></label>
                                    </th>
                                    <th>
                                        <input type="text" name="title" class="form-control input-sm" placeholder="Nhập tiêu đề">
                                    </th>
                                    <th>
                                        <input type="text" name="date_start" class="form-control input-sm" data-mask="99/99/9999"  placeholder="ví dụ: 28/2/2020" autocomplete="off">
                                    </th>
                                    <th>
                                        <input type="text" name="date_end" class="form-control input-sm " data-mask="99/99/9999"  placeholder="ví dụ: 28/2/2020" autocomplete="off">
                                    </th>
                                    <th>
                                        <input type="text" name="money_start" class="int form-control input-sm text-center" placeholder="0"> 
                                    </th>
                                    <th class="text-center">
                                        <span class="money_end">0</span>
                                    </th>
                                    <th>
                                        <input type="text" name ="description" class="form-control input-sm" placeholder="Nhập ghi chú">
                                    </th>
                                    <th>
                                        <button class="btn btn-primary saveButton">Kết chuyển</button>
                                    </th>
                                </tr>
                                <?php } ?>
                            </form>
                            <?php if(isset($periodicList) && is_array($periodicList) && count($periodicList)){ ?>
                            <?php foreach($periodicList as $key => $val){ ?>
                                <tr>
                                    <th style="width: 35px;">
                                        <input type="checkbox" id="checkbox-all">
                                        <label for="check-all" class="labelCheckAll"></label>
                                    </th>
                                    <th class="text-success">
                                        <span><?php echo $val['title'] ?></span>
                                    </th>
                                    <th class="text-center text-success">
                                        <span><?php echo gettime($val['date_start'],'d/m/Y') ?></span>
                                    </th>
                                    <th class="text-center text-success">
                                        <span><?php echo gettime($val['date_end'],'d/m/Y') ?></span>
                                    </th>
                                    <th class="text-right text-success">
                                        <span><?php echo number_format($val['money_start'], 0, ',', '.') ?> VNĐ</span> 
                                    </th>
                                    <th class="text-right text-success">
                                         <span><?php echo number_format(get_money_end($val['id']), 0, ',', '.') ?> VNĐ</span>
                                    </th>
                                    <th>
                                        <span><?php echo $val['description'] ?></span>
                                    </th>
                                    <th>
                                        
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