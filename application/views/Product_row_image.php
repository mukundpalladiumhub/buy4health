<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Image Detail List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Product Image Detail List</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="product_image_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product Number</th>
                                        <th>Product Image</th>
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
                                $("#product_image_table").DataTable({
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
                                        "url": '<?php echo base_url() . '/product/view_image/' . $id; ?>',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'name'},
                                        {'data': 'image'},
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