<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Hover Data Table</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!--<table id="example2" class="table table-bordered table-hover">-->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
                        <link href="<?php echo base_url(); ?>assets/css/data_form.css" type="text/css" rel="stylesheet"/>
                        <div class="container">
                            <button type="button" class="c_reg" data-toggle="modal" data-target="#i_form">Click For Registration</button>
                            <div class="modal fade" id="i_form" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header c_header">
                                            <button type="button" class="c_close" data-dismiss="modal" style="float: right;">&times</button>
                                            <h1>Sign Up</h1>
                                        </div>
                                        <div class="modal-body c_body" style="text-align: center;">
                                            <form class="c_form-content" action="" id="i_forms" method="POST" onsubmit="return false" enctype="multipart/form-data">
                                                <input type="hidden" id="i_id" name="n_id" value=""/>
                                                <input type="hidden" id="i_imghiden" name="n_imghiden" value="" src="upload/8.png"/>
                                                <b>Profile Photo</b><br>
                                                <input type="file" id="i_img" name="n_img" class="c_img" onChange="readURL(this);" />
                                                <div id="targetOuter">
                                                    <div id="image_priview">
                                                        <img class="abcd"/>
                                                    </div>
                                                </div>
                                                <br><b>Full Name</b><br>
                                                <input type="text" id="i_name" name="n_name"/>
                                                <br><b>Number</b><br>
                                                <input type="text" id="i_num" name="n_num"/>
                                                <br><b>Gender</b><br>
                                                <input type="radio" id="i_male" name="n_radio" value="Male">Male
                                                <input type="radio" id="i_female" name="n_radio" value="Female">Female<br>
                                                <b>City</b><br>
                                                <input type="text" id="i_city" name="n_city"/>
                                                <br><b>State</b><br>
                                                <input type="text" id="i_state" name="n_state"/>
                                                <br><b>Country</b><br>
                                                <select id="i_country" class="c_country" name="n_country">
                                                    <option value="India">India</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="U.K.">U.K.</option>
                                                    <option value="U.S.A.">U.S.A.</option>
                                                </select>
                                            </form>
                                        </div>
                                        <div class="modal-footer c_footer">
                                            <button type="button" class="c_cancel" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="c_submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover" id="i_table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Gender</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Button</th>
                                </tr>
                            </thead>
                        </table>
                        <script>
                            $(document).ready(function () {
                                $('#i_form').on('hidden.bs.modal', function () {
                                    $('#i_forms')[0].reset();
                                });
                                var table = jQuery('#i_table').DataTable({
                                    paging: true,
                                    pageLength: 10,
                                    bDestroy: true,
                                    responsive: true,
                                    processing: true,
                                    serverSide: true,
                                    "order": [],
                                    ajax: {
                                        url: "<?php echo base_url(); ?>index.php/hello_world/view",
                                        type: 'POST',
                                    },
                                    columns: [
                                        {data: 's_img'},
                                        {data: 's_name'},
                                        {data: 's_mobile'},
                                        {data: 's_gender'},
                                        {data: 's_city'},
                                        {data: 's_state'},
                                        {data: 's_country'},
                                        {data: 'action', name: 'action', orderable: false, searchable: false}
                                    ],
                                });

                                $('body').on('click', '.edit', function () {
                                    var id = $(this).data('id');
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/hello_world/edit',
                                        method: 'POST',
                                        data: {'id': id},
                                        success: function (data) {
                                            var result = $.parseJSON(data);
                                            if (result.status == 1) {
                                                console.log(result.content);
                                                $('#i_id').val(result.content.s_id);
                                                $('#i_name').val(result.content.s_name);
                                                $('#i_num').val(result.content.s_mobile);
                                                if (result.content.s_gender == 'Male') {
                                                    $("input[name = n_radio][value = Male]").prop('checked', true);
                                                }
                                                else if (result.content.s_gender == 'Female') {
                                                    $("input[name = n_radio][value = Female]").prop('checked', true);
                                                }
                                                $('#i_city').val(result.content.s_city);
                                                $('#i_state').val(result.content.s_state);
                                                $('#i_country').val(result.content.s_country);
//                                                $('#i_img').val(result.content.s_img);
                                                $('.abcd').attr("src", '<?php echo base_url(); ?>/assets/images/' + result.content.s_img);
                                            }
                                        }
                                    })
                                })

                                $('body').on('click', '.delete', function () {
                                    var id = $(this).data('id');
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/hello_world/delete',
                                        method: 'POST',
                                        data: {'id': id},
                                        success: function () {
                                            table.ajax.reload();
                                        }
                                    })
                                })

                                $('body').on('click', '.c_submit', function () {
                                    var form = $("#i_forms");
                                    var f_data = new FormData(form[0]);
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>index.php/hello_world/save',
                                        method: 'POST',
                                        data: f_data,
                                        contentType: false,
                                        processData: false,
                                        success: function (data) {
                                            $('#i_forms')[0].reset();
                                            table.ajax.reload();
                                        }
                                    })
                                })

                            });
                            function readURL(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        $("#image_priview").html('<img src="' + e.target.result + '" width="200px" height="200px" class="upload-preview" />');
                                    }
                                    reader.readAsDataURL(input.files[0]);
                                }
                            }
                        </script>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>