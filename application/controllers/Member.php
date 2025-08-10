<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$autoload = APPPATH . 'third_party/Mpdf/vendorMpdf/autoload.php';
if (file_exists($autoload)) {
    require_once($autoload);
} else {
    // Handle the error
    echo "Autoload file not found.";
}

/*use Mpdf;
use Mpdf\HTMLParserMode;*/
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Member extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('HierarchyLib'); // Load the library
    }

    // function index view
    public function index($title = 'سطح المكتب')
    {
        $data['title'] = $title;
        $data['viewName'] = 'admin/index';
        $data['withParam'] = 'n';
        parent::index($data);
    }

    public function add_employee()
    {
        /*   if (!($this->session->userdata('user_name'))) {
               redirect('user');
           }*/
        $this->form_validation->set_rules('fname', 'fname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('sname', 'sname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('tname', 'tname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('lname', 'lname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('user_name', 'user_name', 'required|trim|is_unique[user.user_name]', [
            'required' => 'حقل واجب الإدخال!',
            'valid_email' => 'حساب خاطىء!',
            'is_unique' => 'الحساب مسجل مسبقاً!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|matches[password2]', [
            'required' => 'حقل واجب الإدخال!',
            'matches' => 'كلمات السر غير متوافقة!',
            'min_length' => 'كلمة المرور قصيرة للغاية!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[5]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'إنشاء حساب جديد';

            $data['viewName'] = 'member/registration';
            $data['withParam'] = 'n';
            $this->db->where('deleted_by IS  NULL');
            $data['param']['roles'] = $this->db->get('user_role')->result_array();
            parent::index($data);
        } else {
            $user_name = $this->input->post('user_name', true);
            $role_id = $this->input->post('role_id', true);
            $password = $this->input->post('password');
            $identity = $this->input->post('identity');
            $fname = $this->input->post('fname', true);
            $sname = $this->input->post('sname', true);
            $tname = $this->input->post('tname', true);
            $lname = $this->input->post('lname', true);
            $full_name = $fname . ' ' . $sname . ' ' . $tname . ' ' . $lname;
            $data = [
                'fname' => htmlspecialchars($fname),
                'sname' => htmlspecialchars($sname),
                'tname' => htmlspecialchars($tname),
                'lname' => htmlspecialchars($lname),
                'full_name' => $full_name,
                'user_name' => htmlspecialchars($user_name),
                'identity' => $identity,
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => $role_id,
                'is_active' => 1,//0,
                'is_emp' => 1,//0,
                'date_created' => date("d-m-Y"),//time()
            ];
            $result = $this->db->insert('user', $data);
            //  var_dump($result);die();
            redirect('admin');
            /*  $userCheck = $this->UserModel->verify_user($user_name, $password);
              if (isset($userCheck)) {
                  $user = $this->db->get_where('user', ['user_name' => $user_name])->row_array();
                  $data = [
                      'identity' => $user['identity'],
                      'user_name' => $user['user_name'],
                      'role_id' => $user['role_id'],
                      'id' => $user['id'],
                  ];
                  $this->session->set_userdata($data);
                  // cek role
                  if ($user['is_emp'] == "1") {
                      redirect('admin');
                  } else {
                      redirect('user');
                  }
              }*/

        }
    }

    public function validate_contact()
    {
        $contact_type = $this->input->post('contact_type');
        $contact_value = $this->input->post('contact_value');

        $data = $this->db->get_where('user_contact', ['contact_type ' => $contact_type, 'contact_value ' => $contact_value])->result_array();
        if (count($data) > 0) {
            $response = [
                'status' => 0,
                'message' => 'وسيلة الاتصال مدخلة مسبقاً لــ  ',
                'user_id' => $data[0]['id'],
            ];

        } else {
            $response = [
                'status' => 1,
                'message' => 'بيانات صحيحة',
                'user_id' => 0,
            ];
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // data member info
    public function validate_identity()
    {
        $identity = $this->input->post('identity');
        $form = $this->input->post('form');
        $maretal_status_id = $this->input->post('type');
        $huspand_user_id = $this->input->post('parent_user_id');
        $parent_user_id = $this->input->post('parent_user_id');
        $data = [];
        switch ($form) {
            case 'father':
                $data = $this->db->get_where('user', ['identity ' => $identity,])->result_array();
                break;
            case 'wife':

                $data = $this->db->get_where('user', ['identity ' => $identity, 'huspand_user_id ' => $huspand_user_id, 'maretal_status_id ' => $maretal_status_id])->result_array();
                break;
            case 'child':
                $data = $this->db->get_where('user', ['identity ' => $identity, 'parent_user_id ' => $parent_user_id])->result_array();
                break;
        }

        if (count($data) > 0) {
            $response = [
                'status' => 0,
                'message' => 'رقم الهوية مدخل مسبقاً لــ  ' . $data[0]['full_name'],
                'user_id' => $data[0]['id'],
                'from' => $form,
                'huspand_user_id' => $huspand_user_id,
                'maretal_status_id' => $maretal_status_id,
            ];

        } else {
            $response = [
                'status' => 1,
                'message' => 'رقم الهوية  صحيح',
                'user_id' => 0,
                'from' => $form,
                'huspand_user_id' => $huspand_user_id,
                'maretal_status_id' => $maretal_status_id,
            ];
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

    public function add_member($huspand_id = null, $tab_id = 1, $title = 'سطح المكتب')
    {
        $this->form_validation->set_rules('user_status', 'user_status', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('fname', 'Fname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('sname', 'sname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('tname', 'tname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('lname', 'lname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('identity', 'identity', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('asylum_status', 'asylum_status', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('naturalwork', 'naturalwork', 'required', ['required' => 'حقل واجب الإدخال!']);
        $nav_user = $care = 0;
        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة رب الأسرة';
            $data['viewName'] = 'member/add_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
            $data['param']['PROFESSIONS'] = (array)$this->db->get_where('professions')->result_array();
            // $data['param']['js_file'][0] ='\assets\custom\jquery.js';
            $data['param']['js_file'][0] = '\assets\custom\validate_identity.js';
            $data['param']['js_file'][1] = '\assets\custom\validate_name.js';
            $data['param']['js_file'][2] = '\assets\custom\add_member.js';
            $data['withParam'] = 'y';
            parent::index($data);
        } else {
            $mother_user_id = $this->input->post('mother_user_id');
            $mother_user_id = empty($mother_user_id) ? NULL : $mother_user_id;
            $fname = $this->input->post('fname');
            $sname = $this->input->post('sname');
            $tname = $this->input->post('tname');
            $lname = $this->input->post('lname');
            $dob = $this->input->post('dob');
            $parent_user_id = NULL;
            $relation_type = FAMILY_HEADER;
            $deathDate = NULL;
            $father_identity = NULL;
            $mother_identity = NULL;
            $gender = 1;
            $huspand_identity = NULL;
            if ($tab_id == 4) {
                if ($huspand_id != null) {
                    $relation_type = WIFE;
                    $gender = 2;
                    $deathDate = '';
                    $parent_user_id = NULL;
                    $dataHus = $this->db->get_where('user', ['id' => $huspand_id])->row_array();
                    $huspand_identity = $dataHus['identity'];
                    $nav_user = $huspand_id;
                } else {
                    $parent_user_id = NULL;
                    $death_date = $this->input->post('death_date');
                    if ($death_date)
                        $deathDate = date('d-m-Y', $death_date);
                    else
                        $deathDate = NULL;
                    $relation_type = FAMILY_HEADER;
                }
            }

            $child_cat_id = $this->input->post('child_cat_id') ?? null;
            if ($tab_id == 5) {
                if ($huspand_id != null) {
                    $huspand_id = NULL;
                    $relation_type = $this->input->post('relation_type_id');
                    $parent_user_id = $this->input->post('parent_user_id');
                    $dataPar = $this->db->get_where('user', ['id' => $parent_user_id])->row_array();
                    $nav_user = $parent_user_id;
                    $father_identity = $dataPar['identity'];
                    $dataMother = $this->db->get_where('user', ['id' => $mother_user_id])->row_array();
                    $mother_identity = $dataMother['identity'];
                    $death_date = $this->input->post('child_death_date');
                    $dob = $this->input->post('dob_child');
                    $care = $this->input->post('care');

                    if ($death_date) {
                        $timestamp = strtotime($death_date); // Convert to timestamp
                        $deathDate = date('Y-m-d', $timestamp);
                    } else
                        $deathDate = NULL;
                    if ($dob) {
                        $timestamp = strtotime($dob); // Convert to timestamp
                        $dob = date('Y-m-d', $timestamp); // Format the date
                    } else
                        $dob = NULL;
                }
            }
            $death_reason_id = $this->input->post('death_reason');
            if ($death_reason_id == 0) {
                $death_reason_id = NULL;
            }
            $data = [
                'parent_user_id' => $parent_user_id,
                'father_identity' => $father_identity,
                'fname' => $fname,
                'sname' => $sname,
                'tname' => $tname,
                'lname' => $lname,
                'care' => ($care === '' || $care === 'null') ? 0 : $care,
                'child_cat_id' => ($child_cat_id === '' || $child_cat_id === 'null') ? null : $child_cat_id,
                'mother_user_id' => $mother_user_id,
                'mother_identity' => $mother_identity,
                'full_name' => $fname . ' ' . $sname . ' ' . $tname . ' ' . $lname,
                'identity' => $this->input->post('identity'),
                'death_date' => $deathDate,
                'dob' => $dob,
                'gender_id' => $gender,
                'death_reason_id' => ($death_reason_id === '' || $death_reason_id === 'null') ? null : $death_reason_id,
                'user_status_id' => $this->input->post('user_status'),
                'asylum_status_id' => $this->input->post('asylum_status'),
                'naturalwork_id' => $this->input->post('naturalwork'),
                'profession_id' => $this->input->post('profession_id'),
                'total_member_no' => $this->input->post('total_member_no'),
                'male_no_under_me' => $this->input->post('male_no_under_me'),
                'femail_no_under_me' => $this->input->post('femail_no_under_me'),
                'maretal_status_id' => $this->input->post('maretal_status'),
                'incom' => $this->input->post('incom'),
                'huspand_user_id' => $huspand_id,
                'huspand_identity' => $huspand_identity,
                'relation_type_id' => $relation_type,
                'after_death_incom' => $this->input->post('after_death_incom'),
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            //  var_dump($_POST);
            //  var_dump($data); die();
            try {
                if ($this->db->insert('user', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                    switch ($tab_id) {
                        case 4:
                            $huz_user_id = $huspand_id;//$this->input->post('huz_user_id');
                            /* var_dump($huz_user_id);
                             var_dump($tab_id);die();*/
                            redirect('member/edit_member/' . $huz_user_id . '/4');
                            break;
                        case 5:
                            $parent_user_id = $parent_user_id;//$this->input->post('parent_user_id');
                            redirect('member/edit_member/' . $parent_user_id . '/5');
                            break;
                        default:
                            redirect('member/edit_member/' . $this->db->insert_id());
                            break;
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('member/datamember/');
                }
            } catch (Exception $e) {
                $error = $this->db->error();
                $error_number = $error['code'];
                if ($error_number === 1062) {
                    $meg = $error['message'];
                    if (preg_match("/'(\d+)'/", $error['message'], $matches)) {
                        $duplicate_number = $matches[1]; // The extracted number
                        $meg = "تكرار في رقم الهوية '$duplicate_number' موجودة مسبقاً.";
                    }
                    $this->session->set_flashdata('dbmessage', '<div class="alert alert-danger" role="alert">' . $meg . '
             </div>');
                    redirect('member/edit_member/' . $nav_user . '/5');

                } else {
                    log_message('error', "DB Exception: " . $e->getMessage());
                    echo "An unexpected error occurred.";
                }
            }
        }
    }

    public function edit_member($id = null, $tab_id = '1', $title = 'سطح المكتب')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('user_status', 'user_status', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('fname', 'Fname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('sname', 'sname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('tname', 'tname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('lname', 'lname', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('identity', 'identity', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('incom', 'incom', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('after_death_incom', 'after_death_incom', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('asylum_status', 'asylum_status', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('naturalwork', 'naturalwork', 'required', ['required' => 'حقل واجب الإدخال!']);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['viewName'] = 'member/edit_member';
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['ATTACH'] = (array)$this->db->get_where('constants', ['parent_id' => ATTACH])->result_array();

            $datap = $this->db->get_where('user', ['id' => $id])->row_array();
            $data['param']['user_row'] = $datap;
            $data['title'] = 'تعديل بيانات  ' . $datap['full_name'];

            $data['param']['tab_id'] = $tab_id;
            $data['param']['id'] = $id;
            $data['param']['js_file'][0] = '/assets/custom/validate_identity.js';
            $data['param']['js_file'][1] = '/assets/custom/contact.js';
            $data['param']['js_file'][2] = '/assets/custom/validate_name.js';
            $data['param']['js_file'][3] = '/assets/custom/tab_manage.js';
            $data['param']['js_file'][4] = '/assets/custom/member.js';
            $data['withParam'] = 'y';
            parent::index($data);
        } else {
            //var_dump($this->input->post('fname'));die();
            $fname = $this->input->post('fname');
            $sname = $this->input->post('sname');
            $tname = $this->input->post('tname');
            $lname = $this->input->post('lname');
            $mother_user_id = $this->input->post('mother_user_id');
            $child_cat_id = $this->input->post('child_cat_id');
            $care = $this->input->post('care');
            $mother_user_id = empty($mother_user_id) ? NULL : $mother_user_id;
            $relation_type = $this->input->post('relation_type_id');
            switch ($tab_id) {
                case '1' :
                    $dob = $this->input->post('dob_father');
                    $death_date = $this->input->post('father_death_date');
                    $death_date = date('Y-m-d', strtotime($death_date));
                    break;
                case '4' :
                    $dob = $this->input->post('dob_wife');
                    $death_date = $this->input->post('wife_death_date');
                    $death_date = date('Y-m-d', strtotime($death_date));
                    break;
                case '5' :
                    $dobPost = $this->input->post('dob_child_detail');
                    $death_date = $this->input->post('child_death_date_detail');
                    $death_date = date('Y-m-d', strtotime($death_date));
                    $dob = date('Y-m-d', strtotime($dobPost));
                    break;
            }
            $death_reason_id = $this->input->post('death_reason');
            $data = [
                'fname' => $fname,
                'sname' => $sname,
                'tname' => $tname,
                'lname' => $lname,

                'full_name' => $fname . ' ' . $sname . ' ' . $tname . ' ' . $lname,
                'identity' => $this->input->post('identity'),
                'care' => $care,
                'child_cat_id' => ($child_cat_id === '' || $child_cat_id === 'null') ? null : $child_cat_id,
                'dob' => $dob,
                'mother_user_id' => $mother_user_id,
                'death_date' => $death_date,
                'death_reason_id' => ($death_reason_id === '' || $death_reason_id === 'null') ? null : $death_reason_id,
                'relation_type_id' => $relation_type,
                'user_status_id' => $this->input->post('user_status'),
                'asylum_status_id' => $this->input->post('asylum_status'),
                'naturalwork_id' => $this->input->post('naturalwork'),
                'profession_id' => $this->input->post('profession_id'),
                'total_member_no' => $this->input->post('total_member_no'),
                'male_no_under_me' => $this->input->post('male_no_under_me'),
                'femail_no_under_me' => $this->input->post('femail_no_under_me'),
                'maretal_status_id' => $this->input->post('maretal_status'),
                'maretal_status_id' => $this->input->post('maretal_status'),
                'gender_id' => $this->input->post('gender'),
                'incom' => $this->input->post('incom'),
                'after_death_incom' => $this->input->post('after_death_incom'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            //var_dump($data);die();
            if ($this->db->update('user', $data, ['id' => $id])) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                switch ($tab_id) {
                    case 4:
                        $huz_user_id = $this->input->post('huz_user_id');
                        redirect('member/edit_member/' . $huz_user_id . '/4');
                        break;
                    case 5:
                        $parent_user_id = $this->input->post('parent_user_id');
                        redirect('member/edit_member/' . $parent_user_id . '/5');
                        break;
                    default:
                        redirect('member/edit_member/' . $id);
                        break;
                }

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');
            }
        }
    }

    public function emp_show()
    {
        $this->datamember('emp', 'إدارة الموظفين');
    }

    public function citizen_show()
    {
        $this->datamember('all', 'إدارة المواطنين');
    }

    public function child_show()
    {
        $this->datamember('child', 'إدارة الأطفال');
    }

    public function family_orphan_show()
    {
        $this->datamember('family_orphan', 'إدارة أسر الأيتام');
    }

    public function family_show()
    {
        $this->datamember('family', 'إدارة العائلة');
    }

    public function datamember($condition = NULL, $title = null)
    {
        if ($condition === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد بيانات';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $user_members = array();
        $data['title'] = $title;
        $data['user'] = $this->db->get_where('user', ['user_name' => $this->session->userdata('user_name')])->row_array();
        // $data['user_member'] = $this->db->order_by('id', 'DESC');
        switch ($condition) {
            case 'emp':
                // $user_members = $this->db->get_where('user', ['is_emp' => 1,'deleted_by' => NULL])->result_array();
                $user_members = $this->db->get_where('user_refreshed_view ', ['is_emp' => 1, 'deleted_by' => NULL])->result_array();
                break;
            case 'all':
                $user_members = $this->db->get_where('user', ['is_emp' => 0, 'deleted_by' => NULL])->result_array();
                break;
            case 'family':
                $user_members = $this->db->get_where('user', ['is_emp' => 0, 'deleted_by' => NULL, 'relation_type_id' => FAMILY_HEADER])->result_array();
                break;

            case 'family_orphan':
                $this->db->where('deleted_by', NULL); // Condition for 'deleted_by'
                $this->db->where('is_emp', 0);
                $this->db->where('relation_type_id', FAMILY_HEADER); // Condition for 'relation_type_id'

                // Use 'where_in' for the 'IN' clause
                $this->db->where_in('user_status_id', [5, 6, 18]);

                // Execute the query
                $user_members = $this->db->get('user')->result_array();
                break;
            case 'child':
                $user_members = $this->db->get_where('user', ['is_emp' => 0, 'deleted_by' => NULL, 'age < ' => CHILD_AGE])->result_array();
                break;

            default:
                $data['title'] = 'خطأ';

                $data['message'] = 'لايوجد بيانات';
                $data['return'] = 'member';
                $this->load->view('error_custom', $data);
                return;
        }

        $data['param']['user_members'] = $user_members;
        $data['param']['condition'] = $condition;
        $data['viewName'] = 'member/data_member';
        $data['withParam'] = 'y';
        parent::index($data);

    }

    public function load_tab($tab_id, $id)
    {
        $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
        $data['param']['ATTACH'] = (array)$this->db->get_where('constants', ['parent_id' => ATTACH])->result_array();
        $data['param']['CATEGORY'] = (array)$this->db->get_where('constants', ['parent_id' => CATEGORY])->result_array();
        $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
        $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
        $data['param']['PROFESSIONS'] = (array)$this->db->get_where('professions')->result_array();
        $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
        $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
        $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
        $result = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        // $hierarchy =$this->buildHierarchy($result);
        $hierarchy = $this->hierarchylib->buildHierarchy($result);
        $data['param']['GOVERNORATES'] = $hierarchy;
        $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
        $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
        $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
//,'user_status_id'=>LIVE
        $datap = $this->db->get_where('user', ['id' => $id])->row_array();
        $dataWife = $this->db->get_where('user', ['huspand_user_id' => $id])->result_array();
        $result = $this->db->get_where('user', ['huspand_user_id' => $id, 'maretal_status_id !=' => DIVORCED])->result_array();
        if ($result)
            $user_wife_row = $result[0];
        else
            $user_wife_row = [];

        $join_array = array(
            array(
                'table_name' => 'constants pms',
                'condition' => 'user.relation_type_id  = pms.id '
            ),
            array(
                'table_name' => 'user mum',
                'condition' => 'user.mother_user_id  = mum.id '
            ),
        );
        $dataChild = $this->Base_model->get_with_join('user.*,user.id as uid,pms.title as relation_type,mum.fname as mother',
            'user', $join_array, '  user.deleted_by  is  null and user.parent_user_id=' . $id,
            'user.id asc');

        if ($dataChild)
            $user_child_row = $dataChild[0];
        else {
            $user_child_row = $dataChild = [];
        }

        $data['param']['user_row'] = $datap;
        $data['title'] = 'تعديل بيانات  ' . $datap['full_name'];
        $join_array = array(
            array(
                'table_name' => 'constants',
                'condition' => 'user_contact.contact_type = constants.id'
            ),
        );
        $dataContacts = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, ' user_contact.user_id=' . $id . ' and  user_contact.deleted_by  is  null ', 'user_contact.id asc');

        $data['title'] = 'تعديل بيانات  ' . $datap['full_name'];
        $join_array = array(
            array(
                'table_name' => 'user',
                'condition' => 'user_attach.user_id = user.id'
            ),
            array(
                'table_name' => 'constants',
                'condition' => 'user_attach.attach_type_id = constants.id'
            ),
        );
        $attachs = $this->Base_model->get_with_join('user_attach.*,constants.title as attach_type', 'user_attach', $join_array, ' user_attach.user_id=' . $id . ' and  user_attach.deleted_by  is  null ', 'user_attach.attach_id  asc');

        $data['param']['tab_id'] = $tab_id;
        $data['param']['contacts'] = $dataContacts;
        $data['param']['wife'] = $dataWife;
        $data['param']['child'] = $dataChild;
        $data['param']['attachs'] = $attachs;
        $data['param']['user_wife_row'] = $user_wife_row;
        $data['param']['user_child_row'] = $user_child_row;
        // var_dump($data['param']);die();
        $this->load->view('member/tab' . $tab_id . '_view', $data);
    }

    /**
     * info detail member
     * */
    public function detailmember($id = null)
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $data['title'] = 'معلومات المستخدم';
        $data['param']['member'] = $this->db->get_where('user', ['id' => $id])->row_array();
//var_dump($data['param']['member'] );
        $data['viewName'] = 'member/detail_member';
        $data['withParam'] = 'y';
        parent::index($data);
    }

    /**
     * get_details
     */
    public function get_details()
    {
        $id = $this->input->post('id');
        $data = $this->db->get_where('user', ['id' => $id])->row_array();
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function printmember($id = null)
    {
        // var_dump($id);
        $orphan = $this->db->get_where('user', ['id' => $id])->row_array();
        if ($orphan) {
            // var_dump($orphan);die();
            $data['orphan'] = $orphan;
            $father_id = $orphan['parent_user_id'];
            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.user_status_id = c.id'
                ),
                array(
                    'table_name' => 'constants cw',
                    'condition' => 'user.naturalwork_id  = cw.id'
                ),
                array(
                    'table_name' => 'constants m',
                    'condition' => 'user.maretal_status_id  = m.id'
                ),
                array(
                    'table_name' => 'constants governorate',
                    'condition' => 'user.governorate_id   = governorate.id'
                ), array(
                    'table_name' => 'constants maretal',
                    'condition' => 'user.maretal_status_id  = maretal.id'
                ),
                array(
                    'table_name' => 'constants city',
                    'condition' => 'user.city_id  = city.id'
                ),
                array(
                    'table_name' => 'general_area',
                    'condition' => 'user.general_area_id   = general_area.id'
                ),
                array(
                    'table_name' => 'constants r',
                    'condition' => 'user.death_reason_id   = r.id'
                ),
                array(
                    'table_name' => 'local_area',
                    'condition' => 'user.local_area_id    = local_area.id'
                ),
                array(
                    'table_name' => 'landmark',
                    'condition' => 'user.nearest_famous_place   = landmark.id'
                ),
                array(
                    'table_name' => 'constants dwelling',
                    'condition' => 'user.dwelling_nature_id  = dwelling.id'
                ),
                array(
                    'table_name' => 'constants damage',
                    'condition' => 'user.dwelling_damage_id   = damage.id'
                ),
                array(
                    'table_name' => 'constants valley',
                    'condition' => 'user.valley_side_id   = valley.id'
                ),
                array(
                    'table_name' => 'constants residence',
                    'condition' => 'user.current_residence_status_id   = residence.id'
                ),
            );
            $father = $this->Base_model->get_with_join('user.*,c.title as title,valley.title as valley_title,residence.title as residence_title,
        landmark.title as land_name,damage.title as damage_title,dwelling.title as dwelling_title,
        governorate.title as governorate_name,city.title as city_name,general_area.title as area_name,local_area.title as local_name,
        cw.title as work_name,maretal.title as maretal_name,r.title as reason', 'user', $join_array, ' user.id=' . $father_id . ' and  user.deleted_by  is  null ', 'user.id asc')[0];

            $data['father'] = $father;
            //  var_dump($father['full_name']);die();
            $mother_id = $orphan['mother_user_id'];
            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.user_status_id = c.id'
                ),
                array(
                    'table_name' => 'constants cw',
                    'condition' => 'user.naturalwork_id  = cw.id'
                ),
                array(
                    'table_name' => 'constants m',
                    'condition' => 'user.maretal_status_id  = m.id'
                ),
                array(
                    'table_name' => 'constants r',
                    'condition' => 'user.death_reason_id   = r.id'
                ),
            );
            $mother = $this->Base_model->get_with_join('user.*,c.title as title,cw.title as work_name,m.title as maretal_name,r.title as reason', 'user', $join_array, ' user.id=' . $mother_id . ' and  user.deleted_by  is  null ', 'user.id asc');

            $data['mother'] = $mother[0];
            $join_array = array(
                array(
                    'table_name' => 'constants',
                    'condition' => 'user_contact.contact_type = constants.id'
                ),
            );
            $contact = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, ' user_contact.user_id=' . $father_id . ' and  user_contact.deleted_by  is  null ', 'user_contact.id asc');
            $data['contact'] = $contact;
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
            $Edu = $this->Base_model->get_with_join('user_education.*,attach.*,con.title as edu_stage,conD.title as edu_level, conT.title as attach_type',
                'user_education', $join_array, '  user_education.deleted_by  is  null and user_education.user_id =' . $id,
                'user_education.edu_id asc');
            $data['edu'] = $Edu;
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

            $Health = $this->Base_model->get_with_join(
                'user_health.*, attach.*,user_health.user_id as usid, con.title as health_status, conD.title as disability_type',
                'user_health',
                $join_array,
                'user_health.deleted_by IS NULL AND user_health.user_id = ' . $id,
                'user_health.health_id ASC'
            );
            $data['health'] = $Health;
            $join_array = array(
                array(
                    'table_name' => 'constants conH',
                    'condition' => 'user_hobbies.hobby_id   = conH.id '
                ),
            );
            $Hob = $this->Base_model->get_with_join('user_hobbies.*,conH.title as hobby,',
                'user_hobbies', $join_array, '  user_hobbies.deleted_by  is  null and user_hobbies.user_id =' . $id,
                'user_hobbies.hob_id asc');
            $data['hob'] = $Hob;
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
            $Need = $this->Base_model->get_with_join('user_need.*,conH.title as need_type,conT.title as needu_sub_type',
                'user_need', $join_array, '  user_need.deleted_by  is  null and user_need.user_id =' . $id,
                'user_need.need_id asc');
            $data['need'] = $Need;
            $join_array = array(
                array(
                    'table_name' => 'constants pms',
                    'condition' => 'user_agent.relation_type_id  = pms.id '
                ),
                array(
                    'table_name' => 'user ',
                    'condition' => 'user.id  = user_agent.agent_user_id '
                ),
            );
            $childAgent = $this->Base_model->get_with_join('user.*,user_agent.*,user.id as uid,pms.title as relation_type',
                'user_agent', $join_array, '  user.deleted_by  is  null and  user_agent.deleted_by  is  null  and user_agent.child_user_id=' . $id,
                'user.id asc');
            $data['agent'] = $childAgent;
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);
        ob_start();
        $config = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'xbriyaz',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 0,
            'margin_header' => 10,
            'margin_footer' => 0,
            'setAutoTopMargin' => false,  // Change this to false
            'autoMarginPadding' => 0     // Add this line
        ];

// Create mPDF instance with simplified configuration
        $mpdf = new \Mpdf\Mpdf($config);

// These lines should come right after creating the instance
        $mpdf->SetHTMLHeader('');    // Set empty header
        $mpdf->SetTopMargin(15);      // Force top margin to 0
        $mpdf->SetDirectionality('rtl');
        $mpdf->useAdobeCJK = true;
        $mpdf->SetDisplayMode('fullpage');
        // Load header image
        $imageHeader = base_url('/assets/img/right-logo.png');
        $mpdf->showImageErrors = true;
        /* $header = file_get_contents(APPPATH . 'view/report/header', ['imageHeaderPath' => $imageHeader]);
         $footer =  file_get_contents(APPPATH . 'view/report/footer');*/

        $header = '';
        //  include APPPATH . 'views/report/header.php';

        $footer = '';
        //    include APPPATH . 'views/report/footer.php';
        $header = view('report/header', ['imageHeaderPath' => $imageHeader]);
        $footer = view('report/footer');
        if ($id == '') {
            $mpdf->WriteHTML("<h1 style='font-family: xbriyaz;'>لا توجد بيانات</h1>");
            $mpdf->Output("aid_P.pdf", 'I');
            exit;
        }

        // Set default font
        $mpdf->SetFont('xbriyaz');
        $data['imageHeader'] = $imageHeader;
        // Load views
        //  $footer = view('Report/aid_copon/footer');
        //  $style = file_get_contents(APPPATH . 'views/report/style.php');
        $style = view('report/style.php');

        // Construct HTML with simplified structure
        $html = '<!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
        <meta charset="UTF-8">
        <style>
            body { 
                font-family: xbriyaz; 
                direction: rtl;
            }
            table {
                direction: rtl;
                text-align: right;
            }
            td, th {
                text-align: right;
            }
        </style>';

        $html .= $style;
        $html .= '</head>
    <body>';
        $html .= $header;
        $html .= $footer;
        //   $html .= $this->load->view('report/index', $data, true);
        $html .= view('report/index', $data);
        // $html .=   file_get_contents(APPPATH . 'view/report/index', $data, true);
        $html .= '</body>
    </html>';
        $mpdf->DefHeaderByName('MyHeader', '');
        $mpdf->DefFooterByName('MyFooter', '');
        //   $this->load->view('report/style', $data);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output("orphan.pdf", 'I');
        ob_end_flush();
        exit;
    }

    public function manaber($id = null)
    {
        // var_dump($id);
        $orphan = $this->db->get_where('user', ['id' => $id])->row_array();
        if ($orphan) {
            // var_dump($orphan);die();
            $data['orphan'] = $orphan;
            $father_id = $orphan['parent_user_id'];
            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.user_status_id = c.id'
                ),
                array(
                    'table_name' => 'constants cw',
                    'condition' => 'user.naturalwork_id  = cw.id'
                ),
                array(
                    'table_name' => 'constants m',
                    'condition' => 'user.maretal_status_id  = m.id'
                ),
                array(
                    'table_name' => 'constants governorate',
                    'condition' => 'user.governorate_id   = governorate.id'
                ), array(
                    'table_name' => 'constants maretal',
                    'condition' => 'user.maretal_status_id  = maretal.id'
                ),
                array(
                    'table_name' => 'constants city',
                    'condition' => 'user.city_id  = city.id'
                ),
                array(
                    'table_name' => 'general_area',
                    'condition' => 'user.general_area_id   = general_area.id'
                ),
                array(
                    'table_name' => 'constants r',
                    'condition' => 'user.death_reason_id   = r.id'
                ),
                array(
                    'table_name' => 'local_area',
                    'condition' => 'user.local_area_id    = local_area.id'
                ),
                array(
                    'table_name' => 'landmark',
                    'condition' => 'user.nearest_famous_place   = landmark.id'
                ),
                array(
                    'table_name' => 'constants dwelling',
                    'condition' => 'user.dwelling_nature_id  = dwelling.id'
                ),
                array(
                    'table_name' => 'constants damage',
                    'condition' => 'user.dwelling_damage_id   = damage.id'
                ),
                array(
                    'table_name' => 'constants valley',
                    'condition' => 'user.valley_side_id   = valley.id'
                ),
                array(
                    'table_name' => 'constants residence',
                    'condition' => 'user.current_residence_status_id   = residence.id'
                ),
            );
            $father = $this->Base_model->get_with_join('user.*,c.title as title,valley.title as valley_title,residence.title as residence_title,
        landmark.title as land_name,damage.title as damage_title,dwelling.title as dwelling_title,
        governorate.title as governorate_name,city.title as city_name,general_area.title as area_name,local_area.title as local_name,
        cw.title as work_name,maretal.title as maretal_name,r.title as reason', 'user', $join_array, ' user.id=' . $father_id . ' and  user.deleted_by  is  null ', 'user.id asc')[0];

            $data['father'] = $father;
            //  var_dump($father['full_name']);die();
            $mother_id = $orphan['mother_user_id'];
            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.user_status_id = c.id'
                ),
                array(
                    'table_name' => 'constants cw',
                    'condition' => 'user.naturalwork_id  = cw.id'
                ),
                array(
                    'table_name' => 'constants m',
                    'condition' => 'user.maretal_status_id  = m.id'
                ),
                array(
                    'table_name' => 'constants r',
                    'condition' => 'user.death_reason_id   = r.id'
                ),
            );
            $mother = $this->Base_model->get_with_join('user.*,c.title as title,cw.title as work_name,m.title as maretal_name,r.title as reason', 'user', $join_array, ' user.id=' . $mother_id . ' and  user.deleted_by  is  null ', 'user.id asc');

            $data['mother'] = $mother[0];
            $join_array = array(
                array(
                    'table_name' => 'constants',
                    'condition' => 'user_contact.contact_type = constants.id'
                ),
            );
            $contact = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, ' user_contact.user_id=' . $father_id . ' and  user_contact.deleted_by  is  null ', 'user_contact.id asc');
            $data['contact'] = $contact;
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
            $Edu = $this->Base_model->get_with_join('user_education.*,attach.*,con.title as edu_stage,conD.title as edu_level, conT.title as attach_type',
                'user_education', $join_array, '  user_education.deleted_by  is  null and user_education.user_id =' . $id,
                'user_education.edu_id asc');
            $data['edu'] = $Edu;
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

            $Health = $this->Base_model->get_with_join(
                'user_health.*, attach.*,user_health.user_id as usid, con.title as health_status, conD.title as disability_type',
                'user_health',
                $join_array,
                'user_health.deleted_by IS NULL AND user_health.user_id = ' . $id,
                'user_health.health_id ASC'
            );
            $data['health'] = $Health;
            $join_array = array(
                array(
                    'table_name' => 'constants conH',
                    'condition' => 'user_hobbies.hobby_id   = conH.id '
                ),
            );
            $Hob = $this->Base_model->get_with_join('user_hobbies.*,conH.title as hobby,',
                'user_hobbies', $join_array, '  user_hobbies.deleted_by  is  null and user_hobbies.user_id =' . $id,
                'user_hobbies.hob_id asc');
            $data['hob'] = $Hob;
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
            $Need = $this->Base_model->get_with_join('user_need.*,conH.title as need_type,conT.title as needu_sub_type',
                'user_need', $join_array, '  user_need.deleted_by  is  null and user_need.user_id =' . $id,
                'user_need.need_id asc');
            $data['need'] = $Need;
            $join_array = array(
                array(
                    'table_name' => 'constants pms',
                    'condition' => 'user_agent.relation_type_id  = pms.id '
                ),
                array(
                    'table_name' => 'user ',
                    'condition' => 'user.id  = user_agent.agent_user_id '
                ),
            );
            $childAgent = $this->Base_model->get_with_join('user.*,user_agent.*,user.id as uid,pms.title as relation_type',
                'user_agent', $join_array, '  user.deleted_by  is  null and  user_agent.deleted_by  is  null  and user_agent.child_user_id=' . $id,
                'user.id asc');
            $data['agent'] = $childAgent;
        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);
        ob_start();
        $config = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'xbriyaz',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 0,
            'margin_header' => 10,
            'margin_footer' => 0,
            'setAutoTopMargin' => false,  // Change this to false
            'autoMarginPadding' => 0     // Add this line
        ];

// Create mPDF instance with simplified configuration
        $mpdf = new \Mpdf\Mpdf($config);

// These lines should come right after creating the instance
        $mpdf->SetHTMLHeader('');    // Set empty header
        $mpdf->SetTopMargin(15);      // Force top margin to 0
        $mpdf->SetDirectionality('rtl');
        $mpdf->useAdobeCJK = true;
        $mpdf->SetDisplayMode('fullpage');
        // Load header image
        $imageHeader = base_url('/assets/img/manaber.png');
        $imageFooter = base_url('/assets/img/footer.png');
        $mpdf->showImageErrors = true;
        //    include APPPATH . 'views/report/footer.php';
        $header = view('manaber/header', ['imageHeaderPath' => $imageHeader]);
        $footer = view('manaber/footer', ['imageFooterPath' => $imageFooter]);
        if ($id == '') {
            $mpdf->WriteHTML("<h1 style='font-family: xbriyaz;'>لا توجد بيانات</h1>");
            $mpdf->Output("aid_P.pdf", 'I');
            exit;
        }

        // Set default font
        $mpdf->SetFont('xbriyaz');
        $data['imageHeader'] = $imageHeader;
        // Load views
        //  $footer = view('Report/aid_copon/footer');
        //  $style = file_get_contents(APPPATH . 'views/report/style.php');
        $style = view('manaber/style.php');

        // Construct HTML with simplified structure
        $html = '<!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
        <meta charset="UTF-8">
        <style>
            body { 
                font-family: xbriyaz; 
                direction: rtl;
            }
            table {
                direction: rtl;
                text-align: right;
            }
            td, th {
                text-align: right;
            }
        </style>';

        $html .= $style;
        $html .= '</head>
    <body>';
        $html .= $header;
        $html .= $footer;
        //   $html .= $this->load->view('report/index', $data, true);
        $html .= view('manaber/index', $data);
        // $html .=   file_get_contents(APPPATH . 'view/report/index', $data, true);
        $html .= '</body>
    </html>';
        $mpdf->DefHeaderByName('MyHeader', '');
        $mpdf->DefFooterByName('MyFooter', '');
        //   $this->load->view('report/style', $data);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output("orphan.pdf", 'I');
        ob_end_flush();
        exit;
    }

    /**
     * delete member
     */
    public function deletemember($id, $tab_id = 1, $parent_id = null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if ($this->db->update('user', $data, ['id' => $id])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
            switch ($tab_id) {
                case 5:
                    redirect('member/edit_member/' . $parent_id . '/5');
                    break;
                default:
                    redirect('member/family_show/');
                    break;
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('member/family_show/');
        }

    }

    /**
     *edit member
     */
    public function editmember($id)
    {
        $this->form_validation->set_rules('user_name', 'user_name', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'تعديل معلومات المستخدم';

            $data['param']['member'] = $this->db->get_where('user', ['id' => $id])->row_array();
            $data['viewName'] = 'member/edit_member_light';
            $data['withParam'] = 'y';
            parent::index($data);
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'user_name' => $this->input->post('user_name'),
                'email' => $this->input->post('email'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active')
            ];

            $this->db->update('user', $data, ['id' => $data['id']]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح!</div>');
            redirect('member/datamember/all');
        }
    }

    /**
     * attach
     */
    public function add_attach()
    {

        $this->form_validation->set_rules('user_id', 'User ID', 'required|numeric');
        $this->form_validation->set_rules('attach_type_id', 'attach_type_id Type ID', 'required|numeric');
        $user_id = $this->input->post('user_id');
        if ($this->form_validation->run()) {

            $attach_type_id = $this->input->post('attach_type_id');

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
            if ($file != 'no') {
                //  var_dump($insert_id);die();
                $data = [
                    'user_id' => $user_id,
                    'attach_type_id' => $attach_type_id,
                    'attach_path' => $attach_path . $file,
                    'attach_name' => $file,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
                $this->db->insert('user_attach', $data);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
            redirect('member/edit_member/' . $user_id . '/6');

        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
            redirect('member/edit_member/' . $user_id . '/6');
        }
    }

    public function delete_attach($id, $user_id = null, $tab_id = 6)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        $this->db->update('user_attach', $data, ['attach_id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
        switch ($tab_id) {
            case 1:
                redirect('member/edit_member/' . $user_id . '/6');
                break;
            default:
                redirect('member/edit_member/' . $user_id . '/6');
                break;
        }

    }

    /**
     * contact
     */
    public function add_contact($title = 'سطح المكتب')
    {
        $this->form_validation->set_rules('contact_type', 'contact_type', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('contact_value', 'contact_type', 'required', ['required' => 'حقل واجب الإدخال!']);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة وسيلة اتصال';
            $data['viewName'] = 'member/edit_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
//var_dump($data['param']['DEATH_REASON']);die();
            $data['withParam'] = 'y';
            parent::index($data);
        } else {
            //var_dump($_POST);die();
            $contact_type = $this->input->post('contact_type');
            $contact_value = $this->input->post('contact_value');
            $user_id = $this->input->post('user_id');

            $data = $this->db->get_where('user_contact', ['contact_type ' => $contact_type, 'contact_value ' => $contact_value, 'user_id' => $user_id])->result_array();
            if (count($data) > 0) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            وسيلة الاتصال مدخلة مسبقاً لــ ' . $data[0]['id'] . ' </div>');
                redirect('member/edit_member/' . $user_id . '/2');
            } else {

                $data = [
                    'user_id' => $user_id,
                    'contact_type' => $contact_type,
                    'contact_value' => $contact_value,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->insert('user_contact', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');


                    redirect('member/edit_member/' . $user_id . '/2');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('member/edit_member/' . $user_id . '/2');
                }
            }
        }
    }

    /**
     *delete_member_contact
     */
    public function delete_member_contact($id = null, $user_id = null, $tab_id = '2')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->db->delete('user_contact', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('member/edit_member/' . $user_id . '/2
        ');
    }

    /**
     * dwelling
     */
    public function edit_dwelling($id = null, $tab_id = '3', $title = 'سطح المكتب')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('general_area_id', 'general_area_id', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('dwelling_nature', 'dwelling_nature', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('dwelling_damage', 'dwelling_damage', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('current_residence_status', 'current_residence_status', 'required', ['required' => 'حقل واجب الإدخال!']);
//$this->form_validation->set_rules('current_residence', 'current_residence', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('governorate', 'governorate', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('mosque', 'mosque', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('detailed_original_housing_address', 'detailed_original_housing_address', 'required', ['required' => 'حقل واجب الإدخال!']);
//$this->form_validation->set_rules('nearest_famous_place', 'nearest_famous_place', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('city_id', 'city_id', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('local_area_id', 'local_area_id', 'required', ['required' => 'حقل واجب الإدخال!']);
        $this->form_validation->set_rules('valley_side', 'valley_side', 'required', ['required' => 'حقل واجب الإدخال!']);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {

            $data['viewName'] = 'member/edit_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
            $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
            $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
            $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
            $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
            $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();

            $datap = $this->db->get_where('user', ['id' => $id])->row_array();
            $data['title'] = 'تعديل بيانات  ' . $datap['name'];
            $data['param']['user_row'] = $datap;

            $join_array = array(
                array(
                    'table_name' => 'constants',
                    'condition' => 'user_contact.contact_type = constants.id'
                ),
            );
            $dataContacts = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, '  user_contact.deleted_by  is  null ', 'user_contact.id asc');

            $data['param']['tab_id'] = $tab_id;
            $data['param']['contacts'] = $dataContacts;
            $data['param']['js_file'][0] = '\assets\custom\tab_manage.js';
            $data['param']['js_file'][1] = '\assets\custom\member.js';
            $data['withParam'] = 'y';
            parent::index($data);
        } else {
            $data = [
                'dwelling_nature_id' => $this->input->post('dwelling_nature'),
                'dwelling_damage_id' => $this->input->post('dwelling_damage'),
                'current_governorate_id' => $this->input->post('current_governorate_id'),
                'current_residence_status_id' => $this->input->post('current_residence_status'),
                'current_residence' => $this->input->post('current_residence'),
                'mosque' => $this->input->post('mosque'),
                'detailed_original_housing_address' => $this->input->post('detailed_original_housing_address'),
                'governorate_id' => $this->input->post('governorate'),
                'city_id' => $this->input->post('city_id'),
                'general_area_id' => $this->input->post('general_area_id'),
                'local_area_id' => $this->input->post('local_area_id'),
                'nearest_famous_place' => $this->input->post('nearest_famous_place'),
                'valley_side_id' => $this->input->post('valley_side'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            // var_dump($data);die();
            if ($this->db->update('user', $data, ['id' => $id])) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                redirect('member/edit_member/' . $id . '/' . $tab_id);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');

            }
        }
    }

    /**
     * objectToArray
     */
    private function objectToArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }


// Function to get the children based on parent_id

    public function get_general_area()
    {
        $id = $this->input->post('city_id');
        $mod = $this->input->post('mode');
        $data = '';
        if ($mod == 1) {
            $data = $this->db->where_in('gov_id', $id)
                ->get('general_area')
                ->result_array();
        } else {
            $data = $this->db->get_where('general_area', ['city_id' => $id])->result_array();
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_local_area()
    {
        $id = $this->input->post('general_area_id');
        $mod = $this->input->post('mode');
        $data = '';
        if ($mod == 1) {
            $data = $this->db->where_in('general_area_id', $id)
                ->get('local_area')
                ->result_array();
        } else {
            $data = $this->db->get_where('local_area', ['general_area_id' => $id])->result_array();
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_landmark()
    {
        $id = $this->input->post('placeID');
        $mod = $this->input->post('mode');
        $data = '';
        if ($mod == 1) {
            $data = $this->db->where_in('local_area_id', $id)
                ->get('landmark')
                ->result_array();
        } else {
            $data = $this->db->get_where('landmark', ['local_area_id' => $id])->result_array();
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function printfamily($id = null)
    {
        $user = $this->db->get_where('user', ['id' => $id])->row_array();
//         var_dump($user);die;
        if ($user) {
            // var_dump($user);die();
            $data['user'] = $user;

            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.maretal_status_id = c.id'
                )
            );

            $wives = $this->Base_model->get_with_join(
                'user.*,
                c.title AS maretal_status',
                'user',
                $join_array,
                'user.huspand_user_id=' . $id . ' AND user.deleted_by IS NULL',
                'user.id ASC'
            );

            $data['wives'] = $wives;
//             var_dump($wives);die();

            $join_array = array(
                array(
                    'table_name' => 'constants c',
                    'condition' => 'user.user_status_id = c.id'
                ),
                array(
                    'table_name' => 'constants cw',
                    'condition' => 'user.naturalwork_id = cw.id'
                ),
                array(
                    'table_name' => 'constants maretal',
                    'condition' => 'user.maretal_status_id = maretal.id'
                ),
                array(
                    'table_name' => 'constants governorate',
                    'condition' => 'user.governorate_id = governorate.id'
                ),
                array(
                    'table_name' => 'constants city',
                    'condition' => 'user.city_id = city.id'
                ),
                array(
                    'table_name' => 'general_area',
                    'condition' => 'user.general_area_id = general_area.id'
                ),
                array(
                    'table_name' => 'constants r',
                    'condition' => 'user.death_reason_id = r.id'
                ),
                array(
                    'table_name' => 'local_area',
                    'condition' => 'user.local_area_id = local_area.id'
                ),
                array(
                    'table_name' => 'landmark',
                    'condition' => 'user.nearest_famous_place = landmark.id'
                ),
                array(
                    'table_name' => 'constants dwelling',
                    'condition' => 'user.dwelling_nature_id = dwelling.id'
                ),
                array(
                    'table_name' => 'constants damage',
                    'condition' => 'user.dwelling_damage_id = damage.id'
                ),
                array(
                    'table_name' => 'constants valley',
                    'condition' => 'user.valley_side_id = valley.id'
                ),
                array(
                    'table_name' => 'constants residence',
                    'condition' => 'user.current_residence_status_id = residence.id'
                ),
            );

            $residance = $this->Base_model->get_with_join(
                'user.*,
                c.title AS status_title,
                valley.title AS valley_title,
                residence.title AS residence_title,
                landmark.title AS landmark_title,
                damage.title AS damage_title,
                dwelling.title AS dwelling_title,
                governorate.title AS governorate_name,
                city.title AS city_name,
                general_area.title AS area_name,
                local_area.title AS local_name,
                cw.title AS work_name,
                maretal.title AS maretal_name,
                r.title AS reason_title',
                'user',
                $join_array,
                'user.id=' . $id . ' AND user.deleted_by IS NULL',
                'user.id ASC'
            );


            $data['residance'] = $residance[0];
            $join_array = array(
                array(
                    'table_name' => 'constants',
                    'condition' => 'user_contact.contact_type = constants.id'
                ),
            );
            $contact = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, ' user_contact.user_id=' . $id . ' and  user_contact.deleted_by  is  null ', 'user_contact.id asc');
            $data['contact'] = $contact;


            $join_array = array(
                array(
                    'table_name' => 'constants disabilityC',
                    'condition' => 'user.last_disability_status = disabilityC.id '
                ),
                array(
                    'table_name' => 'constants eduC',
                    'condition' => 'user.last_edu_status = eduC.id '
                ),
                array(
                    'table_name' => 'constants healthC',
                    'condition' => 'user.last_health_status = healthC.id '
                ),

            );
            $childrenData = $this->Base_model->get_with_join('user.*,user.id as uid, eduC.title as edu_status, disabilityC.title as disability_status, healthC.title as health_status',
                'user', $join_array, '  user.deleted_by  is  null and user.parent_user_id=' . $id,
                'user.id asc');

            $data['children'] = $childrenData;


        }
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);
        ob_start();
        $config = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'xbriyaz',
            'margin_left' => 15,
            'margin_right' => 15,
            'margin_top' => 15,
            'margin_bottom' => 0,
            'margin_header' => 10,
            'margin_footer' => 0,
            'setAutoTopMargin' => false,  // Change this to false
            'autoMarginPadding' => 0     // Add this line
        ];

// Create mPDF instance with simplified configuration
        $mpdf = new \Mpdf\Mpdf($config);

// These lines should come right after creating the instance
        $mpdf->SetHTMLHeader('');    // Set empty header
        $mpdf->SetTopMargin(15);      // Force top margin to 0
        $mpdf->SetDirectionality('rtl');
        $mpdf->useAdobeCJK = true;
        $mpdf->SetDisplayMode('fullpage');
        // Load header image
        $imageHeader = base_url('/assets/img/right-logo.png');
        $mpdf->showImageErrors = true;
        /* $header = file_get_contents(APPPATH . 'view/report/header', ['imageHeaderPath' => $imageHeader]);
         $footer =  file_get_contents(APPPATH . 'view/report/footer');*/

        $header = '';
        //  include APPPATH . 'views/report/header.php';

        $footer = '';
        //    include APPPATH . 'views/report/footer.php';
        $header = view('report/header', ['imageHeaderPath' => $imageHeader]);
        $footer = view('report/footer');
        if ($id == '') {
            $mpdf->WriteHTML("<h1 style='font-family: xbriyaz;'>لا توجد بيانات</h1>");
            $mpdf->Output("aid_P.pdf", 'I');
            exit;
        }

        // Set default font
        $mpdf->SetFont('xbriyaz');
        $data['imageHeader'] = $imageHeader;
        // Load views
        //  $footer = view('Report/aid_copon/footer');
        //  $style = file_get_contents(APPPATH . 'views/report/style.php');
        $style = view('report/style.php');

        // Construct HTML with simplified structure
        $html = '<!DOCTYPE html>
        <html dir="rtl" lang="ar">
        <head>
        <meta charset="UTF-8">
        <style>
            body { 
                font-family: xbriyaz; 
                direction: rtl;
            }
            table {
                direction: rtl;
                text-align: right;
            }
            td, th {
                text-align: right;
            }
        </style>';

        $html .= $style;
        $html .= '</head>
    <body>';
        $html .= $header;
        $html .= $footer;
        //   $html .= $this->load->view('report/index', $data, true);
        $html .= view('report/print_family', $data);
        // $html .=   file_get_contents(APPPATH . 'view/report/index', $data, true);
        $html .= '</body>
    </html>';
        $mpdf->DefHeaderByName('MyHeader', '');
        $mpdf->DefFooterByName('MyFooter', '');
        //   $this->load->view('report/style', $data);
        $mpdf->WriteHTML($html);

        // Output PDF
        $mpdf->Output("family-" . $user['full_name'] . ".pdf", 'I');
        ob_end_flush();
        exit;
    }

    public function check_identity_is_member()
    {
        $identity = $this->input->post('identity');
        $data = $this->db->get_where('user', ['identity ' => $identity,])->result_array();
        if (count($data) > 0) {
            $response = [
                'status' => 1,
                'message' => 'رقم الهوية مدخل مسبقاً لــ  ' . $data[0]['full_name'],
            ];
        } else {
            $response = [
                'status' => 0,
                'message' => 'رقم الهوية غير موجود كأسرة',
            ];
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }

}