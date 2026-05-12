<?php $this->load->view('admin/home/header');?>

<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
			<div class="page-title">
				<h4>Dispute Management</h4>
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="<?php echo base_url('admin/disputes/list');?>">Disputes</a></li>
					<li class="breadcrumb-item active">Detail</li>
				</ol>
			</div>
			</div>
			<?php  $admin_id= $this->session->userdata('admin_id'); ?>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url('admin/disputes/list'); ?>"><i class="fa fa-reply"></i> Back</a>
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
					<div class="card-header">Dispute Detail</div>
					<div class="card-body">
						<table class="table table-striped table-bordered" style="width:100%">
							<tbody>
								<tr>
									<td width="30%"><strong>Driver’s ID</strong></td>
									<td align="center"><?php echo $driver_id;?></td>
									<td width="30%" align="right"><strong> رقم هوية السائق </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Drivers Username</strong></td>
									<td align="center"><?php echo $driver_username;?></td>
									<td width="30%" align="right"><strong> اسم المستخدم الخاص بالسائق </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Reference ID</strong></td>
									<td align="center"><?php echo $ref_id;?></td>
									<td width="30%" align="right"><strong> الرقم المرجعي </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Rider Name</strong></td>
									<td align="center"><?php echo $rider_name;?></td>
									<td width="30%" align="right"><strong> اسم قائد الدراجة </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Dispute Type</strong></td>
									<td align="center"><?php echo $dispute_type_en;?> / <?php echo $dispute_type_ar;?></td>
									<td width="30%" align="right"><strong> اسم قائد الدراجة </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Dispatch Time</strong></td>
									<td align="center"><?php echo date('d-m-Y H:i:s',strtotime($dispatch_date));?></td>
									<td width="30%" align="right"><strong> زمن الإرسال  </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Drivers Debit Amount</strong></td>
									<td align="center"><?php echo $debit_amount;?></td>
									<td width="30%" align="right"><strong> مبلغ الحسم الخاص بالسائقين </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Explanation</strong></td>
									<td align="left"><?php $explanations_final = str_replace(["\\r\\n", "\\n", "\\r"], "\n", $explanations);echo nl2br($explanations_final);?></td>
									<td width="30%" align="right"><strong> التوضيح والتبرير </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Status</strong></td>
									<td align="center">
										<?php 
										echo match($dispute_status) {
											'1' => '<span class="badge badge-pill badge-soft-success font-size-13">Approved</span>',
											'2' => '<span class="badge badge-pill badge-soft-danger font-size-13">Rejected</span>',
											'3' => '<span class="badge badge-pill badge-soft-info font-size-13">Partial Approved</span>',
											default => '<span class="badge badge-pill badge-soft-secondary font-size-13">Open</span>',
										};?>
									</td>
									<td width="30%" align="right"><strong> حالة </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Status Updated Date</strong></td>
									<td align="center"><?php echo (isset($status_updated_date)) ? date('d-m-Y', strtotime($status_updated_date)) : 'NA';?></td>
									<td width="30%" align="right"><strong> تاريخ تحديث الحالة </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Approved Amount</strong></td>
									<td align="center"><?php echo $approved_amount;?></td>
									<td width="30%" align="right"><strong> المبلغ المعتمد </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Created</strong></td>
									<td align="center"><?php echo date('d-m-Y H:i:s', strtotime($created_at));?></td>
									<td width="30%" align="right"><strong> تاريخ الإنشاء </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Updated</strong></td>
									<td align="center"><?php echo (isset($updated_at)) ? date('d-m-Y H:i:s', strtotime($updated_at)) : 'NA';?></td>
									<td width="30%" align="right"><strong> مخلوق </strong></td>
								</tr>
								<tr>
									<td width="30%"><strong>Attachment</strong></td>
									<td align="center"><?php echo (!empty($attach_file)) ? '<a href="'. base_url($attach_file) .'" target="_blank">View File</a>' : 'NA';?></td>
									<td width="30%" align="right"><strong> المرفق </strong></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
 </div>
 <!-- container-fluid -->

<?php $this->load->view('admin/home/footer');?>

