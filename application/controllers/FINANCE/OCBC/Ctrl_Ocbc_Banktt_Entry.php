<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;
class Ctrl_Ocbc_Banktt_Entry extends CI_Controller
{
    function __construct() {
        parent::__construct();
        $this->load->model('FINANCE/OCBC/Mdl_Ocbc_Banktt_Entry');
        $this->load->model('EILIB/Mdl_eilib_common_function');
    }
    public function index()
    {
        $this->load->view('FINANCE/OCBC/Vw_Ocbc_Banktt_Entry');
    }
    public function Initialdata()
    {
        $query=$this->Mdl_Ocbc_Banktt_Entry->Initial_data();
        echo json_encode($query);
    }
    public function Customername(){
        $unitno= $this->input->post('unitno');
        $query=$this->Mdl_Ocbc_Banktt_Entry->Customer_name($unitno);
        echo json_encode($query);
    }
    public function Banktt_Entry_Save()
    {
        $UserStamp=$this->Mdl_eilib_common_function->getSessionUserStamp();
        $Confirmmessage=$this->Mdl_Ocbc_Banktt_Entry->Banktt_EntrySave($UserStamp);
        if($Confirmmessage[0]==1)
        {
            $message1 = new Message();
            $message1->setSender($Confirmmessage[3].'<'.$UserStamp.'>');
            $message1->addTo($Confirmmessage[4][0]);
            $message1->addCc($Confirmmessage[4][1]);
            $message1->setSubject($Confirmmessage[1]);
            $message1->setHtmlBody($Confirmmessage[2]);
            $message1->send();
        }
        echo json_encode($Confirmmessage[0]);
    }
}