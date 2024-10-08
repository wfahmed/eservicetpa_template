<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($title='سطح المكتب')
    {
        $data['title']='إدارة الموردين';
        $data['viewName']='supplier/index';
        $datap=$this->db->get_where('supplier', ['deleted_by' =>NULL])->result_array();
        //var_dump($datap);
        for ($i = 0; $i < count($datap); $i++) {
           // $datap[$i]['supplier_id']  = $this->encryption->encrypt($temp[$i]['supplier_id']);
        }
        // var_dump($datap);
        $data['param']['rows'] =$datap;

        $data['withParam']='y';
        $data['param']['js_file'][0] ='\assets\custom\supplier.js';
        parent::index($data);
    }
    // function add supplier
    public function add_supplier()
    {
        $this->form_validation->set_rules('supplier_name', 'supplier_name', 'required', [ 'required' => 'حقل  واجب الإدخال!']);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة مزود';
            $data['viewName']='supplier/index';
            $data['withParam']='n';
        } else {
            $data = [
                'supplier_name' => $this->input->post('supplier_name'),
                'contact_name' => $this->input->post('contact_name'),
                'contact_email' => $this->input->post('contact_email'),
                'contact_phone' => $this->input->post('contact_phone'),
                'country' => $this->input->post('country'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'address' => $this->input->post('address'),
                'postal_code' => $this->input->post('postal_code'),
                'website' => $this->input->post('website'),

                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            // var_dump($data);
            if($this->db->insert('supplier',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة بنجاح</div>');
                redirect('supplier');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشلت الاضافة</div>');
                redirect('supplier');
            }

        }


        parent::index($data);
    }

    public function edit_supplier($id = null,$title='سطح المكتب')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة للمورد، اختر المورد لتتمكن من تعديله';
            $data['return'] = 'supplier';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->form_validation->set_rules('supplier_name', 'supplier_name', 'required', [
            'required' => 'حقل  واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'تعديل المورد';
            $data['viewName']='supplier/edit_sup';
            $decoded_data = urldecode($id);
            $supplier_id= $this->encryption->decrypt($decoded_data);
            $row= $this->db->get_where('supplier', ['supplier_id' => $id])->row_array();
            // var_dump($row);
            //$encrypted_data= $this->encryption->encrypt($row['supplier_id']);
            $encrypted_data= $row['supplier_id'];
            $data['supplier_id']=$encrypted_data;
            $row['supplier_id']=$encrypted_data;
            $data['param']['row'] =$row;
            $data['withParam']='y';

            $data['param']['js_file'][0] ='\assets\custom\supplier.js';
            parent::index($data);
        } else {
            $data = [
                'supplier_name' => $this->input->post('supplier_name'),
                'contact_name' => $this->input->post('contact_name'),
                'contact_email' => $this->input->post('contact_email'),
                'contact_phone' => $this->input->post('contact_phone'),
                'country' => $this->input->post('country'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'address' => $this->input->post('address'),
                'postal_code' => $this->input->post('postal_code'),
                'website' => $this->input->post('website'),

                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            //    var_dump($id);
            $decoded_data = urldecode($id);
            //  var_dump($decoded_data);
            $supplier_id= $this->encryption->decrypt($decoded_data);
            // var_dump($supplier_id);die();
            if($this->db->update('supplier',$data, ['supplier_id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح</div>');
                redirect('supplier');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('supplier');
            }

        }
    }

    public function debts_supplier($id = null){
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة للمورد، اختر المورد لتتمكن من معرفة ديونه';
            $data['return'] = 'supplier';
            $this->load->view('error_custom', $data);
            return;
        }
        $data_supply=$this->db->get_where('supplier', ['deleted_by' =>NULL,'supplier_id' =>$id])->result_array()[0];
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
        $project_supply_result = $this->Base_model->get_with_join('project_supply.*,supplier.*,psk.title as support_name,pms.title as associaton_name', 'project_supply', $join_array, '  project_supply.deleted_by  is  null and project_supply.supplier_fk='.$id, 'supplier.supplier_id asc');
        $sum_paid_amount = 0;
        $total_value = 0;
        $total_paid = 0;
        $project_supply = $this->objectToArray($project_supply_result);
       // var_dump(count($project_supply));die();
        if (is_array($project_supply) && count($project_supply) > 0) {
            $i=0;
            foreach ($project_supply as $r_sup) {
            $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'supplier_fk' =>$id,'ps_fk' =>$r_sup['ps_fk']])->result_array();

            if (is_array($rowPays)) {
                $sum_paid_amount = 0;
                foreach ($rowPays as $r) {
                    if (is_array($r)) {
                        $sum_paid_amount += $r['invoice_value'];
                    }
                }
            }
                $project_supply[$i]['total_paid_sup']=$sum_paid_amount;
                $i++;
                $total_paid+=$sum_paid_amount;
                $total_value+=$r_sup['supplier_paid_amount'];
        }
        }
      // var_dump($project_supply);
        $data_supply['total_value']=$total_value;
        $data_supply['total_paid']=$total_paid;
        $data['param']['project_supply'] =$project_supply;
        $data['param']['row'] =$data_supply;
        $data['title'] = '  توريدات المورد'.' '.$data_supply['supplier_name'];
        $data['viewName']='supplier/debts_supplier';
        $data['param']['js_file'][0] ='\assets\custom\debts.js';
        $data['withParam']='y';

        parent::index($data);
    }

    public function get_debts($id = null){
        $row=$this->db->get_where('project_supply', ['deleted_by' =>NULL,'proj_supply_id' =>$id])->row_array();
       // var_dump($row);
        $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'ps_fk' =>$row['ps_fk'],'supplier_fk' =>$row['supplier_fk']])->result_array();
        echo json_encode($rowPays);
    }

    public function print_supplier($id = null,$title='سطح المكتب'){
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة لطباعة المورد، اختر المورد لتتمكن من تعديله';
            $data['return'] = 'supplier';
            $this->load->view('error_custom', $data);
            return;
        }
        $data['title'] = 'عرض المورد';
        $data['viewName']='supplier/print_supplier';
        $decoded_data = urldecode($id);
        $supplier_id= $this->encryption->decrypt($decoded_data);
        $row= $this->db->get_where('supplier', ['supplier_id' => $id])->row_array();
        // var_dump($row);
       // $encrypted_data= $this->encryption->encrypt($row['supplier_id']);
        $encrypted_data= $id;
        $data['supplier_id']=$encrypted_data;
        $row['supplier_id']=$encrypted_data;
        //var_dump($row);
        $data['param']['row'] =$row;
        $data['for_print']='y';
        $data['withParam']='y';
        parent::index($data);
    }

    public function delete_supplier($id){
        //var_dump($id);die();
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('supplier',$data, ['supplier_id' => $id])){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم الحذف بنجاح</div>');
            redirect('supplier');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل الحذف</div>');
            redirect('supplier');
        }

    }

    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
}
