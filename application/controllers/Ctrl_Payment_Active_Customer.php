<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Payment_Active_Customer extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/Vw_Paymeny_Active_Customer');
    }
    public function PaymentInitialDatas()
    {
        $this->load->model('EILIB/Common_function');
        $unit = $this->Common_function->getAllActiveUnits();
        $paymenttype=$this->Common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
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
    public function ActiveCustomerLeasePeriodDates()
    {
        $this->load->model('EILIB/Common_function');
        $unit=$_POST['UNIT'];
        $customer=$_POST['CUSTOMERID'];
        $Recever=$_POST['RECVER'];
        $Customer = $this->Common_function->getActive_Customer_Recver_Dates($unit,$customer,$Recever);
        echo json_encode($Customer);
    }
    public function PaymentEntrySave()
    {
     global $UserStamp;
     $unit=$_POST['UNIT'];
     $customerid=$_POST['CUSTOMERID'];
     $leaseperiod=$_POST['LP'];
     $paymenttype=$_POST['PAYMENT'];
     $amount=$_POST['AMOUNT'];
     $flag=$_POST['FLAG'];
     $forperiod=$_POST['FORPERIOD'];
     $paiddate=$_POST['PAIDDATE'];
     $comments=$_POST['Comments'];
     $this->load->model('FINANCE/Mdl_financemodel');
     $Confirm_message = $this->Mdl_financemodel->FinanceEntrySave($unit,$customerid,$leaseperiod,$paymenttype,$amount,$forperiod,$paiddate,$comments,$flag,$UserStamp);
     echo json_encode($Confirm_message);
    }
}