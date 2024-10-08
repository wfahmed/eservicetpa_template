<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // index view menu
    public function index($title='سطح المكتب')
    {
        $data['title'] = 'إدارة القوائم';
        $data['viewName']='menu/index';
              $join_array = array(
                  array(
                      'table_name' => 'user userc',
                      'condition' => 'user_menu.created_by = userc.id'
                  ),
                  array(
                      'table_name' => 'user useru',
                      'condition' => 'user_menu.updated_by = useru.id'
                  ),
              );
        $datap = $this->Base_model->get_with_join('user_menu.*,userc.full_name as cname,useru.full_name as update_name', 'user_menu', $join_array, '  user_menu.deleted_by  is  null ', 'user_menu.id asc');

        $data['param']['menus'] =$datap;
        $data['withParam']='y';
        parent::index($data);
    }

    // add menu
    public function addmenu($title='سطح المكتب')
    {

        $data['title'] = 'ادارة القائمة';

        $this->form_validation->set_rules('menu', 'Menu_EN', 'required', ['required' => 'حقل واجب الادخال!' ]);
        $this->form_validation->set_rules('ar_menu', 'ar_menu', 'required', ['required' => 'حقل واجب الادخال!' ]);
        $this->form_validation->set_rules('menu_icon', 'Menu_icon', 'required', ['required' => 'حقل واجب الادخال!' ]);
        $this->form_validation->set_rules('display', 'Display', 'required', ['required' => 'حقل واجب الادخال!' ]);
        if ($this->form_validation->run() == false) {

            $data['viewName']='menu/index';
            $data['withParam']='n';
            parent::index($data);
        } else {

             $data = [
                 'menu' => trim($this->input->post('menu')),
                 'ar_menu' => trim($this->input->post('ar_menu')),
                 'menu_icon' => trim($this->input->post('menu_icon')),
                 'display' => trim($this->input->post('display')),
                 'created_by' => $this->session->userdata('id'),
                 'created_at' => date('Y-m-d')
             ];

            if($this->db->insert('user_menu',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم إضافة قائمة جديدة بنجاح</div>');
                redirect('menu');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشلت الاضافة</div>');
                redirect('menu');
            }
        }
    }

    // edit menu
    public function editmenu($id = null,$title='سطح المكتب')
    {
        $data['title'] = 'تعديل القائمة';
        $this->form_validation->set_rules('menu', 'Menu_EN', 'required', ['required' => 'حقل واجب الادخال!' ]);
        $this->form_validation->set_rules('ar_menu', 'ar_menu', 'required', ['required' => 'حقل واجب الادخال!' ]);
        $this->form_validation->set_rules('menu_icon', 'Menu_icon', 'required', ['required' => 'حقل واجب الادخال!' ]);
       // $this->form_validation->set_rules('display', 'Display', 'required', ['required' => 'حقل واجب الادخال!' ]);

       if($this->input->post('display'))
        $display=$this->input->post('display');
       else
           $display=0;
        if ($this->form_validation->run() == false) {
            $data['viewName']='menu/edit_menu';
            $data['withParam']='y';
            $join_array = array(
                array(
                    'table_name' => 'user userc',
                    'condition' => 'user_menu.created_by = userc.id'
                ),
                array(
                    'table_name' => 'user useru',
                    'condition' => 'user_menu.updated_by = useru.id'
                ),
            );
            $datap = $this->Base_model->get_with_join('user_menu.*,userc.name as cname,useru.name as update_name', 'user_menu', $join_array, '  user_menu.deleted_by  is  null  and user_menu.id='. $id, 'user_menu.id asc');

            $data['param']['menu'] =$datap[0];
           // var_dump((array)json_encode($datap[0]));die();
            parent::index($data);
        } else {

            $data = [
                'menu' => trim($this->input->post('menu')),
                'ar_menu' => trim($this->input->post('ar_menu')),
                'menu_icon' => trim($this->input->post('menu_icon')),
                'display' => $display,
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];

            if($this->db->update('user_menu',$data, ['id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم تعديل القائمة  بنجاح</div>');
                redirect('menu');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('menu');
            }
        }

    }

    // delete menu
    public function deletemenu($id = null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_menu',$data, ['id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('menu');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('menu');
        }
    }

    // index view sub menu
    public function submenu($menu_id = null,$title='سطح المكتب')
    {
        $data['title'] = 'إدارة القوائم الفرعية';
        $data['viewName']='menu/submenu';
        $menus=$this->db->get_where('user_menu', ['deleted_by'=> NULL])->result_array();
        if($menu_id!= null){
            $this->load->model('Menu_model', 'menu');
            $datap = $this->menu->getSubMenuByid($menu_id);
            $data['param']['gmenu_id'] =$menu_id;
        }else{

            $this->load->model('Menu_model', 'menu');
            $datap = $this->menu->getSubMenu();
        }


        $data['param']['submenu'] =$datap;
        $data['param']['menus'] =$menus;
        $data['withParam']='y';
        parent::index($data);
    }

    // add sub menu
    public function addsubmenu()
    {
        //var_dump($_POST);exit();
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->load->model('Menu_model', 'menu');
        $data['submenu'] = $this->menu->getSubMenu();

        $this->form_validation->set_rules('title', 'Submenu', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('ar_title', 'ar_title', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('menu_id', 'Menu', 'required', [
            'required' => 'يجب الاختيار!'
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
//var_dump($this->form_validation->run() );die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة القوائم الفرعية';
            $menus=$this->db->get_where('user_menu', ['deleted_by'=> NULL])->result_array();
            $data['param']['menus'] =$menus;
            $data['viewName']='menu/submenu';

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل في الاضافة!</div>');
            $data['withParam']='y';
            parent::index($data);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'ar_title' => $this->input->post('ar_title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')

            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة بنجاح!</div>');
            redirect('menu/submenu');
        }
    }

    // edit sub menu
    public function editsubmenu($id = null,$title='سطح المكتب')
    {
        $this->form_validation->set_rules('title', 'Submenu', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('ar_title', 'ar_title', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('menu_id', 'Menu', 'required', [
            'required' => 'يجب الاختيار!'
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required', [
            'required' => 'حقل واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->model('Menu_model', 'menu');
            $data['title'] = 'إدارة القوائم الفرعية';
            $menus=$this->db->get_where('user_menu', ['deleted_by'=> NULL])->result_array();
            $datap= $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();

            $data['param']['submenu'] =$datap;
            $data['param']['menus'] =$menus;
            $data['viewName']='menu/edit_submenu';

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل تعديل البيانات!</div>');
            $data['withParam']='y';
            parent::index($data);
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'title' => $this->input->post('title'),
                'ar_title' => $this->input->post('ar_title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            if($this->db->update('user_sub_menu',$data, ['id' => $id])){
                $data = [
                    'menu_id' => $this->input->post('menu_id'),
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                $this->db->update('user_access_menu',$data, ['submenu_id' => $id]);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم تعديل القائمة  بنجاح</div>');
                redirect('menu/submenu');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('menu/submenu');
            }

        }
    }

    // delete sub menu
    public function deletesubmenu($id = null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_sub_menu',$data, ['id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('menu/submenu');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('menu/submenu');
        }
    }

    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
}