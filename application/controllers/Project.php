<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($title='سطح المكتب')
    {
        $data['title']='المشاريع';
        $data['viewName']='project/index';
        $data['param']['supporting_bodies'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
        $datap[]=array();
        $datap=$this->db->get_where('project_master', ['deleted_by' =>NULL])->result_array();

        //var_dump($datap);die();
        foreach ($datap as &$person) {
            $person['support_name']  =$this->db->get_where('constants', ['id' => $person['support_id']])->result_array()[0]['title'];
            $proj_fk=$person['project_id'];
            $result=$this->db->get_where('project_support', ['deleted_by' =>NULL,'project_fk'=>$person['project_id']])->result_array();
//var_dump($result);
            $support_types = array();
        $sum_stage=0;
        if($result)
        if (count($result)> 0) {
            foreach ($result as &$row) {
           // while ($row = $result->fetch_assoc()) {
                $support_types[] = $this->db->get_where('constants', ['id' => $row['support_fk']])->result_array()[0]['title'];
                $sum_stage+=$row['unit_value'];
            }

        }
// Concatenate rows into a single string
            $person['support_type'] = implode(', ', $support_types);
          //  $person['project_id']  = $this->encryption->encrypt($person['project_id']);
        }
        $project_stages=$this->db->get_where('project_stages', ['deleted_by' =>NULL,'proj_fk' =>$proj_fk])->result_array();
        $data['param']['sum_stage'] =$sum_stage;
        $data['param']['rows'] =$datap;
        $data['param']['project_stages'] =$project_stages;
        $data['param']['js_file'][0] ='\assets\custom\project.js';
        $data['param']['js_file'][1] ='\assets\custom\tag_input.js';
        $data['withParam']='y';

        parent::index($data);
    }
//add_project
    public function add_project()
    {
        $this->form_validation->set_rules('support_id', 'support_id', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('exchange_value', 'exchange_value', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_value', 'approved_value', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_amount', 'approved_amount', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_date', 'approved_date', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        //var_dump($_POST);
        // var_dump($this->session->userdata());die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة مشروع';
            $data['viewName']='project/index';
            $data['withParam']='n';


        } else {
            $data = [
                'support_id' => $this->input->post('support_id'),
                'exchange_value' => $this->input->post('exchange_value'),
                'approved_value' => $this->input->post('approved_value'),
                'approved_amount' => $this->input->post('approved_amount'),
                'approved_date' => $this->input->post('approved_date'),
                'received_from_sponsor' => $this->input->post('received_from_sponsor'),
                'remain_from_sponsor' => $this->input->post('remain_from_sponsor'),
                'notes' => $this->input->post('notes'),

                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            if($this->db->insert('project_master',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة بنجاح</div>');
                redirect('project/edit_project/'.$this->db->insert_id());
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشلت الاضافة</div>');
                redirect('project');
            }

        }


        parent::index($data);
    }

    public function edit_project($id=null,$tab_id='project',$title='سطح المكتب')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة للمشروع، اختر المشروع لتتمكن من تعديله';
            $data['return'] = 'project/supplier';
            $this->load->view('error_custom', $data);
            return;
        }
        //var_dump($id);
        $this->form_validation->set_rules('support_id', 'support_id', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('exchange_value', 'exchange_value', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_value', 'approved_value', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_amount', 'approved_amount', 'required', ['required' => 'حقل  واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_date', 'approved_date', 'required', ['required' => 'حقل  واجب الإدخال!' ]);

        if ($this->form_validation->run() == false) {
            $data['viewName']='project/edit_project';
            $project_id= $id;
            $data['param']['supporting_bodies'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
            $data['param']['support_type'] = (array)$this->db->get_where('constants', ['parent_id' => RELIEF])->result_array();
            $res= (array)$this->db->get_where('project_support', ['project_fk' => $project_id])->result_array();

            $sum_stage = 0;

           /* while ($row = current($res)) { // Fetch the current element
                $sum_stage += $row['unit_value'];
                next($res); // Move to the next element
            }*/
            $project_supply= (array)$this->db->get_where('project_supply', ['proj_fk' => $project_id])->result_array();
           // var_dump($project_supply);
            foreach ($project_supply as &$re) {
                $re['supplier_name'] = $this->db->get_where('supplier', ['supplier_id' => $re['supplier_fk']])->result_array()[0]['supplier_name'];
                $rePS = $this->db->get_where('project_support', ['ps_id' => $re['ps_fk']])->result_array()[0];
                $re['support_name'] = $this->db->get_where('constants', ['id' => $rePS['support_fk']])->result_array()[0]['title'];
                $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'supplier_fk' =>$re['supplier_fk'],'ps_fk' =>$re['ps_fk']])->result_array();
                // $array = json_decode($project_supply, true);
                $sum_paid_amount = 0;
                if (is_array($rowPays)) {
                    foreach ($rowPays as $r) {
                        if (is_array($r)) {
                            $sum_paid_amount += $r['invoice_value'];
                        }
                    }
                    $re['remaining_amount']= $sum_paid_amount;
                }

            }
           //  var_dump($project_supply);
            $data['param']['project_supply'] =$project_supply;

            $project_stages= (array)$this->db->get_where('project_stages', ['proj_fk' => $project_id])->result_array();
            foreach ($project_stages as &$re) {
                $rePS = $this->db->get_where('project_support', ['ps_id' => $re['ps_fk']])->result_array()[0];
                $re['support_name'] = $this->db->get_where('constants', ['id' => $rePS['support_fk']])->result_array()[0]['title'];
            }
            $data['param']['project_stages'] =$project_stages;
            $sum_unit_value=0;
            foreach ($res as &$re) {
                $re['support_name'] = $this->db->get_where('constants', ['id' => $re['support_fk']])->result_array()[0]['title'];
                $re['target_name'] = $this->get_targt_names($re['ps_id']);
                $sum_unit_value+=$re['unit_value'];
            }
            $data['param']['project_support']=$res;

            $row= $this->db->get_where('project_master', ['project_id' => $project_id])->row_array();
            $row['support_project_name']= $this->db->get_where('constants', ['id' => $row['support_id']])->result_array()[0]['title'];
            $data['title'] = 'تعديل بيانات مشروع مقدم من '.' '.$row['support_project_name'];

            $data['param']['row'] =$row;
            $data['param']['tab_id'] =$tab_id;
            $data['param']['sum_stage'] =$sum_unit_value;
            $data['param']['sum_unit_value'] =$sum_unit_value;
            $data['withParam']='y';
            $data['param']['js_file'][0] ='\assets\custom\project.js';
            $data['param']['js_file'][1] ='\assets\custom\tab_manage.js';
            $data['param']['js_file'][2] ='\assets\custom\tag_input.js';
        } else {
            $data = [
                'support_id' => $this->input->post('support_id'),
                'exchange_value' => $this->input->post('exchange_value'),
                'approved_value' => $this->input->post('approved_value'),
                'approved_amount' => $this->input->post('approved_amount'),
                'approved_date' => $this->input->post('approved_date'),
                'received_from_sponsor' => $this->input->post('received_from_sponsor'),
                'remain_from_sponsor' => $this->input->post('remain_from_sponsor'),
                'notes' => $this->input->post('notes'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
          // var_dump($data);die();
            $decoded_data = urldecode($id);
            //  var_dump($decoded_data);
            $project_id= $this->encryption->decrypt($decoded_data);
            $project_id=$this->input->post('project_id');
            // var_dump($supplier_id);die();
            if($this->db->update('project_master',$data,['project_id' => $project_id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح</div>');
                redirect('project/edit_project/'.$project_id);
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('project');
            }

        }


        parent::index($data);
    }

    public function print_project($id=null){
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة للمشروع، اختر المشروع لتتمكن من تعديله';
            $data['return'] = 'project/supplier';
            $this->load->view('error_custom', $data);
            return;
        }
        $project_supports=$res= (array)$this->db->get_where('project_support', ['project_fk' => $id])->result_array();
        $project_supply= (array)$this->db->get_where('project_supply', ['proj_fk' => $id])->result_array();

        foreach ($project_supply as &$re) {
            $re['supplier_name'] = $this->db->get_where('supplier', ['supplier_id' => $re['supplier_fk']])->result_array()[0]['supplier_name'];
            $rePS = $this->db->get_where('project_support', ['ps_id' => $re['ps_fk']])->result_array()[0];
            $re['support_name'] = $this->db->get_where('constants', ['id' => $rePS['support_fk']])->result_array()[0]['title'];
            $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'supplier_fk' =>$re['supplier_fk'],'ps_fk' =>$re['ps_fk']])->result_array();
            // $array = json_decode($project_supply, true);
            $sum_paid_amount = 0;
            if (is_array($rowPays)) {
                foreach ($rowPays as $r) {
                    if (is_array($r)) {
                        $sum_paid_amount += $r['invoice_value'];
                    }
                }
                $re['remaining_amount']= $sum_paid_amount;
            }

        }

        $data['param']['project_supply'] =$project_supply;
        $data['param']['project_supports'] =$project_supports;
        $project_stages= (array)$this->db->get_where('project_stages', ['proj_fk' => $id])->result_array();
        foreach ($project_stages as &$re) {
            $rePS = $this->db->get_where('project_support', ['ps_id' => $re['ps_fk']])->result_array()[0];
            $re['support_name'] = $this->db->get_where('constants', ['id' => $rePS['support_fk']])->result_array()[0]['title'];
        }
        $data['param']['project_stages'] =$project_stages;
        $sum_unit_value=0;
        foreach ($res as &$re) {
            $re['support_name'] = $this->db->get_where('constants', ['id' => $re['support_fk']])->result_array()[0]['title'];
            $re['target_name'] = $this->get_targt_names($re['ps_id']);
            $sum_unit_value+=$re['unit_value'];
        }
        $data['param']['project_support']=$res;

        $row= $this->db->get_where('project_master', ['project_id' => $id])->row_array();
        $row['support_project_name']= $this->db->get_where('constants', ['id' => $row['support_id']])->result_array()[0]['title'];
        $data['title'] = 'تعديل بيانات مشروع مقدم من '.' '.$row['support_project_name'];
        $data['param']['supporting_bodies'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();

        $data['param']['row'] =$row;
        $data['param']['sum_stage'] =$sum_unit_value;
        $data['param']['sum_unit_value'] =$sum_unit_value;
        $data['param']['js_file'][0] ='\assets\custom\print_proj.js';
        $data['viewName']='project/print_project';
        $data['withParam']='y';

        parent::index($data);

    }
    /**SUPPORT*/
    public function get_targt_names($ps_id){
        $data = (array)$this->db->get_where('project_support', ['ps_id' => $ps_id])->result_array()[0];
        //  var_dump($data);
        $target_array = explode(',', $data['proj_target']);
        $target_name='';
        //   var_dump($data['proj_target']);
        $target_tags=array();
        foreach ($target_array as &$target){
            $r=$this->db->get_where('constants', ['id' => $target])->result_array()[0]['title'];
            $target_name.=$r;
            $temp['id']=$target;
            $temp['title']=$r;
            array_push($target_tags,$temp);
            if ($target === end($target_array)) {
                $target_name.='';
            } else {
                $target_name.=',';
            }
        }
        $data['target_name']=$target_name;
        $data['target_data']=$target_tags;
        return $target_name;
    }

    public function get_targets_tags(){
        $data = (array)$this->db->get_where('constants', ['parent_id' => TARGET_GROUPS])->result_array();

        echo json_encode($data);
    }

    public function add_edit_support($title='سطح المكتب')
    {
        $this->form_validation->set_rules('support_fk', 'support_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('approved_support_amount', 'approved_support_amount', 'required', ['required' => 'حقل واجب الإدخال!' ]);
      //  $this->form_validation->set_rules('input-tag', 'input-tag', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        //var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة نوع الدعم';
            $data['viewName'] = 'project/edit_project';
            $data['param']['supporting_bodies'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
            $data['param']['support_type'] = (array)$this->db->get_where('constants', ['parent_id' => RELIEF])->result_array();
            $data['param']['values'] = (array)$this->db->get_where('constants', ['parent_id' => TARGET_GROUPS])->result_array();
            $data['withParam']='y';
            parent::index($data);
        }else{

            $tags_data=$this->objectToArray($this->input->post('tags-data'));
            // Convert JSON string to PHP array
            $array = json_decode($tags_data, true);

            // Check if decoding was successful
            if (json_last_error() === JSON_ERROR_NONE) {
                // Successfully decoded, you can use the array
                $ids = array_column($array, 'id');
                $idsString = implode(',', $ids);
            } else {
                // Handle error
                echo 'JSON decoding error: ' . json_last_error_msg();
            }
            $support_fk=$this->input->post('support_fk');
            $measure_unit=$this->input->post('measure_unit');
            $project_id=$this->input->post('project_id');
            $unit_amount=$this->input->post('unit_amount');
            $unit_price=$this->input->post('unit_price');
            $unit_value=$this->input->post('unit_value');
            $approved_support_amount=$this->input->post('approved_support_amount');
            $ps_id =$this->input->post('ps_id');
            $proj_target=$idsString;
            if($ps_id){
                $data = [
                    'support_fk' => $support_fk,
                    'measure_unit' => $measure_unit,
                    'unit_amount' => $unit_amount,
                    'unit_price' => $unit_price,
                    'unit_value' => $unit_value,
                    'proj_target' => $proj_target,
                    'approved_support_amount' => $approved_support_amount,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                  //var_dump($data);die();
                if ($this->db->update('project_support', $data,['ps_id'=>$ps_id ])) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                    redirect('project/edit_project/'.$project_id.'/2');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/edit_project/'.$project_id.'/2');
                }
            }else {
                $data = [
                    'project_fk' => $project_id,
                    'support_fk' => $support_fk,
                    'measure_unit' => $measure_unit,
                    'unit_amount' => $unit_amount,
                    'unit_price' => $unit_price,
                    'unit_value' => $unit_value,
                    'proj_target' => $proj_target,
                    'approved_support_amount' => $approved_support_amount,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->insert('project_support', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                    redirect('project/edit_project/'.$project_id.'/2');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/edit_project/'.$project_id.'/2');
                }
            }
        }
    }

    public function details_support($ps_id){
        $data = (array)$this->db->get_where('project_support', ['ps_id' => $ps_id])->result_array()[0];
        //  var_dump($data);
        $target_array = explode(',', $data['proj_target']);
        $target_name='';
        //   var_dump($data['proj_target']);
        $target_tags=array();
        foreach ($target_array as &$target){
            $r=$this->db->get_where('constants', ['id' => $target])->result_array()[0]['title'];
            $target_name.=$r;
            $temp['id']=$target;
            $temp['title']=$r;
            array_push($target_tags,$temp);
            if ($target === end($target_array)) {
                $target_name.='';
            } else {
                $target_name.=',';
            }
        }
        $data['target_name']=$target_name;
        $data['target_data']=$target_tags;
        // var_dump($data);
        echo json_encode($data);
    }

    public function delete_support($id,$proj_id,$tab_id='support')
    {
        $this->db->delete('project_support', ['ps_id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('project/edit_project/'.$proj_id.'/2');
    }
/****supplier_payments**********/
    public function add_edit_supply_pay($proj_supply_id=null,$title='سطح المكتب'){
        if ($proj_supply_id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة مختارة، اختر المشروع  لتتمكن من التعديل';
            $data['return'] = 'project';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('sp_supplier_date', 'sp_supplier_date', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('proj_fk', 'proj_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('ps_fk', 'ps_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('supplier_invoice', 'supplier_invoice', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('invoice_value', 'invoice_value', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('receipt_no', 'receipt_no', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('remaining_value', 'remaining_value', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['viewName'] = 'project/project_supply_pay';
            $data['withParam']='y';
            $join_array = array(
                array(
                    'table_name' => 'supplier',
                    'condition' => 'supplier.supplier_id = project_supply.supplier_fk'
                ),
                array(
                    'table_name' => 'project_master',
                    'condition' => 'project_master.project_id  = project_supply.proj_fk '
                ),
                array(
                    'table_name' => 'constants pms',
                    'condition' => 'project_master.support_id  = pms.id '
                ),
                array(
                    'table_name' => 'project_support',
                    'condition' => 'project_supply.ps_fk  = project_support.ps_id '
                ),
                array(
                    'table_name' => 'constants psk',
                    'condition' => 'project_support.support_fk  = psk.id '
                ),
            );
             $resArray= $this->Base_model->get_with_join('project_supply.*,supplier.*,psk.title as support_name,pms.title as associaton_name',
                'project_supply', $join_array, '  project_supply.deleted_by  is  null and proj_supply_id='.$proj_supply_id,
                'supplier.supplier_id asc');
            $project_supply=$resArray[0];
             //var_dump($resArray);die();
            $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'supplier_fk' =>$project_supply['supplier_fk'],'ps_fk' =>$project_supply['ps_fk']])->result_array();
           // $array = json_decode($project_supply, true);

            if (is_array($rowPays)) {
                $sum_paid_amount = 0;
                foreach ($rowPays as $r) {
                    if (is_array($r)) {
                        $sum_paid_amount += $r['invoice_value'];
                    }
                }
              //  echo "إجمالي المبلغ المدفوع: " . $sum_paid_amount;
            } else {
               // echo "Error: \$project_supply is not an array.";
            }
            $remaining_amount = 0;
          /*  if (is_array($rowPays)) {
                foreach ($rowPays as $r) {
                    if (is_array($r)) {
                        $sum_paid_amount += $r['invoice_value'];
                    }
                }
                $re['remaining_amount']= $sum_paid_amount;
            }*/
//var_dump($project_supply);die();
            $data['param']['row'] =$project_supply;
            $data['param']['sum_paid_amount'] =$sum_paid_amount;
            $data['param']['remaining_amount'] =$remaining_amount;
            $data['param']['rowPays'] =$rowPays;
            $data['param']['project_supply'] =$project_supply;
            $data['title'] = 'إضافة مديونية للمورد '.' '.$project_supply['supplier_name'];
            $data['sub_title']='الدعم المقدم من '.$project_supply['associaton_name'].' ل'.$project_supply['support_name'];
            $data['param']['js_file'][0] ='\assets\custom\payment.js';
            // var_dump( $data['sub_title']);
            parent::index($data);
        }else{
            $sp_supplier_date=$this->input->post('sp_supplier_date');
            $support_fk=$this->input->post('support_fk');
            $supplier_invoice=$this->input->post('supplier_invoice');
            $invoice_value=$this->input->post('invoice_value');
            $receipt_no=$this->input->post('receipt_no');
            $remaining_value=$this->input->post('remaining_value');
            $ps_fk =$this->input->post('ps_fk');
            $proj_fk =$this->input->post('proj_fk');
            $sp_id =$this->input->post('sp_id');
            $supplier_fk  =$this->input->post('supplier_fk');
            $notes  =$this->input->post('notes');
         //   var_dump($_POST);die();
            if($sp_id){
                $data = [
                    'sp_supplier_date' => $sp_supplier_date,
                    'supplier_invoice' => $supplier_invoice,
                    'invoice_value' => $invoice_value,
                    'receipt_no' => $receipt_no,
                    'remaining_value' => $remaining_value,
                    'notes' => $notes,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->update('supplier_payments', $data,['sp_id'=>$sp_id ])) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                    redirect('project/add_edit_supply_pay/'.$proj_supply_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/add_edit_supply_pay/'.$proj_supply_id);
                }
            }else {
                $data = [
                    'sp_supplier_date' => $sp_supplier_date,
                    'ps_fk' => $ps_fk,
                    'proj_fk' => $proj_fk,
                    'support_fk' => $support_fk,
                    'supplier_fk' => $supplier_fk,
                    'supplier_invoice' => $supplier_invoice,
                    'invoice_value' => $invoice_value,
                    'receipt_no' => $receipt_no,
                    'remaining_value' => $remaining_value,
                    'notes' => $notes,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
                 // var_dump($data);die();
                if ($this->db->insert('supplier_payments', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                    redirect('project/add_edit_supply_pay/'.$proj_supply_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                    redirect('project/add_edit_supply_pay/'.$proj_supply_id);
                }
            }
        }
    }

    public function details_supply_pay($sp_id){
        $data = (array)$this->db->get_where('supplier_payments', ['sp_id ' => $sp_id ])->result_array()[0];
        echo json_encode($data);
    }

    public function delete_supply_pay($id,$ps_id)
    {
        $this->db->delete('supplier_payments', ['sp_id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('project/add_edit_supply_pay/'.$ps_id);
    }
    /*******SUPPLY******/
    public function add_edit_supply($project_id=null,$ps_id=null,$title='سطح المكتب'){
        if ($project_id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة مختارة، اختر المشروع والدعم لتتمكن من التعديل';
            $data['return'] = 'project';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('supplier_date', 'supplier_date', 'required', ['required' => 'حقل واجب الإدخال!' ]);
      //  $this->form_validation->set_rules('supplier_invoice', 'supplier_invoice', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('proj_fk', 'proj_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('ps_fk', 'ps_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('supplier_paid_amount', 'supplier_paid_amount', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['viewName'] = 'project/project_supply';
            $data['withParam']='y';
            $data['param']['suppliers'] = (array)$this->db->get_where('supplier', ['deleted_by' => NULL])->result_array();

            $row= $this->db->get_where('project_master', ['project_id' => $project_id])->row_array();
            $rowSupport = (array)$this->db->get_where('project_support', ['ps_id' => $ps_id])->result_array()[0];
            $project_supply=$this->db->get_where('project_supply', ['deleted_by' =>NULL,'proj_fk' =>$project_id,'ps_fk' =>$ps_id])->result_array();
            $project_stages=$this->db->get_where('project_stages', ['deleted_by' =>NULL,'proj_fk' =>$project_id,'ps_fk' =>$ps_id])->result_array();

            if(count($project_stages)>0){
                $project_stage=$project_stages[0];
            }else
                $project_stage =array();
            foreach ($project_supply as &$re) {
                $re['supplier_name']  = $this->db->get_where('supplier', ['supplier_id' => $re['supplier_fk']])->result_array()[0]['supplier_name'] ;
            }

            $support_fk=$rowSupport['support_fk'];
            $support_name= $this->db->get_where('constants', ['id' => $rowSupport['support_fk']])->result_array()[0]['title'];

            $support_project_name= $this->db->get_where('constants', ['id' => $row['support_id']])->result_array()[0]['title'];
            $data['param']['row'] =$row;
            $data['param']['rowSupport'] =$rowSupport;
            $data['param']['rowStage'] =$project_stage;
            $data['param']['project_supply'] =$project_supply;
            $data['title'] = 'إضافة توريد لمشروع مقدم من '.' '.$support_project_name;
            $data['sub_title']='الدعم المقدم ل '.$support_name;
            $data['param']['js_file'][0] ='\assets\custom\supply.js';
            // var_dump( $data['sub_title']);
            parent::index($data);
        }else{
            $supplier_date=$this->input->post('supplier_date');
            $support_fk=$this->input->post('support_fk');
         //   $supplier_invoice=$this->input->post('supplier_invoice');
            $supplier_paid_amount=$this->input->post('supplier_paid_amount');
          //  $remaining_amount=$this->input->post('remaining_amount');
            $ps_fk =$this->input->post('ps_fk');
            $proj_fk =$this->input->post('proj_fk');
            $proj_supply_id =$this->input->post('proj_supply_id');
            $supplier_fk  =$this->input->post('supplier_fk');
            $notes  =$this->input->post('notes');
            if($proj_supply_id){
                $data = [
                    'supplier_date' => $supplier_date,
                    'support_fk' => $support_fk,
                  //  'supplier_invoice' => $supplier_invoice,
                    'supplier_fk' => $supplier_fk,
                    'supplier_paid_amount' => $supplier_paid_amount,
                  //  'receipt_no' => $receipt_no,
               //     'remaining_amount' => $remaining_amount,
                    'notes' => $notes,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->update('project_supply', $data,['proj_supply_id'=>$proj_supply_id ])) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                    redirect('project/add_edit_supply/'.$project_id.'/'.$ps_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/add_edit_supply/'.$project_id.'/'.$ps_id);
                }
            }else {
                $data = [
                    'ps_fk' => $ps_fk,
                    'proj_fk' => $proj_fk,
                    'support_fk' => $support_fk,
                    'supplier_date' => $supplier_date,
                //    'supplier_invoice' => $supplier_invoice,
                    'supplier_fk' => $supplier_fk,
                    'supplier_paid_amount' => $supplier_paid_amount,
               //     'receipt_no' => $receipt_no,
                   // 'remaining_amount' => $remaining_amount,
                    'notes' => $notes,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->insert('project_supply', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                    redirect('project/add_edit_supply/'.$project_id.'/'.$ps_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الاضافة</div>');
                    redirect('project/add_edit_supply/'.$project_id.'/'.$ps_id);
                }
            }
        }
    }

    public function details_supply($proj_supply_id){
        $data = (array)$this->db->get_where('project_supply', ['proj_supply_id ' => $proj_supply_id ])->result_array()[0];
        echo json_encode($data);
    }

    public function delete_supply($id,$proj_id,$ps_id)
    {
        $this->db->delete('project_supply', ['proj_supply_id ' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('project/add_edit_supply/'.$proj_id.'/'.$ps_id);
    }
    /*******STAGE******/

    public function add_edit_stage($project_id=null,$ps_id=null,$title='سطح المكتب'){
        if ($project_id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة مختارة، اختر المشروع والدعم لتتمكن من التعديل';
            $data['return'] = 'project';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('unit_amount_actual', 'unit_amount_actual', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('unit_actual_price', 'unit_actual_price', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('proj_fk', 'proj_fk', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('unit_value_actual', 'unit_value_actual', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('total_executed', 'total_executed', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('executed_value', 'executed_value', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('association_share', 'association_share', 'required', ['required' => 'حقل واجب الإدخال!' ]);

       // var_dump($this->form_validation->run());

        if ($this->form_validation->run() == false) {
            $datap[]=array();

          //  $data['viewName'] = 'project/edit_project';
            $data['viewName'] = 'project/project_stages';
            $data['withParam']='y';

            $row= $this->db->get_where('project_master', ['project_id' => $project_id])->row_array();
            $rowSupport = (array)$this->db->get_where('project_support', ['ps_id' => $ps_id])->result_array()[0];
            $project_stages=$this->db->get_where('project_stages', ['deleted_by' =>NULL,'proj_fk' =>$project_id,'ps_fk' =>$ps_id])->result_array();
            $support_name= $this->db->get_where('constants', ['id' => $rowSupport['support_fk']])->result_array()[0]['title'];
            $support_project_name= $this->db->get_where('constants', ['id' => $row['support_id']])->result_array()[0]['title'];
            //var_dump($project_stages);die();
            $data['param']['row'] =$row;
            $data['param']['rowSupport'] =$rowSupport;
            $data['param']['project_stages'] =$project_stages;
            $data['title'] = 'إضافة مرحلة تنفيذ لمشروع مقدم من '.' '.$support_project_name;
            $data['sub_title']='الدعم المقدم ل '.$support_name;
            $data['param']['js_file'][0] ='\assets\custom\stages.js';
            // var_dump( $data['sub_title']);
            parent::index($data);
        }else{
            $unit_value_actual=$this->input->post('unit_value_actual');
            $unit_actual_price=$this->input->post('unit_actual_price');
            $unit_amount_actual=$this->input->post('unit_amount_actual');
            $total_executed=$this->input->post('total_executed');
            $executed_value=$this->input->post('executed_value');
            $ps_fk =$this->input->post('ps_fk');
            $proj_fk =$this->input->post('proj_fk');
            $proj_stage_id  =$this->input->post('proj_stage_id');
            $association_share  =$this->input->post('association_share');

            if($proj_stage_id>0){
                $data = [
                    'unit_amount_actual' => $unit_amount_actual,
                    'unit_actual_price' => $unit_actual_price,
                    'unit_value_actual' => $unit_value_actual,
                    'total_executed' => $total_executed,
                    'executed_value' => $executed_value,
                    'association_share' => $association_share,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
                if ($this->db->update('project_stages', $data,['proj_stage_id'=>$proj_stage_id ])) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                    redirect('project/add_edit_stage/'.$project_id.'/'.$ps_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/add_edit_stage/'.$project_id.'/'.$ps_id);
                }
            }else {
                $data = [
                    'ps_fk' => $ps_fk,
                    'proj_fk' => $proj_fk,
                    'unit_amount_actual' => $unit_amount_actual,
                    'unit_actual_price' => $unit_actual_price,
                    'unit_value_actual' => $unit_value_actual,
                    'total_executed' => $total_executed,
                    'executed_value' => $executed_value,
                    'association_share' => $association_share,
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d')
                ];
               //   var_dump($data);
                if ($this->db->insert('project_stages', $data)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                    redirect('project/add_edit_stage/'.$project_id.'/'.$ps_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                    redirect('project/add_edit_stage/'.$project_id.'/'.$ps_id);
                }
            }
        }
    }

    public function details_stages($proj_stage_id){
        $data = (array)$this->db->get_where('project_stages', ['proj_stage_id ' => $proj_stage_id ])->result_array()[0];
        echo json_encode($data);
    }

    public function delete_stage($id,$proj_id,$ps_id,$tab_id='stages')
    {
        $this->db->delete('project_stages', ['proj_stage_id ' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('project/add_edit_stage/'.$proj_id.'/'.$ps_id);
    }

    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
}
