<?php if (count($permissions_cat) > 0) { ?>
	<?php echo form_open('admin/roles/permission/add/' . $role_id, array("id" => "permission_form")); ?>
	<input type="hidden" name="role_id" value="<?= $role_id; ?>" required />
	<div class="border p-3 rounded mt-4">
	<input type="checkbox" name="check_all"> Check All
		<h5 class="font-size-16">Permissions</h5>
		<div id="accordion" class="custom-accordion categories-accordion">
			<?php foreach ($permissions_cat as $parentIndex => $pcat) { ?>
				<div class="categories-group-card">
					<a href="#collapse_<?= $pcat['short_code'] . '_' . $parentIndex; ?>" class="categories-group-list collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse_<?= $pcat['short_code'] . '_' . $parentIndex; ?>">
						<i class="mdi mdi-minus float-start accor-plus-icon font-size-16 align-middle me-2"></i> <?php echo $pcat['name']; ?>
					</a>
					<input type="hidden" name="parentCat[<?= $parentIndex; ?>][cat_id]" value="<?= $pcat['id']; ?>" />
					<div id="collapse_<?= $pcat['short_code'] . '_' . $parentIndex; ?>" class="collapse <?= $pcat['short_code']; ?>" data-parent="#accordion">
						<div class="row">
							<?php
							$methods = isset($pcat['methods']) ? json_decode($pcat['methods'], true) : [];
							if (json_last_error() !== JSON_ERROR_NONE || !is_array($methods)) {
								$methods = [];
							}

							foreach ($methods as $methodIndex => $meth1) { ?>
								<div class="col">
									<input class="form-check-input" type="checkbox" name="parentCat[<?= $parentIndex; ?>][cat_per_key][<?= $methodIndex; ?>]" method_key="<?= $meth1['method_key']; ?>" value="<?= $meth1['method_value']; ?>" id="add_<?= $pcat['short_code'] . '_' . $methodIndex; ?>" <?php echo in_array($meth1['method_value'], $pcat['allowed_permissions']) ? 'checked' : ''; ?> />
									<label class="form-check-label" for="add_<?= $pcat['short_code'] . '_' . $methodIndex; ?>">
										<?= $meth1['method_key']; ?>
									</label>
								</div>
							<?php } ?>
						</div>
						<?php if (!empty($pcat['children'])) { ?>
							<div>
								<ul class="list-unstyled categories-list mb-0">
									<?php foreach ($pcat['children'] as $childIndex1 => $child) { ?>
										<li>
											<a href="#collapse_<?= $child['short_code'] . '_' . $parentIndex . '_' . $childIndex1; ?>" class="categories-group-list collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse_<?= $child['short_code'] . '_' . $parentIndex . '_' . $childIndex1; ?>">
												<i class="mdi mdi-minus float-start accor-plus-icon font-size-16 align-middle me-2"></i> <?= $child['name']; ?>
											</a>
											<input type="hidden" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][cat_id]" value="<?= $child['id']; ?>" />
											<div id="collapse_<?= $child['short_code'] . '_' . $parentIndex . '_' . $childIndex1; ?>" class="collapse" data-parent="#accordion">
												<div class="row">
													<?php $childMethods1 = isset($child['methods']) ? json_decode($child['methods'], true) : [];
													foreach ($childMethods1 as $methodIndex1 => $childMeth1) { ?>
														<div class="col">
															<input class="form-check-input" type="checkbox" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][cat_per_key][<?= $methodIndex1; ?>]" method_key="<?= $childMeth1['method_key']; ?>" parent_class="<?= $pcat['short_code']; ?>" value="<?= $childMeth1['method_value']; ?>" id="add_<?= $child['short_code'] . '_' . $methodIndex1; ?>" <?php echo in_array($childMeth1['method_value'], $child['allowed_permissions']) ? 'checked' : ''; ?> />
															<label class="form-check-label" for="add_<?= $child['short_code'] . '_' . $methodIndex1; ?>">
																<?= $childMeth1['method_key']; ?>
															</label>
														</div>
													<?php } ?>
												</div>
												<?php if (!empty($child['children'])) { ?>
													<ul class="list-unstyled categories-list mb-0">
														<?php foreach ($child['children'] as $childIndex2 => $grandchild) { ?>
															<li>
																<a href="#collapse_<?= $grandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2; ?>" class="categories-group-list collapsed" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse_<?= $grandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2; ?>">
																	<i class="mdi mdi-minus float-start accor-plus-icon font-size-16 align-middle me-2"></i> <?= $grandchild['name']; ?>
																</a>
																<input type="hidden" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][cat_id]" value="<?= $grandchild['id']; ?>" />
																<div id="collapse_<?= $grandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2; ?>" class="collapse">
																	<div class="row">
																		<?php $grandchildMethods = isset($grandchild['methods']) ? json_decode($grandchild['methods'], true) : [];
																		foreach ($grandchildMethods as $methodIndex2 => $grandchildMeth) { ?>
																			<div class="col">
																				<input class="form-check-input" type="checkbox" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][cat_per_key][<?= $methodIndex2; ?>]" method_key="<?= $grandchildMeth['method_key']; ?>" value="<?= $grandchildMeth['method_value']; ?>" id="add_<?= $grandchild['short_code'] . '_' . $methodIndex2; ?>" <?php echo in_array($grandchildMeth['method_value'], $grandchild['allowed_permissions']) ? 'checked' : ''; ?> />
																				<label class="form-check-label" for="add_<?= $grandchild['short_code'] . '_' . $methodIndex2; ?>">
																					<?= $grandchildMeth['method_key']; ?>
																				</label>
																			</div>
																		<?php } ?>
																	</div>
																	<?php if (!empty($grandchild['children'])) { ?>
																		<ul class="list-unstyled categories-list mb-0">
																			<?php foreach ($grandchild['children'] as $childIndex3 => $subGrandchild) { ?>
																				<li>
																					<a href="#collapse_<?= $subGrandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3; ?>"
																						class="categories-group-list collapsed"
																						data-bs-toggle="collapse"
																						aria-expanded="false"
																						aria-controls="collapse_<?= $subGrandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3; ?>">
																						<i class="mdi mdi-minus float-start accor-plus-icon font-size-16 align-middle me-2"></i>
																						<?= $subGrandchild['name']; ?>
																					</a>
																					<input type="hidden" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][subgrandchildren][<?= $childIndex3; ?>][cat_id]" value="<?= $subGrandchild['id']; ?>" />
																					<div id="collapse_<?= $subGrandchild['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3; ?>" class="collapse">
																						<div class="row">
																							<?php
																							$subGrandchildMethods = isset($subGrandchild['methods']) ? json_decode($subGrandchild['methods'], true) : [];
																							foreach ($subGrandchildMethods as $methodIndex3 => $subGrandchildMeth) { ?>
																								<div class="col">
																									<input class="form-check-input"
																										type="checkbox"
																										name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][subgrandchildren][<?= $childIndex3; ?>][cat_per_key][<?= $methodIndex3; ?>]"
																										method_key="<?= $subGrandchildMeth['method_key']; ?>"
																										value="<?= $subGrandchildMeth['method_value']; ?>"
																										id="add_<?= $subGrandchild['short_code'] . '_' . $methodIndex3; ?>"
																										<?php echo in_array($subGrandchildMeth['method_value'], $subGrandchild['allowed_permissions']) ? 'checked' : ''; ?> />
																									<label class="form-check-label" for="add_<?= $subGrandchild['short_code'] . '_' . $methodIndex3; ?>">
																										<?= $subGrandchildMeth['method_key']; ?>
																									</label>
																								</div>
																							<?php } ?>
																						</div>
																						<?php if (!empty($subGrandchild['children'])) { ?>
																							<ul class="list-unstyled categories-list mb-0">
																								<?php foreach ($subGrandchild['children'] as $childIndex4 => $subGrandchild_child) { ?>
																									<li>
																										<a href="#collapse_<?= $subGrandchild_child['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3 . '_' . $childIndex4; ?>"
																											class="categories-group-list collapsed"
																											data-bs-toggle="collapse"
																											aria-expanded="false"
																											aria-controls="collapse_<?= $subGrandchild_child['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3 . '_' . $childIndex4; ?>">
																											<i class="mdi mdi-minus float-start accor-plus-icon font-size-16 align-middle me-2"></i>
																											<?= $subGrandchild_child['name']; ?>
																										</a>

																										<input type="hidden" name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][subgrandchildren][<?= $childIndex3; ?>][subsubgrandchildren][<?= $childIndex4; ?>][cat_id]" value="<?= $subGrandchild_child['id']; ?>" />
																										<div id="collapse_<?= $subGrandchild_child['short_code'] . '_' . $parentIndex . '_' . $childIndex1 . '_' . $childIndex2 . '_' . $childIndex3 . '_' . $childIndex4; ?>" class="collapse">
																											<div class="row">
																												<?php
																												$subGrandchildChildMethods = isset($subGrandchild_child['methods']) ? json_decode($subGrandchild_child['methods'], true) : [];
																												foreach ($subGrandchildChildMethods as $methodIndex4 => $subGrandchildChildMeth) { ?>
																													<div class="col">
																														<input class="form-check-input"
																															type="checkbox"
																															name="parentCat[<?= $parentIndex; ?>][children][<?= $childIndex1; ?>][grandchildren][<?= $childIndex2; ?>][subgrandchildren][<?= $childIndex3; ?>][subsubgrandchildren][<?= $childIndex4; ?>][cat_per_key][<?= $methodIndex4; ?>]"
																															method_key="<?= $subGrandchildChildMeth['method_key']; ?>"
																															value="<?= $subGrandchildChildMeth['method_value']; ?>"
																															id="add_<?= $subGrandchild_child['short_code'] . '_' . $methodIndex4; ?>"
																															<?php echo in_array($subGrandchildChildMeth['method_value'], $subGrandchild_child['allowed_permissions']) ? 'checked' : ''; ?> />
																														<label class="form-check-label" for="add_<?= $subGrandchild_child['short_code'] . '_' . $methodIndex4; ?>">
																															<?= $subGrandchildChildMeth['method_key']; ?>
																														</label>
																													</div>
																												<?php } ?>
																											</div>
																										</div>
																									</li>
																								<?php } ?>
																							</ul>
																						<?php } ?>
																					</div>
																				</li>
																			<?php } ?>
																		</ul>
																	<?php } ?>

																</div>
															</li>
														<?php } ?>
													</ul>
												<?php } ?>
											</div>
										</li>
									<?php } ?>
								</ul>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
			<div class="pt-4 ps-3 pb-5">
				<button class="btn btn-custom-success" type="submit">Apply Permissions</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
