<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Door_Code_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Door_Code_Search_Update');
    }
    public function Initialdata(){
        $this->load->model('Mdl_door_code_search_update');
        $query=$this->Mdl_door_code_search_update->Initial_data();
        echo json_encode($query);
    }
    public function DCSU_logindetails(){
        global $USERSTAMP;
        global $timeZoneFrmt;
        $unitnumber=$this->input->post("DCSU_unitnumber");
        $flag=$this->input->post("DCSU_flag");
        $this->load->model('Mdl_door_code_search_update');
        $logindetails=$this->Mdl_door_code_search_update->DCSU_login_details($unitnumber,$flag,$timeZoneFrmt);
        echo json_encode($logindetails);
    }
}