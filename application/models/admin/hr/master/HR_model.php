<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HR_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    /* ================= SUMMARY ================= */
    public function employee_summary()
    {
        return $this->db->select("
            COUNT(id) total,
            SUM(status = 'Active') active
        ")->get('master_employee')->row();
    }

    /* ================= NATIONALITY ================= */
    public function nationality_summary()
    {
        return $this->db->select("
            SUM(nationality = '6') saudi,
            SUM(nationality != '6') non_saudi
        ")->where('status','Active')
          ->get('master_employee')->row();
    }

    /* ================= GENDER ================= */
    public function gender_summary()
    {
        return $this->db->select("
            SUM(gender='male') male,
            SUM(gender='female') female
        ")->where('status','Active')
          ->get('master_employee')->row();
    }

    /* ================= Operational Staff ================= */
    public function operational_staff_summary()
    {
        return $this->db
            ->select("
                COUNT(e.id) AS total,
                SUM(e.status = 'Active') AS active
            ", false)
            ->from('master_employee e')
            ->where_not_in('e.designation', [3, 18])
            ->get()
            ->row();
    }

    /* ================= VEHICLE ================= */
    public function vehicle_summary()
    {
        return $this->db->select("
            SUM(designation='3') bike,
            SUM(designation='18') car
        ")->where('status','Active')
          ->get('master_employee')->row();
    }

    /* ================= DEPARTMENT ================= */
    public function employees_by_department()
    {
        return $this->db
            ->select('d.name department, COUNT(e.id) total')
            ->from('master_employee e')
            ->join('master_department d','d.id=e.department','left')
            ->where('e.status','Active')
            ->where('e.department IS NOT NULL', null, false)
            ->group_by('d.id')
            ->order_by('total','DESC')
            ->get()->result();
    }

    /* ================= CITY ================= */
    public function riders_by_city()
    {
        return $this->db
            ->select('
                ml.location_name AS city,
                COUNT(e.id) AS total
            ')
            ->from('master_employee e')
            ->join('master_location ml', 'ml.id = e.work_location', 'left')
            ->where('e.status', 'Active')
            ->where_in('e.designation', [3, 18])
            ->group_by('e.work_location')
            ->order_by('total', 'DESC')
            ->get()
            ->result();
    }

}
