<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Finance_Payments_Entry_Active_Customer extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_finance_payments_entry_active_customer');
    }
    public function PaymentInitialDatas()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit = $this->Mdl_eilib_common_function->getAllActiveUnits();
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
    }
    public function ActiveCustomer()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit=$_POST['UNIT'];
        $Customer = $this->Mdl_eilib_common_function->getActive_Customer($unit);
        echo json_encode($Customer);
    }
    public function ActiveCustomerLeasePeriod()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit=$_POST['UNIT'];
        $customer=$_POST['CUSTOMERID'];
        $Customer = $this->Mdl_eilib_common_function->getActive_Customer_LP($unit,$customer);
        echo json_encode($Customer);
    }
    public function ActiveCustomerLeasePeriodDates()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit=$_POST['UNIT'];
        $customer=$_POST['CUSTOMERID'];
        $Recever=$_POST['RECVER'];
        $Customer = $this->Mdl_eilib_common_function->getActive_Customer_Recver_Dates($unit,$customer,$Recever);
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
     $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
     $Confirm_message = $this->Mdl_finance_payments_entry_active_customer->FinanceEntrySave($unit,$customerid,$leaseperiod,$paymenttype,$amount,$forperiod,$paiddate,$comments,$flag,$UserStamp);
     echo json_encode($Confirm_message);
    }
}