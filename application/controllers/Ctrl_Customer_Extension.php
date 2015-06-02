<?php
include "GET_USERSTAMP.php";
include "GET_CONFIG.php";
$USERSTAMP=$UserStamp;
class Ctrl_Customer_Extension extends CI_Controller{
    public function index(){

        $this->load->view('CUSTOMER/CUSTOMER/Vw_Customer_Extension');
    }
    public function CEXTN_getCommonvalues()
    {
        $this->load->model('Eilib/Common_function');
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $formname=$_POST['Formname'];
        $errorlist=$_POST['ErrorList'];
        $unit = $this->Mdl_customer_extension->CEXTN_getExtnUnitNo();
        $nationality = $this->Common_function->getNationality();
        $EmailList= $this->Common_function->getEmailId($formname);
        $Option= $this->Common_function->getOption();
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Timelist=$this->Common_function->getTimeList();
        $proratedlabel=$this->Common_function->CUST_getProratedWaivedValue();
        $AllUnit =$this->Common_function->getAllActiveUnits();
        $Values=array($unit,$nationality,$EmailList,$Option,$ErrorMessage,$Timelist,$proratedlabel,$AllUnit);
        echo json_encode($Values);
    }
    public function CEXTN_getCustomerNameId_result()
    {
        $CEXTN_lb_unitno=$_POST['unitno'];
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $customer_IdName = $this->Mdl_customer_extension->CEXTN_getCustomerNameId($CEXTN_lb_unitno);
        echo json_encode($customer_IdName);
    }
    public function  CEXTN_getCustomerdtls_result()
    {
        global $USERSTAMP;
        $CEXTN_unitno=$_POST['unitno'];
        $CEXTN_custid=$_POST['customerId'];
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $customer_finaldetls = $this->Mdl_customer_extension->CEXTN_getCustomerdtls($CEXTN_custid,$CEXTN_unitno,$USERSTAMP);
        echo json_encode($customer_finaldetls);
    }
    public function CEXTN_getRoomType(){

        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $CEXTN_rmtype=$this->Mdl_customer_extension->CEXTN_getRoomType($this->input->post('unitno'),$this->input->post('rmtype'));
        echo json_encode($CEXTN_rmtype);
    }
    public  function CEXTN_getdiffunitCardNo(){

        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $final_value=$this->Mdl_customer_extension->CEXTN_getdiffunitCardNo($this->input->post('unitno'),$this->input->post('CEXTN_tb_firstname'),$this->input->post('CEXTN_tb_lastname'));
        echo json_encode($final_value);


    }
    public function CEXTN_SaveDetails(){

        global $UserStamp;
        $this->load->model('CUSTOMER/CUSTOMER/Mdl_customer_extension');
        $final_value=$this->Mdl_customer_extension->CEXTN_SaveDetails($UserStamp);
        echo json_encode($final_value);

    }

}