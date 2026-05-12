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
.percentageinput{
    line-height: 1.3 !important;
}
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Assign cost center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/costcenters/list">Cost Center</a></li>
						<li class="breadcrumb-item active">Assign cost center</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save">
                        <i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
    <form class="needs-validation" novalidate>
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <table id="attribute" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-left"><b>Cost Center </b></th>
                                <th class="text-left"> <b>Percentage </b></th>
                                <th class="text-left"> <b>Auto </b></th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $att_row = 0;?>
                            <tr id="attribute-row<?php echo $att_row; ?>">
                                <td style="width:46%;">
                                    <select class="form-select text-dark" style="height: 38px !important;">
                                            <option value="1">Please Select</option>
                                            <option value="2">Management</option>
                                            <option value="3">Human Resource & Admin</option>
                                            <option value="4">Information Technology</option>
                                    </select>
                                </td>
                                <td style="width:46%;">
                                <div class="input-group">
                                <input type="text" name="percentage" placeholder="Percentage" class="form-control " id="validationCustom02" value="" required="">
                                    <span class="input-group-text percentageinput">&percnt;</span>
                                </div>
                                </td>
                                <td style="width:6%; ">
                                <input type="checkbox" name="auto" class="" id="validationCustom02" value="" required="">
                                </td>
                                <td>
                                    <button type="button" onclick="remove_attribute(<?php echo $att_row;?>);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
                                </td>
                            </tr>
                            <?php $att_row = $att_row = 1;?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td ><button type="button" onclick="addAttribute();" title="Add" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Add</button></td>
                                <td colspan="2"> </td>
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
<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	var attribute_row = <?php echo $att_row; ?>;
	function addAttribute() {
		html  = '<tr id="attribute-row' + attribute_row + '">';
		html += ' <td style="width:46%;"><select class="form-select text-dark" style="height: 38px !important;"><option value="1">Please Select</option><option value="2">Management</option><option value="3">Human Resource & Admin</option><option value="4">Information Technology</option></select></td>';
		html += ' <td style="width:46%;"><div class="input-group"><input type="text" name="percentage" placeholder="Percentage" class="form-control " id="validationCustom02" value="" required=""><span class="input-group-text percentageinput">&percnt;</span></div></td>';
		html += ' <td style="width:6%; "><input type="checkbox" name="auto" class="" id="validationCustom02" value="" required=""></td>';
       	html += '  <td ><button type="button" onclick="remove_attribute(' + attribute_row + ')" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';
		$('#attribute tbody').append(html);
		attribute_row++;
	}

	function remove_attribute(u){
		$('#attribute-row'+u).remove();
	}
    </script>
