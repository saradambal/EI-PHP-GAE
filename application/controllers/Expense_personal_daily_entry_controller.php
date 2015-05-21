<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Expense_personal_daily_entry_controller extends CI_Controller{
// initial form
    public function index()
    {
//        $this->load->view('Menu_view');
        $this->load->view('EXPENSE/Expense_personal_daily_entry_view');
    }
// fetch data
    public function commondata()
    {
        $this->load->model('Common');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        $this->load->database();
        $this->load->model('Expense_personal_daily_entry_model');
        $data=$this->Expense_personal_daily_entry_model->common_data($ErrorMessage);
        echo json_encode($data);
    }
// CAR EXPENSE SAVE FUNCTION
    public function carexpensesave()
    {
        global $USERSTAMP;
        $this->load->model('Expense_personal_daily_entry_model');
        $result = $this->Expense_personal_daily_entry_model->carexpenseinsert($USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }
// CAR LOAN SAVE FUNCTION
    public function carloansave()
    {
        global $USERSTAMP;
        $this->load->model('Expense_personal_daily_entry_model');
        $result = $this->Expense_personal_daily_entry_model->carloaninsert($USERSTAMP) ;
        if ($result == TRUE) {
            $flag=1;
        } else {
            $flag=0;
        }
        echo $flag;
    }

//BABY AND PERSONAL SAVE FUNCTION
    public function babypersonalsave()
    {
        global $USERSTAMP;
        $this->load->model('Expense_personal_daily_entry_model');
        $result = $this->Expense_personal_daily_entry_model->babypersonalinsert($USERSTAMP) ;
        echo JSON_encode($result);

    }


}