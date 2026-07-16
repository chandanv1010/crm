<div class="ibox-content">
    <form action="" method="">
        <div class="toolbox mb20">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="col-lg-6">
                    <div class="perpage">
                        <div class="uk-flex uk-flex-middle">
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
                            <div class="mr10">
                                <?php $cash_catalogue = cash_catalogue();  ?>
                                <?php if(isset($cash_catalogue) && is_array($cash_catalogue) && count($cash_catalogue)){ ?>
                                <?php echo form_dropdown('catalogueid',$cash_catalogue, (isset($_GET['catalogueid']))? $_GET['catalogueid'] : '',' class="form-control input select2 mr10"') ?>
                                <?php } ?>
                            </div>
                            <div>
                                <?php 
                                    $branchList = get_data([
                                        'select' => 'id, title',
                                        'table'  => 'branch',
                                        'where' => ['publish' => 1, 'deleted_at' => 0],
                                        'order_by' => 'id desc'
                                    ]);  
                                    $branchList = convert_array([
                                        'data' => $branchList,
                                        'field' => 'id',
                                        'value' => 'title',
                                        'text' => 'chi nhánh',
                                    ]);
                                ?>
                                <?php if(isset($branchList) && is_array($branchList) && count($branchList)){ ?>
                                <?php echo form_dropdown('branchid',$branchList,(isset($_GET['branchid']))? $_GET['branchid'] : '',' class="form-control input select2 mr10"') ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-row ">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between">
                            <?php echo form_input('timeFrom', set_value('timeFrom',(isset($_GET['timeFrom']))? $_GET['timeFrom'] : ''), 'class="form-control input mr10" data-mask="99/99/9999" placeholder=" Từ ngày 28/2/2020" autocomplete="off"');?>
                            <span>-</span>
                            <?php echo form_input('timeTo', set_value('date_end',(isset($_GET['timeTo']))? $_GET['timeTo'] : ''), 'class="form-control input ml10" data-mask="99/99/9999" placeholder=" Đến ngày 28/3/2020" autocomplete="off"');?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="uk-search">
                        <div class="uk-flex uk-flex-middle uk-flex-right">
                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                            <span class="input-group-btn"> 
                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                            </button> 
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="total_money">
        <div class="uk-flex uk-flex-middle">
            <?php if(isset($total_money) && is_array($total_money) && count($total_money)){ ?>
            <div class="col-lg-3 text-bold">THU: 
                <span class="text-success"><?php echo number_format($total_money['all_collect'], 0, ',', '.') ?> VNĐ</span>
            </div>
            <div class="col-lg-3 text-bold">CHI: 
                <span class="text-danger"><?php echo number_format($total_money['all_pay'], 0, ',', '.') ?> VNĐ</span>
            </div>
            <?php } ?>
        </div>
    </div>
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
            <th>Ngày tháng</th>
            <th >Diễn giải</th>
            <th class="text-center" >Nhóm</th>
            <th class="text-right">Thu</th>
            <th class="text-right">Chi</th>
            <th class="text-center">Chi nhánh</th>
            <th class="text-right">Ghi chú</th>
            <th class="text-right">Người tạo</th>
            <th class="text-center" style="width:100px;">Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($object) && is_array($object) && count($object)){ ?>
        <?php foreach($object as $key => $val){ ?>
            <tr id='tr-<?php echo $val['id']?>' >
                <th style="width: 35px;">
                    <input type="checkbox" id="checkbox-all">
                    <label for="check-all" class="labelCheckAll"></label>
                </th>
                <th><?php echo $val['created_at'] ?></th>
                <th class="text-success">
                    <span><?php echo $val['title'] ?></span>
                </th>
                <th class="text-success">
                    <span><?php echo $val['catalogue_title'] ?></span>
                </th>
                <th class="text-center text-success">
                     <span><?php echo number_format($val['money_collect'], 0, ',', '.') ?> VNĐ</span> 
                </th>
                <th class="text-center text-danger">
                    <span><?php echo number_format($val['money_pay'], 0, ',', '.') ?> VNĐ</span> 
                </th>
                <th>
                    <?php echo $val['branch'] ?>
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