<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Rent Details</h1>
<!--        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url('product'); ?>">Product</a></li>
            <li><a href="JavaScript:Void(0);">Product Rent Details</a></li>
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
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="product_price_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rent Duration</th>
                                        <th>Rent Amount</th>
                                        <th>Advance Amount</th>
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
                                        "url": '<?php echo base_url() . 'product/view_rent/' . $id; ?>',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'rent_duration'},
                                        {'data': 'rent_amount'},
                                        {'data': 'advance_amount'},
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