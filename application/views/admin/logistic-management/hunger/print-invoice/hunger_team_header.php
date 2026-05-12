<table border="0" cellspacing="0" cellpadding="1" style="font-size: 12px; width: 100%;">
    <tr>
        <td align="left" valign="top" style="width: 50%;">
            <p></p>
            <strong style="font-size: 14px;">Maha Alfala Trading Est.</strong><br><span>Riyadh, SA</span><br><span>VAT No: <?php echo COMPANY_VAT_NO ?></span><br>
        </td>
        <td align="left" valign="center" style="width: 50%;">
            <p></p>
            <strong>Team: <?php echo $team->name;?></strong><br><span>Team Leader: <?php echo $team->full_name;?></span><br><span>Team Leader Mobile: <?php echo $team->mobile;?></span><br><span>Total Members: <?php echo count(json_decode($team->team,true));?></span><br>
        </td>
    </tr>
</table>