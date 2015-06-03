<?php
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
Class Ctrl_Finance_Payments_Entry_Terminated_Customer extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Payments_Entry_Terminated_Customer');
    }
    public function PaymentInitialDatas()
    {
        global $UserStamp;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $this->load->model('FINANCE/FINANCE/Mdl_Finance_Payments_Entry_Terminated_Customer');
        $unit = $this->Mdl_Finance_Payments_Entry_Terminated_Customer->FIN_payment_Customer($UserStamp);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
    }
    public function Term_PaymentEntry_Save()
    {
        global $UserStamp;
        $this->load->model('FINANCE/FINANCE/Mdl_Finance_Payments_Entry_Terminated_Customer');
        $Confirm_Mesaage = $this->Mdl_Finance_Payments_Entry_Terminated_Customer->FIN_Payment_EntrySave($UserStamp);
        echo json_encode($Confirm_Mesaage);
    }
}