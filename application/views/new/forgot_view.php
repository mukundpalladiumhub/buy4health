<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 2</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bower_components/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/plugins/iCheck/square/blue.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <b>Admin</b>LTE
            </div>
            <div class="register-box-body">
                <p class="login-box-msg">Forgot Password</p>
                <form id="forgot_form" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    <!--<input type="hidden" id="id" name="id"/>-->
                    <div class="form-group has-feedback">
                        <input type="text" name="user_name" id="user_name" class="form-control" data-validation="required" placeholder="E-Mail id">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-5">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary btn-block btn-flat">Verify email-id</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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

                    $(document).ready(function () {
                        $.validate({
                            form: '#forgot_form',
                            modules: 'security',
                            onSuccess: function ($form) {
                                var fdata = new FormData($("#forgot_form")[0]);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php/login_form/check_id',
                                    method: 'post',
                                    data: fdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (data) {
                                        var result = JSON.parse(data);
                                        if (result.status == 0) {
                                            $("#msg").html(result.msg);
                                        }
                                        else {
                                            alert('verify  Email-id');
                                            window.location.href = '<?php echo base_url(); ?>index.php/login_form/form';
                                        }
                                    }
                                });
                            },
                        });
                    });
        </script>
    </body>
</html>
