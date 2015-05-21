<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Unit_Termination extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Termination');
    }
    public function Initialdata(){
        $this->load->model('Mdl_unit_termination');
        $query=$this->Mdl_unit_termination->Initial_data();
        echo json_encode($query);
    }
    public function UT_unitdetails(){
        global $USERSTAMP;
        $unitnumber=$this->input->post("UT_unitnumber");
        $flag_select=$this->input->post("UT_flag_select");
        $comments=$this->input->post("UT_comments");
        $this->load->model('Mdl_unit_termination');
        $unitdetails=$this->Mdl_unit_termination->UT_unit_details($unitnumber,$flag_select,$comments,$USERSTAMP);
        echo json_encode($unitdetails);
    }
}