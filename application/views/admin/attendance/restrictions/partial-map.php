<div id="map"></div>
<div id="infowindow-content">
	<img src="" width="16" height="16" id="place-icon" />
	<span id="place-name" class="title"></span><br />
	<span id="place-address"></span>
</div>
<div class="pac-card" id="pac-card">
	<div id="pac-container">
		<input id="pac-input" type="text" placeholder="Search location name" />
	</div>
</div>
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
		  $('#s_street').val('');
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

		$("#maplat").val(geoResults.geometry.location.lat());
		$("#maplng").val(geoResults.geometry.location.lng());
		$("#map_location").val(geoResults.geometry.location.lat()+','+geoResults.geometry.location.lng());

		//$("#location_type").html(geoResults[0].geometry.location_type);
		$("#place_id").val(geoResults.place_id);

		var component = geoResults.address_components;

		component.map(componentResult => {
			const types = componentResult.types
			//console.log(types.includes('administrative_area_level_2'));
			/*
			if (types.includes('premise')) {
				$('#house_no').val(componentResult.long_name);
			}*/
		})

		/*
		geoResults.map(geoResult => {
		})*/
	}
</script>
