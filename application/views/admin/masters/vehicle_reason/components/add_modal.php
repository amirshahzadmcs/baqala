<div class="modal-header">
	<h5 class="modal-title mt-0" id="reasonModalLabel">Add Vehicle Reasons</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<?php echo form_open("admin/master/vehicle-reason/save", array("id"=>"reasonForm", "class"=>"form-horizontal form-label-left")); ?>
		<input type="hidden" id="id" name="id" value="">
		<input type="hidden" id="reason_type" name="reason_type" value="vehicle_reason" required>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group mb-2">
					<label class="control-labe" for="reason_title_en">Reason Title (EN)<span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="reason_title_en" name="reason_title_en" required="required" />
				</div>
			</div>
			
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group mb-2">
					<label class="control-labe" for="reason_title_ar">Reason Title (AR)</label>
					<input type="text" class="form-control rtl-input" id="reason_title_ar" rows="3" name="reason_title_ar" required="required" />
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="modal-footer">
	<button type="submit" form="reasonForm" class="btn btn-custom-success">Save</button>
</div>