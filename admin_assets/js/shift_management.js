const searchRiderForm = $('#searchRiderForm').parsley();
const createShiftForm = $('#createShiftForm').parsley();
const shiftFooter = `<div class="modal-footer" id="searchModalFooter2">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetModalData()">Cancel</button>
    <button type="submit" form="assignShiftForm" class="btn btn-custom-success" id="submitBtn">Submit</button></div>`;
$(document).on('hidden.bs.modal', '.modal', function () {
    const modals = {
        'shiftModal': resetShiftModal,
        'areaModal': resetAreaModal,
        'assignShiftModal': resetShiftAssignModel,
        'changeShiftModal': resetChangeShiftModal
    };
    modals[this.id]?.();
});

$('.check_all_riders').change(function () {
    var parent = $(this).closest('.shift_report');
    if ($(this).is(':checked')) {
        parent.find('.team_leader_id').val(null).trigger('change').removeAttr('required');
        parent.find('.rider_id').empty().removeAttr('required');
    } else {
        parent.find('.team_leaderId').prop('disabled', false).attr('required', true);
    }
});

$('.team_leader_id').change(function () {
    var parent = $(this).closest('.shift_report');
    if ($(this).val()) {
        parent.find('.check_all_riders').prop('checked', false);
        parent.find('.team_leader_id').prop('disabled', false).attr('required', true);
        $.get('admin/logistic-management/hunger/search-team_leader', { team_leaderId: $(this).val() }, (response) => {
            if (response.status) {
                parent.find('.rider_id').html(`<option value="">All</option>${response.riders.map(rider => `<option value="${rider.id}">${rider.full_name} (${rider.emp_no})</option>`).join('')}`);
            }
        }, "json");
    }
});


$(document).on('show.bs.modal', '.modal', function () {
    $(this).find('.select2').select2({
        width: '100%'
    });
});



function initializeDataTable(selector, url, columns) {
    if ($.fn.DataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
    }

    $(selector).DataTable({
        lengthMenu: [[25, 50, 100, 500], [25, 50, 100, 500]],
        dom: 'Blfrtip',
        buttons: ["csv", "excel", "pdfHtml5", "print"].map(type => ({ extend: type, className: "btn-md" })),
        responsive: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        searching: false,
        ajax: { url, type: "POST" },
        columnDefs: columns.map(col => ({ targets: col, orderable: false })),
        rowCallback: function (row, data) {
            let updatedAt = data[11];
            if (updatedAt) {
                $(row).css({
                    "background-color": "#ffd7d7",
                    "color": "#999",
                    "cursor": "not-allowed"
                });
            }
        }

    });
}


function shiftEdit(input) {
    const data = getAttributes(input, ['shift_id', 'shift_name', 'shift_ar_name']);
    const modal = $('#shiftModal');
    modal.find('form').attr({ 'action': 'admin/logistic-management/hunger/edit-shift', 'id': 'editShiftForm' });
    modal.find('#shiftModalLabel').text('Edit Shift');
    modal.find('#submitBtn').attr('form', 'editShiftForm');
    $('#shiftId').val(data.shift_id);
    $('#shiftName').val(data.shift_name);
    $('#shiftArName').val(data.shift_ar_name);
    // Object.entries(data).forEach(([key, value]) => $(`#${key.charAt(0).toLowerCase() + key.slice(1)}`).val(value).trigger('chanage'));
    modal.modal('show');
}

function resetShiftModal() {
    const modal = $('#shiftModal');
    modal.find('form').attr({ 'action': 'admin/logistic-management/hunger/create-shift', 'id': 'createShiftForm' }).trigger('reset');
    modal.find('#shiftModalLabel').text('Create Shift');
    modal.find('#submitBtn').attr('data-form', 'createShiftForm');
}
function resetChangeShiftModal() {
    const modal = $('#changeShiftModal');
    modal.find('#changeShiftDeatil').empty();
}

