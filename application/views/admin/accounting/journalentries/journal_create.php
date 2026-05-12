<?php $this->load->view('admin/home/header'); ?>

<style>
	.required-field {
		color: #f00;
	}

	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.credit, .debit, #totalSummary .form-control, #journal_no {
		font-weight: 600;
		color: #2e2e2e;
	}
	.uploadImage .dropzone {
		min-height: 72px;
		border: 2px dashed #ced4da;
		background: #fff;
		border-radius: 6px;
		padding: 10px 10px;
	}

	.uploadImage .dropzone .dz-message {
		text-align: center;
		margin: 0em 0;
	}

	.uploadImage .dropzone .dz-preview {
		margin: 10px;
		min-height: 80px;
	}

	.uploadImage .dropzone .dz-preview .dz-image {
		border-radius: 15px;
		overflow: hidden;
		width: 90px;
		height: 90px;
		position: relative;
		display: block;
		z-index: 10;
	}

	.uploadImage .dropzone .dz-preview .dz-details .dz-size {
		margin-bottom: 0.5em;
		font-size: 12px;
	}

	.uploadImage div#myDropzone:hover {
		border: 2px dashed #85888b;
	}

	span.ui-uploader-drop-area-text i {
		color: #0f9fe3;
		font-size: 28px;
	}

	span.ui-uploader-drop-area-text p {
		font-size: 14px;
	}

	.select2-container--default .select2-selection--single {
		border-radius: 0px !important;
	}

	#attribute .form-control, #attribute .form-select {
		border-radius: 0rem;
	}

	#attribute td {
		padding: 5px;
	}
	#attribute thead td {
		padding: 10px;
	}
	span.select2 {
		width: 100% !important;
	}
	.form-control.debit, .form-control.credit{
		width:100px;
	}
	td.newboxchange {
		width: 120px;
		background: #edf1f5;
	}
	/* .cost-center-drop ul li:last-child{
		position: absolute;bottom: 0;width: 100%;background: #f5c433;
	} */
	.main_row{
		background: #ffe8a3;
	}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif'); ?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Journal Entries</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/accounting/journal/list'); ?>">Journal Entries</a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-1" title="Back" href="<?php echo base_url('admin/accounting/journal/list'); ?>"><i class="fa fa-reply"></i> Back</a>
					<button type="submit" class="btn btn-sm btn-custom-success pull-right total" title="Save"><i class="fa fa-save"></i> Save</button>
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 2) {
				?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else {?>
				<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php }}
				$this->admin->removeInfo();?>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
		<form method="POST" action="<?php echo base_url('admin/accounting/journal/add');?>" id="journalForm" enctype="multipart/form-data">
			<div class="row">
				<div class="col-lg-12 p-0">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">Date <span class="text-danger">*</span></label>
										<div class="input-group" id="datepicker2">
											<input type="text" id="date" class="form-control" value="<?php echo date('d-m-Y'); ?>" placeholder="<?php echo date('d-m-Y'); ?>" data-date-format="d-m-yyyy" data-date-container="#datepicker2" data-provide="datepicker" data-date-autoclose="true" name="journal_date" required>
										</div>
										<div class="invalid-feedback">
											Please select a valid date.
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label class="form-label">Currency <span class="text-danger">*</span></label>
										<select class="form-control select2 p-3" id="currencysr" name="currency">
											<option value="SAR">SAR Saudi Riyal</option>
										</select>
										<div class="invalid-feedback">
											Please select a valid currency.
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="mb-3">
										<label for="journal_no" class="form-label">Number <span class="text-danger">*</span></label>
										<input type="text" class="form-control col-md-6" id="journal_no" value="<?php if (isset($journalnumber)) {
											echo invoiceNmFormat($journalnumber->id + 1);
										} else {
											echo invoiceNmFormat(1);
										} ?>" required="" name="journal_no" placeholder="<?php if (isset($journalnumber)) {echo invoiceNmFormat($journalnumber->id + 1);} else {echo invoiceNmFormat(1);} ?>" onBlur="checkDuplicateJournal()">
										<small class="hint res-msg"></small>
										<div class="valid-feedback">
											Select valid Number
										</div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="mb-3">
										<label>Description</label>
										<div>
											<textarea class="form-control" id="journal_description" rows="2" name="journal_description"></textarea>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="mb-3">
										<label>Attachments</label>
										<div class="uploadImage">
											<div class="dropzone" id="myDropzone">
												<div class="fallback">
													<input name="attachments[]" type="file" multiple />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12 p-0">
					<div class="card">
						<div class="card-body px-1">
							<table id="attribute" class="table table-bordered item_table">
								<thead>
									<tr>
										<td class="text-left">Account Name <span style="color:red;">*</span></td>
										<td class="text-left">Description</td>
										<td class="text-left" style="width: 200px !important;">Cost Center</td>
										<td class="text-left" style="width: 115px;">Tax</td>
										<td class="text-left">Debit <span style="color:red;">*</span></td>
										<td class="text-left">Credit <span style="color:red;">*</span></td>
										<td></td>
									</tr>
								</thead>
								<tbody id="mainTable">
									<?php $att_row = 2; ?>
									<?php $multi_row = 1; ?>
									<tr id="attribute-row0" class="item_row main_row">
										<td>
											<div class="custom-dropdown">
												<select class="form-select itemSearch select2 account-name" name="journal_account_id[]" required>
													<option value="">-- Select account --</option>
												</select>
											</div>
										</td>
										<td>
											<textarea required="" class="form-control description" rows="5" style="height: 17px;" name="description[]"></textarea>
										</td>
										<td>
											<div class="custom-dropdown">
												<select class="form-select select2 cost-center-select" name="cost_center[]" style="width: 200px;">
													<option value="">None</option>
													<?php foreach($costcenters as $costcent){ ?>
													<option value="<?php echo $costcent['code'];?>"><?php echo '#'.$costcent['code'] .'-'. $costcent['name'];?></option>
													<?php } ?>
												</select>
											</div>
										</td>
										<td>
											<select class="form-select tax-select" name="tax_id[]" style="width:115px;">
												<option value="" data-per="0" data-id="tax_none">-</option>
												<?php foreach(taxHelper() as $mTax){ ?>
												<option value="<?php echo $mTax->id;?>" data-per="<?php echo $mTax->tax_percent;?>" data-id="tax_<?php echo $mTax->id;?>"><?php echo $mTax->title_en;?>(%<?php echo $mTax->tax_percent;?>)<?php echo $mTax->title_ar;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input type="hidden" class="tax_debit" required="" name="tax_debit[]" data-taxid="" value="0">
											<input type="text" class="form-control debit" required="" name="debit[]">
										</td>
										<td>
											<input type="hidden" class="tax_credit" required="" name="tax_credit[]" data-taxid="" value="0">
											<input type="text" class="form-control credit" required="" name="credit[]">
										</td>
										<td align="center">
											<button type="button" onclick="remove_attribute(0);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
										</td>
									</tr>
									<tr id="attribute-row1" class="item_row main_row">
										<td>
											<div class="custom-dropdown">
												<select class="form-select itemSearch select2" name="journal_account_id[]">
													<option value="">-- Select account --</option>
												</select>
											</div>
										</td>
										<td>
											<textarea required="" class="form-control description" rows="5" style="height: 17px;" name="description[]"></textarea>
										</td>
										<td>
											<div class="custom-dropdown">
												<select class="form-select select2 cost-center-select" name="cost_center[]" style="width: 200px;">
													<option value="">None</option>
													<?php foreach($costcenters as $costcent){ ?>
													<option value="<?php echo $costcent['code'];?>"><?php echo '#'.$costcent['code'] .'-'. $costcent['name'];?></option>
													<?php } ?>
												</select>
											</div>
										</td>
										<td>
											<select class="form-select tax-select" name="tax_id[]" style="width:115px;">
												<option value="" data-per="0" data-id="tax_none">-</option>
												<?php foreach(taxHelper() as $mTax){ ?>
												<option value="<?php echo $mTax->id;?>" data-per="<?php echo $mTax->tax_percent;?>" data-id="tax_<?php echo $mTax->id;?>"><?php echo $mTax->title_en;?>(%<?php echo $mTax->tax_percent;?>)<?php echo $mTax->title_ar;?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<input type="hidden" class="tax_debit" required="" name="tax_debit[]" data-taxid="" value="0">
											<input type="text" class="form-control debit" required="" name="debit[]">
										</td>
										<td>
											<input type="hidden" class="tax_credit" required="" name="tax_credit[]" data-taxid="" value="0">
											<input type="text" class="form-control credit" required="" value="" name="credit[]">
										</td>
										<td align="center">
											<button type="button" onclick="remove_attribute(1);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td valign="top"><button type="button" onclick="addAttribute();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add</button></td>
										<td colspan="5">
											<table align="right" id="totalSummary">
												<tr class="d-none" id="row_wt">
													<td align="right"><strong>Total Without Tax</strong></td>
													<td class="newboxchange"><input type="text" class="form-control" name="debit_wt_total" id="dwt" value="0.00" readonly style="max-width: 110px;"> </td>
													<td class="newboxchange"><input type="text" class="form-control" name="credit_wt_total" id="cwt" value="0.00" readonly style="max-width: 110px;"></td>
												</tr>
												<tr>
													<td align="right"><strong>Total</strong></td>
													<td class="newboxchange"><input type="text" class="form-control" name="debit_total" id="dt" value="0.00" readonly style="max-width: 110px;"> </td>
													<td class="newboxchange"><input type="text" class="form-control" name="credit_total" id="ct" value="0.00" readonly style="max-width: 110px;"></td>
												</tr>
											</table>
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>

			</div>
		</form>
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer'); ?>

<script type="text/javascript">

	function checkDuplicateJournal() {
		var journal_no = $("#journal_no").val();
		if (journal_no !== "") {
			$.ajax({
				url: "<?php echo base_url();?>admin/accounting/journal/check-duplicate",
				type: "GET",
				data: "journal_no=" + $("#journal_no").val(),
				dataType: "json",
				success: function (data) {
					if(data.status == 'success'){
						$(".res-msg").html(data.msg);
					}else{
						$("#journal_no").val('');
						$(".res-msg").html(data.msg);
						return false;
					}
				},
				error: function () {
					$("#journal_no").val('');
					return false;
				},
			});
		} else {
			checkField("journal_no");
		}
	}

	function checkField(u){
		var id = $("#"+u).val();
		if(id == ""){
			$("#"+u).addClass("alert_text");
		}
		else{
			$("#"+u).removeClass("alert_text");
		}
	}

	var attribute_row = <?php echo $att_row; ?>;
	
	function addAttribute() {
		html = '<tr id="attribute-row' + attribute_row + '" class="item_row main_row">';
		html += '  <td style="width:25%;"><select class="form-select itemSearch select2 account-name" name="journal_account_id[]"><option value="">-- Select account --</option></select></td>';
		html += '  <td style="width:25%;"><textarea required="" class="form-control description" rows="5" style="height: 17px;" name="description[]"></textarea></td>';
		html += '<td style="width:20%;"><select class="form-select select2 cost-center-select" name="cost_center[]" style="width: 200px;"><option value="">None</option><?php foreach($costcenters as $costcent){ ?><option value="<?php echo $costcent['code'];?>"><?php echo '#'.$costcent['code'] .'-'. $costcent['name'];?></option><?php } ?></select></td>';
		html += '  <td><select class="form-select tax-select" name="tax_id[]" style="width:115px;"><option value="" data-per="0" data-id="tax_none">-</option><?php foreach(taxHelper() as $mTax){ ?><option value="<?php echo $mTax->id;?>" data-per="<?php echo $mTax->tax_percent;?>" data-id="tax_<?php echo $mTax->id;?>"><?php echo $mTax->title_en .' ';?> (%<?php echo $mTax->tax_percent .' ';?>) <?php echo $mTax->title_ar;?></option><?php } ?></select></td>';
		html += '  <td><input type="hidden" class="tax_debit" required="" name="tax_debit[]" value="0" data-taxid=""><input type="text" class="form-control debit" required="" name="debit[]"></td>';
		html += '  <td><input type="hidden" class="tax_credit" required="" name="tax_credit[]" value="0" data-taxid=""><input type="text" class="form-control credit" required="" name="credit[]"></td>';
		html += '  <td align="right"><button type="button" onclick="remove_attribute(' + attribute_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
		$('#attribute #mainTable').append(html);
		$(".cost-center-select").select2({
			dropdownCssClass: "cost-center-drop"
		});
		attribute_row++;
		$(".itemSearch").select2({
			tags: false,
			multiple: false,
			tokenSeparators: [',', ' '],
			minimumInputLength: 2,
			minimumResultsForSearch: 10,
			cache: true,
			placeholder: 'Search for a account...',
			ajax: {
				url: "<?php echo base_url(); ?>admin/accounting/journal/searchaccount",
				dataType: 'json',
				data: function (params) {
					var query = {
						search: params.term,
						type: 'account_search'
					}
					//console.log(params);
					// Query parameters will be ?search=[term]&type=user_search
					return query;
				},
				processResults: function (data) {
					return {
						results: $.map(data, function (item) {
							return {
								//text: item.name+', '+item.state.name+', '+item.state.coutry.name,
								text: '#'+item.code+' - '+item.branch_name,
								id: item.branch_id
							}
						})
					};
				}
			}
		});
	}

	function remove_attribute(u) {
		$('#attribute-row' + u).remove();
		$('#trmultiple_' + u).remove();
		calculateTax();
	}

	function multiCenter(id){
		if(id !== ''){
			var req_tr = 'attribute-row'+id;
			var selMultiCenter = $('#'+req_tr +' .cost-center-select').find(":selected").val();
			//alert(conceptName);
			if(selMultiCenter == 'multiple'){
				$.ajax({
					type: "get",
					url: "<?php echo base_url();?>admin/Accounting/Journal/multi_center",
					data: {'id': id},
					//dataType: "json",
					success: function (response) {
						//console.log(response);
						$('#'+req_tr).addClass(' active-tr');
						$('#'+req_tr).after(response);
					},
					error: function (request, error) {
						//console.log(" Can't do because: " + JSON.stringify(request));
						$('#'+req_tr).after(JSON.stringify(request));
					},
				});
			}
		}else{
			alert('Invalid request id!');
		}
	}

	/*---- Multi Select ----*/
	var multi_row = <?php echo $multi_row; ?>;
	function addMultiSingle(centerTableId) {
		html = '<tr id="multi-row' + centerTableId +'_'+ multi_row + '" class="item_row">';
		html += '  <td style="width:25%;"><div class="custom-dropdown"><select class="form-select select2 multi-center-select" name="data[CostCenterTransactionV2]['+ centerTableId +']['+ multi_row +'][cost_center]" style="width: 200px;"><option value="">None</option><?php foreach($costcenters as $costcent){ ?><option value="<?php echo $costcent['code'];?>"><?php echo '#'.$costcent['code'] .'-'. $costcent['name'];?></option><?php } ?></select></div></td>';
		html += '  <td style="width:25%;"><div class="input-group"><input type="text" class="form-control debit" required="" name="data[CostCenterTransactionV2]['+ centerTableId +']['+ multi_row +'][tax_percent]"><span class="input-group-text input-group-append">%</span></div></td>';
		html += '  <td><input type="text" class="form-control amount" required="" name="data[CostCenterTransactionV2]['+ centerTableId +']['+ multi_row +'][amount]"></td>';
		html += '  <td align="right"><button type="button" onclick="removeMultiSingle(' + centerTableId +','+ multi_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
		html += '</tr>';
		$('#multipleTable'+centerTableId +' tbody').append(html);
		$(".multi-center-select").select2({
			placeholder: 'Select an option'
		});
		multi_row++;
	}

	function removeMultiSingle(u,r) {
		//alert('#multi-row' + u +'_'+r);
		$('#multi-row' + u +'_'+r).remove();
	}

	function removeMultiFirst(u) {
		$('#multi-row' + u).remove();
	}

	function removeMultiAll(u) {
		$('#trmultiple_' + u).remove();
	}

	/*----- END ----*/

	$(".cost-center-select").select2({
		dropdownCssClass: "cost-center-drop"
	});
	
	$(document).on("change", ".debit", function() {
		$(this).parent().next().find('.credit').val('0');
		var debit_row = $(this).val();
		var credit_row = $(this).parent().next().find('.credit').val();
		var sel_row = $(this).parent().parent().attr('id');
		var tax_data_per = $(this).parent().parent().find('.tax-select :selected').data('per');
		var tax_data_id = $(this).parent().parent().find('.tax-select :selected').data('id');
		//alert(tax_data_id);
		if(tax_data_per != 'undefined'){
			if(debit_row > credit_row){
				var row_debit_percent = (debit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_debit').val(row_debit_percent);
				$('#'+sel_row+' td .tax_debit').attr("data-taxid",'debit_'+tax_data_id);
				$('#'+sel_row+' td .tax_credit').val('0');
				$('#'+sel_row+' td .tax_credit').attr("data-taxid",'');
			}else{
				var row_credit_percent = (credit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_credit').val(row_credit_percent);
				$('#'+sel_row+' td .tax_credit').attr("data-taxid",'credit_'+tax_data_id);
				$('#'+sel_row+' td .tax_debit').val('0');
				$('#'+sel_row+' td .tax_debit').attr("data-taxid",'');
			}
		}
		calculateTax();
	});

	$(document).on("change", ".credit", function() {
		$(this).parent().prev().find('.debit').val('0');
		var debit_row = $(this).parent().prev().find('.debit').val();
		var credit_row = $(this).val();
		var sel_row = $(this).parent().parent().attr('id');
		var tax_data_per = $(this).parent().parent().find('.tax-select :selected').data('per');
		var tax_data_id = $(this).parent().parent().find('.tax-select :selected').data('id');
		//alert(tax_data_id);
		if(tax_data_per != 'undefined'){
			if(credit_row > debit_row){
				var row_credit_percent = (credit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_credit').val(row_credit_percent);
				$('#'+sel_row+' td .tax_credit').attr('data-taxid','credit_'+tax_data_id);
				$('#'+sel_row+' td .tax_debit').val('0');
				$('#'+sel_row+' td .tax_debit').attr("data-taxid",'');
			}else{
				var row_debit_percent = (debit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_debit').val(row_debit_percent);
				$('#'+sel_row+' td .tax_debit').attr('data-taxid','debit_'+tax_data_id);
				$('#'+sel_row+' td .tax_credit').val('0');
				$('#'+sel_row+' td .tax_credit').attr("data-taxid",'');
			}
		}
		calculateTax();
	});

	function calculateTax(){
		var totalTax = 0;
		var credit_sum = 0;
		var debit_sum = 0;
		var tax_credit_sum = 0;
		var tax_debit_sum = 0;

		$('.tax-select').each(function(){
			totalTax += +$(this).val();
		});

		if($('.tax-select').length && (totalTax > 0)){
			//alert('Yes '+$('.tax-select').val().length);
			
			$(".tax_credit").each(function() {
				tax_credit_sum += +$(this).val();
			});
			$(".tax_debit").each(function() {
				tax_debit_sum += +$(this).val();
			});
			$(".credit").each(function() {
				credit_sum += +$(this).val();
			});
			$(".debit").each(function() {
				debit_sum += +$(this).val();
			});
			//alert(credit_sum);
			$("#dwt").val(parseFloat(debit_sum).toFixed(2));
			$("#cwt").val(parseFloat(credit_sum).toFixed(2));
			$("#row_wt").removeClass('d-none');
		}else{
			//alert('No '+$('.tax-select').val().length);
			$("#dwt").val('0');
			$("#cwt").val('0');
			$(".credit").each(function() {
				credit_sum += +$(this).val();
			});
			$(".debit").each(function() {
				debit_sum += +$(this).val();
			});
			$("#row_wt").addClass('d-none');
		}
		calculateTaxBreaks();
		$("#ct").val(parseFloat(credit_sum + tax_credit_sum).toFixed(2));
		$("#dt").val(parseFloat(debit_sum + tax_debit_sum).toFixed(2));
		setPlaceholder();
	}

	$(document).on("change", ".tax-select", function() {
		var tax_id = $(this).val();
		var tax_data_per = $(this).find(':selected').data('per');
		var tax_data_id = $(this).find(':selected').data('id');
		var tax_data_txt = $(this).find(':selected').text();
		var debit_row = $(this).parent().next().find('.debit').val();
		var credit_row = $(this).parent().next().next().find('.credit').val();
		var sel_row = $(this).parent().parent().attr('id');
		var totalTax = 0;
		var credit_sum = 0;
		var debit_sum = 0;
		var tax_credit_sum = 0;
		var tax_debit_sum = 0;
		$('.tax-select').each(function(){
			totalTax += +$(this).val();
		});
		//alert(tax_data_txt);
		if($('.tax-select').length && (totalTax > 0)){
			//alert('Yes '+$('.tax-select').val().length);
			if(debit_row > credit_row){
				var row_debit_percent = (debit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_debit').val(row_debit_percent);
				$('#'+sel_row+' td .tax_debit').attr('data-taxid','debit_'+tax_data_id);
			}else{
				var row_credit_percent = (credit_row/100)*tax_data_per;
				$('#'+sel_row+' td .tax_credit').val(row_credit_percent);
				$('#'+sel_row+' td .tax_credit').attr('data-taxid','credit_'+tax_data_id);
			}
			$(".tax_credit").each(function() {
				tax_credit_sum += +$(this).val();
			});
			$(".tax_debit").each(function() {
				tax_debit_sum += +$(this).val();
			});
			$(".credit").each(function() {
				credit_sum += +$(this).val();
			});
			$(".debit").each(function() {
				debit_sum += +$(this).val();
			});
			if($('#totalSummary').find('tr#'+tax_data_id).length){    
				//$('table#totalSummary tr#'+tax_data_id).remove();
			}else{
				if(tax_data_id == 'tax_none'){
					
				}else{
					$('table#totalSummary tr:last').before('<tr class="total_tax_inputs" id="'+tax_data_id+'"><td align="right"><strong>'+ tax_data_txt +'</strong></td><td class="newboxchange"><input type="text" class="form-control" name="tax_total[]" id="debit_'+tax_data_id+'" value="0.00" readonly style="max-width: 110px;"> </td><td class="newboxchange"><input type="text" class="form-control" name="credit_total" id="credit_'+tax_data_id+'" value="0.00" readonly style="max-width: 110px;"></td></tr>');
				}
			}
			//alert(credit_sum);
			$("#dwt").val(parseFloat(debit_sum).toFixed(2));
			$("#cwt").val(parseFloat(credit_sum).toFixed(2));
			$("#row_wt").removeClass('d-none');
		}else{
			//alert('No '+$('.tax-select').val().length);
			$("#dwt").val('0');
			$("#cwt").val('0');
			$(".credit").each(function() {
				credit_sum += +$(this).val();
			});
			$(".debit").each(function() {
				debit_sum += +$(this).val();
			});
			$('table#totalSummary tr.total_tax_inputs').remove();
			$("#row_wt").addClass('d-none');
		}
		calculateTaxBreaks();
		$("#ct").val(parseFloat(credit_sum + tax_credit_sum).toFixed(2));
		$("#dt").val(parseFloat(debit_sum + tax_debit_sum).toFixed(2));
		setPlaceholder();
	});

	function calculateTaxBreaks(){
		var selTaxArray = new Array();
		$('.tax-select').each(function(){
			selTaxArray.push($(this).find(':selected').data('id'));
		});
		$('.total_tax_inputs').each(function(){
			var seltaxinp = $(this).attr('id');
			//console.log(selTaxArray);
			if(jQuery.inArray(seltaxinp, selTaxArray) != -1) {
				
			} else {
				$('table#totalSummary tr#'+seltaxinp).remove();
			}
		});
		$('.total_tax_inputs').each(function(){
			var seltaxinp = $(this).attr('id');
			if($('.total_tax_inputs').length) {
				var credit_tax_sum = 0;
				var debit_tax_sum = 0;
				$('.tax_credit[data-taxid="credit_'+ seltaxinp +'"]').each(function() {
					credit_tax_sum += +$(this).val();
				});
				$('.tax_debit[data-taxid="debit_'+ seltaxinp +'"]').each(function() {
					debit_tax_sum += +$(this).val();
				});
				$('#credit_'+ seltaxinp).val(parseFloat(credit_tax_sum).toFixed(2));
				$('#debit_'+ seltaxinp).val(parseFloat(debit_tax_sum).toFixed(2));
			}
		});
	}

	function setPlaceholder(){
		var debit = $("#dt").val();
		var credit = $("#ct").val();
		var rest_amt = 0;
		if(debit != credit) {
		    var lastTrIndex = $('#mainTable tr:last').index() + 1;
			if (lastTrIndex % 2 === 0) { /* we are even */ }
			else { addAttribute(); }
			if(debit > credit){
				rest_amt = debit - credit;
				$('tbody#mainTable tr:last td input.credit').attr('placeholder',rest_amt);
				$('tbody#mainTable tr:last td input.debit').attr('placeholder','');
			}else{
				rest_amt = credit - debit;
				$('tbody#mainTable tr:last td input.debit').attr('placeholder',rest_amt);
				$('tbody#mainTable tr:last td input.credit').attr('placeholder','');
			}
		}else{
			$('tbody#mainTable tr:last td input.debit').attr('placeholder','');
			$('tbody#mainTable tr:last td input.credit').attr('placeholder','');
		}
	}

	$(".total").on("click", function() {
		var debit = $("#dt").val();
		var credit = $("#ct").val();
		if (debit != credit) {
			alert("Total Credit value and Debit value should equal.");
		} else {
			var number = $("#journal_no").val();
			var currency = $("#currencysr").val();
			var date = $("#date").val();
			var account_name = $(".account-name").val();
			var costcenter = $(".costcenter").val();
			var debit = $(".debit").val();
			var credit = $(".credit").val();

			if ((number != "") && (currency != "") && (date != "") && (account_name != "") && (debit != "") && (credit != "")) {
				$("#journalForm").trigger("submit");

			} else {
				alert('Fill all required fields');
			}
		}
	});

	$(".itemSearch").select2({
		tags: false,
		multiple: false,
		tokenSeparators: [',', ' '],
		minimumInputLength: 2,
		minimumResultsForSearch: 10,
		cache: true,
        placeholder: 'Search for a account...',
        ajax: {
			delay: 250, // wait 250 milliseconds before triggering the request
            url: "<?php echo base_url(); ?>admin/accounting/journal/searchaccount",
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    type: 'account_search'
                }
				//console.log(params);
                // Query parameters will be ?search=[term]&type=user_search
                return query;
            },
            processResults: function (data) {
				//console.log(data);
				return {
					results: $.map(data, function (item) {
						return [
							//text: item.name+', '+item.state.name+', '+item.state.coutry.name,
							{
								text: '#'+item.code+' - '+item.branch_name,
								id: item.branch_id,
							}
						]
					})
				};
			}
        }
    });
	/*
	$(".itemSearch").select2({
		ajax: {
			url: "https://api.github.com/search/repositories",
			dataType: 'json',
			delay: 250,
			data: function (params) {
			return {
				q: params.term, // search term
				page: params.page
			};
			},
			processResults: function (data, params) {
			// parse the results into the format expected by Select2
			// since we are using custom formatting functions we do not need to
			// alter the remote JSON data, except to indicate that infinite
			// scrolling can be used
			params.page = params.page || 1;

			return {
				results: data.items,
				pagination: {
				more: (params.page * 30) < data.total_count
				}
			};
			},
			cache: true
		},
		placeholder: 'Search for a repository',
		minimumInputLength: 1,
		templateResult: formatRepo,
		templateSelection: formatRepoSelection
		});

		function formatRepo (repo) {
		if (repo.loading) {
			return repo.text;
		}

		var $container = $(
			"<div class='select2-result-repository clearfix'>" +
			"<div class='select2-result-repository__avatar'><img src='" + repo.owner.avatar_url + "' /></div>" +
			"<div class='select2-result-repository__meta'>" +
				"<div class='select2-result-repository__title'></div>" +
				"<div class='select2-result-repository__description'></div>" +
				"<div class='select2-result-repository__statistics'>" +
				"<div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div>" +
				"<div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div>" +
				"<div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div>" +
				"</div>" +
			"</div>" +
			"</div>"
		);

		$container.find(".select2-result-repository__title").text(repo.full_name);
		$container.find(".select2-result-repository__description").text(repo.description);
		$container.find(".select2-result-repository__forks").append(repo.forks_count + " Forks");
		$container.find(".select2-result-repository__stargazers").append(repo.stargazers_count + " Stars");
		$container.find(".select2-result-repository__watchers").append(repo.watchers_count + " Watchers");

		return $container;
	}

	function formatRepoSelection (repo) {
		return repo.full_name || repo.text;
	}
	*/
	$(".centerSearch").select2({
		tags: false,
		multiple: false,
		tokenSeparators: [',', ' '],
		minimumInputLength: 2,
		minimumResultsForSearch: 5,
		cache: true,
        placeholder: 'Search for cost center...',
        ajax: {
			delay: 250, // wait 250 milliseconds before triggering the request
            url: "<?php echo base_url(); ?>admin/accounting/journal/searchacostcenter",
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    type: 'center_search'
                }
				//console.log(params);
                // Query parameters will be ?search=[term]&type=user_search
                return query;
            },
            processResults: function (data) {
				//console.log(data);
				return {
					results: $.map(data, function (item) {
						return {
							//text: item.name+', '+item.state.name+', '+item.state.coutry.name,
							text: '#'+item.code+' - '+item.name,
							id: item.id
						}
					})
				};
			}
        }
    });

	Dropzone.autoDiscover = false;
	$("#myDropzone").dropzone({
		url: "upload.php",
		autoProcessQueue: false,
		uploadMultiple: true,
		parallelUploads: 5,
		maxFiles: 5,
		maxFilesize: 1,
		acceptedFiles: 'image/*',
		addRemoveLinks: true,
		dictDefaultMessage: '<span class="ui-uploader-drop-area-text"><p style="margin-bottom: 0;"><i class="dropzone-upload-icon mdi mdi-cloud-upload-outline"></i>&nbsp;<span style="color: #050;">&nbsp;Drop file here or&nbsp;</span><span class="text-info">Select from your computer</span></p></span>',
		success: function(file, response) {
			var imgName = response;
			file.previewElement.classList.add("dz-success");
			console.log("Successfully uploaded :" + imgName);
		},
		error: function(file, response) {
			console.log("Error in uploading :" + response);
			file.previewElement.classList.add("dz-error");
		}
	});

</script>
