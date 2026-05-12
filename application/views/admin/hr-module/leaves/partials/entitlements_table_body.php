<?php
	$entitlements = json_decode($settings['annual_leave_entitlement'], true);
	if (is_array($entitlements)) {
		foreach ($entitlements as $edays) {
			?>
			<tr>
				<td>Days <?php echo htmlspecialchars($edays); ?></td>
				<td align="right">
					<span class="delete-icon">
						<button class="btn btn-link text-danger delete-btn2"
								data-setting-id="<?php echo htmlspecialchars($settings['id']); ?>"
								data-day="<?php echo htmlspecialchars($edays); ?>">
							<i class="dripicons-trash"></i>
						</button>
					</span>
				</td>
			</tr>
			<?php
		}
	} else {
		echo '<tr><td colspan="2">No entitlements found</td></tr>';
	}
?>
