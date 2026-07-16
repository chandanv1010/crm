<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php echo BASE_URL; ?>">
    <title>LOGIN | HT VIET NAM SYSTEM V3.0</title>

    <link href="<?php echo ASSET_BACKEND; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo ASSET_BACKEND; ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>css/style.css" rel="stylesheet">
    <link href="<?php echo ASSET_BACKEND; ?>css/customize.css" rel="stylesheet">
    
</head>

<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">Welcome to IN+</h2>

                <p>
                    Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                </p>

                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
                </p>

                <p>
                    When an unknown printer took a galley of type and scrambled it to make a type specimen book.
                </p>

                <p>
                    <small>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</small>
                </p>

            </div>
            <div class="col-md-6">
                <div class="ibox-content">

                    <?php echo  (!empty($validate) && isset($validate)) ? '<div class="alert alert-danger">'.$validate.'</div>'  : '' ?>
                    
                    <form class="m-t" method="post" action="">
                        <div class="form-group">
                            <input type="email" required name="email" value="<?php echo set_value('email') ?>" class="form-control" placeholder="Nhập vào email của bạn">
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">Nhận mã OTP</button>

                        <a href="<?php echo base_url(BACKEND_DIRECTORY); ?>">
                            <small>Đăng nhập?</small>
                        </a>
                    </form>
                    <p class="m-t">
                        <small>HT VietNam Copyright <?php echo date('Y'); ?></small>
                    </p>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                Copyright Example Company
            </div>
            <div class="col-md-6 text-right">
               <small>© 2014-2015</small>
            </div>
        </div>
    </div>

</body>

</html>
