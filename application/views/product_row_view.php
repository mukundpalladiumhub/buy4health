<div class="content-wrapper">
    <section class="content-header">
        <h1>Product View<small>advanced tables</small></h1>
<!--        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">Product View</li>
        </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Product id- <?php echo $id; ?></h3>
                    </div>
                    <div class="box-body">
                        <label>Product Name:- </label><br><?php echo $product_name; ?><br><br>
                        <label>Category:- </label><br><?php echo $category_name; ?><br><br>
                        <label>Sub Category:- </label><br><?php echo $sub_category; ?><br><br>
                        <label>Status:- </label><br>
                        <?php
                        if ($status == 1) {
                            $status = 'Active';
                        } else {
                            $status = 'Inactive';
                        }
                        echo $status;
                        ?><br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>