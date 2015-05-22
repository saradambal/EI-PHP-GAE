<?php
include 'GET_USERSTAMP.php';
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 20/5/15
 * Time: 3:44 PM
 */

class Ctrl_Customer_Cancel extends CI_Controller {

    public function index(){

        $this->load->view('CUSTOMER/Vw_Customer_Cancel');
    }

    public  function CCAN_getcustomer(){

        $this->load->model('Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_getcustomer();
        echo json_encode($final_value);
    }
    public function CCAN_getcustomer_details(){

        $this->load->model('Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_getcustomer_details($this->input->post('CCAN_select_type'));
        echo json_encode($final_value);
    }
    public  function CCAN_get_customervalues(){

        global $UserStamp;
        $cusid=$this->input->post('cust_id');
        $type= $this->input->post('CCAN_select_type');
        $recver= $this->input->post('CCAN_name_recver');
        $this->load->model('Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_get_customervalues($cusid,$type,$recver,$UserStamp);
        echo json_encode($final_value);


    }
    public  function CCAN_cancel(){

        global $UserStamp;
        $custid=$this->input->post('cust_id');
        $recver= $this->input->post('CCAN_name_recver');
        $CCAN_unitnumber= $this->input->post('CCAN_unitnumber');
        $CCAN_tb_firstname=$this->input->post('CCAN_tb_firstname');
        $CCAN_tb_lastname=$this->input->post('CCAN_tb_lastname');
        $CCAN_ta_comments=$this->input->post('CCAN_ta_comments');
        $this->load->model('Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_cancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments);
        echo json_encode($final_value);



    }


} 