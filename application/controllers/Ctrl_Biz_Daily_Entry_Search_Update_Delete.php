<?php
include "GET_USERSTAMP.php";
$USERSTAMP=$UserStamp;
class Ctrl_Biz_Daily_Entry_Search_Update_Delete extends CI_Controller{
// initial form
    public function index()
    {
        $this->load->view('EXPENSE/Vw_Biz_Daily_Entry_Search_Update_Delete');
    }
    public function initialvalues()
    {
        $this->load->model('Eilib/Common_function');
        $errorlist=$_REQUEST['ErrorList'];
        $ErrorMessage= $this->Common_function->getErrorMessageList($errorlist);
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->initialvalues($ErrorMessage);
        echo json_encode($data);
    }
    public function BDLY_INPUT_checkexistunit()
    {
        $BDLY_INPUT_unitval=$this->input->post('BDLY_INPUT_unitval');
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_checkexistunit($BDLY_INPUT_unitval);
        echo $data;
    }
    public function BDLY_INPUT_get_unitno()
    {
        $BDLY_INPUT_type=$this->input->post('BDLY_INPUT_type');
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_unitno($BDLY_INPUT_type);
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_balance()
    {
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_balance();
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_cleanername()
    {
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_cleanername();
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_allunitno()
    {
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_allunitno();
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_SEdate()
    {
        $BDLY_INPUT_unitno=$this->input->post('BDLY_INPUT_unitno');
        $this->load->database();
        $this->load->model('Eilib/Common_function');
        $data=$this->Common_function->GetUnitSdEdInvdate($BDLY_INPUT_unitno);
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_values()
    {
        $BDLY_INPUT_unitno=$this->input->post('BDLY_INPUT_unitno');
        $BDLY_INPUT_type=$this->input->post('BDLY_INPUT_type');
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_values($BDLY_INPUT_unitno,$BDLY_INPUT_type);
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_invoiceto()
    {
        $BDLY_INPUT_unit=$this->input->post('BDLY_INPUT_unit');
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_invoiceto($BDLY_INPUT_unit);
        echo json_encode($data);
    }
    public function BDLY_INPUT_save_values()
    {
        global $USERSTAMP;
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_save_values($USERSTAMP);
        echo json_encode($data);
    }
    public function BDLY_INPUT_checkcardno()
    {
        $this->load->database();
        $BDLY_INPUT_cardno=$this->input->post('BDLY_INPUT_cardno');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_checkcardno($BDLY_INPUT_cardno);
        echo $data;
    }
    public function BDLY_INPUT_get_category()
    {
        $this->load->database();
        $BDLY_INPUT_uexp_unit=$this->input->post('BDLY_INPUT_uexp_unit');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_category($BDLY_INPUT_uexp_unit);
        echo json_encode($data);
    }
    public function BDLY_INPUT_get_accno()
    {
        $this->load->database();
        $BDLY_INPUT_star_unitt=$this->input->post('BDLY_INPUT_star_unit');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_INPUT_get_accno($BDLY_INPUT_star_unitt);
        echo json_encode($data);
    }

 //SEARCH AND UPDATE FORM
    public function BDLY_SRC_getInitialvalue()    {

        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getInitialvalue();
        echo json_encode($data);
    }

      public function BDLY_SRC_getSearchOptions()
      {
          global $USERSTAMP;
          $this->load->database();
          $selectedexpense=$this->input->post('selectedexpense');
          $this->load->model('Mdl_biz_daily_entry_search_update_delete');
          $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getSearchOptions($selectedexpense,$USERSTAMP);
          echo json_encode($data)  ;
      }
    public function BDLY_SRC_getAnyTypeExpData()
    {
        global $USERSTAMP;
        global $timeZoneFormat;
        $this->load->database();
        $BDLY_SRC_lb_unitno=$this->input->post('BDLY_SRC_lb_unitno');
        $BDLY_SRC_lb_invoiceto=$this->input->post('BDLY_SRC_lb_invoiceto');
        $BDLY_SRC_comments=$this->input->post('BDLY_SRC_comments');
        $BDLY_SRC_tb_fromamnt=$this->input->post('BDLY_SRC_tb_fromamnt');
        $BDLY_SRC_tb_toamnt=$this->input->post('BDLY_SRC_tb_toamnt');
        $BDLY_SRC_servicedue=$this->input->post('BDLY_SRC_servicedue');
        $BDLY_SRC_lb_cleanername=$this->input->post('BDLY_SRC_lb_cleanername');
        $BDLY_SRC_tb_durationamt=$this->input->post('BDLY_SRC_tb_durationamt');
        $BDLY_SRC_startdate=$this->input->post('BDLY_SRC_startdate');
        $BDLY_SRC_enddate=$this->input->post('BDLY_SRC_enddate');
        $BDLY_SRC_invoicefrom=$this->input->post('BDLY_SRC_invoicefrom');
        $BDLY_SRC_lb_accountno=$this->input->post('BDLY_SRC_lb_accountno');
        $BDLY_SRC_lb_cusname=$this->input->post('BDLY_SRC_lb_cusname');
        $BDLY_SRC_lb_Digvoiceno=$this->input->post('BDLY_SRC_lb_Digvoiceno');
        $BDLY_SRC_lb_cardno=$this->input->post('BDLY_SRC_lb_cardno');
        $BDLY_SRC_lb_carno=$this->input->post('BDLY_SRC_lb_carno');
        $BDLY_SRC_lb_serviceby=$this->input->post('BDLY_SRC_lb_serviceby');
        $BDLY_SRC_invoiceitem=$this->input->post('BDLY_SRC_invoiceitem');
        $BDLY_SRC_lb_category=$this->input->post('BDLY_SRC_lb_category');

        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getAnyTypeExpData($USERSTAMP,$timeZoneFormat,$BDLY_SRC_lb_unitno,$BDLY_SRC_lb_invoiceto,$BDLY_SRC_comments,$BDLY_SRC_comments,$BDLY_SRC_tb_fromamnt,$BDLY_SRC_tb_toamnt,$BDLY_SRC_servicedue,$BDLY_SRC_lb_cleanername,$BDLY_SRC_tb_durationamt,$BDLY_SRC_startdate,$BDLY_SRC_enddate,$BDLY_SRC_invoicefrom,$BDLY_SRC_lb_accountno,$BDLY_SRC_lb_cusname,$BDLY_SRC_lb_Digvoiceno,$BDLY_SRC_lb_cardno,$BDLY_SRC_lb_carno,$BDLY_SRC_lb_serviceby,$BDLY_SRC_invoiceitem,$BDLY_SRC_lb_category);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_get_cleanernameservicedue(){
        $this->load->database();
        $BDLY_SRC_servicedue=$this->input->post('BDLY_SRC_servicedue');
        $selectedSearchopt=$this->input->post('selectedSearchopt');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_cleanername($BDLY_SRC_servicedue,$BDLY_SRC_servicedue,$selectedSearchopt);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_get_cusname(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_cusname(null,$startdate,$enddate);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_get_cusname1(){
        $this->load->database();
        $BDLY_DT_getunit_no=$this->input->post('BDLY_DT_getunit_no');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_cusname($BDLY_DT_getunit_no,"","");
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_get_cusname2(){
        $this->load->database();
        $BDLY_DT_getunit_no=$this->input->post('BDLY_DT_getunit_no');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_cusname($BDLY_DT_getunit_no,"","");
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_get_autocomplete()
    {
        global $USERSTAMP;
        $this->load->database();
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_autocomplete($USERSTAMP);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_getUnitexp_catg()
    {
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getUnitexp_catg($startdate,$enddate,0);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_get_accountno()
    {
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $selectedexpense=$this->input->post('selectedexpense');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_accountno($selectedexpense,$startdate,$enddate);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_invoiceto()
    {
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $selectedexpense=$this->input->post('selectedexpense');
        $selectedSearchopt=$this->input->post('selectedSearchopt');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_invoiceto($selectedexpense,$selectedSearchopt,$startdate,$enddate);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_get_cleanername(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $selectedSearchopt=$this->input->post('selectedSearchopt');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_get_cleanername($startdate,$enddate,$selectedSearchopt);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_getPurchase_card(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getPurchase_card($startdate,$enddate);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_getCarNoList(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getCarNoList($startdate,$enddate);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_getServiceByList(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getServiceByList($startdate,$enddate);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_getUnitList(){
        global $USERSTAMP;
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $selectedexpense=$this->input->post('selectedexpense');
        $selectedSearchopt=$this->input->post('selectedSearchopt');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getUnitList($selectedexpense,$selectedSearchopt,$startdate,$enddate,$USERSTAMP);
        echo json_encode($data)  ;
    }
    public  function  BDLY_SRC_getDigitalVoiceNo(){
        $this->load->database();
        $startdate=$this->input->post('startdate');
        $enddate=$this->input->post('enddate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getDigitalVoiceNo($startdate,$enddate);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_check_access_cardOrUnitno(){
        $this->load->database();
        $inputval=$this->input->post('inputval');
        $BDLY_SRC_selectedexptype=$this->input->post('BDLY_SRC_selectedexptype');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_check_access_cardOrUnitno($inputval,$BDLY_SRC_selectedexptype);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_getUnitDate(){
        $this->load->database();
        $unidate=$this->input->post('unidate');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_getUnitDate($unidate);
        echo json_encode($data)  ;
    }
    public function BDLY_SRC_UpdaterowData(){
        global $USERSTAMP;
        $this->load->database();
        $BDLY_DT_row_new_vals=$this->input->post('BDLY_DT_row_new_vals');
        $BDLY_DT_row_old_vals=$this->input->post('BDLY_DT_row_old_vals');
        $BDLY_SRC_lb_ExpenseList=$this->input->post('BDLY_SRC_lb_ExpenseList');
        $selectedSearchopt=$this->input->post('selectedSearchopt');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_UpdaterowData($BDLY_DT_row_new_vals,$BDLY_DT_row_old_vals,$BDLY_SRC_lb_ExpenseList,$selectedSearchopt,$USERSTAMP);
        echo ($data)  ;
    }
    public function BDLY_SRC_DeleteRowData(){
        global $USERSTAMP;
        $this->load->database();
        $BDLY_SRC_DeleteKey=$this->input->post('BDLY_SRC_DeleteKey');
        $selectedexpense=$this->input->post('selectedexpense');
        $this->load->model('Mdl_biz_daily_entry_search_update_delete');
        $data=$this->Mdl_biz_daily_entry_search_update_delete->BDLY_SRC_DeleteRowData($BDLY_SRC_DeleteKey,$selectedexpense,$USERSTAMP);
        echo ($data)  ;
    }
}