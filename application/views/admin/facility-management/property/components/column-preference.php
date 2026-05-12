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
                            'id', 'property_number', 'property_name', 'property_type', 'property_city', 'property_status', 'tenant_company_id', 'tenant_unified_number', 'tenant_cr_no', 'brokerage_entity_name', 'brokerage_entity_address', 'brokerage_landline_no', 'brokerage_cr_no', 'brokerage_vat_no', 'broker_name', 'broker_nationality', 'broker_id_no', 'broker_person', 'broker_mobile_no', 'broker_email_id', 'account_name', 'bank_name', 'iban', 'ejar_contract_number', 'ejar_contract_start_date', 'ejar_contract_end_date', 'attach_ejar_contract', 'created_at', 'updated_at'
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
                                    <?php if ($column === 'id'): ?>
                                        <!-- Always checked and readonly-like -->
                                        <input 
                                            class="form-check-input checkbox available-column mt-0 me-2" 
                                            type="checkbox" 
                                            checked 
                                            onclick="return false;" 
                                            data-column="<?= $column; ?>"
                                        >
                                        <input type="hidden" name="columns[]" value="id">
                                    <?php else: ?>
                                        <input 
                                            class="form-check-input checkbox available-column mt-0 me-2" 
                                            type="checkbox" 
                                            name="columns[]" 
                                            value="<?= $column; ?>" 
                                            <?= in_array($column, $availableColumns) ? 'checked' : ''; ?>
                                            data-column="<?= $column; ?>"
                                        >
                                    <?php endif; ?>
                                    <?= ucwords(str_replace('_', ' ', $column)); ?>
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
                        <div class="d-flex align-items-center mb-1 visible-column" data-column="id">
                            <div class="visible-column-icon cursor-move text-muted me-2" style="visibility: hidden;">
                                <i class="fas fa-grip-vertical"></i>
                            </div>
                            <div class="visible-column-text">Id</div>
                        </div>
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

        // Column ko remove karne ka functionality
        $(document).on('click', '.remove-column', function() {
            const columnName = $(this).data('column');

            // Prevent removing 'id' column
            if (columnName === 'id') {
                toastr.warning("You can't remove the ID column.");
                return;
            }

            // Proceed with removing other columns
            $(`.visible-columns .visible-column[data-column="${columnName}"]`).remove();
            $(`.available-column[data-column="${columnName}"]`).prop('checked', false);

            updateVisibleColumnCount();
        });


        // Drag-and-Drop Sorting
        $(".visible-columns").sortable({
            handle: ".visible-column-icon",
            axis: "y",
            items: ".visible-column:not([data-column='id'])",
            placeholder: "ui-state-highlight",
            update: function() {
                updateVisibleColumnCount();
            }
        }).disableSelection();

        $(document).on('change', '.available-column', function() {
            const columnName = $(this).data('column').trim();
            if (columnName === 'id') return;

            const columnText = $(this).closest('label').text().trim();

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
                $(`.visible-column[data-column="${columnName}"]`).remove();
            }

            updateVisibleColumnCount();
        });

        // ✅ Column Count Update Logic
        function updateVisibleColumnCount() {
            const count = $('.visible-columns .visible-column').not('[data-column="id"]').length;
            $('.badge.bg-primary').text(count);
        }

        // ✅ Remove Column Logic for Dynamic Elements
        $(document).on('click', '.remove-column', function() {
            const columnName = $(this).data('column');
            if (columnName === 'id') return;

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

            const visibleColumns = ['id'];
            $('.visible-column').not('[data-column="id"]').each(function() {
                visibleColumns.push($(this).data('column'));
            });

            $.ajax({
                url: '<?= base_url('admin/manage-column/save-preferences') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    module_name: 'facilities_properties',
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

        updateVisibleColumnCount(); // Initial count
    });

</script>