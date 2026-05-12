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
                            <h4>Hi, welcome back!</h4>
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="container-fluid">
            <div class="page-content-wrapper">
                <div class="row">
                    <?php $this->load->view('logistic/partials/alert');?>
                    <div class="col-xl-12">
                        <div class="card">
							<div class="card-body">
								<div class="card-title mb-4 mx-3">
									<h4 class="header-title">Logistic Partner Dashboard</h4>
									<small>Here you can manage your riders and your profile.</small>
								</div>
								
							</div>
						</div>
						
                    </div>
                </div>
				
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end page content-->

<?php $this->load->view('logistic/layout/footer');?>
