var baseUrl = $('.baseUrl').val();
$(function () {
    $('#empCheck').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    if (response.message == 'Employee Detail Fetched') {
                        $('#empCheckMsg').html(`<span class="text-success">${response.message}</span>`);
                        // var address = JSON.parse(response.employee.saudi_address);
                        $('#empDetails').html(`<div class="main-body">
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <img src="${response.employee.employee_pic != "" ? response.employee.employee_pic : 'https://bootdey.com/img/Content/avatar/avatar7.png'}" alt="Admin" class="rounded-circle" width="150">
                                            <div class="mt-3">
                                                <h5>${response.employee.full_name}/${response.employee.employee_arabic_name}</h5>
                                                <p class="text-secondary mb-1">${response.employee.job_name}</p>
                                                <p class="text-muted font-size-sm">${response.employee.department_name}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card mb-3 bh-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Emloyee No</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                               ${response.employee.emp_no}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Iqama No</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                ${response.employee.iqama_no}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Mobile No</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                ${response.employee.mobile}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Gender</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                               ${response.employee.gender}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Address</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                               ${response.employee.bed_name && response.employee.room_name && response.employee.camp_name != null ? 'Bed: ' + response.employee.bed_name + ', ' + 'Room: ' + response.employee.room_name + ', ' + 'Camp: ' + response.employee.camp_name : ''}
                                               <br>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Vehicle No</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                               ${response.employee.vehicle_no == null ? '<span class="text-danger">Vehicle Not Alloted To This Employee</span>' : response.employee.vehicle_no + '/' + response.employee.vehicle_model + '/' + response.employee.vehicle_brand_name}
                                               <br>
                                            </div>
                                        </div>
                                        <hr>
                                        
                                        <div id="otpSection" class="row">
                                           <form id="otpSend" class="col-md-6" action="" method="post" onsubmit="sendOtp(event,this)" data-parsley-validate>
                                           <input type="hidden" name="emp_id" value="${response.employee.id}">
                                           <input type="hidden" name="email" value="${response.employee.email}">

                                                <div class="row">
                                                    ${response.employee.vehicle_no != null ? `<div class="col-sm-6">
                                                        <input class="form-control runningKm" name="km" placeholder="Enter Km" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-info">Send Otp</a>
                                                        </div>` : ''}
                                                </div> 
                                           </form>                                         
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>`).show('slow');
                        $('form').parsley();
                    }
                }
                else if (response.status == false) {
                    $('#empCheckMsg').html(`<span class="text-danger">${response.error}</span>`);
                    $('#empDetails').empty().css('display', 'none');
                }
            }
        });
    });
});

// Send Otp
function sendOtp(event, input) {
    event.preventDefault();
    var form = $(input);
    if (form.parsley().isValid()) {
        $.ajax({
            type: "get",
            url: "admin/vehicle/send-otp",
            data: $(input).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    $('#otpForm').remove();
                    var otpForm = $('#otpSend');
                    otpForm.find('*:not(input[type="hidden"], .row)').remove();
                    otpForm.find('.row').append(`                      
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-secondary disabled" id="resendOtpButton">Resend</button>
                        </div>
                        <div class="col-sm-6">
                            <p id="otpCountDown"></p>
                        </div>
                    `);
                    $('#otpSection').prepend(`
                <form id="otpForm" class="col-md-4 mb-2" onsubmit="otpSubmit(event,this)" action="admin/vehicle/submit-otp" method="post" data-parsley-validate>
                <input type="hidden" name="employee_id" value="${response.emp_id}">
                    <div class="row">
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="otp" placeholder="Enter OTP" required>
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </div>
                    </div>
                </form>
                `);
                    $('form').parsley();
                    var timeLeft = 30;
                    var $elem = $('#otpCountDown');
                    var timerId = setInterval(countdown, 1000);
                    function countdown() {
                        if (timeLeft == 0) {
                            clearInterval(timerId);
                            countdownEnd();
                        } else {
                            $elem.text('Resend Otp After ' + timeLeft + ' Seconds');
                            timeLeft--;
                        }
                    }
                }
            }
        });
    }
};

