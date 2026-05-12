<div class="add-account-form">	
	<form action="<?php echo base_url('admin/cost-center/form-submit'); ?>" method="POST" class="needs-validation" id="addAccountForm" data-parsley-validate>
		<input type="hidden" name="folderid" value="" required />
		<div class="row">
			<div class="col-md-6">
				<div class="mb-3">
					<label class="form-label" for="namefield">Name <span class="text-danger">*</span></label>
					<input type="text" class="form-control" id="namefield"  name="name"  required="">
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
			
			<div class="col-lg-6 mb-3">
				<label for="Parent_Cost_Center">Parent Cost Center <span class="text-danger">*</span></label>
				<select name="parent_id" id="Parent_Cost_Center" class="form-select select2" required>
					<?php 
					
					if(isset($parent_detail)){
						?>
					<option value="<?php echo $parent_detail['id']; ?>"><?php echo $parent_detail['name']; ?></option>
					<?php }?>
					<?php foreach($centers as $value) { ?>
					<option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
					<?php } ?>
					
				</select>
			</div>
			<div class="col-md-6">
                            <label></label>
                            <div class="">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="formCheck2" name="is_parent" value="0">
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
	
$( "#formCheck2" ).on( "click", function() {
	if ($("#formCheck2").is(':checked')) {
  $("#formCheck2").val('1');
	}
	else{
		$("#formCheck2").val('0');
	}
} );
	
</script>
