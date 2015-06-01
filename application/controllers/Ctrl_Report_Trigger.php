<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Report_Trigger extends CI_Controller
{
    public function Index()
    {
    $this->load->view('OCBC/Vw_Csv_Updation');
    }
    public function TriggerConfiguration()
    {
        $this->load->model('OCBC/Mdl_csvmodel');
        $data = $this->Mdl_csvmodel->getTriggerConfiguration();
        echo json_encode($data);
    }
    public function CSV_Initaildatas()
    {
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Common_function');
        $service = $this->Common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('OCBC/Mdl_csvmodel');
        $CSV_Records=$this->Mdl_csvmodel->getCSVfileRecords($service);
        echo json_encode($CSV_Records);
    }


}