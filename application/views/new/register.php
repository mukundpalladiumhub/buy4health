<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>AdminLTE 2 | Registration Page</title>
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
                <p class="login-box-msg">Register a new membership</p>
                <form id="user_form" method="post" onsubmit="return false;" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id"/>
                    <input type="hidden" id="img_id" name="img_id" value=""/>
                    <div class="form-group has-feedback">
                        <b>Profile Picture</b>
                        <input type="file" id="image" name="image" placeholder="Profile Picture"/>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="fname" name="fname" class="form-control" data-validation="required" placeholder="Full name">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="mnum" name="mnum" class="form-control" data-validation="required" placeholder="Mobile Number">
                        <span class="glyphicon glyphicon-key form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="radio" id="male" value="1" name="gender"/> &nbsp;&nbsp; Male  &nbsp;&nbsp;&nbsp;
                        <input type="radio" id="female" value="0" name="gender"/> &nbsp;&nbsp; Female
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" id="city" name="city" class="form-control" placeholder="City">
                        <span class="glyphicon glyphicon-city form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <select id="state" name="state" placeholder="State" style="width: -moz-available;padding: 6px;text-align: -moz-center;">
                            <option value="Select State">State</option>
                            <option name="rajastan" id="rajastan" value="Rajastan">Rajastan</option>
                            <option name="gujarat" id="gujarat" value="Gujarat">Gujarat</option>
                            <option name="mumbai" id="mumbai" value="Mumbai">Mumbai</option>
                            <option name="dehli" id="dehli" value="Dehli">Dehli</option>
                            <option name="goa" id="goa" value="Goa">Goa</option>
                        </select>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="user_name" id="user_name" class="form-control" data-validation="required" placeholder="E-Mail id">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirmation" id="password" data-validation="length" data-validation-length="min3" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" id="repassword" data-validation="confirmation" class="form-control" placeholder="Retype password">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <a href="<?php echo base_url(); ?>index.php/login_form/form" class="text-center">I already have a membership</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                        </div>
                    </div>
                    <p id="msg"></p>
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
                            form: '#user_form',
                            modules: 'security',
                            onSuccess: function ($form) {
                                var fdata = new FormData($("#user_form")[0]);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php/login_form/save',
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
                                            alert("Please verify your email-id for login.")
                                            window.location.href = '<?php echo base_url(); ?>index.php/popup/form';
                                        }
                                    }
                                });
                            },
                        });
                    });
        </script>
    </body>
</html>
