<div class="content-wrapper">
    <section class="content-header">
        <h1>Order Detail List</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order Detail List</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table" style="overflow-x:auto;">
                            <table id="order_detail_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Type</th>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total Price</th>
                                        <th>Rent Duration</th>
                                        <th>Delivery Charge</th>
                                        <th>Advance Amount</th>
                                        <th>Refund Amount</th>
                                        <th>Damage Amount</th>
                                        <th>Deliver On</th>
                                        <th>Deliver Date</th>
                                        <th>Pickup Date</th>
                                        <th>Commision</th>
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
                                $("#order_detail_table").DataTable({
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
                                        "url": '<?php echo base_url() . '/order/order_detail/' . $order_id; ?>',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'order_number'},
                                        {'data': 'type'},
                                        {'data': 'product_name'},
                                        {'data': 'size'},
                                        {'data': 'quantity'},
                                        {'data': 'price'},
                                        {'data': 'total_price'},
                                        {'data': 'rent_duration'},
                                        {'data': 'delivery_charge'},
                                        {'data': 'advance_amount'},
                                        {'data': 'refund_amount'},
                                        {'data': 'damage_amount'},
                                        {'data': 'deliver_on'},
                                        {'data': 'delivery_date'},
                                        {'data': 'pickup_date'},
                                        {'data': 'commison'},
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