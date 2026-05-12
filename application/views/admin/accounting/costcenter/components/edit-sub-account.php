<div class="add-account-form">	
	<form action="<?php echo base_url('admin/cost-center/update-submit'); ?>" id="editAccountForm" method="POST" class="needs-validation" data-parsley-validate>
		<input type="hidden" name="folderid" id="folderid" value="<?php echo $detail['id'];?>" required />
		
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
					<input type="text" class="form-control" id="branch_name" name="name" value="<?php echo $detail['name'];?>" required="">
				</div>
			</div>
			<div id="codeResponse"></div>
		</div>
		
		<div class="row">
			
			<div class="col-lg-6 mb-3">
				<label for="Parent_Cost_Center">Parent Cost Center <span class="text-danger">*</span></label>
				<select name="parent_id" id="Parent_Cost_Center" class="form-select select2" required>
					<option value="0">Select One</option>
					<?php foreach($centers as $value) { ?>
					<option <?php if($detail['parent_id'] ==  $value['id']){ echo "selected";} ?> value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php } ?>
					
				</select>
			</div>
			<div class="col-md-6">
				<label></label>
				<div class="">
					<div class="form-check mt-2">
						<input class="form-check-input" type="checkbox" id="formCheck2" name="is_parent" value="<?php echo $detail['is_parent']; ?>" <?php if($detail['is_parent'] == "1"){ echo "checked";} ?>>
						<label class="form-check-label" for="formCheck2">
						Is Parent Cost Center?
						</label>
						
					</div>
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
	});
	$( "#formCheck2" ).on( "click", function() {
	if ($("#formCheck2").is(':checked')) {
  $("#formCheck2").val('1');
	}
	else{
		$("#formCheck2").val('0');
	}
} );
</script>
