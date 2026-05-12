$(document).bind("ajaxSend", function () {
	$("#wait").css("display", "block");
}).bind("ajaxComplete", function () {
	$("#wait").css("display", "none");
}).bind("ajaxError", function () {
	$("#wait").css("display", "none");
});

function addtocart(sid) {
	var qty = $("#"+sid).val();
	var size_id = $("#"+sid).data('size');
	var prod_id = $("#"+sid).data('product');
	$.ajax({
		url: base_url+'add-to-cart',
		type: "POST",
		data: {"product_id":prod_id, "size_id":size_id, "quantity": qty},
		beforeSend: function() {
			$("div.loading").html('<span class="load"><i class="fal fa-spinner fa-spin"></i></span>');
		},
		success: function(data){
			var result = JSON.parse(data);
			var cartnumber = result['in_cart'];
			$(".cart_load_ajax").load(" .cart_load_ajax");
			$("#cart_number").html(cartnumber);
			if(cartnumber > 0){
				$('.top-bar-right li.checkout button').prop("disabled", false);
			}else{
				$('.top-bar-right li.checkout button').prop("disabled", true);
			}
			show_message(data);
			$("div.loading").html('');
		},
		error: function (xhr) {
			alert(xhr.responseText);
			$("div.loading").html('');
		}
	});
}

function ordertocart(oid) {
	if (oid > 0) {
		if (confirm("Do you want to add these product in cart?") === true) {
			$.ajax({
				url: base_url+'copy-order-basket',
				type: "POST",
				data: {"order_id":oid},
				beforeSend: function() {
					$("div.loading").html('<span class="load"><i class="fal fa-spinner fa-spin"></i></span>');
				},
				success: function(data){
					var result = JSON.parse(data);
					var cartnumber = result['in_cart'];
					$(".cart_load_ajax").load(" .cart_load_ajax");
					$("#cart_number").html(cartnumber);
					if(cartnumber > 0){
						$('.top-bar-right li.checkout button').prop("disabled", false);
					}else{
						$('.top-bar-right li.checkout button').prop("disabled", true);
					}
					show_message(data);
					$("div.loading").html('');
				},
				error: function (xhr) {
					alert(xhr.responseText);
					$("div.loading").html('');
				}
			});
		} else {
			userPreference = "Action Cancelled!";
		}
	}else {
		alert("Unauthorized access");
	}
}

function quotationtocart(qid) {
	if (qid > 0) {
		if (confirm("Do you want to add these product in cart?") === true) {
			$.ajax({
				url: base_url+'copy-quotation-basket',
				type: "POST",
				data: {"quotation_id":qid},
				beforeSend: function() {
					$("div.loading").html('<span class="load"><i class="fal fa-spinner fa-spin"></i></span>');
				},
				success: function(data){
					var result = JSON.parse(data);
					var cartnumber = result['in_cart'];
					$(".cart_load_ajax").load(" .cart_load_ajax");
					$("#cart_number").html(cartnumber);
					if(cartnumber > 0){
						$('.top-bar-right li.checkout button').prop("disabled", false);
					}else{
						$('.top-bar-right li.checkout button').prop("disabled", true);
					}
					show_message(data);
					$("div.loading").html('');
				},
				error: function (xhr) {
					alert(xhr.responseText);
					$("div.loading").html('');
				}
			});
		} else {
			userPreference = "Action Cancelled!";
		}
	}else {
		alert("Unauthorized access");
	}
}

$('.address_popup').click(function(){
	var address_type = $(this).data('address');
	//alert(address_type);
	$('#address_type').val(address_type);
	$('#selectAddress').modal('show');
});

function checkoutAddress(aid) {
	$.ajax({
		url: base_url+'address-detail',
		type: "POST",
		data: {"address_id":aid},
		beforeSend: function() {
			$(".checkout-pg").append('<div class="loader"><i class="fal fa-spinner fa-spin"></i></div>');
			$('#selectAddress').modal('hide');
		},
		success: function(data){
			var result = JSON.parse(data);
			var address_for = $('#address_type').val();
			var html_content = '<span>'+ result.person_name +'<br>'+ result.building_villa_no +'<br>'+ result.street +'<br>'+ result.city +', '+ result.state +'<br>'+ result.postal +'<br>'+ result.country +'<span>';
			html_content += '<input type="hidden" name="delivery_address_id" id="delivery_address_id" value="'+ aid +'" required /> ';
			$('#delivery_address_text').html(html_content);
			//console.log(result.address_label);
			$(".checkout-pg .loader").remove();
		},
		error: function (xhr) {
			alert(xhr.responseText);
			$(".checkout-pg .loader").remove();
		}
	});
}

function removeCart(){
	$.ajax({
		url: '<?php echo base_url();?>order/remove_all_items',
		type: "POST",
		data: {"id":u},
		success:
		 function(data){
			var result = JSON.parse(data);
			cart_value_ajax();
			$("#cart_number").html(result['in_cart']);
		},
		error: function(){}
	});
}

function show_message(data){
    var result = JSON.parse(data);
    //console.log(result);
    if(result['success'] == '1'){
        $("#flash_message").html('<div class="alert alert-success alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
    }
    if(result['success'] == '0'){
        $("#flash_message").html('<div class="alert alert-danger alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
    }
    if(result['success'] == '2'){
        $("#flash_message").html('<div class="alert alert-warning alert-dismissible fade show" role="alert"> '+result['message']+' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 12px;padding: 1.1rem 1rem;"></button></div>');
    }
	setTimeout(function() {
		$('.close').click();
	}, 5000);
}

function closeSearch(){
	$(".searchResult").html('');
	$(".txt_search").val('');
	$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
}

$(document).ready(function(){
	$('.txt_search').on('search', function(evt) {
		$(".searchResult").html('');
		$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
	});

	$(".txt_search").keyup(function(){
		var search = $(this).val();

		if(search.length > 2){
			$.ajax({
				url: 'home/get_search_list',
				type: 'get',
				data: {term:search},
				//dataType: 'json',
				success:function(request){
					//console.log(request);
					$(".searchResult").empty();
					$('.searchResult').append(request);
					$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
				},
				error: function (request, error){
					console.log(" Can't do because: " + JSON.stringify(request));
					//alert(JSON.stringify(request));
				}
			});
		}else{
			$(".searchResult").html('');
			$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
		}
	});
});

/*----- Mobile Search -----*/
function closeMobSearch(){
	$(".searchResultMob").html('');
	$(".txt_search_mob").val('');
	$("#searchModal").hide();
	$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
}

$(document).ready(function(){
	$('.txt_search_mob').on('search', function(evt) {
		$(".searchResultMob").html('');
		$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
	});

	$(".txt_search_mob").keyup(function(){
		var search = $(this).val();

		if(search.length > 2){
			$.ajax({
				url: 'home/get_search_list',
				type: 'get',
				data: {term:search},
				//dataType: 'json',
				success:function(request){
					//console.log(request);
					$(".searchResultMob").empty();
					$('.searchResultMob').append(request);
					$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
				},
				error: function (request, error){
					console.log(" Can't do because: " + JSON.stringify(request));
					//alert(JSON.stringify(request));
				}
			});
		}else{
			$(".searchResultMob").html('');
			$('body').css('overflow', $('body').css('overflow') == 'hidden' ? 'auto' : 'hidden');
		}
	});
});

/*		
var changeLang = function(lang){
	//alert(lang);
	$.ajax({
		url: 'home/setLang',
		type: "POST",
		data: {"lang":lang},
		success:
		function(data){
			location.reload();
		},
		error: function(){}
	});
}
*/
