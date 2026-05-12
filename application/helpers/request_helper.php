<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function addSpaceBetweenWords($string) {
    $result = preg_replace('/(?<!^)([A-Z])/', ' $1', $string);
    return $result;
}

if (!function_exists('get_asset_details')) {
    function get_asset_details($requestDetail) {
        $ci =& get_instance();
        // Decode the JSON string to get assets_ids
        $detail = json_decode($requestDetail, true);
        // Check if assets_ids exist in the decoded data
        if (isset($detail['assets_ids']) && is_array($detail['assets_ids'])) {
            $assetIds = $detail['assets_ids'];
            // Fetch details from asset_categories table
            $ci->db->select('categoryId, categoryName, categoryCode');
            $ci->db->from('asset_categories');
            $ci->db->where_in('categoryId', $assetIds);
            $query = $ci->db->get();
            return $query->result_array();
        }
        return [];
    }
}

if (!function_exists('download_files_as_zip')) {
	/**
	 * Create a ZIP file from an array of file paths and prompt for download.
	 *
	 * @param array $filePaths Array of file paths to include in the ZIP.
	 * @param string $zipName Name of the ZIP file (without extension).
	 * @return void Outputs the ZIP file for download.
	 */
	function download_files_as_zip(array $filePaths, string $zipName = 'documents')
	{
		$CI =& get_instance();
		$CI->load->helper(['file', 'download']);

		// Ensure tmp directory exists
		$tmpDir = FCPATH . 'uploads/tmp/';
		if (!is_dir($tmpDir)) {
			mkdir($tmpDir, 0755, true);
		}

		// Create ZIP file
		$zipFileName = $zipName . '_' . time() . '.zip';
		$zipFilePath = $tmpDir . $zipFileName;

		$zip = new ZipArchive();
		if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
			foreach ($filePaths as $file) {
				$filePath = FCPATH . ltrim($file, './');
				if (file_exists($filePath)) {
					$zip->addFile($filePath, basename($filePath));
				}
			}
			$zip->close();

			// Serve the ZIP file for download
			force_download($zipFilePath, NULL);

			// Register shutdown function to delete the ZIP file after download
            register_shutdown_function(function() use ($zipFilePath) {
                if (file_exists($zipFilePath)) {
                    unlink($zipFilePath);  // Delete the file after download
                }
            });
			exit;
		} else {
			show_error('Failed to create ZIP file.', 500);
		}
	}
}

if (!function_exists('getApprovers')) {
	function getApprovers($employee_id, $request_type)
	{
		$CI =& get_instance();
		$CI->db->select('id, name, approval_types, approval_detail, is_applicable_to_all, employees_ids, approver, status, type');
		$CI->db->from('request_approval');
		$CI->db->where('approval_types', $request_type);
		$CI->db->where('status', 'active');
		$CI->db->group_start()
				->where('is_applicable_to_all', 'yes')
				->or_where('JSON_CONTAINS(employees_ids, \'["' . (string) $employee_id . '"]\')', null, false)
				->group_end();
		//$CI->db->limit(1);
		$query = $CI->db->get();
		$result = $query->row_array();
		$approverList = [];
		if($result){
			$approvers = json_decode($result['approver'], true);
			foreach ($approvers as $approver) {
				if ($approver['approver_type'] == 'employee') {
					$approver_id = $approver['approver_list'];
					$approverDetail = $CI->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.employee_pic, me.designation, me.department, me.status FROM master_employee me WHERE me.status = 'active' AND me.id='" . $approver_id . "'")->row();
					if ($approverDetail) {
						$approverList[] = $approverDetail;
					}
				} elseif ($approver['approver_type'] == 'designation') {
					$other_approver = getOtherApprover($employee_id);
					if ($approver['approver_list'] == 'Line Manager') {
						$lineManagerId = $other_approver['work_line_manager'];
						$approverDetail = $CI->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.employee_pic, me.designation, me.department, me.status FROM master_employee me WHERE me.status = 'active' AND me.id='" . $lineManagerId . "'")->row();
						if ($approverDetail) {
							$approverList[] = $approverDetail;
						}
					} elseif ($approver['approver_list'] == 'Department Head') {
						$departmentHeadId = $other_approver['department_head'];
						$approverDetail = $CI->db->query("SELECT me.id, me.emp_no, me.full_name, me.employee_arabic_name, me.mobile, me.email, me.employee_pic, me.designation, me.department, me.status FROM master_employee me WHERE me.status = 'active' AND me.id='" . $departmentHeadId . "'")->row();
						if ($approverDetail) {
							$approverList[] = $approverDetail;
						}
					}
				}
			}
		}
		return $approverList;
	}
}

if (!function_exists('getOtherApprover')) {
	function getOtherApprover($emp_id)
	{
		$CI =& get_instance();
		$CI->db->select('id, work_line_manager, department_head');
		$CI->db->from('master_employee');
		$CI->db->where('id', $emp_id);
		$CI->db->where('status', 'Active');
		$CI->db->limit(1);
		$query = $CI->db->get();
		$result = $query->row_array();
		return $result;
	}
}

if (!function_exists('getRequestApprover')) {
	function getRequestApprover($emp_id,$request_type)
	{
		$CI =& get_instance();
		//Get approvers
		$approvers_persons = [];
		$loan_approver = getApprovers($emp_id,$request_type);
		foreach ($loan_approver as $approver) {
			$approvers_persons[] = [
				'emp_id' => $approver->id,
				'emp_no' => $approver->emp_no,
				'name' => $approver->full_name,
				'arabic_name' => $approver->employee_arabic_name,
				'employee_pic' => $approver->employee_pic,
				'email' => $approver->email
			];
		}
		return $approvers_persons;
	}
}

// Get the list of all approvers for a specific request
if (!function_exists('getRequestedApprover')) {
	function getRequestedApprover($request_id)
	{
		$CI =& get_instance();
		$CI->db->select('ra.*, me.emp_no, me.full_name, me.employee_arabic_name, me.employee_pic');
		$CI->db->from('request_approvers ra');
		$CI->db->join('master_employee me', 'ra.approver_id = me.id', 'left');
		$CI->db->where('ra.request_id', $request_id);
		$query = $CI->db->get();
		$result = $query->result_array();
		return $result;
	}
}

// Get the pending approvers for a specific request
if (!function_exists('getPendingApprover')) {
	function getPendingApprover($request_id)
	{
		$CI =& get_instance();
		$CI->db->select('id, request_id, approver_id, approve_status, approver_email');
		$CI->db->from('request_approvers');
		$CI->db->where('request_id', $request_id);
		$CI->db->where('approve_status', 0);
		$query = $CI->db->get();
		$result = $query->row_array();
		return $result;
	}
}