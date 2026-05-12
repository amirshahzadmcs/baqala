<div class="mt-2">
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Payment Request Detail</div>
        <div class="d-flex align-items-center employee-detail">
            <div class="p-3 w-100">
                <h5 class="mb-0 mt-0"> <?php echo $payment->request_name;?> </h5>
				<?php
					if($payment->request_for_type == 'employee'){
						$deptDetail = departmentsDetailHelper($payment->department);
						$departName = $deptDetail->name;
					}else{
						$departName = 'NA';
					}
				?>
                <span><?php echo ucfirst($payment->request_for_type);?> | <?php echo $departName;?></span>
                <hr class="my-1">
                <table>
                    <tr>
                        <td>Method of Payment</td>
                        <td> : </td>
                        <td><?php echo $payment->method_of_payment;?></td>
                    </tr>
                    <tr>
                        <td>Type of Payment</td>
                        <td> : </td>
                        <td><?php echo $payment->type_of_payment;?></td>
                    </tr>
                    <tr>
                        <td>Cost Center</td>
                        <td> : </td>
                        <td><?php echo $payment->cost_center;?></td>
                    </tr>
					<tr>
						<td>Bank Name</td>
						<td> : </td>
						<td><?php echo $payment->bank_name;?></td>
					</tr>
                    <tr>
                        <td>IBAN</td>
                        <td> : </td>
                        <td><?php echo $payment->iban_no;?></td>
                    </tr>
                    <tr>
                        <td>Amount</td>
                        <td> : </td>
                        <td><?php echo $payment->amount;?> <?php echo ucfirst($payment->currency);?></td>
                    </tr>
                    <tr>
                        <td>Requester</td>
                        <td> : </td>
                        <td><?php echo $payment->request_name;?></td>
                    </tr>
                    <tr>
                        <td>Request Date</td>
                        <td> : </td>
                        <td><?php echo date('d-m-Y', strtotime($payment->request_date));?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="size-inner-section px-1 py-1 mx-1">
        <div class="card-header">Update Payment Details</div>
        <?php echo form_open("admin/finance/payment-request/payment-update", array("id" => "editPaymentForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
            <input type="hidden" id="id" name="id" value="<?php echo $payment->id;?>" required />
            <div class="row p-2">
				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="finance_Payment_details">Bank <span class="text-danger">*</span></label>
					<div style="border: 1px dashed #ccc;padding: 7px;border-radius: 5px;">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank1" value="Al Rajhi">
							<label class="form-check-label" for="bank1">Al Rajhi</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank2" value="STC Bank">
							<label class="form-check-label" for="bank2">STC Bank</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="finance_Payment_bank" id="bank3" value="Petty Cash">
							<label class="form-check-label" for="bank3">Petty Cash</label>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-sm-12 mb-3 form-group">
					<label for="bank_ref_no">Bank Reference No</label>
					<input type="text" class="form-control" id="bank_ref_no" name="finance_bank_ref" maxlength="120" />
				</div>

				<div class="col-md-6 col-sm-12 mb-3 form-group">
					<label for="finance_payment_date">Bank Payment Date <span class="text-danger">*</span></label>
					<input type="date" class="form-control" id="finance_payment_date" name="finance_payment_date" max="<?php echo date('Y-m-d');?>" required />
				</div>

				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="daftra_reference">Daftra Reference</label>
					<input type="text" class="form-control" id="daftra_reference" name="daftra_reference" maxlength="120" />
				</div>

				<div class="col-md-12 col-sm-12 mb-3 form-group">
					<label for="request_status">Status <span class="text-danger">*</span></label>
					<select name="request_status" id="request_status" class="form-select select2" required>
						<option value="">Select Status Type</option>
						<option value="paid" <?php echo ($payment->request_status == 'paid') ? 'selected' : ''; ?>>Paid</option>
						<option value="cancelled" <?php echo ($payment->request_status == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
					</select>
				</div>
				
				<div class="col-md-12 col-sm-12 form-group">
					<label for="attachment">Attachment <span class="text-danger required-field"></span></label>
					<input type="file" name="attachment" id="attachment" class="dropify"
						accept="image/png, image/jpeg, image/jpg, image/gif, image/svg, image/webp"
						data-max-file-size="2M" data-height="100">
				</div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
	$(document).ready(function() {
		$('.dropify').dropify();

		// Handle the request_status change event
        $('#request_status').change(function() {
            const selectedStatus = $(this).val();
            const attachmentField = $('#attachment');
            if (selectedStatus === 'paid') {
                attachmentField.attr('required', true);
                $('.required-field').html('*');
            } else {
                attachmentField.removeAttr('required');
				$('.required-field').html('');
            }
        });

		// Handle form submission
		$('#editPaymentForm').submit(function(e) {
			e.preventDefault();
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: '<?php echo base_url('admin/finance/payment-request/payment-update');?>',
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				success: function(response) {
					if (response.type === 'success') {
						initializeDataTable();
						toastr.success(response.message);
						$('#formRequestModal').modal('hide');
						resetModalData();
					} else {
						//console.log("Error:", response.message);
						toastr.error(response.message);
					}
				},
				error: function() {
					toastr.error('An error occurred. Please try again.');
				}
			});
		});
	});
</script>
