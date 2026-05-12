<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Notification</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/notification"><i class="fa fa-reply"></i></a>
<button form="demo-form2" type="submit" class="btn btn-sm btn-success pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i> Publish</button>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Create Notification</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<?php echo form_open("admin/notification/add_notification", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>

<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="title" name="title" value="<?php echo $title;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="message">Message <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<textarea id="message" name="message" rows='8' class="form-control col-md-7 col-xs-12" required="required"><?php echo $message;?></textarea>
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="ended_on">Date End <span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="date" id="ended_on" name="ended_on" value="<?php echo $ended_on;?>" required="required" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="status">Status
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<select id="status" name="status" class="form-control col-md-7 col-xs-12">
<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Active</option>
<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Deactive</option>
</select>
</div>
</div>

<?php echo form_close(); ?>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/home/footer');?>
