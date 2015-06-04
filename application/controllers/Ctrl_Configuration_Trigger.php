<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
$UserStamp=$UserStamp;
Class Ctrl_Configuration_Trigger extends CI_Controller
{
    public function Index()
    {
    $this->load->view('CONFIGURATION/Vw_Configuration_Trigger');
    }
    public function TriggerConfiguration()
    {
        $this->load->model('CONFIGURATION/Mdl_configuration_trigger');
        $data = $this->Mdl_configuration_trigger->getTriggerConfiguration();
        echo json_encode($data);
    }
    public function CSV_Initaildatas()
    {
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $service = $this->Mdl_eilib_common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('CONFIGURATION/Mdl_configuration_trigger');
        $CSV_Records=$this->Mdl_configuration_trigger->getCSVfileRecords($service);
        echo json_encode($CSV_Records);
    }


}