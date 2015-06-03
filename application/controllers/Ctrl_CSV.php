<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_CSV extends CI_Controller
{
    public function Index()
    {
    $this->load->view('OCBC/FORM_CSV');
    }
    public function TriggerConfiguration()
    {
        $this->load->model('Csvmodel');
        $data = $this->Csvmodel->getTriggerConfiguration();
        echo json_encode($data);
    }
    public function CSV_Initaildatas()
    {
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('EILIB/Common_function');
        $service = $this->Common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('Csvmodel');
        $CSV_Records=$this->Csvmodel->getCSVfileRecords($service);
        echo json_encode($CSV_Records);
    }


}