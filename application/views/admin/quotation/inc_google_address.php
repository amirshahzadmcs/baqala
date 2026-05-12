<div class="col-md-6 form-group">
    <label for="contact_person_name">Contact Person Name:</label>
    <input type="text" class="form-control" id="contact_person_name" placeholder="Enter contact person name" name="contact_person_name" required />
</div>
<div class="col-md-6 form-group">
    <label for="shipping_email">Shipping Email:</label>
    <input type="email" class="form-control" id="shipping_email" placeholder="Enter email id" name="shipping_email" required />
</div>
<div class="col-md-6 form-group">
    <label for="shipping_mobile">Shipping Mobile Number:</label>
    <input type="text" class="form-control" id="shipping_mobile" placeholder="Enter mobile number" name="shipping_mobile" required />
</div>
<div class="col-md-12 form-group">
    <label>Shipping Address:</label>
    <div id="map"></div>
    <div id="infowindow-content">
    <img src="" width="16" height="16" id="place-icon" />
    <span id="place-name" class="title"></span><br />
    <span id="place-address"></span>
    </div>
    <div class="pac-card" id="pac-card">
    <div id="pac-container">
        <input id="pac-input" type="text" placeholder="Enter location name" />
    </div>
    </div>
</div>
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
<div class="col-md-6 form-group">
    <label class="form-label">Select Address Type</label><br/>
    <div class="col-md-6">
        <input class="form-check-input" type="radio" name="house_type" id="house_type1" value="1">
        <label class="form-check-label" for="house_type1">Villa</label>
    </div>
    <div class="col-md-6">
        <input class="form-check-input" type="radio" name="house_type" id="house_type2" value="2">
        <label class="form-check-label" for="house_type2">Building</label>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="form-label" id="villa_label">Villa No.</label>
    <input name="villa_building" type="text" class="form-control" required />
</div>
<div class="col-md-6 form-group">
    <label style="width:100%">Save as</label>
    <div class="col-md-4">
    <label class="radio-label active"> <input type="radio" value="Home" name="address_type" id="option1" checked /> Home</label>
    </div>
    <div class="col-md-4">
    <label class="radio-label"> <input type="radio" value="Work" name="address_type" id="option2" /> Work</label>
    </div>
    <div class="col-md-4">
    <label class="radio-label"> <input type="radio" value="Other" name="address_type" id="option3" /> Other</label>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="form-label">Delivery Instructions</label>
    <input id="instruction" name="instruction" type="text" class="form-control" />
</div>
<div class="col-md-12">
    <div class="bg-success" style="padding: 10px;color: #000;">
        <div class="d-flex align-items-center mb-2">
            <p class="mb-0 h6">Your Selected Address</p>
        </div>
        <p class="small m-0" id="formated_addr"></p>
    </div>
</div>
