<?php 
    if (!empty($summaryDetails)) {
        $serialNumber = $start;
        foreach ($summaryDetails as $detail) {
?>
    <tr>
        <td><?php echo $serialNumber++; ?></td>
        <?php
            foreach ($visibleTableColumns as $column) {
                $cleanedColumn = strtolower(str_replace(['jos.', 'me.'], '', $column));

                // Ensure array keys are accessed in lowercase
                $detailKeys = array_change_key_case($detail);
                $styleSet = ($cleanedColumn == 'full_name') ? 'align="left"' : ' align="center"';
                ?>
                <td <?= $styleSet; ?>>
                    <?php 
                        $value = $detailKeys[$cleanedColumn] ?? '[NA]';
                        echo (is_numeric($value) && strpos($value, '.') !== false) ? number_format($value, 2) : $value;
                    ?>
                </td>
        <?php
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
