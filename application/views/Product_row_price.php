<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Price Details</h1>
<!--        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url('product'); ?>">Product</a></li>
            <li><a href="JavaScript:Void(0);">Product Price Details</a></li>
        </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Product Name : <?php echo $product_name; ?></h3>
                        <div class="box-tools">
                            <a href="<?php echo base_url('product'); ?>" class="btn btn-primary">Back to Product</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="product_price_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Size Type</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
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
                                        "url": '<?php echo base_url() . 'product/view_price/' . $id; ?>',
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