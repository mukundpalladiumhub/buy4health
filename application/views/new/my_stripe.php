<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Payment
            <small>page</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-dashboard"></i> Home</li>
            <li>Payment</li>
            <li class="active">Form</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Stripe Payment Example</h3>
                    </div>
                    <div class="box-body">
                        <title>Codeigniter Stripe Payment Integration Example - ItSolutionStuff.com</title>
                        <!--                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
                        <style type="text/css">
                            .panel-title {
                                display: inline;
                                font-weight: bold;
                            }
                            .display-table {
                                display: table;
                            }
                            .display-tr {
                                display: table-row;
                            }
                            .display-td {
                                display: table-cell;
                                vertical-align: middle;
                                width: 61%;
                            }
                        </style>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="panel panel-default credit-card-box">
                                        <div class="panel-heading display-table" >
                                            <div class="row display-tr" >
                                                <h3 class="panel-title display-td" >Payment Details</h3>
                                                <div class="display-td" >                            
                                                    <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                                                </div>
                                            </div>                    
                                        </div>
                                        <div class="panel-body">
                                            <?php if ($this->session->flashdata('success')) { ?>
                                                <div class="alert alert-success text-center">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                                    <p><?php echo $this->session->flashdata('success'); ?></p>
                                                </div>
                                            <?php } ?>
                                            <form role="form" action="<?php echo base_url(); ?>index.php/makepayment/stripePost" method="post" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="<?php echo $this->config->item('stripe_key') ?>" id="payment-form">
                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group required'>
                                                        <label class='control-label'>Name on Card</label> <input class='form-control' size='4' type='text' name="name" >
                                                    </div>
                                                </div>
                                                <div class='form-row row'>
                                                    <div class='col-xs-12 form-group card required'>
                                                        <label class='control-label'>Card Number</label>
                                                        <input autocomplete='off' class='form-control card-number' size='20' type='text' name="card" >
                                                    </div>
                                                </div>
                                                <div class='form-row row'>
                                                    <div class='col-xs-12 col-md-4 form-group cvc required'>
                                                        <label class='control-label'>CVC</label>
                                                        <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text' name="cvc" >
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label'>Expiration Month</label>
                                                        <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text' name="month" >
                                                    </div>
                                                    <div class='col-xs-12 col-md-4 form-group expiration required'>
                                                        <label class='control-label'>Expiration Year</label>
                                                        <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text' name="year" >
                                                    </div>
                                                </div>
                                                <div class='form-row row'>
                                                    <div class='col-md-12 error form-group hide'>
                                                        <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>        
                                </div>
                            </div>
                        </div>
                        <script src="https://checkout.stripe.com/checkout.js"
                                class="stripe-button"
                                data-key="pk_Fhlzwtm9SCx6Uxww5fNXX8CUbwwAc"
                                data-amount="2000"
                                data-name="Demo Site"
                                data-description="2 widgets ($20.00)"
<!--                                data-image="/128x128.png">-->
                        </script>
                        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                        <script type="text/javascript">
                                    $(function () {
                                        var $form = $(".require-validation");
                                        $('form.require-validation').bind('submit', function (e) {
                                            var $form = $(".require-validation"),
                                                    inputSelector = ['input[type=email]', 'input[type=password]',
                                                        'input[type=text]', 'input[type=file]',
                                                        'textarea'].join(', '),
                                                    $inputs = $form.find('.required').find(inputSelector),
                                                    $errorMessage = $form.find('div.error'),
                                                    valid = true;
                                            $errorMessage.addClass('hide');
                                            $('.has-error').removeClass('has-error');
                                            $inputs.each(function (i, el) {
                                                var $input = $(el);
                                                if ($input.val() === '') {
                                                    $input.parent().addClass('has-error');
                                                    $errorMessage.removeClass('hide');
                                                    e.preventDefault();
                                                }
                                            });
                                            if (!$form.data('cc-on-file')) {
                                                e.preventDefault();
                                                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                                                Stripe.createToken({
                                                    number: $('.card-number').val(),
                                                    cvc: $('.card-cvc').val(),
                                                    exp_month: $('.card-expiry-month').val(),
                                                    exp_year: $('.card-expiry-year').val()
                                                }, stripeResponseHandler);
                                            }
                                        });
                                        function stripeResponseHandler(status, response) {
                                            if (response.error) {
                                                $('.error')
                                                        .removeClass('hide')
                                                        .find('.alert')
                                                        .text(response.error.message);
                                            } else {
                                                var token = response['id'];
                                                $form.find('input[type=text]').empty();
                                                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                                                $form.get(0).submit();
                                            }
                                        }
                                    });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>