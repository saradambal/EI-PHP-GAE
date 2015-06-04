<?php
Class Ctrl_Finance_Payments_Entry_Terminated_Customer extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_Finance_Payments_Entry_Terminated_Customer');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Payments_Entry_Terminated_Customer');
    }
    public function PaymentInitialDatas()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $paymenttype=$this->Mdl_eilib_common_function->getPaymenttype();
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $unit = $this->Mdl_Finance_Payments_Entry_Terminated_Customer->FIN_payment_Customer($UserStamp);
        $ReturnValues=array($unit,$paymenttype,$ErrorMessage);
        echo json_encode($ReturnValues);
    }
    public function Term_PaymentEntry_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Confirm_Mesaage = $this->Mdl_Finance_Payments_Entry_Terminated_Customer->FIN_Payment_EntrySave($UserStamp);
        echo json_encode($Confirm_Mesaage);
    }
}