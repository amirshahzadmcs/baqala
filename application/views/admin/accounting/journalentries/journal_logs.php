<?php $this->load->view('admin/home/header');?>

<style>
	.table>:not(caption)>*>* {
    padding: 0.5rem 0.25rem;
    background-color: var(--bs-table-bg);
    border-bottom-width: 1px;
    -webkit-box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
    box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
}
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
					<h4>Journal Entries</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/accounting/journal/list">Journal Entries </a></li>
						<li class="breadcrumb-item active">List</li>
					</ol>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- end page title -->

<div class="container-fluid">
	<div class="page-content-wrapper">
    <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Search</h4>
                            <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label  class="form-label">Account</label>
                                        <select class="form-control select2 p-3" style="height: 38px !important;">
                                            <optgroup>
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">Description</label>
                                        <textarea required="" class="form-control" rows="5" style="height: 17px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                            <label class="form-label">Date</label>
                                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                                <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                                <input type="text" class="form-control" name="end" placeholder="End Date" />
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="validationCustom03" class="form-label">Action</label>
                                        <select class="form-select" id="validationCustom03" required>
                                            <option value="">Any Action</option>
                                            <option value="0">Add</option>
                                            <option value="1">Delete</option>
                                            <option value="2">Update</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Staff Id</label>
                                        <select class="form-control select2 p-3" style="height: 38px !important;">
                                            <optgroup >
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-6 mb-3">
									<label for=""></label>
									<button type="submit" class="btn btn-success mt-2 form-control">Submit</button>
								</div>
                                <div class="col-lg-2 col-sm-6 mb-3">
									<label for=""></label>
									<a type="reset" href="" class="btn btn-danger mt-2 form-control">Reset</a>
								</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
				<div class="card">
					<div class="card-body">
						<table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0px; width: 100%;" role="grid" aria-describedby="datatable_info">
							<thead>
								<tr>					  
									
									<th width="10%">Date</th>
									<th width="8%">Action</th>
									<th width="8%">Staff Member</th>
									<th width="8%">Journal No</th>
									<th width="8%">Name</th>
									<th width="8%">Description</th>
									<th width="8%">Currency Code</th>
									<th width="8%">Debit</th>
									<th width="8%">Credit</th>
                                    <th width="8%">Local Debit</th>
									<th width="8%">Local Credit</th>
                                    <th width="10%">Journal Date</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								
								if(isset($list))
								{ 
									
									$result = array_filter($list); 
									// var_dump($result);
								foreach($result as $row)
								{
									
									
								foreach(array_filter($row) as $key=>$loglist)
								{ ?>
                                <tr>
                                    
                                    <td width="10%"><?php echo date('d- m-Y  H:i', strtotime($loglist['created_at'])); ?></td>
                                    <td width="8%"><?php echo $loglist['action']  ?></td>
                                    <td width="8%"><?php echo $loglist['action'] ?></td>
                                    <td width="8%"><?php echo $loglist['journal_number'] ?></td>
                                    <td width="8%"><?php echo $loglist['account_name'] ?></td>
                                    <td width="8%"><?php echo $loglist['description'] ?></td>
                                    <td width="8%"><?php echo $loglist['currency_code'] ?></td>
                                    <td width="8%"><?php echo $loglist['debit'] ?></td>
                                    <td width="8%"><?php echo $loglist['credit'] ?></td>
                                    <td width="8%"><?php echo $loglist['local_debit'] ?></td>
                                    <td width="8%"><?php echo $loglist['local_credit']  ?></td>
                                    <td width="10%"><?php echo date('d- m-Y',strtotime($result[$key]['entry_date'])) ?></td>
                                    
                                </tr>
								
								
								<?php } 
							?>
							<tr>
									<td colspan="12"  style="background-color: #fdcf43;"></td>
								</tr> 
							<?php } } ?>
                             
                            </tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
        </div>
	</div>
</div>
<!-- container-fluid -->
<?php $this->load->view('admin/home/footer');?>
<script>
    $(document).ready(function() {
    $('#regionTable').dataTable({
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
