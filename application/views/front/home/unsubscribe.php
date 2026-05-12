<?php $this->load->view("front/common/header");?>
<div class="wrappage">

    <div class="container-fluid">
    <ol class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Unsubscribe</li>        
      </ol>
    </div>
    
    <div class="container webcontent">
    	<div class="col-md-4 col-md-offset-4" style="border: 1px solid #d0d0d0;padding: 25px;">
    	    <LEGEND>Unsubscribe to our Newsletter </LEGEND>
    		<?php echo form_open("home/unsubscribe"); ?>
    			<div class="form-group">
    				<label>Email</label>
    				<input type="email" class="form-control" name="email" maxlength="120" required />
    			</div>
    			
    			<input type="submit" value="Unsubscribe" class="btn btn-primary" />
    		<?php echo form_close(); ?>
    	</div>
    
    </div>

</div>
	
<?php $this->load->view("front/common/footer"); ?>
<script>
    
</script>