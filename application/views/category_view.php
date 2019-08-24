<div class="content-wrapper">
    <section class="content-header">
        <h1>Category List</h1>
<!--        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li><a href="JavaScript:Void(0);">Category</a></li>
        </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Category List</h3>
                        <div class="box-tools">
                            <select id="site_id" name="site_id" class="form-control"> 
                                <option value="">Sort By</option>
                                <option value="<?php echo RENT4HEALTHID;?>">Rent4health</option>
                                <option value="<?php echo BUY4HEALTHID;?>">Buy4health</option>
                            </select>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="category_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Site</th>
                                        <th>Category Name</th>
                                        <th>Tag</th>
                                        <th>Image</th>
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
                                
                                $("#site_id").on('change',function(){
                                    var site_id = $('#site_id option:selected').val();
                                    showtable(site_id);
                                });
                            });
                            function showtable(site_id) {
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
                                        data : {site_id:site_id}
                                    },
                                    "columns": [
                                        {'data': 'site_id'},
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