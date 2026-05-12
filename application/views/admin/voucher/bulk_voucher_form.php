<?php $this->load->view('admin/home/header');?>
<div class="page-title">
   <div class="title_left">
      <h3>Vouchers</h3>
   </div>
   <div class="title_right">
      <a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/voucher"><i class="fa fa-reply"></i></a>
      <button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
		<div>
			<?php if($this->admin->getInfo()){ $info = explode("--", $this->admin->getInfo()); $info_type = $info[0]; $msg_data = $info[1]; if($info_type == 2){ ?>
			<div class="alert alert-danger" style="width: 85%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?>
			</div>
			<?php } else{?>
			<div class="alert alert-info" style="width: 85%;">
				<button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
				<?php echo $msg_data; ?>
			</div>
			<?php } $this->admin->removeInfo(); } ?>
		</div>
   </div>
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-6">
      <div class="x_panel">
         <div class="x_title">
            <h5><i class="fa fa-pencil"></i> Check Duplicacy</h5>
            <div class="clearfix"></div>
         </div>
		 <div class="text-left">
			<p class="text-danger"><b>Please check csv file for duplicate entry before uploading.</b></p>
		</div>
        <div class="x_content">
            <?php echo form_open("admin/voucher/check_duplicate", array("id"=>"csvCheck", "enctype"=>"multipart/form-data", "class"=>"form-horizontal")); ?>
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
               <div class="form-group">
                  <label class="control-label" for="csv_file_check">CSV File <span class="required">*</span>
                  </label>
					<div>
						<input type="file" id="csv_file_check" name="csv_file_check" required="required" class="form-control">
					</div><br/>
					<button type="submit" class="btn btn-primary">Check CSV</button>
				</div>
            </div>
            <?php echo form_close(); ?>
         </div>
      </div>
	</div>
	
	<div class="col-md-6 col-sm-6 col-xs-6">
      <div class="x_panel">
         <div class="x_title">
            <h5><i class="fa fa-pencil"></i> Add Bulk Vouchers</h5>
            <div class="clearfix"></div>
         </div>
		 <div class="text-left">
			<p class="text-danger"><b>Important: Please check csv file for duplicate entry before uploading.</b></p>
		</div>
         <div class="x_content">
            <?php echo form_open("admin/voucher/add_bulk", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal")); ?>
            <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
               <div class="form-group">
                  <label class="control-label" for="csv_file">CSV File <span class="required">*</span>
                  </label>
                  <div>
                     <input type="file" id="csv_file" name="csv_file" required="required" class="form-control">
                  </div><br/>
				<button type="submit" class="btn btn-danger">Upload CSV</button>
               </div>
            </div>
            <?php echo form_close(); ?>
			<div class="text-left">
				To download sample CSV click here <a href="<?php echo base_url('build/images/sample_voucher.csv');?>" target="_blank" download style="color:green"><b>Sample CSV</b></a>
			</div>
         </div>
      </div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>