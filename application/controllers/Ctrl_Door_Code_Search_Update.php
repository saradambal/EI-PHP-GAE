<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Door_Code_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Door_Code_Search_Update');
    }
    public function Initialdata(){
        $this->load->model('UNIT/Mdl_door_code_search_update');
        $query=$this->Mdl_door_code_search_update->Initial_data();
        echo json_encode($query);
    }
    public function DCSU_logindetails(){
        global $USERSTAMP;
        global $timeZoneFrmt;
        $unitnumber=$this->input->post("DCSU_unitnumber");
        $flag=$this->input->post("DCSU_flag");
        $this->load->model('UNIT/Mdl_door_code_search_update');
        $logindetails=$this->Mdl_door_code_search_update->DCSU_login_details($unitnumber,$flag,$timeZoneFrmt);
        echo json_encode($logindetails);
    }
    public function DCSU_updateDoorcode(){
        global $USERSTAMP;
        global $timeZoneFrmt;
        $loginid=$this->input->post("DCSU_login_id");
        $unitnumber=$this->input->post("DCSU_unitnumber");
        $doorcode=$this->input->post("DCSU_doorcode");
        $weblogin=$this->input->post("DCSU_weblogin");
        $webpass=$this->input->post("DCSU_webpass");
        $this->load->model('UNIT/Mdl_door_code_search_update');
        $loginrs=$this->Mdl_door_code_search_update->DCSU_update_Doorcode($loginid,$unitnumber,$doorcode,$weblogin,$webpass,$USERSTAMP,$timeZoneFrmt);
        echo json_encode($loginrs);
    }
    public function DCSU_ExistsDoorcode(){
        $DCSU_doorcode=$this->input->post("val");
        $DCSU_flag_doorCodeLogin=$this->input->post("flag");
        $this->load->model('EILIB/Common_function');
        $DCSU_arr=$this->Common_function->Check_ExistsDoorcodeLogin($DCSU_doorcode, $DCSU_flag_doorCodeLogin);
        echo json_encode($DCSU_arr);
    }
}