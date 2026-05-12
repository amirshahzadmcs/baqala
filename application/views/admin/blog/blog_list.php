<?php $this->load->view('admin/home/header');?>
<div class="page-title">
	<div class="title_left">
		<h3>Blog</h3>
	</div>
	<div class="title_right">
		<a class="btn btn-info btn-sm pull-right" data-toggle="tooltip" title="Add" href="<?php echo base_url()?>admin/Blog/add"><i class="fa fa-plus"></i></a>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<h5><i class="fa fa-list"></i> Enquiry List</h5>
		<div class="x_panel">
			<div class="x_content">
				<?php echo ($this->session->flashdata('message')!=''?$this->session->flashdata('message'):'');?> 
				<table id="datatable" class="table table-bordered">
					<thead>
						<tr>
                          <th>#</th>
                          <th>Blog Title</th>
                          <th>Action</th>
                         </tr>
                      </thead>
                      <tbody>
                      <?php 
                      	if(!empty($blog)){
                      		$i=1;
                      		foreach ($blog as $key => $value) {
                      	?>
					  <tr>
					  	<td><?php echo $i++;?></td>
					  	<td><?php echo $value->title;?></td>
					  	<td><a href="<?php echo base_url('admin/Blog/edit/'.$value->id)?>"> <i class="fa fa-edit"></i></a><a href="<?php echo base_url('admin/Blog/delete/'.$value->id)?>"> <i class="fa fa-trash" onclick="confirm('Are You Sure');"></i></a></td>
					  </tr>
					  <?php 
					 }
                      	}
                      ?>
				</tbody>
			</table>
			<?php echo form_close();?>
		</div>
	</div>
</div>
<?php $this->load->view('admin/home/footer');?>