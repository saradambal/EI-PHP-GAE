<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Ocbc_Forms extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/Vw_OCBC');
    }
    public function Fin_OCBC_Submit()
    {
        $Period=$_POST['Period'];
        $this->load->model('EILIB/Common_function');
        $unit = $this->Common_function->getAllActiveUnits();
        $paymenttype=$this->Common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/Mdl_ocbcmodel');
        $SubmittedData=$this->Mdl_ocbcmodel->getOCBCData($Period);
        $values=array($SubmittedData,$unit,$paymenttype,$ErrorMessage);
        echo json_encode($values);
    }
    public function ActiveCustomer()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_POST['UNIT'];
        $Customer = $this->Common_function->getActive_Customer($unit);
        echo json_encode($Customer);
    }
    public function ActiveCustomerLeasePeriod()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_POST['UNIT'];
        $customer=$_POST['CUSTOMERID'];
        $Customer = $this->Common_function->getActive_Customer_LP($unit,$customer);
        echo json_encode($Customer);
    }
    public function OCBC_Record_Save()
    {
        global $UserStamp;
        $unit=$_POST['UNIT'];
        $customerid=$_POST['CUSTOMERID'];
        $recver=$_POST['LP'];
        $payment=$_POST['PAYMENT'];
        $amount=$_POST['AMOUNT'];
        $period=$_POST['FORPERIOD'];
        $comments=$_POST['COMMENTS'];
        $comments=$this->db->escape_like_str($comments);
        $flag=$_POST['FLAG'];
        $id=$_POST['ID'];
        $this->load->model('FINANCE/Mdl_ocbcmodel');
        $Result = $this->Mdl_ocbcmodel->RecordSave($unit,$customerid,$recver,$payment,$amount,$period,$comments,$flag,$id,$UserStamp);
        echo json_encode($Result);
    }
}