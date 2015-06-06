<?php
class Ctrl_Menu extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->helper('form');
        $this->load->view('ACCESS RIGHTS/Vw_Menu');
    }
    public function Initaildatas()
    {
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    public function fetchdata()
    {
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->model('ACCESS RIGHTS/Mdl_menu');
        $menu_data=$this->Mdl_menu->fetch_data($USERSTAMP);
        echo $menu_data;
    }
}