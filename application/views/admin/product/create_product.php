<?php
$this->load->view('admin/home/header');
?>
<style>
span.required{
	color:red;
}
.alert_text{
	border:2px red solid;
}
.d-none{
	display:none;
}
#wait{
	display: none;
    width: 100%;
    height: 100%;
    position: absolute;
    padding: 2px;
    z-index: 9;
    background: #ffffff96;
    text-align: center;
    padding-top: 17%;
    font-size: 30px;
}
ul.nav-pills li.nav-item{
	width:16.66% !important;
}


@media only screen and (max-width: 1240px) {
  ul.nav-pills li.nav-item{
		width:24% !important;
	}
}
@media only screen and (max-width: 767px) {
  ul.nav-pills li.nav-item{
		width:50% !important;
	}
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #050 !important;
    background-color: rgb(249, 249, 252) !important;
	margin-bottom: 18px !important;
}
</style>

<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <div class="page-title">
                    <h4>Product Management</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/product">Product</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
            <?php  $admin_id= $this->session->userdata('admin_id'); ?>
            <div class="col-sm-6">
                <div class="float-end d-sm-block">
                    <a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/product"><i class="fa fa-reply"></i> Back</a>
                </div>
                <?php if($this->admin->getInfo()){ $info = explode("--", $this->admin->getInfo()); $info_type = $info[0]; $msg_data = $info[1]; if($info_type == 2){ ?>
                <div class="alert alert-danger alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } else{?>
                <div class="alert alert-info alert-dismissible fade show" style="position: fixed; z-index: 99; right: 20px; top: 90px; width: 50%;" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php echo $msg_data;?></strong>
                </div>
                <?php } ?>
                <?php } $this->admin->removeInfo();?>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="container-fluid">
    <div class="page-content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
						<div class="row py-5">
							<div class="col-md-4">
								<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<a class="nav-link p-nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><div class="d-flex"><div class="me-2"><i class="dripicons-network-1 fa-2x"></i></div><div>Category<br><span>Your product category</span></div></div></a>
									
									<a class="nav-link p-nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><div class="d-flex"><div class="me-2"><i class="mdi mdi-brightness-percent fa-2x"></i></div><div>Brand<br><span>Your product brand</span></div></div></a>
									
									<a class="nav-link p-nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><div class="d-flex"><div class="me-2"><i class="mdi mdi-barcode-scan fa-2x"></i></div><div>SKU<br><span>Your product identifiers</span></div></div></a>
									
									<a class="nav-link p-nav-link" id="v-pills-variation-tab" data-bs-toggle="pill" href="#v-pills-variation" role="tab" aria-controls="v-pills-variation" aria-selected="false"><div class="d-flex"><div class="me-2"><i class="mdi mdi-checkbox-multiple-marked-outline fa-2x"></i></div><div>Variation<br><span>Your product variation</span></div></div></a>
								</div>
							</div>
							<div class="col-md-8">
								<?php echo form_open("admin/product/save_product", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"product-form")); ?>
								<div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
									<div class="tab-pane p-tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
										<h5>Lets start with categorizing your product</h5>
										<div class="form-group" style="min-height: 140px;">
											<label class="control-label" for="first-name">Select category</label>
											<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
												<select style="height:410px;" name="category_id" id="category_id" class="form-control select2" required onblur="checkField('category_id')">
													<option value="">Select </option>
													<?php
													foreach($categories as $category){?>
													<option value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
													<?php foreach($category['child'] as $child){?>
													<option value="<?php echo $child['id'];?>"><?php echo $category['name'] . " > " . $child['name'];?></option>
													<?php foreach($child['child'] as $sub){?>
													<option value="<?php echo $sub['id'];?>"><?php echo $category['name'] . " > " . $child['name'] . " > " . $sub['name'];?></option>
													<?php }}}?>
												</select>
											</div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
											<hr/>
											<button type="button" onclick="trigger_tab('v-pills-profile-tab','v-pills-profile')" class="btn btn-sm btn-custom-success" style="float: right;"> Next <i class="dripicons-chevron-right" style="vertical-align: text-top;"></i></button>
										</div>
									</div>
									<div class="tab-pane p-tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
										<h5>Tell us about the brand</h5>
										<div class="form-group" style="min-height: 140px;">
											<label class="control-label" for="first-name">Select brand </label>
											<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
												<select style="height:410px;" name="brand_id" id="brand_id" class="form-control select2" required onblur="checkField('brand_id')">
													<option value="">Select </option>
													<?php foreach($brand_list as $brand){?>
													<option value="<?php echo $brand->id;?>"><?php echo $brand->brand_name;?></option>
													<?php } ?>
												</select>
												<small>Select brand of your product</small>
											</div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
											<hr/>
											<button type="button" onclick="trigger_tab('v-pills-settings-tab','v-pills-settings')" class="btn btn-sm btn-custom-success" style="float: right;"> Next <i class="dripicons-chevron-right" style="vertical-align: text-top;"></i></button>
										</div>
									</div>
									<div class="tab-pane p-tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
										<h5>Tell us about your product</h5>
										<div class="form-group" style="min-height: 140px;">
											<label class="control-label" for="first-name">Parent SKU</label>
											<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
												<input type="text" id="parent_sku" name="parent_sku" <?php if(!$this->input->get('id')){ echo 'onBlur="checkSKU()"'; } ?> required onblur="checkField('parent_sku')"  class="form-control" placeholder="Parent SKU">
												<small>Enter parent sku for your product</small>
												<div class="ajax-skucheck"></div>
											</div>
										</div>
										<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
											<hr/>
											<button type="button" onclick="trigger_tab('v-pills-variation-tab','v-pills-variation')" class="btn btn-sm btn-custom-success" style="float: right;"> Next <i class="dripicons-chevron-right" style="vertical-align: text-top;"></i></button>
										</div>
									</div>
									<div class="tab-pane p-tab-pane fade" id="v-pills-variation" role="tabpanel" aria-labelledby="v-pills-variation-tab">
										<div class="row">
											<h5>Tell us about your product</h5>
											<div class="form-group col-md-6" style="min-height: 50px;">
												<label class="control-label" for="is_variation">Product Variation</label>
												<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
													<input type="checkbox" id="switch3" switch="bool" name="is_variation" checked />
													<label for="switch3" data-on-label="Yes" data-off-label="No"></label>
													<div><small>Switch ON, If product has variation</small></div>
												</div>
											</div>
											<div class="form-group col-md-6" style="min-height: 50px;">
												<label class="control-label" for="cod_available">COD Available</label>
												<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
													<input type="checkbox" id="switch2" switch="bool" name="cod_available" checked />
													<label for="switch2" data-on-label="Yes" data-off-label="No"></label>
													<div><small>Switch ON, If cod available</small></div>
												</div>
											</div>
											<div class="form-group col-md-6" style="min-height: 50px;">
												<label class="control-label" for="b2b_availability">B2B Available</label>
												<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
													<input type="checkbox" id="switch4" switch="bool" name="b2b_availability" checked />
													<label for="switch4" data-on-label="Yes" data-off-label="No"></label>
													<div><small>Switch ON, If B2B available</small></div>
												</div>
											</div>
											<div class="form-group col-md-6" style="min-height: 50px;">
												<label class="control-label" for="status">Product Status</label>
												<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
													<input type="checkbox" id="switch1" switch="bool" name="status" />
													<label for="switch1" data-on-label="Yes" data-off-label="No"></label>
													<div><small>Switch ON, If status active</small></div>
												</div>
											</div>
											<div class="col-md-10 col-sm-12 col-xs-12 mb-3">
												<hr/>
												<button type="save" class="btn btn-sm btn-custom-success" style="float: right;"> Submit</button>
											</div>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function () {
    $(document).ajaxStart(function () {
        $("#wait").css("display", "block");
    });
    $(document).ajaxComplete(function () {
        $("#wait").css("display", "none");
    });
    $(document).ajaxError(function () {
        $("#wait").css("display", "none");
    });
});

function checkSKU() {
    var sku = $("#sku").val();
    if (sku !== "") {
        $.ajax({
            url: "<?php echo base_url();?>admin/product/checkSKU",
            type: "GET",
            data: "sku=" + $("#sku").val(),
            success: function (data) {
                $(".ajax-skucheck").html(data);
            },
            error: function () {},
        });
    } else {
        checkField("sku");
    }
}

function checkSEO() {
    var seo_url = $("#seo").val();
    if (seo_url !== "") {
        //alert(seo_url);
        $.ajax({
            url: "<?php echo base_url();?>admin/product/checkSEO",
            type: "GET",
            data: "seo=" + seo_url,
            success: function (data) {
                //alert(data);
                $(".ajax-seocheck").html(data);
            },
            error: function () {},
        });
    } else {
        checkField("seo");
    }
}

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.summerNote').summernote({
			height: 200
		});
	});

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}
</script>
<script type="text/javascript">
var trigger_tab = function(link,tab) {
    $(".p-nav-link").removeClass('active');
    $(".p-tab-pane").removeClass('active');
    $("#" + link).addClass('active');
    $("#" + tab).addClass('show active');
}
</script>