function deleteAlert(id, path) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#1cbb8c",
        cancelButtonColor: "#f14e4e",
        confirmButtonText: "Yes, delete it!"
    }).then(result => result.value && (window.location.href = `${path}?id=${id}`));
}

function initializeAreaTable() {
    initializeDataTable('#masterAreaTable', `admin/logistic-management/hunger/get-area?name=${getUrlParameter('name') ?? ''}`, [0, 1, 2, 3, 4]);
}

function areaEdit(input) {
    const data = getAttributes(input, ['area_id', 'area_name', 'area_ar_name', 'area_status']);
    const modal = $('#areaModal');
    modal.find('form').attr({ 'action': 'admin/logistic-management/hunger/edit-area', 'id': 'editAreaForm' });
    modal.find('#areaModalLabel').text('Edit Area');
    modal.find('#submitBtn').attr('form', 'editAreaForm');
    Object.entries(data).forEach(([key, value]) => $(`#${key.charAt(0).toLowerCase() + key.slice(1)}`).val(value).trigger('change'));
    modal.modal('show');
}

function resetAreaModal() {
    const modal = $('#areaModal');
    modal.find('form').attr({ 'action': 'admin/logistic-management/hunger/create-area', 'id': 'createAreaForm' }).trigger('reset');
    modal.find('#areaModalLabel').text('Create Area');
    modal.find('#submitBtn').attr('form', 'createAreaForm');
}

