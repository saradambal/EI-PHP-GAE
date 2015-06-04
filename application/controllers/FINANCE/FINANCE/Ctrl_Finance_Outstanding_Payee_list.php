<?php
error_reporting(0);
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
Class Ctrl_Finance_Outstanding_Payee_list extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/FINANCE/Mdl_finance_outstanding_payee_list');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function Index()
    {
        $this->load->view('FINANCE/FINANCE/Vw_Finance_Outstanding_Payee_list');
    }
    public function ProfileEmailId()
    {
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
            $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
            $Emailid=$_POST['FIN_OPL_lb_mailid'];
            $Forperiod=$_POST['FIN_OPL_db_period'];
            $confirm_message=$this->Mdl_finance_outstanding_payee_list->OPL_list_creation($UserStamp);
            if($confirm_message[4]=='OPL_list')
            {
                $EmailDisplayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('OUTSTANDING_PAYEES');
                if ($confirm_message[3] == 1) {
                    $mailsub = $confirm_message[0];
                    $mailbody = $confirm_message[1];
                    $mailmessage="opllist";
                } else
                {
                    $mailsub = $confirm_message[0];
                    $mailbody = "THERE IS NO OUTSTANDING PAYEES FOR <MONTH-YEAR>";
                    $mailbody = str_replace("<MONTH-YEAR>", $Forperiod, $mailbody);
                    $mailmessage="emptylist";
                }
                $message1 = new Message();
                $message1->setSender($EmailDisplayname . '<' . $UserStamp . '>');
                $message1->addTo($Emailid);
                $message1->setSubject($mailsub);
                $message1->setHtmlBody($mailbody);
                $message1->send();
                echo json_encode($mailmessage);
            }
            else
            {
                $subject='ACTIVE CUST LIST-'.$confirm_message[2];
                $mailbody ="HELLO  ".$confirm_message[1];
                $mailbody=$mailbody.''.'<br><br>, PLEASE FIND ATTACHED THE CURRENT : '.$confirm_message[0];
                $EmailDisplayname = $this->Mdl_eilib_common_function->Get_MailDisplayName('ACTIVE_CC_LIST');
                $message1 = new Message();
                $message1->setSender($EmailDisplayname . '<' . $UserStamp . '>');
                $message1->addTo($Emailid);
                $message1->setSubject($subject);
                $message1->setHtmlBody($mailbody);
                $message1->send();
                echo json_encode('ACTIVECCLIST');
            }
        }
        catch (\InvalidArgumentException $e)
        {
            echo $e;
        }
    }
}