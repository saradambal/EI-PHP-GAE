<?php
include "GET_USERSTAMP.php";
include "GET_CONFIG.php";
$USERSTAMP=$UserStamp;
Class Ctrl_Customer_Termination extends CI_Controller
{
    public function index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Termination');
    }
    public function CTERM_getErrMsgCalTime(){
        global $USERSTAMP;
        $this->load->database();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getErrMsgCalTime($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerName(){
        global $USERSTAMP;
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerName($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerId(){
        global $USERSTAMP;
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerId($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerdtls(){
        global $USERSTAMP;
        global $timeZoneFormat;
        $custid=$this->input->post('custid');
        $radiooption=$this->input->post('radiooption');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerdtls($custid,$radiooption,$USERSTAMP,$timeZoneFormat);
        echo json_encode($data);
    }
    public function CTERM_UpdatePtd(){
        global $USERSTAMP;
        global $timeZoneFormat;
        $Globalrecver=$this->input->post('Globalrecver');
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Calender');
        // FUNCTION TO CALL AND GET THE CALENDAR SERVICE
        $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_UpdatePtd($USERSTAMP,$timeZoneFormat,$Globalrecver,$cal);
        echo $data;
    }
    public function CTERM_getMinPTD(){
        global $USERSTAMP;
        global $timeZoneFormat;
        $CTERM_custid=$this->input->post('CTERM_custid');
        $CTERM_radio_termoption=$this->input->post('CTERM_radio_termoption');
        $CTERM_unitno=$this->input->post('CTERM_unitno');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getMinPTD($CTERM_custid,$CTERM_radio_termoption,$CTERM_unitno);
        echo json_encode($data);
    }
}