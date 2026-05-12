<h6>Mobile Number: <span class="text-primary"><?php echo $sim_detail->mobile;?></span></h6>
<h6>Sim Number: <span class="text-primary"><?php echo $sim_detail->sim_no;?></span></h6><br>
<?php if($type == 'allotment'){ ?>
<form id="allotment_form" action="<?php echo base_url('admin/sim/save-allotment'); ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="sim_id" value="<?php echo $id;?>" required>
	<input type="hidden" name="type" value="<?php echo $type;?>" required>
	<input type="hidden" name="allot_status" value="1" required>
	<div class="row">
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="status_date">Date Of Allotment<span class="text-danger">*</span></label>
			<input type="date" class="form-control" id="status_date" name="status_date" required />
			<p class="hint">Enter date of allotment of sim</p>
		</div>
		<div class="form-group col-lg-12 col-sm-6 mb-3">
			<label for="alloted_user">Select Employee<span class="text-danger">*</span></label>
			<select name="alloted_user" id="alloted_user" class="form-select select2" required>
				<option value="">Select Employee</option>
				<?php if(count($employee_list) > 0){ foreach($employee_list as $emp_list){ ?>
				<option value="<?php echo $emp_list['id']; ?>"><?php echo $emp_list['emp_no'];?> - <?php echo $emp_list['full_name'] .' ['.$emp_list['sim_count'].']'; ?></option>
				<?php }}else{ echo '<option value="">No unalloted employee, add new employee first</option>';} ?>
			</select>
		</div>
		<div class="form-group col-lg-3 col-md-12 col-12 mb-3">
			<input type="submit" value="Update" class="form-control btn btn-custom-success" />
		</div>
	</div>
</form>
<?php } ?>
<?php if($type == 'unallotment'){ ?>
	<form id="unallotment_form" action="<?php echo base_url('admin/sim/save-allotment'); ?>" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="sim_id" value="<?php echo $id;?>" required>
	<input type="hidden" name="type" value="<?php echo $type;?>" required>
	<input type="hidden" name="allot_status" value="2" required>
	<input type="hidden" name="alloted_user" value="<?php echo $sim_detail->alloted_user;?>" required>
	<div class="row">
		<div class="col-md-12 col-sm-12 mb-3 form-group">
			<label for="status_date">Date Of <?php echo ucfirst($type); ?><span class="text-danger">*</span></label>
			<input type="date" class="form-control" id="status_date" name="status_date" required />
			<p class="hint">Enter date of <?php echo $type; ?> of sim</p>
		</div>
		<div class="form-group col-lg-3 col-md-12 col-12 mb-3">
			<input type="submit" value="Update" class="form-control btn btn-custom-success" />
		</div>
	</div>
</form>
<?php } ?>

<script>
    $(".select2").select2();
</script>