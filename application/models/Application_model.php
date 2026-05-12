<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application_model extends CI_Model{
	function __construct() {
		parent::__construct();
	}

	// Existing methods...
	public function save_application($data) {
        $this->db->insert('3pl_rider_applications', $data);
        return $this->db->insert_id();
    }
}
