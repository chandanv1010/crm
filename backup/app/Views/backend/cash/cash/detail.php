<div class="ibox-content">
    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <a href="<?php echo base_url('backend/cash/catalogue/create') ?>" title="Thêm nhóm tiền mặt" class="btn btn-primary mb20 btn-sm open-window">Thêm nhóm tiền mặt</a>
        <form action="" method="">
            <div class="toolbox mb20">
                <div class="uk-search">
                    <div class="uk-flex uk-flex-middle uk-flex-right">
                        <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control"> 
                        <?php echo form_hidden('day', set_value('day',(isset($day)? strtotime($day): '')),'class="form-control input " id="day"' ) ?>
                        <span class="input-group-btn"> 
                            <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                        </button> 
                        </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="box-body response-message">
            <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
        </div><!-- /.box-body -->
    </div>
    <table class="table table-striped table-bordered table-hover dataTables-example object-list table-money">
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
            <tr>
                <form class="object-form" action="" method="post">
                    <th style="width: 35px;">
                        <input type="checkbox" id="checkbox-all">
                        <label for="check-all" class="labelCheckAll"></label>
                    </th>
                    <th>
                    	<?php echo $day ?>
                    	<?php echo form_input('created_at', set_value('created_at', (isset($day)) ? $day  : 0), 'class="form-control input" placeholder="" autocomplete="off" id="created_at" style="display:none;"');?>
                    	<?php echo form_input('periodicid', set_value('periodicid', (isset($periodicid)) ? $periodicid  : 0), 'class="form-control input" placeholder="" autocomplete="off" id="created_at" style="display:none;"');?>
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
                    <th>
                        <?php if(isset($branchList) && is_array($branchList) && count($branchList)){ ?>
                        <?php echo form_dropdown('branchid',$branchList,'',' class="form-control input select2"') ?>
                        <?php } ?>
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
        <?php if(isset($object) && is_array($object) && count($object)){ ?>
        <?php foreach($object as $key => $val){ ?>
            <tr id='tr-<?php echo $val['id']?>' >
                <th style="width: 35px;">
                    <input type="checkbox" id="checkbox-all">
                    <label for="check-all" class="labelCheckAll"></label>
                </th>
                <th><?php echo $day ?></th>
                <th class="text-success">
                    <span><?php echo $val['title'] ?></span>
                </th>
                <th class="text-success">
                    <span><?php echo $val['catalogue_title'] ?></span>
                </th>
                <th class="text-center text-success">
                     <span>
                         <?php echo ($val['money_collect'] != 0)? '+': '' ?>
                         <?php echo number_format($val['money_collect'], 0, ',', '.') ?> VNĐ
                     </span> 
                </th>
                <th class="text-center <?php echo ($val['money_pay'] != 0)? 'text-danger': 'text-success' ?>">
                    <span><?php echo ($val['money_pay'] != 0)? '-': '' ?>
                    <?php echo number_format($val['money_pay'], 0, ',', '.') ?> VNĐ</span> 
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
</div>