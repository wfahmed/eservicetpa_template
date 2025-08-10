<?php

function is_logged_in()
{
    $ci = get_instance();
    // var_dump($ci->session->userdata['user_name']);die();
    //  $user_name = $ci->session->userdata('user_name'); // Fetch the session data safely

    if (!$ci->session->has_userdata('user_name')) {
       // var_dump('not logged in');
        redirect('auth'); // Redirect to login or auth page
    }else {
        $role_id =$ci->session->userdata['role_id'] ;

        $menu = $ci->uri->segment(1);
        $segTemp=$ci->uri->segment(2);

        if(isset($segTemp))
            $menu=$menu.'/'.$segTemp;

        $querysubMenu = $ci->db->get_where('user_sub_menu', ['url' => $menu,'deleted_by'=> NULL])->row_array();

        $menu_id = $querysubMenu['menu_id'];

        $menu_subid = $querysubMenu['id'];
        ;
        if($role_id==2){
            $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id,'deleted_by'=> NULL]);
        }else
            $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id, 'submenu_id' =>$menu_subid,'deleted_by'=> NULL]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
