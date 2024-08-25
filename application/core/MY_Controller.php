<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class MY_Controller extends CI_Controller {

    public $screens;
    public $data;
    public $param;
    public $isModal;
    public $istest;
    public $user_os;
    public $user_browser;
    public $user_ip;
    function __construct(){

        parent::__construct();

        $this->user_os        = $this->getOS();
        $this->user_browser   = $this->getBrowser();
        $this->user_ip        = $this->get_client_ip();

        $this->showsSidebar = true;

        $this->load->library('template');
        $this->load->library('form_validation');
        $this->load->model(array('Base_model', 'base_model'));


      //  $this->load->model('systems/m_users');


        header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');

        header('Cache-Control: no-store, no-cache, must-revalidate');

        header('Cache-Control: post-check=0, pre-check=0',false);

        header('Pragma: no-cache');

        // user access
        is_logged_in();
    }


    public  function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function getOS() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $os_platform = $value;

        return $os_platform;
    }
    public function getBrowser() {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $browser        = "Unknown Browser";

        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value)
            if (preg_match($regex, $user_agent))
                $browser = $value;

        return $browser;
    }

    public function index($dataAr)
    {
        $this->data = [
            'title' => $dataAr['title'],
            'user' => $this->db->get_where('user', ['user_name' => $this->session->userdata('user_name')])->row_array(),
            'user_role' => $this->db->get_where('user_role', ['deleted_by'=> NULL])->num_rows(),
            'user_member' => $this->db->get_where('user', ['role_id' => 2])->num_rows(),
            'menu' => $this->db->get_where('user_menu', ['deleted_by'=> NULL])->num_rows(),
            'sub_menu' => $this->db->get('user_sub_menu')->num_rows(),
            'report' => $this->db->get('user_report')->num_rows(),
        ];
        if(isset($dataAr['param'])){
            $this->data['param'] = $dataAr['param'];

        }else{
            $this->data['param'] = '';

        }
      /*  if(isset($dataAr['role'])){
            $this->data['role'] = $dataAr['role'];

        }else{
            $this->data['role'] = $this->db->get('user_role')->result_array();

        }*/
      //  var_dump( $this->data['role']);

       /*  if(isset($dataAr['details']))
            $this->data['details']= $dataAr['details'];
        else
            $this->data['details']= '';
        var_dump( $this->data['details']);*/

       // var_dump( $this->data);die();
        $this->load->view('templates/admin_header', $this->data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar', $this->data);

        if($dataAr['withParam']=='y'){
            $this->load->view($dataAr['viewName'], $this->data);

        }else{
            $this->load->view($dataAr['viewName']);

        }

        $this->load->view('templates/admin_footer');

    }





}


