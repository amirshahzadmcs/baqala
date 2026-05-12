var baseUrl = $('.baseUrl').val();
document.addEventListener('DOMContentLoaded', function () {
	// ===== Helper Function =====
	function capitalize(str) {
		// Convert snake_case to PascalCase (FilterStatus)
		return str.split('_')
			.map(word => word.charAt(0).toUpperCase() + word.slice(1))
			.join('');
	}

	// ===== Update Query Parameter Utility =====
	function updateQueryParam(param, value) {
		const url = new URL(window.location.href);

		if (value) {
			url.searchParams.set(param, value);
		} else {
			url.searchParams.delete(param);
		}

		window.location.href = url.toString();
	}

	// ===== Search Input Live Handling =====
	const searchInput = document.getElementById('searchInput');
	const clearSearchBtn = document.getElementById('clearSearch');
	let searchTimeout;

	if (searchInput && clearSearchBtn) {
		function updateSearchClearBtn() {
			clearSearchBtn.style.display = searchInput.value ? 'block' : 'none';
		}

		// Initial state
		updateSearchClearBtn();

		searchInput.addEventListener('input', function () {
			updateSearchClearBtn();

			clearTimeout(searchTimeout);

			const query = this.value.trim();

			// Only fetch after 2 or more characters
			if (query.length >= 2) {
				searchTimeout = setTimeout(() => {
					updateQueryParam('keyword', query);
				}, 500); // 0.5s debounce
			} else if (query.length === 0) {
				updateQueryParam('keyword', null);
			}
		});

		clearSearchBtn.addEventListener('click', function () {
			searchInput.value = '';
			updateQueryParam('keyword', null);
		});
	}

	// ===== Reusable Dropdown Init Function =====
	function initFilterDropdown(config) {
		const {
			dropdownId,
			loaderId,
			selectId,
			endpoint,
			paramName,
			multiple
		} = config;
		let initialized = false;

		const dropdownEl = document.getElementById(dropdownId);
		if (!dropdownEl) return;

		// Prevent dropdown auto-close when clicking inside
		dropdownEl.addEventListener('hide.bs.dropdown', function (e) {
			if (!e.clickEvent || !this.contains(e.clickEvent.target)) return;
			e.preventDefault();
		});

		// Lazy load data on dropdown open
		dropdownEl.addEventListener('show.bs.dropdown', function () {
			if (!initialized) {
				const loader = document.getElementById(loaderId);
				loader.style.display = 'block';

				fetch(endpoint)
					.then(response => response.json())
					.then(data => {
						loader.style.display = 'none';

						// Initialize Virtual Select
						VirtualSelect.init({
							ele: '#' + selectId,
							options: data,
							multiple: multiple,
							showValueAsTags: true,
							keepAlwaysOpen: true,
							showSelectedOptionsFirst: true,
							additionalClasses: 'custom-wrapper',
							search: true,
							required: false,
							placeholder: 'Select ' + capitalize(paramName)
						});

						// Pre-select if already in URL params
						const urlParams = new URLSearchParams(window.location.search);
						const preSelected = urlParams.get(paramName);
						if (preSelected) {
							document.querySelector('#' + selectId).setValue(preSelected.split(','));
						}

						initialized = true;
					})
					.catch(() => {
						loader.innerHTML = `<span class="text-danger">Failed to load data</span>`;
					});
			}
		});

		// ===== Function to toggle active class on button =====
		function toggleButtonActive() {
			const urlParams = new URLSearchParams(window.location.search);
			const buttonEl = dropdownEl.querySelector('button');

			if (urlParams.has(paramName) && urlParams.get(paramName) !== '') {
				buttonEl.classList.add('active');
			} else {
				buttonEl.classList.remove('active');
			}
		}

		// Initially check when page loads
		toggleButtonActive();

		// Apply filter button
		document.querySelector('#apply' + capitalize(paramName)).addEventListener('click', function () {
			const selected = document.querySelector('#' + selectId).value;
			updateQueryParam(paramName, selected.length ? selected.join(',') : null);
			toggleButtonActive();
		});

		// Clear filter button
		document.querySelector('#clear' + capitalize(paramName)).addEventListener('click', function () {
			document.querySelector('#' + selectId).reset();
			updateQueryParam(paramName, null);
			toggleButtonActive();
		});
	}

	// ===== Reset Filters Button =====
	const resetFiltersBtn = document.getElementById('resetFilters');
	if (resetFiltersBtn) {
		if (window.location.search) {
			resetFiltersBtn.style.display = 'inline-block';
		}

		resetFiltersBtn.addEventListener('click', function () {
			window.location.href = window.location.pathname; // clear all filters
		});
	}

	// ===== Initialize All Filters =====
	initFilterDropdown({
		dropdownId: 'nationalityFilterDropdown',
		loaderId: 'loaderNationality',
		selectId: 'nationalityTypeSelect',
		endpoint: baseUrl + 'admin/hr-module/HrFilters/nationality_list',
		paramName: 'nationality',
		multiple: true
	});

	initFilterDropdown({
		dropdownId: 'designationFilterDropdown',
		loaderId: 'loaderDesignation',
		selectId: 'designationTypeSelect',
		endpoint: baseUrl + 'admin/hr-module/HrFilters/get_designations',
		paramName: 'designation',
		multiple: true
	});

	initFilterDropdown({
		dropdownId: 'departmentFilterDropdown',
		loaderId: 'loaderDepartment',
		selectId: 'departmentTypeSelect',
		endpoint: baseUrl + 'admin/hr-module/HrFilters/get_departments',
		paramName: 'department',
		multiple: true
	});

	initFilterDropdown({
		dropdownId: 'statusFilterDropdown',
		loaderId: 'loaderStatus',
		selectId: 'statusTypeSelect',
		endpoint: baseUrl + 'admin/hr-module/HrFilters/get_status',
		paramName: 'filter_status',
		multiple: true
	});
});

