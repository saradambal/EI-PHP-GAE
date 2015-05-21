<?php
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


} 