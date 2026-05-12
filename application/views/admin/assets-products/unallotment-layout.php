<form class="needs-validation" id="unallotment_form" method="POST" action="<?php echo base_url('admin/assets/product/unallot-product');?>">
    <input type="hidden" id="assets_id" name="assets_id" value="<?php echo $prod_detail->id;?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="remarks" id="remarks" rows="5" placeholder="Write remarks here..." class="form-control" required></textarea>
            </div>
        </div>
        <div>
            <button class="btn btn-custom-success" type="submit">Submit form</button>
        </div>
    </div>
</form>
<script>
    $('.select2').select2({
        placeholder: 'Select an option'
    });
</script>