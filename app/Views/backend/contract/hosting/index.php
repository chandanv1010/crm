<?php
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý Hợp Đồng Hosting</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý Hợp Đồng Hosting</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5  style="margin-right: 10px;">Quản lý Hợp Đồng Hosting </h5>
                    <div class="total-rows ">
                        (Có tổng số <span class="text-danger"> <?php echo isset($total_rows) ? $total_rows : '' ?></span> bản ghi)
                    </div>
                    

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
                    <form class="form-search" action="" method="">
                        <div class="uk-flex uk-flex-middle uk-flex-space-between mb10">
                            <div class="perpage">
                                <div class="uk-flex uk-flex-middle mb10">
                                    <?php
                                        $perpage = [
                                            20 => '20 bản ghi',
                                            30 => '30 bản ghi',
                                            40 => '40 bản ghi',
                                            50 => '50 bản ghi',
                                            60 => '60 bản ghi',
                                        ];
                                        echo form_dropdown('perpage', $perpage, set_value('perpage', (isset($_GET['perpage']))? $_GET['perpage'] : 20), 'class="form-control input-sm perpage filter mr10" style="width: auto;"')
                                     ?>

                                    <?php
                                        $contract_end = [
                                            0 => 'Hợp đồng còn hạn',
                                            1 => 'Hợp đồng hết hạn',

                                        ];
                                        echo form_dropdown('contract_end', $contract_end, set_value('contract_end', (isset($_GET['contract_end']))? $_GET['contract_end'] : 0), 'class="form-control input-sm"')
                                     ?>
                                </div>
                            </div>
                            <div class="toolbox">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <div class="uk-search uk-flex uk-flex-middle mr10">
                                        <div class="input-group">
                                            <input type="text" name="keyword" value="<?php echo (isset($_GET['keyword'])) ? $_GET['keyword'] : ''; ?>" placeholder="Nhập Từ khóa bạn muốn tìm kiếm..." class="form-control">
                                            <span class="input-group-btn">
                                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm">Tìm Kiếm
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="uk-button">
                                        <a href="<?php echo base_url('backend/contract/hosting/create') ?>" class="btn btn-danger btn-sm open-window"><i class="fa fa-plus"></i> Thêm Hợp đồng Hosting Mới</a>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row box-advanced">
                            <div class="col-lg-2 mb20">
                            <?php
                                $staff = staff();
                                $staff = convert_array([
                                    'data' => $staff,
                                    'field' => 'id',
                                    'value' => 'fullname',
                                    'text' => 'người phụ trách',
                                ]);
                                echo form_dropdown('staff', $staff, set_value('staff', (isset($_GET['staff']))? $_GET['staff'] : 0), 'class="form-control input select2"')
                             ?>
                            </div>
                            <div class="col-lg-2 mb20">
                            <?php
                                $city = city();

                                echo form_dropdown('city', $city, set_value('city', (isset($_GET['city']))? $_GET['city'] : 0), 'class="form-control input select2"')
                             ?>
                            </div>
                            <div class="col-lg-4 mb20">
                                 <div class="form-row ">
                                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                        <?php echo form_input('timeFrom', set_value('timeFrom',(isset($_GET['timeFrom']))? $_GET['timeFrom'] : ''), 'class="form-control input" data-mask="99/99/9999" placeholder=" Từ ngày 28/2/2020" autocomplete="off"');?>
                                        <span>-</span>
                                    <?php echo form_input('timeTo', set_value('date_end',(isset($_GET['timeTo']))? $_GET['timeTo'] : ''), 'class="form-control input" data-mask="99/99/9999" placeholder=" Đến ngày 28/3/2020" autocomplete="off"');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <!-- <a href="" title ="Reset" class="form-reset lta-btn btn mr20"> reset</a> -->
                            <a href="" title ="Advanced" class="form-advanced m0 lta-btn">Tìm kiếm nâng cao</a>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example object-list table-hosting">
                        <thead>
                        <tr>
                            <th style="width: 35px;">
                                <input type="checkbox" id="checkbox-all">
                                <label for="check-all" class="labelCheckAll"></label>
                            </th>
                            <th>Thông tin khách hàng</th>
                            <th>Thông tin thanh toán</th>
                            <th>Thông tin hợp đồng</th>
                            <th>Thông tin khác</th>
                            <th>Thời gian</th>
                            <th>Người Tạo</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $process = getOPtion('process');
                            ?>
                            <?php if(isset($objectList) && is_array($objectList) && count($objectList)){ ?>
                            <?php foreach($objectList as $key => $val){ ?>
                            <tr id="post-<?php echo $val['id']; ?>" data-id="<?php echo $val['id']; ?>">
                                <td>
                                    <input type="checkbox" name="checkbox[]" value="<?php echo $val['id']; ?>" class="checkbox-item">
                                    <div for="" class="label-checkboxitem"></div>
                                </td>
                                <td style="color:blue;" >
                                    <div class="mb5"><span class="text">Name </span>: <span><?php echo $val['fullname'] ?></span></div>
                                    <div class="mb5"><span class="text">Phone</span> : <span><?php echo $val['phone'] ?></span></div>
                                </td>
                                <td style="color:blue;" class="show-infor">
                                    <div class="mb5"><span class="text">Giá Tiền:</span> <span><?php echo number_format($val['price'], 0, ',', '.') ?> Đ</span></div>
                                    <div class="mb5"><span class="text">Tổng Tiền:</span> <span class="text-navy"><?php echo number_format($val['total'], 0, ',', '.') ?> Đ</span></div>
                                </td>
                                <td style="color:blue;">
                                    <div class="mb5"><span class="text">TM:</span> <span><?php echo $val['domain'] ?></span></div>
                                    <div class="mb5"><span class="text">TG:</span> <span><?php echo $val['service'] ?></span></div>
                                </td>
                                <td style="color:blue;">
                                    <div class="mb5"><span class="text">IP:</span> <span><?php echo $val['ip_vps'] ?></span></div>
                                    <div class="mb5"><span class="text">PT:</span> <span><?php echo $val['staff'] ?></span></div>
                                </td>

                                <td style="color:blue;">
                                    <div class="mb5"><span class="text">SD </span>: <span><?php echo gettime($val['date_start'],'d/m/Y') ?></span></div>
                                    <div class="mb5"><span class="text">ED </span>: <span class ="<?php echo dayWarning($val['day'])?>
                                <?php echo(isset($_GET['contract_end']) && ($_GET['contract_end'] == 1))? 'warning-1' : ''; ?>"><?php echo gettime($val['date_end'],'d/m/Y') ?> <?php echo ($val['day'] < 0)?'('.$val['day'].')' : '' ?></span></div>
                                </td>
                                <td style="color:blue;">
                                    <div class="mb5"><span class="text">Người tạo </span>: <span><?php echo $val['creator'] ?></span></div>
                                    <div class="mb5"><span class="text">Ngày tạo </span>: <span><?php echo gettime($val['created_at'],'d/m/Y'); ?></span></div>
                                </td>
                                <td class="text-center">
                                    <ul class="uk-list lta-tool">
                                        <li>
                                            <a type="button" href="<?php echo base_url('backend/contract/hosting/update/'.$val['id']) ?>" class="open-window btn btn-primary " title="Sửa"><i class="fa fa-edit"></i></a>
                                        </li>
                                        <li>
                                            <a type="button" href="<?php echo base_url('backend/contract/hosting/extend/'.$val['id']) ?>" class="btn btn-success open-window"  title="Gia hạn"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                        </li>
                                         <li>
                                            <div class="ibox-tools">
                                                <a class="dropdown-toggle toggle-sm" data-toggle="dropdown" href="#" aria-expanded="true">
                                                   <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                               </a>
                                               <ul class="dropdown-menu dropdown-user">
                                                    <li>
                                                        <a type="button" href="<?php echo base_url('backend/contract/hosting/delete/'.$val['id']) ?>" class=" open-window" title="Xóa">Xóa</a>
                                                    </li>
                                                    <li>
                                                        <a type="button" href="<?php echo base_url('backend/contract/hosting/upgrade/'.$val['id']) ?>" class="open-window" title="Nâng cấp">Nâng cấp</a>
                                                    </li>
                                               </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
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
