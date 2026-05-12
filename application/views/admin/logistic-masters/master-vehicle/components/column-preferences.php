<style> 
#columnManagementForm .form-check-label {
    text-transform: capitalize;
}
</style>
<div class="modal-header">
	<h5 class="modal-title px-3" id="manageColumnModalLabel">Manage Columns</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
	<div class="py-2">Select which columns are visible for you. To change the column order, drag and drop the visible fields.</div>
	<form id="columnManagementForm" method="post" autocomplete="off">
		<div class="row">
			<div class="col-md-6">
				<div class="card">
                    <?php
                        $availableTableColumns = [
                            'id', 'vehicle_ownership', 'owner_name_select', 'vehicle_type', 'vehicle_no', 'vehicle_expiry', 'vehicle_year', 'color_name', 'make_name', 'vehicle_model', 'purchase_date', 'chassis_no', 'vehicle_category', 'insurance_no', 'insurance_company_name', 'insurance_issue_date', 'insurance_class', 'insurance_expiry', 'sequel_no', 'status', 'inactive_reason', 'allotment_status', 'status_reason', 'status_date', 'alloted_user', 'allotment_date', 'ip', 'gps_installed', 'gps_device_serial', 'gsp_mobile_no', 'gps_installation_date', 'gps_expiry_date', 'custom_card_no', 'gasoline_chip_status', 'gasoline_installation_date', 'registration_certificate', 'insurance_certificate', 'operation_card_no', 'operation_card_issue_date', 'operation_card_expiry_date', 'attached_file', 'tamm_attachment', 'location', 'city_of_operation', 'created_at', 'updated_at'
                        ];
                    ?>
					<div class="card-header pb-2">Available Columns <span class="badge bg-secondary"><?= count($availableTableColumns);?></span></div>
					<div class="card-body p-2">
						<div class="search-box chat-search-box mb-2">
							<div class="position-relative">
								<input type="search" id="searchColumn" class="form-control" placeholder="Filter columns" />
								<i class="mdi mdi-magnify search-icon"></i>
							</div>
						</div>
						<!-- Available Columns -->
						<?php foreach ($availableTableColumns as $column): ?>
                            <div class="form-check mb-2">
                                <label class="form-check-label">
                                    <input 
                                        class="form-check-input checkbox available-column mt-0 me-2" 
                                        type="checkbox" 
                                        data-column="<?= $column; ?>" 
                                        <?= ($column === 'id') ? 'checked readonly' : (in_array($column, $availableColumns) ? 'checked' : ''); ?>
                                    >
                                    <?= ucfirst(str_replace('_', ' ', $column)); ?>
                                    <?php if ($column === 'id'): ?>
                                        <span class="badge bg-info ms-1">Required</span>
                                    <?php endif; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header pb-2">Visible Columns <span class="badge bg-primary">0</span> <span class="float-end"><a href="javascript:;">Restore defaults</a></span></div>
					<div class="card-body p-2 visible-columns">
                        
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-custom-white" data-bs-dismiss="modal">Close</button>
	<button type="submit" form="columnManagementForm" class="btn btn-custom" id="savePreferences">Apply changes</button>
</div>

<script>
	$(document).ready(function() {
        $('#searchColumn').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();

            $('.available-column').each(function() {
                const columnText = $(this).closest('label').text().trim().toLowerCase();

                if (columnText.includes(searchText)) {
                    $(this).closest('.form-check').show();
                } else {
                    $(this).closest('.form-check').hide();
                }
            });

            const visibleCount = $('.form-check:visible').length;
            $('.badge.bg-secondary').text(visibleCount);
        });

        $(document).on('click', '.remove-column', function() {
            const columnName = $(this).data('column');

            // 🚫 Prevent removing ID
            if (columnName === 'id') {
                toastr.warning('ID column cannot be removed!');
                return;
            }

            $(this).closest('.visible-column').remove();
            $(`.available-column[data-column="${columnName}"]`).prop('checked', false);

            updateVisibleColumnCount();
        });

        // Drag-and-Drop Sorting
        $(".visible-columns").sortable({
            handle: ".visible-column-icon",
            axis: "y",
            placeholder: "ui-state-highlight",
            update: function() {
                updateVisibleColumnCount();
            }
        }).disableSelection();
		
		// Force add ID column into visible columns on page load
		if ($('.visible-columns .visible-column[data-column="id"]').length === 0) {
			const idColumnHTML = `
				<div class="d-flex align-items-center mb-1 visible-column" data-column="id">
					<div class="visible-column-icon cursor-move">
						<i class="fas fa-grip-vertical text-muted me-2"></i>
					</div>
					<div class="visible-column-text">ID <span class="badge bg-info ms-1">Required</span></div>
					<div class="ms-auto">
						<!-- disable remove button for ID -->
						<i class="mdi mdi-lock text-secondary p-1"></i>
					</div>
				</div>
			`;
			$('.visible-columns').prepend(idColumnHTML);
			updateVisibleColumnCount();
		}
		
        $(document).on('change', '.available-column', function() {
            const columnName = $(this).data('column').trim();
            const columnText = $(this).closest('label').text().trim();

            // 🚫 Prevent ID from being unchecked
            if (columnName === 'id') {
                $(this).prop('checked', true); 
                return;
            }

            if ($(this).is(':checked')) {
                if (!$(`.visible-column[data-column="${columnName}"]`).length) {
                    const newColumn = `
                        <div class="d-flex align-items-center mb-1 visible-column" data-column="${columnName}">
                            <div class="visible-column-icon cursor-move">
                                <i class="fas fa-grip-vertical text-muted me-2"></i>
                            </div>
                            <div class="visible-column-text">${columnText}</div>
                            <div class="ms-auto remove-column" data-column="${columnName}">
                                <i class="mdi mdi-close-circle text-muted p-1"></i>
                            </div>
                        </div>
                    `;
                    $('.visible-columns').append(newColumn);
                }
            } else {
                const targetElement = $(`.remove-column[data-column="${columnName}"]`).closest('.visible-column');
                if (targetElement.length) {
                    targetElement.remove();
                }
            }

            updateVisibleColumnCount();
        });

        // ✅ Column Count Update Logic
        function updateVisibleColumnCount() {
            const count = $('.visible-columns .visible-column').length;
            $('.badge.bg-primary').text(count);
        }

        // ✅ Remove Column Logic for Dynamic Elements
        $(document).on('click', '.remove-column', function() {
            const columnName = $(this).data('column');

            // 🚫 Prevent removing ID
            if (columnName === 'id') {
                toastr.warning('ID column cannot be removed!');
                return;
            }

            $(this).closest('.visible-column').remove();
            $(`.available-column[data-column="${columnName}"]`).prop('checked', false);

            updateVisibleColumnCount();
        });

        $('#savePreferences').on('click', function(e) {
            e.preventDefault();

            const availableColumns = [];
            $('.available-column:checked').each(function() {
                availableColumns.push($(this).data('column'));
            });

            const visibleColumns = [];
            $('.visible-column').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            $.ajax({
                url: '<?= base_url('admin/manage-column/save-preferences') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    module_name: 'vehicles',
                    available_columns: availableColumns,
                    visible_columns: visibleColumns
                },
                success: function(response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        location.reload();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('Error saving preferences!');
                }
            });
        });
    });

</script>