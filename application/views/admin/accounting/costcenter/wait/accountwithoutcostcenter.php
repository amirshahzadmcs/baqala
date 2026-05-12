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
</style>
<div id="wait"><img src="<?= base_url('images/sample-loader.gif');?>" /><br>Loading..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Cost Center</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/costcenters/list">Cost Center</a></li>
						<li class="breadcrumb-item active">Accounts without Cost Center</li>
					</ol>
				</div>
			</div>
            <div class="col-md-6 ">
                <div class="d-sm-block float-end">
                    <button type="button" class="btn btn-custom-danger btn-sm pull-right" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                    &nbsp;
                    <a class="btn btn-custom-success btn-sm pull-right me-1" title="Export"><i class="fa fa-plus"></i> Export</a>
                </div>
            </div>
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
        <div class="row">
            
        <div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="header-title mb-0">Search</h4>
					</div>
					<div class="card-body">
                    <form class="needs-validation" novalidate="">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Account</label>
                                    <select class="select2 form-control "
                                     data-placeholder="Nothing Select">
                                     <option value="1">Any Account</option>
                                    <option value="15">Assets</option>
                                    <option value="16">Fixed Assets</option>
                                    <option value="17">Furniture and Fixtures</option>
                                    <option value="18">Equipment</option>
                                    <option value="19">Vehicles</option>
                                    <option value="20">Buildings</option>
                                    <option value="21">Land</option>
                                    <option value="27">Revenue</option>
                                    <option value="28">Accounts Receivable</option>
                                    <option value="31">Clients</option>
                                    <option value="34">Current Assets</option>
                                    <option value="35">Treasury</option>
                                    <option value="36">Bank</option>
                                    <option value="37">Inventory</option>
                                    <option value="39">Liabilities</option>
                                    <option value="40">Current Liabilities</option>
                                    <option value="41">Accounts Payable</option>
                                    <option value="42">Suppliers</option>
                                    <option value="43">Expenses</option>
                                    <option value="46">Tax Payable</option>
                                    <option value="47">Tax Expense</option>
                                    <option value="53">Depreciation Expense</option>
                                    <option value="56">Notes Receivable</option>
                                    <option value="57">Shipping</option>
                                    <option value="58">Owner's Equity</option>
                                    <option value="59">Notes Payable</option>
                                    <option value="61">Accumulated Depreciation</option>
                                    <option value="62">Capital Gains &amp; Losses</option>
                                    <option value="65">Other Expense</option>
                                    <option value="66">Other Income</option>
                                    <option value="67">Petty Cash</option>
                                    <option value="68">Salaries &amp; Wages</option>
                                    <option value="69">Cost of Sales</option>
                                    <option value="70">Direct Cost</option>
                                    <option value="71">Selling Expense</option>
                                    <option value="72">Rent Expenses</option>
                                    <option value="73">Utilities</option>
                                    <option value="74">Consumables</option>
                                    <option value="75">Office Supplies</option>
                                    <option value="76">Vehicle Maintenance</option>
                                    <option value="77">Corporate expense</option>
                                    <option value="78">General &amp; Administrative</option>
                                    <option value="79">Bank Charges</option>
                                    <option value="80">Revenue - E-Commerce</option>
                                    <option value="81">Revenue - Third Party Logistics</option>
                                    <option value="82">Share Capital</option>
                                    <option value="83">Other Current Assets</option>
                                    <option value="84">Other Current Liabilities</option>
                                    <option value="85">Standard Rate القيمة المضافة Payable</option>
                                    <option value="86">Zero Rate صفرية Payable</option>
                                    <option value="87">Exempted معافاة Payable</option>
                                    <option value="88">Accrued Expenses</option>
                                    <option value="89">Non-Current Liabilities</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 float-end">
                                    <!-- <label class="form-label">&nbsp;</label> -->
                                    <button type="reset" class="btn btn-secondary ml-0 btn-md">Reset</button>
                                    <button type="submit" class="btn btn-success ml-0 btn-md">Search</button>
                                </div>
                            </div>
                        </div> 
                        
                        </form>
					</div>
				</div>
			</div>
          
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                           
                <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>
                                <div class="form-check form-check-right">
                                    <input class="form-check-input" type="checkbox" id="selectall">
                                </div>
                            </th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Actions</th>
                        </tr>
                        </thead>


                        <tbody>
                        <tr>
                            <td>
                                <div class="form-check form-check-right mb-3">
                                    <input name="sample[]" class="form-check-input allcheck" type="checkbox" id="formCheckRight1">
                                </div>
                            </td>
                            <td>1</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td class="float-end">
                            <span class="dtr-data">
                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/assigncostcenter'); ?>">Assign Cost Centers</a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/editwithoutcost'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Delete" href=""><i class="fas fa-trash-alt"></i></a>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-right mb-3">
                                    <input name="sample[]" class="form-check-input allcheck" type="checkbox" id="formCheckRight1">
                                </div>
                            </td>
                            <td>2</td>
                            <td>Edin</td>
                            <td>62</td>
                            <td class="float-end">
                                <span class="dtr-data">
                                <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/assigncostcenter'); ?>">Assign Cost Centers</a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Edit" href="<?php echo base_url('admin/accounting/costcenters/editwithoutcost'); ?>"><i class="mdi mdi-pencil"></i></a> 
                                    <a class="btn btn-outline-secondary btn-sm edit" title="Delete" href=""><i class="fas fa-trash-alt"></i></a>
                                </span>
                            </td>
                        </tr>
                       
                        </tbody>

                        
                    </table>
                    
                </div>
            </div>
        </div>
	</div>
</div>

<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>
<script>
    $(document).ready(function() {
    $('#activelog').dataTable({
    "lengthMenu": [
    [25, 50, 100, 500],
    [25, 50, 100, 500]
    ],
    order: [
    [0, 'asc']
    ],
    "responsive": true,
    fixedHeader: true,
    });
    });
</script>

<script>
    $('#selectall').click(function() { 
        $('.allcheck').filter(':checkbox').prop('checked', this.checked);
});
</script>

