<?php $this->load->view('admin/home/header');?>

<div class="page-title">

  <div class="title_left">

	<h3>Recharge Voucher</h3>

  </div>

  <div class="title_right">

  <a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/voucher"><i class="fa fa-reply"></i></a>

	<button type="submit" form="demo-form2" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>

  </div>

  </div>

  <div class="clearfix"></div>

<div class="row">

  <div class="col-md-12 col-sm-12 col-xs-12">

	<div class="x_panel">

	  <div class="x_title">

		<h5><i class="fa fa-pencil"></i> Update Recharge Voucher</h5>

		   <div class="clearfix"></div>

	  </div>

	  <div class="x_content">

		<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/voucher/edit" data-parsley-validate class="form-horizontal form-label-left">
			<input type="hidden" id="id" name="id" value="<?php echo $voucher_id;?>">

		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="voucher_name">Group Name <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="voucher_name" name="voucher_name" value="<?php echo $voucher_name;?>" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="voucher_code">voucher_code <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="voucher_code" name="voucher_code" value="<?php echo $voucher_code;?>" minlength="16" maxlength="16" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>


		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="voucher_value">Coupan Value <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="text" id="voucher_value" name="voucher_value" value="<?php echo $voucher_value?>" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>
		   
		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="<?php echo $expiry_date;?>" required="required" readonly="readonly" class="form-control col-md-7 col-xs-12">
			</div>
		  </div>

		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <select id="status" name="status" class="form-control col-md-7 col-xs-12">
				<option value="1" <?php echo $status == '1' ? 'selected' :'';?>>Enabled</option>
				<option value="0" <?php echo $status == '0' ? 'selected' :'';?>>Disabled</option>
			  </select>
			</div>
		  </div>
		  
		  <div class="form-group">
			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="is_used">Is used <span class="required">*</span></label>
			<div class="col-md-6 col-sm-6 col-xs-12">
			  <select id="is_used" name="is_used" class="form-control col-md-7 col-xs-12">
				<option value="1" <?php echo $is_used == '1' ? 'selected' :'';?>>Used</option>
				<option value="0" <?php echo $is_used == '0' ? 'selected' :'';?>>Unused</option>
			  </select>
			</div>
		  </div>

		  </div>

		<?php echo form_close(); ?>

	  </div>

	</div>

  </div>

</div>

<?php $this->load->view('admin/home/footer');?>

			