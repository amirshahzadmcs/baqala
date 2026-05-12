// Asset Management js

// App setting Edit Model
$(function () {
    $('.admin_edit_condition').on('click', function (e) {
        e.preventDefault();
        $('#conditionModal').find('form').attr('id', 'admin_edit_condition').attr('action', 'admin/asset/edit-condition');
        $('#conditionModal').find('.modal-title').html('Edit Asset Condition');
        $('#conditionModal').find('.submit_button').attr('form', 'admin_edit_condition');
        $('.condition_id').val($(this).attr('condition_id'));
        $('.condition_name').val($(this).attr('condition_name'));
        $('.condition_ar_name').val($(this).attr('condition_ar_name'));
        $('#conditionModal').modal('show');

    });

    $('.admin_edit_asset_brand').on('click', function (e) {
        e.preventDefault();
        $('#brandModal').find('form').attr('id', 'admin_edit_brand').attr('action', 'admin/asset/edit-brand');
        $('#brandModal').find('.modal-title').html('Edit Asset brand');
        $('#brandModal').find('.submit_button').attr('form', 'admin_edit_brand');
        var brand_category = $(this).attr('brand_category_ids');
        $('.brand_id').val($(this).attr('brand_id'));
        $('.brand_name').val($(this).attr('brand_name'));
        $('.brand_ar_name').val($(this).attr('brand_ar_name'));
        $('#brandCategory').combotree('setValue', JSON.parse(brand_category));
        $('#brandModal').modal('show');
    });

    $('.admin_edit_asset_model').on('click', function (e) {
        e.preventDefault();
        var model_brand_id = $(this).attr('model_brand_id');
        $('#modelModal').find('form').attr('id', 'admin_edit_model').attr('action', 'admin/asset/edit-model');
        $('#modelModal').find('.modal-title').html('Edit Asset model');
        $('#modelModal').find('.submit_button').attr('form', 'admin_edit_model');
        $('.model_id').val($(this).attr('model_id'));
        $('.model_name').val($(this).attr('model_name'));
        $('.model_ar_name').val($(this).attr('model_ar_name'));
        $(".model_brand_id").select2().select2('val', model_brand_id);
        $('#modelModal').modal('show');
    })
    // Inventory Setting
    $('.admin_edit_unit').on('click', function (e) {
        e.preventDefault();
        $('#unitModal').find('form').attr('id', 'admin_edit_unit').attr('action', 'admin/asset/inventory/edit-unit');
        $('#unitModal').find('.modal-title').html('Edit Unit');
        $('#unitModal').find('.submit_button').attr('form', 'admin_edit_unit');
        $('.unit_id').val($(this).attr('unit_id'));
        $('.unit_name').val($(this).attr('unit_name'));
        $('.unit_ar_name').val($(this).attr('unit_ar_name'));
        $('.unit_description').val($(this).attr('unit_description'));
        $('#unitModal').modal('show');
    });

    $('.admin_edit_movement').on('click', function (e) {
        e.preventDefault();
        $('#movementModal').find('form').attr('id', 'admin_edit_movement').attr('action', 'admin/asset/inventory/edit-movement');
        $('#movementModal').find('.modal-title').html('Edit Unit');
        $('#movementModal').find('.submit_button').attr('form', 'admin_edit_movement');
        $('.movement_id').val($(this).attr('movement_id'));
        $('.movement_name').val($(this).attr('movement_name'));
        $('.movement_ar_name').val($(this).attr('movement_ar_name'));
        $(".movement_type").select2("val", $(this).attr('movement_type'));
        $('#movementModal').modal('show');
    });




    //  App Setting Hide Model Event
    $(document).on('hidden.bs.modal', '.modal', function () {
        var form = $(this).find('form');
        if ($(this).find('form').attr('id') == 'admin_add_condition') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'admin_edit_condition') {
            $(this).find('form').attr('id', 'admin_add_condition').attr('action', 'admin/asset/create-condition');
            $(this).find('.submit_button').attr('form', 'admin_add_condition');
            $(this).find('.modal-title').html('Add Asset Condition');
            $(this).find('form').trigger('reset');
        }
        // asset brand 
        if ($(this).find('form').attr('id') == 'admin_add_brand') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'admin_edit_brand') {
            $('#brandCategory').combotree('setValue', '');
            $(this).find('form').attr('id', 'admin_add_brand').attr('action', 'admin/asset/create-brand');
            $(this).find('.submit_button').attr('form', 'admin_add_brand');
            $(this).find('.modal-title').html('Add Asset brand');
            $(this).find('form').trigger('reset');
        }

        if ($(this).find('form').attr('id') == 'admin_add_model') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'admin_edit_model') {
            $(this).find('form').attr('id', 'admin_add_model').attr('action', 'admin/asset/create-model');
            $(this).find('.submit_button').attr('form', 'admin_add_model');
            $(this).find('.modal-title').html('Add Asset Model');
            $(this).find('form').trigger('reset');
            $(".model_brand_id").select2().select2('val', model_brand_id);
        }

        // Inventory Setting
        if ($(this).find('form').attr('id') == 'admin_add_unit') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'admin_edit_unit') {
            $(this).find('form').attr('id', 'admin_add_unit').attr('action', 'admin/asset/inventory/create-unit');
            $(this).find('.submit_button').attr('form', 'admin_add_unit');
            $(this).find('.modal-title').html('Add Unit');
            $(this).find('form').trigger('reset');
        }

        if ($(this).find('form').attr('id') == 'admin_add_movement') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'admin_edit_movement') {
            $(this).find('form').attr('id', 'admin_add_movement').attr('action', 'admin/asset/inventory/create-movement');
            $(this).find('.submit_button').attr('form', 'admin_add_movement');
            $(this).find('.modal-title').html('Add Movement');
            $(this).find('form').trigger('reset');
        }

        if (form.attr('id') == 'admin_createItem') {
            form.trigger('reset').parsley().reset();
            $('#itemCategory').combotree('clear');
            $('#itemSkuError').empty();
        } else if (form.attr('id') == 'admin_editItem') {
            form.attr({
                'id': 'admin_createItem',
                'action': 'admin/asset/inventory/create-item'
            });
            $(this).find('.submit_button').attr('form', 'admin_createItem');
            $(this).find('.modal-title').html('Manage Items');
            $('.img_preview').empty();
            $('#itemBrand').val(null).trigger('change');
            form.trigger('reset').parsley().reset();
            $('#itemCategory').combotree('clear');
            $('#itemSkuError').empty();
        }

        if ($(this).find('form').attr('id') == 'addCategoryForm') {
            $(this).find('form').trigger('reset');
        }
        else if ($(this).find('form').attr('id') == 'editCategoryForm') {
            $(this).find('form').attr('id', 'addCategoryForm').attr('action', 'admin/asset/create-category');
            $(this).find('.submit_button').attr('form', 'addCategoryForm');
            $(this).find('form').trigger('reset');

            html = `<div class="card" id="dattribute-row${dattribute_row}"><div class="card-body cardSection">`;
            html += `<div class="row assignee_based_on__main"><div class="col-md-6 mb-3 form-group"><div><h5 class="font-size-14 mb-2">Assignee Based On</h5>`;

            html += `<div class="form-check mb-1"><input class="form-check-input user__involved" onchange="user__involved(this)" type="radio" name="tvpActivity[${dattribute_row}][activity_assignee_type]" id="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}1" value="1"><label class="form-check-label user__involved" for="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}1">Users Involved</label></div>`;

            html += `<div class="form-check"><input class="form-check-input user__role" onchange="user__role(this)" type="radio" name="tvpActivity[${dattribute_row}][activity_assignee_type]" id="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}2" value="2"><label class="form-check-label user__role" for="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}2"> User Role</label></div></div></div>`;

            html += `<div class="col-md-6 mb-3 form-group user_role__hide"><label class="control-label" for="address_id" style="width:100%">User Type</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_user_type]"> <option value="0">Select</option><option value="1">Created To</option><option value="2">Alloted To</option><option value="3">Category Head</option></select></div></div>`;

            html += `<div class="row assignee_based_on__main">`;

            html += `<div class="row involved__hide"><div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee_role" style="width:100%">Assignee Role</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_assignee_role]" onchange="getAssignee(this)"><option value="0">Select an Option</option>${roles.map((role_value) => `<option value="${role_value.id}">${role_value.name}</option>`).join('')}</select></div>`;

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee" style="width:100%">Assignee</label><select class="form-control select2 assigneeOption" name="tvpActivity[${dattribute_row}][activity_assignee]"><option value="0">Select an Option</option></select></div></div>`;

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_type_id" style="width:100%">Activity Type</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_type_id]"><option value="0">Select an Option</option><option value="1">Created To</option>
            <option value="2">Alloted To</option>
            <option value="3">Category Head</option></select></div>`;

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_occurs" style="width:100%">Occurs</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_occurs]"> <option value="0">Select an Option</option>
            <option value="1">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Mothly</option>
            <option value="4">Yearly</option>
            <option value="5">One Time</option>
            <option value="6">Custom</option></select></div>`;

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_start_after" style="width:100%">Start Schedule After (Days)</label><p style="font-size:13px;">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p><input id="instruction" name="tvpActivity[${dattribute_row}][activity_start_after]" type="number" class="form-control" /></div>`;

            html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_reminder" style="width:100%">Activity Reminders</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_reminder]"> <option value="0">Select an Option</option><option value="1">Same day</option><option value="2">1 day before</option><option value="3">2 day before</option><option value="4">3 day before</option><option value="5">4 day before</option><option value="6">5 day before</option></select></div>';

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_schedule" style="width:100%">Schedule Based On</label><p style="font-size:13px;">Select the date which should be used as the start date of the schedule</p><select class="form-control select2" name="tvpActivity['${dattribute_row}][activity_schedule]"><option value="0">Select an Option</option></select></div>`;

            html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_custom_days" style="width:100%">Custom Days</label><p style="font-size:13px;">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p><input id="instruction" name="tvpActivity[${dattribute_row}][activity_custom_days]" type="number" class="form-control" /></div></div>`;

            html += `<div class="row"><div class="col-md-12 text-end"><hr><button class="btn btn-outline-info btn-custom-light" onclick="adddAttribute(event);"><i class="fas fa-plus"></i></button><button class="btn btn-outline-danger btn-custom-light" onclick="remove_dattribute(${dattribute_row})"><i class="mdi mdi-close-thick"></i></button></div></div>`;
            html += `</div></div>`;

            $('#detail .detail__inner').html(html);
            dattribute_row++;
            $('.select2').select2();
        }
    });

    // App Setting View Model Event

    $('.admin_view_condition').on('click', function (e) {
        e.preventDefault();
        $('.condition_view_name').html($(this).attr('condition_name'));
        $('.condition_view_ar_name').html($(this).attr('condition_ar_name'));
        $('#conditionViewModal').modal('show');
    });

    $('.admin_view_brand').on('click', function (e) {
        $('.brand_view_name').html($(this).attr('brand_name'));
        $('.brand_view_ar_name').html($(this).attr('brand_ar_name'));
        $('.brand_view_category').html($(this).attr('brand_category_name'));
        $('.brand_view_created_by').html($(this).attr('brand_created_by'));
        $('.brand_view_created_at').html($(this).attr('brand_created_at'));
        $('#brandViewModal').modal('show');
    });

    $('.admin_view_model').on('click', function (e) {
        $('.model_view_name').html($(this).attr('model_name'));
        $('.model_view_ar_name').html($(this).attr('model_ar_name'));
        $('.model_view_brand').html($(this).attr('model_brand_name'));
        $('#modelViewModal').modal('show');
    })

    // Inventory Setting View Modal
    $('.admin_view_unit').on('click', function (e) {
        $('.unit_view_name').html($(this).attr('unit_name'));
        $('.unit_view_ar_name').html($(this).attr('unit_ar_name'));
        $('.unit_view_description').html($(this).attr('unit_description'));
        $('.unit_view_created_at').html($(this).attr('unit_created_at'))
        $('#unitViewModal').modal('show');
    })

    $('.admin_view_movement').on('click', function (e) {
        var movement_type = $(this).attr('movement_type');
        var type = movement_type == '1' ? 'Add' : (movement_type == '2' ? 'Move' : (movement_type == '3' ? 'Draw' : ''));
        $('.movement_view_name').html($(this).attr('movement_name'));
        $('.movement_view_ar_name').html($(this).attr('movement_ar_name'));
        $('.movement_view_type').html(type);
        $('.movement_view_created_at').html($(this).attr('movement_created_at'));
        $('#movementViewModal').modal('show');
    })

});


