<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
class Ctrl_Access_Card_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('CUSTOMER/ACCESS CARD/Vw_Access_Card_Search_Update');
    }
    public function Initialdata(){
        $errorlist= $this->input->post('ErrorList');
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);

        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_search_update');
        $query=$this->Mdl_access_card_search_update->Initial_data($ErrorMessage);
        echo json_encode($query);
    }
    public function Accesscardupdate(){
        global $USERSTAMP;
        $CSU_custid=$this->input->post('CSU_cust_id');
        $CSU_currentcard=$this->input->post('CSU_lb_curcard');
        $CSU_reason=$this->input->post('CSU_lb_reason');
        $CSU_comments=$this->input->post('CSU_ta_comments');
        $this->load->model('CUSTOMER/ACCESS CARD/Mdl_access_card_search_update');
        $returnflag=$this->Mdl_access_card_search_update->Accesscard_update($CSU_custid,$CSU_currentcard,$CSU_reason,$CSU_comments,$USERSTAMP);
        echo json_encode($returnflag);
    }
}
