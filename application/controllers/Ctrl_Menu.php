<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
//echo $USERSTAMP;
class Ctrl_Menu extends CI_Controller{

    public function index()
    {
        $this->load->helper('form');
        $this->load->view('ACCESS RIGHTS/Vw_Menu');
    }
    public function Initaildatas()
    {
        $this->load->model('EILIB/Common_function');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    public function fetchdata()
    {
        global $USERSTAMP;
        $this->load->model('ACCESS RIGHTS/Mdl_menu');
        $menu_data=$this->Mdl_menu->fetch_data($USERSTAMP);
        echo $menu_data;
    }
}