/*----- Additional FIlter -----*/
const filtersConfig = [
    {
        key: 'bed_name',
        label: 'Employee Bed',
        endpoint: 'HrFilters/get_beds'
    },
    {
        key: 'camp_name',
        label: 'Employee Camp',
        endpoint: 'HrFilters/get_camps'
    },
    {
        key: 'date_of_birth',
        label: 'Date of Birth',
        type: 'date_range'
    },
    {
        key: 'department_head',
        label: 'Department Head',
        endpoint: 'HrFilters/get_department_heads'
    },
    {
        key: 'employee_policy_no',
        label: 'Employee Policy No',
        type: 'text'
    },
    {
        key: 'employment_type',
        label: 'Employment Type',
        endpoint: 'HrFilters/get_employment_types'
    },
    {
        key: 'employer',
        label: 'Employer',
        endpoint: 'HrFilters/get_employers'
    },
    {
        key: 'gender',
        label: 'Gender',
        endpoint: 'HrFilters/get_genders'
    },
    {
        key: 'work_location',
        label: 'Work Location',
        endpoint: 'HrFilters/get_work_location'
    },
    {
        key: 'insurance_end_date',
        label: 'Insurance End Date',
        type: 'date_range'
    },
    {
        key: 'insurance_issue_date',
        label: 'Insurance Issue Date',
        type: 'date_range'
    },
    {
        key: 'iqama',
        label: 'Iqama No.',
        type: 'text'
    },
    {
        key: 'iqama_expiry',
        label: 'Iqama Expiry',
        type: 'date_range'
    },
    {
        key: 'iqama_issue_city',
        label: 'Iqama Issue City',
        endpoint: 'HrFilters/get_cities'
    },
    {
        key: 'iqama_issue_date',
        label: 'Iqama Issue Date',
        type: 'date_range'
    },
    {
        key: 'iqama_status',
        label: 'Iqama Status',
        endpoint: 'HrFilters/get_iqama_status'
    },
    {
        key: 'joining_date',
        label: 'Joining Date',
        type: 'date_range'
    },
    {
        key: 'last_working_date',
        label: 'Last Working Day',
        type: 'date_range'
    },
    {
        key: 'marital_status',
        label: 'Marital Status',
        endpoint: 'HrFilters/get_marital_status'
    },
    {
        key: 'passport_expiry_date',
        label: 'Passport Expiry Date',
        type: 'date_range'
    },
    {
        key: 'passport_issue_city',
        label: 'Passport Issue City',
        endpoint: 'HrFilters/get_cities'
    },
    {
        key: 'passport_issue_country',
        label: 'Passport Issue Country',
        endpoint: 'HrFilters/get_countries'
    },
    {
        key: 'passport_issue_date',
        label: 'Passport Issue Date',
        type: 'date_range'
    },
    {
        key: 'passport_no',
        label: 'Passport No',
        type: 'text'
    },
    {
        key: 'religion',
        label: 'Religion',
        endpoint: 'HrFilters/get_religions'
    },
    {
        key: 'room_name',
        label: 'Employee Room',
        endpoint: 'HrFilters/get_rooms'
    },
    {
        key: 'terminate_reason',
        label: 'Termination Reason',
        endpoint: 'HrFilters/get_terminate_reasons'
    },
    {
        key: 'work_line_manager',
        label: 'Work Line Manager',
        endpoint: 'HrFilters/get_line_managers'
    }
];

