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
                            'id', 'did', 'ref_id', 'emp_id', 'emp_no', 'full_name', 'driver_name', 'driver_username', 'driver_id', 'amount', 'price', 'driver_debit_amount', 'driver_credit_amount', 'is_free_order', 'dispatch_time', 'subscriber', 'driver_paid_org', 'org_settled', 'driver_settled', 'created_at', 'updated_at'
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
                                        class="form-check-input checkbox available-column" 
                                        type="checkbox" 
                                        data-column="<?= $column; ?>" 
                                        <?= in_array($column, $availableColumns) ? 'checked' : ''; ?>
                                    >
                                    <?= ucfirst(str_replace('_', ' ', $column)); ?>
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

        // Column ko remove karne ka functionality
        $(document).on('click', '.remove-column', function() {
            const columnName = $(this).data('column');
            $(`.visible-columns .visible-column[data-column="${columnName}"]`).remove();
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

        $(document).on('change', '.available-column', function() {
            const columnName = $(this).data('column').trim();
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
                // ✅ Uncheck par remove karne ka logic
                const targetElement = $(`.remove-column[data-column="${columnName}"]`).closest('.visible-column');
                if (targetElement.length) {
                    targetElement.remove(); // ✅ Correct element removed
                } else {
                    console.warn(`Element with data-column="${columnName}" not found!`);
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
            $(this).closest('.visible-column').remove();
            $(`.available-column[data-column="${columnName}"]`).prop('checked', false);

            updateVisibleColumnCount(); // Count update
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
                    module_name: 'jahez_monthly_summary',
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