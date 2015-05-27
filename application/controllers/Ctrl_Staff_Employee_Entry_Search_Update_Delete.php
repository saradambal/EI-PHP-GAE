<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Staff_Employee_Entry_Search_Update_Delete extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('EXPENSE/Vw_staff_employee_entry_search_update_delete.php');
    }
    //FUNCTION FOR INITIAL DATA
    public function Initialdata(){
        $this->load->model('Common');
        $errorlist= $this->input->post('ErrorList');
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $query=$this->Mdl_staff_employee_entry_search_update_delete->Initialdata($ErrorMessage);
        echo json_encode($query);
    }
    //FUNCTION FOR SAVE PART
    public function EMP_ENTRY_save()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $result = $this->Mdl_staff_employee_entry_search_update_delete->EMP_ENTRY_insert($USERSTAMP) ;
        echo JSON_encode($result);
    }
}