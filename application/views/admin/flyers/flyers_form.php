<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Flyers Image</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/flyers"><i class="fa fa-reply"></i></a>
<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Add Flyers Image</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<?php echo form_open("admin/flyers/add_photo", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>

<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
<input type="hidden" id="o_img" name="o_img" value="<?php echo $o_img;?>">



<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="file" id="image" name="image" class="form-control col-md-7 col-xs-12">
</div>
</div>

<div class="form-group">
<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
<input type="text" id="name" name="name" class="form-control col-md-7 col-xs-12">
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
$('#description').summernote({
height: 200
});
});
</script>