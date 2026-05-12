<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<h3>Blog</h3>
	 <?php echo ($this->session->set_flashdata('error')?$this->session->set_flashdata('error'):'');?>
		<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/blog"><i class="fa fa-reply"></i></a>
		<button type="submit" form="demo-form2" class="btn btn-sm btn-info pull-right submit"  data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
	 
</div>
<div class="clearfix"></div>
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h5><i class="fa fa-pencil"></i> Edit Blog</h5>
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
        <?php echo ($this->session->flashdata('message')!=''?$this->session->flashdata('message'):'');?> 
				<form id="demo-form2" method="post" action="<?php echo base_url()?>admin/blog/updateBlogCode" enctype="multipart/form-data" class="form-horizontal form-label-left">

          <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(4);?>">
     
					<div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Blog Title<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="title" name="title" value="<?php echo $blog->title;?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Blog Slug<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="slug" name="slug" value="<?php echo $blog->slug;?>" readonly="readonly" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="blogimg">Image (580*280)</label>
            	<div class="col-md-6 col-sm-6 col-xs-12">
            		<input type="file" name="blogimg" id="fileUpload"  />
            	</div>
              <?php if($blog->image!=''){?>
              <input type="hidden" name="imagepath" value="<?php echo $blog->image;?>">
              <img src="<?php echo base_url('upload/blog/'.$blog->image);?>" height="50" width="50">
              <?php } ?>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">Description  <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="description" name="description" class="form-control col-md-7 col-xs-12"><?php echo $blog->description;?></textarea>
            </div>
            <span style="color:red;">Content Copy Only With Notepad*</span>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_title">Meta Title  <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="meta_title" name="meta_title" value="<?php echo $blog->meta_title;?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_keyword">Meta Keywords  <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="meta_keyword" name="meta_keyword" value="<?php echo $blog->meta_keyword;?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_description">Meta Description  <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="meta_description" name="meta_description" value="<?php echo $blog->meta_description;?>" required="required" class="form-control col-md-7 col-xs-12">
            </div>
          </div>

          <div class="form-group">
          	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status</label>
          	<div class="col-md-6 col-sm-6 col-xs-12">
          		<select name="status" id="status" class="form-control">
								  <option <?php echo ($blog->status=='1'?'selected="selected"':'');?> value="1" >Enable</option>
								  <option <?php echo ($blog->status=='0'?'selected="selected"':'');?> value="0">Disable</option>
  	           </select>
            </div>
          </div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
		<?php $this->load->view('admin/home/footer');?>
		<script type="text/javascript">
      
			$(document).ready(function() {

    $("#title").on("change",function(){
      var value=$(this).val();
      var slug = value.split(' ').join('-');
        $("#slug").val(slug);
    });
        
        $("#fileUpload").change(function (e) {
            var _URL = window.URL || window.webkitURL;
            var file = $(this)[0].files[0];
            var imgage = new Image();
            var imgwidth = 0;
            var imgheight = 0;
            var maxwidth = 640;
            var maxheight = 640;
            imgage.src = _URL.createObjectURL(file);
            imgage.onload = function() {
              imgwidth = this.width;
              imgheight = this.height;
              if(imgwidth!='580' || imgheight!='280' ){
                confirm("Width and Height must  exceed 580px * 280px.");
                $('.submit').attr('disabled',true);
              }else{
                $('.submit').attr('disabled',false);
                return true;
              }
            }
       });
				$('#description').summernote({
					height: 200
				});
        

        
			});
		</script>

	