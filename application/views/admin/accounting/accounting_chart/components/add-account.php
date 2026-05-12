<div class="add-account-form">	
	<form action="<?php echo base_url('admin/chart-of-accounts/form-submit'); ?>" method="POST" class="needs-validation" id="addAccountForm" data-parsley-validate>
		<input type="hidden" name="folderid" value="" required />
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label class="form-label" for="account_type">Account Type <span class="text-danger">*</span></label>
					<select class="form-select" id="account_type" name="account_type" required="">
						<option value="1">Sub-Account</option>
						<option value="0">Main Account</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="mb-3 loader-input">
					<div class="spinner-border text-secondary m-1" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<label for="code" class="form-label">Code <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="code" name="code" onblur="checkDuplicateCode()" required="">
				</div>
			</div>
			<div id="codeResponse"></div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label for="branch_name" class="form-label">Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="branch_name" name="branch_name" required="">
				</div>
			</div>
			<div class="col-lg-6 mb-3">
				<label for="main_account">Main Account <span class="text-danger">*</span></label>
				<select name="main_account" id="main_account" class="form-select select2" required>
					<option value="0">Main Account</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label for="choose-type" class="form-control-label">Type <span class="text-danger">*</span></label>
				<div id="choose-type" class="">
					<label class="radio-inline me-4">
					<input class="radio-inline me-2" type="radio" name="journal_cat_type" checked="" value="credit">Credit</label>
					
					<label class="radio-inline me-4">
					<input class="radio-inline me-2" type="radio" name="journal_cat_type" value="debit">Debit</label>
					
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
		var account_type = $("#account_type").find('option:selected').val();
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
</script>
