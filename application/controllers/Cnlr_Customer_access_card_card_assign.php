<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Cnlr_Customer_access_card_card_assign extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/Vw_Customer_access_card_card_assign');
    }
    public function Initialdata(){
        $this->load->model('Common');
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);

        $this->load->model('Mdl_Customer_access_card_card_assign');
        $query=$this->Mdl_Customer_access_card_card_assign->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Customerdetails(){
        global $USERSTAMP;
        $CA_recver= $this->input->post('CA_recver');
        $CA_unit= $this->input->post('CA_unit');
        $CA_cust_id= $this->input->post('CA_cust_id');

        $this->load->model('Mdl_Customer_access_card_card_assign');
        $query=$this->Mdl_Customer_access_card_card_assign->Customer_details($CA_recver,$CA_unit,$CA_cust_id,$USERSTAMP);
        echo json_encode($query);
    }
}