<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Unit_Existing_Unit extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Existing_Unit');
    }
    public function Initialdata(){
        $unitno=$this->input->post("EU_unitno");
        $flag=$this->input->post("flag");
        $this->load->model('UNIT/Mdl_unit_existing_unit');
        $query=$this->Mdl_unit_existing_unit->Initial_data($unitno,$flag);
        echo json_encode($query);
    }
    public function EU_Alreadyexists(){
        $inputs=$this->input->post("EU_input");
        $source=$this->input->post("EU_source");
        $this->load->model('UNIT/Mdl_unit_existing_unit');
        $existquery=$this->Mdl_unit_existing_unit->EU_already_exists($inputs,$source);
        echo json_encode($existquery);
    }
    public function EU_login_acct_others(){
        $unitnumber=$this->input->post("lbunitno");
        $flagvalue=$this->input->post("radioflag");
        $this->load->model('UNIT/Mdl_unit_existing_unit');
        $accquery=$this->Mdl_unit_existing_unit->Login_acct_others($unitnumber,$flagvalue);
        echo json_encode($accquery);
    }
    public function EU_updateForm(){
        global $USERSTAMP;
        $EU_unitnumber = $this->input->post("EU_lb_unitnumber");
        $EU_flag=$this->input->post("EU_hidden_flag");
        $EU_doorcode = $this->input->post("EU_tb_doorcode");
        $EU_weblogin = $this->input->post("EU_tb_weblogin");
        $EU_webpass = $this->input->post("EU_tb_webpass");
        $EU_accntnumber = $this->input->post("EU_tb_accntnumber");
        $EU_accntname = $this->input->post("EU_tb_accntname");
        $EU_bankcode = $this->input->post("EU_tb_bankcode");
        $EU_branchcode =$this->input->post("EU_tb_branchcode");
        $EU_bankaddrs = $this->input->post("EU_tb_bankaddrs");
        $EU_unitdeposite = $this->input->post("EU_tb_unitdeposite");
        $EU_accesscard = $this->input->post("EU_tb_accesscard");
        $EU_oldroomtype = $this->input->post("EU_lb_oldroomtype");
        $EU_newroomtype = $this->input->post("EU_tb_newroomtype");
        $EU_stampdutydate = $this->input->post("EU_db_stampdutydate");
        $EU_oldstamptype = $this->input->post("EU_lb_oldstamptype");
        $EU_newstamptype = $this->input->post("EU_tb_newstamptype");
        $EU_stampamount = $this->input->post("EU_tb_stampamount");
        $EU_comments = $this->input->post("EU_ta_comments");
        $this->load->model('UNIT/Mdl_unit_existing_unit');
        $savequery=$this->Mdl_unit_existing_unit->EU_update_Form($EU_unitnumber,$EU_flag,$EU_doorcode,$EU_weblogin,$EU_webpass,$EU_accntnumber,$EU_accntname,
            $EU_bankcode,$EU_branchcode,$EU_bankaddrs,$EU_unitdeposite,$EU_accesscard,$EU_oldroomtype,$EU_newroomtype,$EU_stampdutydate,$EU_oldstamptype,
            $EU_newstamptype,$EU_stampamount,$EU_comments,$USERSTAMP);
        echo json_encode($savequery);
    }
}