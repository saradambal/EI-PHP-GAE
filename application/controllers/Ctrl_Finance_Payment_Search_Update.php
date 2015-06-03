<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Finance_Payment_Search_Update extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Payment_Search_Update');
    }
    public function InitialDataLoad()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $unit = $this->Mdl_eilib_common_function->getAllUnits();
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
        $searchOption=$this->Mdl_finance_payments_entry_active_customer->getSearchOption();
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage,$searchOption);
        echo json_encode($ReturnValues);
    }
    public function PaymentsearchData()
    {
         global $UserStamp;
         $SearchOption=$_POST['Option'];
         $unit=$_POST['Unit'];
         $Customer=$_POST['Customer'];
         $Fromdate=$_POST['FromDate'];
         $Todate=$_POST['Todate'];
         $fromamount=$_POST['Fromamount'];
         $toamount=$_POST['Toamount'];
         $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
         $searchResults=$this->Mdl_finance_payments_entry_active_customer->getSearchResults($SearchOption,$unit,$Customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp);
         echo json_encode($searchResults);
    }
    public function UnitCustomer()
    {
        $unit=$_POST['Unit'];
        $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
        $searchResults=$this->Mdl_finance_payments_entry_active_customer->getUnitCustomer($unit);
        echo json_encode($searchResults);
    }
    public function PaymentsearchRowDetails()
    {
       $unit=$_POST['Unit'];
       $customerid=$_POST['Customerid'];
       $Rowid=$_POST['Rowid'];
       $Recver=$_POST['Recversion'];
       $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
       $searchResults=$this->Mdl_finance_payments_entry_active_customer->getPaymentRowDetails($Rowid);
       $LPsearchResults=$this->Mdl_finance_payments_entry_active_customer->getPaymentRowLPDetails($customerid,$unit);
       $Returnvalues=array($searchResults,$LPsearchResults,$Recver);
       echo json_encode($Returnvalues);
    }
    public function PaymentUpdationDetails()
    {
        global $UserStamp;
        $this->load->model('FINANCE/FINANCE/Mdl_finance_payments_entry_active_customer');
        $Create_confirm=$this->Mdl_finance_payments_entry_active_customer->Payment_Updation($UserStamp);
        print_r($Create_confirm);
    }
    public function PaymentsDetails()
    {
        global $UserStamp;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Rowid=$_POST['Rowid'];
        $Create_confirm=$this->Mdl_eilib_common_function->DeleteRecord(18,$Rowid,$UserStamp);
        print_r($Create_confirm);
    }
}