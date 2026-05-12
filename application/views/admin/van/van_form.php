<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Van</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/van"><i class="fa fa-reply"></i></a>
<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
</div>
</div>
<div class="clearfix"></div>
			  
			  
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h5><i class="fa fa-pencil"></i> Add Van</h5>
		   <div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<?php echo form_open("admin/van/add_van", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
			
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
			<input type="hidden" id="o_img" name="o_img" value="<?php echo $o_img;?>">
			<input type="hidden" id="o_icon" name="o_icon" value="<?php echo $o_icon;?>">
			<input type="hidden" id="o_car" name="o_car" value="<?php echo $o_car;?>">
	
			<div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="parent_id">Partner
			</label>
			<select class="form-control col-md-7 col-xs-12" name="parent_id" required="required">
			<option value="">--Choose Partner--</option>
			 <?php foreach($submits as $res){?>
				<option value="<?php echo $res->id;?>" <?php echo ($res->id == $parent_id) ? "selected":"" ?>><?php echo $res->cname;?></option>
			 <?php }?>
			</select>
		  </div>
		
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="van_no">Van No <span class="required">*</span>
			</label>
			  <input type="text" id="van_no" name="van_no" value="<?php echo $van_no;?>" required="required" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="dname"> Driver Name <span class="required">*</span>
			</label>
			  <input type="text" id="dname" name="dname" value="<?php echo $dname;?>" class="form-control col-md-7 col-xs-12" required="required" onKeyPress="return Alpha(event);"  maxlength="50">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="arabic_name"> Driver Name Arabic <span class="required">*</span>
			</label>
			  <input type="text" id="arabic_name" name="arabic_name" value="<?php echo $arabic_name;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		<div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="driver_mo_no">Driver Mobile No <span class="required">*</span>
			</label>
			  <input type="text" id="driver_mo_no" name="driver_mo_no" value="<?php echo $driver_mo_no;?>" class="form-control col-md-7 col-xs-12" required="required" onkeypress="return numerics(event);"  maxlength="15"  minlength="10">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="password">Password <span class="required">*</span>
			</label>
				<?php if($id == ''){ ?>
					<input type="text" id="password" name="password" value="<?php echo $password;?>" class="form-control col-md-7 col-xs-12" required="required">
				<?php }else{ ?>
					<input type="text" id="password" name="password" class="form-control col-md-7 col-xs-12">
				<?php } ?>
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="validity">Validity <span class="required">*</span>
			</label>
			  <input type="date" id="validity" name="validity" value="<?php echo $validity;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  	  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="city">City <span class="required">*</span>
			</label>
			  <input type="text" id="city" name="city" value="<?php echo $city;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>	 
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="region">Region <span class="required">*</span>
			</label>
			  <input type="text" id="region" name="region" value="<?php echo $region;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  	  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="country">Country <span class="required">*</span>
			</label>
			  <input type="text" id="country" name="country" value="<?php echo $country;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="charge">Delivery Charges <span class="required">*</span>
			</label>
			  <input type="text" id="charge" name="charge" value="<?php echo $charge;?>" placeholder="5 SAR" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="dcity">Delivery City <span class="required">*</span>
			</label>
			  <input type="text" id="dcity" name="dcity" value="<?php echo $dcity;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="area">Delivery Area <span class="required">*</span>
			</label>
			  <input type="text" id="area" name="area" value="<?php echo $area;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="iqama_no">Iqama No <span class="required">*</span>
			</label>
			  <input type="text" id="iqama_no" name="iqama_no" value="<?php echo $iqama_no;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="iqama_expiry">Iqama Expiry <span class="required">*</span>
			</label>
			  <input type="date" id="iqama_expiry" name="iqama_expiry" value="<?php echo $iqama_expiry;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		   <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="car_ins_expiry">Car Insurance Expiry <span class="required">*</span>
			</label>
			  <input type="date" id="car_ins_expiry" name="car_ins_expiry" value="<?php echo $car_ins_expiry;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
		   <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="stc_pay_no">STC Pay No (10 digits) <span class="required">*</span>
			</label>
			  <input type="text" id="stc_pay_no" name="stc_pay_no" value="<?php echo $stc_pay_no;?>" class="form-control col-md-7 col-xs-12" required="required">
		  </div>
	
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="image">Upload Iqama Copy <span class="required">*</span>
			</label>
			  <input type="file" id="image" name="image" class="form-control col-md-7 col-xs-12" <?php echo ($id != "") ? '':'required';?>>
			<div class="col-sm-3"><?php echo ($o_img != "") ? '<img src="'.base_url().$o_img.'" width="70px"/>':'';?></div>
		  </div>
		  
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="icon">Upload Driving Licence <span class="required">*</span>
			</label>
			  <input type="file" id="icon" name="icon" class="form-control col-md-7 col-xs-12" <?php echo ($id != "") ? '':'required';?>>
			<div class="col-sm-3"><?php echo ($o_icon != "") ? '<img src="'.base_url().$o_icon.'" width="70px"/>':'';?></div>
		  </div>
		  
		   <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="icon">Upload Car Insurance <span class="required">*</span>

			</label>
			  <input type="file" id="car" name="car" class="form-control col-md-7 col-xs-12" <?php echo ($id != "") ? '':'required';?>>
			<div class="col-sm-3"><?php echo ($o_car != "") ? '<img src="'.base_url().$o_car.'" width="70px"/>':'';?></div>
		  </div>
		  
		  
		  <div class="form-group col-md-6 col-sm-6 col-xs-12">
			<label class="control-label" for="status">Status <span class="required">*</span>
			</label>
			  <select id="status" name="status" class="form-control col-md-7 col-xs-12" required="required">
				<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
				<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
			  </select>
		  </div>

		<?php echo form_close(); ?>
	  </div>
	</div>
  </div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script>

 $(document).ready(function() {
	$('#description').summernote({
	height: 200
	});
});
</script>
<script type="text/javascript">

 $(document).ready(function(){
     $("#number").on("keypress",function(e){
      if($(this).val().length<='13'){
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          
          $("#errmsg").html("Digits Only").show();
          return false;
        }
      }else{
          $("#errmsg").html("Input  14 Digits Only").show();
          return false;
      }
     });
     });
</script>
<script>
    function Alpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }
    function numerics(key) {
           //getting key code of pressed key
           // alert($(this).val());
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes

           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;


       }
</script> 