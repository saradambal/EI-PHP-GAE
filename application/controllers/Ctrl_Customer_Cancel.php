<?php
include 'GET_USERSTAMP.php';
include "GET_CONFIG.php";
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 20/5/15
 * Time: 3:44 PM
 */

class Ctrl_Customer_Cancel extends CI_Controller {

    public function index(){

        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Cancel');
    }
    public function Get_cal_service(){
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('Eilib/Calender');
        // FUNCTION TO CALL AND GET THE CALENDAR SERVICE
        $cal= $this->Calender->createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        return $cal;
    }
    public  function CCAN_getcustomer(){

        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_getcustomer();
        echo json_encode($final_value);
    }
    public function CCAN_getcustomer_details(){

        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_getcustomer_details($this->input->post('CCAN_select_type'));
        echo json_encode($final_value);
    }
    public  function CCAN_get_customervalues(){

        global $UserStamp;
        $cusid=$this->input->post('cust_id');
        $type= $this->input->post('CCAN_select_type');
        $recver= $this->input->post('CCAN_name_recver');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel');
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
        $cal_service=$this->Get_cal_service();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_cancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service);
        echo json_encode($final_value);



    }

    public  function CCAN_uncancel(){
        global $UserStamp;
        $custid=$this->input->post('cust_id');
        $recver= $this->input->post('CCAN_name_recver');
        $cal_service=$this->Get_cal_service();
        $CCAN_unitnumber= $this->input->post('CCAN_unitnumber');
        $CCAN_tb_firstname=$this->input->post('CCAN_tb_firstname');
        $CCAN_tb_lastname=$this->input->post('CCAN_tb_lastname');
        $CCAN_ta_comments=$this->input->post('CCAN_ta_comments');
        $CCAN_tb_roomtype=$this->input->post('CCAN_tb_roomtype');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel');
        $final_value=$this->Mdl_customer_cancel->CCAN_uncancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service,$CCAN_tb_roomtype);
        echo json_encode($final_value);
    }


} 