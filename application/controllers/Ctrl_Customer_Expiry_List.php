<?php
include "GET_USERSTAMP.php";
/**
 * Created by PhpStorm.
 * User: SSOMENS-022
 * Date: 26/5/15
 * Time: 4:30 PM
 */

class Ctrl_Customer_Expiry_List extends CI_Controller {


    public  function index(){
        $this->load->view('CUSTOMER/Vw_Customer_Expiry_List');
    }
    public function CEXP_get_initial_values(){
        $this->load->model('Mdl_customer_expiry_list');
        $final_value=$this->Mdl_customer_expiry_list->CEXP_get_initial_values();
        echo json_encode($final_value);
    }
    public function CEXP_get_customer_details(){
        global $UserStamp,$timeZoneFormat;
        $this->load->model('Mdl_customer_expiry_list');
        $final_value=$this->Mdl_customer_expiry_list->CEXP_get_customer_details($this->input->post('CEXP_fromdate'),$this->input->post('CEXP_todate'),$this->input->post('CEXP_radio_button_select_value'),$UserStamp,$timeZoneFormat);
        echo json_encode($final_value);
    }


} 