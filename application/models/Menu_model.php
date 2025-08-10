<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function getSubMenu()
    {
        $query =    "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id` where user_sub_menu.deleted_by is null and user_menu.display=1 and user_sub_menu.is_active = 1";

        return $this->db->query($query)->result_array();
    }
    public function getSubMenuByid($menu_id)
    {
        $query =    "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON `user_sub_menu`.`menu_id` = `user_menu`.`id` where user_sub_menu.deleted_by is null and menu_id=".$menu_id;

        return $this->db->query($query)->result_array();
    }
}