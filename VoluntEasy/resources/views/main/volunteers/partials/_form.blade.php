<div class="panel panel-white">
    <div class="panel-body">
        <div id="rootwizard">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab1" data-toggle="tab"><i class="fa fa-user m-r-xs"></i>Personal Info</a></li>
                <li role="presentation"><a href="#tab2" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Product Info</a></li>
                <li role="presentation"><a href="#tab3" data-toggle="tab"><i class="fa fa-truck m-r-xs"></i>Payment</a></li>
                <li role="presentation"><a href="#tab4" data-toggle="tab"><i class="fa fa-check m-r-xs"></i>Finish</a></li>
            </ul>

<div class="progress progress-sm m-t-sm">
                                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                            </div>
                                        </div>
                                        <form id="wizardForm">
                                            <div class="tab-content">
                                                <div class="tab-pane active fade in" id="tab1">
                                                    <div class="row m-b-lg">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="exampleInputName">First Name</label>
                                                                    <input type="text" class="form-control" name="exampleInputName" id="exampleInputName" placeholder="First Name">
                                                                </div>
                                                                <div class="form-group  col-md-6">
                                                                    <label for="exampleInputName2">Last Name</label>
                                                                    <input type="text" class="form-control col-md-6" name="exampleInputName2" id="exampleInputName2" placeholder="Last Name" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="exampleInputEmail">Email address</label>
                                                                    <input type="email" class="form-control" name="exampleInputEmail" id="exampleInputEmail" placeholder="Enter email" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="exampleInputPassword1">Password</label>
                                                                    <input type="password" class="form-control" name="exampleInputPassword1" id="exampleInputPassword1" placeholder="Password" >
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="exampleInputPassword2">Confirm Password</label>
                                                                    <input type="password" class="form-control" name="exampleInputPassword2" id="exampleInputPassword2" placeholder="Confirm Password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h3>Personal Info</h3>
                                                            <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus.</p>
                                                            <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <img src="assets/images/envato-logo.png" width="250" alt="">
                                                            <div class="m-t-md">
                                                                <address>
                                                                    <strong>Twitter, Inc.</strong><br>
                                                                    795 Folsom Ave, Suite 600<br>
                                                                    San Francisco, CA 94107<br>
                                                                    <abbr title="Phone">P:</abbr> (123) 456-7890
                                                                </address>
                                                                <address>
                                                                    <strong>Full Name</strong><br>
                                                                    <a href="mailto:#">first.last@example.com</a>
                                                                </address>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputProductName">Product Name</label>
                                                                <input type="text" class="form-control" name="exampleInputProductName" id="exampleInputProductName" placeholder="Product Name" >
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputProductId">Product ID</label>
                                                                <input type="text" class="form-control" name="exampleInputProductId" id="exampleInputProductId" placeholder="Product ID">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputQuantity">Quantity</label>
                                                                <input type="number" min="1" max="5" class="form-control" name="exampleInputQuantity" id="exampleInputQuantity" placeholder="Quantity">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab3">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputCard">Card Number</label>
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <input type="text" class="form-control" name="exampleInputCard" id="exampleInputCard" placeholder="Card Number">
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <input type="text" class="form-control col-md-4" name="exampleInputSecurity" id="exampleInputSecurity" placeholder="Security Code">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputHolder">Card Holders Name</label>
                                                                <input type="text" class="form-control" name="exampleInputHolder" id="exampleInputHolder" placeholder="Card Holders Name">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputExpiration">Expiration</label>
                                                                <input type="text" class="form-control date-picker" name="exampleInputExpiration" id="exampleInputExpiration" placeholder="Expiration">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label for="exampleInputCsv">CSV</label>
                                                                <input type="text" class="form-control" name="exampleInputCsv" id="exampleInputCsv" placeholder="CSV">
                                                            </div>
                                                            <div class="form-group col-md-12">
                                                                <label class="f-s-12">By pressing Next You will Agree to the Payment <a href="#">Terms & Conditions</a></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="tab4">
                                                    <h2 class="no-s">Thank You !</h2>
                                                    <div class="alert alert-info m-t-sm m-b-lg" role="alert">
                                                        Congratulations ! You got the last step.
                                                    </div>
                                                </div>
                                                <ul class="pager wizard">
                                                    <li class="previous"><a href="#" class="btn btn-default">Previous</a></li>
                                                    <li class="next"><a href="#" class="btn btn-default">Next</a></li>
                                                </ul>
                                            </div>
                                        </form>

{!! Form::open() !!}
    {!! Form:label('name', 'Name:') !!}
    {!! Form:text() !!}

{!! Form::close() !!}

</div>
</div>
</div>