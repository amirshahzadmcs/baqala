function initializeDataTable() {
    const tableSelector = '#hunderTeamTable';

    // Destroy the existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable(tableSelector)) {
        $(tableSelector).DataTable().destroy();
    }

    // Initialize the DataTable
    $(tableSelector).DataTable({
        lengthMenu: [
            [25, 50, 100, 500],
            [25, 50, 100, 500]
        ],
        dom: 'Blfrtip',
        buttons: [
            { extend: "csv", className: "btn-md" },
            { extend: "excel", className: "btn-md" },
            { extend: "pdfHtml5", className: "btn-md" },
            { extend: "print", className: "btn-md" }
        ],
        responsive: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        searching: false,
        ajax: {
            url: `admin/logistic-management/hunger/team-list?name=${getUrlParameter('name') ?? ''}&team_leader=${getUrlParameter('team_leader') ?? ''}`,
            type: "POST"
        },
        columnDefs: [
            { targets: [0, 1, 2, 3, 4, 5], orderable: false }
        ]
    });
}

$(document).ready(function () {
    initializeDataTable();
});



function changeActionAndSubmit(action) {
    document.getElementById('myform').action = action;
    document.getElementById('myform').submit();
}

$('#createTeamForm').parsley().on('form:submit', function () {
    // Prevent the default form submission
    const form = $(this.$element);
    const submitBtn = $("#submitBtn");

    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "json",
        beforeSend: () => {
            submitBtn.prop('disabled', true)
                .html('<i class="fa fa-spinner fa-spin"></i> <small>Please wait ...</small>');
        },
        success: (response) => {
            if (response.status) {
                form.trigger('reset');
                $('.select2').val(null).trigger('change');
                form.closest('.modal').modal('hide');
                initializeDataTable();
                alertSuccess(response.message);
            }
            else {
                alertError(response.message);
            }
        },
        complete: () => {
            submitBtn.prop('disabled', false)
                .html('Submit');
        }
    });

    return false;
});


function deleteAlert(id, path) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#1cbb8c",
        cancelButtonColor: "#f14e4e",
        confirmButtonText: "Yes, delete it!"
    }).then(function (t) {
        if (t.value) {
            window.location.href = location.href = path + "?id=" + id + "&team_id=" + getUrlParameter('team_id');
        }
    })
}

$(document).on('hidden.bs.modal', '.modal', function () {
    $(this).find('form').trigger('reset');
    $('.select2').val(null).trigger('change');
});

// Team View Js
function teamData(team_id) {
    $.ajax({
        type: "get",
        url: "admin/logistic-management/hunger/get_team_member",
        data: {
            team_id: team_id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.status) {
                $('#teamName').html(response.team.name);
                $('#teamLeader').html(`<span>${response.team.full_name}</span><li class="fa fa-user-alt ms-3 icon-with-shadow" onclick="getTeamLeader(this)" leader_id="${response.team.emp_id}"></li>`);
                $('#teamData').html(response.team_data.map((data, index) => `<tr>
                                        <td>${index + 1}</td>
                                        <td>${data.emp_no}</td>
                                        <td>${data.full_name}</td>
                                        <td>${data.sim_mobile}</td>
										<td>${data.aggregator_id ?? '-'}</td>
										<td>${data.company_name ?? '-'}</td>
                                        <td>${formatDate(data.work_joining_date)}</td>
                                        <td>
                                            <span class="badge badge-pill badge-soft-${data.rider_status === 'active' ? 'success' : data.rider_status === 'suspend' ? 'warning' : 'danger'} font-size-13">
                                                ${data.rider_status.charAt(0).toUpperCase() + data.rider_status.slice(1)}
                                            </span>
                                        </td>
                                        <td><button class="btn btn-warning btn-sm me-1" title="Move" onclick="moveTeamMember(${data.id})"><i class="fa fa-exchange-alt"></i></button><button class="btn btn-danger btn-sm" title="Remove" onclick="deleteAlert(${data.id},'admin/logistic-management/hunger/team_member_remove')"><i class="fa fa-trash-alt"></i></button></td>
                                        </tr>`).join(''));
            }
        }
    });
}

