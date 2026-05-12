<?php $this->load->view('admin/home/header');?>
        <!-- page content -->
       
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Form Upload </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dropzone multiple file uploader</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <form action="<?php echo base_url()?>invoice/imageUploadPost" class="dropzone"></form>
                    <br />
                    <br />
					<h3>Instructions: How to upload bulk Images : </h3>
<ul>
<li>Image Size : (Below 2000px X 2000px) max file size 500 Kb jpeg only,</li> 
<li>You can drag and drop multiple files</li>
<li>If you want to upload one by one images than click in any area of box and select images.</li>
<li>Selected image will be auto upload.</li>
<li>Successfully upload images will be shown in box.</li>
                    <br />
                    <br />
                  </div>
                </div>
              </div>
            </div>
          
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            <a href="https://arinfotech.co.in">Developed by A R Infotech</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url()?>vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url()?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url()?>vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url()?>vendors/nprogress/nprogress.js"></script>
    <!-- Dropzone.js -->
    <script src="<?php echo base_url()?>vendors/dropzone/dist/min/dropzone.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url()?>build/js/custom.min.js"></script>
  </body>
</html>