<nav class="navbar-default navbar-static-side" role="navigation">
    <?php  
        $user = authentication();
        $uri = service('uri');   
        $uri = current_url(true);
        $uriModule = $uri->getSegment(2);
    ?>
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="image" class="img-circle" src="<?php echo $user['image']; ?>" style="max-width:48px;height:48px;" />
                     </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="<?php echo site_url('profile') ?>">
                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $user['fullname'] ?></strong>
                     </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('backend/authentication/auth/logout') ?>">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
           <li class="landing_link">
                <a  href="<?php echo base_url('backend/dashboard/dashboard/index') ?>"><i class="fa fa-star"></i> <span class="nav-label">Dashboard</span> <span class="label label-warning pull-right">NEW</span></a>
            </li>
            <li class="<?php echo ( $uriModule == 'cash') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-money" aria-hidden="true"></i><span class="nav-label">QL Tiền mặt</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/cash/periodic/index') ?>">QL Kì</a></li>
                    <li><a href="<?php echo base_url('backend/cash/cash/index') ?>">QL Tiền mặt</a></li>
                    <li><a href="<?php echo base_url('backend/cash/catalogue/index') ?>">QL Nhóm tiền mặt</a></li>
                    <li><a href="<?php echo base_url('backend/cash/common/index') ?>">QL Thu chi mặc định</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'contract') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-diamond" aria-hidden="true"></i><span class="nav-label">QL Hợp Đồng</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/contract/hosting/index') ?>">QL Hợp đồng Hosting</a></li>
                    <li><a href="<?php echo base_url('backend/contract/domain/index') ?>">QL Hợp đồng Domain</a></li>
                     <li><a href="<?php echo base_url('backend/contract/website/index') ?>">QL Hợp đồng Website</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'service') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-cube"></i> <span class="nav-label">QL Dịch Vụ</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/service/vps/index') ?>">QL Thông Tin Vps</a></li>
                    <li><a href="<?php echo base_url('backend/service/hosting/index') ?>">QL Báo Gía Hosting</a></li>
                    <li><a href="<?php echo base_url('backend/service/domain/index') ?>">QL Báo Gía Domain</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'customer') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-user-o"></i> <span class="nav-label">QL Khách Hàng</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/customer/catalogue/index') ?>">QL Nhóm Khách Hàng</a></li>
                    <li><a href="<?php echo base_url('backend/customer/customer/index') ?>">QL Khách Hàng</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'user') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-user"></i> <span class="nav-label">QL Nhân Sự</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/user/catalogue/index') ?>">QL Phòng Ban</a></li>
                    <li><a href="<?php echo base_url('backend/user/user/index') ?>">QL Nhân sự</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'display') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-book"></i> <span class="nav-label">QL Kho giao diện</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/display/catalogue/index') ?>">QL Nhóm giao diện</a></li>
                    <li><a href="<?php echo base_url('backend/display/display/index') ?>">QL Giao diện</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'branch') ? 'active'  : '' ?>">
                <a href="<?php echo base_url('backend/branch/branch/index') ?>"><i class="fa fa-university" aria-hidden="true"></i><span class="nav-label">QL Chi nhánh</a>
            </li>
            <li class="<?php echo ( $uriModule == 'deadline') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="nav-label">QL Thời gian xử lý</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/deadline/catalogue/index') ?>">Nhóm thời gian xử lý</a></li>
                    <li><a href="<?php echo base_url('backend/deadline/deadline/index') ?>">Thời gian xử lý</a></li>
                </ul>
            </li>
            <li class="<?php echo ( $uriModule == 'problem') ? 'active'  : '' ?>">
                <a href="index.html"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="nav-label">QL Vấn đề</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url('backend/problem/catalogue/index') ?>">Nhóm vấn đề</a></li>
                    <li><a href="<?php echo base_url('backend/problem/problem/index') ?>">Vấn đề</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>