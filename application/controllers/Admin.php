<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($title='سطح المكتب')
    {
        $join_array = array(
            array(
                'table_name' => 'constants pms',
                'condition' => 'user.relation_type_id  = pms.id '
            ),
            array(
                'table_name' => 'user father',
                'condition' => 'user.parent_user_id  = father.id '
            ),
        );
        $dataChild= $this->Base_model->get_with_join('user.*,user.id as uid,pms.title as relation_type,father.full_name as father_name',
            'user', $join_array, '  user.deleted_by  is  null and father.deleted_by  is  null and user.age< 19 and father.user_status_id in(5,6,18) and father.relation_type_id = '. FAMILY_HEADER,
            'user.id asc');
        if (is_array($dataChild)) {
            $user_child_orphan = count($dataChild);
        } else {
            $user_child_orphan = 0; // Default to 0 if $dataChild is not an array
        }
        /*_orphan*/
          $where=' deleted_by is null and user_status_id in(5,6,18) and relation_type_id = '. FAMILY_HEADER;
        $user_family_orphan = $this->Base_model->count_records('user', $where);
        /******child*******/
        $where=' deleted_by is null and age <  '. CHILD_AGE;
        $user_child = $this->Base_model->count_records('user', $where);
        /**family*/
        $where=' deleted_by is null and relation_type_id = '. FAMILY_HEADER;
        $user_family = $this->Base_model->count_records('user', $where);
       //data
        $where=' role_id=1 and deleted_by is null';
        $user_has_access = $this->Base_model->count_records('user', $where);
        $data['user_has_access']=$user_has_access  ;
        /*************/
        $where=' deleted_by is null';
        $user_citezn = $this->Base_model->count_records('user', $where);
        $data['user_citezn']=$user_citezn;
        /**************/
        $where=' deleted_by is null';
        $projects = $this->Base_model->count_records('project_master', $where);
        $data['projects']=$projects;
        /***supplier***************/
        $where=' deleted_by is null';
        $supplier = $this->Base_model->count_records('supplier', $where);
        $data['supplier']=$supplier;
        // view
        $data['param']['user_child']=$user_child;
        $data['param']['user_child_orphan']=$user_child_orphan;
        $data['param']['user_family_orphan']=$user_family_orphan;
        $data['param']['user_has_access']=$user_has_access;
        $data['param']['user_citezn']=$user_citezn;
        $data['param']['user_family']=$user_family;
        $data['param']['projects']=$projects;
        $data['param']['supplier']=$supplier;
        $data['title']=$title;
        $data['viewName']='admin/index';
        $data['withParam']='n';

        $data['param']['js_file'][0] ='\assets\template\js\chart.js';
        $data['param']['js_file'][1] ='\assets\custom\dashboard.js';
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
        $datap = $this->Base_model->get_with_join('user_role.*,userc.full_name as cname,useru.full_name as update_name', 'user_role', $join_array, '  user_role.deleted_by  is  null ', 'user_role.id asc');

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
        $this->form_validation->set_rules('role', 'Authority', 'required');

        if ($this->form_validation->run() == false) {
            $data['role'] = $this->db->get_where('user_role', ['id' => $id])->row_array();
            $data['title'] = 'تعديل  صلاحيات الوصول';
            $data['viewName']='admin/edit_role';
            $data['withParam']='y';
            $data['param']=$data;
            //var_dump($data['row']);
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
        } else {
        $data = [
            'role' => $this->input->post('role'),
            'updated_by' => $this->session->userdata('id'),
            'updated_at' => date('Y-m-d')

        ];

        if ($this->db->update('user_role', $data, ['id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح!</div>');
            redirect('admin/role');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل!</div>');
            redirect('admin/role');
        }
    }
        parent::index($data);
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
                'table_name' => 'user_menu',
                'condition' => 'user_menu.id = user_access_menu.menu_id'
            ),
            array(
                'table_name' => 'user_sub_menu',
                'condition' => 'user_sub_menu.id = user_access_menu.submenu_id'
            ),
            array(
                'table_name' => 'user_role',
                'condition' => 'user_role.id = user_access_menu.role_id'
            ),
        );
        $usermenu = $this->Base_model->get_with_join('user_menu.*,user_access_menu.*,user_sub_menu.ar_title as sub_title', 'user_access_menu', $join_array, '  user_access_menu.role_id = ' .$role_id . '  and user_access_menu.deleted_by is  null ', 'user_menu.id asc');
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
         //   var_dump($submenu_id);
            $menu_id =$this->db->get_where('user_sub_menu', ['id' => $submenu_id])->row_array()['menu_id'];
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
        $this->form_validation->set_rules('parent_id', 'parent_id', 'required', [
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
                'parent_id' => $this->input->post('parent_id'),
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
        $this->form_validation->set_rules('parent_id', 'parent_id', 'required', [
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
                'parent_id' => $this->input->post('parent_id'),
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

    public function get_statisc_support(){
        // Define an empty JSON array for labels
        $labels = [];
        // Define an empty JSON array for data
        $data = [];
        $supporting_type =$this->db->get_where('constants', ['parent_id' => RELIEF,'deleted_by' =>NULL])->result_array();
        foreach ($supporting_type as $item) {
            $labels[] = $item['title']; // Push label to labels array
            $project_supply =$this->db->get_where('project_supply', ['deleted_by' =>NULL,'support_fk'=>$item['id']])->result_array();
            $data[] = count($project_supply);   // Push value to data array
        }
        // Create a response array
        $response = [
            'labels' => $labels,
            'data' => $data
        ];
// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
}

    public function get_statisc_supplier(){
        // Define an empty JSON array for labels
        $labels = [];
        // Define an empty JSON array for data
        $data = [];
        $suppliers =$this->db->get_where('supplier', ['deleted_by' =>NULL])->result_array();
        foreach ($suppliers as $item) {
            $labels[] = $item['supplier_name']; // Push label to labels array
            $this->db->select_sum('supplier_remain_mony', 'total_amount');
            $this->db->from('project_supply');
            $this->db->where(['deleted_by' =>NULL,'supplier_fk'=>$item['supplier_id']]);
            $query = $this->db->get();
            $res= $query->row()->total_amount;
            $data[] = $res;   // Push value to data array
        }
        // Create a response array
        $response = [
            'labels' => $labels,
            'data' => $data
        ];
// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function get_statisc_association(){
        // Define an empty JSON array for labels
        $labels = [];
        // Define an empty JSON array for data
        $data = [];
        $supporting =$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES,'deleted_by' =>NULL])->result_array();

        foreach ($supporting as $item) {
            $labels[] = $item['title']; // Push label to labels array
            $this->db->select_sum('approved_amount', 'total_amount');
            $this->db->from('project_master');
            $this->db->where(['deleted_by' =>NULL,'support_id'=>$item['id']]);
            $query = $this->db->get();
            $res= $query->row()->total_amount;
            $data[] = $res;   // Push value to data array
        }
        // Create a response array
        $response = [
            'labels' => $labels,
            'data' => $data
        ];
// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function objectToArray($obj) {
    return json_decode(json_encode($obj), true);
}
}