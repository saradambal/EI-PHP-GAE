<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
$UserStamp=$UserStamp;
Class Ctrl_Finance_Outstanding_Payee_list extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Outstanding_Payee_list');
    }
    public function ProfileEmailId()
    {
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $Emaillist = $this->Mdl_eilib_common_function->getProfileEmailId('OPL&ACTIVE CC');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Mdl_eilib_common_function->getErrorMessageList($errorlist);
        $Returnvalues=array($Emaillist,$ErrorMessage);
        echo json_encode($Returnvalues);
    }
    public function FIN_OPL_opllist()
    {
        try
        {
            global $UserStamp;
            $Emailid=$_POST['FIN_OPL_lb_mailid'];
            $Forperiod=$_POST['FIN_OPL_db_period'];
            $this->load->model('EILIB/Mdl_eilib_common_function');
            $EmailDisplayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('OUTSTANDING_PAYEES');
            $this->load->model('FINANCE/FINANCE/Mdl_finance_outstanding_payee_list');
            $confirm_message=$this->Mdl_finance_outstanding_payee_list->OPL_list_creation($UserStamp);
            if($confirm_message[4]=='OPL_list')
            {
                if ($confirm_message[3] == 1) {
                    $mailsub = $confirm_message[0];
                    $mailbody = $confirm_message[1];
                } else {
                    $mailsub = $confirm_message[0];
                    $mailbody = "THERE IS NO OUTSTANDING PAYEES FOR <MONTH-YEAR>";
                    $mailbody = str_replace("<MONTH-YEAR>", $Forperiod, $mailbody);
                }
                $message1 = new Message();
                $message1->setSender($EmailDisplayname . '<' . $UserStamp . '>');
                $message1->addTo($Emailid);
                $message1->setSubject($mailsub);
                $message1->setHtmlBody($mailbody);
                $message1->send();
                echo json_encode('1');
            }
            else
            {
               echo json_encode($confirm_message);
            }
        }
        catch (\InvalidArgumentException $e)
        {
            echo $e;
        }
    }
}