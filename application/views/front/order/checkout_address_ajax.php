<?php
		$i = 1;
		if($addresses->num_rows()){
		echo '<p class="bg-white p-2 font-weight-bold">Select Address: </p>';
		foreach($addresses->result() as $address){?>
			<div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
				<input type="hidden" id="delvadd" value="<?php echo $this->session->userdata('delievery_id'); ?>" />
				<input type="radio" id="customRadioInline<?php echo $i; ?>" name="customRadioInline1" class="custom-control-input" onclick="set_delievery('<?php echo $address->id;?>')" <?php if($this->session->userdata('delievery_id') == $address->id){ echo 'checked'; }?> />
				<label class="custom-control-label w-100" for="customRadioInline<?php echo $i; ?>">
					<div>
						<div class="p-3 bg-white rounded shadow-sm w-100">
							<div class="d-flex align-items-center mb-2">
								<p class="mb-0 h6"><?php echo $address->address_type; ?></p>
								<?php if($this->session->userdata('delievery_id') == $address->id){ ?>
								<p class="mb-0 badge badge-success ml-auto"><?php echo $this->lang->line('msg_selected') ?></p>
								<?php } ?>
							</div>
							<p class="small text-muted m-0"><b><?php echo $address->name; ?></b></p>
							<p class="small text-muted m-0"><?php echo $address->complete_address; ?></p>
							<p class="pt-2 m-0 text-right">
								<span class="small">
								<button type="button" class="btn btn-outline-warning btn-sm ml-auto" onclick="edit_address('<?php echo $address->id;?>')"><?php echo $this->lang->line('msg_edit') ?></button>
								<button type="button" class="btn btn-outline-danger btn-sm ml-auto" onclick="delete_address('<?php echo $address->id;?>')"><?php echo $this->lang->line('msg_delete') ?></button>
								</span>
							</p>
						</div>
					</div>
				</label>
			</div>
		<?php $i++;} } else{ ?>
			<div class="custom-control custom-radio px-0 mb-3 position-relative border-custom-radio">
				<?php echo $this->lang->line('msg_no_address_added') ?>
			</div>
		<?php } ?>
