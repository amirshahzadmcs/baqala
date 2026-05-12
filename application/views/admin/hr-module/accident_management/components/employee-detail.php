<div class="size-inner-section px-1 py-1">
    <div class="card-header">Driver Detail</div>
    <div class="d-flex align-items-center employee-detail">
        <div class="image">
			<?php if(!empty($emp_detail['employee_pic']) && $emp_detail['employee_pic'] !== ''){ ?>
				<img src="<?php echo $emp_detail['employee_pic'];?>" class="rounded" width="100">
			<?php }else{ ?>
				<img src="<?php echo base_url('images/user-img.png'); ?>" class="rounded" width="100">
			<?php } ?>
        </div>
        <div class="p-3 w-100">
            <h5 class="mb-0 mt-0"> <?php echo $emp_detail['full_name'];?> / <?php echo $emp_detail['employee_arabic_name'];?> </h5>
            <span><?php echo $emp_detail['designation_name'];?> | <?php echo $emp_detail['department_name'];?></span>
            <hr class="my-1">
            <table>
                <tr>
                    <td>Emp No.</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['emp_no'];?></td>
                </tr>
				<tr>
                    <td>Nationality</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['nationality_name'];?></td>
                </tr>
                <tr>
                    <td>Flex Number</td>
                    <td> : </td>
                    <td><?php echo (!empty($sim_detail['mobile'])) ? $sim_detail['mobile'] : 'NA';?></td>
                </tr>
                <tr>
                    <td>Mobile No</td>
                    <td> : </td>
                    <td><?php echo $emp_detail['mobile'];?></td>
                </tr>
				<tr>
                    <td>DL Number</td>
                    <td> : </td>
                    <td><?php if(!empty($other_detail['driving_license_number'])){ echo $other_detail['driving_license_number'];}else{ echo 'NA';}?></td>
                </tr>
            </table>
        </div>
    </div>
</div>