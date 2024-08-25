<?php

function is_logged_in()
{
  $ci = get_instance();

  if (!$ci->session->userdata['user_name']) {
    redirect('auth');
  } else {
    $role_id = $ci->session->userdata['role_id'];
  //    var_dump($role_id);
    $menu = $ci->uri->segment(1);
   //   var_dump($menu);
    $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu,'deleted_by'=> NULL])->row_array();
   // var_dump($queryMenu);
       //

    $menu_id = $queryMenu['id'];
  //
    $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id,'deleted_by'=> NULL]);
//var_dump($userAccess);die();
    if ($userAccess->num_rows() < 1) {
      redirect('auth/blocked');
    }
  }
}

function is_weekends()
{
  date_default_timezone_set('Asia/Jakarta');
  $today = date('l', time());
  $weekends = ['Saturday', 'Sunday'];
  if (in_array($today, $weekends)) {
    return true;
  } else {
    return false;
  }
}
