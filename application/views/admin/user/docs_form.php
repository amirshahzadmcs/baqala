<?php $this->load->view('admin/home/header');?>
<style>
.table th, .table td {
    vertical-align: middle;
	padding: 6px 10px;
}
</style>
<!-- start page title -->
<div class="page-title-box">
	<div class="container-fluid">
		<div class="row align-items-center">
			<div class="col-sm-6">
				<div class="page-title">
					<h4>Update Docs</h4>
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="<?php echo base_url('admin/business-user/list');?>">Corporate Client Management</a></li>
						<li class="breadcrumb-item active">Client's Docs</li>
					</ol>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="float-end d-sm-block">
					<a class="btn btn-sm btn-custom pull-right" title="Back" href="<?php echo base_url('admin/business-user/list');?>"><i class="fa fa-reply"></i> Back</a>
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
						<div class="row">
							<?php if($this->session->flashdata('msg')) { ?>
								<?php if($this->session->flashdata('is_success') == 1) { ?>
									<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
								<?php }else{ ?>
									<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?= $this->session->flashdata('msg') ?> </div>
								<?php } ?>
							<?php } ?>
							<?php echo form_open("admin/user/submit_docs", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
								<div class="row">		
									<?php if(!empty($docs)){ ?>
										<input type="hidden" value="<?php echo $docs->id;?>" name="id" />
										<input type="hidden" value="<?php echo $docs->user_id;?>" name="user_id" />
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="commercial_reg">Commercial Registration</label>
											<input placeholder="Upload Commercial Registration" type="file" name="commercial_reg" class="form-control" id="commercial_reg" aria-describedby="commercial_regHelp" />
											<input type="hidden" name="old_commercial_reg" value="<?php echo $docs->commercial_reg;?>" /><br/>
											<img src="<?php echo base_url($docs->commercial_reg); ?>" class="img-fluid p-2" width="100px" />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="national_id">National ID</label>
											<input placeholder="Upload National ID" type="file" name="national_id" class="form-control" id="national_id" aria-describedby="vatHelp" />
											<input type="hidden" name="old_national_id" value="<?php echo $docs->national_id;?>" /><br/>
											<img src="<?php echo base_url($docs->national_id); ?>" class="img-fluid p-2" width="100px" />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="agreement_copy">Agreement Copy</label>
											<input placeholder="Upload Agreement Copy" type="file" name="agreement_copy" class="form-control" id="agreement_copy" aria-describedby="agreement_copyHelp" />
											<input type="hidden" name="old_agreement_copy" value="<?php echo $docs->agreement_copy;?>" /><br/>
											<img src="<?php echo base_url($docs->agreement_copy); ?>" class="img-fluid p-2" width="100px" />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="auth_copy">Authorization Copy</label>
											<input placeholder="Upload Authorization Copy" type="file" name="auth_copy" class="form-control" id="auth_copy" aria-describedby="auth_copyHelp" />
											<input type="hidden" name="old_auth_copy" value="<?php echo $docs->auth_copy;?>" /><br/>
											<img src="<?php echo base_url($docs->auth_copy); ?>" class="img-fluid p-2" width="100px" />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="auth_p_id">Authorized Person ID</label>
											<input placeholder="Upload Authorized Person ID" type="file" name="auth_p_id" class="form-control" id="auth_p_id" aria-describedby="auth_p_idHelp" />
											<input type="hidden" name="old_auth_p_id" value="<?php echo $docs->auth_p_id;?>" /><br/>
											<img src="<?php echo base_url($docs->auth_p_id); ?>" class="img-fluid p-2" width="100px" />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="vat_certificate">VAT Certificate</label>
											<input placeholder="Upload VAT Certificate" type="file" name="vat_certificate" class="form-control" id="vat_certificate" aria-describedby="vat_certificateHelp" required />
											<input type="hidden" name="old_vat_certificate" value="<?php echo $docs->vat_certificate;?>" /><br/>
											<img src="<?php echo base_url($docs->vat_certificate); ?>" class="img-fluid p-2" width="100px" />
										</div>
									<?php }else{ ?>
										<input type="hidden" value="<?php echo $this->input->get('id');?>" name="user_id" required />
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="commercial_reg">Commercial Registration</label>
											<input placeholder="Upload Commercial Registration" type="file" name="commercial_reg" class="form-control" id="commercial_reg" aria-describedby="commercial_regHelp" required />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="national_id">National ID</label>
											<input placeholder="Upload National ID" type="file" name="national_id" class="form-control" id="national_id" aria-describedby="vatHelp" required />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="agreement_copy">Agreement Copy</label>
											<input placeholder="Upload Agreement Copy" type="file" name="agreement_copy" class="form-control" id="agreement_copy" aria-describedby="agreement_copyHelp" required />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="auth_copy">Authorization Copy</label>
											<input placeholder="Upload Authorization Copy" type="file" name="auth_copy" class="form-control" id="auth_copy" aria-describedby="auth_copyHelp" required />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="auth_p_id">Authorized Person ID</label>
											<input placeholder="Upload Authorized Person ID" type="file" name="auth_p_id" class="form-control" id="auth_p_id" aria-describedby="auth_p_idHelp" required />
										</div>
										<div class="col-md-4 col-sm-12 mb-3 form-group">
											<label for="vat_certificate">VAT Certificate</label>
											<input placeholder="Upload VAT Certificate" type="file" name="vat_certificate" class="form-control" id="vat_certificate" aria-describedby="vat_certificateHelp" required />
										</div>
									<?php }	?>
									<div class="text-center">
										<button type="submit" class="btn btn-success btn-block btn-md float-end">Save Changes</button>
									</div>
								</div>
							<?php echo form_close();?>
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
</div>
<!-- container-fluid -->


<?php $this->load->view('admin/home/footer');?>

