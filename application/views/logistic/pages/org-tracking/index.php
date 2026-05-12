<?php $this->load->view('logistic/layout/header');?>
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
                            <h4>ORG Tracking</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('logistic-partner');?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">ORG Tracking / Driver Tracking</li>
                            </ol>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-end d-none d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('logistic-partner');?>"><i class="fa fa-reply"></i> Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
							<div class="card-body" style="min-height: 506px;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.6691849559893!2d73.06437757438071!3d19.034293653282106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c2152a2fffff%3A0x86b86add743c6a28!2sIXIANA!5e0!3m2!1sen!2sin!4v1683291350426!5m2!1sen!2sin" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
<?php $this->load->view('logistic/layout/footer');?>
<script></script>
