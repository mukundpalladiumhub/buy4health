<div class="content-wrapper">
    <section class="content-header">
        <h1>Profile<small>Form</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Profile</a></li>
            <li class="active">User Data</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-body">
                    <div class="col-md-10">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Profile Form</h3>
                            </div>
                            <form runat="server" class="form-horizontal" id="user_form" method="post" onsubmit="return false;" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Profile Picture</label>
                                        <div class="col-sm-4">
                                            <input type="file" id="image" name="image"/>
                                            <img src="http://placehold.it/100x100" id="image_show" alt="image" style="height: 100px; width: 100px;"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Full Name</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Full Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Mobile Number</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="mnum" name="mnum" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <label class="col-sm-2 control-label">Gender</label>
                                        <div class="col-sm-6">
                                            <input type="radio" id="male" value="1" name="gender"/>&nbsp;&nbsp;Male&nbsp;&nbsp;
                                            <input type="radio" id="female" value="0" name="gender"/>&nbsp;&nbsp;Female
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">City</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">State</label>
                                        <div class="col-sm-6">
                                            <select id="state" name="state" class="form-control">
                                                <option name="rajastan" id="rajastan" value="Rajastan">Rajastan</option>
                                                <option name="gujarat" id="gujarat" value="Gujarat">Gujarat</option>
                                                <option name="mumbai" id="mumbai" value="Mumbai">Mumbai</option>
                                                <option name="dehli" id="dehli" value="Dehli">Dehli</option>
                                                <option name="goa" id="goa" value="Goa">Goa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">User Name</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" id="username" name="username" placeholder="User Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Password</label>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-default">Cancel</button>
                                    <button type="submit"  id="submit" class="btn btn-info pull-right">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function () {
                            $.ajax({
                                url: '<?php echo base_url(); ?>index.php/new_form/profile_data',
                                data: '',
                                method: 'post',
                                success: function (data) {
                                    var result = JSON.parse(data);
                                    $("#fname").val(result.full_name);
                                    $("#mnum").val(result.mobile_no);
                                    $("input[name='gender'][value='" + result.gender + "']").prop('checked', true);
                                    $("#city").val(result.city);
                                    $("#state").val(result.state);
                                    $("#username").val(result.user_name);
                                    $("#password").val(result.password);
//                                    $("#img_id").val(result.profile_image);
                                    $("#image_show").attr("src", "<?php echo base_url(); ?>assets/images/" + result.profile_image);
                                }
                            })
                            $("#submit").on('click', function () {
                                var form = $("#user_form").serialize();
                                var fdata = new FormData($("#user_form")[0]);
                                $.ajax({
                                    url: '<?php echo base_url(); ?>index.php/new_form/save_profile',
                                    method: 'post',
                                    data: fdata,
                                    processData: false,
                                    contentType: false,
                                    success: function (data) {
                                        var result = JSON.parse(data);
                                        alert(result + ' subbmited');
                                        window.location.href = '<?php echo base_url(); ?>index.php/login_form/form';
                                    }
                                });
                            });
                        });
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#image_show').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                        $("#image").change(function () {
                            readURL(this);
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
</div>