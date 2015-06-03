<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Access_Card_Card_Assign extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/ACCESS CARD/Vw_Access_Card_Card_Assign');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);

        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_card_assign');
        $query=$this->Mdl_access_card_card_assign->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Customerdetails(){
        global $USERSTAMP;
        $CA_recver= $this->input->post('CA_recver');
        $CA_unit= $this->input->post('CA_unit');
        $CA_custid= $this->input->post('CA_cust_id');
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_card_assign');
        $query=$this->Mdl_access_card_card_assign->Customer_details($CA_recver,$CA_unit,$CA_custid,$USERSTAMP);
        echo json_encode($query);
    }
    public function Cardassignsave(){
        global $USERSTAMP;
        $CA_custid= $this->input->post('CA_cust_id');
        $CA_recver= $this->input->post('CA_lb_leaseperiod');
        $CA_comment=$this->input->post('CA_ta_comments');
        $CA_unitno=$this->input->post('CA_lb_unitno');
        $CA_fname=$this->input->post('CA_tb_firstname');
        $CA_lname=$this->input->post('CA_tb_lastname');
        $CA_card_value=$this->input->post('CA_tb_cardno');
        $CA_startdate=$this->input->post('CA_tb_startdate');
        $CA_startdate=date('Y-m-d',strtotime($CA_startdate));
        $CA_enddate=$this->input->post('CA_tb_enddate');
        $CA_enddate=date('Y-m-d',strtotime($CA_enddate));
        $CA_cardclick = $this->input->post('CA_selectcard');
        $CA_card_no = $this->input->post('CA_tb_cardno');
        $CA_namelist = $this->input->post('CA_selectnamelist1');
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_card_assign');
        $query=$this->Mdl_access_card_card_assign->Cardassign_save($CA_custid,$CA_recver,$CA_comment,$CA_unitno,$CA_fname,$CA_lname,$CA_card_value,$CA_startdate,$CA_enddate,$CA_cardclick,$CA_card_no,$CA_namelist,$USERSTAMP);
        echo $query;
    }
}