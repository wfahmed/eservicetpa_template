<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($title='سطح المكتب')
    {
        $data['title']=$title;
        $data['viewName']='admin/index';
        $data['withParam']='n';
        parent::index($data);
    }

    // function role
    public function role()
    {
        $data['title']='صلاحية الوصول';
        $data['viewName']='admin/role';

        $join_array = array(
            array(
                'table_name' => 'user userc',
                'condition' => 'user_role.created_by = userc.id'
            ),
            array(
                'table_name' => 'user useru',
                'condition' => 'user_role.updated_by = useru.id'
            ),
        );
        $datap = $this->Base_model->get_with_join('user_role.*,userc.name as cname,useru.name as update_name', 'user_role', $join_array, '  user_role.deleted_by  is  null ', 'user_role.id asc');

        $data['param']['roles'] =$datap;//$this->objectToArray($datap);

        $data['withParam']='y';

        parent::index($data);
    }

    // function add role
    public function addrole()
    {
        $this->form_validation->set_rules('role', 'Authority', 'required', [
            'required' => 'حقل الصلاحية واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'صلاحيات الوصول';
         /*   $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['role'] = $this->db->get('user_role')->result_array();*/

            $data['viewName']='admin/role';
            $data['withParam']='n';
        } else {
            $data = [
                'role' => $this->input->post('role'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            if($this->db->insert('user_role',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم إضافة صلاحية جديدة بنجاح</div>');
                redirect('admin/role');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشلت الاضافة</div>');
                redirect('admin/role');
            }

        }


        parent::index($data);
    }
    // function delete role
    public function  deleterole($id = null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_role',$data, ['id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('admin/role');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('admin/role');
        }
    }
    // function edit role
    public function editrole($id = null)
    {
            $data = [
                'role' => $this->input->post('role'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')

            ];

            if($this->db->update('user_role', $data, ['id' => $id])) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح!</div>');
                redirect('admin/role');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل!</div>');
                redirect('admin/role');
            }
    }

    // function delete role
    public function delete_access_role($id = null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        $role_id =$this->db->get_where('user_access_menu', ['id' => $id])->row_array()['role_id'];
        //['role_id'];
        if( $this->db->update('user_access_menu', $data, ['id' => $id])){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('admin/roleaccess/'.$role_id);
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('admin/role');
        }

    }
    
    // function role access
    public function roleaccess($role_id)
    {
        $data['title'] = 'القوائم الممنوحة  ';
        $data['param']['role'] = $this->db->get_where('user_role', ['id' => $role_id],['deleted_by'=> NULL])->row_array();
        $this->load->model('Menu_model', 'menu');
        $menus= $this->menu->getSubMenu();
        $data['param']['menusub'] =$menus;
        $join_array = array(
            array(
                'table_name' => 'user_access_menu',
                'condition' => 'user_menu.id = user_access_menu.menu_id'
            )
        );
        $usermenu = $this->Base_model->get_with_join('user_menu.*,user_access_menu.*', 'user_menu', $join_array, '  user_access_menu.role_id = ' .$role_id . '  and user_access_menu.deleted_by is  null ', 'user_menu.id asc');
        $data['param']['role_id'] =$role_id ;
        $data['param']['menu'] =$usermenu ;
        $data['viewName']='admin/role_access';
        $data['withParam']='y';
        parent::index($data);
    }

    public function addroleaccess()
    {
        $data['title'] = 'إضافة شاشات للصلاحية';
        $this->form_validation->set_rules('menu_id', 'menu_id', 'required', [ 'required' => 'حقل واجب الإدخال!' ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة شاشات للصلاحية';
            $this->load->model('Menu_model', 'menu');
            $menus= $this->menu->getSubMenu();
            $data['param']['menusub'] =$menus;
            $data['viewName']='admin/roleaccess';

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل في الاضافة!</div>');
            $data['withParam']='y';
            parent::index($data);
        } else {
            $submenu_id=$this->input->post('menu_id');
            $menu_id =$this->db->get_where('user_access_menu', ['submenu_id' => $submenu_id])->row_array()['menu_id'];
            $role_id =$this->input->post('role_id');
            $data = [
                'role_id' => $this->input->post('role_id'),
                'menu_id' =>$menu_id ,
                'submenu_id' => $submenu_id,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')

            ];

            $this->db->insert('user_access_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة بنجاح!</div>');
            redirect('admin/roleaccess/'.$role_id);
        }
    }

    // change access
    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
if($role_id!=null ){


    $data = [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ];

    $result = $this->db->get_where('user_access_menu', $data);

    if ($result->num_rows() < 1) {
        $this->db->insert('user_access_menu', $data);
    } else {
        $this->db->delete('user_access_menu', $data);
    }

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم تعديل صلاحية الوصول بنجاح!</div>');
}
    }

//def
    public function def($title='الثوابت والتعريفات')
    {
        $data['title']=$title;
        $data['viewName']='def/index';

        $datap = $this->Base_model->get_hierarchical_paths();
//var_dump($datap);die();
        $data['param']['rows'] =$this->objectToArray($datap);
        $data['withParam']='y';
        parent::index($data);
    }

    // function add def
    public function adddef()
    {
        $this->form_validation->set_rules('menu_id', 'menu_id', 'required', [
            'required' => 'حقل  واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('title', 'title', 'required', [
            'required' => 'حقل  واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة تعريف';
            $datap = $this->Base_model->get_hierarchical_paths();

            $data['param']['rows'] =$this->objectToArray($datap);
            $data['viewName']='admin/def';
            $data['withParam']='y';
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'parent_id' => $this->input->post('menu_id'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            if($this->db->insert('constants',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة بنجاح</div>');
                redirect('admin/def');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشلت الاضافة</div>');
                redirect('admin/def');
            }

        }


        parent::index($data);
    }

    // function edit def
    public function editdef($id = null,$title='سطح المكتب')
    {
        $this->form_validation->set_rules('menu_id', 'menu_id', 'required', [
            'required' => 'حقل الصلاحية واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('title', 'title', 'required', [
            'required' => 'حقل الصلاحية واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'تعديل تعريف';
            $datap = $this->Base_model->get_hierarchical_paths();

            $data['param']['rows'] =$this->objectToArray($datap);
            $data['param']['def_id'] =$id;

            $row= $this->db->get_where('constants', ['id' => $id])->row_array();

            $data['param']['row'] =$row;
            $data['viewName']='def/edit_def';
            $data['withParam']='y';
           // var_dump($data);
            parent::index($data);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'parent_id' => $this->input->post('menu_id'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            if($this->db->update('constants',$data, ['id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح</div>');
                redirect('admin/def');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('admin/def');
            }

        }



    }

    public function deletedef($id){
            $data = [
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d')
            ];
            if($this->db->update('constants',$data, ['id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم الحذف بنجاح</div>');
                redirect('admin/def');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الحذف</div>');
                redirect('admin/def');
            }

    }

    private function objectToArray($obj) {
    return json_decode(json_encode($obj), true);
}
}