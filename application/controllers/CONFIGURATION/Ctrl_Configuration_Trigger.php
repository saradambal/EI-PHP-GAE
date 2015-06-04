<?php
include 'GET_USERSTAMP.php';
include 'GET_CONFIG.php';
//require_once 'google/appengine/api/mail/Message.php';
//use google\appengine\api\mail\Message;
$UserStamp=$UserStamp;
Class Ctrl_Configuration_Trigger extends CI_Controller
{
    public function Index()
    {
    $this->load->view('CONFIGURATION/TRIGGER/Vw_Configuration_Trigger');
    }
    public function TriggerConfiguration()
    {
        $this->load->model('CONFIGURATION/TRIGGER/Mdl_configuration_trigger');
        $data = $this->Mdl_configuration_trigger->getTriggerConfiguration();
        echo json_encode($data);
    }
    public function CSV_Updation()
    {
        $this->load->library('Google');
        global $ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token;
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $service = $this->Mdl_eilib_common_function->get_service($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token);
        $this->load->model('CONFIGURATION/TRIGGER/Mdl_configuration_trigger');
        $CSV_Records=$this->Mdl_configuration_trigger->getCSVfileRecords($service);
        echo json_encode($CSV_Records);
    }
    public function Monthlypaymentreminder()
    {
        try {
            global $UserStamp;
            $this->load->model('CONFIGURATION/TRIGGER/Mdl_configuration_trigger');
            $data = $this->Mdl_configuration_trigger->getMonthlyPaymentReminder();
            $Displayname = $data[0];
            $EmailSubject = $data[1];
            $EmailBody = $data[2];
            for ($i = 0; $i < count($data[3]); $i++) {
                $EmailSubject = str_replace('[CURRENT_MONTH]', '', $EmailSubject);
                $EmailBody = str_replace('[CUSTOMER_NAME]', $data[3][$i], $EmailBody);
                $EmailBody = str_replace('[UNIT-NO]', $data[6][$i], $EmailBody);
                $EmailBody = str_replace('[RENTAL_AMOUNT]', $data[4][$i], $EmailBody);
                $message1 = new Message();
                $message1->setSender($Displayname . '<' . $UserStamp . '>');
                $message1->addTo($data[5][$i]);
                $message1->setSubject($EmailSubject);
                $message1->setHtmlBody($EmailBody);
                $message1->send();
            }
            echo json_encode('SUCCESS');
        }
        catch (Exception $e)
        {
            echo $e->getMessage();

        }
    }
   public function Nonpaymentreminder()
    {
        $this->load->model('CONFIGURATION/TRIGGER/Mdl_configuration_trigger');
        $data = $this->Mdl_configuration_trigger->getNonPaymentReminder();
    }

}