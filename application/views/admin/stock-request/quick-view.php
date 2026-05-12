<div class="row">
    <div class="col-12">
        <div class="panel panel-default">
            <div class="row p-2">
				<div class="col-md-6"><h6 class="panel-title font-size-14">STR No. - <?php echo $order->request_id;?></h6></div>
				<div class="col-md-6"><h6 class="panel-title font-size-14 text-end">Total Products - <?php echo $order->total_sku;?></h6></div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-start">#</td>
                        <td class="text-start" style="width: 100px;">CHILD SKU</td>
                        <td class="text-start">BARCODE</td>
                        <td class="text-start" style="width: 330px;">PRODUCT NAME/ DESCRIPTION</td>
                        <td class="text-start">SIZE</td>
                        <td class="text-start">QTY</td>
                        <td class="text-start">UNIT PRICE</td>
                        <td class="text-start">AMT. EXCL. VAT</td>
                        <td class="text-start">VAT AMT</td>
                        <td class="text-start">AMT. INC. VAT</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count=1;foreach ($products as $product){ ?>
                    <tr>
                        <td class="text-start"><?= $count++;?></td>
                        <td class="text-start"><?= $product->parent_sku;?>-<?= $product->item_sku;?></td>
                        <td class="text-start"><?= $product->barcode;?></td>
                        <td class="text-start"><?= $product->item_description;?></td>
                        <td class="text-start"><?= $product->size;?></td>
                        <td class="text-start"><?= $product->item_unit;?></td>
                        <td class="text-end"><?= $product->unit_price;?></td>
                        <td class="text-end"><?= $product->amt_excl_vat;?></td>
                        <td class="text-end"><?= $product->vat_amt;?></td>
                        <td class="text-end"><?= $product->amt_incl_vat;?></td>
                    </tr>
                    <?php } ?>
					<tr>
						<td colspan="6"></td>
						<td colspan="4">
							<address>
								<h6>TOTAL UNIT: <span class="float-end"><?= $order->total_qty;?></span></h6>
								<h6>SUBTOTAL: <span class="float-end"><?= $order->total_amt_excl_vat;?></span></h6>
								<h6>VAT %: <span class="float-end">15</span></h6>
								<h6>VAT AMOUNT: <span class="float-end"><?= $order->vat_amt;?></span></h6>
								<h6>SHIPPING & HANDLING: <span class="float-end">-</span> </h6>
								<h6>TOTAL: <span class="float-end"><?= $order->total_tax_inclusive;?></span></h6>
							</address>
						</td>
					</tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> <!-- end row -->
