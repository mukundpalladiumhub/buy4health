<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Profile
            <small>Change Password</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active">Change Password</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!--                <head>
                                    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
                                </head>-->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <div class="box-body">
                        <form id="user_pass" method="post" onsubmit="return false;" enctype="multipart/form-data">
                            <div class="form-group has-feedback">
                                <input type="text" id="old_pass" name="old_pass" class="form-control" data-validation="required" placeholder="Old Password" style="width: auto;">
                            </div><p id="msg"></p>
                            <div class="form-group has-feedback">
                                <input type="password" id="new_pass" name="password_confirmation" class="form-control" data-validation="length" data-validation-length="min3" placeholder="New Password"style="width: auto;">
                            </div>
                            <div class="form-group has-feedback">
                                <input type="password" id="cnfm_pass" name="password" class="form-control" data-validation="confirmation" placeholder="Conform Password"style="width: auto;">
                            </div><br>
                            <div class="row">
                                <div class="col-xs-2">
                                    <button type="submit" id="submit" name="submit" class="btn btn-primary btn-block btn-flat">Change</button>
                                </div>
                                <!--                                <div class="col-xs-2">
                                                                    <button type="button" id="cancel" name="cancel" class="btn btn-primary btn-block btn-flat">Cancel</button>
                                                                </div>-->
                            </div>
                        </form>
                        <script>
                            $(document).ready(function () {
                                $.validate({
                                    form: '#user_pass',
                                    modules: 'security',
                                    onSuccess: function ($form) {
                                        $("#submit").on('click', function () {
                                            var fdata = new FormData($("#user_pass")[0]);
                                            $.ajax({
                                                url: '<?php echo base_url(); ?>index.php/new_form/change_pass_id',
                                                method: 'post',
                                                data: fdata,
                                                processData: false,
                                                contentType: false,
                                                success: function (data) {
                                                    var result = JSON.parse(data);
                                                    if (result.status == 1) {
                                                        $("#msg").html(result.msg);
                                                        window.location.href = '<?php echo base_url(); ?>index.php/new_form/form';
                                                    } else {
                                                        $("#msg").html(result.msg);
                                                    }
                                                }
                                            });
                                        });
                                    },
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>