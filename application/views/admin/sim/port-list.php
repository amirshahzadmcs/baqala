<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_wrapper::-webkit-scrollbar {
  display: none;
}
.nav-md .container.body .right_col {
    padding: 10px 10px 0;
    margin-left: 230px;
}
#sim_info p{
	margin-top: 0;
    font-size: 13px;
    margin-bottom: 0rem;
    font-weight: 200;
}
</style>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Sim Card Management</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item active">Port Inn Number List</li>
				</ol>
			</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<?php if(check_action_permission(get_user_role(),'port_inn_sim_card','save_port_detail')):?>
					<button class="btn btn-custom-success btn-sm pull-right ms-1" title="Add Port Inn" data-bs-toggle="modal" data-bs-target=".add-port-modal"><i class="fa fa-plus"></i> Add Port Number</button>
					<?php endif; ?>
				</div>
				<?php if($this->admin->getInfo()){
				$info = explode("--", $this->admin->getInfo());
				$info_type = $info[0];
				$msg_data = $info[1];
				if($info_type == 1){
				?>
				<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data; ?></strong>
				</div>
				<?php } else{?>
				<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong><?php echo $msg_data;?></strong>
				</div>
				<?php }} $this->admin->removeInfo();  ?>
				<?php if($this->input->get('msg')){ ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						<strong><?php echo $this->input->get('msg'); ?></strong>
					</div>
				<?php }?>
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
					<div class="card-body">
						<form method="get">
							<div class="row align-items-center">
							    <div class="form-group col-lg-4 col-sm-6 mb-3">
									<label>Search By Mobile No.</label>
									<input type="text" id="keyword" name="keyword" placeholder="Enter Mobile No." value="<?php echo $this->input->get('keyword') ? $this->input->get('keyword') : ''; ?>" autocomplete="off" class="form-control">
								</div>
								<div class="form-group col-lg-4 col-md-4 col-12 mb-3">
									<label for="network">Select Network:</label>
									<select name="network" class="form-control select2 w-100">
										<option value="">[Any Network]</option>
										<?php foreach($networks as $network) { ?>
											<option value="<?php echo $network->id;?>" <?php echo ($network->id == $this->input->get('network')) ? 'selected' : ''; ?>><?php echo $network->network_name; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-lg-4 col-sm-6 mb-3">
									<label>Port Inn Between (From and To)</label>
									<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
										<input type="text" class="form-control" id="_from" name="from" value="<?php echo $this->input->get('from') ? $this->input->get('from') : ''; ?>" autocomplete="off" placeholder="Start Date" />
										<input type="text" class="form-control" id="_to" name="to" value="<?php echo $this->input->get('to') ? $this->input->get('to') : ''; ?>" autocomplete="off" placeholder="End Date" />
									</div>
								</div>
								<div class="row mt-2">
									<div class="col-lg-12 col-md-12 col-sm-12">
										<button type="submit" class="btn btn-success btn-md float-end ms-2">Apply Filter</button>
										<a href="<?php echo base_url('admin/sim/port-list'); ?>" class="btn btn-danger btn-md float-end">Reset Filter</a>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<table id="portTable" class="table table-striped table-bordered jambo_table bulk_action" style="width:100%">
							<thead>
								<tr>
									<th>Sr.No.</th>
									<th>Port Date</th>
									<th>Service Provider</th>
									<th>Mobile No.</th>
									<th>Old Service Provider</th>
									<th>New Plan</th>
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

 <!-- Modal -->
 <div class="modal fade add-port-modal" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0">Add Port Inn Detail</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php echo form_open("admin/sim/save-port-detail", array("id" => "portForm", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
					<div class="row">
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="sim_id">Select Sim Card <span class="text-danger">*</span></label>
							<select name="id" id="sim_id" class="form-select select2" required>
								<option value="">Select Sim Card</option>
								<?php foreach($sim_list as $sim_card){ ?>
								<option value="<?php echo $sim_card->id;?>"><?php echo $sim_card->mobile;?> - <?php echo $sim_card->sim_no;?></option>
								<?php } ?>
							</select>
							<p class="sim-provider-msg mb-0 mt-1"></p>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="network">New Service Provider <span class="text-danger">*</span></label>
							<select name="network" class="form-control select2" id="network" required>
								<option value="">Select Service Provider</option>
								<?php if (!empty($networks)) {  
									foreach($networks as $key => $item) { ?>
										<option value="<?php echo $networks[$key]->id; ?>"><?php echo $networks[$key]->network_name; ?></option>
									<?php } } else { ?>
									<option value="" disabled>Add Service Provider</option>
								<?php } ?>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="sim_type">New Service Type <span class="text-danger">*</span></label>
							<select name="sim_type" id="sim_type" class="form-select" required>
								<option value="">-- Select Type --</option>
								<option value="prepaid">Prepaid</option>
								<option value="postpaid">Postpaid</option>
								<option value="Postpaid - Data SIM">Postpaid - Data SIM</option>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="plan">New Plan <span class="text-danger">*</span></label>
							<input type="hidden" name="plan_id" id="plan_id">
							<select name="plan" class="form-control select2" id="plan" data-placeholder="Choose Plan...">
								<option value="">-- Select Plan --</option>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="sim_no">New Sim Card No <span class="text-danger">*</span></label>
							<input type="text" class="form-control" id="sim_no" name="sim_no" onKeyPress="return numerics(event);" onBlur="checkDuplicateSim()" minlength="<?php echo SIM_LENGTH; ?>" maxlength="<?php echo SIM_LENGTH; ?>" required />
							<span class="res-msg-sim"></span>
						</div>
						<div class="col-md-6 col-sm-12 mb-3 form-group">
							<label for="port_date">Port Date <span class="text-danger">*</span></label>
							<input type="date" class="form-control" id="port_date" name="port_date" required />
						</div>
					</div>
				<?php echo form_close(); ?>
				<div class="row modal-info d-none">
					<hr>
					<div class="col-md-6" id="sim_info"></div>
				</div>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-default" class="btn-close" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="portForm" class="btn btn-success">Submit</button>
            </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('admin/home/footer');?>

<script>
$(document).ready(function() {
	$('#portTable').dataTable({
		"lengthMenu": [[25, 50, 100, 500], [25, 50, 100, 500]],
		order: [[0, 'asc']],
		
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
		searching: false,
		"ajax":{
			url:"<?php echo base_url();?>admin/sim/port-ajax-list?network=<?php echo $this->input->get('network')?>&keyword=<?php echo $this->input->get('keyword')?>&from=<?php echo $this->input->get('from');?>&to=<?php echo $this->input->get('to');?>",
			type:"POST",
			// success: function (request) {
			// 	console.log(" Success: " + JSON.stringify(request));
			// },
			error: function (request, error) {
				console.log(" Can't do because: " + JSON.stringify(request));
			},
		},
		"columnDefs":[
			{
			 "targets":[0,1,2,3,4,5,6],
			 "orderable":false
			},
		],
	});
});

$(document).ready(function() {
	$('#sim_type').change(function() {
		var simNumberInput = $('#sim_no');
		var simNetwork = $('#network option:selected').val();
		var sim_type = $('#sim_type option:selected').val();
		if ($(this).val() === 'Postpaid - Data SIM') {
			simNumberInput.attr('minlength', '19');
			simNumberInput.attr('maxlength', '19');
		} else {
			if(simNetwork == '5'){
				simNumberInput.attr('minlength', '19');
				simNumberInput.attr('maxlength', '19');
			}else{
				simNumberInput.attr('minlength', '18');
				simNumberInput.attr('maxlength', '18');
			}
		}
		$.ajax({
			url: "<?php echo base_url()?>admin/Sim_card/getPlans",
			data: { "id": simNetwork,"sim_type": sim_type },
			//dataType:"html",
			type: "get",
			success: function(data){
				console.log(data);
				$('#plan').html(data);
			},
			error: function(data){
				console.log(data);
			}
		});
	});
});

$(function(){
	$('#sim_id').on('change',function(){
		getSimDetail();
	});

	$('#network').on('change',function(){
		$('#sim_type').val('');
		$('#plan').val(null).trigger('change');
		$('#plan').html('<option value="">-- Select Plan --</option>');
	});
});

function checkDuplicateSim() {
	var sim_no = $("#sim_no").val();
	var id = $('#sim_id option:selected').val();
	if (sim_no !== "") {
		$.ajax({
			url: "<?php echo base_url();?>admin/sim/check-duplicate-sim",
			type: "GET",
			data: {
				sim_no: sim_no,
				id: id,
			},
			dataType: "json",
			success: function (data) {
				if(data.status == 'success'){
					$("#sim_no").removeClass('parsley-error');
					$(".res-msg-sim").html(data.msg);
				}else{
					$("#sim_no").val('');
					$("#sim_no").addClass('parsley-error');
					$(".res-msg-sim").html(data.msg);
					return false;
				}
			},
			error: function () {
				$("#sim_no").val('');
				$("#sim_no").addClass('parsley-error');
				$(".res-msg-sim").html('<span class="text-danger">Some error occured, refresh page.</span>');
				return false;
			},
		});
	} else {
		$("#sim_no").addClass('parsley-error');
		$(".res-msg-sim").html('<span class="text-danger">Enter sim number.</span>');
	}
}

function getSimDetail() {
	var sim_id = $('#sim_id option:selected').val();
	if(sim_id !== "") {
		$.ajax({
			url: "<?php echo base_url('admin/sim/port-sim-detail');?>",
			type: "POST",
			data: {
				id: sim_id,
			},
			dataType: "json",
			success: function (data) {
				if(data.status == 'success'){
					$('.modal-info').removeClass('d-none');
					$("#sim_info").html('<h6>Sim Card Detail:</h6><p><strong>SIM No : </strong>'+ data.sim_detail.sim_no +'</p><p><strong>Service Provider : </strong>'+ data.sim_detail.network_name +'</p><p><strong>Service Type : </strong>'+ data.sim_detail.sim_type +'</p><p><strong>Plan : </strong>'+ data.sim_detail.plan_name +'</p><p><strong>Employee ID : </strong>'+ data.sim_detail.emp_no +'</p><p><strong>Employee Name : </strong>'+ data.sim_detail.emp_full_name +'</p>');
				}else{
					$("#sim_info").html('');
					return false;
				}
			},
			error: function () {
				$("#sim_info").html('');
				return false;
			},
		});
	}
}
</script>
