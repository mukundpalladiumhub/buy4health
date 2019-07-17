<div class="content-wrapper">
    <section class="content-header">
        <h1>Data Tables<small>advanced tables</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Data tables</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Hover Data Table</h3>
                    </div>
                    <div class="box-body">
                        <div class="full table">
                            <style>
                                th,td,table{
                                    border: 1px solid #01b2d2;
                                    padding: 5px;
                                }
                                image{
                                    height: 30px;
                                    width: 30px;
                                }
                                .modal-body{
                                    background-color: papayawhip;
                                    border: 2px solid skyblue;
                                    text-align: center;
                                    padding: 20px 0 20px 0;
                                    margin: 10px;
                                }
                                .has-error{
                                    border: 1px solid red; 
                                }
                            </style>
                            <div class="div_form" style="float: left">
                                <input type="button" class="formopen" value="Open Form" data-target='#div_form' data-toggle='modal' style="background-color: darkgrey;width: 300px;padding: 10px;border: 1px solid black;" >
                                <div id="div_form" class="modal">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss='modal' >&times;</button>
                                            </div>
                                            <form id="user_form" method="post" onsubmit="return false;" enctype="multipart/form-data">
                                                <div class="modal-body">                                                
                                                    <input type="hidden" id="id" name="id"/>
                                                    <input type="hidden" id="img_id" name="img_id" value=""/>
                                                    <b>Upload File</b><br/>
                                                    <input type="file" id="image" name="image"/><br/>
                                                    <b>Full Name</b><br/>
                                                    <input type="text" id="fname" name="fname" data-validation="required"/>
                                                    <p id="e_name"></p>
                                                    <b>Mobile Number</b><br/>
                                                    <input type="text" id="mnum" name="mnum" data-validation="required"/>
                                                    <p id="e_number"></p>
                                                    <b>Gender</b><br/>
                                                    <input type="radio" id="male" value="1" name="gender"/>Male
                                                    <input type="radio" id="female" value="0" name="gender"/>Female<br/>
                                                    <b>City</b><br/>
                                                    <input type="text" id="city" name="city" data-validation="required"/><br/>
                                                    <b>State</b><br/>
                                                    <select id="state" name="state">
                                                        <option name="rajastan" id="rajastan" value="Rajastan">Rajastan</option>
                                                        <option name="gujarat" id="gujarat" value="Gujarat">Gujarat</option>
                                                        <option name="mumbai" id="mumbai" value="Mumbai">Mumbai</option>
                                                        <option name="dehli" id="dehli" value="Dehli">Dehli</option>
                                                        <option name="goa" id="goa" value="Goa">Goa</option>
                                                    </select><br/>
                                                    <b>User Name</b><br/>
                                                    <input type="text" name="user_name" id="user_name" data-validation="required"/>
                                                    <p id="e_user"></p>
                                                    <b>Password</b><br/>
                                                    <input type="text" name="password" id="password" data-validation="length" data-validation-length="min3"/>
                                                    <p id="e_password"></p>
                                                    <p id="msg"></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="submit" id="submit" name="submit"/>
                                                    <input type="button" id="refresh" name="refresh" value="Refresh Table"/><br/><br/>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="div_table" style="width: 90%">
                                <br><br><br><br>
                                <table id="user_table" style="width: 1050px;">
                                    <thead>
                                        <tr>
                                            <th>Profile Photo</th>
                                            <th>Full Name</th>
                                            <th>Mobile Number</th>
                                            <th>Gender</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>User Name</th>
                                            <th>Password</th>                                            
                                            <th>Button</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $("#submit").on('click', function () {
                                    var name = $('#fname').val();
                                    var number = $('#mnum').val();
                                    var user = $('#user_name').val();
                                    var pass = $('#password').val();
                                    var error = 0;
                                    if (name == '') {
                                        $('#e_name').html('Name can not be empty');
                                        $('#fname').addClass('has-error');
                                        error++;
                                    } else {
                                        $("#e_name").html('');
                                        $("#fname").removeClass('has-error');
                                    }
                                    if (number == '') {
                                        $('#e_number').html('Number can not be empty');
                                        $('#mnum').addClass('has-error');
                                        error++;
                                    } else {
                                        $("#e_number").html('');
                                        $("#mnum").removeClass('has-error');
                                    }
                                    if (user == '') {
                                        $('#e_user').html('User name can not be empty');
                                        $('#user_name').addClass('has-error');
                                        error++;
                                    } else {
                                        $("#e_user").html('');
                                        $("#user_name").removeClass('has-error');
                                    }
                                    if ((pass.length) < 2) {
                                        error++;
                                        $("#e_password").html('Password shoud be more than 3 words');
                                        $('#password').addClass('has-error');
                                    } else if (pass == '') {
                                        error++;
                                        $('#e_password').html('Password can not be empty');
                                        $('#password').addClass('has-error');
                                    }
                                    else {
                                        $("#e_password").html('');
                                        $("#password").removeClass('has-error');
                                    }
                                    if (error == 0) {
                                        var fdata = new FormData($("#user_form")[0]);
                                        $.ajax({
                                            url: '<?php echo base_url(); ?>index.php/popup/save',
                                            method: 'post',
                                            data: fdata,
                                            processData: false,
                                            contentType: false,
                                            success: function (data) {
//                                                var result = JSON.parse(data);
                                                alert('subbmited');
                                                $("#user_form")[0].reset();
                                                showtable();
                                            }
                                        });
                                    }
                                });
