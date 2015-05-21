<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Staff_Detail_Entry_Search_Update_Delete extends CI_Controller{
    //FUNCTION FOR INDEX FILE
    public function index()
    {
        $this->load->view('EXPENSE/Vw_staff_detail_entry_search_update_delete.php');
    }
    public function STDTL_INPUT_getempname(){
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $query = $this->Mdl_staff_detail_entry_search_update_delete->getstaffname($this->input->post('STDTL_INPUT_searchby'));
        $Values=array($query);
        echo json_encode($Values);
    }
    //FUNCTION FOR ERR MSGS
    public function Initaildatas()
    {
        $this->load->model('Common');
        $formname=$_REQUEST['Formname'];
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common->getErrorMessageList($errorlist);
        echo json_encode($ErrorMessage);
    }
    //SAVE PART
    public function STDTL_INPUT_save()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $data['final_array'] = $this->Mdl_staff_detail_entry_search_update_delete->save_models($USERSTAMP,$this->input->post('STDTL_INPUT_radioemployid'),$this->input->post('STDTL_INPUT_employeenameid'),$this->input->post('STDTL_INPUT_cpfnumber'),$this->input->post('STDTL_INPUT_cpfamount'),$this->input->post('STDTL_INPUT_levyamount'),$this->input->post('STDTL_INPUT_salaryamount'),$this->input->post('STDTL_INPUT_comments'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
//        print_r($data);
//        exit;
    }
    //ALREADY EXIT FUNCTION
    public function STDTL_INPUT_already()
    {
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $data['script_name_already_exits_array'] = $this->Mdl_staff_detail_entry_search_update_delete->cpfno_exists($this->input->post('STDTL_INPUT_Cpfno'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //FUNCTION FOR GET EMP ND CPF NO
    public function STDTL_SEARCH_empcpfnoresult(){
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $Values = $this->Mdl_staff_detail_entry_search_update_delete->getempcpfno();
//        $Values=array($query);
        echo json_encode($Values);
    }
    // fetch data
    public function fetchdata()
    {
        $STDTL_SEARCH_cpfnumber=$_POST['STDTL_SEARCH_cpfnumber'];
        $STDTL_SEARCH_staffexpense_selectquery=$_POST['STDTL_SEARCH_staffexpense_selectquery'];
        $STDTL_SEARCH_cpffrom_form=$_POST['STDTL_SEARCH_cpffrom_form'];
        $STDTL_SEARCH_cpfto_form=$_POST['STDTL_SEARCH_cpfto_form'];
        $STDTL_SEARCH_staffcommentstxt=$_POST['STDTL_SEARCH_staffcommentstxt'];
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $data=$this->Mdl_staff_detail_entry_search_update_delete->fetch_data($STDTL_SEARCH_staffexpense_selectquery,$STDTL_SEARCH_cpfnumber,$STDTL_SEARCH_cpffrom_form,$STDTL_SEARCH_cpfto_form,$STDTL_SEARCH_staffcommentstxt);
        echo json_encode($data);
    }
    //FUNCTION FOR UPDATE PART
    public function updatefunction()
    {
        global $USERSTAMP;
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $result = $this->Mdl_staff_detail_entry_search_update_delete->update_data($USERSTAMP,$this->input->post('id'),$this->input->post('STDTL_SEARCH_cpfnumber'),$this->input->post('STDTL_SEARCH_cpfamount'),$this->input->post('STDTL_SEARCH_levyamount'),$this->input->post('STDTL_SEARCH_salaryamount'),$this->input->post('STDTL_SEARCH_comments')) ;
        echo JSON_encode($result);
    }
    //DELETE OPTION
    public function deleteoption(){
        global $USERSTAMP;
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $result = $this->Mdl_staff_detail_entry_search_update_delete->deleteoption($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
    //FUNCTION FOR DELETE CONFORM
    public function deleteconformoption(){
        global $USERSTAMP;
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $result = $this->Mdl_staff_detail_entry_search_update_delete->DeleteRecord($USERSTAMP,$this->input->post('rowid')) ;
        echo JSON_encode($result);
    }
    //ALREADY EXIT FUNCTION
    public function dataupd_exists()
    {
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $data['already_exits_array'] = $this->Mdl_staff_detail_entry_search_update_delete->updcpfno_exists($this->input->post('tdvalue'));
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }
    //PDLY_SEARCH_lb_comments
    public function STDTL_SEARCH_comments()
    {
        $this->load->model('Mdl_staff_detail_entry_search_update_delete');
        $data=$this->Mdl_staff_detail_entry_search_update_delete->STDTL_SEARCH_comments();
        echo json_encode($data);
    }
}