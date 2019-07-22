<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Price Detail List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo $product_name; ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="product_price_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product Size Type</th>
                                        <th>Product Size ID</th>
                                        <th>Product Quantity</th>
                                        <th>Low Level</th>
                                        <th>Service Tax</th>
                                        <th>M.R.P.</th>
                                        <th>Price</th>
                                        <th>Status</th>
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
                                $("#product_price_table").DataTable({
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
                                        "url": '<?php echo base_url() . '/product/view_price/' . $id; ?>',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'size_type'},
                                        {'data': 'size_id'},
                                        {'data': 'quantity'},
                                        {'data': 'low_level'},
                                        {'data': 'service_tax'},
                                        {'data': 'mrp'},
                                        {'data': 'price'},
                                        {'data': 'status'},
//                                        {'data': 'action', orderable: false},
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