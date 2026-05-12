<?php //echo '<pre>';print_r($attend_results);exit();
$this->load->view('admin/home/header'); ?>
<style>
	.dataTables_wrapper::-webkit-scrollbar {
		display: none;
	}

	.nav-md .container.body .right_col {
		padding: 10px 10px 0;
		margin-left: 230px;
	}

	.roundCircle {
		/* background-color: rgba(35,197,143,.25)!important; */
		border-radius: 50%;
		width: 50px;
		height: 50px;
		padding: 12px 14px;
	}
	.input-group-text {
        padding: 0 0.75rem;
    }
	.table .thead-caption {
		font-weight: 300;
		color: #000000;
		background: #fdce43ad;
	}
	.table>:not(caption)>*>* {
    	padding: 0.25rem 0.75rem;
	}
	.table .thead-caption td{
		padding: 0.2rem 0.5rem;
		vertical-align: middle;
		font-weight: 400;
		color: #764444;
	}
	.result-tr td{
		line-height: 15px;
		color: #000000;
	}
	.result-tr .present{
		background-color: #70dc70;
	}
	.result-tr .absent{
		background-color: #f03838;
	}
	.tpre{
		color: green !important;
    	font-weight: 700;
	}
	.tabs{
		color: red !important;
    	font-weight: 700;
	}
	.table.border-gray {
		border-color: #989898!important;
	}
	.custom-scroll::-webkit-scrollbar {
		height: 5px;
	}
	.custom-scroll::-webkit-scrollbar-thumb {
		background: #cacaca;
		border-radius: 25px;
	}
	.td-fridged{
		position: absolute;
		width: 50px;
		border: none;
		background: #fff;
	}
</style>


<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Add Attendance</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/list'); ?>">Attendance</a></li>
						<li class="breadcrumb-item active">Add</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/list') ?>"><i class="fa fa-reply me-2"></i>Back</a>
					<button type="submit" form="form_attendance" class="btn btn-sm btn-custom-success">Save</button>
					<?php if($this->admin->getInfo()){
					$info = explode("--", $this->admin->getInfo());
					$info_type = $info[0];
					$msg_data = $info[1];
					if($info_type == 2){
					?>
					<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $msg_data;?></strong>
					</div>
					<?php } else{?>
						<div class="alert alert-info alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;top:90px;width:50%;" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							<strong><?php echo $msg_data;?></strong>
						</div>
					<?php } ?> <?php } $this->admin->removeInfo();?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->


<div class="container-fluid">
	<div class="page-content-wrapper">
		<div class="row">

			<div class="col-12 mb-3 mx-auto">
				<div class="card">
					<div class="card-body pb-2">
						<form action="<?php echo base_url('admin/attendance/save') ?>" id="form_attendance" method="POST">
							<div class="row">	
								<div class="col-md-3 mb-2">
									<label for="attend_date">Attendance Date:</label>
									<input type="date" class="form-control col-3" name="attend_date" id="attend_date" required />
								</div>
								<div class="col-md-6 mb-2">
									<label for="bulk_mark">Bulk Mark:</label>
									<div class="d-flex">
										<div class="form-check mb-3">
											<input class="form-check-input" type="radio" name="bulk_mark" value="P" id="bulk_mark1">
											<label class="form-check-label" for="bulk_mark1">
												Present
											</label>
										</div>
										<div class="form-check mb-3 ms-3">
											<input class="form-check-input" type="radio" name="bulk_mark" value="A" id="bulk_mark2">
											<label class="form-check-label" for="bulk_mark2">
												Absent
											</label>
										</div>
										<div class="form-check mb-3 ms-3">
											<input class="form-check-input" type="radio" name="bulk_mark" value="H" id="bulk_mark3">
											<label class="form-check-label" for="bulk_mark3">
												Holiday
											</label>
										</div>
										<div class="form-check mb-3 ms-3">
											<input class="form-check-input" type="radio" name="bulk_mark" value="" id="bulk_mark4">
											<label class="form-check-label" for="bulk_mark4">
												None
											</label>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12 table-responsive custom-scroll">
									
									<table align="left" class="table table-bordered border-gray">
										<thead>
											<tr class="text-dark h6" style="background-color: #ffe492!important">
												<td align="left" style="width: 5%;padding: 13px;"><b>S.No.</b></td>
												<td align="left" style="width: 40%;padding: 13px;"><b>Rider/Driver Name</b></td>
												<td align="center" style="width: 15%;padding: 13px;"><b>Attendance</b></td>
												<td align="center" style="width: 30%;padding: 13px;"><b>Remarks</b></td>
												<!-- <td align="center" style="width: 10%;padding: 13px;"><b>Date</b></td> -->
											</tr>
										</thead>
										<tbody>
											<?php $d_count = 1;foreach(deliveryBoyList() as $list){ ?>
											<tr>
												<td align="left" style="vertical-align: middle;"><?php echo $d_count; ?></td>
												<td align="left" style="vertical-align: middle;"><input type="hidden" name="rider_id[]" value="<?php echo $list->id; ?>" required /><?php echo $list->name; ?></td>
												<td align="left" style="vertical-align: middle;">
													<select name="mark_attend[]" class="form-control w-100 type_selected" data-placeholder="Mark Attendance ..." required>
														<option value="" disabled>Select Option</option>
														<option value="P">Present</option>
														<option value="A">Absent</option>
														<option value="OT">Over Time</option>
														<option value="L">Late</option>
														<option value="SL">Sick Leave</option>
														<option value="EL">Earned Leave</option>
														<option value="PL">Paid Leave</option>
														<option value="CL">Casual Leave</option>
														<option value="ML">Maternity Leave</option>
														<option value="NH">National Holiday</option>
														<option value="FH">Festive Holiday</option>
														<option value="H">Holiday</option>
														<option value="TR">Training</option>
													</select>
												</td>
												<td align="left" style="vertical-align: middle;"><input type="text" class="form-control" name="remarks[]" /></td>
												<!-- <td align="left" style="vertical-align: middle;"><input type="date" class="form-control attendance_date" name="attend_date[]" required="required" /></td> -->
											</tr>
											<?php $d_count++;} ?>
										</tbody>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div> <!-- end col -->
			

		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer'); ?>
<script>
	/*
    $("#attend_date").change(function(){
        $c_date = this.value;
        $('.attendance_date').val($c_date)
    });*/

	$(document).ready(function() {
		$('input[type=radio][name=bulk_mark]').change(function() {
			var selectedOption = $(this).val();
			$('.type_selected').val(selectedOption);
		});
	});
</script>