//======== Category Edit Start
function admin_edit_category(input) {
    $('#categoryModal').find('form').attr('id', 'editCategoryForm').attr('action', 'admin/asset/edit-category');
    $('#categoryModal').find('.submit_button').attr('form', 'editCategoryForm');
    $.ajax({
        type: "get",
        url: "admin/get-single-category",
        data: { category_id: $(input).attr('category_id') },
        dataType: "json",
        success: function (response) {
            if (response.status == true) {
                $('.category_id').val(response.category.categoryId);
                $('#parentCategoryId').combotree('setValue', response.category.parentCategoryId == '0' ? '' : response.category.parentCategoryId);
                $('#categoryName').val(response.category.categoryName);
                $('#categoryArabicName').val(response.category.categoryArabicName);
                $('#categoryCode').val(response.category.categoryCode);
                $('#transferDuration').val(response.category.transferDuration);
                $('#transferDurationType').select2('val', response.category.transferDurationType);
                $('#actualCost').val(response.category.actualCost);
                $('#isCasCade').prop('checked', response.category.isCasCade == '1' ? true : false);
                $('#allowAutoExtend').prop('checked', response.category.allowAutoExtend == '1' ? true : false);
                $('#billingCost').val(response.category.billingCost);
                $('#endOfLife').val(response.category.endOfLife);
                $('#endOfLifeType').select2('val', response.category.endOfLifeType);
                $('#depreciation').val(response.category.depreciation);
                $("#scrapValue").val(response.category.scrapValue);
                $('#scrapValueType').select2('val', response.category.scrapValueType);
                $('#depreciationTaxPct').val(response.category.depreciationTaxPct);
                //  Category Activity 
                var activity = response.category.activities;
                if (activity.length > 0) {
                    $('#detail .detail__inner').empty();
                    $.each(activity, function (index, value) {
                        html = `<div class="card" id="dattribute-row${dattribute_row}"><div class="card-body cardSection">`;
                        html += `<div class="row assignee_based_on__main"><div class="col-md-6 mb-3 form-group"><div><h5 class="font-size-14 mb-2">Assignee Based On</h5>`;

                        html += `<div class="form-check mb-1"><input class="form-check-input user__involved" onchange="user__involved(this)" type="radio" name="tvpActivity[${dattribute_row}][activity_assignee_type]" id="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}1" value="1" ${value.activity_assignee_type == '1' ? 'checked' : ''}><label class="form-check-label user__involved" for="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}1">Users Involved</label></div>`;

                        html += `<div class="form-check"><input class="form-check-input user__role" onchange="user__role(this)" type="radio" name="tvpActivity[${dattribute_row}][activity_assignee_type]" id="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}2" value="2" ${value.activity_assignee_type == '2' ? 'checked' : ''}><label class="form-check-label user__role" for="tvpActivity[${dattribute_row}][activity_assignee_type]${dattribute_row}2"> User Role</label></div></div></div>`;

                        html += `<div class="col-md-6 mb-3 form-group user_role__hide"><label class="control-label" for="address_id" style="width:100%">User Type</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_user_type]"> <option value="0">Select</option><option value="1" ${value.activity_user_type == '1' ? 'selected' : ''}>Created To</option><option value="2">Alloted To</option><option value="3">Category Head</option></select></div></div>`;

                        html += `<div class="row assignee_based_on__main">`;

                        html += `<div class="row involved__hide"><div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee_role" style="width:100%">Assignee Role</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_assignee_role]" onchange="getAssignee(this)"><option value="0">Select an Option</option>${roles.map((role_value) => `<option value="${role_value.id}" ${role_value.id == value.activity_assignee_role ? 'selected' : ''}>${role_value.name}</option>`).join('')}</select></div>`;

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_assignee" style="width:100%">Assignee</label><select class="form-control select2 assigneeOption" name="tvpActivity[${dattribute_row}][activity_assignee]"><option value="0">Select an Option</option><option value="${value.employee_id}" selected>${value.employee_name}</option></select></div></div>`;

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_type_id" style="width:100%">Activity Type</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_type_id]"><option value="0">Select an Option</option><option value="1" ${value.activity_user_type == '1' ? 'selected' : ''}>Created To</option>
                    <option value="2" ${value.activity_user_type == '2' ? 'selected' : ''}>Alloted To</option>
                    <option value="3" ${value.activity_user_type == '3' ? 'selected' : ''}>Category Head</option></select></div>`;

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_occurs" style="width:100%">Occurs</label><select class="form-control select2" name="tvpActivity[${dattribute_row}][activity_occurs]"> <option value="0">Select an Option</option>
                    <option value="1" ${value.activity_occurs == '1' ? 'selected' : ''}>Daily</option>
                    <option value="2" ${value.activity_occurs == '2' ? 'selected' : ''}>Weekly</option>
                    <option value="3" ${value.activity_occurs == '3' ? 'selected' : ''}>Mothly</option>
                    <option value="4" ${value.activity_occurs == '4' ? 'selected' : ''}>Yearly</option>
                    <option value="5" ${value.activity_occurs == '5' ? 'selected' : ''}>One Time</option>
                    <option value="6" ${value.activity_occurs == '6' ? 'selected' : ''}>Custom</option></select></div>`;

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_start_after" style="width:100%">Start Schedule After (Days)</label><p style="font-size:13px;">The first activity will be created on these many days after the date in "Schedule based on". Leave blank or 0 to create the first activity on the same date</p><input id="instruction" name="tvpActivity[${dattribute_row}][activity_start_after]" type="number" class="form-control" value="${value.activity_start_after}" /></div>`;

                        html += ' <div class="col-md-6 mb-3"><label class="control-label" for="activity_reminder" style="width:100%">Activity Reminders</label><select class="form-control select2" name="tvpActivity[' + dattribute_row + '][activity_reminder]"> <option value="0">Select an Option</option><option value="1">Same day</option><option value="2">1 day before</option><option value="3">2 day before</option><option value="4">3 day before</option><option value="5">4 day before</option><option value="6">5 day before</option></select></div>';

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_schedule" style="width:100%">Schedule Based On</label><p style="font-size:13px;">Select the date which should be used as the start date of the schedule</p><select class="form-control select2" name="tvpActivity['${dattribute_row}][activity_schedule]"><option value="0">Select an Option</option></select></div>`;

                        html += `<div class="col-md-6 mb-3"><label class="control-label" for="activity_custom_days" style="width:100%">Custom Days</label><p style="font-size:13px;">Enter the number of days when the schedule should recur. For ex, 15 for fortnightly, 60 for bi-monthly, 180 for half yearly</p><input id="instruction" name="tvpActivity[${dattribute_row}][activity_custom_days]" type="number" class="form-control" /></div></div>`;

                        html += `<div class="row"><div class="col-md-12 text-end"><hr><button class="btn btn-outline-info btn-custom-light" onclick="adddAttribute(event);"><i class="fas fa-plus"></i></button><button class="btn btn-outline-danger btn-custom-light" onclick="remove_dattribute(${dattribute_row})"><i class="mdi mdi-close-thick"></i></button></div></div>`;
                        html += `</div></div>`;

                        $('#detail .detail__inner').append(html);
                        dattribute_row++;
                    });
                }
                $('.select2').select2();

                $('#defaultVendor').select2('val', value.defaultVendor);
                $('#autoassigns').prop('checked', value.autoAssign == '1' ? true : false);
            }
        }
    });
    $('#categoryModal').modal('show');

};

// Category Edit Model End

// ===Category View Modal Start
function admin_view_category(input) {
    $('.category_view_path').html($(input).attr('category_path'));

    $.ajax({
        type: "get",
        url: "admin/get-single-category",
        data: { category_id: $(input).attr('category_id') },
        dataType: "json",
        success: function (response) {
            if (response.status == true) {
                $('.category_view_name').html(response.category.categoryName);
                $('.category_view_ar_name').html(response.category.categoryArabicName);
                $('.category_view_code').html(response.category.categoryCode);
                $('.view_default_transfer').html(response.category.transferDuration + '-' + (response.category.transferDurationType == '1' ? 'Day(s)' : (response.category.transferDurationType == '2' ? 'Month(s)' : (response.category.transferDurationType == '3' ? 'Year(s)' : ''))));
                $('.view_actual_cost').html(response.category.actualCost);
                $('.view_cascade').html(response.category.isCasCade == '1' ? 'Yes' : 'No');
                $('.view_auto_extend').html(response.category.allowAutoExtend == '1' ? 'Yes' : 'No');
                $('.view_billing_cost').html(response.category.billingCost);
                $('.view_end_of_life').html(response.category.endOfLife + '-' + (response.category.endOfLifeType == '1' ? 'Day(s)' : (response.category.endOfLifeType == '2' ? 'Month(s)' : (response.category.endOfLifeType == '3' ? 'Year(s)' : ''))));
                $('.view_depreciation').html(response.category.depreciation);
                $('.view_scrap_val').html(response.category.scrapValue + '-' + (response.category.scrapValueType == '1' ? 'Percentage(%)' : (response.category.scrapValueType == '2' ? 'Amount' : '')));
                $('.view_tax_depreciation').html(response.category.depreciationTaxPct);
                $('.view_created_by').html(response.category.categoryCreatedBy);
                var dateObject = new Date(response.category.categoryCreatedAt);
                var formattedDate = dateObject.getDate() + '/' + (dateObject.getMonth() + 1) + '/' + dateObject.getFullYear();
                $('.view_created_at').html(formattedDate);
                var activity = JSON.parse(response.category.tvpActivity);
                $.each(response.category.activities, function (index, value) {
                    $('#defaultActivity').append(`
                     <tr>
                     <td></td>
                     <td>${index + 1}</td>
                     <td>${value.activity_assignee_type == '1' ? 'Users Involved' : (value.activity_assignee_type == '2' ? 'User Role' : '')}</td>
                     <td>${value.activity_user_type == '1' ? 'Created_by' : (value.activity_user_type == '2' ? 'Alloted To' : (value.activity_user_type == '3' ? 'Category Head' : ''))}</td>
                     <td>${value.role_name}</td>
                     <td>${value.employee_name}</td>
                     <td>${value.activity_type_id == '1' ? 'Callibration' : (value.activity_type_id == '2' ? 'Inspection' : (value.activity_type_id == '3' ? 'Warrenty Expiry' : ''))}</td>
                     <td>${value.activity_occurs == '1' ? 'Daily' : (value.activity_occurs == '2' ? 'Weekly' : (value.activity_occurs == '3' ? 'Monthly' : (value.activity_occurs == '4' ? 'Yearly' : (value.activity_occurs == '5' ? 'One Time' : (value.activity_occurs == '6' ? 'Custom' : '')))))}</td>
                     <td>${value.activity_start_after}</td>
                     <td>${value.activity_reminder} day before</td>
                     <td>${value.activity_schedule}</td>
                     <td>${value.activity_custom_days}</td>
                 </tr>
                     `);
                });
                $('.view_default_vendor_name').html(response.category.defaultVendor == '1' ? 'AMC Vendor' : (response.category.defaultVendor == '2' ? 'Asset Vendor' : (response.category.defaultVendor == '3' ? 'Warranty Vendor' : '')));
                $('.view_auto_assign').html(response.category.autoAssign == '1' ? 'Yes' : 'No');
            }
        }
    });
    $('#categoryViewModal').modal('show');
}

//  Inventory item View Start

function admin_editCopy_inventroyItem(input) {
    var data = getAttributes($(input), ['title', 'item_id', 'category', 'name', 'ar_name', 'sku', 'brand', 'unit', 'image', 'code', 'description', 'old_image']);
    var $itemModal = $('#itemModal');
    var $form = $itemModal.find('form');

    if (data.title == 'Edit') {
        $form.attr({
            'id': 'admin_editItem',
            'action': 'admin/asset/inventory/edit-item'
        });
        $itemModal.find('.modal-title').html('Edit Item');
        $itemModal.find('.submit_button').attr('form', 'admin_editItem');
        $('.item_code').val(data.code);
    }

    $('.itemId').val(data.item_id);
    $('#itemCategory').combotree('setValue', data.category == '0' ? '' : data.category);
    $('.item_sku').val(data.sku);
    $('.item_name').val(data.name);
    $('.item_ar_name').val(data.ar_name);
    $('.item_unit').select2('val', data.unit);
    $('.item_descriptionView').val(data.description);
    $('.img_preview').html(`<img src="${data.image != '' ? data.image : $('.baseUrl').val() + 'images/notfound.jpg'}" alt="" width="120px" height="75px"><input type="hidden" name="old_image" value="${data.old_image}">`);

    $itemModal.modal('show');

    setTimeout(function () {
        $('#itemBrand').val(JSON.parse(data.brand)).trigger('change');
    }, 200);
};



function admin_view_inventroyItem(input) {
    var data = getAttributes($(input), ['category', 'name', 'ar_name', 'sku', 'brand', 'unit', 'image', 'code', 'description']);
    $('.item_codeView').html(data['code']);
    $('.item_skuView').html(data['sku']);
    $('.item_nameView').html(data['name']);
    $('.item_ar_nameView').html(data['ar_name']);
    $('.item_categoryView').html(data['category']);
    $('.item_unitView').html(data['unit']);
    $('.item_descriptionView').html(data['description']);
    if (data['image'] != '') {
        $('.item_imagePreview').html(`<img src="${data['image'] != '' ? data['image'] : $('.baseUrl').val() + 'images/notfound.jpg'}" width="120px" height="80px">`);
    }
    else {
        $('.item_imagePreview').empty();
    }
    $('#itemViewModal').modal('show');
}



//---- Initializing combo Tree for all Fields
$(document).ready(function () {

    initializeComboTree();
    setTimeout(function () {
        $('#filterCategory').combotree('setValue', getUrlParameter('filterCategory'));
    }, 500);

});

function initializeComboTree() {
    $.ajax({
        url: 'admin/asset/get-category',
        method: 'get',
        dataType: 'json',
        success: function (data) {
            initializeComboboxes(data);
        },
        error: function (xhr, status, error) {
            console.error('Failed to fetch category data:', error);
        }
    });
}

function initializeComboboxes(data) {
    $('.easyui-combotree').each(function () {
        var input = $(this);
        var id = input.attr('id');
        var options = {
            data: data,
            labelPosition: 'top',
            collapsible: true,
            panelHeight: 'auto',
            onChange: function (newValue, oldValue) {
                var t = input.combotree('tree'); // Get the tree object
                var n = t.tree('getSelected'); // Get the selected node
                if (n) {
                    if (id !== 'brandCategory') {
                        var path = getPath(t, n); // Get the path of the selected node
                        input.combotree('setText', path); // Set the text of the combotree to the full path
                    }
                    if (id === 'itemCategory') {
                        getBrands(newValue, oldValue); // Example function call
                    }
                }
            }
        };

        if (id === 'brandCategory') {
            options.multiple = true;
        }

        if ($.isFunction(input.combotree)) {
            input.combotree(options);
        } else {
            console.error('combotree function is not available for', input);
        }
    });
}


// Inventory Items js
function itemSkuCheck(input) {
    var sku = $(input).val();
    $.getJSON("admin/asset/inventory/check-sku", { sku: sku }, function (response) {
        var $itemSkuError = $('#itemSkuError');
        $itemSkuError
            .html(response.message)
            .toggleClass('text-success', response.status)
            .toggleClass('text-danger', !response.status);
    });
}

// $(function () {
//     $('#itemCategory').combotree({
//         onChange: function (newValue, oldValue) {
//             var t = $(this).combotree('tree'); // Get the tree object
//             var n = t.tree('getSelected'); // Get the selected node
//             if (n) {
//                 var path = getPath(t, n); // Get the path of the selected node
//                 $('#itemCategory').combotree('setText', path); // Set the text of the combotree to the full path
//             }
//             getBrands(newValue, oldValue);
//         }
//     });
// });

function getBrands(values, oldValues) {
    $.ajax({
        type: "get",
        url: "admin/asset/inventory/get-brands",
        data: { categories: values },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('#itemBrand').html(`<option value="">Select an Brand</option>${response.data.map(value => `<option value="${value.brand_id}">${value.brand_name}</option>`).join('')}`);
            }
        }
    });
}

$('#stockTypeChange').on('change', function () {
    var type = $(this).val();
    $.ajax({
        type: "get",
        url: "url",
        data: { 'type': type },
        dataType: "json",
        success: function (response) {

        }
    });
});



//-----Other Hepler Functions
function getPath(tree, node) {
    var path = [];
    while (node) {
        path.unshift(node.text); // Add node text to the beginning of the path array
        node = tree.tree('getParent', node.target); // Get parent node
    }
    return path.join(' > '); // Join path array with a separator
}


function getUrlParameter(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

// Get Attibutes
function getAttributes(element, attributes) {
    var result = {};
    var elem = $(element)[0];
    attributes.forEach(function (attribute) {
        result[attribute] = elem.getAttribute(attribute);
    });
    return result;
}