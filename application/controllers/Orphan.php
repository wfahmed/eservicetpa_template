<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Orphan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('OrphanModel');
        $this->load->library('HierarchyLib'); // Load the library
    }

    public function index($title='إدارة الأيتام')
    {
        /***constant************/
        $data['param']['DISABILITY_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DISABILITY_STATUS])->result_array();
        $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
        $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
        $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
        $data['param']['HEALTH'] = (array)$this->db->get_where('constants', ['parent_id' => HEALTH])->result_array();
        $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
        $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
        $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
        $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
        $data['param']['EDUCATION'] = (array)$this->db->get_where('constants', ['parent_id' => EDUCATION])->result_array();
        $data['param']['RELIEF'] = (array)$this->db->get_where('constants', ['parent_id' => RELIEF])->result_array();
        $data['param']['GUARANTEE_SUB'] = (array)$this->db->get_where('constants', ['parent_id' => GUARANTEE_SUB])->result_array();
        $data['param']['CURRENCY'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENCY])->result_array();
        $data['param']['BENEFIT'] = (array)$this->db->get_where('constants', ['parent_id' => BENEFIT])->result_array();
        $data['param']['SUPPORTING_BODIES'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
        $hierarchy= (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['GOVERNORATES']=$hierarchy;
        $data['title'] = $title;
        $data['viewName']='orphan/index';
        $data['param']['js_file'][0] ='\assets\custom\orphan.js';
        $data['withParam']='y';
        parent::index($data);

    }

    public function view()
    {
        $search_params = $this->input->post();
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        $result = $this->OrphanModel->search_orphans($search_params, $length, $start);
        //var_dump($result);die();
        $total = $this->OrphanModel->get_total_orphans($search_params);

        if ($result === false) {
            // Handle the error
            $error_message = $this->OrphanModel->get_last_error();
            echo json_encode(['error' => 'An 333 error occurred while fetching data: ' . $error_message]);
        } else {
            echo json_encode([
                'data' => $result,
                'recordsTotal' => $total,
                'recordsFiltered' => $total
            ]);
        }
    }

    public function show($title='إدارة الأيتام')
    {
        /***constant************/
        $data['param']['DISABILITY_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DISABILITY_STATUS])->result_array();
        $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
        $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
        $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
        $data['param']['HEALTH'] = (array)$this->db->get_where('constants', ['parent_id' => HEALTH])->result_array();
        $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
        $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
        $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
        $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
        $data['param']['EDUCATION'] = (array)$this->db->get_where('constants', ['parent_id' => EDUCATION])->result_array();
        $data['param']['RELIEF'] = (array)$this->db->get_where('constants', ['parent_id' => RELIEF])->result_array();
        $data['param']['GUARANTEE_SUB'] = (array)$this->db->get_where('constants', ['parent_id' => GUARANTEE_SUB])->result_array();
        $data['param']['CURRENCY'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENCY])->result_array();
        $data['param']['BENEFIT'] = (array)$this->db->get_where('constants', ['parent_id' => BENEFIT])->result_array();
        $data['param']['SUPPORTING_BODIES'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
        $hierarchy= (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['GOVERNORATES']=$hierarchy;
        $data['title'] = $title;
        $data['viewName']='orphan/show';
        $data['param']['js_file'][0] ='\assets\custom\orphan_show.js';
        $data['withParam']='y';
        parent::index($data);

    }
    public function show_orphans() {
        try {
            // Validate and sanitize input
            $search_params = $this->input->post();

            // Pagination parameters
            $start = $this->input->post('start') ?? 0;
            $length = $this->input->post('length') ?? 10;
            $search=$this->input->post();

            // Column sorting
            $order_column = $this->input->post('order')[0]['column'] ?? null;
            $order_dir = $this->input->post('order')[0]['dir'] ?? 'asc';
            // Get filtered and paginated results
            $result = $this->OrphanModel->get_orphans(
                $start,
                $length,
                $search,
                $order_column,
                $order_dir
            );

            // Get total count of records
//            $total = $this->OrphanModel->count_orphans($search);

            $response = [
                'draw' => intval($this->input->post('draw')),
                'recordsTotal' => $result['total_count'],
                'recordsFiltered' => $result['total_count'],
                'data' => $result['data'],
                // Optional: add error handling
                'error' => null
            ];

            // Ensure proper JSON headers
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        catch (Exception $e) {
            // Error handling
            $response = [
                'draw' => intval($this->input->post('draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $e->getMessage()
            ];

            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode($response);
        }
        exit();
    }


    public function refresh_row()
    {
        $id= $this->input->post('id');
        $data = [
            'is_refresh' =>1,
            'refreshed_by' => $this->session->userdata('id'),
            'refreshed_at' => date('Y-m-d H:i:s') // Use full datetime format
        ];
        //  var_dump($data);die();
        if ($this->db->update('user', $data, ['id' => $id])) {
            $response = [
                'status' => true,
                'message' => 'تم التحديث',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'فشل التحديث',
            ];
        }

        // Return JSON response
        echo json_encode($response);
    }

    public function priority_row()
    {
        $id= $this->input->post('id');
        $data = [
            'has_prior' => 1,
            'prior_by'  => $this->session->userdata('id'),
            'prior_at'  => date('Y-m-d H:i:s')
        ];
        if ($this->db->update('user', $data, ['id' => $id])) {
            $response = [
                'status' => true,
                'message' => 'تم إعطاء اولوية',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'فشل إعطاء اولوية',
            ];
        }
        echo json_encode($response);
    }

    /**
     * objectToArray
     */
    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
    private function getPostArray($key) {
        $value = $this->input->post($key);
        return $value ? (is_array($value) ? $value : array($value)) : null;
    }
}