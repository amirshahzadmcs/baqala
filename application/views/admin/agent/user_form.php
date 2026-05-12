<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Agents</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/agent"><i class="fa fa-reply"></i></a>			  
<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> SUBMIT</button>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Add Agent </h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<?php echo form_open("admin/agent/add_agent", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>

<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first_name">Full Name <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="first_name" name="name" value="<?php echo $name;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="email" id="email" name="email" value="<?php echo $email;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">Phone <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="phone" name="phone" value="<?php echo $phone;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="account_no">Account Number<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="account_no" name="account_no" value="<?php echo $account_no;?>" required class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="bank_name">Bank Name <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="bank_name" name="bank_name" value="<?php echo $bank_name;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ifsc">Bank IFSC <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="ifsc" name="ifsc" value="<?php echo $ifsc;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_code">Referal Code <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="ref_code" name="ref_code" value="<?php echo $ref_code;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select id="status" name="status" class="form-control col-md-7 col-xs-12">
<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Deactive</option>
</select>
</div>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/home/footer');?>