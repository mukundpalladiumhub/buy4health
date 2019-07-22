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
                    </div>
                    <div class="box-body">
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="order_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Order Number</th>
                                        <th>Delivery Charge</th>
                                        <th>Total</th>
                                        <th>Convenience Charge</th>
                                        <th>Shipping Rate</th>
                                        <th>Order Date</th>
                                        <th>Payment Method</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Status</th>
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
                                        {'data': 'order_delivery_charge'},
                                        {'data': 'total'},
                                        {'data': 'convenience_charge'},
                                        {'data': 'shipping_rate'},
                                        {'data': 'order_date'},
                                        {'data': 'payment_method'},
                                        {'data': 'payment_status'},
                                        {'data': 'order_status'},
                                        {'data': 'status', orderable: false},
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