<?php  
    helper('form');
?>
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-8">
      <h2>Quản Lý tiền mặt</h2>
      <ol class="breadcrumb" style="margin-bottom:10px;">
         <li>
            <a href="<?php echo base_url('backend/dashboard/dashboard/index') ?>">Home</a>
         </li>
         <li class="active"><strong>Quản lý tiền mặt</strong></li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Quản lý tiền mặt </h5>
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
                            <?php $periodicList = cash_periodic(); ?>
                            <div class="uk-flex uk-flex-middle">
                                <div class="perpage mr20">
                                    <?php echo form_dropdown('periodicid', $periodicList,(isset($_GET['periodicid']))? $_GET['periodicid']: '','class="form-control input select2"') ?>
                                </div>
                                <button type="submit" name="search" value="search" class="btn btn-primary mb0 btn-sm ml20">Tìm Kiếm
                                </button>
                            </div>
                             <div class=""> 
                                <a href="<?php echo base_url('backend/cash/cash/search') ?>" class="btn btn-primary mb0 btn-sm open-window" title="tìm kiếm nâng cao">Tìm Kiếm nâng cao
                                </a> 
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered table-hover dataTables-example object-list table-money">
                        <?php if(isset($periodic) && is_array($periodic) && count($periodic)){ ?>
                        <thead>
                        <?php
                            $money_month = get_money_month($periodic['id']);
                            // pre($money_month);
                            $object = get_money_day($periodic['id']);
                            $time_start  =  strtotime($periodic['date_start']);
                            $time_end  =  strtotime($periodic['date_end']);
                            $money_save = $periodic['money_start'] + $money_month['exist'];
                        ?>
                            <tr>
                                <th style="width: 35px;">
                                    <input type="checkbox" id="checkbox-all">
                                    <label for="check-all" class="labelCheckAll"></label>
                                </th>
                                <th >Ngày tháng</th>
                                <th class="text-right">Thu</th>
                                <th class="text-right">Chi</th>
                                <th class="text-right">Tồn</th>
                                <th class="text-center" style="width:103px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($money_month) && is_array($money_month) && count($money_month)){ ?>
                            <tr class="bg-active">
                                <td></td>
                                <td class="text-bold text-success">Tồn đầu kì: <?php echo number_format($periodic['money_start'], 0, ',', '.'); ?> VNĐ</td>
                                <td class="text-right text-success"> + <?php echo (isset($money_month['all_collect']))? number_format($money_month['all_collect'], 0, ',', '.') : '0' ?> VNĐ</td>
                                <td class="text-right text-danger"> - <?php echo (isset($money_month['all_pay']))? number_format($money_month['all_pay'], 0, ',', '.') : '0' ?> VNĐ</td>
                                <td class="text-right <?php echo ($money_save < 0)?'text-danger' : 'text-success'?>"><?php echo number_format($money_save, 0, ',', '.'); ?> VNĐ</td>
                                <td></td>
                            </tr>
                            <?php } ?>
                            <?php while($time_end  >= $time_start) { ?>
                            <?php 
                                $day = date("d/m/Y",$time_end);
                            ?>
                            <tr>
                                <th style="width: 35px;">
                                    <input type="checkbox" id="checkbox-all">
                                    <label for="check-all" class="labelCheckAll"></label>
                                </th>
                                <td class="text-success"><?php echo $day ?></td>
                                <td class="text-right text-success"><?php echo (isset($object[$day]['all_collect']))? '+ '.number_format($object[$day]['all_collect'], 0, ',', '.') : '0' ?> VNĐ</td>
                                <td class="text-right text-danger"><?php echo (isset($object[$day]['all_pay']))? '- '.number_format($object[$day]['all_pay'], 0, ',', '.') : '0' ?> VNĐ</td>
                                <td class="text-right <?php echo (isset($object[$day]['exist']) && ($object[$day]['exist'] < 0))?'text-danger' : 'text-success'?>">
                                    <?php echo (isset($object[$day]['exist']) && ($object[$day]['exist'] > 0))? '+ ' : ''?>
                                    <?php echo (isset($object[$day]['exist']))? number_format($object[$day]['exist'], 0, ',', '.') : '0' ?> VNĐ
                                        
                                </td>
                                <td>
                                    <a data-date = "<?php echo $day ?>" href="<?php echo base_url('backend/cash/cash/detail?day='.$time_end.'&id='.$periodic['id'] ) ?>" class="btn-detail btn btn-primary open-window"><i class="fa fa-edit"></i> Chi tiết</a>
                                </td>
                            </tr>
                            <?php
                                $time_end = strtotime("-1 day",$time_end); 
                            }}else{ 
                            ?>
                                <tr>
                                    <td colspan="100%"><span class="text-danger">Không có dữ liệu phù hợp...</span></td>
                                </tr>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>