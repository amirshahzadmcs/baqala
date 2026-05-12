<?php $this->load->view('admin/home/header');?>
<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

<div class="page-title">
<div class="title_left">
<h3>Time Slot</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/timeslot"><i class="fa fa-reply"></i></a>
<button type="submit" form="demo-form2" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Add Time Slot</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<form id="demo-form2" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>admin/timeslot/edit" data-parsley-validate class="form-horizontal form-label-left">

<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Time Slot Name <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" id="name" name="name" value="<?php echo $name;?>" required="required" class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="short_name">Slot Short Name <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" id="short_name" name="short_name" value="<?php echo $short_name;?>" required="required" class="form-control col-md-7 col-xs-12">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_from">From <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="time_from" value="<?php echo $time_from;?>" required="required" class="form-control col-md-7 col-xs-12 time">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="time_to">To <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" name="time_to" value="<?php echo $time_to;?>" required="required" class="form-control col-md-7 col-xs-12 time">
	</div>
</div>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="slot_order">Slot Order <span class="required">*</span>
	</label>
	<div class="col-md-6 col-sm-6 col-xs-12">
	<input type="text" id="slot_order" name="slot_order" value="<?php echo $slot_order;?>" required="required" class="form-control col-md-7 col-xs-12">
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
<script>
var timepicker = new TimePicker('time', {
  lang: 'en',
  theme: 'dark'
});

timepicker.on('change', function(evt) {
  
  var value = (evt.hour || '00') + ':' + (evt.minute || '00');
  evt.element.value = value;

});
</script>
<?php $this->load->view('admin/home/footer');?>
