<?php
class Mdl_deposit_calculations extends CI_Model{
    // GET THE UNIT  FOR LOAD IN THE  FORM
    public function Initial_data($UserStamp){
        $this->load->model('Eilib/Common_function');
        $ErrorMessage= $this->Common_function->getErrorMessageList('248,251,252,253,254,255,256,257,258,259,260,261,262,271,380,449,450,451,459,468');
        $DDC_all_array =[];
        $DDC_unit_array =[];
        $DDC_sp_unitcustomer = "CALL SP_DD_GET_UNIT_CUSTNAME('".$UserStamp."',@TEMP_DD_DYNAMICTBLE)";
        $this->db->query($DDC_sp_unitcustomer);
        $DDC_rs_temptble=$this->db->query("SELECT @TEMP_DD_DYNAMICTBLE AS TEMP_DD_DYNAMICTBLE");
        $DDC_temptble_name=$DDC_rs_temptble->row()->TEMP_DD_DYNAMICTBLE;
        $DDC_unitcust_selectquery="SELECT DISTINCT UNIT_NO,CUSTOMER_ID,CUSTOMER_NAME FROM ".$DDC_temptble_name;
        $DDC_unitvalue = $this->db->query($DDC_unitcust_selectquery);
        foreach($DDC_unitvalue->result_array() as $row)
        {
            $DDC_unitno=$row["UNIT_NO"];
            $DDC_unit_array[]=(object)['DDC_unitno'=>$DDC_unitno,'DDC_customerid'=>$row["CUSTOMER_ID"],'DDC_customername'=>$row["CUSTOMER_NAME"]];
        }
        $this->db->query('DROP TABLE '.$DDC_temptble_name);
        $DDC_cusentryarray=[];$DDC_unitarray=[];$DDC_paymentarray=[]; $DDC_expunitarray=[]; $DDC_customerarray=[];$DDC_customertrmdtlarray=[];
        $DDC_cusentry_msg="SELECT CED_ID FROM CUSTOMER_ENTRY_DETAILS";
        $DDC_cusentryresult=$this->db->query($DDC_cusentry_msg);
        foreach($DDC_cusentryresult->result_array() as $row){
            $DDC_cusentryarray[]=$row["CED_ID"];
        }
        $DDC_unit_msg="SELECT UNIT_ID FROM UNIT";
        $DDC_unitresult=$this->db->query($DDC_unit_msg);
        foreach($DDC_unitresult->result_array() as $row){
            $DDC_unitarray[]=$row["UNIT_ID"];
        }
        $DDC_payment_msg="SELECT PD_ID FROM PAYMENT_DETAILS";
        $DDC_paymentresult=$this->db->query($DDC_payment_msg);
        foreach($DDC_paymentresult->result_array() as $row){
            $DDC_paymentarray[]=$row["PD_ID"];
        }
        $DDC_expunit_msg="SELECT EU_ID FROM EXPENSE_UNIT";
        $DDC_expunitresult=$this->db->query($DDC_expunit_msg);
        foreach($DDC_expunitresult->result_array() as $row){
            $DDC_expunitarray[]=$row["EU_ID"];
        }
        $DDC_customer_msg="SELECT CUSTOMER_ID FROM CUSTOMER";
        $DDC_customerresult=$this->db->query($DDC_customer_msg);
        foreach($DDC_customerresult->result_array() as $row){
            $DDC_customerarray[]=$row["CUSTOMER_ID"];
        }
        $DDC_customertrmdtl_msg="SELECT CLP_ID FROM CUSTOMER_LP_DETAILS";
        $DDC_customertrmdtlresult=$this->db->query($DDC_customertrmdtl_msg);
        foreach($DDC_customertrmdtlresult->result_array() as $row){
            $DDC_customertrmdtlarray[]=$row["CLP_ID"];
        }
        $DDC_RESULTS=(object)['DDC_cusentryarray'=>$DDC_cusentryarray,'DDC_customerarray'=>$DDC_customerarray,'DDC_expunitarray'=>$DDC_expunitarray,'DDC_paymentarray'=>$DDC_paymentarray,'DDC_unitarray'=>$DDC_unitarray,'DDC_errorAarray'=>$ErrorMessage,'DDC_unit_array'=>$DDC_unit_array,'DDC_customertrmdtlarray'=>$DDC_customertrmdtlarray];
        $DDC_all_array[]=($DDC_RESULTS);
        return $DDC_all_array;
    }
    public function DDC_load_datebox($DDC_getcustid,$DDC_name,$DDC_unitno){
        $DDC_custid=[];
        $DDC_custid=$DDC_getcustid;
        $DDC_index=explode(' ',$DDC_name);
        $DDC_firstname=$DDC_index[0];
        $DDC_lastname=$DDC_index[1];
        $startarrary =[];
        $endarrary =[];
        $pendarrary =[];
        $recverarray=[];
        $custidarray=[];
        $customer_data="SELECT DISTINCT CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CED.CED_REC_VER,CTD.CLP_PRETERMINATE_DATE FROM CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER C ON  (C.CUSTOMER_ID=CED.CUSTOMER_ID)   LEFT JOIN CUSTOMER_LP_DETAILS CTD ON (CTD.CUSTOMER_ID=CED.CUSTOMER_ID),UNIT U WHERE (U.UNIT_ID=CED.UNIT_ID) AND  (CED.CUSTOMER_ID='".$DDC_custid."') AND (U.UNIT_NO='".$DDC_unitno."')  AND   (CED.CED_REC_VER=CTD.CED_REC_VER) AND CTD.CLP_GUEST_CARD IS NULL AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CTD.CLP_STARTDATE<CTD.CLP_PRETERMINATE_DATE,CTD.CLP_ENDDATE>CTD.CLP_STARTDATE) ORDER BY CED.CED_REC_VER ASC";//AND (CED.CED_CANCEL_DATE IS NULL)
        $getcustomer_data= $this->db->query($customer_data);
        foreach($getcustomer_data->result_array() as $row)
        {
            $sdate = $row["CLP_STARTDATE"];
            $edate = $row["CLP_ENDDATE"];
            $recversion = $row["CED_REC_VER"];
            $pedate=$row["CLP_PRETERMINATE_DATE"];
            $recverarray[]=($recversion);
            $startarrary[]=($sdate);
            $endarrary[]=($edate);
            $pendarrary[]=($pedate);
        }
        $joinarray=[];
        $custidarray[]=($DDC_custid);
        $joinarray[]=($recverarray);
        $joinarray[]=($startarrary);
        $joinarray[]=($endarrary);
        $joinarray[]=($pendarrary);
        $joinarray[]=($custidarray);
        return $joinarray;
    }
    public function DDC_depcal_submit($unit_value,$name,$chkbox,$radio,$startdate,$enddate,$dep_custid,$DDC_recverlgth,$DDC_recdate,$UserStamp){
        if($radio!='')
            $name=$name.'_'.$radio;
        else
            $name=$name;
        $index=explode(' ',$name);
        $firstname=$index[0];
        $lastname=$index[1];
        $errormessage_array =[];
        $errormsg_exequery ="SELECT DDC_DATA FROM DEPOSIT_DEDUCTION_CONFIGURATION WHERE CGN_ID=30";
        $errormsg_rs = $this->db->query($errormsg_exequery);
        $DDC_folderid=$errormsg_rs->row()->DDC_DATA;
        $selectdate=[];
        $unique_id=[];
        if($chkbox!=''){
            if((is_array($chkbox))==true){
                $rbuttonX1=$chkbox;
            }
            else
            {
                $rbuttonX1=$chkbox;
            }
        }
        else{
            $rbuttonX1=$DDC_recdate;
        }
        $DDC_alllengdate=count($rbuttonX1);
        $DDC_recverarray=[];
        for($i=0;$i<count($rbuttonX1);$i++)
        {
            $DDC_splitalvalue=explode('^',$rbuttonX1[$i]);
            $DDC_id=$DDC_splitalvalue[0];
            $DDC_recver=explode(',',$DDC_splitalvalue[1]);
            $DDC_startdate=$DDC_splitalvalue[2];
            $DDC_enddate=$DDC_splitalvalue[3];
            $DDC_recverarray[]=($DDC_recver);
            $selectedrecverlength=count($DDC_recverarray);
        }
        $flag='X';
        if($DDC_recverlgth==$selectedrecverlength)
        {
            $flag="";
        }
        if($DDC_recverlgth!=$selectedrecverlength)
        {
            $flag="X";
        }
        if($flag=="")
        {
            $DDC_recver=$DDC_recverarray;
            $DDC_nooftimescalculat=1;
        }
        if($flag=="X")
        {
            $DDC_nooftimescalculat=$selectedrecverlength;
        }
        $curdate=date('Y-M');
        $date=explode('-',$curdate);
        $DDC_currentdateyear=$date[1];
        $DDC_currentmonth=$date[0];
        $DDC_ssname_currentyear='EI_DEPOSIT_DEDUCTIONS_'.$DDC_currentdateyear;
//        $DDC_getfiles = DriveApp.getFolderById(DDC_folderid).getFiles();
        $DDC_flag_ss=0;
//        while($DDC_getfiles.hasNext())
//        {
//            $DDC_oldfile=$DDC_getfiles.next();
//            $DDC_oldfile.getId();
//            $DDC_oldfile_id= DDC_oldfile.getId();//DriveApp.getFilesByName(DDC_oldfile).next().getId();
//            if($DDC_oldfile==$DDC_ssname_currentyear)
//            {
//                $DDC_currentfile_id=$DDC_oldfile_id;
//                $DDC_flag_ss=1;
//            }
//            $DDC_olddateyear=$date[1]-1;
//            $DDC_ssname_oldyear='EI_DEPOSIT_DEDUCTIONS_'.$DDC_olddateyear;
//            if($DDC_ssname_oldyear==$DDC_oldfile){
//                $DDC_ssname_getid=$DDC_oldfile_id;
//            }
//        }
//        if($DDC_flag_ss!=1){
//            if($DDC_ssname_getid=='')
//            {
//                $DDC_getfiles = DriveApp.getFolderById($DDC_folderid).getFiles();
//                while($DDC_getfiles.hasNext())
//                {
//                    $DDC_oldfile=$DDC_getfiles.next();
//                    if($DDC_oldfile==$DDC_ssname_currentyear)
//                    {
//                        $DDC_oldfile.setTrashed(true);
//                    }
//                }
//                return ['DDC_flag_nosheet',$DDC_ssname_oldyear];
//            }
//            $DDC_newspread=SpreadsheetApp.create($DDC_ssname_currentyear);
//            $DDC_newspread_ssid=$DDC_newspread.getId();
//            $DDC_targetFolderId=$DDC_folderid;
//            $this->load->model('Eilib/Common_function');
//            $this->Common_function->CUST_moveFileToFolder($DDC_newspread_ssid,"",$DDC_targetFolderId);
//            conn.setAutoCommit(false);
            //CREATE TEMPLATE FOR NEW SS
//            $DDC_source = SpreadsheetApp.openById(DDC_ssname_getid);
//            $DDC_templatesheet = $DDC_source.getSheets();
//            $DDC_flg_tempsht=0;
//            for($i=0;$i<count($DDC_templatesheet);$i++){
//                if($DDC_templatesheet[$i].getSheetName()=='TEMPLATE'){
//                    $DDC_flg_tempsht=1;
//                    $DDC_sh=$DDC_source.getSheets()[$i];
//                    $DDC_sh.copyTo(SpreadsheetApp.openById($DDC_newspread_ssid));
//                }
//            }
            //RETURN ERR MSG
//            if($DDC_flg_tempsht==0 ){
//                $DDC_getfiles = DriveApp.getFolderById($DDC_folderid).getFiles();
//                while($DDC_getfiles.hasNext())
//                {
//                    $DDC_oldfile=$DDC_getfiles.next();
//                    if($DDC_oldfile==$DDC_ssname_currentyear)
//                    {
//                        $DDC_oldfile.setTrashed(true);
//                    }
//                }
//                return [$DDC_flg_tempsht];
//            }
//            $this->db->query("UPDATE FILE_PROFILE SET FP_FILE_ID='".$DDC_newspread_ssid."' WHERE FP_ID=1");
//            conn.commit();
//            $DDC_docowner=$this->common_function->CUST_documentowner(conn);
//            $this->common_function->SetDocOwner($DDC_newspread_ssid,$DDC_docowner,$DDC_docowner);
            //GIVE PERMISSION TO EDITORS WHEN NEW SS CREATED USING EILIB
//                $this->common_function->Deposit_Deduction_fileSharing($DDC_newspread_ssid, $DDC_folderid)
//                $DDC_rename=SpreadsheetApp.openById(DDC_newspread_ssid).getSheets();
//                for($k=0;$k<count($DDC_rename);$k++){
//                        if($DDC_rename[$k].getSheetName()=='Copy of TEMPLATE'){
//                            $DDC_rename[$k].setName('TEMPLATE');
//                    }
//                }
//              $DDC_destination = SpreadsheetApp.openById($DDC_newspread_ssid);
//              $DDC_newspread_delete=$DDC_destination.getSheetByName('Sheet1');
//              DDC_newspread.deleteSheet($DDC_newspread_delete);
//              $DDC_rename=SpreadsheetApp.openById($DDC_newspread_ssid).getSheets();
//              for($k=0;k<DDC_rename.length;k++){
//                if(DDC_rename[k].getSheetName()!=$DDC_currentmonth){
//                    SpreadsheetApp.openById(DDC_newspread_ssid).insertSheet($DDC_currentmonth);
//                    break;
//                }
//                }
//              $DDC_currentfile_id=$DDC_newspread_ssid;
//            }
//IF CURRENT SS NOT HAVING TEMPLATE SHEET IT LL CREATE THEM TEMPLATE AND SENDING EMAIL
//    else{
//            $temp_sheet = SpreadsheetApp.openById($DDC_currentfile_id).getSheetByName('TEMPLATE');
//            if(temp_sheet==null){
//                if($DDC_ssname_getid==undefined)
//                    return ['DDC_flag_nosheet',$DDC_ssname_oldyear];
//                $DDC_source = SpreadsheetApp.openById($DDC_ssname_getid);
//                $DDC_templatesheet = $DDC_source.getSheets();
//                for($F=0;$F<count($DDC_templatesheet);$F++){
//                    if(($temp_sheet==null)&&($DDC_templatesheet[$F].getSheetName()=='TEMPLATE')){
//                        $DDC_sh=$DDC_source.getSheets()[$F];
//                        $DDC_sh.copyTo(SpreadsheetApp.openById($DDC_currentfile_id));
//                    }
//        }
//        $DDC_rename=SpreadsheetApp.openById(DDC_currentfile_id).getSheets();
//        for($W=0;$W<count($DDC_rename);$W++){
//                    if($DDC_rename[$W].getSheetName()=='Copy of TEMPLATE'){
//                        $DDC_rename[$W].setName('TEMPLATE');
//            }
//            }
//        }
//    }
//        $temp_sheet = SpreadsheetApp.openById($DDC_currentfile_id).getSheetByName('TEMPLATE');
//        if(temp_sheet==null)
//            return [0,1]
//        $currntyear = new Date().getYear();
//        $temp_header = temp_sheet.getRange(1,1,1,4);
//        $head_color = temp_sheet.getRange(1,1,1,temp_sheet.getLastColumn()).getBackgroundColor();
//        $ur = 2;
//        $unit_temp = temp_sheet.getRange(ur,1,1,1);
//        $output_sheet = SpreadsheetApp.openById($DDC_currentfile_id).getSheetByName($DDC_currentmonth);
//        if(output_sheet == null)
//        {
//            $output_sheet = SpreadsheetApp.openById($DDC_currentfile_id).insertSheet($DDC_currentmonth);
//        }
//        $DDC_callstorepcedurquery="CALL SP_DD_CALCULATION('".$unit_value."','".$dep_custid."','".$DDC_recverarray."','".$flag."','".$UserStamp."',@TEMP_DD_DYNAMICTBLE)";
//        $this->db->query($DDC_callstorepcedurquery);
//        $DDC_rs_temptble=$this->db->query("SELECT @TEMP_DD_DYNAMICTBLE AS TEMP_DD_DYNAMICTBLE");
//        $DDC_temptble_name=$DDC_rs_temptble->row()->TEMP_DD_DYNAMICTBLE;





    }
}