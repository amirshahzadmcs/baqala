<style>
	.t_table td {
    border: 1px solid #555555;
    border-collapse: collapse;
    padding: 6px 19px 12px 28px;
    font-size: 13px;
	
	}
</style>
<?php 

if(isset($result))
{ ?>
<div class="tab-pane active" id="journal" role="tabpanel">
	<div class="graytempmain">
		<div class="invoice-wrap">
			<div class="invoice-inner">
				<h2 class="">
					Journal Entry #<?php echo $result->number;?> </h2>
				<table class="f_table">
					<tbody>
						<tr style="line-hight:10px;" style="font-size:16px;">
							<td>Date: <?php echo date("d-m-Y", strtotime($result->entry_date));?></td>
						</tr>
						
						<tr style="line-hight:10px;">
							<td style="font-size:16px;">
								Description: <?php echo $result->description;?> </td>
							<td class="pull-right">
							</td>
						</tr>
					</tbody>
				</table>
				<br>
				<br>

				<table id="listing_table" class="t_table">
					<tbody>
					
						<tr class="bold" style="text-align:ceneter;">
							<td colspan="2">Account</td>
							<td>Description</td>
							<td>Cost Center </td>
							<td>Debit</td>
							<td>Credit</td>
						</tr>
						
						<?php 
						$account=getJournalAccount($result->entry_id);
						// print_r($account);
						foreach ($account as $accountdetail)
						{?>
						<tr style="text-align:ceneter;">
							<td> <?php echo $result->number; ?> </td>
							<td><?php echo $accountdetail['account_name']; ?> </td>
							<td> <?php echo $accountdetail['description']; ?> </td>
							<td>
							<?php echo $accountdetail['cost_center']; ?></td>
							<td> <?php echo $accountdetail['debit']; ?></td>
							<td><?php echo $accountdetail['credit']; ?></td>
						</tr>
						<?php } ?>
						
						<tr bgcolor="#e5e5e5" style="font-weight:bold;" class="bold">
							<td colspan="4">Total</td>
							<td style="word-wrap: break-word;"><?php echo $result->debit_total;?>&nbsp;SR</td>
							<td style="word-wrap: break-word;" colspan="1"><?php echo $result->credit_total;?>&nbsp;SR</td>

						</tr>
					</tbody>
				</table>
				<br>
			</div>
		</div>
	</div>
</div>
<?php } ?>


