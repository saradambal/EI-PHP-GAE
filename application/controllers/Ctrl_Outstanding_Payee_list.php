<?php
error_reporting(0);
include 'GET_USERSTAMP.php';
$UserStamp=$UserStamp;
Class Ctrl_Outstanding_Payee_list extends CI_Controller
{
    public function Index()
    {
        $this->load->view('FINANCE/FORM_OPL');
    }
    public function ProfileEmailId($formname)
    {
        $this->load->model('Eilib/Common_function');
        $Emaillist = $this->Common_function->getProfileEmailId('OPL&ACTIVE CC');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $Returnvalues=array($Emaillist,$ErrorMessage);
        echo json_encode($Returnvalues);
    }
    public function FIN_OPL_opllist()
    {
        try
        {
            global $UserStamp;
            $this->load->model('Opllistmodel');
            $confirm_message=$this->Opllistmodel->OPL_list_creation($UserStamp);
//            $message1 = new Message();
//            $message1->setSender($name.'<'.$from.'>');
//            $message1->addTo($loginid);
//            $message1->addCc($cclist);
//            $message1->setSubject($confirm_message[0]);
//            $message1->setHtmlBody($confirm_message[1]);
//            $message1->send();
            echo json_encode($confirm_message);
        }
        catch (\InvalidArgumentException $e)
        {
            echo $e;
        }
    }
}