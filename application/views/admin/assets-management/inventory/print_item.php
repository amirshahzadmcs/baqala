<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Baqala Station - Items List</title>
    <style>
        * {
            padding: 0px;
            margin: 0px
        }
    </style>
</head>

<body>
    <table border="0" cellspacing="0" cellpadding="1" style="font-size: 10px; width: 100%;">
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10px; width: 100%;">
                    <tr>
                        <td colspan="3" style="width: 100%;">
                            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                                <tr>
                                    <td valign="top" bgcolor="#c6efce" style="width: 7%; text-align: center;"><strong>Sr. No</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Item Code</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 15%; text-align: center;"><strong>SKU</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 30%; text-align: center;"><strong>Item Name</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 20%; text-align: center;"><strong>Category</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 8%; text-align: center;"><strong>Qty</strong></td>
                                    <td valign="top" bgcolor="#c6efce" style="width: 10%; text-align: center;"><strong>Unit</strong></td>
                                </tr>
                                <?php $item_row = 1;
                                foreach ($items as $data) { ?>
                                    <tr>
                                        <td valign="top" style="text-align: center;"><?php echo $item_row; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->code; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->sku; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->name; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->categoryName; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->available_stock; ?></td>
                                        <td valign="top" style="text-align: center;"><?php echo $data->unit_name;; ?></td>
                                    </tr>
                                <?php $item_row = $item_row + 1;
                                } ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>