<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 29-05-2015
 * Time: 05:13 PM
 */

class Ctrl_Report_Report extends CI_Controller{

    public function index(){

        $this->load->view('REPORT/Vw_Report_Report');
    }

    public function REP_getdomain_err(){
        $this->load->model('REPORT/Mdl_report_report');
        $final_value=$this->Mdl_report_report->REP_getdomain_err();
        echo json_encode($final_value);

    }
    public function  REP_func_load_searchby_option(){

        $this->load->model('REPORT/Mdl_report_report');
        $final_value=$this->Mdl_report_report->REP_func_load_searchby_option($this->input->post('REP_report_optionfetch'));
        echo json_encode($final_value);

    }

}