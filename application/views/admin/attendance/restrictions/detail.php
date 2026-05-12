
<?php $this->load->view('admin/home/header');?>

<style>
	.required-field{
		color:#f00;
	}
	.size-inner-section {
		box-shadow: 0px 1px 4px #c5c5c5;
		border-radius: 5px;
		margin-bottom: 10px;
	}
	input, textarea, select, select.select2{
		pointer-events: none;
	}
	input[type=checkbox] +label {
		pointer-events: none;
	}
	.map_wrap {
		border: 1px solid #dee2e6;
		width: 100%;
		height: 265px;
		background-image: url(<?php echo base_url('admin_assets/images/bs_map.svg');?>);
		background-size: cover;
		position: relative;
	}
	.map_wrap>.map_wrap_btn {
		background: rgba(0,0,0,.3);
		height: 100%;
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map{
		height: 40vh;
		margin-bottom: 10px;
		box-shadow: 0px 0px 5px #bbbbbb;
	}
  #description {
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
  }

  #infowindow-content .title {
	font-weight: bold;
  }

  #infowindow-content {
	display: none;
  }

  #map #infowindow-content {
	display: inline;
  }

  .pac-card {
	margin: 0px;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    position: relative !important;
  }

  #pac-container {
	padding: 12px;
  }
  .pac-container {
	z-index: 99999 !important;
  }
  .pac-controls {
	display: inline-block;
	padding: 5px 11px;
  }

  .pac-controls label {
	font-family: Roboto;
	font-size: 13px;
	font-weight: 300;
  }

  #pac-input {
	background-color: #fff;
    font-size: 15px;
    font-weight: 300;
    padding: 0 10px;
    text-overflow: ellipsis;
    width: 100%;
	height: 30px;
    border: 1px solid #409844;
  }

  #pac-input:focus {
	border-color: #4d90fe;
  }
  p.hint{
	font-size: 12px;
  }
  .authorize-signs .form-check-input[type=checkbox] {
    border-radius: 0.25em;
    width: 20px;
    height: 20px;
    margin-right: 9px;
    margin-top: 0px;
}
</style>
<div id="wait"><i class="fa fa-spinner fa-spin"></i><br>Updating..</div>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Attendance Restrictions</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin'); ?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/attendance/restriction-list'); ?>">Attendance Restrictions</a></li>
						<li class="breadcrumb-item active">Detail</li>
					</ol>
				</div>
			</div>
			<?php $admin_id = $this->session->userdata('admin_id');?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right me-2" title="Back" href="<?php echo base_url('admin/attendance/restriction-list'); ?>"><i class="fa fa-reply"></i> Back</a>

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
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<!-- Tab panes -->
						<div class="tab-content p-3 text-muted">
							<div class="tab-pane active" id="home1" role="tabpanel">
								<div class="row size-inner-section px-2 py-4">
									<h4 class="header-title">Attendance Restrictions</h4><hr>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="name">Name <span class="required-field">*</span></label>
										<input type="text" class="form-control" id="name" name="name" maxlength="125" onBlur="checkDuplicateName()" value="<?php echo $restriction->name;?>" required />
										<small class="hint res-msg">Enter Unique Restrictions Name</small>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="res_status">Status <span class="required-field">*</span></label>
										<p><?php echo ($restriction->status == 'active') ? '<span class="badge badge-pill badge-soft-success font-size-13">Active</span>' : '<span class="badge badge-pill badge-soft-danger font-size-13">Inactive</span>' ?></p>
									</div>
									<hr>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="is_allowed_ips d-block">Restricted by IPs</label>
										<div class="bg-light p-1">
											<div><?php echo ($restriction->is_allowed_ips == 'on') ? ' <i class="mdi mdi-checkbox-marked-outline font-size-24 text-success"></i>' : '<i class="mdi-close-box-multiple-outline font-size-24 text-danger"></i>' ?></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group if-ip-checked">
										<label for="ip_validation">Validation </label>
										<select name="ip_validation" id="ip_validation" class="form-select" required>
											<option value="">Select</option>
											<option value="1" <?php echo ($restriction->ip_validation == '1') ? ' selected' : '' ?>>Required</option>
											<option value="0" <?php echo ($restriction->ip_validation == '0') ? ' selected' : '' ?>>Optional</option>
										</select>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group if-ip-checked">
										<label for="allowed_ips">Allowed IPs </label>
										<textarea id="allowed_ips" class="form-control" rows="2" autoresize="" name="allowed_ips" required cols="50" required style="height: 68px;"><?php echo $restriction->allowed_ips;?></textarea>
									</div>
									<hr>
									<div class="col-md-6 col-sm-12 mb-3 form-group">
										<label for="is_location_restricted d-block">Restricted By Location Range</label>
										<div class="bg-light p-1">
											<div><?php echo ($restriction->is_location_restricted == 'on') ? ' <i class="mdi mdi-checkbox-marked-outline font-size-24 text-success"></i>' : '<i class="mdi-close-box-multiple-outline font-size-24 text-danger"></i>' ?></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-12 mb-3 form-group if-location-checked">
										<label for="location_validation">Validation </label>
										<select name="location_validation" id="location_validation" class="form-select" required>
											<option value="">Select</option>
											<option value="1" <?php echo ($restriction->location_validation == '1') ? ' selected' : '' ?>>Required</option>
											<option value="0" <?php echo ($restriction->location_validation == '0') ? ' selected' : '' ?>>Optional</option>
										</select>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group if-location-checked">
										<div class="map_wrap" id="mapmap">
											<div class="map_wrap_btn">
												<button class="btn btn-custom-success btn-icon responsive" type="button">
													<i class="fas fa-map-marked-alt fs-16"></i>
													<span>Show Map</span>
												</button>
											</div>
										</div>
										<div id="mapMsg"></div>
										<input id="maplng" class="long-input" name="map[longitude]" type="hidden" value="<?php echo $restriction->longitude;?>" required>
										<input id="maplat" class="lat-input" name="map[latitude]" type="hidden" value="<?php echo $restriction->latitude;?>" required>
										<input id="place_id" class="place-input" name="map[place_id]" type="hidden" value="<?php echo $restriction->place_id;?>" required>
										<input id="map_location" class="map-input" name="map_location" type="hidden" value="<?php echo $restriction->map_location;?>" required>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group if-location-checked">
										<label for="location_range">Range of the Sign </label>
										<div class="input-group">
											<input type="text" id="location_range" name="location_range" class="form-control" value="<?php echo $restriction->location_range;?>" required style="height:38px !important">
											<select name="range_unit" id="range_unit" class="form-select" required>
												<option value="">Select Type</option>
												<option value="1" <?php echo ($restriction->range_unit == '1') ? ' selected' : '' ?>>Kilometers</option>
												<option value="0" <?php echo ($restriction->range_unit == '0') ? ' selected' : '' ?>>Meters</option>
											</select>
										</div>
									</div>
									
									<hr>
									<div class="col-md-6 col-sm-12 mb-2 form-group">
										<label for="is_photo_required d-block">Restricted By Employees Photos</label>
										<div class="bg-light p-1">
											<div><?php echo ($restriction->is_photo_required == 'on') ? ' <i class="mdi mdi-checkbox-marked-outline font-size-24 text-success"></i>' : '<i class="mdi-close-box-multiple-outline font-size-24 text-danger"></i>' ?></div>
										</div>
									</div>
									<div class="col-md-6 col-sm-12 mb-2 form-group if-photo-checked">
										<label for="photo_validation">Validation </label>
										<select name="photo_validation" id="photo_validation" class="form-select" required>
											<option value="">Select</option>
											<option value="1" <?php echo ($restriction->photo_validation == '1') ? ' selected' : '' ?>>Required</option>
											<option value="0" <?php echo ($restriction->photo_validation == '0') ? ' selected' : '' ?>>Optional</option>
										</select>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
	
</script>
