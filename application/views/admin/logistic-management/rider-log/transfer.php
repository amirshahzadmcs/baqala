<?php $this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}
	
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Logistic Management</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/logistic-management/rider/list'); ?>">Riders</a></li>
						<li class="breadcrumb-item active">Transfer Log</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					
				</div>
				<?php if ($this->admin->getInfo()) {
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if ($info_type == 1) {
				?>
					<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
					</div>

				<?php } else { ?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data; ?></strong>
					</div>
				<?php }
				}
				$this->admin->removeInfo();  ?>
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
						<form action="<?php echo base_url('admin/logistic-management/rider/transfer-log'); ?>" method="get" id="filter_form">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Search by Employee Name or Employee No.</label>
										<input type="search" id="keyword" name="keyword" placeholder="Search by Employee Name or Employee No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>Platform</label>
										<select name="platform" id="platform" class="form-select">
											<option value="">[ANY]</option>
											<?php foreach(fdCompanyHelper() as $fdcompany) { ?>
												<option value="<?php echo $fdcompany->id; ?>" <?php echo ($fdcompany->id == $this->input->get('platform')) ? ' selected ' : '';?>><?php echo $fdcompany->company_name; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="form-group mb-2">
										<label>ID Type</label>
										<select name="id_type" id="id_type" class="form-select">
											<option value="">[ANY]</option>
											<option value="Freelancer" <?php echo ($this->input->get('id_type') == 'Freelancer') ? ' selected ' : '';?>>Freelancer</option>
											<option value="Company" <?php echo ($this->input->get('id_type') == 'Company') ? ' selected ' : '';?>>Company</option>
										</select>
									</div>
								</div>
								
							</div>
							<?php
								$adv_show = false;
								if(!empty($this->input->get('id_number'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('from'))){
									$adv_show = true;
								}
								if(!empty($this->input->get('to'))){
									$adv_show = true;
								}
							?>
							<div class="collapse <?php if($adv_show){ echo ' show';}?>" id="advanceFilter">
								<div class="row">
									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>ID Number</label>
											<input type="search" id="id_number" name="id_number" placeholder="Search ID Number" value="<?php echo $this->input->get('id_number') ? $this->input->get('id_number') : ''; ?>" autocomplete="off" class="form-control">
										</div>
									</div>

									<div class="col-lg-4 col-md-4 col-sm-12">
										<div class="form-group mb-2">
											<label>Date Between (From and To)</label>
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-m-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
												<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
												<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row mt-2">
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button class="btn btn-outline-secondary waves-effect waves-light" type="button" data-bs-toggle="collapse" data-bs-target="#advanceFilter" aria-expanded="false" aria-controls="advanceFilter"><i class="fas fa-sliders-h"></i> Advance Search</button>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12">
									<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
									<a href="<?php echo base_url('admin/logistic-management/rider/transfer-log'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<table id="empTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Emp No.</th>
									<th>Emp Name</th>
									<th>ID Number</th>
									<th>Platform</th>
									<th>ID Type</th>
									<th>Transfer Date</th>
									<th>Created At</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
$(document).ready(function() {
	$('#empTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		//order: [[0, 'asc']],
		dom: 'Blfrtip',
		buttons: [
			{
				extend: "csv",
				className: "btn-md"
			},
			{
				extend: "excel",
				className: "btn-md"
			},
			{
				extend: "pdfHtml5",
				className: "btn-md"
			},
			{
				extend: "print",
				className: "btn-md"
			},
		],

		"responsive": true,
		"processing":true,
		"serverSide":true,
		"fixedHeader": true,
		"searching": false,
		"ajax":{
			url:"<?php echo base_url();?>admin/logistic-management/rider/transfer-ajax-list?keyword=<?php echo $this->input->get('keyword')?>&id_type=<?php echo $this->input->get('id_type')?>&platform=<?php echo $this->input->get('platform')?>&id_number=<?php echo $this->input->get('id_number')?>&from=<?php echo $this->input->get('from')?>&to=<?php echo $this->input->get('to')?>",
			type:"POST"
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6,7],
			 "orderable":false
			},
		],
	});
	
});

</script>
