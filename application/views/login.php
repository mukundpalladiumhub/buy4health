<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 2 | Log in</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>Admin</b>LTE</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form id="user_form" method="post" onsubmit="return false;" enctype="multipart/form-data" action="">
                    <div class="form-group has-feedback">
                        <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <!--<a href="<?php echo base_url(); ?>index.php/login_form/signup" class="text-center">Register a new membership</a>-->
                                </label>
                                <label>
                                    <a href="<?php echo base_url(); ?>login/forgot_password" class="text-center">Forgot Password</a>
                                </label>
                            </div>
                            <p id="msg"></p>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/assets/plugins/iCheck/icheck.min.js"></script>
        <script>
                    $(function () {
                        $('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue',
                            increaseArea: '20%' /* optional */
                        });
                    });
        </script>
        <script>
            $(document).ready(function () {
                $("#submit").on('click', function () {
                    var form = $("#user_form").serialize();
                    var fdata = new FormData($("#user_form")[0]);
                    $.ajax({
                        url: '<?php echo base_url(); ?>login/login_action',
                        method: 'post',
                        data: fdata,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (result.status == 1) {
                                $("#msg").html(result.msg);
                                window.location.href = '<?php echo base_url(); ?>user';
                            } else if (result.status == 1) {
                                $("#msg").html(result.msg);
                                
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>