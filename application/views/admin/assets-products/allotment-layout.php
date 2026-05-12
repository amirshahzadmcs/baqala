<form class="needs-validation" id="allotment_form" method="POST" action="<?php echo base_url('admin/assets/product/allot-product');?>">
    <input type="hidden" id="assets_id" name="assets_id" value="<?php echo $prod_detail->id;?>">
    <input type="hidden" id="designation" name="emp_designation" value="">
    <input type="hidden" id="emp_type" name="emp_type" value="">
    <input type="hidden" id="emp_name" name="emp_name" value="">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="emp_id" class="form-label">Select Employee <span class="text-danger">*</span></label>
                <select class="form-select select2" name="emp_id" id="allot_emp_id" required>
                    <option value="">--- Select Employee ---</option>
                    <?php 
                    foreach(employeeListHelper() as $emp_list){?>
                    <option value="<?php echo $emp_list->id;?>" data-design="<?php echo $emp_list->position;?>" data-db="master_employee" data-name="<?php echo $emp_list->name;?>"><?php echo $emp_list->name;?> - Employee</option>
                    <?php } ?>
                    <?php 
                    foreach(deliveryBoyList() as $emp_list){?>
                    <option value="<?php echo $emp_list->id;?>" data-design="<?php echo (($emp_list->service_type == 'car') ? 'Driver' : 'Rider');?>" data-db="delivery_vehicles" data-name="<?php echo $emp_list->name;?>"><?php echo $emp_list->name;?> - Rider</option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">
                    Please select a employee for allotment.
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="allotment_date" class="form-label">Allotment Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="allotment_date" name="allotment_date" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea name="allot_remarks" id="allot_remarks" rows="5" placeholder="Write remarks here..." class="form-control"></textarea>
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

    $('#allot_emp_id').on('change', function(e) {
        e.preventDefault();
        var emp_desig = $('#allot_emp_id').find(":selected").data('design');
        var tab_name = $('#allot_emp_id').find(":selected").data('db');
        var emp_name = $('#allot_emp_id').find(":selected").data('name');
        if(emp_desig !== '' || tab_name !== '' || emp_name !== ''){
            $('#designation').val(emp_desig);
            $('#emp_type').val(tab_name);
            $('#emp_name').val(emp_name);
        }else{
            $('#allot_emp_id').val('');
            alert('Incomplete data of selected user!');
        }
    });
</script>