<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Report_Charts extends CI_Controller{
    public function index(){
        $this->load->view('REPORT/Vw_Report_Charts');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('EILIB/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);

        $this->load->model('REPORT/Mdl_report_charts');
        $query=$this->Mdl_report_charts->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Subchartdata(){
        $nameval=$this->input->post('nameval');
        $this->load->model('REPORT/Mdl_report_charts');
        $query=$this->Mdl_report_charts->Subchart_data($nameval);
        echo json_encode($query);
    }
    public function Expense_inputdata(){
        global $USERSTAMP;
        $unitno=$this->input->post('unitno');
        $fromdate=$this->input->post('fromdate');
        $todate=$this->input->post('todate');
        $srch_data=$this->input->post('srch_data');
        $flag=$this->input->post('flag');
        $this->load->model('REPORT/Mdl_report_charts');
        $query=$this->Mdl_report_charts->Expense_input_data($unitno,$fromdate,$todate,$srch_data,$flag,$USERSTAMP);
        echo json_encode($query);
    }
}