<?php } else { ?>
	<div class="border p-3 rounded mt-4">
		<h5 class="font-size-16">No Permissions Found</h5>
	</div>
<?php } ?>

<script>
	$(document).on('change', 'input[method_key="View"]', function() {
		if ($(this).prop('checked') === true) {
			$(this).parents('.categories-group-card, .collapse').each(function() {
				$(this).find('> .row:first input[method_key="View"]').prop('checked', true);
			});
		} else {
			$(this).closest('.categories-group-card, .collapse').find('input[type="checkbox"]').each(function() {
				$(this).prop('checked', false);
			});

			$(this).parents('.categories-group-card, .collapse').each(function() {
				var hasCheckedChild = $(this).find('input[method_key="View"]:checked').length > 0;
				if (!hasCheckedChild) {
					$(this).find('> .row:first input[method_key="View"]').prop('checked', false);
				}
			});
		}
	});

	$(document).on('change', 'input[type="checkbox"]', function() {
		if ($(this).attr('method_key') !== 'View') {
			if ($(this).prop('checked') === true) {
				$(this).closest('.row').find('input[method_key="View"]').prop('checked', true);
				var parentContainer = $(this).closest('.' + $(this).attr('parent_class'));
				parentContainer.find('.row:first input[method_key="View"]').prop('checked', true);
			}
		}
	});

	$(document).on('change', 'input[name="check_all"]', function() {
		$('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
	});
</script>