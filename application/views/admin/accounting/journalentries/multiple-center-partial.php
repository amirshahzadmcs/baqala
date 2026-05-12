<tr class="multiple-center-tr" id="trmultiple_<?= $id;?>" style="background: #f9f9f9;">
    <td colspan="4">
        <table id="multipleTable<?= $id;?>" class="table w-100 border" style="border:1px solid #edf1f5!important">
            <thead>
                <tr>
                    <td class="text-start" style="width: 40%;">Cost Center</td>
                    <td class="text-start">Percentage</td>
                    <td class="text-start">Amount</td>
                    <td align="right" style="padding: 5px;">
						<button type="button" onclick="removeMultiAll(<?= $id;?>);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button>
					</td>
                </tr>
            </thead>
            <tbody>
				<tr id="multi-row<?= $id;?>">
					<td>
						<div class="custom-dropdown">
							<select class="form-select select2 cost-center-select" name="data[CostCenterTransactionV2][<?= $id;?>][0][cost_center]" style="width: 200px;">
								<option value="">None</option>
								<?php foreach($costcenters as $costcent){ ?>
								<option value="<?php echo $costcent['code'];?>"><?php echo '#'.$costcent['code'] .'-'. $costcent['name'];?></option>
								<?php } ?>
							</select>
						</div>
					</td>
					<td><div class="input-group"><input type="text" class="form-control debit" required="" name="data[CostCenterTransactionV2][<?= $id;?>][0][tax_percent]"><span class="input-group-text input-group-append">%</span></div></td>
					<td><input type="text" class="form-control amount" required="" name="data[CostCenterTransactionV2][<?= $id;?>][0][amount]"></td>
					<td align="right"><button type="button" onclick="removeMultiFirst(<?php echo $id; ?>);" data-toggle="tooltip" title="Remove" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i></button></td>
				</tr>
            </tbody>
			<tfoot>
				<tr>
					<td><a href="javascript:;" onclick="addMultiSingle(<?= $id;?>);" class="float-start"><i class="fa fa-plus-circle"></i> Add Cost Center</a> <span class="float-end"><b>Total</b></span></td>
					<td><span class="total-percent">0.00%</span></td>
					<td><span class="total-amount">0.00</span></td>
					<td></td>
				</tr>
			</tfoot>
        </table>
    </td>
	<script>
		$('.cost-center-select').select2({
			placeholder: 'Select an option'
		});
	</script>
</tr>
