<?php
include 'GET_USERSTAMP.php';
$USERSTAMP=$UserStamp;
$timeZoneFrmt=$timeZoneFormat;
class Ctrl_Unit_Creation_Search_Update extends CI_Controller{
    public function index(){
        $this->load->view('UNIT/Vw_Unit_Creation_Search_Update');
    }
    public function Initialdata(){
        $flag= $this->input->post('flag');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Initial_data($flag);
        echo json_encode($query);
    }
    public function Check_existinginput(){
        $source= $this->input->post('source');
        $chkinput= $this->input->post('chkinput');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Check_existing_input($source,$chkinput);
        echo json_encode($query);
    }
    public function Unitsaveprocess(){
        global $USERSTAMP;
        $UC_nonei= $this->input->post('UC_cb_nonEI');
        $UC_newroomtype = $this->input->post('UC_tb_newroomtype');
        $UC_newstamptype = $this->input->post('UC_tb_newstamptype');
        $UC_oldroomtype = $this->input->post('UC_lb_roomtype');
        $UC_oldstamptype = $this->input->post('UC_lb_stamptype');
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Unit_saveprocess($UC_nonei,$UC_newroomtype,$UC_newstamptype,$UC_oldroomtype,$UC_oldstamptype,$USERSTAMP);
        echo json_encode($query);
    }
    //--------------------------------------------UNIT SEARCH AND UPDATE---------------------------------------------//
    public function USU_Initialdata(){
        $this->load->model('Mdl_unit_creation_search_update');
        $query=$this->Mdl_unit_creation_search_update->Usu_initial_data();
        echo json_encode($query);
    }
    public function USU_Searchbyoption(){
        $option = $this->input->post('option');
        $USU_parentfunc_load = $this->input->post('USU_parentfunc_load');
        $USU_not_load_lb = $this->input->post('USU_not_load_lb');
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_searchby_option($option,$USU_parentfunc_load,$USU_not_load_lb);
        echo json_encode($resultquery);
    }
    public function USU_AlreadyExists(){
        global $USERSTAMP;
        $inventory_unitno = $this->input->post('inventory_unitno');
        $typeofcard = $this->input->post('typeofcard');
        $flag_card_unitno = $this->input->post('flag_card_unitno');
        $USU_parent_func = $this->input->post('USU_parent_func');
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->USU_already_exists($inventory_unitno,$typeofcard,$flag_card_unitno,$USU_parent_func,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_flexttable(){
        global $timeZoneFrmt;
        global $USERSTAMP;
        $USU_all_searchby='';
        $USU_parent_updation='';
        $USU_unit_searchby = $this->input->post('USU_lb_searchby');
        $USU_dutyamt_fromamt = $this->input->post('USU_tb_dutyamt_fromamt');
        $USU_dutyamt_toamt = $this->input->post('USU_tb_dutyamt_toamt');
        $USU_payment_frmamt = $this->input->post('USU_tb_payment_fromamt');
        $USU_payment_toamt = $this->input->post('USU_tb_payment_toamt');
        $USU_frmdate = $this->input->post('USU_db_fromdate');
        $USU_enddate = $this->input->post('USU_db_todate');
        $USU_unino=$this->input->post('USU_lb_unitno');
        $USU_roomtype=$this->input->post('USU_lb_roomtyps');
        $USU_accesscard = $this->input->post('USU_lb_cardno');
        if($USU_unino!='SELECT' && $USU_unino!='' && $USU_unino!='null'){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!='' && $USU_roomtype!='null'){
            $USU_all_searchby=$USU_roomtype;
        }
        $this->load->model('Mdl_unit_creation_search_update');
        $resultquery=$this->Mdl_unit_creation_search_update->Usu_flext_table($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP);
        echo json_encode($resultquery);
    }
    public function USU_roomstamp_unitno(){
        $USU_unitno=$this->input->post("unitstamp_unitno");
        $this->load->model('Mdl_unit_creation_search_update');
        $resquery=$this->Mdl_unit_creation_search_update->USU_roomstampunitno($USU_unitno);
        echo json_encode($resquery);
    }
    public function USU_func_update(){
        global $timeZoneFrmt;
        global $USERSTAMP;
        $USU_form_values=$this->input->post("USU_obj_formvalues");
        $USU_obj_rowvalue=$this->input->post("USU_obj_rowvalue");
        $USU_obj_flex=$this->input->post("USU_obj_flex");
        $USU_upd_selectoption_unit= $USU_form_values['USU_lb_selectoption_unit'];
        $USU_upd_unitid_stampid = $USU_form_values['USU_radio_flex'];
        $USU_upd_startdate_update = $USU_form_values['USU_db_startdate_update'];
        $USU_upd_unitno = $USU_form_values['USU_tb_unitno'];
        $USU_upd_enddate_update = $USU_form_values['USU_db_enddate_update'];
        $USU_upd_unitdeposit = $USU_form_values['USU_tb_unitdeposit'];
        $USU_upd_obsolete = $USU_form_values['USU_hidden_obsolete'];
        $USU_upd_unitpayment = $USU_form_values['USU_tb_unitreltal'];
        $USU_upd_accnoid = $USU_form_values['USU_tb_accnoid'];
        $USU_upd_accname = $USU_form_values['USU_tb_accname'];
        $USU_upd_bankcodeid = $USU_form_values['USU_tb_bankcodeid'];
        $USU_upd_branchcode = $USU_form_values['USU_tb_branchcode'];
        $USU_upd_nonei = $USU_form_values['USU_cb_nonei'];
        $USU_upd_bankaddr = $USU_form_values['USU_tb_bankaddr'];
        $USU_upd_comments = $USU_form_values['USU_ta_comments'];
        $USU_upd_roomtype = $USU_form_values['USU_tb_sep_roomtype'];
        $USU_update_stamptype = $USU_form_values['USU_tb_sep_stamptype'];
        $USU_upd_lb_stamptype = $USU_form_values['USU_lb_stamptype'];
        $USU_upd_access = $USU_form_values['USU_tb_access'];
        $USU_upd_access_comments = $USU_form_values['USU_ta_accesscomment'];
        $USU_upd_accunitno = $USU_form_values['USU_tb_accunitno'];
        $USU_sep_upd_roomtype = $USU_form_values['USU_tb_sep_roomtype'];
        $USU_sep_update_stamptype = $USU_form_values['USU_tb_sep_stamptype'];
        $USU_upd_lost = $USU_form_values['USU_cb_lost'];
        $USU_upd_inventory = $USU_form_values['USU_cb_inventory'];
        $USU_update_lb_roomtype = $USU_form_values['USU_lb_roomtype'];
        $USU_upd_tb_stampamt = $USU_form_values['USU_tb_stampamt'];
        $USU_update_lb_stampdate = $USU_form_values['USU_db_stampdate'];
        $USU_upd_typeofcard = $USU_form_values['USU_typeofCard'];
        $USU_cb_inventory=$USU_form_values['USU_cb_inventory'];
        $USU_cb_lost=$USU_form_values['USU_cb_lost'];

        $USU_all_searchby='';
        $USU_unit_searchby = $USU_obj_flex['USU_lb_searchby'];
        $USU_dutyamt_fromamt = $USU_obj_flex['USU_tb_dutyamt_fromamt'];
        $USU_dutyamt_toamt = $USU_obj_flex['USU_tb_dutyamt_toamt'];
        $USU_payment_frmamt = $USU_obj_flex['USU_tb_payment_fromamt'];
        $USU_payment_toamt = $USU_obj_flex['USU_tb_payment_toamt'];
        $USU_frmdate = $USU_obj_flex['USU_db_fromdate'];
        $USU_enddate = $USU_obj_flex['USU_db_todate'];
        $USU_unino=$USU_obj_flex['USU_lb_unitno'];
        $USU_roomtype=$USU_obj_flex['USU_lb_roomtyps'];
        $USU_accesscard = $USU_obj_flex['USU_lb_cardno'];
        $USU_parent_updation = $USU_obj_flex['USU_parent_updation'];
        if($USU_parent_updation!=''){
            $USU_parent_updation=$USU_parent_updation;
        }
        else{
            $USU_parent_updation='';
        }
        if($USU_unino!='SELECT' && $USU_unino!=''){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!=''){
            $USU_all_searchby=$USU_roomtype;
        }
        $this->load->model('Mdl_unit_creation_search_update');
        $resltquery=$this->Mdl_unit_creation_search_update->USU_funcupdate($USU_upd_selectoption_unit,$USU_upd_unitid_stampid,$USU_upd_startdate_update
            ,$USU_upd_unitno,$USU_upd_enddate_update,$USU_upd_unitdeposit,$USU_upd_obsolete,$USU_upd_unitpayment,$USU_upd_accnoid,$USU_upd_accname
            ,$USU_upd_bankcodeid,$USU_upd_branchcode,$USU_upd_nonei,$USU_upd_bankaddr,$USU_upd_comments,$USU_upd_roomtype,$USU_update_stamptype
            ,$USU_upd_lb_stamptype,$USU_upd_access,$USU_upd_access_comments,$USU_upd_accunitno,$USU_sep_upd_roomtype,$USU_sep_update_stamptype
            ,$USU_upd_lost,$USU_upd_inventory,$USU_update_lb_roomtype,$USU_upd_tb_stampamt,$USU_update_lb_stampdate,$USU_upd_typeofcard,$USU_cb_inventory
            ,$USU_cb_lost,$USU_obj_rowvalue,$USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate
            ,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP);
        echo json_encode($resltquery);
    }
    public function USU_flexttablepdf(){
        global $timeZoneFrmt;
        global $USERSTAMP;
        $this->load->library('pdf');
        $USU_all_searchby='';
        $USU_parent_updation='';
        $USU_unit_searchby = $this->input->get('USU_lb_searchby');
        $USU_dutyamt_fromamt = $this->input->get('USU_tb_dutyamt_fromamt');
        $USU_dutyamt_toamt = $this->input->get('USU_tb_dutyamt_toamt');
        $USU_payment_frmamt = $this->input->get('USU_tb_payment_fromamt');
        $USU_payment_toamt = $this->input->get('USU_tb_payment_toamt');
        $USU_frmdate = $this->input->get('USU_db_fromdate');
        $USU_enddate = $this->input->get('USU_db_todate');
        $USU_unino=$this->input->get('USU_lb_unitno');
        $USU_roomtype=$this->input->get('USU_lb_roomtyps');
        $USU_accesscard = $this->input->get('USU_lb_cardno');
        if($USU_unino!='SELECT' && $USU_unino!='' && $USU_unino!='null'){
            $USU_all_searchby=$USU_unino;
        }
        elseif($USU_roomtype!='SELECT' && $USU_roomtype!='' && $USU_roomtype!='null'){
            $USU_all_searchby=$USU_roomtype;
        }
        $pdfresult='';
        $this->load->model('Mdl_unit_creation_search_update');
        $pdfresult=$this->Mdl_unit_creation_search_update->Usu_flext_table_pdf($USU_unit_searchby,$USU_dutyamt_fromamt,$USU_dutyamt_toamt,$USU_payment_frmamt,$USU_payment_toamt,$USU_frmdate,$USU_enddate,$USU_all_searchby,$USU_accesscard,$USU_parent_updation,$timeZoneFrmt,$USERSTAMP);
        $pdfheader='';
        if($USU_unit_searchby==1){$pdfheader='DETAILS FOR THE INVENTORY CARD: '.$USU_accesscard;}
        elseif($USU_unit_searchby==2){$pdfheader='STAMP DUTY AMOUNT DETAIL BETWEEN '.$USU_dutyamt_fromamt.' AND '.$USU_dutyamt_toamt;}
        elseif($USU_unit_searchby==3){$pdfheader='END DATE BETWEEN '.$USU_frmdate.' AND '.$USU_enddate;}
        elseif($USU_unit_searchby==4){$pdfheader='UNIT PAYMENT AMOUNT DETAIL BETWEEN '.$USU_payment_frmamt.' AND '.$USU_payment_toamt;}
        elseif($USU_unit_searchby==5){$pdfheader='LIST OF ROOM TYPE';}
        elseif($USU_unit_searchby==6){$pdfheader='START DATE BETWEEN '.$USU_frmdate.' AND '.$USU_enddate;}
        elseif($USU_unit_searchby==7){$pdfheader='DETAILS FOR THE UNIT NUMBER '.$USU_unino;}
        elseif($USU_unit_searchby==8){$pdfheader='LIST OF STAMP TYPE';}
        elseif($USU_unit_searchby==9){$pdfheader='DETAILS FOR THE ROOM TYPE: '.$USU_roomtype;}
        $pdf = $this->pdf->load();
        if($USU_unit_searchby==5 || $USU_unit_searchby==8){
            $pdf=new mPDF('utf-8','A4');
        }
        elseif($USU_unit_searchby==7){
            $pdf=new mPDF('utf-8',array(400,250));
        }
        else{
            $pdf=new mPDF('utf-8',array(380,200));
        }
        $pdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">'.$pdfheader.'</div>', 'O', true);
        $pdf->SetHTMLFooter('<div style="text-align: center;">{PAGENO}</div>');
        $pdf->WriteHTML($pdfresult);
        $pdf->Output($pdfheader.'.pdf', 'D');
    }
}