function initializeShiftTable() {
    initializeDataTable('#scheduledShiftTable', `admin/logistic-management/hunger/get-riders-shift?name=${getUrlParameter('name') ?? ''}`, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
}


function shiftTypeChange(input) {
    $('#shiftDate').attr('type', input.value == 1 ? 'week' : 'date');
}

function changeShift(input) {
    const data = getAttributes(input, ['shift_id', 'rider_id', 'shift_date', 'start_time', 'end_time', 'area_id']);
    var modal = $('#changeShiftModal');
    var selector = $('#changeShiftDeatil');
    var footer = selector.closest('.modal').find('.footerArea');
    $.get('admin/logistic-management/hunger/rider-shift-change-get', { shiftId: data.shift_id }, (response) => {
        if (response.status) {
            modal.modal('show');
            selector.html(response.profile).show('slow');
            footer.html(shiftFooter).show('slow');
            footer.find('button').attr('form', selector.find('form').attr('id'));
            selector.find('form').parsley();
        }
        else {
            alertError(response.message);
        }
    }, 'json');
}

function resetShiftAssignModel() {
    var modal = $('#assignShiftModal');
    modal.find('#riderDeatil').empty().hide();
    modal.find('#footerArea').empty().hide();
    modal.find('form').find('.select2').val(null).trigger('change');
}


function admin_view_riderShift(input) {

    const data = getAttributes(input, ['shift_name', 'rider_name', 'shift_date', 'shift_time', 'shift_duration', 'area_name']);
    $('#riderView').html(data.rider_name);
    $('#shiftView').html(data.shift_name);
    $('#dateView').html(data.shift_date);
    $('#timeView').html(data.shift_time);
    $('#durationView').html(data.shift_duration);
    $('#areaView').html(data.area_name);
    $('#viewShiftModal').modal('show');

}

// Search Rider
searchRiderForm.on('form:submit', function () {
    var form = $(this.$element);
    var selector = $('#riderDeatil');
    var footer = selector.closest('.modal').find('.footerArea');
    var modalBody = selector.closest('.modal').find('.modal-body');
    var alertSelector = modalBody.find('.alert_box');
    $.get(form.attr('action'), form.serialize(), function (response) {
        if (response.status) {
            selector.html(response.profile).show('slow');
            footer.html(shiftFooter).show('slow');
            selector.find('form').parsley();
            $('#riderError').removeClass('text-danger').addClass('text-success').html(response.message).fadeOut(3000);
        } else {
            $('#riderError').removeClass('text-success').addClass('text-danger').html(response.message).show();
        }
    }, "json").fail(function () {
        alertErrorModal('Something Went Wrong', alertSelector);
    });
    return false;
});

function checkAvailability(input) {
    const $form = $('#assignShiftForm');
    const shiftRow = $('.shift_row').last();
    const modal = $form.closest('.modal');
    var modalBody = modal.find('.modal-body');
    var selector = modalBody.find('.alert_box');

    if ($form.parsley().isValid()) {
        const requestData = {
            rider_id: $('#riderId').val(),
            shift_id: shiftRow.find('.shiftId').val(),
            shift_date: shiftRow.find('.shiftDate').val(),
            start_time: shiftRow.find('.startTime').val(),
            end_time: shiftRow.find('.endTime').val(),
        };

        let dateConflict = false;
        $('.shift_row').not(shiftRow).each(function () {
            if ($(this).find('.shiftDate').val() === requestData.shift_date && $(this).find('.shiftId').val() == requestData.shift_id) {
                dateConflict = true;
            }
        });
        if (dateConflict) {
            modalScrollAnimation(modal, 'Top');
            alertErrorModal("This Date has Already been Selected.", selector);
            return;
        }

        $.post("admin/logistic-management/hunger/riders-check-availability", requestData, (response) => {
            if (response.status) {
                addShiftAttribute();
                modalScrollAnimation(modal, 'Down');
            } else {
                modalScrollAnimation(modal, 'Top');
                alertErrorModal(response.message, selector);
            }
        }, 'json').fail(() => alertErrorModal("An error occurred while checking availability. Please try again.", selector));
    } else {
        $form.parsley().validate();
    }
}


// Create Shiftsss
createShiftForm.on('form:submit', function () {
    const form = $(this.$element);
    $.post(form.attr('action'), form.serialize(), function (response) {
        form.closest('.modal').modal('hide');
        response.status ? alertSuccess(response.message) : alertError(response.message);
        if (response.status) resetShiftModal();
        initializeDataTable('#masterShiftTable', `admin/logistic-management/hunger/get-shift?name=${getUrlParameter('name') ?? ''}`, [0, 1, 2, 3, 4]);
    }, "json").fail(() => alertError('An error occurred while processing your request.'));
    return false;
});

function removeBlankShiftRows() {
    $('.shift_row').slice(1).each(function () {
        const isBlank = $(this).find('input, select').toArray().every(field => !$(field).val());
        if (isBlank) {
            $(this).remove();
        }
    });
}

function swapShift(id, path) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#1cbb8c",
        cancelButtonColor: "#f14e4e",
        confirmButtonText: "Yes, Swap It!"
    }).then(result => result.value && (window.location.href = `${path}?id=${id}`));
}

function modalScrollAnimation(input, type) {
    const modalBody = input.closest('.modal').find('.modal-body');
    const scrollValue = type === 'Top' ? 0 : modalBody.prop('scrollHeight');
    modalBody.animate({ scrollTop: scrollValue }, 'slow');
}

function alertSuccess(message) {
    createAlert('success', message);
}

function alertError(message) {
    createAlert('danger', message);
}

function createAlert(type, message) {
    $('.message_place').append(`<div class="alert alert-${type} alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong>${message}</strong>
    </div>`).children(':last').delay(3000).fadeOut(500, function () { $(this).remove(); });
}


function alertSuccessModal(message) {
    $('#alertBox').prepend(`
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>${message}</strong>
        </div>
    `).children(':first').delay(3000).fadeOut(500, function () { $(this).remove(); });
}

function alertErrorModal(message, selector) {
    selector.prepend(`
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>${message}</strong>
        </div>
    `).children(':first').delay(3000).fadeOut(500, function () { $(this).remove(); });
}




function getAttributes(element, attributes) {
    const result = {};
    attributes.forEach(attr => result[attr] = element.getAttribute(attr));
    return result;
}