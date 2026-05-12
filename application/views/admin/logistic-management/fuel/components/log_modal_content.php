<?php if (!empty($logs)) : ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="bg-secondary text-white">
                <th>S.No.</th>
                <th>Emp No</th>
                <th>Employee Name</th>
                <th>Iqama No</th>
                <th>Date</th>
                <th>Attendance</th>
                <th>Vehicle No</th>
                <th>Vehicle Type</th>
                <th>Aggregator ID</th>
                <th>Aggregator Name</th>
                <th>Final Deliveries</th>
                <th>Team</th>
                <th>Remarks</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $index => $log): ?>
                <?php $details = $log['log_details']; ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $details['emp_no'] ?? '-'; ?></td>
                    <td><?= $details['emp_full_name'] ?? '-'; ?></td>
                    <td><?= $details['iqama_no'] ?? '-'; ?></td>
                    <td><?= isset($details['date_of_attend']) ? date('d-m-Y', strtotime($details['date_of_attend'])) : '-'; ?></td>
                    <td><?= $details['attend_type'] ?? '-'; ?></td>
                    <td><?= $details['vehicle_no'] ?? '-'; ?></td>
                    <td><?= $details['vehicle_type'] ?? '-'; ?></td>
                    <td><?= $details['aggregator_id'] ?? '-'; ?></td>
                    <td><?= $details['aggregator_name'] ?? '-'; ?></td>
                    <td><?= $details['total_deliveries'] ?? '-'; ?></td>
                    <td><?= $details['team_name'] ?? '-'; ?></td>
                    <td><?= $details['remarks'] ?? '-'; ?></td>
                    <td><?= date('d-m-Y H:i:s', strtotime($log['created_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-center p-3 mb-0">No logs found for this attendance record.</p>
<?php endif; ?>
