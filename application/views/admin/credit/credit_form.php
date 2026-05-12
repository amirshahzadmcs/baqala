<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Credit Account Update</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/Credit_account"><i class="fa fa-reply"></i></a>
</div>
</div>
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h5><i class="fa fa-pencil"></i>Credit Account Update </h5>
		   <div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<div style="border:1px solid #ccc;padding:10px;min-height: 100px;">
			<div class="col-md-6">
				<h5><b>Account Holder Name: </b> <?php echo $name; ?></h5>
				<h5><b>Company Name: </b> <?php echo $company_name; ?></h5>
				<h5><b>Account Status: </b>
					<?php
					if ($account_status == 0) {
						echo '<span class="label label-primary">Not Open Yet</span>';
					} elseif ($account_status == 1) {
						echo '<span class="label label-warning">Not Active</span>';
					} elseif ($account_status == 2) {
						echo '<span class="label label-success">Active</span>';
					} else {
						echo '<span class="label label-danger">Suspended</span>';
					}
					?>
				</h5>
			</div>
			<div class="col-md-6">
				<h3><b>Max Credit Limit: </b> <span class="text-success"><?php echo $max_credit_limit ?></span></h3>
				<h3><b>Credit Available: </b> <span class="text-success"><?php echo $credit_avilable ?></span></h3>
			</div>
		</div>
		<div style="border: 1px solid #ccc;padding: 10px;">
		<?php echo form_open("admin/Credit_account/update_limit", array("id"=>"submit_form"));?>
			<input type="hidden" id="id" name="id" value="<?php echo $id ?>" required>
			<input type="hidden" id="uname" name="name" value="<?php echo $name ?>" required>
			<input type="hidden" name="old_credit_limit" value="<?php echo $max_credit_limit ?>" required>
			<div class="form-group col-md-4">
				<label for="max_credit_limit">Max Credit Limit</label>
				<input type="text" id="max_credit_limit" min="1" name="max_credit_limit" class="form-control" placeholder="Max Credit Limit" value="<?php echo $max_credit_limit ?>" required />
			</div>
			<div class="col-md-2" style="margin-top: 23px;">
				<button type="submit" class="btn btn-success btn-md btn-block">UPDATE MAX LIMIT</button>
			</div>
		<?php echo form_close();?>
		<!--
		<?php echo form_open("admin/Credit_account/update_credits", array("id"=>"submit_form"));?>
			<input type="hidden" id="id" name="id" value="<?php echo $id ?>" required>
			<input type="hidden" id="uid" name="uid" value="<?php echo $uid ?>" required>
			<input type="hidden" id="uname" name="name" value="<?php echo $name ?>" required>
			<div class="form-group col-md-4">
				<label for="amount">Add Credit</label>
				<input type="text" id="amount" min="1" name="amount" class="form-control" placeholder="Enter Amount" value="" required />
			</div>
			<div class="form-group col-md-6">
				<label for="remarks">Remarks</label>
				<input type="text" id="remarks" name="remarks" class="form-control" placeholder="Enter Remarks" required />
			</div>
			<div class="col-md-2" style="margin-top: 23px;">
				<button type="submit" class="btn btn-success btn-md btn-block">UPDATE CREDIT</button>
			</div>
		<?php echo form_close();?>
		-->
		</div>
	  </div>
	</div>
  </div>
</div>
<?php $this->load->view('admin/home/footer');?>