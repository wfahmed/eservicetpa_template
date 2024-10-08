<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Cv extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($id=null,$tab_id='1',$title='السيرة الذاتية')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $data['viewName']='cv/index';
        $datap= $this->db->get_where('user', ['id' => $id])->row_array();
        $data['param']['user_row'] =$datap;
        $data['title'] = 'السيرة الذاتية لـ '.$datap['full_name'];

        $data['param']['tab_id'] =$tab_id;
        $data['param']['id'] =$id;
        $data['param']['js_file'][0] ='\assets\custom\tab_manage.js';
        $data['param']['js_file'][1] ='\assets\custom\cv.js';
        $data['withParam'] = 'y';
        parent::index($data);
    }

    public function load_tab($tab_id,$id) {
        $datap= $this->db->get_where('user', ['id' => $id])->row_array();
        $data['param']['user_row'] =$datap;
        switch($tab_id){
            case 1:
                $data['param']['DISABILITY_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DISABILITY_STATUS])->result_array();
                $data['param']['HEALTH'] = (array)$this->db->get_where('constants', ['parent_id' => HEALTH])->result_array();
                $join_array = array(
                    array(
                        'table_name' => 'constants conD',
                        'condition' => 'user_health.disability_type_id   = conD.id '
                    ),
                    array(
                        'table_name' => 'constants con',
                        'condition' => 'user_health.health_status_id   = con.id '
                    ),
                    array(
                        'table_name' => 'user_attach attach',
                        'condition' => 'user_health.health_id   = attach.attach_table_id'
                    ),
                    array(
                        'table_name' => 'constants conT',
                        'condition' => 'attach.attach_type_id = conT.id'
                    ),
                );
                $dataHealth= $this->Base_model->get_with_join('user_health.*,attach.*,con.title as health_status,conD.title as disability_type, conT.title as attach_type',
                    'user_health', $join_array, '  user_health.deleted_by  is  null and user_health.user_id ='.$id,
                    'user_health.health_id asc');
              //  var_dump($dataHealth);
                $data['param']['tab_id'] =$tab_id;
                $data['param']['health'] =$dataHealth;
                break;
            case 2:

                $itemsResult= (array)$this->db->get_where('constants', ['parent_id' => EDUCATION])->result_array();
                // Initialize arrays for categories and items
                foreach ($itemsResult as $row) {
                    $categoryId = $row['id']; // Category ID
                    $categoryName = $row['title']; // Category Name
                    // Initialize category in the array
                    $itemsByCategory[$categoryId] = [
                        'title' => $categoryName,
                        'items' => [] // Array to hold items for this category
                    ];

                    // Fetch items belonging to this category
                    $items = $this->db->get_where('constants', ['parent_id' => $categoryId])->result_array();

                    // Add items to the respective category
                    foreach ($items as $item) {
                        $itemsByCategory[$categoryId]['items'][] = [
                            'id' => $item['id'],
                            'title' => $item['title']
                        ];
                    }
                }
                $data['param']['EDUCATION'] =$itemsByCategory;
                $join_array = array(
                    array(
                        'table_name' => 'constants conD',
                        'condition' => 'user_education.edu_level_id   = conD.id '
                    ),
                    array(
                        'table_name' => 'constants con',
                        'condition' => 'user_education.edu_stage_id   = con.id '
                    ),
                    array(
                        'table_name' => 'user_attach attach',
                        'condition' => 'user_education.edu_id   = attach.attach_table_id'
                    ),
                    array(
                        'table_name' => 'constants conT',
                        'condition' => 'attach.attach_type_id = conT.id'
                    ),
                );
                $dataEdu= $this->Base_model->get_with_join('user_education.*,attach.*,con.title as edu_stage,conD.title as edu_level, conT.title as attach_type',
                    'user_education', $join_array, '  user_education.deleted_by  is  null and user_education.user_id ='.$id,
                    'user_education.edu_id asc');
                $data['param']['tab_id'] =$tab_id;
                $data['param']['edu'] =$dataEdu;
                break;
            case 3:

                $data['param']['HOBBIES'] = (array)$this->db->get_where('constants', ['parent_id' => HOBBIES])->result_array();
                $join_array = array(
                    array(
                        'table_name' => 'constants conH',
                        'condition' => 'user_hobbies.hobby_id   = conH.id '
                    ),
                );
                $dataHob= $this->Base_model->get_with_join('user_hobbies.*,conH.title as hobby,',
                    'user_hobbies', $join_array, '  user_hobbies.deleted_by  is  null and user_hobbies.user_id ='.$id,
                    'user_hobbies.hob_id asc');
                $data['param']['tab_id'] =$tab_id;
                $data['param']['hob'] =$dataHob;
                break;
            case 4:

                $data['param']['NEED'] = (array)$this->db->get_where('constants', ['parent_id' => NEED])->result_array();
                $join_array = array(
                    array(
                        'table_name' => 'constants conH',
                        'condition' => 'user_need.need_type_id   = conH.id '
                    ),
                    array(
                        'table_name' => 'constants conT',
                        'condition' => 'user_need.needu_sub_type_id   = conT.id '
                    ),
                );
                $dataNeed= $this->Base_model->get_with_join('user_need.*,conH.title as need_type,conT.title as needu_sub_type',
                    'user_need', $join_array, '  user_need.deleted_by  is  null and user_need.user_id ='.$id,
                    'user_need.need_id asc');
                $data['param']['tab_id'] =$tab_id;
                $data['param']['need'] =$dataNeed;
                break;
        }

        $this->load->view('cv/tab'.$tab_id.'_view',$data);
    }
    /**
     *get select
     */
    public function get_select()
    {
        $id = $this->input->post('need_type_id');

        $dataRes = (array)$this->db->get_where('constants', ['parent_id' => $id])->result_array();

// If you expect only one result, access the first element of the array
        $response = isset($dataRes) ? $dataRes : null;

// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     *add need
     */
    public function add_need()
    {
        $value = $this->input->post('user_id');
        $user_id = isset($value) ? trim($value) : '';

        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('need_type_id', 'need_type_id ID', 'required');
        $this->form_validation->set_rules('needu_sub_type_id[]', 'needu_sub_type_id  ', 'required');

        if ($this->form_validation->run()) {
            $need_type_id=$_POST['need_type_id'];
            if (isset($_POST['needu_sub_type_id'])) {
                $selected_hobbies = $_POST['needu_sub_type_id'];
                $need_details = $_POST['need_details'];
                // $selected_hobbies is now an array of the selected hobby IDs

                foreach ($selected_hobbies as $row) {
                    $data = [
                        'user_id' => $user_id,
                        'need_type_id' => $need_type_id,
                        'needu_sub_type_id' => $row,
                        'need_details' => $need_details,
                        'created_by' => $this->session->userdata('id'),
                        'created_at' => date('Y-m-d')
                    ];
                    $res = $this->db->insert('user_need', $data);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                redirect('cv/index/' . $user_id . '/4');

            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                redirect('cv/index/' . $user_id . '/4');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            تحقق من الحقول</div>');
            redirect('cv/index/' . $user_id . '/4');
        }
    }

    /**
     *delete need
     */
    public function delete_need($id,$user_id)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_need',$data, ['need_id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('cv/index/' . $user_id . '/4');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الحذف</div>');
            redirect('cv/index/' . $user_id . '/4');
        }
    }
    /**
     *add hobby
     */
    public function add_hob()
    {
        $value = $this->input->post('user_id');
        $user_id = isset($value) ? trim($value) : '';

        $this->form_validation->set_rules('user_id', 'User ID', 'required');
        $this->form_validation->set_rules('hobby_id[]', 'Hob  ', 'required');

        if ($this->form_validation->run()) {
            $hobby_id = $this->input->post('hobby_id');
            if (isset($_POST['hobby_id'])) {
                $selected_hobbies = $_POST['hobby_id'];
                // $selected_hobbies is now an array of the selected hobby IDs

                foreach ($selected_hobbies as $row) {
                    $data = [
                        'user_id' => $user_id,
                        'hobby_id' => $row,
                        'created_by' => $this->session->userdata('id'),
                        'created_at' => date('Y-m-d')
                    ];
                    $res = $this->db->insert('user_hobbies', $data);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                redirect('cv/index/' . $user_id . '/3');

            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                redirect('cv/index/' . $user_id . '/3');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            تحقق من الحقول</div>');
            redirect('cv/index/' . $user_id . '/3');
        }
    }
    /**
     *delete hobby
     */
    public function delete_hob($id,$user_id)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_hobbies',$data, ['hob_id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            redirect('cv/index/' . $user_id . '/3');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الحذف</div>');
            redirect('cv/index/' . $user_id . '/3');
        }
    }

    /**
     * info detail edu
     * */
    public function detail_edu()
    {
        $edu_id = $this->input->post('edu_id');

        $join_array = array(
            array(
                'table_name' => 'constants conD',
                'condition' => 'user_education.edu_level_id   = conD.id '
            ),
            array(
                'table_name' => 'constants con',
                'condition' => 'user_education.edu_stage_id   = con.id '
            ),
            array(
                'table_name' => 'user_attach attach',
                'condition' => 'user_education.edu_id   = attach.attach_table_id'
            ),
            array(
                'table_name' => 'constants conT',
                'condition' => 'attach.attach_type_id = conT.id'
            ),
        );
        $dataEdu= $this->Base_model->get_with_join('user_education.*,attach.*,con.title as edu_stage,user_education.user_id as usid,conD.title as edu_level, conT.title as attach_type',
            'user_education', $join_array, '  user_education.deleted_by  is  null and user_education.edu_id ='.$edu_id,
            'user_education.edu_id asc');

// If you expect only one result, access the first element of the array
        $response = isset($dataEdu[0]) ? $dataEdu[0] : null;

// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    /**
     *add edu
     */
    public function add_edu()
    {
        $user_id = $this->input->post('user_id');
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('edu_stage_id', 'Stage Type ID', 'required|numeric');
        $this->form_validation->set_rules('edu_level_id', 'Level Status ID', 'required|numeric');
//var_dump($_POST);die();
        if ($this->form_validation->run()) {

            $edu_level_id = $this->input->post('edu_level_id');
            $edu_stage_id = $this->input->post('edu_stage_id');
            $edu_details= $this->input->post('edu_details');

            /****files***/
            // upload file
            $upload_image = $_FILES['edu_file']['name'];
            $file = 'no';
            if ($upload_image) {
                $attach_path = '/assets/uploads/attach/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '6000';
                $config['upload_path'] = './assets/uploads/attach/';

                $this->load->library('upload', $config);


                if ($this->upload->do_upload('edu_file')) {
                    $upload_data = $this->upload->data();
                    // Generate a new file name with a date and serial number
                    $new_file_name = date('YmdHis') . '_' . uniqid() . $upload_data['file_ext'];
                    // Rename the uploaded file
                    rename($upload_data['full_path'], $upload_data['file_path'] . $new_file_name);
                    // Set the new file name
                    $file = $new_file_name;
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $data = [
                'user_id' => $user_id,
                'edu_stage_id' => $edu_stage_id,
                'edu_level_id' => $edu_level_id,
                'edu_details' => $edu_details,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            //  var_dump($data);
            if ($this->db->insert('user_education', $data)) {
                $insert_id = $this->db->insert_id();

                if ($file != 'no') {
                    $data = [
                        'user_id' => $user_id,
                        'attach_type_id' => EDU_REPORT,
                        'attach_path' => $attach_path . $file,
                        'attach_name' => $file,
                        'attach_table_id' => $insert_id,
                        'attach_table_name' => 'user_education',
                        'created_by' => $this->session->userdata('id'),
                        'created_at' => date('Y-m-d')
                    ];
                    $this->db->insert('user_attach', $data);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                redirect('cv/index/'.$user_id .'/2');

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                redirect('cv/index/' . $user_id . '/2');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل المتطلبات والتحقق</div>');
            redirect('cv/index/' . $user_id . '/2');
        }
    }

    /**
     * delete edu
     */
    public function delete_edu($id,$user_id=null,$tab_id=1)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_education',$data, ['edu_id' => $id])){
            $data = [
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d')
            ];
            $this->db->update('user_attach',$data, ['attach_table_id' => $id,'attach_table_name'=>'user_education']);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            switch($tab_id){
                case 1:
                    redirect('cv/index/'.$user_id.'/2');
                    break;
                default:
                    redirect('member/family_show/');
                    break;
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('member/family_show/');
        }

    }
    /**
     *edit edu
     */
    public function edit_edu($id)
    {
        $user_id = $this->input->post('user_id');
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('edu_stage_id', 'Stage Type ID', 'required|numeric');
        $this->form_validation->set_rules('edu_level_id', 'Level Status ID', 'required|numeric');
//var_dump($_POST);die();
        if ($this->form_validation->run()) {

            $edu_level_id = $this->input->post('edu_level_id');
            $edu_stage_id = $this->input->post('edu_stage_id');
            $edu_details= $this->input->post('edu_details');

            /****files***/
            // upload file
            $upload_image = $_FILES['edu_file']['name'];
            $file = 'no';

            $data = [
                'edu_stage_id' => $edu_stage_id,
                'edu_level_id' => $edu_level_id,
                'edu_details' => $edu_details,
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            //  var_dump($data);
            if ($this->db->update('user_education', $data, ['edu_id' => $id])) {
                if ($upload_image) {
                    $attach_path = '/assets/uploads/attach/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '6000';
                    $config['upload_path'] = './assets/uploads/attach/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('edu_file')) {
                        $upload_data = $this->upload->data();
                        // Generate a new file name with a date and serial number
                        $new_file_name = date('YmdHis') . '_' . uniqid() . $upload_data['file_ext'];
                        // Rename the uploaded file
                        rename($upload_data['full_path'], $upload_data['file_path'] . $new_file_name);
                        // Set the new file name
                        $file = $new_file_name;
                    } else {
                        echo $this->upload->display_errors();
                    }

                    $attach_id = $this->input->post('attach_id');

                    // Ensure $attach_id is set and convert it to an integer
                    $attach_id = isset($attach_id) ? (int)$attach_id : 0;

                    // Check if $attach_id is greater than 0 and $file is not 'no'
                    if ($attach_id > 0 && $file != 'no') {
                        $data = [
                            'attach_path' => $attach_path . $file,
                            'attach_name' => $file,
                            'updated_by' => $this->session->userdata('id'),
                            'updated_at' => date('Y-m-d')
                        ];
                        $this->db->update('user_attach', $data, ['attach_id' => $attach_id]);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                        redirect('cv/index/' . $user_id . '/2');
                    }
                    if (($attach_id == 0) && ($file != 'no')) {
                        $data = [
                            'user_id' => $user_id,
                            'attach_type_id' => EDU_REPORT,
                            'attach_path' => $attach_path . $file,
                            'attach_name' => $file,
                            'attach_table_id' => $id,
                            'attach_table_name' => 'user_education',
                            'created_by' => $this->session->userdata('id'),
                            'created_at' => date('Y-m-d')
                        ];
                        if ($this->db->insert('user_attach', $data)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                            redirect('cv/index/' . $user_id . '/2');
                        }
                    }
                }
                else{
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                    redirect('cv/index/' . $user_id . '/2');
                }
            }
            else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل </div>');
                redirect('cv/index/' . $user_id . '/2');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل المتطلبات والتحقق</div>');
            redirect('cv/index/' . $user_id . '/2');
        }
    }
    /**
     *add health
     */
    public function add_health()
    {
        $user_id = $this->input->post('user_id');
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('disability_type_id', 'Disability Type ID', 'required|numeric');
        $this->form_validation->set_rules('health_status_id', 'Health Status ID', 'required|numeric');

        if ($this->form_validation->run()) {

            $disability_type_id = $this->input->post('disability_type_id');
            $health_status_id = $this->input->post('health_status_id');
            $health_details = $this->input->post('health_details');

            //var_dump($this->input->post());die();
            /****files***/
            // upload file
            $upload_image = $_FILES['file']['name'];
            $file = 'no';
            if ($upload_image) {
                $attach_path = '/assets/uploads/attach/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '6000';
                $config['upload_path'] = './assets/uploads/attach/';

                $this->load->library('upload', $config);


                if ($this->upload->do_upload('file')) {
                    $upload_data = $this->upload->data();
                    // Generate a new file name with a date and serial number
                    $new_file_name = date('YmdHis') . '_' . uniqid() . $upload_data['file_ext'];
                    // Rename the uploaded file
                    rename($upload_data['full_path'], $upload_data['file_path'] . $new_file_name);
                    // Set the new file name
                    $file = $new_file_name;
                } else {
                    echo $this->upload->display_errors();
                }
            }
            $data = [
                'user_id' => $user_id,
                'disability_type_id' => $disability_type_id,
                'health_status_id' => $health_status_id,
                'health_details' => $health_details,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
          //  var_dump($data);
            if ($this->db->insert('user_health', $data)) {
                $insert_id = $this->db->insert_id();

                if ($file != 'no') {
                    $data = [
                        'user_id' => $user_id,
                        'attach_type_id' => HEALTH_REPORT,
                        'attach_path' => $attach_path . $file,
                        'attach_name' => $file,
                        'attach_table_id' => $insert_id,
                        'attach_table_name' => 'user_health',
                        'created_by' => $this->session->userdata('id'),
                        'created_at' => date('Y-m-d')
                    ];
                    $this->db->insert('user_attach', $data);
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                redirect('cv/index/'.$user_id .'/1');

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                redirect('cv/index/' . $user_id . '/1');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل المتطلبات والتحقق</div>');
            redirect('cv/index/' . $user_id . '/1');
        }
    }
    /**
     * info detail health
     * */
    public function detail_health()
    {
        $health_id = $this->input->post('health_id');

        $join_array = array(
            array(
                'table_name' => 'constants conD',
                'condition' => 'user_health.disability_type_id = conD.id'
            ),
            array(
                'table_name' => 'constants con',
                'condition' => 'user_health.health_status_id = con.id'
            ),
            array(
                'table_name' => 'user_attach attach',
                'condition' => 'user_health.health_id = attach.attach_table_id'
            ),
        );

        $dataHealth = $this->Base_model->get_with_join(
            'user_health.*, attach.*,user_health.user_id as usid, con.title as health_status, conD.title as disability_type',
            'user_health',
            $join_array,
            'user_health.deleted_by IS NULL AND user_health.health_id = '.$health_id,
            'user_health.health_id ASC'
        );

// If you expect only one result, access the first element of the array
        $response = isset($dataHealth[0]) ? $dataHealth[0] : null;

// Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * delete health
     */
    public function delete_health($id,$user_id=null,$tab_id=1)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_health',$data, ['health_id' => $id])){
            $data = [
                'deleted_by' => $this->session->userdata('id'),
                'deleted_at' => date('Y-m-d')
            ];
            $this->db->update('user_attach',$data, ['attach_table_id' => $id,'attach_table_name'=>'user_health']);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
        switch($tab_id){
            case 1:
                redirect('cv/index/'.$user_id.'/1');
                break;
            default:
                redirect('member/family_show/');
                break;
        }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('member/family_show/');
        }

    }

  /**
   *edit health
   */
    public function edit_health($id)
    {
        $user_id = $this->input->post('user_id');
        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('disability_type_id', 'Disability Type ID', 'required|numeric');
        $this->form_validation->set_rules('health_status_id', 'Health Status ID', 'required|numeric');

        if ($this->form_validation->run()) {

            $disability_type_id = $this->input->post('disability_type_id');
            $health_status_id = $this->input->post('health_status_id');
            $health_details = $this->input->post('health_details');

            /****files***/
            // upload file
            $upload_image = $_FILES['file']['name'];
            $file = 'no';

            $data = [
                'disability_type_id' => $disability_type_id,
                'health_status_id' => $health_status_id,
                'health_details' => $health_details,
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            //  var_dump($data);
            if ($this->db->update('user_health', $data, ['health_id' => $id])) {
                if ($upload_image) {
                    $attach_path = '/assets/uploads/attach/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '6000';
                    $config['upload_path'] = './assets/uploads/attach/';

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('file')) {
                        $upload_data = $this->upload->data();
                        // Generate a new file name with a date and serial number
                        $new_file_name = date('YmdHis') . '_' . uniqid() . $upload_data['file_ext'];
                        // Rename the uploaded file
                        rename($upload_data['full_path'], $upload_data['file_path'] . $new_file_name);
                        // Set the new file name
                        $file = $new_file_name;
                    } else {
                        echo $this->upload->display_errors();
                    }

                    $attach_id = $this->input->post('attach_id');

                    // Ensure $attach_id is set and convert it to an integer
                    $attach_id = isset($attach_id) ? (int)$attach_id : 0;

                    // Check if $attach_id is greater than 0 and $file is not 'no'
                    if ($attach_id > 0 && $file != 'no') {
                        $data = [
                            'attach_path' => $attach_path . $file,
                            'attach_name' => $file,
                            'updated_by' => $this->session->userdata('id'),
                            'updated_at' => date('Y-m-d')
                        ];
                        $this->db->update('user_attach', $data, ['attach_id' => $attach_id]);
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                        redirect('cv/index/' . $user_id . '/1');
                    }
                    if (($attach_id == 0) && ($file != 'no')) {
                        $data = [
                            'user_id' => $user_id,
                            'attach_type_id' => HEALTH_REPORT,
                            'attach_path' => $attach_path . $file,
                            'attach_name' => $file,
                            'attach_table_id' => $id,
                            'attach_table_name' => 'user_health',
                            'created_by' => $this->session->userdata('id'),
                            'created_at' => date('Y-m-d')
                        ];
                        if ($this->db->insert('user_attach', $data)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                            redirect('cv/index/' . $user_id . '/1');
                        }
                    }
                }
else{
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
    redirect('cv/index/' . $user_id . '/1');
}
            }
            else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل </div>');
                redirect('cv/index/' . $user_id . '/1');
            }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل المتطلبات والتحقق</div>');
            redirect('cv/index/' . $user_id . '/1');
        }
    }

    /**
     * objectToArray
     */
    private function objectToArray($obj) {
    return json_decode(json_encode($obj), true);
}
}