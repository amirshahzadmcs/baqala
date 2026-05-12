<?php $this->load->view('admin/home/header');?>
<style>
    .err-msg{
        color:red;
        font-size:12px;
    }
</style>
<div class="page-title">
	<div class="title_left">
		<h3>Delivery Boy</h3>
	</div>
	<div class="title_right">
		<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> SUBMIT</button>
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/delivery"><i class="fa fa-reply"></i></a>
		<!--
		<?php if($id){ ?>
		<a class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="UPDATE PASSWORD" href="<?php echo base_url();?>admin/delivery/update?id=<?php echo $id;?>">UPDATE Username / Password</a>
		<?php } ?>
		-->
	</div>
</div>
<div class="clearfix"></div>			  
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h5><i class="fa fa-pencil"></i> Add Delivery Boy </h5>
			   <div class="clearfix"></div>
			</div>
			<div class="x_content">
			<br />
				<?php echo form_open("admin/delivery/add_delivery", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
				
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
					<?php if($id){ ?>
					<input type="hidden" id="o_iqama" name="o_iqama" value="<?php echo $o_iqama;?>">
					<input type="hidden" id="o_dl_image" name="o_dl_image" value="<?php echo $o_dl_image;?>">
					<?php } ?>
					
					<div class="form-group col-md-6 col-sm-6 col-xs-12">
						<label class="control-label" for="partner_id">Partner
						</label>
						<select class="form-control col-md-7 col-xs-12" name="partner_id" required="required">
							<option value="">--Choose Partner--</option>
							<?php foreach($partners as $res){?>
							<option value="<?php echo $res->id;?>" <?php echo ($res->id == $partner_id) ? "selected":"" ?>><?php echo $res->cname;?></option>
							<?php }?>
						</select>
					</div>
		  
					<div class="form-group col-md-6">
						<label class="control-label" for="name">Name <span class="required">*</span>
						</label>
						<div>
							<input type="text" id="name" name="name" maxlength="120" value="<?php echo $name;?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Name">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="arabic_name">Arabic Name <span class="required">*</span>
						</label>
						<div>
							<input type="text" id="arabic_name" name="arabic_name" maxlength="120" value="<?php echo $arabic_name;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Name in Arabic">
						</div>
					</div>
			  
					<div class="form-group col-md-6">
						<label class="control-label" for="mobile">Mobile Number<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="mobile" name="mobile" maxlength="10" minlength="10" value="<?php echo $mobile;?>" class="form-control col-md-7 col-xs-12" required="required" placeholder="Enter Mobile (Eg. 9876543210)">
						</div>
						<span id="errmsg1" class="err-msg"></span>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="iqama_no">Iqama No <span class="required">*</span>
						</label>
						<div >
							<input type="text" id="iqama_no" name="iqama_no" minlength="10" maxlength="10" value="<?php echo $iqama_no;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="iqama_exp">Iqama Exp. Date<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="iqama_exp" data-provide="datepicker" name="iqama_exp" value="<?php echo $iqama_exp;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="delivery_charge">Delivery Charge<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="delivery_charge" name="delivery_charge" value="<?php echo $delivery_charge;?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Set Delivery Charge (Eg. 99 or 99.00 | Do not use any alphabet)">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="dl_no">Driving License No<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="dl_no" name="dl_no" minlength="10" maxlength="10" value="<?php echo $dl_no;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
						<span id="errmsgadhar" class="err-msg"></span>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="dl_expiry">Driving License Exp. Date<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="date" data-provide="datepicker" name="dl_expiry" value="<?php echo $dl_expiry;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="stc_pay_no">STC Pay No<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="stc_pay_no" name="stc_pay_no" minlength="10" maxlength="10" value="<?php echo $stc_pay_no;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="iban">IBAN No<span class="required">*</span>
						</label>
						<div>
							<input type="text" id="iban" name="iban" minlength="24" maxlength="24" value="<?php echo $iban;?>" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
			  
					<div class="form-group col-md-6">
						<label class="control-label" for="bank_name">Bank Name <span class="required">*</span></label>
						<div>
							<select id="bank_name" name="bank_name" class="form-control col-md-12 select2">
								<option value="">Select Bank</option>
								<?php foreach($master_banks as $master_bank){?>
								<option value="<?php echo $master_bank->id;?>" <?php echo ($bank_name == $master_bank->id) ? "selected":"";?>><?php echo $master_bank->bank_name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
			  
					<div class="form-group col-md-6">
						<label class="control-label" for="iqama">Iqama<span class="required">*</span>
						</label>
						<div>
							<input type="file" id="iqama" name="iqama" minlength="10" maxlength="10" class="form-control col-md-7 col-xs-12">
						</div>
						<?php if($id){ ?>
						<img src="<?php echo base_url().$o_iqama;?>" width="100px"/>
						<?php } ?>
					</div>

					<div class="form-group col-md-6">
						<label class="control-label" for="dl_image">Driving Licence<span class="required">*</span></label>
						<div>
							<input type="file" id="dl_image" name="dl_image" class="form-control col-md-7 col-xs-12">
						</div>
						<?php if($id){ ?>
						<img src="<?php echo base_url().$o_dl_image;?>" width="100px"/>
						<?php } ?>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="van_no">Van Number <span class="required">*</span>
						</label>
						<div>
							<input type="text" id="van_no" name="van_no" maxlength="50" value="<?php echo $van_no;?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Van Number">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="van_color">Van Colour <span class="required">*</span>
						</label>
						<div>
							<input type="text" id="van_color" name="van_color" maxlength="50" value="<?php echo $van_color;?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Van Colour">
						</div>
					</div>
					
					<div class="form-group col-md-6">
						<label class="control-label" for="van_model">Van Model <span class="required">*</span>
						</label>
						<div>
							<input type="text" id="van_model" name="van_model" maxlength="198" value="<?php echo $van_model;?>" required="required" class="form-control col-md-7 col-xs-12" placeholder="Enter Van Model">
						</div>
					</div>
					<?php if(!$id){?>
					<div class="form-group col-md-6">
						<label class="control-label" for="password">Password <span class="required">*</span></label>
						<div>
							<input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
						</div>
					</div>
					<?php } ?>

					<div class="form-group col-md-6">
						<label class="control-label" for="status">Status
						</label>
						<div>
							<select id="status" name="status" class="form-control col-md-7 col-xs-12">
								<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
								<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
								<option value="2" <?php echo ($status == '2') ? "selected":"";?>>Block</option>
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
	var date = new Date();
	date.setDate(date.getDate());

	$('#date').datepicker({ 
		startDate: date
	});
	
	$('#iqama_exp').datepicker({ 
		startDate: date
	});
	
	$("#mobile").on("keypress",function(e){
		if($(this).val().length<='10'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 10 Digits Only").show();
			return false;
		}
	});
	
	$("#adhar").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				
				$("#errmsgadhar").html("Aadhar number not valid").show();
				return false;
			}
		}else{
			$("#errmsgadhar").html("Maximum input 12 Digits Only").show();
			return false;
		}
	});
</script>
