<?php

$id= $_GET['id'];
$order = get_post_meta( $id );
$orderDetail = wc_get_order( $id );
//var_dump($orderDetail);
$mapUrl = 'google.com/maps/place/' .get_post_meta( $id, 'olocations', true ) . ',19z';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>فاکتور فروش</title>
    <style>

    </style>
    <style>
        html, body {
            padding: 0;
            margin: 0 auto;
            max-width: 29.7cm;
            -webkit-print-color-adjust: exact;
        }

        body {
            padding: 0.5cm
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table {
            table-layout: fixed;
            border-spacing: 0;
        }

        .header-table td {
            padding: 0;
            vertical-align: top;
        }

        body {
            font: 9pt IRANYekanWeb;
            direction: rtl;
        }

        .print-button {
            cursor: pointer;
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            border-radius: 5px;
            background: none;
            -webkit-transition: all .3s ease-in-out;
            transition: all .3s ease-in-out;
            position: relative;

            outline: none;
            text-align: center;

            padding: 8px 16px;
            font-size: 12px;
            font-size: .857rem;
            line-height: 1.833;
            font-weight: 700;
            background-color: #0fabc6;
            color: #fff;
            border: 1px solid #0fabc6;
        }

        .page {
            background: white;
            page-break-after: always;
        }

        .flex {
            display: flex;
        }

        .flex > * {
            float: left;
        }

        .flex-grow {
            flex-grow: 10000000;
        }

        .barcode {
            text-align: center;

        }

        .barcode span {
            font-size: 35pt;

        }

        .portait {
            transform: rotate(-90deg) translate(0, 40%);
            text-align: center;
        }

        .header-item-wrapper {
            border: 1px solid #000;
            width: 100%;
            height: 100%;
            background: #eee;
            display: flex;
            align-content: center;
        }

        thead, tfoot {
            background: #eee;
        }

        .header-item-data {
            height: 100%;
            width: 100%;
        }

        .bordered {
            border: 1px solid #000;
            padding: 0.12cm;
        }

        .header-table table {
            width: 100%;
            vertical-align: middle;
        }

        .content-table {
            border-collapse: collapse;
        }

        .content-table td, th {
            border: 1px solid #000;
            text-align: center;
            padding: 0.1cm;
            font-weight: normal;
        }

        table.centered td {
            vertical-align: middle;
        }

        .serials {
            direction: ltr;
            text-align: left;
        }

        .title {
            text-align: right;
        }

        .grow {
            width: 100%;
            height: 100%;
        }

        .font-small {
            font-size: 8pt;
        }

        .font-medium {
            font-size: 10pt;
        }

        .font-big {
            font-size: 15pt;
        }

        .label {
            font-weight: bold;
            padding: 0 0 0 2px;
        }

        @page {
            size: A4 landscape;
            margin: 0;
            margin-bottom: 0.5cm;
            margin-top: 0.5cm;
        }

        .ltr {
            direction: ltr;
            display: block;
        }
    </style>
</head>
<body>
<button class="print-button" id="print-button">پرینت</button>
<div class="page">
    <h1 style="text-align: center">
        فاکتور فـروش كـالا و خـدمات
    </h1>
    <table class="header-table" style="width: 100%">
        <tr>
            <td style="width: 1.8cm; height: 2.5cm;vertical-align: middle;padding-bottom: 4px;">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin: 5px;">
                        فروشنده
                    </div>
                </div>
            </td>
            <td style="padding: 0 4px 4px;height: 2cm;">
                <div class="bordered grow header-item-data">
                    <table class="grow centered">
                        <tr>
                            <td style="width: 7cm">
                                <span class="label">فروشنده:</span><?=$sellerName; ?>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">نشانی شرکت:</span><?=$sellerAddress; ?>

                            </td>
                            <td>
                                <span class="label">کدپستی:</span> <?=$sellerZipCode; ?>
                            </td>
                            <td>
                                <span class="label">تلفن و فکس:</span> <?=$sellerPhone; ?>
                            </td>
                        </tr>
                    </table>                </div>
            </td>
            <td style="width: 4.5cm;height: 2cm;padding: 0 0 4px;">
                <div class="bordered grow" style="padding: 2mm 5mm;">
                    <div class="flex">
                        <div class="font-small">شماره فاکتور:</div>
                        <div class="flex-grow" style="text-align: left"><?=$shopperOrderID; ?></div>
                    </div>
                    <div class="flex">
                        <div>تاریخ:</div>
                        <div class="flex-grow"
                             style="text-align: left"><?=$invoiceDate ='1399/05/09'; ?></div>
                    </div>
                    <div class="flex">
                        <div>پیگیری:</div>
                        <div class="flex-grow font-medium"
                             style="text-align: left"><?=$id ?></div>
                    </div>

                    <div class="barcode">
                        <span style="font-family: 'Libre Barcode 128'"><?=$gnjInvoice; ?></span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="width: 1.8cm; height: 2cm;vertical-align: center; padding: 0 0 4px">
                <div class="header-item-wrapper">
                    <div class="portait" style="margin: 20px">خریدار</div>
                </div>
            </td>
            <td style="height: 2cm;vertical-align: center; padding: 0 4px 4px">
                <div class="bordered header-item-data">
                    <table style="height: 100%" class="centered">
                        <tr>
                            <td style="width: 6.7cm">
                                <span class="label">خریدار:</span> <?=$order['_shipping_first_name']['0']." ".$order['_shipping_last_name']['0']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <span class="label">نشانی:</span><?=$order['_shipping_state']['0']." ".$order['_shipping_address_1']['0']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="label">شماره تماس:</span><?=$order['_billing_phone']['0']; ?>
                            </td>
                            <td colspan="2">
                                <span class="label">کد پستی:</span> <?=$order['_shipping_postcode']['0']; ?>
                            </td>
                        </tr>
                    </table>                </div>
            </td>
            <td style="padding: 0 0 4px">
                <div class="grow bordered" style="padding: 2mm 5mm;">

                    <span>موقعیت</span>
                    <div class="barcode">

                        <span><?php echo '<img src="https://chart.googleapis.com/chart?chs=70x70&cht=qr&chl=http%3A%2F%2F'.$mapUrl.'%2F&choe=UTF-8" title="Link to Google.com" />'; ?></span>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <table class="content-table">
        <thead>
        <tr>
            <th>ردیف</th>
            <th>کد کالا</th>
            <th style="width: 30%">شرح کالا</th>
            <th>تعداد</th>
            <th style="width: 2.3cm">مبلغ واحد (ریال)</th>
            <th style="width: 2.3cm">مبلغ کل (ریال)</th>
            <th style="width: 2.3cm">تخفیف (ریال)</th>
            <th style="width: 2.3cm">مبلغ کل پس از تخفیف (ریال)</th>
        </tr>
        </thead>
        <?php
        $row = 1;
        foreach ( $orderDetail->get_items() as $item_id => $item ) {

            $variation_id = $item->get_variation_id();
            $product = $item->get_product();
            $type = $item->get_type();
            $product_type   = $product->get_type();
            $product_sku    = $product->get_sku();
            $product_price  = $product->get_price();
            $product_rprice  = $product->get_regular_price();
            $discount = ($product->get_regular_price()-$product->get_price()) * $item->get_quantity();

            ?>
        <tr>
            <td><?=$row; ?></td>
            <td><?=$item->get_product_id(); ?></td>
            <td>
                <div class="title"><?=$item->get_name(); ?></div>
            </td>
            <td><span class="ltr"><?=$item->get_quantity() ?></span></td>
            <td><span class="ltr">
                                           <?=$product->get_regular_price(); ?>
                                    </span></td>

            <td><span class="ltr">
                                            <?=$product_rprice * $item->get_quantity(); ?>
                                        </span></td>

            <td><span class="ltr">
                                            <?= $discount?>
                                        </span></td>

            <td><span class="ltr">
                                           <?=$item->get_total(); ?>
                                        </span></td>

        </tr>
        <?php
            ++$row;
        } ?>


        <tfoot>
        <tr>
            <td colspan="4">
            <td colspan="3" class="font-small">
                جمع کل پس از تخفیف و کسر مالیات و عوارض (ریال):
            </td>
            <td><span class="ltr">
                                      <?=$orderDetail->get_total(); ?>
                                </span></td>
        </tr>
        <tr style="background: #fff">
            <td colspan="8" style="height: 2.5cm;vertical-align: top">
                <div class="flex">
                    <div class="flex-grow">مهر و امضای فروشنده:</div>
                    <div class="flex-grow">تاریخ تحویل:</div>
                    <div class="flex-grow">ساعت تحویل:</div>
                    <div class="flex-grow">مهر و امضای خریدار:</div>
                </div>
                <div class="flex">
                    <div class="flex-grow">
                        <img class="footer-img uk-align-center" width="150px"
                             src="<?=$stamp; ?>">
                    </div>
                    <div class="flex-grow"><?=$invoiceDate; ?></div>
                    <div class="flex-grow"><?=$invoiceTime; ?></div>
                    <div class="flex-grow"></div>
                </div>
            </td>
        </tr>
        </tfoot>
    </table>
</div> </body>

<script>
    var printButton = document.getElementById('print-button');
    printButton.addEventListener('click', function() {
        window.print();
    })
</script>
</html>
