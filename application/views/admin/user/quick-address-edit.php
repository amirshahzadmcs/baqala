<?php echo form_open("admin/business-user/submit-corporate-address", array("id"=>"bs-edit-address", "enctype"=>"multipart/form-data", "class"=>"form-horizontal form-label-left")); ?>
    <div class="row">
        <input type="hidden" name="customer_id" value="<?= $customer_id;?>" required="required" />
        <input type="hidden" name="address_id" value="<?= $id;?>" required="required" />
        <div class="col-md-6  mb-3 form-group">
            <label for="address_label">Address Label <span class="required">*</span></label>
            <input type="text" class="form-control" id="address_label" name="address_label" value="<?= $address_label;?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="person_name">Name <span class="required">*</span></label>
            <input type="text" class="form-control" id="person_name" name="person_name" value="<?= $person_name;?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="company_name">Company <span class="required">*</span></label>
            <input type="text" class="form-control" id="company_name" name="company_name" value="<?= $company_name;?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="country">Country <span class="required">*</span></label>
            <select id="country" name="country" class="form-control col-md-12 select2" required="required">
                <option value="">Selct Country</option>
                <option value="Saudi Arabia" <?php echo ($country == 'Saudi Arabia') ? "selected":"";?>>Saudi Arabia</option>
            </select>
        </div>
        <div class="col-md-6 mb-3 form-group">
            <label for="city">City <span class="required">*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="<?= $city;?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="street">Street <span class="required">*</span></label>
            <textarea id="street" name="street" class="form-control" required="required"><?= $street;?></textarea>
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="floor">Floor <span class="required">*</span></label>
            <input type="text" class="form-control" id="floor" name="floor" value="<?= $floor;?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="postal">Postal <span class="required">*</span></label>
            <input type="text" class="form-control" id="postal" name="postal" value="<?= $postal;?>" onkeypress="return numerics(event);" minlength="<?= ZIP_LENGTH; ?>" maxlength="<?= ZIP_LENGTH; ?>" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="mobile">Mobile <span class="required">*</span></label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $mobile;?>" maxlength="15" required="required" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="phone">Phone </label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone;?>" maxlength="15" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="extension">Extension </label>
            <input type="text" class="form-control" id="extension" name="extension" value="<?= $extension;?>" maxlength="255" />
        </div>
        <div class="col-md-6  mb-3 form-group">
            <label for="email">Email </label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $email;?>" maxlength="255" />
        </div>
        <div class="col-md-6 mb-3 form-group">
            <label for="reference">Reference </label>
            <input type="text" class="form-control" id="reference" name="reference" value="<?= $reference;?>" maxlength="255" />
        </div>
        <div class="col-md-12 mb-3 form-group">
            <label for="map_location">Map Location</label>
            <textarea id="map_location" name="map_location" class="form-control"><?= $map_location;?></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-sm btn-custom-success float-end" title="Save"> Save Address </button>
        </div>
    </div>
<?php echo form_close(); ?>
