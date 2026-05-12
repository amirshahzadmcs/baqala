<style> 
.approver-item .select2-container{
	width: 100% !important;
    margin-right: 8px;
}
.select2-container--default .select2-selection--single .select2-selection__clear{
	font-size: 20px;
}
.select2-container .select2-selection--single .select2-selection__rendered{
	padding-right: 30px;
}
/* Styling for the custom footer */
.custom-footer {
	padding: 10px;
	text-align: center;
	cursor: pointer;
	background-color: #f1f1f1;
	border-top: 1px solid #ccc;
}
.custom-footer:hover {
	background-color: #e2e2e2;
}
/* Adds smooth transitions to list items */
#approverList .list-group-item.transition {
    transition: transform 0.2s ease-in-out;
}

/* Style the placeholder to be visible while sorting */
.sortable-placeholder {
    background-color: #f0f0f0;
    height: 65px;
    border: 2px dashed #ccc;
    visibility: visible !important;
}
</style>
<?php echo form_open("admin/hr-module/request/driving-licence/save", array("id" => "addDlForm", "enctype" => "multipart/form-data", "class" => "form-label-left", "data-parsley-validate" => "")); ?>
<div class="row tab-inner-section m-1 py-4">
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required />
    </div>
    
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <input class="form-check-input" type="checkbox" id="is_applicable_to_all" name="is_applicable_to_all">
        <label class="form-check-label" for="is_applicable_to_all">Do you want to apply this policy to all employees in company?</label>
    </div>
    <div class="col-md-12 col-sm-12 mb-3 form-group">
        <div id="addEmployeeContainer" style="display: block;">
            <p><small>Selected Employees</small></p>
            <span><i class="mdi mdi-account-multiple-outline font-size-20" style="vertical-align: middle;"></i> <span id="employeeCount" class="text-primary ms-2">0</span><span class="text-primary ms-2">Employees</span></span>
            <a type="button" id="employeeSelectionButton" class="text-primary ms-3"><i class="dripicons-plus font-size-20 text-primary" style="vertical-align: middle;"></i> Add Employees</a>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 mb-3 form-group">
		<div class="approver-section">
			<label>Approver</label>
			<ul id="approverList" class="list-group connectedSortable">
				<!-- Initial approver item -->
				<li class="list-group-item approver-item">
					<span class="badge bg-light me-2">1</span>
					<select class="form-select approver-select" name="approver[]">
						<option value="" disabled selected>Select Employee</option>
						<option value="Line Manager">Line Manager</option>
						<option value="Department Head">Department Head</option>
					</select>
					<input type="hidden" name="approver_list[]" value="" />
					<input type="hidden" name="approver_type[]" value="" />
					<input type="hidden" class="approver-index" name="approver_index[]" value="1" />
					<span class="btn btn-secondary grab-button"><i class="mdi mdi-dots-grid"></i></span>
				</li>
			</ul>
			<div class="text-center mt-2">
				<button type="button" id="addApprover" class="btn btn-outline-info">+ Add Approver</button>
			</div>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<script>
	function updateApproverIndexes() {
		$('#approverList .approver-item').each(function (index) {
			// Update the badge number and hidden index for each approver
			$(this).find('.badge').text(index + 1);
			$(this).find('.approver-index').val(index + 1);
		});
	}

	$(document).ready(function() {
		var selectedEmployees = [];
		
		// Add custom CSS rules with !important
		$('<style>')
        .prop('type', 'text/css')
        .html(`
            .show-important {
                display: flex !important;
            }
            .hide-important {
                display: none !important;
            }
        `)
        .appendTo('head');

		// Handle the checkbox change for employee selection
		$('input[name="is_applicable_to_all"]').on('change', function() {
			var isChecked = $(this).prop('checked');
			if (!isChecked) {  // if checkbox is unchecked
				$('#addEmployeeContainer').show();
			} else {  // if checkbox is checked
				$('#addEmployeeContainer').hide();
				$('#employeeCount').text(selectedEmployees.length);
			}
		});

		// Show modal and load employee list via AJAX
		$('#employeeSelectionButton').on('click', function() {
			$.ajax({
				url: '<?php echo base_url('admin/hr-module/request/driving-licence/get-employee-list'); ?>',
				method: 'GET',
				success: function(responseHtml) {
					//console.log(responseHtml);
					$('.employee-selection-body').html(responseHtml);
					$('.employeeSelectionModal').modal('show');
					initializeEmployeeList();
					var footerHtml = `<div class="row">
							<div class="col-md-12">
								<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-success btn-md">Save</button>
								<button type="button" data-bs-dismiss="modal" aria-label="Close" class="btn btn-outline-danger btn-md ms-2">Cancel </button>
							</div>
						</div>`;
					$('.employeeSelectionModal .modal-footer').html(footerHtml);
				},
				error: function(errorResponse) {
					//console.log(errorResponse);
					toastr.error('Error fetching updated data');
				}
			});
		});

		// Initialize the employee list and button states
		function initializeEmployeeList() {
			$('#employeeList').on('click', '.addEmployee', function() {
				var empId = $(this).data('emp-id').toString();
				var button = $(this);
				if (selectedEmployees.includes(empId)) {
					// Remove employee
					selectedEmployees = selectedEmployees.filter(id => id !== empId);
					button.text('+ Add').removeClass('btn-outline-danger').addClass('btn-outline-primary');
				} else {
					// Add employee
					selectedEmployees.push(empId);
					button.text('- Remove').removeClass('btn-outline-primary').addClass('btn-outline-danger');
				}
				updateEmployeeCount();
			});

			// Handle search functionality
			$('#searchEmployees').on('keyup', function() {
				var searchQuery = $(this).val().toLowerCase();
				//console.log('Search Query:', searchQuery); // Log search query
				$('#employeeList .list-group-item').each(function() {
					var employeeName = $(this).find('h6.mb-0').text().toLowerCase();
					var employeeID = $(this).find('small').text().toLowerCase();
					var isVisible = employeeName.includes(searchQuery) || employeeID.includes(searchQuery);
					
					if (isVisible) {
						$(this).addClass('show-important').removeClass('hide-important'); // Show item
					} else {
						$(this).addClass('hide-important').removeClass('show-important'); // Hide item
					}
				});
			});

			// Update employee count display
			function updateEmployeeCount() {
				$('#employeeCountInModal').text(selectedEmployees.length + ' Employees');
				$('#employeeCount').text(selectedEmployees.length);
			}

			// Update the employee list to reflect the selected employees
			$('#employeeList .list-group-item').each(function() {
				var empId = $(this).find('.addEmployee').data('emp-id').toString();
				var button = $(this).find('.addEmployee');
				if (selectedEmployees.includes(empId)) {
					button.text('- Remove').removeClass('btn-outline-primary').addClass('btn-outline-danger');
				} else {
					button.text('+ Add').removeClass('btn-outline-danger').addClass('btn-outline-primary');
				}
			});
			updateEmployeeCount(); // Initial count update
		}

		// Function to initialize Select2 with custom footer
		function initializeSelect2WithFooter($element) {
			$element.select2({
				placeholder: 'Select Employee',
				allowClear: true,
				dropdownParent: $('body') // Ensures the dropdown is correctly placed within body
			});

			// Add footer button when dropdown opens
			$element.on('select2:open', function () {
				if (!$('.custom-footer').length) {
					$('.select2-results').append('<div class="custom-footer">+ Approver Employee</div>');

					// Event listener for footer button
					$('.custom-footer').on('click', function () {
						$element.select2('close');
						var approverIndex = $element.closest('.approver-item').find('.approver-index').val();
						$('#currentApproverIndex').val(approverIndex);
						$('#approverModal').modal('show');
					});
				}
			});
		}

		// Initialize the first Select2 dropdown with footer
		initializeSelect2WithFooter($('.approver-select'));

		// Add new approver row
		$('#addApprover').on('click', function () {
			var approverCount = $('#approverList .approver-item').length + 1;
			var newApprover = `
				<li class="list-group-item approver-item">
					<span class="badge bg-light me-2">${approverCount}</span>
					<select class="form-select approver-select" name="approver[]">
						<option value="" disabled selected>Select Employee</option>
						<option value="Line Manager">Line Manager</option>
						<option value="Department Head">Department Head</option>
					</select>
					<input type="hidden" name="approver_list[]" value="" />
					<input type="hidden" name="approver_type[]" value="" />
					<input type="hidden" class="approver-index" name="approver_index[]" value="${approverCount}" />
					<span class="btn btn-secondary grab-button"><i class="mdi mdi-dots-grid"></i></span>
				</li>
			`;
			$('#approverList').append(newApprover);

			// Initialize the newly added Select2 dropdown
			initializeSelect2WithFooter($('#approverList .approver-item:last-child select'));
			updateApproverIndexes();
		});

		// Function to update approver numbers when new approver is added
		function updateApproverNumbers() {
			$('#approverList .approver-item').each(function (index, element) {
				$(element).find('.badge').text(index + 1);
			});
		}
		updateApproverIndexes();

		$(document).on('change', '.approver-select', function () {
			var selectedValue = $(this).val();
			var currentApproverItem = $(this).closest('.approver-item'); // Current approver row
			var isDuplicate = false;

			// Check if the selected value is already in other approver_list inputs
			$('#approverList .approver-item').each(function () {
				if ($(this).is(currentApproverItem)) {
					// Skip the current approver row
					return;
				}
				var approverValue = $(this).find('input[name="approver_list[]"]').val();
				if (approverValue === selectedValue) {
					isDuplicate = true;
					return false; // Exit the loop early
				}
			});

			if (isDuplicate) {
				toastr.error('This designation is already selected as an approver.');
				$(this).val(null).trigger('change'); // Clear the invalid selection
			} else {
				// Update the hidden inputs with the selected value
				currentApproverItem.find('input[name="approver_list[]"]').val(selectedValue);
				currentApproverItem.find('input[name="approver_type[]"]').val('designation');
			}
		});


		// Handle form submission
		$('#addDlForm').on('submit', function (e) {
			e.preventDefault();
			var formData = new FormData(this);
			var currentSelectedEmployees = [...selectedEmployees];
			formData.append('selectedEmployees', JSON.stringify(currentSelectedEmployees));

			// Send the AJAX request to save the form
			$.ajax({
				url: $(this).attr('action'),
				method: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function (response) {
					// Ensure the response is parsed as JSON
					var result;
					try {
						result = typeof response === 'object' ? response : JSON.parse(response);
					} catch (e) {
						console.error('Failed to parse response as JSON:', e);
						toastr.error('Invalid server response. Please try again.');
						return;
					}

					// Handle the success or error message
					if (result.status === 'success') {
						toastr.success(result.message);
						$('#addDlForm')[0].reset();
						$('#employeeCount').text(0);
						selectedEmployees = [];
						setTimeout(function() {
							location.reload();
						}, 1000);
					} else {
						toastr.error(result.message);
					}
				},
				error: function (error) {
					toastr.error('Failed to submit form. Please try again.');
					console.error(error);
				}
			});
		});

	});

	function initializeSortable() {
		$('#approverList').sortable({
			placeholder: 'sortable-placeholder',
			handle: '.grab-button',
			forcePlaceholderSize: true,
			tolerance: 'pointer',
			axis: 'y',
			start: function(event, ui) {
				// Add transition class to all other items on drag start
				$('#approverList .list-group-item').not(ui.item).addClass('transition');
			},
			stop: function(event, ui) {
				// Remove transition class when dragging stops
				$('#approverList .list-group-item').removeClass('transition');
			},
			update: function(event, ui) {
				updateApproverIndexes();
				console.log('List updated');
			}
		});
	}
	// Initialize sortable on page load
	initializeSortable();
</script>
