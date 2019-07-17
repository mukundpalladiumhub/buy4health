<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Data Tables
            <small>advanced tables</small>
        </h1>
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
                                #user_form{
                                    background-color: papayawhip;
                                    border: 2px solid skyblue;
                                    text-align: center;
                                    padding: 20px 0 20px 0;
                                }
                            </style>
                            <div class="div_form" style="float: left">
                                <form id="user_form" method="post" onsubmit="return false;" enctype="multipart/form-data">
                                    <input type="hidden" id="id" name="id"/>
                                    <input type="hidden" id="img_id" name="img_id" value=""/>
                                    <b>Upload File</b><br/>
                                    <input type="file" id="image" name="image"/><br/><br/>
                                    <b>Full Name</b><br/>
                                    <input type="text" id="fname" name="fname"/><br/><br/>
                                    <b>Mobile Number</b><br/>
                                    <input type="text" id="mnum" name="mnum"/><br/><br/>
                                    <b>Gender</b><br/>
                                    <input type="radio" id="male" value="1" name="gender"/>Male
                                    <input type="radio" id="female" value="0" name="gender"/>Female<br/><br/>
                                    <b>City</b><br/>
                                    <input type="text" id="city" name="city"/><br/><br/>
                                    <b>State</b><br/>
                                    <select id="state" name="state">
                                        <option name="rajastan" id="rajastan" value="Rajastan">Rajastan</option>
                                        <option name="gujarat" id="gujarat" value="Gujarat">Gujarat</option>
                                        <option name="mumbai" id="mumbai" value="Mumbai">Mumbai</option>
                                        <option name="dehli" id="dehli" value="Dehli">Dehli</option>
                                        <option name="goa" id="goa" value="Goa">Goa</option>
                                    </select><br/><br/>
                                    <input type="submit" id="submit" name="submit"/>
                                    <input type="button" id="refresh" name="refresh" value="Refresh Table"/><br/><br/>
                                </form>
                            </div>
                            <div class="div_table" style="float: right;">
                                <table id="user_table" style="width: 1050px;">
                                    <thead>
                                        <tr>
                                            <th>Profile Photo</th>
                                            <th>Full Name</th>
                                            <th>Mobile Number</th>
                                            <th>Gender</th>
                                            <th>City</th>
                                            <th>State</th>
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
                                showtable();
                                $("#submit").on('click', function () {
//                                    var form = $("#user_form").serialize();
                                    var fdata = new FormData($("#user_form")[0]);
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/new_form/save',
                                        method: 'post',
                                        data: fdata,
                                        processData: false,
                                        contentType: false,
                                        success: function (data) {
                                            var result = JSON.parse(data);
                                            alert(result + ' subbmited');
                                            showtable();
                                        }
                                    });
                                });
                                $('body').on('click', '#refresh', function () {
                                    showtable();
                                });
                                $('body').on('click', '.edit', function () {
                                    var id = $(this).data('id');
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/new_form/edit',
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
                                            $("#img_id").val(result.profile_image);
                                        }
                                    })
                                })
                                $('body').on('click', '.delete', function () {
                                    var id = $(this).data("id");
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/new_form/delete',
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
                                        "url": '<?php echo base_url(); ?>index.php/new_form/showtable',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'profile_image'},
                                        {'data': 'full_name'},
                                        {'data': 'mobile_no'},
                                        {'data': 'gender'},
                                        {'data': 'city'},
                                        {'data': 'state'},
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