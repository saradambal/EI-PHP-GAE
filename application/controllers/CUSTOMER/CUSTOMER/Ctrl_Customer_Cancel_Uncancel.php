<?php

/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 20/5/15
 * Time: 3:44 PM
 */

class Ctrl_Customer_Cancel_Uncancel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_cancel_uncancel');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index(){

        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Cancel_Uncancel');
    }
    public function Get_cal_service(){
        $this->load->library('Google');
        $this->load->model('EILIB/Mdl_eilib_calender');
        // FUNCTION TO CALL AND GET THE CALENDAR SERVICE
        $cal= $this->Mdl_eilib_calender->createCalendarService();
        return $cal;
    }
    public  function CCAN_getcustomer(){
        $final_value=$this->Mdl_customer_cancel_uncancel->CCAN_getcustomer();
        echo json_encode($final_value);
    }
    public function CCAN_getcustomer_details(){
        $final_value=$this->Mdl_customer_cancel_uncancel->CCAN_getcustomer_details($this->input->post('CCAN_select_type'));
        echo json_encode($final_value);
    }
    public  function CCAN_get_customervalues(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $cusid=$this->input->post('cust_id');
        $type= $this->input->post('CCAN_select_type');
        $recver= $this->input->post('CCAN_name_recver');
        $final_value=$this->Mdl_customer_cancel_uncancel->CCAN_get_customervalues($cusid,$type,$recver,$UserStamp);
        echo json_encode($final_value);
    }
    public  function CCAN_cancel(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $custid=$this->input->post('cust_id');
        $recver= $this->input->post('CCAN_name_recver');
        $CCAN_unitnumber= $this->input->post('CCAN_unitnumber');
        $CCAN_tb_firstname=$this->input->post('CCAN_tb_firstname');
        $CCAN_tb_lastname=$this->input->post('CCAN_tb_lastname');
        $CCAN_ta_comments=$this->input->post('CCAN_ta_comments');
        $cal_service=$this->Get_cal_service();
        $final_value=$this->Mdl_customer_cancel_uncancel->CCAN_cancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service);
        echo json_encode($final_value);
    }
    public  function CCAN_uncancel(){
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $timeZoneFormat=$this->Mdl_eilib_common_function->getTimezone();
        $custid=$this->input->post('cust_id');
        $recver= $this->input->post('CCAN_name_recver');
        $cal_service=$this->Get_cal_service();
        $CCAN_unitnumber= $this->input->post('CCAN_unitnumber');
        $CCAN_tb_firstname=$this->input->post('CCAN_tb_firstname');
        $CCAN_tb_lastname=$this->input->post('CCAN_tb_lastname');
        $CCAN_ta_comments=$this->input->post('CCAN_ta_comments');
        $CCAN_tb_roomtype=$this->input->post('CCAN_tb_roomtype');
        $final_value=$this->Mdl_customer_cancel_uncancel->CCAN_uncancel($UserStamp,$custid,$recver,$CCAN_unitnumber,$CCAN_tb_firstname,$CCAN_tb_lastname,$CCAN_ta_comments,$cal_service,$CCAN_tb_roomtype);
        echo json_encode($final_value);
    }


} 