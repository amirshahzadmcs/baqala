<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo WEBSITE_NAME; ?></title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
	<div class="login_wrapper">
		
		<?php if($this->admin->getInfo()){ 

		$info = explode("--", $this->admin->getInfo());

		$info_type = $info[0];

		$msg_data = $info[1];

		if($info_type == 2){

 ?>  

 <div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>

		<?php } else{?>

		 <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-label="close">x</button>

		<?php } echo $msg_data; ?> </div><?php } $this->admin->removeInfo();?>
				
	</div>
  
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="<?php echo base_url()?>admin/common/reset_password" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<h1>Reset password</h1>
                      
                          <input type="hidden" name="token" value="<?php echo $this->input->get('token');?>" class="form-control col-md-7 col-xs-12">
                       
					  
					  <div>
                       
                        
                          <input type="password" name="new_password" placeholder="New Password" required="required" class="form-control col-md-7 col-xs-12">
                     
                      </div>
					  
					  <div>
                        
                          <input type="password"  name="confirm" required="required" placeholder="Confirm Password" class="form-control col-md-7 col-xs-12">
                        
                      </div>
					  
	
                    
                      <div class="ln_solid"></div>
					
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <input type="submit" name="submit" class="btn btn-success">
                        </div>
                      </div>

                    </form>
              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> <?php echo WEBSITE_NAME; ?></h1>
                  <p>©<?php echo date("Y");?> All Rights Reserved. <?php echo WEBSITE_NAME; ?> Privacy and Terms</p>
                </div>
              </div>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>







