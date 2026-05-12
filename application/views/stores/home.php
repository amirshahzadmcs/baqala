<?php $this->load->view('admin/home/header');?>
    <div class="page-title">
        <div class="title_left">
            <h3>Home Page</h3>
        </div>
        <div class="title_right">
            <button type="submit" form="demo-form2" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h5><i class="fa fa-pencil"></i> Edit Home</h5>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="demo-form2" method="post" action="<?php echo base_url()?>admin/home_admin/edit" enctype="multipart/form-data" class="form-horizontal form-label-left">
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="banner-tab" role="tab" data-toggle="tab" aria-expanded="true">Banner</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content4" role="tab" id="description-tab" data-toggle="tab" aria-expanded="false">Description</a>
                                </li>

                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="banner-tab">

                                    <input type="hidden" id="id" name="id" value="<?php echo $id;?>" class="form-control col-md-7 col-xs-12">

                                   <table id="banner" class="table table-striped table-bordered table-hover">
        
                  <thead>
                    <tr>
                      <td class="text-left">Banner <span style="color:red;">(2050px X 659px) </span></td>
                      <td class="text-left">Heading</td>
                      <td class="text-left">Text</td>
                      <td class="text-left">URL</td>
                      <td class="text-left">Sort Order</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                  
                  <?php $banner_row = 1;
                // echo '<pre>'; print_r($home_banner->result());die;
                  foreach($home_banner->result() as $k=> $home_banner){
                    
                   
                    
                   ?>
                  <tr id="banner-row<?php echo $banner_row; ?>">
                    <td class="text-left" style="width: 20%;">
          <img src="<?php echo base_url().$home_banner->image;?>" width="70px">
          <input type="file" name="home_banner[]" class="form-control btn btn-default" />
          <input type="hidden" name="home_banner_count[]" value="1" />
          <input type="hidden" name="old_home_banner[]" value="<?php echo $home_banner->image; ?>" />
                    </td>
                    <td class="text-left">
                      <div class="input-group">
                        <input type="text" name="home_banner_heading[]" value="<?php echo $home_banner->heading;?>" placeholder="heading" class="form-control" />
                      </div>
                      </td>
                      <td class="text-left" width="30%">
                      <div class="input-group">
                        <textarea name="home_banner_text_data[]"  placeholder="text" class="form-control" ><?php echo $home_banner->text_data;?></textarea>
                      </div>
                      </td>
           <td class="text-left">
                      <div class="input-group">
                        <input type="text" name="home_banner_url[]" value="<?php echo $home_banner->url;?>" placeholder="http://www.example.com/" class="form-control" />
                      </div>
                      </td>
                    <td class="text-left">
                      <div class="input-group">
                        <input type="text" name="home_banner_sort[]" value="<?php echo $home_banner->sort_order;?>" placeholder="Sort Order" class="form-control" />
                      </div>
                      </td>
                    <td class="text-right"><button type="button" onclick="remove_banner('<?php echo $banner_row;?>')" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                  </tr>
                  <?php $banner_row = $banner_row + 1;
                  }?>
                    </tbody>
                  
                  <tfoot>
                    <tr>
                      <td colspan="5"></td>
                      <td class="text-right"><button type="button" onclick="addBanner();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
           

                                </div>

                                <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image 1 <span class="required">* (370px X 572px)</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <img src="<?php echo base_url().$image1;?>" width="70px" />
                                            <input type="hidden" id="image1" name="image1" value="<?php echo $image1;?>" class="form-control">
                                            <input type="file" id="home_image1" name="home_image1" class="form-control">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="url1" name="url1" value="<?php echo $url1;?>" placeholder="http://www.example.com/" required class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Image 2 <span class="required">* (370px X 572px)</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <img src="<?php echo base_url().$image2;?>" width="70px" />
                                            <input type="hidden" id="image2" name="image2" value="<?php echo $image2;?>" class="form-control">
                                            <input type="file" id="home_image2" name="home_image2" class="form-control">
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="text" id="url2" name="url2" value="<?php echo $url2;?>" placeholder="http://www.example.com/" required class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea id="editor" name="description" class="form-control col-md-7 col-xs-12">
                                                <?php echo $description;?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Description2
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea id="desceditor" name="description2" class="form-control col-md-7 col-xs-12"><?php echo $description2;?></textarea>
                                        </div>
                                    </div>
                                        <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Headline
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea id="headline" name="headline" class="form-control col-md-7 col-xs-12"><?php echo $headline;?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta tag title <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="metatitle" name="metatitle" value="<?php echo $metatitle;?>" required class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta Description
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea id="metadescription" name="metadescription" class="form-control col-md-7 col-xs-12">
                                                <?php echo $metadescription;?>
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Meta tag Keywords
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="metakeyword" name="metakeyword" value="<?php echo $metakeyword;?>" class="form-control col-md-7 col-xs-12">
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <?php echo form_close(); ?>

                </div>
            </div>
            <?php $this->load->view('admin/home/footer');?>

                <script type="text/javascript">
                    var banner_row = <?php echo $banner_row; ?>;

                    function addBanner() {
                        html = '<tr id="banner-row' + banner_row + '">';
                        html += '  <td class="text-left" style="width: 50%;"><input type="file" name="home_banner[]" class="form-control" /><input type="hidden" name="home_banner_count[]" value="1" class="form-control" /><input type="hidden" name="old_home_banner[]" value="" /></td>';
                        html += '  <td class="text-left">';
  html +=' <div class="input-group"><input type="text" name="heading"  placeholder="heading" class="form-control" /> </div>';
   html += '  </td>';
    html += '  <td class="text-left">';
    html +=' <div class="input-group"><textarea name="home_banner_text_data"  placeholder="text" class="form-control" ></textarea></div>';
    html += '  </td>';
                        html += '  <td class="text-left">';
                        html += '<div class="input-group"><input type="text" name="home_banner_url[]" placeholder="http://www.example.com/" class="form-control" /></div>';
                        html += '  </td>';
                        html += '  <td class="text-left">';
                        html += '<div class="input-group"><input type="text" name="home_banner_sort[]" placeholder="Sort Order" class="form-control" /></div>';
                        html += '  </td>';
                        html += '  <td class="text-right"><button type="button" onclick="remove_banner(' + banner_row + ')" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
                        html += '</tr>';

                        $('#banner tbody').append(html);
                        banner_row++;
                    }

                    function remove_banner(u) {
                        $('#banner-row' + u).remove();
                    }
                </script>
                <script>
                    $(document).ready(function() {
                        $('#editor').summernote({
                            height: 200
                        });
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        $('#desceditor').summernote({
                            height: 200
                        });
                    });
                </script>