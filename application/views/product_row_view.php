<div class="content-wrapper">
    <section class="content-header">
        <h1>Product Detail</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="<?php echo base_url('product'); ?>">Product</a></li>
            <li><a href="JavaScript:Void(0);">Product Detail</a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Product ID - <?php echo $id; ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-6">
                            <label>Product Name:- </label><br><?php echo $product_name; ?><br><br>
                            <label>Product Code:- </label><br><?php echo $product_code; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Category:- </label><br><?php echo $category_name; ?><br><br>
                            <label>Sub Category:- </label><br><?php echo $sub_category; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Product Weight:- </label><br><?php echo $product_weight; ?><br><br>
                            <label>Product VAT:- </label><br><?php echo $product_vat; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Sub Sub Category:- </label><br><?php echo $sub_sub_category; ?><br><br>
                            <label>Sub Sub Minor ID Category:- </label><br><?php echo $sub_sub_minor_category; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Product Tags:- </label><br><?php echo $product_tags; ?><br><br>
                            <label>Products Bought Together:- </label><br><?php echo $products_bought_together; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Service Tax:- </label><br><?php echo $service_tax; ?><br><br>
                            <label>Delivery Charges:- </label><br><?php echo $delivery_charges; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>COD Amount:- </label><br><?php echo $cod_amount; ?><br><br>
                            <label>Packing Charges:- </label><br><?php echo $packing_charges; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Size Type:- </label><br><?php echo $size_type; ?><br><br>
                            <label>Vehicle:- </label><br><?php echo $vehicle; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>C.O.D:- </label><br><?php echo $cod; ?><br><br>
                            <label>Sale Dispatch Time:- </label><br><?php echo $sale_dispatch_time; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Meta Title:- </label><br><?php echo $meta_title; ?><br><br>
                            <label>Meta Keyword:- </label><br><?php echo $meta_keyword; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Flipkart Price:- </label><br><?php echo $flipkart_price; ?><br><br>
                            <label>Amazon Price:- </label><br><?php echo $amazon_price; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Meta Description:- </label><br><?php echo $meta_description; ?><br><br>
                            <label>Calls of enquire:- </label><br><?php echo $call_to_enquire; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Average Rating:- </label><br><?php echo $avg_rating; ?><br><br>
                            <label>Rent Delivery pickup Charges:- </label><br><?php echo $rent_del_pickup_charges; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Average Rating Sale Price:- </label><br><?php echo $avg_sale_price; ?><br><br>
                            <label>Average Rent Price:- </label><br><?php echo $avg_rent_price; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Refill Product ID:- </label><br><?php echo $refill_product_id; ?><br><br>
                            <label>Vendor ID:- </label><br><?php echo $vendor_id; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Product Image:- </label><br><?php echo $product_image; ?><br><br>
                            <label>Brand:- </label><br><?php echo $brand; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Category Name:- </label><br><?php echo $category_name; ?><br><br>
                            <label>Product Info:- </label><?php echo $product_info; ?><br><br>
                        </div>
                        <div class="col-xs-6">
                            <label>Product Description:- </label><br><?php echo $product_description; ?><br><br>
                            <label>Status:- </label><br><?php echo $status; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>