<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
Class Ctrl_Customer_Termination extends CI_Controller
{
    public function index()
    {
        $this->load->view('CUSTOMER/Vw_Customer_Termination');
    }
    public function CTERM_getErrMsgCalTime(){
        global $USERSTAMP;
        $this->load->database();
        $this->load->model('Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getErrMsgCalTime($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerName(){
        global $USERSTAMP;
        $this->load->model('Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerName($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerId(){
        global $USERSTAMP;
        $this->load->model('Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerId($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerdtls(){
        global $USERSTAMP;
        global $timeZoneFormat;
        $custid=$this->input->post('custid');
        $radiooption=$this->input->post('radiooption');
        $this->load->model('Mdl_customer_termination');
        $data=$this->Mdl_customer_termination->CTERM_getCustomerdtls($custid,$radiooption,$USERSTAMP,$timeZoneFormat);
        echo json_encode($data);
    }
}