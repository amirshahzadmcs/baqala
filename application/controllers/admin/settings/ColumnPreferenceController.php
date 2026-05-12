<?php defined('BASEPATH') or exit('No direct script access allowed');

class ColumnPreferenceController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->admin->isLogged()) {
			$this->load->model('admin/settings/ColumnPreferenceModel');
			$this->load->library('form_validation');
			$this->load->helper('common_helper');
			$this->load->library('user_agent');
			$this->ip_address = $_SERVER['REMOTE_ADDR'];
			$this->datetime = date("Y-m-d H:i:s");
		} else {
			redirect('admin/common/login');
		}
	}

	public function get_column_form()
	{
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed');
		}

		if (!$this->admin->isLogged()) {
			echo json_encode([
				'type' => 'error',
				'message' => 'Session expired. Please login again.'
			]);
			return;
		}

		$userId = $this->admin->getLoginEmpId();
		$moduleName = $this->input->get('request_type');

		if (empty($moduleName)) {
			echo json_encode([
				'type' => 'error',
				'message' => 'Invalid request type.'
			]);
			return;
		}

		$preferences = $this->ColumnPreferenceModel->getUserPreferences($userId, $moduleName);

		// 🛠️ Handle case when no preferences are found
		if (!$preferences) {
			$data['availableColumns'] = [];
			$data['visibleColumns'] = [];
		} else {
			$data['availableColumns'] = json_decode($preferences->available_columns ?? '[]', true);
			$data['visibleColumns'] = json_decode($preferences->visible_columns ?? '[]', true);
		}

		//dd($data);
		if($moduleName === 'hunger_monthly_summary'){
			$html = $this->load->view('admin/logistic-management/aggregators/hunger/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'hunger_sales_data') {
			$html = $this->load->view('admin/logistic-management/aggregators/hunger_sales/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'hunger_sales_invoice') {
			$html = $this->load->view('admin/logistic-management/aggregators/hunger_invoice/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'keeta_monthly_summary') {
			$html = $this->load->view('admin/logistic-management/aggregators/keeta/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'keeta_sales_data') {
			$html = $this->load->view('admin/logistic-management/aggregators/keeta_sales/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'keeta_sales_invoice') {
			$html = $this->load->view('admin/logistic-management/aggregators/keeta_invoice/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'jahez_monthly_summary') {
			$html = $this->load->view('admin/logistic-management/aggregators/jahez/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'jahez_sales_data') {
			$html = $this->load->view('admin/logistic-management/aggregators/jahez_sales/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'jahez_sales_invoice') {
			$html = $this->load->view('admin/logistic-management/aggregators/jahez_invoice/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'master_employees_data') {
			$html = $this->load->view('admin/hr-module/employees/components/column-preference', $data, TRUE);
		}elseif ($moduleName === 'facilities_properties') {
			$html = $this->load->view('admin/facility-management/property/components/column-preference', $data, TRUE);
		}elseif ($moduleName === 'noon_order_summary') {
			$html = $this->load->view('admin/logistic-management/noon/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'noon_daily_penelty') {
			$html = $this->load->view('admin/logistic-management/noon/panelty/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'noon_cod_summary') {
			$html = $this->load->view('admin/logistic-management/noon/cod/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'jahez_order_summary') {
			$html = $this->load->view('admin/logistic-management/new_jahez/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'threepl_rider_applications') {
			$html = $this->load->view('admin/3pl/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'interview_forms') {
			$html = $this->load->view('admin/hr-module/interview/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'vehicles') {
			$html = $this->load->view('admin/logistic-masters/master-vehicle/components/column-preferences', $data, TRUE);
		}elseif ($moduleName === 'jahez_rent') {
			$html = $this->load->view('admin/logistic-management/jahez_rent/components/column-preferences', $data, TRUE);
		}

		echo json_encode([
			'type' => 'success',
			'message' => 'Column preferences successfully fetched.',
			'data' => $html
		]);
	}

    // Save Preferences
    public function savePreferences() {
		if (!$this->input->is_ajax_request()) {
			show_error('No direct script access allowed');
		}
	
		$userId = $this->admin->getLoginEmpId();
		$moduleName = $this->input->post('module_name');
		$availableColumns = $this->input->post('available_columns');
		$visibleColumns = $this->input->post('visible_columns');
	
		// Validation
		if (empty($availableColumns) || empty($visibleColumns)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Both available and visible columns are required.'
			]);
			return;
		}
	
		if (!is_array($availableColumns) || !is_array($visibleColumns)) {
			echo json_encode([
				'status' => 'error',
				'message' => 'Invalid data format.'
			]);
			return;
		}
	
		// Data Preparation
		$data = [
			'user_id' => $userId,
			'module_name' => $moduleName,
			'available_columns' => json_encode($availableColumns),
			'visible_columns' => json_encode($visibleColumns),
			'updated_at' => date('Y-m-d H:i:s')
		];
	
		// Check if record exists (Insert or Update)
		$existingRecord = $this->db->get_where('user_column_preferences', [
			'user_id' => $userId,
			'module_name' => $moduleName
		])->row();
	
		if ($existingRecord) {
			// Update record
			$this->db->where('id', $existingRecord->id);
			$saveStatus = $this->db->update('user_column_preferences', $data);
		} else {
			// Insert new record
			$data['created_at'] = date('Y-m-d H:i:s');
			$saveStatus = $this->db->insert('user_column_preferences', $data);
		}
	
		if ($saveStatus) {
			echo json_encode([
				'status' => 'success',
				'message' => 'Preferences saved successfully!'
			]);
		} else {
			echo json_encode([
				'status' => 'error',
				'message' => 'Failed to save preferences. Please try again.'
			]);
		}
	}	
	
}
