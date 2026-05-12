<div class="add-account-form">	
	<form action="<?php echo base_url('admin/chart-of-accounts/update-submit'); ?>" id="editAccountForm" method="POST" class="needs-validation" data-parsley-validate>
	    <input type="hidden" name="main_account" id="main_account" value="<?php echo $detail['main_account'];?>" required />
		<input type="hidden" name="folderid" id="folderid" value="<?php echo $detail['branch_id'];?>" required />
		<input type="hidden" name="account_type" id="account_type" value="<?php echo $detail['account_type'];?>" required />
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3 loader-input">
					<div class="spinner-border text-secondary m-1" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<label for="code" class="form-label">Code <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="code" name="code" onblur="checkDuplicateCode()" value="<?php echo $detail['code'];?>" required="">
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3">
					<label for="branch_name" class="form-label">Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo $detail['branch_name'];?>" required="">
				</div>
			</div>
			<div id="codeResponse"></div>
		</div>
		
		<div class="row">
			<div class="form-group">
				<label for="choose-type" class="form-control-label">Type <span class="text-danger">*</span></label>
				<div id="choose-type" class="">
					<label class="radio-inline me-4">
					<input class="radio-inline me-2" type="radio" name="journal_cat_type" <?php echo ($detail['journal_cat_type'] == 'credit') ? ' checked ' : ''; ?> value="credit">Credit</label>
					
					<label class="radio-inline me-4">
					<input class="radio-inline me-2" type="radio" name="journal_cat_type" <?php echo ($detail['journal_cat_type'] == 'debit') ? ' checked ' : ''; ?> value="debit">Debit</label>
					
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-9"></div>
			<div class="col-md-3">
				<div class="mb-3 pull-right">
					<button type="submit" class="btn btn-success mt-2 form-control" id="addAccountBtn" disabled>Submit</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
    $(".select2").select2();

	function checkDuplicateCode() {
		var account_type = $("#account_type").val();
		var code = $("#code").val();
		var id = $("#folderid").val();
		$(".loader-input .spinner-border").addClass('d-block');
		if (code !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/chart-of-accounts/check-code",
				type: "GET",
				data: {
					account_type: account_type,
					code: code,
					id: id,
				},
				dataType: "json",
				success: function (data) {
					console.log(data);
					if(data.status == 'success'){
						$("#codeResponse").html(data.msg);
						$(".loader-input .spinner-border").removeClass('d-block');
						$('#addAccountBtn').prop("disabled", false);
					}else{
						$("#code").val('');
						$(".loader-input .spinner-border").removeClass('d-block');
						$("#codeResponse").html(data.msg);
						return false;
					}
				},
				error: function (data) {
					console.log(data);
					$("#code").val('');
					$(".loader-input .spinner-border").removeClass('d-block');
					$("#codeResponse").html('<p style="display: block;" class="alert alert-danger">Something went wrong, try again</p>');
					return false;
				},
			});
		} else {
			$("#code").addClass('parsley-error');
			$(".loader-input .spinner-border").removeClass('d-block');
			$("#codeResponse").html('<p style="display: block;" class="alert alert-danger">Code field is mandantory.</p>');
		}
	}

	$(document).ready(function() {
		$('#editAccountForm').on('input change', function() {
			$('#addAccountBtn').prop("disabled", false);
		});
	})
</script>
