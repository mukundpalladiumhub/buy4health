<div class="content-wrapper">
    <section class="content-header">
        <h1>Category List</h1>
<!--        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Category tables</li>
        </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Category List</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="category_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Tag</th>
                                        <th>Image</th>
                                        <th>Status</th>                                            
                                        <!--<th>Action</th>-->                                            
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
                                $("#category_table").DataTable({
                                    "processing": true,
                                    "serverSide": true,
                                    "paging": true,
                                    "searching": true,
                                    "order": [],
                                    "pageLength": 10,
                                    "destroy": true,
                                    "processData": false,
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>category',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'category_name'},
                                        {'data': 'category_tag'},
                                        {'data': 'category_image'},
                                        {'data': 'status', orderable: false},
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