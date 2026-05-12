<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teamleader
{
    protected $CI;

    public function __construct()
    {
        $CI = &get_instance();
        if (!$CI->session->userdata('session_id')) {
            $CI->session->set_userdata('session_id', md5(time() . rand() . time()));
        }
        if (!$CI->session->userdata('currency')) {
            $this->setCurrency($id = 1);
        }
    }

    public function login($username, $password)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $login_time = CURRENT_TIME;
        $CI = &get_instance();
        $dboy_query = $CI->db->query("SELECT * FROM master_employee WHERE emp_no = '" . $CI->db->escape_str($username) . "'");
        if ($dboy_query->num_rows() > 0) {
            $row = $dboy_query->row();
            $team_leader=$CI->db->get_where('hunger_team',['team_leader'=>$row->id])->row();
            if(!$team_leader){
                return 5;
            }
            $status = $row->status;
            $oldPassword = $row->password;
            if (password_verify($password, $oldPassword)) {
                if ($status == 'Active') {
                    $CI->session->set_userdata('emp_id', $row->id);
                    $CI->session->set_userdata('emp_name', $row->full_name);
                    $CI->session->set_userdata('emp_name_ar', $row->employee_arabic_name);
                    $this->logistic_id = $row->id;
                    $CI->db->query("UPDATE master_employee SET login_ip = '" . $ip . "' WHERE id = '" . (int)$this->logistic_id . "'");
                    return 1;
                } elseif ($status == 'Inactive') {
                    return 2;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function isLogged()
    {
        $CI = &get_instance();
        return (bool) $CI->session->userdata('emp_id');
    }

    public function logout()
    {
        $CI = &get_instance();
        $CI->session->unset_userdata('emp_id');
        $CI->session->unset_userdata('emp_name');
        $CI->session->unset_userdata('emp_name_ar');
        $this->emp_name = '';
    }

    public function getId()
    {
        $CI = &get_instance();
        $emp_id = $CI->session->userdata('emp_id');
        if (!empty($emp_id)) {
            return (int)$emp_id;
        } else {
            return null;
        }
    }

    public function addSession()
    {
        $CI = &get_instance();
        $CI->session->set_userdata('session_id', md5(time() . rand() . time()));
    }

    public function getSessionId()
    {
        $CI = &get_instance();
        $session_id = $CI->session->userdata('session_id');
        if (!empty($session_id)) {
            return $session_id;
        }
        return false;
    }

    public function getInfo()
    {
        $CI = &get_instance();
        $info = $CI->session->userdata('info');
        if (!empty($info)) {
            return $info;
        } else {
            return null;
        }
    }

    public function removeInfo()
    {
        $CI = &get_instance();
        $CI->session->unset_userdata('info');
    }

    public function checkPassword($old)
    {
        $CI = &get_instance();
        $customer_query = $CI->db->query("SELECT * FROM master_employee WHERE id = '" . $this->getId() . "' AND password = '" . $CI->db->escape_str($old) . "'");
        if ($customer_query->num_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function getToken($id)
    {
        $CI = &get_instance();
        $customer_query = $CI->db->query("SELECT * FROM master_employee WHERE id = '" . (int)$id . "'");
        foreach ($customer_query->result() as $row) {
            $this->token = $row->salt;
        }
        if ($this->token) {
            return $this->token;
        } else {
            return null;
        }
    }
}
