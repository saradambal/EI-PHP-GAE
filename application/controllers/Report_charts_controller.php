<?php
class Report_charts_controller extends CI_Controller{
    public function index(){
//        $this->load->view('FORM_MENU');
        $this->load->view('REPORT/Report_charts_view');
    }
    public function Initialdata(){
        $this->load->model('Report_charts_model');
        $query=$this->Report_charts_model->Initial_data();
        echo json_encode($query);
    }
    public function Subchartdata(){
        $nameval=$this->input->post('nameval');
        $this->load->model('Report_charts_model');
        $query=$this->Report_charts_model->Subchart_data($nameval);
        echo json_encode($query);
    }
    public function Expense_inputdata(){
        $unitno=$this->input->post('unitno');
        $fromdate=$this->input->post('fromdate');
        $todate=$this->input->post('todate');
        $srch_data=$this->input->post('srch_data');
        $flag=$this->input->post('flag');
        $this->load->model('Report_charts_model');
        $query=$this->Report_charts_model->Expense_input_data($unitno,$fromdate,$todate,$srch_data,$flag);
        echo json_encode($query);
    }
}