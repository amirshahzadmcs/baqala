<style> 
.tab-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div class="modal fade fixed-left requestModal" aria-labelledby="#requestModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-aside">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="requestModalFullscreenLabel">New Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				
            </div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-md-12">
						<button form="request_form" type="submit" id="save_request_btn" class="btn btn-success btn-md">Save</button>
						<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
					</div>
				</div>
			</div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script> 
function addRequestForm(identifier) {
	let emp_id = $(identifier).data('empid');
	let requesttype = $(identifier).data('requesttype');
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('admin/hr-module/employees/Employee/add_request_form');?>",
		data: {'emp_id': emp_id, 'request_type':requesttype},
		//dataType: "json",
		success: function (response) {
			//console.log(response);
			$('.requestModal').modal('show');
			$('.requestModal .modal-body').html(response);
			$('#requestModalFullscreenLabel').html(requesttype);
		},
		error: function (request, error) {
			console.log(" Can't do because: " + JSON.stringify(request));
			$('.requestModal .modal-body').after(JSON.stringify(request));
		},
	});
}
</script>
