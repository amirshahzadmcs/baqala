<?php $this->load->view('admin/home/header');?>



<!-- start page title -->
<div class="page-title-box">
		<div class="container-fluid">
		 <div class="row align-items-center">
				 <div class="col-sm-6">
						 <div class="page-title">
								 <h4>Category Management</h4>
								 <ol class="breadcrumb m-0">
									 <li class="breadcrumb-item"><a href="<?php echo base_url('admin');?>">Dashboard</a></li>
									 <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/category">Category List</a></li>
									 <li class="breadcrumb-item active">Create / Edit</li>
								 </ol>
						 </div>
				 </div>
				 <?php  $admin_id= $this->session->userdata('admin_id'); ?>
				 <div class="col-sm-6">
						<div class="float-end d-sm-block">
							<a class="btn btn-sm btn-custom-white pull-right" title="Back" href="<?php echo base_url();?>admin/category"><i class="fa fa-reply"></i> Back</a>
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
									<?php echo form_open("admin/category/add_category", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>

										  <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
										  <input type="hidden" id="o_img" name="o_img" value="<?php echo $o_img;?>">
										  <input type="hidden" id="o_icon" name="o_icon" value="<?php echo $o_icon;?>">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
											<div class="form-group">
												<label class="control-label" for="first-name">Parent Category
												</label>
												<select class="form-control select2" name="parent_id" data-placeholder="Choose Parent Category...">
												<option value="">select</option>
												 <?php foreach($parent as $category){?>
													<option value="<?php echo $category['id'];?>" <?php echo ($category['id'] == $parent_id) ? "selected":"" ?>><?php echo $category['name'];?></option>
												 <?php foreach($category['child'] as $child){?>
													<option value="<?php echo $child['id'];?>" <?php echo ($child['id'] == $parent_id) ? "selected":"" ?>><?php echo $category['name'] . " > " . $child['name'];?></option>
												 <?php }}?>
												</select>
										  </div>
									  </div>

										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Name <span class="required">*</span>
										</label>
										  <input type="text" id="name" name="name" value="<?php echo $name;?>" required="required" class="form-control">
										</div>
									  </div>
										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="arabic_name">Arabic Name
										</label>
										  <input type="text" id="arabic_name" name="arabic_name" value="<?php echo $arabic_name;?>" class="form-control">
										</div>
									  </div>
										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="heading_text">Heading sub title (Max length 500 character)
										</label>
										  <textarea id="heading_text" name="heading_text" class="form-control elm1"><?php echo $heading_text;?></textarea>
										</div>
									  </div>
										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Category Description (English)
										</label>
										  <textarea id="description" name="description" class="form-control elm1 "><?php echo $description;?></textarea>
										</div>
									  </div>
										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="arabic_desc">Category Description (Arabic)
										</label>
										  <textarea id="arabic_desc" name="arabic_desc" class="form-control elm1 "><?php echo $arabic_desc;?></textarea>
										</div>
									  </div>
										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="image">Category Icon (Image size must be 292*277)
										</label>
										  <input type="file" id="image" name="image" class="form-control">
										</div>
										<div class="col-sm-3"><?php echo ($o_img != "") ? '<img src="'.base_url().$o_img.'" width="70px"/>':'';?></div>
									  </div>

										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="icon">Banner Image (Image size must be 1350*250)
										</label>
										  <input type="file" id="icon" name="icon" class="form-control">
										</div>
										<div class="col-sm-3"><?php echo ($o_icon != "") ? '<img src="'.base_url().$o_icon.'" width="70px"/>':'';?></div>
									  </div>

										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">SEO URL <span class="required">*</span>
										</label>
										  <input type="text" id="seo" name="seo" value="<?php echo $seo;?>" required="required" class="form-control">
										</div>
									  </div>



										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Meta Title <span class="required">*</span>
										</label>
										  <input type="text" id="metatitle" name="metatitle" value="<?php echo $metatitle;?>" required="required" class="form-control">
										</div>
									  </div>

										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Meta Tag
										</label>
										  <input type="text" id="metakeyword" name="metakeyword" value="<?php echo $metakeyword;?>" class="form-control">
										</div>
									  </div>
										<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Metadescription
										</label>
										  <textarea id="metadescription" name="metadescription" class="form-control"><?php echo $metadescription;?></textarea>
										</div>
									  </div>

										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Sort Order <span class="required">*</span>
										</label>
										  <input type="number" id="sort_order" name="sort_order" value="<?php echo $sort_order;?>" required="required" class="form-control">
										</div>
									  </div>

										<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									  <div class="form-group">
										<label class="control-label" for="first-name">Status
										</label>
										  <select name="status" class="form-control">
											<option value="1" <?php echo ($status == '1') ? "selected":"";?>>Enable</option>
											<option value="0" <?php echo ($status == '0') ? "selected":"";?>>Disable</option>
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
	$('.textEditor').summernote({
	height: 200
	});
});
</script>
