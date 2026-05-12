<?php $this->load->view('admin/home/header');?>

	<!-- start page title -->
	<div class="page-title-box">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-sm-6">
					<div class="page-title">
						<h4>Spare Part Master</h4>
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
							<li class="breadcrumb-item"><a href="<?php echo base_url('admin/spare-parts/list');?>">Spare Part Master</a></li>
							<li class="breadcrumb-item active">Create Or Edit</li>
						</ol>
					</div>
				</div>
				<?php  $admin_id= $this->session->userdata('admin_id'); ?>
				<div class="col-sm-6">
					<div class="float-end d-sm-block">
						<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url();?>admin/spare-parts/list"><i class="fa fa-reply"></i> Back</a>
						<button form="demo-form2" type="submit" class="btn btn-sm btn-custom-success pull-right" title="Save"><i class="fa fa-save"></i> Save</button>
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
   			 			<div class="card-body">
							<?php echo form_open("admin/spare-parts/submit", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
								<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

								<div class="row">

									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_make">Vehicle Make <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_make" id="vehicle_make" class="form-control select2" required>
											<option value="">Select Vehicle Make</option>
											<?php foreach($vehicle_makes as $vmakes){ ?>
											<option value="<?php echo $vmakes->id;?>" <?php echo ($vehicle_make == $vmakes->id ? ' selected ' : '');?>><?php echo $vmakes->make_name;?></option>
											<?php } ?>
										</select>
									</div>
									
									<div class="col-md-4 col-sm-12 mb-3 form-group">
										<label for="vehicle_model">Vehicle Type <span class="text-danger">*</span></label>
										<select style="height:410px;" name="vehicle_model" id="vehicle_model" class="form-control select2" required>
											<option value="">Select Vehicle Make First</option>
										</select>
									</div>

									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="item_code">Part No <span class="text-danger">*</span></label>
											<input type="text" id="item_code" name="item_code" value="<?php echo $item_code;?>" required="required" class="form-control">
										</div>
									</div>

									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="part_name_en">Particular Name (English) <span class="text-danger">*</span></label>
											<input type="text" id="part_name_en" name="part_name_en" value="<?php echo $part_name_en;?>" required="required" class="form-control">
										</div>
									</div>

									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="part_name_ar">Particular Name (Arabic) <span class="text-danger">*</span></label>
											<input type="text" id="part_name_ar" name="part_name_ar" value="<?php echo $part_name_ar;?>" required="required" class="form-control rtl-input">
										</div>
									</div>
									
									<div class="col-md-4 col-sm-6 col-xs-12">
										<div class="form-group mb-2">
											<label class="control-label" for="status">Status <span class="text-danger">*</span></label>
											<select name="status" class="form-select" required>
												<option value="">Select Status</option>
												<option value="active" <?php echo ($status == 'active') ? "selected":"";?>>Active</option>
												<option value="inactive" <?php echo ($status == 'inactive') ? "selected":"";?>>Inactive</option>
											</select>
										</div>
									</div>
								</div>
							<?php echo form_close(); ?>
   			 			</div>
   			 		</div>
   			 	</div> <!-- end col -->
   			 </div> <!-- end row -->
    	</div>
    </div>
    <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>
<script>
	$(document).ready(function() {
		var vehicle_make = "<?= ($vehicle_make == '') ? 'NULL' : $vehicle_make; ?>";
	    selectedVehicleModel(vehicle_make);
	});

	$('#vehicle_make').change(function() {
		var make_id = $(this).find('option:selected').val();
		$.ajax({
			url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
			data: {
				make_id: make_id
			},
			dataType: "json",
			type: "post",
			success: function(data) {
				var html = '<option value="">Select Vehicle Type</option>';
		
				if (Object.keys(data).length > 0) {
					$.each(data, function(index, item) {
						html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '">' + item.vehicle_type + '</option>';
					});
				} else {
					var html = '<option value="">No vehicle type found</option>';
				}
				$('#vehicle_model').html(html);
			}
		});
	});

	function selectedVehicleModel(vehicle_make){
		var vehicle_model = "<?= ($vehicle_model == '') ? 'NULL' : $vehicle_model; ?>";
		if(vehicle_make !== 'NULL'){
			$.ajax({
				url: "<?php echo base_url(); ?>admin/deliveryvehicle/get_vehicle_type",
				data: {
					make_id: vehicle_make
				},
				dataType: "json",
				type: "post",
				success: function(data) {
					var html = '<option value="">Select Vehicle Type</option>';
			
					if (Object.keys(data).length > 0) {
						$.each(data, function(index, item) {
							var isSelected = (vehicle_model == item.vehicle_type ? 'selected' : '');
							html += '<option value="' + item.vehicle_type + '" data-id="' + item.id + '" ' + isSelected + '>' + item.vehicle_type + '</option>';
						});
					} else {
						var html = '<option value="">No vehicle type found</option>';
					}
					$('#vehicle_model').html(html);
				}
			});
		}
	}
</script>
