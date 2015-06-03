<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Report_Tickler_History extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('REPORT/Vw_Report_Tickler_History');
    }
    //FUNCTIONFOR SAVE PART
    public function TH_customername_autocomplete()
    {
        global $USERSTAMP;
        $this->load->model('Common');
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        $this->load->model('REPORT/Mdl_report_tickler_history');
        $result = $this->Mdl_report_tickler_history->customername_autocomplete($USERSTAMP,$ErrorMessage) ;
        echo JSON_encode($result);
    }
    // fetch data
    public function fetchdata()
    {
        $this->load->model('REPORT/Mdl_report_tickler_history');
        $data=$this->Mdl_report_tickler_history->fetch_data();
        echo json_encode($data);
    }
}