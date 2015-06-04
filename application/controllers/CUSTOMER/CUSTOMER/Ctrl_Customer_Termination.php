<?php
Class Ctrl_Customer_Termination extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_termination');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Termination');
    }
    public function CTERM_getErrMsgCalTime(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $this->load->database();        
        $data=$this->Mdl_customer_termination->CTERM_getErrMsgCalTime($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerName(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();        
        $data=$this->Mdl_customer_termination->CTERM_getCustomerName($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerId(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();        
        $data=$this->Mdl_customer_termination->CTERM_getCustomerId($USERSTAMP);
        echo json_encode($data);
    }
    public function CTERM_getCustomerdtls(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $custid=$this->input->post('custid');
        $radiooption=$this->input->post('radiooption');        
        $data=$this->Mdl_customer_termination->CTERM_getCustomerdtls($custid,$radiooption,$USERSTAMP,$timeZoneFormat);
        echo json_encode($data);
    }
    public function CTERM_UpdatePtd(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $Globalrecver=$this->input->post('Globalrecver');
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        $cal= $this->Mdl_eilib_calender->createCalendarService();
        $data=$this->Mdl_customer_termination->CTERM_UpdatePtd($USERSTAMP,$timeZoneFormat,$Globalrecver,$cal);
        echo ($data);
    }
    public function CTERM_getMinPTD(){
        $USERSTAMP= $this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat= $this->Mdl_eilib_common_function->getTimezone();
        $CTERM_custid=$this->input->post('CTERM_custid');
        $CTERM_radio_termoption=$this->input->post('CTERM_radio_termoption');
        $CTERM_unitno=$this->input->post('CTERM_unitno');        
        $data=$this->Mdl_customer_termination->CTERM_getMinPTD($CTERM_custid,$CTERM_radio_termoption,$CTERM_unitno);
        echo json_encode($data);
    }
}