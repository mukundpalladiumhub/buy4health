<div class="content-wrapper">
    <section class="content-header">
        <h1>Order Tables<small>advanced tables</small></h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Order tables</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order Data Table</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="order_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Product Title</th>
                                        <th>Order Amount</th>
                                        <th>Transaction ID</th>
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
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>index.php/order',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'full_name'},
                                        {'data': 'title'},
                                        {'data': 'order_amount'},
                                        {'data': 'transaction_id'},
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