<?php $this->load->view("front/common/header");?>
<style type="text/css">
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map{
	height: 60vh;
	margin-bottom: 10px;
	box-shadow: 1px 2px 2px #bbbbbb;
}
  #description {
	font-family: Roboto;
	font-size: 15px;
	font-weight: 300;
  }

  #infowindow-content .title {
	font-weight: bold;
  }

  #infowindow-content {
	display: none;
  }

  #map #infowindow-content {
	display: inline;
  }

  .pac-card {
	margin: 0px;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    position: relative !important;
  }

  #pac-container {
	padding: 12px;
  }

  .pac-controls {
	display: inline-block;
	padding: 5px 11px;
  }

  .pac-controls label {
	font-family: Roboto;
	font-size: 13px;
	font-weight: 300;
  }

  #pac-input {
	background-color: #fff;
    font-size: 15px;
    font-weight: 300;
    padding: 0 10px;
    text-overflow: ellipsis;
    width: 100%;
	height: 30px;
    border: 1px solid #409844;
  }

  #pac-input:focus {
	border-color: #4d90fe;
  }

  #title {
	color: #fff;
	background-color: #4d90fe;
	font-size: 25px;
	font-weight: 500;
	padding: 6px 12px;
  }
</style>

<div class="osahan-order_address">
    <div class="p-3 border-bottom fixed-top" style="background-color:#f0f2f5">
        <div class="d-flex align-items-center">
            <a class="font-weight-bold text-success text-decoration-none" onclick="goBack()" href="javascript:void(0)"> <i class="icofont-rounded-left back-page"></i></a>
            <h5 class="font-weight-bold m-0 ml-3"><?php echo $this->lang->line('msg_add') ?></h5>
            <a class="toggle ml-auto hc-nav-trigger hc-nav-1" href="#"><i class="icofont-navigation-menu"></i></a>
        </div>
    </div>
    <div id="map" style="margin-top:3.5rem"></div>

    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon" />
      <span id="place-name" class="title"></span><br />
      <span id="place-address"></span>
    </div>
	<div class="pac-card" id="pac-card">
      <div id="pac-container">
        <input id="pac-input" type="text" placeholder="<?php echo $this->lang->line('msg_enter_your_location') ?>" />
      </div>
    </div>
	<div class="form-content px-2 pb-4">
		<div id="locationList" class="my-3">
			<div class="p-3 rounded bg-success text-white shadow-sm w-100">
				<div class="d-flex align-items-center mb-2">
					<p class="mb-0 h6"><?php echo $this->lang->line('msg_your_address') ?></p>
				</div>
				<p class="small m-0" id="formated_addr"></p>
			</div>
		</div>
		<?php echo form_open("account/add_address", array("id"=>"address_form"));?>
			<div class="form-row">
				<input type="hidden" id="address_id" name="id" value="" />
				<input type="hidden" id="house_no" name="house_no" value="" />
				<input type="hidden" id="street" name="street" value="" required />
				<input type="hidden" id="sector" name="sector" value="" />
				<input type="hidden" id="locality" name="locality" value="" />
				<input type="hidden" id="city" name="city" value="" required />
				<input type="hidden" id="state" name="state" value="" required />
				<input type="hidden" id="country" name="country" value="" required />
				<input type="hidden" id="postal_code" name="postal_code" value="" required />
				<input type="hidden" id="lat" name="lat" value="" />
				<input type="hidden" id="lng" name="lng" value="" />
				<input type="hidden" id="place_id" name="place_id" value="" required />
				<input type="hidden" id="complete_address" name="complete_address" value="" required />
				<div class="col-md-12 form-group">
					<label class="form-label"><?php echo $this->lang->line('msg_person_name'); ?></label>
					<input name="name" id="name" type="text" class="form-control" required />
				</div>
				<div class="col-md-12 form-group">
					<label class="form-label"><?php echo $this->lang->line('msg_mobile'); ?></label>
					<input name="mobile" id="mobile" type="text" class="form-control" required />
				</div>
				<div class="col-md-12 form-group">
					<label class="form-label"><?php echo $this->lang->line('msg_sel_add_type'); ?></label><br/>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="house_type" id="house_type1" value="1">
						<label class="form-check-label" for="house_type1"><?php echo $this->lang->line('msg_villa'); ?></label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="house_type" id="house_type2" value="2">
						<label class="form-check-label" for="house_type2"><?php echo $this->lang->line('msg_building'); ?></label>
					</div>
				</div>
				<div class="col-md-12 form-group">
					<label class="form-label" id="villa_label"><?php echo $this->lang->line('msg_villa_no'); ?></label>
					<input name="villa_building" type="text" class="form-control" required />
				</div>
				<div class="col-md-12 form-group">
					<label class="form-label"><?php echo $this->lang->line('msg_delev_inst'); ?></label>
					<input id="instruction" name="instruction" type="text" class="form-control" />
				</div>
				<div class="mb-0 col-md-12 form-group">
					<label class="form-label"><?php echo $this->lang->line('msg_save_as'); ?></label>
					<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
						<label class="btn btn-outline-secondary radio-label active"> <input type="radio" value="Home" name="address_type" id="option1" checked /> <?php echo $this->lang->line('msg_home'); ?><?php echo $this->lang->line('msg_delev_inst'); ?> </label>
						<label class="btn btn-outline-secondary radio-label"> <input type="radio" value="Work" name="address_type" id="option2" /> <?php echo $this->lang->line('msg_work'); ?> </label>
						<label class="btn btn-outline-secondary radio-label"> <input type="radio" value="Other" name="address_type" id="option3" /> <?php echo $this->lang->line('msg_other'); ?> </label>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
	<!-- continue -->
	<div class="fixed-bottom">
		<button form="address_form" type="submit" class="btn btn-success btn-lg btn-block" id="submit_address"><?php echo $this->lang->line('msg_confirm_address') ?></button>
	</div>
