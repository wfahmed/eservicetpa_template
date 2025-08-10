<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class HierarchyLib
{
    protected $CI;

    public function __construct() {
        // Get the CodeIgniter instance
        $this->CI =& get_instance();
    }

// Recursive function to build hierarchy
    public function buildHierarchy($elements) {
        $tree = [];

        foreach ($elements as $element) {
            // Fetch children for the current element
            $children = $this->getChildren($element['id']);

            // If children exist, add them to the current element
            if (!empty($children)) {
                $element['children'] = $this->buildHierarchy($children);
            }

            // Add the element to the tree
            $tree[] = $element;
        }

        return $tree;
    }
    public function getChildren($parentId) {
        // Fetch all elements where parent_id equals the given parentId
        return $this->CI->db->get_where('constants', ['parent_id' => $parentId])->result_array();
    }
}