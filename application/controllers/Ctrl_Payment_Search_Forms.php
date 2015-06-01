<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Payment_Search_Forms extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/Form_Payment_Search_Upadte');
    }
    public function InitialDataLoad()
    {
        $this->load->model('Eilib/Common_function');
        $unit = $this->Common_function->getAllUnits();
        $paymenttype=$this->Common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/Mdl_financemodel');
        $searchOption=$this->Mdl_financemodel->getSearchOption();
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
         $this->load->model('FINANCE/Mdl_financemodel');
         $searchResults=$this->Mdl_financemodel->getSearchResults($SearchOption,$unit,$Customer,$Fromdate,$Todate,$fromamount,$toamount,$UserStamp);
         echo json_encode($searchResults);
    }
    public function UnitCustomer()
    {
        $unit=$_POST['Unit'];
        $this->load->model('FINANCE/Mdl_financemodel');
        $searchResults=$this->Mdl_financemodel->getUnitCustomer($unit);
        echo json_encode($searchResults);
    }
    public function PaymentsearchRowDetails()
    {
       $unit=$_POST['Unit'];
       $customerid=$_POST['Customerid'];
       $Rowid=$_POST['Rowid'];
       $Recver=$_POST['Recversion'];
       $this->load->model('FINANCE/Mdl_financemodel');
       $searchResults=$this->Mdl_financemodel->getPaymentRowDetails($Rowid);
       $LPsearchResults=$this->Mdl_financemodel->getPaymentRowLPDetails($customerid,$unit);
       $Returnvalues=array($searchResults,$LPsearchResults,$Recver);
       echo json_encode($Returnvalues);
    }
    public function PaymentUpdationDetails()
    {
        global $UserStamp;
        $this->load->model('FINANCE/Mdl_financemodel');
        $Create_confirm=$this->Mdl_financemodel->Payment_Updation($UserStamp);
        print_r($Create_confirm);
    }
    public function PaymentsDetails()
    {
        global $UserStamp;
        $this->load->model('Eilib/Common_function');
        $Rowid=$_POST['Rowid'];
        $Create_confirm=$this->Common_function->DeleteRecord(18,$Rowid,$UserStamp);
        print_r($Create_confirm);
    }
}