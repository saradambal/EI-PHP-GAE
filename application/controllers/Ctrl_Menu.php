<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
//echo $USERSTAMP;
class Ctrl_Menu extends CI_Controller{

    public function index()
    {
        $this->load->helper('form');
        $this->load->view('Vw_Menu');
    }
    public function Initaildatas()
    {
        $this->load->model('Common');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    public function fetchdata()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_menu');
        $menu_data=$this->Mdl_menu->fetch_data($USERSTAMP);
        echo $menu_data;
    }
}