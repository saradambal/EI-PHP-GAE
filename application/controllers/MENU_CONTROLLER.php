<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class MENU_CONTROLLER extends CI_Controller{

    public function index()
    {
        $this->load->helper('form');
        $this->load->view('FORM_MENU.php');
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
        $this->load->model('Db_menu');
        $menu_data=$this->Db_menu->fetch_data($USERSTAMP);
        echo $menu_data;
    }
}