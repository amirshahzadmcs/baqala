<?php 
$this->load->view("front/common/header"); ?>
<div class="wrappage">
<div class="header-top-bar fixed-top" style="background-color:#f0f2f5">
	<div class="container">
		<div class="back-btn">
			<a onclick="goBack()" href="javascript:void(0)">
				<i class="fa fa-angle-left"></i>
			</a>
		</div>
		<div class="category-name">
			New Password
		</div>
	</div>
</div>

<main class="main" style="margin-top:3.5rem">
	<div class="page-content pt-7 pb-2">
		<div class="checkout">
			<div class="container">
				<div class="row justify-content-center">
				    <img src="images/new-password.png" width="100%" style="max-width:300px" />
				</div>
				<div class="row p-5">
					<div class="col-lg-12">
                        <div id="ajax_response"></div>
                        <?php echo form_open('account/new_password1');?>
                            <input type="hidden" name="for_id" value="<?php echo $id;?>">
                            <input type="hidden" name="st" value="<?php echo $_GET['st']?>">
                            <div class="form-group">
                                <input type="password" required name="new_password" placeholder="New Password" class="form-control"/>
                            </div>
                            
                            <div class="form-group">
                                <input type="password" required name="confirm_password" placeholder="Confirm Password" class="form-control"/>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        <?php echo form_close();?>
					</div>
				</div>
			</div><!-- End .container -->
		</div><!-- End .checkout -->
	</div><!-- End .page-content -->
</main><!-- End .main -->

<?php 
    $this->load->view("front/common/footer-nav");
    $this->load->view("front/common/footer");
?>
  
<script type="text/javascript" >
    $(document).ready(function(e) {
        $('#forget_form').on('submit',function(e) {
                e.preventDefault();
                var email=$("#username").val();
                $.ajax({
                url: '<?php echo base_url() ?>account/check_user',
                type: "POST",
                data:{email:email},
                complete: function() {
                    $('.fa-spin').remove();
                },
                success: function(data){
                    $("#ajax_response").html('<div style="margin-bottom:10px;line-height:30px;padding:10px;border:1px solid #555;">'+data+'</div>');
                },
            });
        });
    });
</script>