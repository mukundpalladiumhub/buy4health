
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Invoice
            <!--<small>#007612</small>-->
        </h1>
    </section>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Rent4Health
                    <small class="pull-right">Date: <?php echo date('m/d/Y'); ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Rent4Health</strong><br>
                    F 2&3, Ground Floor<br>
                    Guru Tej Bahadur CHS<br>
                    Aundh Road, Pune <br>
                    Phone : +91-88 22 256 256 ,<br> +91-99 21 755 196<br>
                    Email : info@rent4health.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong><?php echo $user['first_name'].' '.$user['last_name'];?></strong><br>
                    <?php echo $user['address1']; ?>,<br>
                    <?php echo $user['zipcode']; ?><br>
                    <?php echo $user['city'].','.$user['state']; ?><br>
                    Phone : <?php echo $user['phone'].' , '.$user['mobile']; ?><br>
                    Email: <?php echo $user['email']; ?>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <!--<b>Invoice #007612</b><br>-->
                <br>
                <b>Order ID : </b> <?php echo $user['order_number']; ?><br>
                <b>Payment Due : </b> <?php echo $user['order_date']; ?><br>
                <!--<b>Account:</b> 968-34567-->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped" id="order_detail_table" width="100%">
                    <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Product Name</th>
                                        <th>Type (Buy & Rent)</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row" style="padding-top: 25px;">
            <!-- accepted payments column -->
            <div class="col-xs-6">
    <!--          <p class="lead">Payment Methods:</p>
              <img src="../../dist/img/credit/visa.png" alt="Visa">
              <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
              <img src="../../dist/img/credit/american-express.png" alt="American Express">
              <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
    
              <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
              </p>-->
            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Amount Due <?php echo $user['order_date']; ?></p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td><?php echo $user['total'];?></td>
                        </tr>
                        <tr>
                            <th>Shipping:</th>
                            <td><?php echo $user['shipping_rate'];?></td>
                        </tr>
                        <tr>
                            <th>Delivery Charge:</th>
                            <td><?php echo $user['order_delivery_charge'];?></td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td><?php echo (int)$user['total'] + (int)$user['shipping_rate'] + (int)$user['order_delivery_charge'];?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
      <!--          <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                </button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                  <i class="fa fa-download"></i> Generate PDF
                </button>-->
            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->


<script>
    $(document).ready(function () {
        showtable();
    });
    function showtable() {
        $("#order_detail_table").DataTable({
            "processing": true,
            "serverSide": true,
            "paging": false,
            "searching": false,
            "order": [],
            "pageLength": 10,
            "destroy": true,
            "processData": false,
            "responsive": true,
            "bInfo" : false,
            "bFilter": false,
            "ajax": {
                "url": '<?php echo base_url() . '/order/order_detail/' . $order_id; ?>',
                "type": 'POST',
            },
            "columns": [
                {'data': 'sr_no'},
                {'data': 'product_name'},
                {'data': 'type'},
                {'data': 'quantity'},
                {'data': 'price'},
                {'data': 'total_price'},
            ]
        });
    }
</script>