function otpSubmit(event, input) {
    event.preventDefault();
    var form = $(input);
    if (form.parsley().isValid()) {
        $.ajax({
            type: "get",
            url: "admin/vehicle/submit-otp",
            data: form.serialize(),
            dataType: "json",
            success: function (response) {
                if (response.status == true) {
                    if (response.form == 'Check Out') {
                        $('#otpSection').css('display', 'none');
                        $('#otpSection').html(`<form id="checkOutForm" action="${baseUrl + 'admin/vehicle/check_out'}" method="post" data-parsley-validate>
                        <div class="openForm p-2">
                        <input class="form-control" type="hidden" name="driver_id" value="${response.employee.id}" required>
                        <input class="form-control" type="hidden" name="vehicle_id" value="${response.employee.vehicle_id}" required>
                            <div class="row">
                                <div class="col-md-3 mb-3 form-group">
                                    <label class="form-label">Km</label>
                                    <input class="form-control" type="text" name="km_driven" id="km_driven" value="${response.km}" readonly required>
                                </div>
                                <div class="col-md-3 mb-3 form-group">
                                    <label class="form-label">Battery</label>
                                    <input class="form-control" type="text" name="battery_status" id="battery_status" required>
                                </div>
                                <div class="col-md-3 mb-3 form-group">
                                    <label class="form-label">Delivery Platform</label>
                                    <select class="form-control select2" name="delivery_platform" required>
                                     <option value="">Choose and Option</option>
                                     <option value="Jahez">Jahez</option> 
                                     <option value="Hunger">Hunger</option>   
                                    </select>
                                </div>
                                <div class="col-md-3 align-content-end mb-3 form-group">
                                    <button type="submit" form="checkOutForm" class="btn btn-success submit_button">Check Out</button>
                                </div>
                            </div>
                        </div>
                    </form>`).show('slow');
                        $('form').parsley();
                    }
                    else if (response.form == 'Check In') {
                        $('#otpSection').css('display', 'none');
                        $('#otpSection').html(`<form id="checkInForm" action="${baseUrl + 'admin/vehicle/check_in'}" method="post" data-parsley-validate>
                        <div class="openForm p-2">
                        <input class="form-control" type="hidden" name="driver_id" value="${response.employee.id}" required>
                        <input class="form-control" type="hidden" name="vehicle_id" value="${response.employee.vehicle_id}" required>
                            <div class="row">
                                <div class="col-md-4 mb-3 form-group">
                                    <label class="form-label">Km</label>
                                    <input class="form-control" type="text" name="km_driven" id="km_driven" value="${response.km}" readonly required>
                                </div>
                                <div class="col-md-4 mb-3 form-group">
                                    <label class="form-label">Battery</label>
                                    <input class="form-control" type="text" name="battery_status" id="battery_status" required>
                                </div>
                                <div class="col-md-4 align-content-end mb-3 form-group">
                                    <button type="submit" form="checkInForm" class="btn btn-success submit_button">Check In</button>
                                </div>
                            </div>
                        </div>
                    </form>`).show('slow');
                        $('form').parsley();
                    }
                }
                else if (response.status == false) {
                    form.find('.row').append(`<span class="text-danger">${response.message}</span>`);
                }
            }
        });
    }
}

function countdownEnd() {
    $('#resendOtpButton').removeClass('disabled')
    $('#otpCountDown').remove();
}

function adminViewTimesheet(input) {
    $('.sheet_view_vehicle_no').html($(input).attr('vehicle_no'));
    $('.sheet_view_emp_no').html($(input).attr('emp_no'));
    $('.sheet_view_name').html($(input).attr('emp_name'));
    $('.sheet_view_checkOut_km').html($(input).attr('checkOut_km'));
    $('.sheet_view_checkIn_km').html($(input).attr('checkIn_km'));
    $('.sheet_view_checkOut_battery').html($(input).attr('checkOut_battery'));
    $('.sheet_view_checkIn_battery').html($(input).attr('checkIn_battery'));
    $('.sheet_view_checkOut_time').html($(input).attr('checkOut_time'));
    $('.sheet_view_checkIn_time').html($(input).attr('checkIn_time'));
    $('#timesheetViewModal').modal('show');
};