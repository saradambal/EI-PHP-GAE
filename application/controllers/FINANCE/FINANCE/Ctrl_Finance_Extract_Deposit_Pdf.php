<?php
class Ctrl_Finance_Extract_Deposit_Pdf extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_extract_deposit_pdf');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Extract_Deposit_Pdf');
    }
    public function Call_service(){
        $this->load->library('Google');
        $service = $this->Mdl_eilib_common_function->get_service_document();
        return $service;
    }
    public function Initialdata(){
        $timeZoneFrmt= $this->Mdl_eilib_common_function->getTimezone();
        $USERSTAMP=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $service=$this->Call_service();
        $query=$this->Mdl_finance_extract_deposit_pdf->Initial_data($service);
        echo json_encode($query);
    }
}