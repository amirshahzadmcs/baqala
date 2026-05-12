<div class="modal-header">
	<h5 class="modal-title mt-0" id="reasonModalLabel">Update Master Reasons</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<?php echo form_open("admin/master/master-reason/update", array("id"=>"reasonForm", "class"=>"form-horizontal form-label-left")); ?>
		<input type="hidden" id="id" name="id" value="<?php echo $reason_detail['id'];?>">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group mb-2">
					<label class="control-labe" for="reason_title_en">Reason Title (EN)<span class="text-danger">*</span></label>
					<textarea class="form-control" id="reason_title_en" rows="3" name="reason_title_en" required="required"><?php echo $reason_detail['reason_title_en'];?></textarea>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group mb-2">
					<label class="control-labe" for="reason_title_ar">Reason Title (AR)</label>
					<textarea class="form-control rtl-input" id="reason_title_ar" rows="3" name="reason_title_ar" required="required"><?php echo $reason_detail['reason_title_ar'];?></textarea>
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group mb-2">
					<label class="control-labe" for="reason_type">Reason Type</label>
					<select name="reason_type" class="form-select" required>
						<option value="">Select Type</option>
						<option value="suspend_reason" <?php echo ($reason_detail['reason_type'] == 'suspend_reason') ? ' selected ' : '';?>>Suspend Reason</option>
					</select>
				</div>
			</div>
			
		</div>
	<?php echo form_close(); ?>
</div>
<div class="modal-footer">
	<button type="submit" form="reasonForm" class="btn btn-custom-success">Save</button>
</div>