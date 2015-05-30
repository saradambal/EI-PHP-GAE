<?php
include "GET_USERSTAMP.php";
include "GET_CONFIG.php";
$USERSTAMP=$UserStamp;
class Ctrl_Customer_Extension extends CI_Controller{
    public function index(){

        $this->load->view('CUSTOMER/Vw_Customer_Extension');
    }
    public function CEXTN_getCommonvalues()
    {
        $this->load->model('Eilib/Common_function');
        $this->load->model('CUSTOMER/Mdl_Customer_Extension');
        $formname=$_POST['Formname'];
        $errorlist=$_POST['ErrorList'];
        $unit = $this->Mdl_Customer_Extension->CEXTN_getExtnUnitNo();
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
        $this->load->model('CUSTOMER/Mdl_Customer_Extension');
        $customer_IdName = $this->Mdl_Customer_Extension->CEXTN_getCustomerNameId($CEXTN_lb_unitno);
        echo json_encode($customer_IdName);
    }
    public function  CEXTN_getCustomerdtls_result()
    {
        global $USERSTAMP;
        $CEXTN_unitno=$_POST['unitno'];
        $CEXTN_custid=$_POST['customerId'];
        $this->load->model('CUSTOMER/Mdl_Customer_Extension');
        $customer_finaldetls = $this->Mdl_Customer_Extension->CEXTN_getCustomerdtls($CEXTN_custid,$CEXTN_unitno,$USERSTAMP);
        echo json_encode($customer_finaldetls);
    }






}