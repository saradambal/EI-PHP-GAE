<?php
class Db_configuration_configuration_entry extends CI_Model{
    //FUNCTION FOR GETTING MODEL NAME
    Public function getscriptname($CONFIG_ENTRY_searchby)
    {
        if($CONFIG_ENTRY_searchby=="CONFIGURATION ENTRY")
        {
        $this->db->select("CNP_ID,CNP_DATA");
        $this->db->order_by("CNP_DATA", "ASC");
        $this->db->from('CONFIGURATION_PROFILE');
        $this->db->where('CNP_ID NOT IN (12,13,6,14,1)');
        $query = $this->db->get();
        return $query->result();
        }
        else{
            $this->db->select("CNP_ID,CNP_DATA");
            $this->db->order_by("CNP_DATA", "ASC");
            $this->db->from('CONFIGURATION_PROFILE');
            $this->db->where('CNP_ID NOT IN (12,13,1)');
            $query = $this->db->get();
            return $query->result();
        }
    }
    //FUNCTION FOR GETTING TYPE NAME
    Public function gettypename($CONFIG_ENTRY_data,$CONFIG_ENTRY_searchby)
    {
        if($CONFIG_ENTRY_searchby=="CONFIGURATION ENTRY")
        {
        $this->db->distinct();
        $this->db->select("CGN_ID,CGN_TYPE");
        $this->db->order_by("CGN_TYPE", "ASC");
        $this->db->from("CONFIGURATION ");
        $this->db->where("CNP_ID='$CONFIG_ENTRY_data' AND (CGN_NON_IP_FLAG is null)");
        $query = $this->db->get();
        return $query->result_array();
        }
        else{
            $this->db->distinct();
            $this->db->select("CGN_ID,CGN_TYPE");
            $this->db->order_by("CGN_TYPE", "ASC");
            $this->db->from("CONFIGURATION");
            $this->db->where("CNP_ID='$CONFIG_ENTRY_data' AND (CGN_NON_IP_FLAG != 'XX' or CGN_NON_IP_FLAG is null)");
            $query = $this->db->get();
            return $query->result_array();
        }
    }
    public function CONF_ENTRY_twodimdata($module){
       $CONF_ENTRY_twodimen=array(3=>array('CCN_ID','CUSTOMER_CONFIGURATION','CCN_DATA','CCN_DATA',25),5=>array('ACN_ID','ACCESS_CONFIGURATION','ACN_DATA',28),
                             8=>array('DDC_ID','DEPOSIT_DEDUCTION_CONFIGURATION','DDC_DATA',31),7=>array('ECN_ID','EXPENSE_CONFIGURATION','ECN_DATA',30),
                             10=>array('NC_ID','NATIONALITY_CONFIGURATION','NC_DATA',34),6=>array('OCN_ID','OCBC_CONFIGURATION','OCN_DATA',29),
                             4=>array('PCN_ID','PAYMENT_CONFIGURATION','PCN_DATA',27),9=>array('TC_ID','TRIGGER_CONFIGURATION','TC_DATA',33),
                             2=>array('UCN_ID','UNIT_CONFIGURATION','UCN_DATA',26),14=>array('URC_ID','USER_RIGHTS_CONFIGURATION','URC_DATA',35),
                             11=>array('BCN_ID','BANKTT_CONFIGURATION','BCN_DATA',37),15=>array('ERMCN_ID','ERM_CONFIGURATION','ERMCN_DATA',36),
                             16=>array('CQCN_ID','CHEQUE_CONFIGURATION','CQCN_DATA',38),17=>array('RCN_ID','REPORT_CONFIGURATION','RCN_DATA',89)
    );
    return array ($CONF_ENTRY_twodimen[$module][0],$CONF_ENTRY_twodimen[$module][1],$CONF_ENTRY_twodimen[$module][2],$CONF_ENTRY_twodimen[$module][3]);
  }
    //FUNCTION FOR SAVE PART
    public function configentrydatainsert($USERSTAMP){
        global  $USERSTAMP;
        $module=$_POST['CONFIG_ENTRY_lb_module'];
        $type=$_POST['CONFIG_ENTRY_lb_type'];
        if($type==42){
        $CONF_ENTRY_tb_subtype_dd=$_POST['CONF_ENTRY_tb_subtype_dd'];
        $CONF_ENTRY_tb_Datadd=$_POST['CONF_ENTRY_tb_Datadd'];
       $insertquery = "INSERT INTO DEPOSIT_DEDUCTION_CONFIGURATION(ULD_ID,CGN_ID,DDC_DATA,DDC_SUB_DATA) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$type','$CONF_ENTRY_tb_subtype_dd','$CONF_ENTRY_tb_Datadd')";
        }
        else{
            $data=$_POST['CONFIG_ENTRY_tb_data'];
       $CONF_ENTRY_twodimen_details = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $insertquery = "INSERT INTO ".$CONF_ENTRY_twodimen_details[1]."(CGN_ID,".$CONF_ENTRY_twodimen_details[2].",ULD_ID) VALUES(".$type.",'".$data."',(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='".$USERSTAMP."'))";
        }
        $this->db->query($insertquery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    public function CONF_ENTRY_twodimflexdata($module){
        $CONF_ENTRY_twodimen=array(3=>array("CUSTOMER_CONFIGURATION","CCN_DATA","DT.CCN_ID AS ID,DT.CCN_DATA AS DATA,DT.CCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.CCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),5=>array("ACCESS_CONFIGURATION","ACN_DATA","DT.ACN_ID AS ID,DT.ACN_DATA AS DATA,DT.ACN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.ACN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),
            8=>array("DEPOSIT_DEDUCTION_CONFIGURATION","DDC_DATA","DT.DDC_ID AS ID,DT.DDC_DATA AS DATA,DT.DDC_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.DDC_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),7=>array("EXPENSE_CONFIGURATION","ECN_DATA","DT.ECN_ID AS ID,DT.ECN_DATA AS DATA,DT.ECN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.ECN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),
            10=>array("NATIONALITY_CONFIGURATION","NC_DATA","DT.NC_ID AS ID,DT.NC_DATA AS DATA,DT.NC_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.NC_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),6=>array("OCBC_CONFIGURATION","OCN_DATA","DT.OCN_ID AS ID,DT.OCN_DATA AS DATA,DT.OCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.OCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),
            4=>array("PAYMENT_CONFIGURATION","PCN_DATA","DT.PCN_ID AS ID,DT.PCN_DATA AS DATA,DT.PCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.PCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),9=>array("TRIGGER_CONFIGURATION","TC_DATA","DT.TC_ID AS ID,DT.TC_DATA AS DATA,DT.TC_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.TC_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),
            2=>array("UNIT_CONFIGURATION","UCN_DATA","DT.UCN_ID AS ID,DT.UCN_DATA AS DATA,DT.UCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.UCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),14=>array("USER_RIGHTS_CONFIGURATION","URC_DATA","DT.URC_ID AS ID,DT.URC_DATA AS DATA,DT.URC_USERSTAMP AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.URC_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP,DT.URC_INITIALIZE_FLAG AS INIFLAG"),
            11=>array("BANKTT_CONFIGURATION","BCN_DATA","DT.BCN_ID AS ID,DT.BCN_DATA AS DATA,DT.BCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.BCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),15=>array("ERM_CONFIGURATION","ERMCN_DATA","DT.ERMCN_ID AS ID,DT.ERMCN_DATA AS DATA,DT.ERMCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.ERMCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),
            16=>array("CHEQUE_CONFIGURATION","CQCN_DATA","DT.CQCN_ID AS ID,DT.CQCN_DATA AS DATA,DT.CQCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.CQCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP"),17=>array("REPORT_CONFIGURATION","RCN_DATA","DT.RCN_ID AS ID,DT.RCN_DATA AS DATA,DT.RCN_INITIALIZE_FLAG AS INIFLAG,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(DT.RCN_TIMESTAMP,'+00:00','+05:30'),'%d-%m-%Y %T') AS TIMESTAMP")
        );
        return array ($CONF_ENTRY_twodimen[$module][0],$CONF_ENTRY_twodimen[$module][1],$CONF_ENTRY_twodimen[$module][2]);
    }
    //FUNCTION FOR FLEX TABLE
    public function config_flexdata($USERSTAMP,$module,$type){
        global  $USERSTAMP;
        $CONF_ENTRY_twodimen_details = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimflexdata($module) ;
     if($module!=14){
        $flex_tble_query =$this->db->query("SELECT ". $CONF_ENTRY_twodimen_details[2]. "  FROM ". $CONF_ENTRY_twodimen_details[0]. " DT,CONFIGURATION C,CONFIGURATION_PROFILE CP,USER_LOGIN_DETAILS ULD WHERE  ULD.ULD_ID=DT.ULD_ID AND CP.CNP_ID='$module' AND DT.CGN_ID=C.CGN_ID AND C.CGN_TYPE= '$type'  ORDER BY DT. ". $CONF_ENTRY_twodimen_details[1]. " ASC ");
       }
      else if($module==8){
            $flex_tble_query =$this->db->query("SELECT DDC.DDC_ID,DDC.DDC_DATA,DDC.DDC_SUB_DATA AS SUBTYPE,ULD.ULD_LOGINID,DDC.DDC_INITIALIZE_FLAG,DATE_FORMAT(CONVERT_TZ(DDC.DDC_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS DDC_TIMESTAMP FROM DEPOSIT_DEDUCTION_CONFIGURATION DDC,CONFIGURATION C,CONFIGURATION_PROFILE CP ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=DDC.ULD_ID AND CP.CNP_ID='$module' AND DDC.CGN_ID=C.CGN_ID AND C.CGN_TYPE='$type' ORDER BY DDC.DDC_DATA ASC ");
        }
     else{
            $flex_tble_query =$this->db->query("SELECT ". $CONF_ENTRY_twodimen_details[2]. "  FROM ". $CONF_ENTRY_twodimen_details[0]. " DT,CONFIGURATION C,CONFIGURATION_PROFILE CP WHERE  CP.CNP_ID='$module' AND DT.CGN_ID=C.CGN_ID AND C.CGN_TYPE= '$type'  ORDER BY DT. ". $CONF_ENTRY_twodimen_details[1]. " ASC ");
        }
        return $flex_tble_query->result();
    }
    // FUNCTION FOR UPDATE PART
    public  function dataupdate($USERSTAMP,$rowid,$module,$type,$data)
    {
        global  $USERSTAMP;
        $CONFIG_SRCH_UPD_arr = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $updatequery = "UPDATE ".$CONFIG_SRCH_UPD_arr[1]." SET ".$CONFIG_SRCH_UPD_arr[2]."= '$data',ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE ".$CONFIG_SRCH_UPD_arr[0]."=".$rowid;
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    public function deleteoption($USERSTAMP,$rowid,$module,$type,$data)
    {
        $tableid = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $rowid=$rowid;
        $deletestmt = "CALL SP_CONFIG_CHECK_TRANSACTION(".$tableid[3].",$rowid,@DELETION_FLAG)";
        $this->db->query($deletestmt);
        $PDLY_INPUT_rs_flag = 'SELECT @DELETION_FLAG as DELETION_FLAG';
        $query = $this->db->query($PDLY_INPUT_rs_flag);
        $successflag=$query->result();
        return $successflag;
    }
    //FUNCTION FOR ALREADY EXIT
    public function data_name_exists($module,$type,$data)
    {
        $CONFIG_ENTRY_arr_config = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $checkquery= "SELECT ".$CONFIG_ENTRY_arr_config[2]." FROM ".$CONFIG_ENTRY_arr_config[1]." CCN WHERE CCN.CGN_ID=(SELECT C.CGN_ID FROM CONFIGURATION C WHERE C.CGN_ID='$type') AND ".$CONFIG_ENTRY_arr_config[2]."='$data'";
        $this->db->query($checkquery);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    //FUNCTION FOR ALREADY EXIT
    public function sub_data_exists($sub_type_data)
    {
        $checkquery= "SELECT DDC_SUB_DATA FROM DEPOSIT_DEDUCTION_CONFIGURATION WHERE DDC_SUB_DATA='$sub_type_data'";
        $this->db->query($checkquery);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
    //SINGLE ROW DELETION PROCESS CALLING EILIB  FUNCTION
    public function DeleteRecord($USERSTAMP,$rowid,$module,$type,$data)
    {
        global  $USERSTAMP;
        $CONFIG_SRCH_UPD_arr_delete_data = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $this->load->model('Eilib/Common_function');
        $deleteflag=$this->Common_function->DeleteRecord(".$CONFIG_SRCH_UPD_arr_delete_data[3].",$rowid,$USERSTAMP);
        return $deleteflag;
    }
    //FUNCTION FOR ALREADY EXIT
    public function data_updname_exists($module,$type,$data)
    {
        $CONFIG_ENTRY_arr_config = $this->Db_configuration_configuration_entry->CONF_ENTRY_twodimdata($module) ;
        $checkquery= "SELECT ".$CONFIG_ENTRY_arr_config[2]." FROM ".$CONFIG_ENTRY_arr_config[1]." CCN WHERE CCN.CGN_ID=(SELECT C.CGN_ID FROM CONFIGURATION C WHERE C.CGN_ID='$type') AND ".$CONFIG_ENTRY_arr_config[2]."='$data'";
        $this->db->query($checkquery);
        if ($this->db->affected_rows() > 0) {
            return 1;
        }
        else {
            return 0;
        }
    }
 }