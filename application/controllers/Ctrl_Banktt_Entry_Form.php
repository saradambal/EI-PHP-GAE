<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
class Ctrl_Banktt_Entry_Form extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/BANKTT_ENTRY');
    }
    public function Initialdata()
    {
        $this->load->model('Banktt_entry_model');
        $query=$this->Banktt_entry_model->Initial_data();
        echo json_encode($query);
    }
    public function Customername(){
        $unitno= $this->input->post('unitno');
        $this->load->model('Banktt_entry_model');
        $query=$this->Banktt_entry_model->Customer_name($unitno);
        echo json_encode($query);
    }
    public function Banktt_Entry_Save()
    {
        global $UserStamp;
        $this->load->model('Banktt_entry_model');
        $Confirmmessage=$this->Banktt_entry_model->Banktt_EntrySave($UserStamp);
        echo json_encode($Confirmmessage);
    }
}