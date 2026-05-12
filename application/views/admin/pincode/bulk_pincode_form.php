<?php $this->load->view('admin/home/header');?>
    <div class="page-title">
        <div class="title_left">
            <h3>Master Pincode</h3>
        </div>
        <div class="title_right">
            <a class="btn btn-sm btn-default pull-right" data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/pincode"><i class="fa fa-reply"></i></a>
            <button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5><i class="fa fa-pencil"></i> Add Master Pincode</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <?php echo form_open("admin/pincode/add_bulk", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">CSV File <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" id="csv_file" name="csv_file" required="required" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                        </div>

                    <?php echo form_close(); ?>
                    <div class="col-md-12" style="text-align:center"><a href="<?php echo base_url();?>/demo/sample.csv" download style="color:red;">Download Sample CSV</a></div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/home/footer');?>