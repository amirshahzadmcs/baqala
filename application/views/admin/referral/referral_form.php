<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Referral Charges</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/referral"><i class="fa fa-reply"></i></a>
<button type="submit" form="demo-form2" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Update Referral Charges</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/referral/edit" data-parsley-validate class="form-horizontal form-label-left">

<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="referral_type">Heading <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="referral_type" name="referral_type" value="<?php echo $referral_type;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="heading_arabic">Heading (Arabic)<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="heading_arabic" name="heading_arabic" value="<?php echo $heading_arabic;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="referral_charge">Referral Amount <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="referral_charge" name="referral_charge" value="<?php echo $referral_charge;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="refferer_amount">Referer Amount <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="refferer_amount" name="refferer_amount" value="<?php echo $refferer_amount;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">Referral Description</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <textarea id="content" name="content" class="form-control col-md-7 summerNote col-xs-12"><?php echo $content;?></textarea>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content_arabic">Referral Description (Arabic)</label>
    <div class="col-md-6 col-sm-6 col-xs-12">
      <textarea id="content_arabic" name="content_arabic" class="form-control col-md-7 summerNote col-xs-12"><?php echo $content_arabic;?></textarea>
    </div>
</div>
                      
<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select id="status" name="status" class="form-control col-md-7 col-xs-12" required="required">
<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
</select>
</div>
</div>
</div>

<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
    $(document).ready(function() {
		$('.summerNote').summernote({
			height: 200
		});
	});
</script>
