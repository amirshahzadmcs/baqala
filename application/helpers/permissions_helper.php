<?php

if (!function_exists('get_user_role')) {
    function get_user_role()
    {
        $CI = &get_instance();
        $CI->load->database();
        return $CI->session->userdata('role');
    }
}

if (!function_exists('role_permissions')) {
    function role_permissions($role_id)
    {
        $CI = &get_instance();
        $CI->load->database();
        $permissions = $CI->db->select('pc.short_code')->where('role_id', $role_id)
            ->join('permission_category pc', 'rp.perm_cat_id=pc.id', 'left')
            ->get('roles_permissions rp')->result_array();
        $menus = array_column($permissions, 'short_code');
        return $menus;
    }
}
if (!function_exists('permission_exists')) {
    function permission_exists($modules = [], $short_code)
    {
        if (get_user_role() == 1) {
            return true;
        }
        return in_array($short_code, $modules);
    }
}

if (!function_exists('check_action_permission')) {
    function check_action_permission($role_id, $module, $action)
    {
        $CI = &get_instance();
        $CI->load->database();

        if ($role_id == 1) {
            return true;
        }

        $permissions = $CI->db
            ->select('pc.short_code')
            ->from('roles_permissions rp')
            ->join('permission_category pc', 'rp.perm_cat_id = pc.id', 'left')
            ->where('rp.role_id', $role_id)
            ->where('pc.short_code', $module)
            ->where("JSON_CONTAINS(allowed_methods, '\"$action\"')", null, false)
            ->get()
            ->row();

        return $permissions ? true : false;
    }
}
