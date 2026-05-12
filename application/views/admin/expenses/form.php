<?php $this->load->view('admin/home/header');?>
<style>
.dataTables_filter {
    width: 27%;
    float: right;
    text-align: right;
}
.select2-container {
    width: 100% !important;
	max-height:34px;
}
.select2-container--default .select2-selection--multiple, .select2-container--default .select2-selection--single {
    min-height: 34px !important;
}
fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1em 1em 1em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}
legend {
    display: block;
    width: auto;
    padding: 5px;
    margin-bottom: 20px;
    font-size: 17px;
    line-height: inherit;
    color: #484848;
    border: 0;
    border-bottom: none;
}
ul.bar_tabs {
    overflow: visible;
    background: #ffffff;
    height: 25px;
    margin: 21px 0 14px;
    padding-left: 0px;
    position: relative;
    z-index: 1;
    width: 100%;
    border-bottom: 1px solid #E6E9ED;
}
ul.bar_tabs>li.active {
    border-right: 6px solid #00d541;
    border-top: 0;
    margin-top: -15px;
}
</style>
<div class="page-title">
<div class="title_left">
<h3>Expenses VAT Entry</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/expenses"><i class="fa fa-reply"></i></a>
<button form="demo-form2" type="submit" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
</div>
</div>
<div class="clearfix"></div>
			  
			  
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	  <div class="x_title">
		<h5><i class="fa fa-pencil"></i> Expenses VAT Entry</h5>
		   <div class="clearfix"></div>
	  </div>
	  <div class="x_content">
		<br />
		<?php echo form_open("admin/expenses/add_expenses", array("id"=>"demo-form2", "enctype"=>"multipart/form-data", "class"=>"form-label-left", "data-parsley-validate"=> "")); ?>
			<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
			<fieldset class="scheduler-border">
				<legend class="scheduler-border">Expenses VAT Information:</legend>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="branch_code">Branch Code :</label>
					<input type="text" class="form-control" id="branch_code" name="branch_code" value="<?php echo $branch_code;?>"  maxlength="150" />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="date">Date * :</label>
					<input type="date" class="form-control" id="date" name="date" value="<?php echo $date;?>" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="invoice_number">Invoice Number * :</label>
					<input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?php echo $invoice_number;?>" maxlength="150" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="item_description">Item Description * :</label>
					<input type="text" class="form-control" id="item_description" name="item_description" value="<?php echo $item_description;?>" maxlength="150" required />
				</div>
				
				<div class="col-md-4 col-sm-4 form-group">
					<label for="supplier_name">Supplier Name *:</label>
					<input type="text" onKeyPress="return Alpha(event);" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo $supplier_name;?>" maxlength="150" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="supplier_arabic_name">Supplier Arabic Name:</label>
					<input type="text" class="form-control" id="supplier_arabic_name" name="supplier_arabic_name" value="<?php echo $supplier_arabic_name;?>" maxlength="120" />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="supplier_vat_no">Supplier VAT No *:</label>
					<input type="text" class="form-control" id="supplier_vat_no" name="supplier_vat_no" value="<?php echo $supplier_vat_no;?>" maxlength="50" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="cr_no">CR No:</label>
					<input type="text" class="form-control" id="cr_no" name="cr_no" value="<?php echo $cr_no;?>" maxlength="50" />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="amt_bef_vat">Amount Without VAT * :</label>
					<input type="text" class="form-control" id="amt_bef_vat" name="amt_bef_vat" placeholder="Eg: 95" value="<?php echo $amt_bef_vat;?>" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="tax">Tax :</label>
					<input type="text" class="form-control" id="tax" name="tax" value="<?php echo $tax;?>" placeholder="Eg: 5" maxlength="15" />
				</div>
				
				<div class="col-md-4 col-sm-4 form-group">
					<label for="total">Inclusive * :</label>
					<input type="text" class="form-control" id="total" name="total" value="<?php echo $total;?>" placeholder="Eg: 100" maxlength="15" required />
				</div>
				<div class="col-md-4 col-sm-4 form-group">
					<label for="image">Attatchment (If any) :</label>
					<input type="file" class="form-control" id="image" name="image" />
					<input type="hidden" name="o_img" value="<?php echo $o_img;?>" />
				</div>
				<div class="col-md-12">
					<img src="<?php echo base_url().$o_img;?>" width="100px" style="float:right" />
				</div>
			</fieldset>
		<?php echo form_close(); ?>
	  </div>
	</div>
  </div>
</div>
<?php $this->load->view('admin/home/footer');?>

<script type="text/javascript">
  $(document).ready(function(){
     $("#number").on("keypress",function(e){
      if($(this).val().length<='15'){
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
          
          $("#errmsg").html("Digits Only").show();
          return false;
        }
      }else{
          $("#errmsg").html("Input Maxium 15 Digits Only").show();
          return false;
      }
     });
     });
</script>
<script>
    function Alpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }
	
    function numerics(key) {
           //getting key code of pressed key
           // alert($(this).val());
           var keycode = (key.which) ? key.which : key.keyCode;
           //comparing pressed keycodes

           if (keycode > 31 && (keycode < 48 || keycode > 57)) {
               alert(" You can enter only characters 0 to 9 ");
               return false;
           }
           else return true;


       }
</script> 