function editTeam() {
    var team_id = getUrlParameter('team_id');
    $.ajax({
        type: "get",
        url: "admin/logistic-management/hunger/team_edit",
        data: { team_id: team_id },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('#teamId').val(response.team.id);
                $('#team_name').val(response.team.name);
                $('#team_leader').html(response.team_leaders.map(value=>`<option value="${value.id}" ${value.id==response.team.leader_id ? 'selected' : ''}>${value.full_name}</option>`));
                $('#Team').html(`<option value="">Choose Team</option>` + response.teams.map(value => `<option value="${value.id}">${value.full_name} (${value.emp_no}) ${value.company_name ? '- ' + value.company_name : ''}</option>`).join(''));
                $('#editTeamModal').modal('show');
            }
        }
    });
}

function moveTeamMember(id) {
    var team_id = getUrlParameter('team_id');
    var member_id = id;
    $.ajax({
        type: "get",
        url: "admin/logistic-management/hunger/team_member_move",
        data: { team_id: team_id, member_id: member_id },
        dataType: "json",
        success: function (response) {
            if (response.status) {
                $('#teamMemberId').val(member_id);
                $('#fromTeamId').val(team_id);
                $('#move_to').html(`<option value="">Choose Team</option>` + response.teams.map(value => `<option value="${value.id}">${value.name}</option>`));
                $('#moveTeamModal').modal('show');
            }
        }
    });
}

function getTeamLeader(input) {
    var base_url = $('.baseUrl').val();
    var id = $(input).attr('leader_id');
    $.get("admin/logistic-management/hunger/get_team_leader", { id: id },
        function (response) {
            if (response.status) {
                var data = response.team_leader;
                $('#viewTeamLeaderInformation').html(`
                                <div class="size-inner-section px-1 py-1 mx-1">
    <div class="card-header">Team Leader Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="image">
				<img src="${data.employee_pic ? data.employee_picf : base_url + 'images/user-img.png'}" class="rounded" width="140">
        </div>
        <div class="p-3 w-100">
            <h5 class="mb-0 mt-0">${data.full_name} / ${data.employee_arabic_name}</h5>
            <span>${data.job_title} | ${data.department_name}</span>
            <hr class="my-1">
            <table>
                <tr>
                    <td>Emp No.</td>
                    <td> : </td>
                    <td>${data.emp_no}</td>
                </tr>
				<tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td>${data.nationality_name}</td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td>${data.mobile}</td>
                </tr>
				<tr>
                    <td>DL Number</td>
                    <td> : </td>
                    <td>${data.driving_license_number ?? ''}</td>
                </tr>
                <tr>
                    <td>Vehicle No</td>
                    <td> : </td>
                    <td>${data.vehicle_no ?? ''}/ ${data.vehicle_type ? data.vehicle_type + ' 🛵' : ''} </td>
                </tr>
				<tr>
                    <td>GPS Tracking</td>
                    <td> : </td>
                    <td>${data.gps_device_serial ? 'Yes' : ''}</td>
                </tr>
            </table>
        </div>
    </div>
</div>`);
            }
        },
        "Json"
    );
    $('#viewTeamLeaderModal').modal('show');
}

function alertSuccess(message) {
    $('.message_place').append(`<div class="alert alert-success alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>${message}</strong>
                        </div>`).children(':last').delay(3000).fadeOut(500, function () { $(this).remove(); });;
}
function alertError(message) {
    $('.message_place').append(`<div class="alert alert-danger alert-dismissible fade show" style="position:fixed;z-index:99;right:20px;width:50%;top:90px;" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong>${message}</strong>
                            </div>`).children(':last').delay(3000).fadeOut(500, function () { $(this).remove(); });;
}
function getUrlParameter(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name);
}

function formatDate(date) {
    const [year, month, day] = date.split('-');
    return `${day}-${month}-${year}`;
}