<style> 
#responseContainer{
	position: fixed;
    width: 93%;
    top: 60px;
}
.size-inner-section {
	box-shadow: 0px 1px 4px #c5c5c5;
	border-radius: 5px;
	margin-bottom: 10px;
}
</style>
<div class="modal-header">
	<h5 class="modal-title mt-0">Edit Transaction Detail</h5>
	<button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body px-2">
    <form id="dl_form" action="<?php echo base_url('admin/dl-transaction/update');?>" method="post" enctype="multipart/form-data" class="form-label-left" data-parsley-validate="" accept-charset="utf-8">
        <input type="hidden" id="id" name="id" value="<?php echo $dl_detail->id;?>" required />
        <div class="row size-inner-section mx-2">
			<div class="d-flex align-items-center employee-detail">
				<div class="image">
					<?php if(!empty($dl_detail->employee_pic) && $dl_detail->employee_pic !== ''){ ?>
						<img src="<?php echo $dl_detail->employee_pic;?>" class="rounded" width="100">
					<?php }else{ ?>
						<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="100">
					<?php } ?>
				</div>
				<div class="p-3 w-100">
					<h5 class="mb-0 mt-0"> <?php echo $dl_detail->full_name;?></h5>
					<span><?php echo $dl_detail->designation_name;?> | <?php echo $dl_detail->department_name;?></span>
					<hr class="my-1">
					<table>
						<tr>
							<td>Emp No.</td>
							<td> : </td>
							<td><?php echo $dl_detail->emp_no;?></td>
						</tr>
						<tr>
							<td>DL Req. Number</td>
							<td> : </td>
							<td><?php if(!empty($dl_detail->request_no)){ echo $dl_detail->request_no;}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>DL Type</td>
							<td> : </td>
							<td><?php if(!empty($dl_detail->dl_type)){ echo $dl_detail->dl_type;}else{ echo 'NA';}?></td>
						</tr>
						<tr>
							<td>DL Req. Date</td>
							<td> : </td>
							<td><?php if(!empty($dl_detail->request_date)){ echo $dl_detail->request_date;}else{ echo 'NA';}?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div class="row size-inner-section mx-2 py-2">
			<h4>Fees & Expenses</h4><hr>
			<div class="col-md-6 col-sm-12 mb-2 form-group">
				<label for="trans_amount">Transaction Amount </label>
				<input type="text" class="form-control" id="trans_amount" name="trans_amount" value="<?php echo $dl_detail->trans_amount;?>" />
			</div>
		</div>
    </form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button form="dl_form" type="submit" class="btn btn-custom-success">Save</button>
</div>

<script>
    $(document).ready(function () {
		$('#dl_form').submit(function (e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);

			// Disable buttons
			$('#cancelBtn, #saveBtn').prop('disabled', true);
			$.ajax({
				url: '<?php echo base_url('admin/dl-transaction/update'); ?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function (response) {
					if (response.type === 'success') {
						toastr.success(response.message);
						$('#searchResult').html('');
						setTimeout(function () {
							window.location.href = "<?php echo base_url('admin/dl-transaction/list'); ?>";
						}, 1000);
					} else {
						toastr.error(response.message);
					}
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				},
				error: function () {
					toastr.error('An error occurred. Please try again.');
					$('#cancelBtn, #saveBtn').prop('disabled', false);
				}
			});
		});
	});
</script>