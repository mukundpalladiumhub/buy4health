<div class="content-wrapper">
    <section class="content-header">
        <h1>Product List<small>advanced tables</small></h1>
        <!--        <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Tables</a></li>
                    <li class="active">Product tables</li>
                </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Product Data Table</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="product_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Price</th>                                            
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
                                $("#product_table").DataTable({
                                    "processing": true,
                                    "serverSide": true,
                                    "paging": true,
                                    "searching": true,
                                    "order": [],
                                    "pageLength": 10,
                                    "destroy": true,
                                    "processData": false,
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>product',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'title'},
                                        {'data': 'description'},
                                        {'data': 'price'},
                                        {'data': 'status'},
                                        {'data': 'action', 'orderable': false},
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