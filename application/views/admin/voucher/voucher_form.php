<?php $this->load->view('admin/home/header');?>
<div class="page-title">
<div class="title_left">
<h3>Recharge Voucher</h3>
</div>
<div class="title_right">
<a class="btn btn-sm btn-default pull-right"  data-toggle="tooltip" title="Back" href="<?php echo base_url();?>admin/voucher"><i class="fa fa-reply"></i></a>
</div>
</div>
<div class="clearfix"></div>


<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
<h5><i class="fa fa-pencil"></i> Generate Recharge Voucher</h5>
<div class="clearfix"></div>
</div>
<div class="x_content">
<br />
<div class="col-md-6">
<?php
$StartingDate = date("Y-m-d");  // todays date as a timestamp
$newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($StartingDate)) . " + 365 day"));
?>
<form role="form" method="post" action="<?php echo base_url('admin/voucher/generate_vouchers');?>" id="voucher_form">
    <div class="box-body">
		<div class="form-group">
            <label for="voucher_name">Voucher Group Name </label>
            <input type="text" class="form-control" id="voucher_name" name="voucher_name" placeholder="Voucher Group By." required />
        </div>
		
        <div class="form-group">
            <label for="no_of_voucher">No. of vouchers</label>
            <input type="number" class="form-control" id="no_of_voucher" name="no_of_voucher" placeholder="Number of codes to generate." required />
        </div>
		
		<div class="form-group">
            <label for="voucher_value">Vouchers Value</label>
            <input type="number" class="form-control" maxlength="5" min="1" max="99999" id="voucher_value" name="voucher_value" placeholder="Amount of voucher" />
        </div>
		
		<div class="form-group">
            <label for="expiry">Expiry Date</label>
            <input type="date" class="form-control" id="expiry" name="expiry" value="<?php echo $newEndingDate; ?>" placeholder="Voucher Expiry Date" required />
        </div>
		
        <p>Your code will be look like <b>####-####-####-#### (*if it is 16 character)</b></p>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary">Generate</button>
    </div>
</form>
</div>
<div class="col-md-6">
	<div id="result" class="text-center hide">
		<div id="msg" style="padding:10px;border:1px solid #000;background-color: #28a528;color: #fff;font-weight: 600;text-align: center;"></div><br/>
		<h4>Generate csv file</h4>
		<form role="form" method="post" id="exportCSV">
			<input type="hidden" class="form-control" name="voucher_data" id="voucher_data" required />
			<button type="submit" class="btn btn-primary">Export CSV</button>
		</form>
	</div>
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view('admin/home/footer');?>
<script>
$('#voucher_form').on('submit', (function(e) {
	//alert('test');exit();
	e.preventDefault();
	$.ajax({
		url: $('#voucher_form').attr('action'),
		type: "POST",
		data:  new FormData(this),
		//dataType: 'json',
		contentType: false,
		cache: false,
		processData:false,
		success: 
		//showResponse,
		function(data){
			console.log(data);
			$('#voucher_data').val(data);
			$("#result").removeClass("show");
			$("#result").addClass("show");
			$("#msg").html('Vouchers successfully generated.');
		},
		error: function(data){
			console.log('An error occurred.');
            console.log(data);
		}
	});
})); 

$(document).ready(function(){
    $('#exportCSV').on('submit', (function(e) {
		//alert('test');exit();
		e.preventDefault();
        var data = $('#voucher_data').val();
        if(data == '')
            return;
        
        JSONToCSVConvertor(data, "_voucher_list", true);
    }));
});

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    /*
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    */
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = Date.now();
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>
