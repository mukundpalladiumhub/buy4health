<div class="content-wrapper">
    <section class="content-header">
        <h1>Order List</h1>
        <!--        <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Order tables</li>
                </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order List</h3>
                        <p style="text-align: center;" id="status_msg"></p>
                    </div>
                    <div class="box-body">
                        <div>
                            <form method="post" id="status_form" onsubmit="return false">
                                <div id="change_modal" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <input type="hidden" name="id" id="id">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Change Order Status</h4>
                                            </div>
                                                <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-1"></div>
                                                <label class="col-sm-3">Order Status</label>
                                                <div class="col-sm-7 form-group">
                                                    <select id="order_status" name="order_status" class="form-control">
                                                        <?php
                                                        if (!empty($order_status)) {
                                                            foreach ($order_status as $order) { ?>
                                                                <option value="<?php echo $order['status_id']; ?>"><?php echo $order['status_name']; ?></option>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-1"></div>
                                            </div>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal" id="save_status">Save</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="order_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Order Number</th>
                                        <th>Order Total</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <script>
                            $(document).ready(function () {
                                showtable();
                                $('body').on('click', '.edit_status', function () {
                                    var id = $(this).data('id');
                                    var order_id = $(this).data('order_id');
                                    $("#order_status").val(id);
                                    $("#id").val(order_id);
                                    $("#change_modal").modal('show');
                                });
                                $('#save_status').on('click', function () {
                                    $.ajax({
                                        url: '<?php echo base_url(); ?>order/save_status',
                                        data: $("#status_form").serialize(),
                                        method: 'post',
                                        success: function (data) {
                                            var result = JSON.parse(data);
                                            if (result.status == 1) {
                                                $("#status_msg").css('color','green');
                                                $("#status_msg").html(result.msg)
                                                showtable();
                                            } else {
                                                $("#status_msg").css('color','red');
                                                $("#status_msg").html(result.msg)
                                            }
                                        }
                                    })
                                })
                            });
                            function showtable() {
                                $("#order_table").DataTable({
                                    "processing": true,
                                    "serverSide": true,
                                    "paging": true,
                                    "searching": true,
                                    "order": [],
                                    "pageLength": 10,
                                    "destroy": true,
                                    "processData": false,
                                    "responsive": true,
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>order',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'user_name'},
                                        {'data': 'order_number'},
                                        {'data': 'total'},
                                        {'data': 'order_date'},
                                        {'data': 'status_name'},
                                        {'data': 'action', orderable: false},
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