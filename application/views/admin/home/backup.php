<?php
$this->load->view('admin/home/header');
$msg = false;
?>
          
<div class="page-title">
<div class="title_left">
<h3>Backup</h3>
</div>

<div class="title_right">
<?php if($this->input->get('msg')){ ?> <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>
<?php echo $this->input->get('msg'); ?> </div><?php }?>
</div>
</div>
<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_content">
<h2>Database Backup</h2>

<div class="clearfix"></div>
<a href="<?php echo base_url('admin/common/db_backup');?>" class="btn btn-success">Take Backup</a>

</div>
</div>
</div>
</div>
<?php $this->load->view('admin/home/footer');?>