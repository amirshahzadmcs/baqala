<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function categoryName($ids)
{
    $ci = &get_instance();
    $ci->db->select('categoryName');
    $ci->db->from('asset_categories');
    $ci->db->where_in('categoryId', $ids);
    $name = $ci->db->get()->result_array();
    return $name;
}
function getParentCategory($id)
{
    $path = parent_tree($id);
    return array_reverse($path);
}

function parent_tree($id = 0, &$path = []) // Pass $path by reference
{
    $ci = &get_instance();
    $category = $ci->db->select(['categoryId as id', 'parentCategoryId', 'categoryName'])->where('categoryId', $id)->get('asset_categories')->row();
    if ($category) {
        $path[] = $category->categoryName;
        if ($category->parentCategoryId > 0) {
            parent_tree($category->parentCategoryId, $path); // Pass $path by reference
        }
    }
    return $path;
}

function getCategories()
{
    $categories = $this->db->select(['categoryId as id', 'parentCategoryId', 'categoryName as text'])->get('asset_categories')->result_array();
    $catTree = $this->build_tree($categories);
    echo json_encode($catTree);
}

function build_tree($categories, $parent_id = 0)
{
    $tree = array();
    foreach ($categories as $category) {
        if ($category['parentCategoryId'] == $parent_id) {
            $category['children'] = $this->build_tree($categories, $category['id']);
            $tree[] = $category;
        }
    }
    return $tree;
}