//                                $.validate({
//                                    form: '#user_form',
//                                    modules: 'security',
//                                    onSuccess: function ($form) {
//                                        var fdata = new FormData($("#user_form")[0]);
//                                        $.ajax({
//                                            url: '<?php echo base_url(); ?>index.php/login_form/save',
//                                            method: 'post',
//                                            data: fdata,
//                                            processData: false,
//                                            contentType: false,
//                                            success: function (data) {
////                                                var result = JSON.parse(data);
//                                                alert('subbmited');
////                                                $('#div_form').on('hidden.bs.modal', function () {
//                                                    $("#div_form").empty();
////                                                });
//                                                showtable();
//                                            }
//                                        });
//                                    },
//                                });

                                showtable();
                                $('#div_form').on('hidden.bs.modal', function () {
                                    $("#user_form")[0].reset();
                                });

                                $('body').on('click', '#refresh', function () {
                                    showtable();
                                });

                                $('body').on('click', '.edit', function () {
                                    var id = $(this).data('id');
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/popup/edit',
                                        data: {id: id},
                                        method: 'post',
                                        success: function (data) {
                                            var result = JSON.parse(data);
                                            $("#id").val(result.id);
                                            $("#fname").val(result.full_name);
                                            $("#mnum").val(result.mobile_no);
                                            $("input[name='gender'][value='" + result.gender + "']").prop('checked', true);
                                            $("#city").val(result.city);
                                            $("#state").val(result.state);
                                            $("#user_name").val(result.user_name);
                                            $("#password").val(result.password);
                                            $("#img_id").val(result.profile_image);
                                        }
                                    })
                                })

                                $('body').on('click', '.delete', function () {
                                    var id = $(this).data("id");
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/popup/delete',
                                        data: {id: id},
                                        method: 'post',
                                        success: function (data) {
                                            var result = JSON.parse(data);
                                            alert(result + " is deleted");
                                            showtable();
                                        }
                                    })
                                })
                            });

                            function showtable() {
                                $("#user_table").DataTable({
                                    "processing": true,
                                    "serverSide": true,
                                    "paging": true,
                                    "searching": true,
                                    "order": [],
                                    "pageLength": 10,
                                    "destroy": true,
                                    "processData": false,
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>index.php/popup/showtable',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'profile_image'},
                                        {'data': 'full_name'},
                                        {'data': 'mobile_no'},
                                        {'data': 'gender'},
                                        {'data': 'city'},
                                        {'data': 'state'},
                                        {'data': 'user_name'},
                                        {'data': 'password'},
                                        {'data': 'action'},
                                    ]
                                });
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>