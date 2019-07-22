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
                        <h3 class="box-title">Product List</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="product_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>                                            
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
                                        {'data': 'product_name'},
                                        {'data': 'category'},
                                        {'data': 'sub_category'},
                                        {'data': 'status'},
                                        {'data': 'action', 'orderable': false},
                                    ]
                                });
                            }
                            $('body').on('click', '.viewbtn', function () {
                                alert('aef');
                                var id = $(this).data('id');
                                showtable_view(id);
                            }
                            );
                            function showtable_view(id) {
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
                                        "url": '<?php echo base_url(); ?>product/view/' + id,
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'product_name'},
                                        {'data': 'category'},
                                        {'data': 'sub_category'},
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