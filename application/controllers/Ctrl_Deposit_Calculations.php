<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Deposit_Calculations extends CI_Controller{
    public function index(){
        $this->load->view('FINANCE/FINANCE/Vw_Deposit_Calculations');
    }
    public function Initialdata(){
        global $USERSTAMP;
        $this->load->model('FINANCE/FINANCE/Mdl_deposit_calculations');
        $query=$this->Mdl_deposit_calculations->Initial_data($USERSTAMP);
        echo json_encode($query);
    }
    public function DDC_loaddatebox(){
        $custid=$this->input->post("custid");
        $custname=$this->input->post("custname");
        $unitno=$this->input->post("unitno");
        $this->load->model('FINANCE/FINANCE/Mdl_deposit_calculations');
        $datequery=$this->Mdl_deposit_calculations->DDC_load_datebox($custid,$custname,$unitno);
        echo json_encode($datequery);
    }
    public function Call_service(){
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Common_function');
        // FUNCTION TO CALL AND GET SERVICE
        $service= $this->Common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        return $service;
    }
    public function DDC_Dep_Cal_submit(){
        global $USERSTAMP;
        $unit_value=$this->input->post("DDC_lb_unitselect");
        $name=$this->input->post("DDC_lb_customerselect");
        $chkbox=$this->input->post("DDC_chk_checkboxinc");
        $radio=$this->input->post("DDC_radio_idradiobtn");
        $startdate=$this->input->post("DDC_db_startdate");
        $enddate=$this->input->post("DDC_db_enddate");
        $dep_custid=$this->input->post("DDC_tb_hidecustid");
        $DDC_recverlgth=$this->input->post("DDC_tb_hiderecverlength");
        $DDC_recdate=$this->input->post("DDC_tb_recdate");
        $service=$this->Call_service();
        $this->load->model('FINANCE/FINANCE/Mdl_deposit_calculations');
        $calcquery=$this->Mdl_deposit_calculations->DDC_depcal_submit($unit_value,$name,$chkbox,$radio,$startdate,$enddate,$dep_custid,$DDC_recverlgth,$DDC_recdate,$USERSTAMP,$service);
        echo json_encode($calcquery);
    }
}