<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Access_Card_Replace extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/Vw_Access_Card_Replace');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);

        $this->load->model('Mdl_access_card_replace');
        $result=$this->Mdl_access_card_replace->Initial_data($ErrorMessage);
        echo json_encode($result);
    }
    public function Avialablecard(){
        $unitno= $this->input->post('unitno');
        $this->load->model('Mdl_access_card_replace');
        $cardarray=$this->Mdl_access_card_replace->Avialable_card($unitno);
        echo json_encode($cardarray);
    }
    public function Replacecardsave(){
        global $USERSTAMP;
        $CR_custid=$this->input->post('CR_cust_id');
        $CR_currentcard=$this->input->post('CR_lb_curcard');
        $CR_newcard=$this->input->post('CR_lb_newcard');
        $CR_reason=$this->input->post('CR_lb_reason');
        $CR_comments=$this->input->post('CR_ta_comments');
        $CR_unit_no=$this->input->post('CR_lb_unitno');
        $this->load->model('Mdl_access_card_replace');
        $savearray=$this->Mdl_access_card_replace->Replacecard_save($CR_custid,$CR_currentcard,$CR_newcard,$CR_reason,$CR_comments,$CR_unit_no,$USERSTAMP);
        echo json_encode($savearray);
    }
}