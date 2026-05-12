<?php $this->load->view('delivery/layout/header');?>
<style>
#steps {
  width: auto;
  margin: 50px auto;
}

.step {
  width: 40px;
  height: 40px;
  background-color: white;
  display: inline-block;
  border: 4px solid;
  border-color: #cfcfcf;
  border-radius: 50%;
  color: #b4b4b4;
  font-weight: 600;
  text-align: center;
  line-height: 28px;
}
.step span{
	vertical-align: text-top;
}
.step p{
	margin-bottom: 0px;
    line-height: 27px;
}
.step:first-child {
  line-height: 33px;
}

.step:nth-child(n+2) {
  margin: 0 0 0 100px;
  transform: translate(0, -4px);
}

.step:nth-child(n+2):before {
  width: 104px;
  height: 3px;
  display: block;
  background-color: #dbdbdb;
  transform: translate(-108px, 15px);
  content: "";
}

.step:after {
	width: 150px;
	display: block;
	transform: translate(-55px, 14px);
	color: #434343;
	content: attr(data-desc);
	font-weight: 500;
	font-size: 14px;
}

.step:first-child:after {
  transform: translate(-55px, 10px);
}

.step.active {
  border-color: #73b5e8;
  color: #73b5e8;
}

.step.active:before {
  background: linear-gradient(to right, #58bb58 0%, #73b5e8 100%);
}

.step.active:after {
  color: #73b5e8;
}

.step.done {
  background-color: #58bb58;
  border-color: #58bb58;
  color: white;
}

.step.done:before {
  background-color: #58bb58;
}
</style>
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

                    <div class="col-xl-12">
                        <div class="card">
                          <div class="card-body">
                            <div class="card-title mb-4 mx-3">
                              <h4 class="header-title">Your Application Status</h4>
                              <small>Your personal information and application status are displayed here</small>
                            </div>
                            <div class="mt-2 text-center">
                              <div class="row">
                                <?php echo iqamaExpAlert($result->iqama_exp);?>
								               <?php echo dlExpAlert($result->dl_expiry);?>
                                <div class="col-md-12">
                                  <div id="steps">
                                    <div class="step" data-desc="Profile Details">1</div>
                                    <div class="step" data-desc="Vehicle Details">2</div>
                                    <div class="step active" data-desc="Bank Details">3</div>
                                    <div class="step" data-desc="Documents">4</div>
                                  </div>
                                </div>
                                <!--
                                <div class="col-md-6">
                                  <div class="mt-4 mt-sm-0">
                                    <div class="font-size-24"><i class="ti-receipt"></i></div>
                                    <p class="text-dark mb-2 pt-1 font-size-18">Application Status:</p>
                                    <h5 class="font-size-16 mb-1 text-warning">Incomplete</h5>
                                  </div>
                                </div>

                                <div class="col-md-6 dash-goal">
                                  <div class="mt-4 mt-sm-0">
                                    <div class="font-size-24"><i class="ti-user"></i></div>
                                    <p class="text-dark mb-2 pt-1 font-size-18">Account Status:</p>
                                    <h5 class="font-size-16 mb-1 text-warning">Pending</h5>
                                  </div>
                                </div>
            -->
                              </div>
                              <div class="row mt-2">
                                <div class="col-md-12">
                                  <h4 class="text-center text-primary-2">Your application is not submitted</h4>
                                  <small class="text-muted">Please complete the application and submit it for approval</small><br>
                                  <a href="<?= base_url('delivery-partner/application-form');?>" class="btn btn-primary btn-sm mt-3">Edit Application</a>
                                </div>
                              </div>
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

<?php $this->load->view('delivery/layout/footer');?>
<script>
	$(document).ready( function() {
		$('.step').each(function(index, element) {
			// element == this
			$(element).not('.active').addClass('done');
			$('.done').html('<i class="fa fa-check"></i>');
			if($(this).is('.active')) {
			return false;
			}
		});    
	});
</script>