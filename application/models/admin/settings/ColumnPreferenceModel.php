<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ColumnPreferenceModel extends CI_Model{

	private $table = 'user_column_preferences';

    // Get Column Preferences
    public function getUserPreferences($userId, $moduleName) {
        return $this->db->get_where($this->table, [
            'user_id' => $userId,
            'module_name' => $moduleName
        ])->row();
    }

    // Save or Update Preferences
    public function saveUserPreferences($userId, $moduleName, $availableColumns, $visibleColumns) {
        $data = [
            'user_id'          => $userId,
            'module_name'      => $moduleName,
            'available_columns'=> json_encode($availableColumns),
            'visible_columns'  => json_encode($visibleColumns),
            'updated_at'       => date('Y-m-d H:i:s')
        ];

        // Check if record exists
        $existingPreference = $this->getUserPreferences($userId, $moduleName);

        if ($existingPreference) {
            // Update existing record
            $this->db->where('id', $existingPreference->id)->update($this->table, $data);
        } else {
            // Insert new record
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert($this->table, $data);
        }
    }
	
}
