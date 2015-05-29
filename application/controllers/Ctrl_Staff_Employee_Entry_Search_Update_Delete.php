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
        $result = $this->Mdl_staff_employee_entry_search_update_delete->EMP_ENTRY_insert($USERSTAMP,$this->input->post('EMP_ENTRY_email'),$this->input->post('EMP_ENTRY_comments'),$this->input->post('EMP_ENTRY_radio_null'),$this->input->post('submenu')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR INITIAL DATA FOR SEARCH FORM
    public function EMPSRC_UPD_DEL_searchoptionresult(){
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $query=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_searchoptionresult();
        echo json_encode($query);
    }
    //FUNCTION FOR FETCH DATA
    public function fetchdata()
    {
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $result = $this->Mdl_staff_employee_entry_search_update_delete->fetch_data($this->input->post('EMPSRC_UPD_DEL_lb_designation_listbox'),$this->input->post('emp_first_name'),$this->input->post('emp_last_name'),$this->input->post('EMPSRC_UPD_DEL_ta_mobile'),$this->input->post('EMPSRC_UPD_DEL_lb_employeename_listbox'),$this->input->post('EMPSRC_UPD_DEL_lb_searchoption'),$this->input->post('EMPSRC_UPD_DEL_ta_email'),$this->input->post('EMPSRC_UPD_DEL_ta_comments')) ;
        echo JSON_encode($result);
    }
    //PDLY_SEARCH_lb_comments
    public function EMPSRC_UPD_DEL_comments()
    {
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $data=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_comments($this->input->post('EMPSRC_UPD_DEL_lb_searchoption'));
        echo json_encode($data);
    }
    //FUNCTION FOR GET CARD NO ND UNIT NO DATA
    public function EMPSRC_UPD_DEL_getcardnoandunitno(){
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $query=$this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_getcardnoandunitno($this->input->post('EMPSRC_UPD_DEL_id'));
        echo json_encode($query);
    }
    //FUNCTION FOR SAVE PART
    public function EMPSRC_UPD_DEL_update()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_employee_entry_search_update_delete');
        $result = $this->Mdl_staff_employee_entry_search_update_delete->EMPSRC_UPD_DEL_update($USERSTAMP,$this->input->post('EMPSRC_UPD_DEL_email'),$this->input->post('EMPSRC_UPD_DEL_comments'),$this->input->post('EMP_ENTRY_radio_null'),$this->input->post('submenu'),$this->input->post('EMPSRC_UPD_DEL_carcunitarray'),$this->input->post('EMPSRC_UPD_DEL_id')) ;
        echo JSON_encode($result);
    }
}