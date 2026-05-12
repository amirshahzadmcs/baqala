<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color: #f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	.cv-documents{
		border: 1px dashed #a9a9a9;
		padding: 6px;
		width: 130px;
		height: 130px;
		margin-top: -9px;
	}
	.image-container {
		position: relative;
		display: inline-block;
	}
	.image-container .overlay{
		opacity: 0;
	}
	.image-container:hover .overlay{
		background: #0006;
		opacity: .9;
		position: absolute;
		top: -9px;
		bottom: 0;
		width: 130px;
    	height: 130px;
	}
	.image-container:hover .edit {
		display: block;
	}
	.image-container .edit {
		padding-top: 7px;	
		padding-right: 7px;
		position: absolute;
		right: 0;
		left: 0;
		top: 20%;
		display: none;
	}

    .hideadvanced{
        display: none;
    }
    .showadvanced:focus{
        box-shadow: none !important;
    }
    td.newboxchange {
    background: #fccd42;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<?php if(isset($result))
{?>
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Journal Entries</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list">Journal Entries</a></li>
						<li class="breadcrumb-item active">Edit</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url(); ?>admin/accounting/journal/list">
                        <i class="fa fa-reply"></i> Back</a>
										&nbsp;
					<button type="submit" class="btn btn-sm btn-custom-success pull-right total" title="Save" >
                        <i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
    <form id="demo-form2" class="needs-validation" action="<?php echo base_url(); ?>admin/accounting/journal/update" method="post">
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Search</h4>
                            <!-- <form class="needs-validation" novalidate> -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Number</label>
                                        <input type="text" class="form-control col-md-6" id="validationCustom02" value="<?php echo $result->number?>" required="" name="number">
										<input type="hidden" name="entry_id" value="<?php echo $result->entry_id; ?>">
                                        <div class="valid-feedback">
                                        Number
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label  class="form-label">Currency</label>
                                        <select class="form-control select2 p-3" id="currencysr"style="height: 38px !important;" name="currency">
                                            <optgroup>
                                                <option value="<?php echo $result->currency; ?>"<?php  ($result->currency = "SR") ? "selected": "";?>>SR</option>
                                                
                                            </optgroup>
                                          
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid state.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label  class="form-label">Date</label>
                                        <div class="input-group" id="datepicker2">
                                            <input type="text" id="date" class="form-control" placeholder="dd M, yyyy" data-provide="datepicker" data-date-container="#datepicker2" data-date-format="yyyy-m-dd" data-date-multidate="true"  value="<?php echo date("d-m-Y", strtotime($result->entry_date));?>" name="startdate">
                                        </div>
                                          <div class="invalid-feedback">
                                            Please select a valid date.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label>Description</label>
                                        <div>
                                            <textarea required="" class="form-control" id="descriptiondata"rows="5" style="height: 17px;" name="desc"><?php echo $result->description?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                    <label>Attachments</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="customFile" name="filename">
                                        </div>
                                    </div>
                                </div>
                                
                                
                               
                            </div>
                            
                            
                        <!-- </form> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <table id="attribute" class="table table-striped table-bordered table-hover item_table">
                        <thead>
                            <tr>
                                <td class="text-left">Account Name <span style="color:red;">*</span></td>
                                <td class="text-left">Description</td>
                                <td class="text-left">Cost Center</td>
                                <td class="text-left">Debit <span style="color:red;">*</span></td>
                                <td class="text-left">Credit <span style="color:red;">*</span></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $att_row = 0;?>
						<?php 
						$account=getJournalAccount($result->entry_id);
						//  print_r($account);
						foreach ($account as $accountdetail)
						{?>
                            <tr id="attribute-row<?php echo $att_row; ?>" class="item_row">
                                <td style="width:25%;">
                                    <select class="form-select text-dark acc_name" style="height: 38px !important;" name="acc_name[]">
                                            <option value="<?php echo $accountdetail['account_name'];?>" selected><?php echo $accountdetail['account_name'];?></option>
                                            <option value="BAD DEBT">BAD DEBT</option>
                                            
                                    </select>
                                </td>
                                <td style="width:25%;">
                                    <div>
                                        <textarea  class="form-control description" rows="5" style="height: 17px;" name="description[]"><?php echo $accountdetail['description'];?></textarea>
                                    </div>
                                </td>
                                <td style="width:20%;">
                                    <select class="form-select costcenter" style="height: 38px !important;"  name="costcenter[]">
                                            <option value="<?php echo $accountdetail['cost_center'];?>" selected><?php echo $accountdetail['cost_center'];?></option>
                                            <option value="Any">Any</option>
                                            
                                    </select>
                                </td>
                                <td >
                                    <div>
                                    <input type="text" class="form-control col-md-6 debit"  required="" value="<?php echo $accountdetail['debit'];?>" name="debit[]">
                                    </div>
                                </td>
                                <td >
                                    <div>
                                    <input type="text" class="form-control col-md-6 credit"  required="" value="<?php echo $accountdetail['credit'];?>" name="credit[]">
                                    </div>
                                </td>
                                <td>
                                    <button type="button" onclick="remove_attribute(<?php echo $att_row;?>);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
							<?php } ?>
                            <?php $att_row = $att_row = 1;?>
							
                        </tbody>
                        <tfoot>
                            <tr>
                                <td ><button type="button" onclick="addAttribute();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add</button></td>
                                <td colspan="2"> Total</td>
                               
                                <td class="newboxchange"><input type="text" name="debit_total" id="dt"  value="<?php echo $result->debit_total?>"readonly> </td>
                                <td class="newboxchange"><input type="text" name="credit_total" id="ct"  value="<?php echo $result->credit_total?>"readonly></td>
								<td class="newboxchange"> </td>
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
<?php } ?>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	var attribute_row = <?php echo $att_row; ?>;
	function addAttribute() {
		html  = '<tr id="attribute-row' + attribute_row + '" class="item_row">';
		html += '  <td style="width:25%;"><select class="form-select acc_name" style="height: 38px !important;" name="acc_name[]"><optgroup><option value="AZ">Arizona</option><option value="CO">Colorado</option><option value="ID">Idaho</option></optgroup></select></td>';
		html += '  <td style="width:25%;"><div><textarea  class="form-control description" rows="5" style="height: 17px;" name="description[]"></textarea></div></td>';
		html += '<td style="width:20%;"><select class="form-select costcenter" style="height: 38px !important;" name="costcenter[]"><optgroup><option value="AZ">Arizona</option><option value="CO">Colorado</option><option value="ID">Idaho</option></optgroup> </select></td>';
        html += '  <td><div><input type="text" class="form-control col-md-6 debit"   name="debit[]"></div></td>';
        html += '  <td ><div><input type="text" class="form-control col-md-6 credit" name="credit[]"></div></td>';
		html += '  <td ><button type="button" onclick="remove_attribute(' + attribute_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
		$('#attribute tbody').append(html);
		attribute_row++;
	}

	function remove_attribute(u){
		$('#attribute-row'+u).remove();
		
	}
	$(document).on("change", ".debit", function() {
		//alert('hii');
    var sum = 0;
    $(".debit").each(function(){
        sum += +$(this).val();
    });
    $("#dt").val(sum);
});
	$(document).on("change", ".credit", function() {
		//alert('hii');
    var sum = 0;
    $(".credit").each(function(){
        sum += +$(this).val();
    });
    $("#ct").val(sum);
});

$(".total" ).on( "click", function() {
	var debit=$("#dt").val();
	var credit=$("#ct").val();
	if(debit != credit)
	{
		alert("Credit Total  Value And debit Value Should Equal")
	}
	else{
		var number=$("#validationCustom02").val();
		var currency=$("#currencysr").val();
		var date=$("#date").val();
		var description=$("#descriptiondata").val();
		var des=$(".description").val();
		var costcenter=$(".costcenter").val();
		var debit=$(".debit").val();
		var credit=$(".credit").val();
		
		if((number != "") &&(currency != "") && (date != "") && (description != "") && (des !="") &&(costcenter != "") && (debit !="")&& (credit != ""))
		{
			$("#demo-form2" ).trigger("submit");
			
	}
	else{
		alert('Fill The  Required Fields');
	}
	
}

});
    </script>
 