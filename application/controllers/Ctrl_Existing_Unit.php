<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Existing_Unit extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Existing_Unit');
    }
    public function Initialdata(){
        $unitno=$this->input->post("EU_unitno");
        $flag=$this->input->post("flag");
        $this->load->model('Mdl_existing_unit');
        $query=$this->Mdl_existing_unit->Initial_data($unitno,$flag);
        echo json_encode($query);
    }
    public function EU_Alreadyexists(){
        $inputs=$this->input->post("EU_input");
        $source=$this->input->post("EU_source");
        $this->load->model('Mdl_existing_unit');
        $query=$this->Mdl_existing_unit->EU_already_exists($inputs,$source);
        echo json_encode($query);
    }
    public function EU_login_acct_others(){
        $unitnumber=$this->input->post("lbunitno");
        $flagvalue=$this->input->post("radioflag");
        $this->load->model('Mdl_existing_unit');
        $query=$this->Mdl_existing_unit->Login_acct_others($unitnumber,$flagvalue);
        echo json_encode($query);
    }
}