</div>
<?php $this->load->view("front/common/footer");?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCL2JAl_JhBNZHOOm34cEN0jZb_TfVORSk&callback=initMap&libraries=places&v=weekly" defer></script>
<script>
	// This example requires the Places library. Include the libraries=places
	// parameter when you first load the API. For example:

	function initMap() {

		const map = new google.maps.Map(document.getElementById("map"), {
		  center: { lat: 23.885942, lng: 45.079163 },
		  zoom: 13,
		});
		const card = document.getElementById("pac-card");
		const input = document.getElementById("pac-input");
		map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
		const autocomplete = new google.maps.places.Autocomplete(input);
		// Bind the map's bounds (viewport) property to the autocomplete object,
		// so that the autocomplete requests use the current map bounds for the
		// bounds option in the request.
		autocomplete.bindTo("bounds", map);
		// Set the data fields to return when the user selects a place.
		autocomplete.setFields([
		  "address_components",
		  "formatted_address",
		  "geometry",
		  "place_id",
		  "icon",
		  "name",
		]);
		const infowindow = new google.maps.InfoWindow();
		const infowindowContent = document.getElementById("infowindow-content");
		infowindow.setContent(infowindowContent);
		const marker = new google.maps.Marker({
			map,
			anchorPoint: new google.maps.Point(0, -29),
		});
		autocomplete.addListener("place_changed", () => {
		  infowindow.close();
		  marker.setVisible(false);
		  const place = autocomplete.getPlace();
		  if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			window.alert(
			  "No details available for input: '" + place.name + "'"
			);
			return;
		  }

		  // If the place has a geometry, then present it on a map.
		  if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		  } else {
			map.setCenter(place.geometry.location);
			map.setZoom(17); // Why 17? Because it looks good.
		  }
		  marker.setPosition(place.geometry.location);
		  marker.setVisible(true);
		  let address = "";

		  if(place.address_components) {
			populateCard(place);
			address = [
			  (place.address_components[0] &&
				place.address_components[0].short_name) ||
				"",
			  (place.address_components[1] &&
				place.address_components[1].short_name) ||
				"",
			  (place.address_components[2] &&
				place.address_components[2].short_name) ||
				"",
			].join(" ");
		  }
		  infowindowContent.children["place-icon"].src = place.icon;
		  infowindowContent.children["place-name"].textContent = place.name;
		  infowindowContent.children["place-address"].textContent = address;
		  infowindow.open(map, marker);
		});

		// Sets a listener on a radio button to change the filter type on Places
		// Autocomplete.
		function setupClickListener(id, types) {
		  const radioButton = document.getElementById(id);
		  radioButton.addEventListener("click", () => {
			autocomplete.setTypes(types);
		  });
		}
		setupClickListener("changetype-all", []);
		setupClickListener("changetype-address", ["address"]);
		setupClickListener("changetype-establishment", ["establishment"]);
		setupClickListener("changetype-geocode", ["geocode"]);
		document
		  .getElementById("use-strict-bounds")
		  .addEventListener("click", function () {
			console.log("Checkbox clicked! New state=" + this.checked);
			autocomplete.setOptions({ strictBounds: this.checked });
		  });
	}

	populateCard = (geoResults) => {
		// check if a the container has a child node to force re-render of dom
		//removeAddressCards();
		//console.log(geoResults.geometry.location.lat());

		$("#complete_address").val(geoResults.formatted_address);
		$("#formated_addr").html(geoResults.formatted_address);

		$("#lat").val(geoResults.geometry.location.lat());
		$("#lng").val(geoResults.geometry.location.lng());

		//$("#location_type").html(geoResults[0].geometry.location_type);
		$("#place_id").val(geoResults.place_id);

		var component = geoResults.address_components;

		component.map(componentResult => {
			const types = componentResult.types
			if (types.includes('premise')) {
				$('#house_no').val(componentResult.long_name);
			}
			if (types.includes('sublocality_level_2')) {
				$('#street').val(componentResult.long_name);
			}
			if (types.includes('sublocality_level_1')) {
				$('#sector').val(componentResult.long_name);
			}
			if (types.includes('locality')) {
				$('#locality').val(componentResult.long_name);
			}
			if (types.includes('administrative_area_level_2')) {
				$('#city').val(componentResult.long_name);
			}
			if (types.includes('administrative_area_level_1')) {
				$('#state').val(componentResult.long_name);
			}
			if (types.includes('country')) {
				$('#country').val(componentResult.long_name);
			}
			if (types.includes('postal_code')) {
				$('#postal_code').val(componentResult.long_name);
			}
		})

		/*
		geoResults.map(geoResult => {
		})*/
	}

	$('#address_form').on('submit', (function(e) {
		//alert('test');

		e.preventDefault();
		var full_address = $('#complete_address').val();
		if(full_address !== ''){
			$.ajax({
				url: '<?php echo base_url();?>account/add_address',
				type: "POST",
				data:  new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success:
				//showResponse,
				function(data){
					window.location.href = "order-address";
				},
				error: function(data){
					alert(data);
				}
			});
		}else{
			alert('Please select address first.');
		}
	}));

	$('input:radio[name="house_type"]').change(function() {
        if ($(this).val() == '1') {
            $('#villa_label').html('Villa Number');
        } else {
            $('#villa_label').html('Floor & Flat No.');
        }
    });

	$("#number").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#errmsg").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg").html("Input  14 Digits Only").show();
			return false;
		}
	});

	$("#form_mobile").on("keypress",function(e){
		if($(this).val().length<='12'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#errmsg1").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errmsg1").html("Maximum input 12 Digits Only").show();
			return false;
		}
	});

	$("#postal").on("keypress",function(e){
		if($(this).val().length<='6'){
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {

				$("#errpost").html("Digits Only").show();
				return false;
			}
		}else{
			$("#errpost").html("Maximum input 6 Digits Only").show();
			return false;
		}
	});
</script>