const filterContainer = document.getElementById('filterContainer');
const noFiltersMessage = document.getElementById('noFiltersMessage');
const filterButtons = document.getElementById('filterButtons');

// Toggle no filter message
function toggleNoFiltersMessage() {
	const hasFilters = filterContainer.querySelectorAll('.filter-item').length > 0;
	if (!hasFilters) {
		noFiltersMessage.style.display = 'block';
		filterButtons.classList.add('single-button');
	} else {
		noFiltersMessage.style.display = 'none';
		filterButtons.classList.remove('single-button');
	}
}

// Get available fields
function getAvailableFields() {
	const usedKeys = Array.from(filterContainer.querySelectorAll('.filter-item select')).map(sel => sel.value);
	return filtersConfig.filter(f => !usedKeys.includes(f.key));
}

// Add filter block
document.getElementById('addFilterBtn').addEventListener('click', () => addFilterBlock());

function addFilterBlock(preKey = null, preValues = [], preStart = '', preEnd = '') {
	const availableFields = getAvailableFields();

	// Allow preKey even if already used (for restoring)
	if (preKey && !availableFields.find(f => f.key === preKey)) {
		const found = filtersConfig.find(f => f.key === preKey);
		if (found) availableFields.push(found);
	}

	if (availableFields.length === 0) return;

	const div = document.createElement('div');
	div.classList.add('filter-item');

	const selectField = document.createElement('select');
	selectField.classList.add('form-select', 'filter-field');
	selectField.innerHTML = '<option value="">Select Field</option>';

	availableFields.forEach(f => {
		const opt = document.createElement('option');
		opt.value = f.key;
		opt.textContent = f.label;
		selectField.appendChild(opt);
	});

	const valueSelect = document.createElement('div');
	valueSelect.classList.add('value-select');

	const removeBtn = document.createElement('span');
	removeBtn.classList.add('remove-btn');
	removeBtn.innerHTML = '<i class="mdi mdi-close-circle font-size-24"></i>';
	removeBtn.onclick = () => {
		div.remove();
		toggleNoFiltersMessage();
	};

	div.appendChild(removeBtn);
	div.appendChild(selectField);
	div.appendChild(valueSelect);
	filterContainer.appendChild(div);

	$(selectField).select2({
		width: '100%',
		placeholder: 'Select Field',
	});

	if (preKey) {
		$(selectField).val(preKey).trigger('change');
		$(selectField).prop('disabled', true).trigger('change.select2');

		// Check if this is date_range
		const field = filtersConfig.find(f => f.key === preKey);
		if (field.type === 'date_range') {
			loadFilterOptions(preKey, valueSelect, [], preStart, preEnd);
		} else {
			loadFilterOptions(preKey, valueSelect, preValues);
		}
	}

	$(selectField).on('change', function () {
		const selectedKey = this.value;
		if (!selectedKey) return;
		loadFilterOptions(selectedKey, valueSelect);
		$(this).prop('disabled', true).trigger('change.select2');
	});

	toggleNoFiltersMessage();
}

