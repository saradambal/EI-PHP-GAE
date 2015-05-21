<?php
include 'GET_USERSTAMP.php';
$$UserStamp=$UserStamp;
Class Ctrl_Payment_Terminated_Customer_Forms extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FORM_PAYMENT_TERMINATED_CUSTOMER');
    }
    public function PaymentInitialDatas()
    {
        global $UserStamp;
        $this->load->model('Eilib/Common_function');
        $paymenttype=$this->Common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $this->load->model('Financeterminated_customermodel');
        $unit = $this->Financeterminated_customermodel->FIN_payment_Customer($UserStamp);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
    }
    public function Term_PaymentEntry_Save()
    {
        global $UserStamp;
        $this->load->model('Financeterminated_customermodel');
        $Confirm_Mesaage = $this->Financeterminated_customermodel->FIN_Payment_EntrySave($UserStamp);
        echo json_encode($Confirm_Mesaage);
    }
}