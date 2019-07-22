<div class="content-wrapper">
    <section class="content-header">
        <h1>User List<small>advanced tables</small></h1>
<!--        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Tables</a></li>
            <li class="active">User tables</li>
        </ol>-->
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">User List</h3>
                    </div>
                    <div class="box-body">
                        <div class="div_table">
                            <table id="user_table" class="display nowrap table table-hover table-striped table-bordered cms-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>                                            
                                        <th>Zipcode</th>                                            
                                        <th>State</th>                                            
                                        <th>City</th>                                            
                                        <th>Mobile No.</th>                                            
                                        <th>Phone No.</th>                                            
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
                                $("#user_table").DataTable({
                                    "processing": true,
                                    "serverSide": true,
                                    "paging": true,
                                    "searching": true,
                                    "order": [],
                                    "pageLength": 10,
                                    "destroy": true,
                                    "processData": false,
                                    "ajax": {
                                        "url": '<?php echo base_url(); ?>user',
                                        "type": 'POST',
                                    },
                                    "columns": [
                                        {'data': 'name'},
                                        {'data': 'email'},
                                        {'data': 'address'},
                                        {'data': 'zipcode'},
                                        {'data': 'state'},
                                        {'data': 'city'},
                                        {'data': 'mobile'},
                                        {'data': 'phone'},
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