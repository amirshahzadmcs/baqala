<?php 
    if (!empty($summaryDetails)) {
        $serialNumber = $start;
        foreach ($summaryDetails as $detail) {
?>
    <tr>
        <td><?php echo $serialNumber++; ?></td>
        <?php
            foreach ($visibleTableColumns as $column) {
                $cleanedColumn = strtolower(str_replace(['mjms.', 'me.'], '', $column));

                // Ensure array keys are accessed in lowercase
                $detailKeys = array_change_key_case($detail);

                if ($cleanedColumn === 'dispatch_time' && !empty($detailKeys[$cleanedColumn])) {
                    $timestamp = strtotime($detailKeys[$cleanedColumn]);
                    $formattedDate = ($timestamp) ? date('d-m-Y h:i:s A', $timestamp) : '[Invalid Date]';
                    echo "<td>{$formattedDate}</td>";
                } else {
                    echo "<td>" . ($detailKeys[$cleanedColumn] ?? '[NA]') . "</td>";
                }
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
