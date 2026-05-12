<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
	<h3>Pincode</h3>
	</div>
	<div class="title_right">
	<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/pincode"><i class="fa fa-reply"></i></a>
	<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
	</div>
</div>
<div class="clearfix"></div>
		  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
		  <div class="x_title">
			<h5><i class="fa fa-pencil"></i> Add Pincode</h5>
			   <div class="clearfix"></div>
		  </div>
		  <div class="x_content">
			<br />
			<?php echo form_open("admin/pincode/add_pincode", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
				
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
				  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pincode">Pincode <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="pincode" name="pincode" minlength="6" maxlength="6" value="<?php echo $pincode;?>" required="required" class="form-control col-md-7 col-xs-12">
				<span id="errpost" style="color: red;font-size: 11px;"></span>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="region">Region <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="region" name="region" value="<?php echo $region;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="area_name">Area Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="area_name" name="area_name" value="<?php echo $area_name;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="area">Area <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="area" name="area" value="<?php echo $area;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="svc">SVC <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="svc" name="svc" value="<?php echo $svc;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="service_code_name">Service Code Name <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="service_code_name" name="service_code_name" value="<?php echo $service_code_name;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="city">City <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="city" name="city" value="<?php echo $city;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="state">State <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="state" name="state" value="<?php echo $state;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="edp">EDP <span class="required">*</span>
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <input type="text" id="edp" name="edp" value="<?php echo $edp;?>" required="required" class="form-control col-md-7 col-xs-12">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status
				</label>
				<div class="col-md-6 col-sm-6 col-xs-12">
				  <select id="status" name="status" class="form-control col-md-7 col-xs-12">
					<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
					<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
				  </select>
			  </div>
			  </div>

			<?php echo form_close(); ?>
		  </div>
		</div>
	  </div>
	</div>
<?php $this->load->view('admin/home/footer');?>
<script>
    $("#pincode").on("keypress",function(e){
		if($(this).val().length<='6'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errpost").html("Digits Only").show();
				return false;
			}
		}else{
				$("#errpost").html("Maximum input 6 Digits Only").show();
				return false;
		}
	});
</script>
			