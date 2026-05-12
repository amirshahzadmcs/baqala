<?php 
    if (!empty($summaryDetails)) {
        $serialNumber = $start;
        foreach ($summaryDetails as $detail) {
?>
    <tr>
        <td><?php echo $serialNumber++; ?></td>
        <?php
        foreach ($visibleTableColumns as $column) {
            $cleanedColumn = strtolower(str_replace(['mhms.', 'me.'], '', $column));

            // Ensure array keys are accessed in lowercase
            $detailKeys = array_change_key_case($detail);

            // Columns that need a percentage sign
            $percentageColumns = ['avg_working_hours', 'attendance_rate', 'acceptance_rate', 'contact_rate', 'no_shows_percent'];

            // Retrieve the value
            $value = $detailKeys[$cleanedColumn] ?? '[NA]';

            // Append % if column matches and round off value
            if (in_array($cleanedColumn, $percentageColumns) && is_numeric($value)) {
                $value = round($value * 100) . '%';
            }

            echo "<td>$value</td>";
        }
        ?>
    </tr>
<?php
        }
    } else {
        echo "<tr>
            <td colspan='12' class='text-center' style='height: 500px;color: #adadad !important;vertical-align: middle;'>
                <i class='mdi mdi-text-box-search-outline fa-9x'></i>
                <br />
                <h4 style='color: #adadad !important;'>No results to show.</h4>
            </td>
            <td colspan='18'></td>
            </tr>";
    }
?>
