<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ae">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Maha Al Fala - Hunger Invoice</title>
    <style>
        table {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <table cellspacing="10" cellpadding="10">
        <tr>
            <td></td>
        </tr>
    </table>
    <table cellpadding="2px">
        <tr>
            <td style="text-align:right; border: 1px solid black; width:33%;">HS- <?php echo date('dY',strtotime($start_date)); ?></td>
            <td style="text-align:right; border: 1px solid black; width:17%;">رقم الفاتورة</td>
            <td style="text-align:right; border: 1px solid black; width:33%;">شركة هنقرستيشن المحدودة </td>
            <td style="text-align:right; border: 1px solid black; width:17%;">عميل</td>
        </tr>

        <tr>
            <td style="text-align:right; border: 1px solid black; width:33%;"><?php echo date('d/m/y'); ?></td>
            <td style="text-align:right; border: 1px solid black; width:17%;">تاريخ</td>
            <td style="text-align:right; border: 1px solid black; width:33%;">العنوان: الرياض - ي ح الیاسم ن ی - طريق الملك عبد العزي ز</td>
            <td style="text-align:right; border: 1px solid black; width:17%;">عنوان</td>
        </tr>

        <tr>
            <td style="text-align:right; border: 1px solid black; width:33%;"><?php echo 'إلى ' . $end_date . ' من ' . $start_date; ?></td>
            <td style="text-align:right; border: 1px solid black; width:17%;">فترة</td>
            <td style="text-align:right; border: 1px solid black; width:33%;">310069655100003</td>
            <td style="text-align:right; border: 1px solid black; width:17%;">ظريبه الشراء</td>
        </tr>

    </table>

    <table cellspacing="10" cellpadding="10">
        <tr>
            <td></td>
        </tr>
    </table>
    <table cellpadding="2px">
        <tr style="background-color: #f1b287; color:#000;">
            <td style="text-align:right; border: 1px solid black; width:21%;">المجموع</td>
            <td style="text-align:center; border: 1px solid black; width:21%;">معدل</td>
            <td style="text-align:center; border: 1px solid black; width:15%;">الكمية</td>
            <td style="text-align:center; border: 1px solid black; width:43%;">وصف</td>
        </tr>
        <?php foreach ($invoices as $invoice) { ?>
            <tr>
                <td style="text-align:right; border: 1px solid black; width:21%;"><span>ر.س</span> <?php echo number_format($invoice->TotalAmountWSD, 2); ?></td>
                <td style="text-align:center; border: 1px solid black; width:21%;"><span>ر.س</span> <?php echo number_format($invoice->rate, 2); ?></td>
                <td style="text-align:center; border: 1px solid black; width:15%;"><?php echo $invoice->orders; ?></td>
                <td style="text-align:center; border: 1px solid black; width:43%;">عمولة توصيل طلبات هنقرستيشن في <?php echo date('F', strtotime($invoice->invoice_month)); ?></td>
            </tr>
        <?php } ?>
    </table>

    <table cellpadding="2px">
        <tr>
            <td style="text-align:right; border: 1px solid black; width:21%;">ر.س <?php echo number_format($sums['VAT'], 2); ?></td>
            <td style="text-align:right; border: 1px solid black; width:30%;">ضريبة القيمة المضافة 15%</td>
        </tr>
        <tr>
            <td style="text-align:right; border: 1px solid black; width:21%;">ر.س <?php echo number_format($sums['AmountIncVAT'], 2); ?></td>
            <td style="text-align:right; border: 1px solid black; width:30%;">الإجمالي شامل ضريبة القيمة المضافة</td>
        </tr>
        <tr>
            <td style="text-align:right; border: 1px solid black; width:21%;">ر.س <?php echo number_format($sums['RiderBalance'], 2); ?></td>
            <td style="text-align:right; border: 1px solid black; width:30%;">المدفوعة (المحفظة)</td>
        </tr>
        <tr>
            <td style="text-align:right; border: 1px solid black; width:21%;">ر.س <?php echo number_format($sums['AmountIncVAT']-$sums['RiderBalance'], 2); ?></td>
            <td style="text-align:right; border: 1px solid black; width:30%;">المبلغ المستحق</td>
        </tr>
    </table>

    <table cellspacing="6" cellpadding="6">
        <tr>
            <td style="width:40%;"><img src="<?php echo $qrCode; ?>" alt="QR Code" width="80px"></td>
            <td style="width:62%">
                <table cellpadding="2px">
                    <tr>
                        <td colspan="1" style="text-align:center; border: 1px solid black; width:100%; background-color: #000; color:#fff;">Bank Account Information</td>
                        <!-- <td style="text-align:center; border: 1px solid black; width:30%; background-color: #000; color:#fff;">Bank Account </td> -->
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right; border: 1px solid black; width:100%;"> مضف الراجح</td>
                        <!-- <td style="text-align:right; border: 1px solid black; width:30%;">البنك:</td> -->
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right; border: 1px solid black; width:100%;">MAHA ALFALA TRADING ESTABLISHMENT</td>
                        <!-- <td style="text-align:right; border: 1px solid black; width:30%;"> اسم ا :</td> -->
                    </tr>
                    <tr>
                        <td colspan="1" style="text-align:right; border: 1px solid black; width:100%;">SA1780000504608010839885</td>
                        <!-- <td style="text-align:right; border: 1px solid black; width:30%;">الآيبان رقم :</td> -->
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>