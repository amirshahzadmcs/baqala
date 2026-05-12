<?php $this->load->view('agency/layout/header');?>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
    <div class="page-content">
        <!-- start page title -->
        <div class="page-title-box">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h4>Manage Password</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('hiring-agency');?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Change Password</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
                            <a class="btn btn-sm btn-custom-white pull-right me-1" title="Back"
                                href="<?php echo base_url('hiring-agency');?>"><i class="fa fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <?php $this->load->view('agency/layout/profile-sidebar');?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="card p-3">
                            <div class="card-body" style="min-height: 506px;">
								<?php $this->load->view('agency/partials/alert');?>

                                <form method="post" action="<?php echo base_url('hiring-agency/update-password')?>"
                                    id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group mb-3">
                                        <label class="control-label col-md-12" for="old_password">Old
                                            Password <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <input type="password" id="old_password" name="old_password"
                                                required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="control-label col-md-12" for="new_password">New
                                            Password <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <input type="password" id="new_password" name="new_password"
                                                required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"
                                            for="confirm_password">Confirm Password <span class="required">*</span>
                                        </label>
                                        <div class="col-md-8 col-sm-12 col-xs-12">
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                required="required" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                            <button class="btn btn-primary" type="reset">Reset</button>
                                            <input type="submit" name="submit" class="btn btn-success">
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->
<?php $this->load->view('agency/layout/footer');?>