// Load filter options (multi-select OR date range)
function loadFilterOptions(fieldKey, container, preValues = [], preStart = '', preEnd = '') {
    const field = filtersConfig.find(f => f.key === fieldKey);

    // --- DATE RANGE SUPPORT ---
    if (field.type === 'date_range') {
        container.innerHTML = `
            <div class="input-group mb-2">
                <input type="date" class="form-control start-date" placeholder="Start Date">
                <span class="input-group-text">to</span>
                <input type="date" class="form-control end-date" placeholder="End Date">
            </div>
        `;

        // Pre-fill values
        if (preStart) container.querySelector('.start-date').value = preStart;
        if (preEnd) container.querySelector('.end-date').value = preEnd;

        const startInput = container.querySelector('.start-date');
        const endInput = container.querySelector('.end-date');

        startInput.addEventListener('change', () => {
            if (startInput.value) {
                endInput.min = startInput.value;
                if (!endInput.value || endInput.value < startInput.value) {
                    endInput.value = startInput.value;
                }
            } else {
                endInput.value = '';
                endInput.min = '';
            }
        });

        endInput.addEventListener('change', () => {
            if (endInput.value && startInput.value && endInput.value < startInput.value) {
                alert('End Date cannot be earlier than Start Date');
                endInput.value = startInput.value;
            }
        });

        return;
    }

    // --- TEXT FIELD SUPPORT ---
    if (field.type === 'text') {
        container.innerHTML = `
            <input type="text" class="form-control text-input" placeholder="Enter ${field.label}">
        `;
        // Pre-fill if restoring
        if (preValues.length > 0) {
            container.querySelector('.text-input').value = preValues[0];
        }
        return;
    }

    // --- DEFAULT MULTISELECT SUPPORT ---
    container.innerHTML = `<div class="text-center py-2"><div class="spinner-border text-success" style="width:1.2rem;height:1.2rem"></div></div>`;

    fetch(baseUrl + 'admin/hr-module/' + field.endpoint)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';
            const vsId = 'vs_' + fieldKey + '_' + Date.now();
            container.innerHTML = `<div id="${vsId}"></div>`;

            VirtualSelect.init({
                ele: `#${vsId}`,
                options: data,
                multiple: true,
                search: true,
                showValueAsTags: true,
                placeholder: 'Select ' + field.label
            });

            if (preValues.length > 0) {
                document.querySelector(`#${vsId}`).setValue(preValues);
            }
        });
}


// Apply Filters (append to URL)
document.getElementById('applyFiltersBtn').addEventListener('click', () => {
    const url = new URL(window.location.href);

    // Clear old params
    filtersConfig.forEach(f => {
        url.searchParams.delete(f.key);
        url.searchParams.delete(f.key + '_start');
        url.searchParams.delete(f.key + '_end');
    });

    // Add new params
    document.querySelectorAll('.filter-item').forEach(item => {
        const field = item.querySelector('.filter-field').value;
        const fieldDef = filtersConfig.find(f => f.key === field);
        if (!fieldDef) return;

        if (fieldDef.type === 'date_range') {
            const startDate = item.querySelector('.start-date')?.value;
            const endDate = item.querySelector('.end-date')?.value;
            if (startDate) url.searchParams.set(field + '_start', startDate);
            if (endDate) url.searchParams.set(field + '_end', endDate);
        } else if (fieldDef.type === 'text') {
            const value = item.querySelector('.text-input')?.value;
            if (value) url.searchParams.set(field, value);
        } else {
            const value = item.querySelector('.vscomp-ele').value;
            if (value) url.searchParams.set(field, value);
        }
    });

    window.location.href = url.toString();
});

// Clear All
document.getElementById('clearAllFilters').addEventListener('click', () => {
	const url = new URL(window.location.href);
	filtersConfig.forEach(f => {
		url.searchParams.delete(f.key);
		url.searchParams.delete(f.key + '_start');
		url.searchParams.delete(f.key + '_end');
	});
	window.location.href = url.toString();
});

// Restore filters from URL on page load
(function restoreFilters() {
    const params = new URLSearchParams(window.location.search);

    filtersConfig.forEach(f => {
        if (f.type === 'date_range') {
            const start = params.get(f.key + '_start');
            const end = params.get(f.key + '_end');
            if (start || end) {
                addFilterBlock(f.key, [], start, end);
            }
        } else if (f.type === 'text') {
            if (params.has(f.key)) {
                const value = params.get(f.key);
                addFilterBlock(f.key, [value]);
            }
        } else {
            if (params.has(f.key)) {
                const values = params.get(f.key).split(',');
                addFilterBlock(f.key, values);
            }
        }
    });
})();

toggleNoFiltersMessage();