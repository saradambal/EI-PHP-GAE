<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
class Ctrl_Banktt_Entry_Form extends CI_Controller
{
    public function index()
    {
        $this->load->view('OCBC/Vw_BankTT_Entry');
    }
    public function Initialdata()
    {
        $this->load->model('OCBC/Mdl_banktt_entry');
        $query=$this->Mdl_banktt_entry->Initial_data();
        echo json_encode($query);
    }
    public function Customername(){
        $unitno= $this->input->post('unitno');
        $this->load->model('OCBC/Mdl_banktt_entry');
        $query=$this->Mdl_banktt_entry->Customer_name($unitno);
        echo json_encode($query);
    }
    public function Banktt_Entry_Save()
    {
        global $UserStamp;
        $this->load->model('OCBC/Mdl_banktt_entry');
        $Confirmmessage=$this->Mdl_banktt_entry->Banktt_EntrySave($UserStamp);
        echo json_encode($Confirmmessage);
    }
}