<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Extract_Deposit_Pdf extends CI_Controller{
    public function index(){
        $this->load->view('FINANCE/FINANCE/Vw_Extract_Deposit_Pdf');
    }
    public function Initialdata(){
        global $USERSTAMP;
        $this->load->model('FINANCE/FINANCE/Mdl_extract_deposit_pdf');
        $query=$this->Mdl_extract_deposit_pdf->Initial_data();
        echo json_encode($query);
    }
}