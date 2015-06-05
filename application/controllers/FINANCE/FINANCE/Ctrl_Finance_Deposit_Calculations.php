<?php
//******************************************Deposit_Calculations********************************************//
//VER 0.03-SD:02/06/2015 ED:02/06/2015,moved to folder and changed filename eilib file name
//VER 0.02-SD:28/05/2015 ED:04/06/2015,did the ss part for deposit calculation and ss insert part
//VER 0.01-SD:25/05/2015 ED:26/05/2015,completed form design and validation without ss part
//*******************************************************************************************************//
class Ctrl_Finance_Deposit_Calculations extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_deposit_calculations');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Deposit_Calculations');
    }
    public function Initialdata(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $query=$this->Mdl_finance_deposit_calculations->Initial_data($USERSTAMP);
        echo json_encode($query);
    }
    public function DDC_loaddatebox(){
        $custid=$this->input->post("custid");
        $custname=$this->input->post("custname");
        $unitno=$this->input->post("unitno");
        $datequery=$this->Mdl_finance_deposit_calculations->DDC_load_datebox($custid,$custname,$unitno);
        echo json_encode($datequery);
    }
    public function Call_service(){
        $this->load->library('Google');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        return $service;
    }
    public function DDC_Dep_Cal_submit(){
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
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
        $calcquery=$this->Mdl_finance_deposit_calculations->DDC_depcal_submit($unit_value,$name,$chkbox,$radio,$startdate,$enddate,$dep_custid,$DDC_recverlgth,$DDC_recdate,$USERSTAMP,$service);
        echo json_encode($calcquery);
    }
}