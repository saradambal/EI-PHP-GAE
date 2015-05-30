<?php
class Mdl_customer_termination extends CI_Model{
//FUNCTION TO GET CALENDAR TIME N ERROR MESSAGES
    public function CTERM_getErrMsgCalTime($USERSTAMP)
    {
    $CEXTN_timearray=[];
        $this->load->model('Eilib/Common_function');
        $CEXTN_timearray=$this->Common_function->CUST_getCalendarTime();
        $CTERM_errarray =[];
        $CTERM_errmsgids='42,43,47,97,329,356,401,458';
        $CTERM_errarray=$this->Common_function->GetErrorMessageList($CTERM_errmsgids);
        $CTERM_temptable=$this->CTERM_Calluntermcustsp($USERSTAMP);
        $CTERM_namearray =[];
        $CTERM_cnamequery="";
        $CTERM_cnamequery= "SELECT DISTINCT CUSTOMERNAME FROM VW_TERMINATION_ACTIVE_CUSTOMER UNION SELECT DISTINCT CUSTOMERNAME FROM $CTERM_temptable[1] UNION SELECT DISTINCT CUSTOMERNAME FROM VW_TERMINATION_TERMINATED_CUSTOMER ORDER BY CUSTOMERNAME ASC";
        $CTERM_cnameres = $this->db->query($CTERM_cnamequery);
        foreach($CTERM_cnameres->result_array() as $row)
        {
         $CTERM_namearray[]=$row["CUSTOMERNAME"];
        }
      //DROP UNTERM CUSTOMER TEMP TABLES
    $this->DropUntermTables($CTERM_temptable);
    $CTERM_errmsgntime=(object)["errormsg"=>$CTERM_errarray,"calfrmtime"=>$CEXTN_timearray,"namelen"=>count($CTERM_namearray)];
    return $CTERM_errmsgntime;
    }
    // FUNCTION TO CALL UNTERM CUST SP
    public function CTERM_Calluntermcustsp($USERSTAMP)
    {
        $CTERM_callspquery="CALL SP_NON_TERMINATED_CUSTOMER('$USERSTAMP',@TEMP_TERMINATED_CUSTOMER,@TEMP_ACTIVE_CUSTOMER,@FINAL_TERMINATED_CUSTOMER,@NON_TERMINATED_CUSTOMER)";
        $this->db->query($CTERM_callspquery);
        $CTERM_feetemptbl_query="SELECT @FINAL_TERMINATED_CUSTOMER,@NON_TERMINATED_CUSTOMER,@TEMP_TERMINATED_CUSTOMER,@TEMP_ACTIVE_CUSTOMER";
        $CTERM_feetemptblres=$this->db->query($CTERM_feetemptbl_query);
        $CTERM_temptblname_array=[];
        $CTERM_temptblname1="";$CTERM_temptblname2="";$CTERM_temptblname3="";$CTERM_temptblname4="";
        foreach($CTERM_feetemptblres->result_array() as $row)
        {
            $CTERM_temptblname1=$row['@FINAL_TERMINATED_CUSTOMER'];
            $CTERM_temptblname2=$row['@NON_TERMINATED_CUSTOMER'];
            $CTERM_temptblname3=$row['@TEMP_TERMINATED_CUSTOMER'];
            $CTERM_temptblname4=$row['@TEMP_ACTIVE_CUSTOMER'];
        }
        $CTERM_temptblname_array=[$CTERM_temptblname1,$CTERM_temptblname2,$CTERM_temptblname3,$CTERM_temptblname4];
         return $CTERM_temptblname_array;
    }
    //FUNCTION TO DROP TEMP TABLES FOR UNTERMINATION CUSTOMER OPTION
    public function DropUntermTables($CTERM_temptable)
    {
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_temptable[0]);
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_temptable[1]);
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_temptable[2]);
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_temptable[3]);
    }
    //FUNCTION TO GET ACTIVE CUSTOMER
    public function CTERM_getCustomerName($USERSTAMP)
    {
        $CTERM_form_option=$_POST['CTERM_radio_termoption'];
        $CTERM_namearray =[];
        $CTERM_cnamequery="";
        if($CTERM_form_option=='CTERM_radio_activecust')
        {
            $CTERM_cnamequery= "SELECT DISTINCT CUSTOMERNAME FROM VW_TERMINATION_ACTIVE_CUSTOMER ORDER BY CUSTOMERNAME ASC";
        }
        else if($CTERM_form_option=='CTERM_radio_untermnonactive')
        {
            $CTERM_temptable=$this->CTERM_Calluntermcustsp($USERSTAMP);
            $CTERM_cnamequery= "SELECT DISTINCT CUSTOMERNAME FROM $CTERM_temptable[1] WHERE CUSTOMERID NOT IN(SELECT CUSTOMERID FROM VW_TERMINATION_TERMINATED_CUSTOMER) ORDER BY CUSTOMERNAME ASC";
        }
        else
        {
            $CTERM_cnamequery= "SELECT DISTINCT CUSTOMERNAME FROM VW_TERMINATION_TERMINATED_CUSTOMER ORDER BY CUSTOMERNAME ASC";
        }
        $CTERM_cnameres = $this->db->query($CTERM_cnamequery);
        foreach($CTERM_cnameres->result_array() as $row)
        {
            $CTERM_namearray[]=$row["CUSTOMERNAME"];
        }
        if($CTERM_form_option=='CTERM_radio_untermnonactive')
        {
            $this->DropUntermTables($CTERM_temptable);
        }
        return $CTERM_namearray;
    }
    //FUNCTION TO GET CUSTOMER ID FOR THE SELECTED CUSTOMER NAME
    public function CTERM_getCustomerId($USERSTAMP)
    {
        $CTERM_cname=$_POST['CTERM_lb_custname'];
        $CTERM_form_option=$_POST['CTERM_radio_termoption'];
        $CTERM_cidarray =[];
        $CTERM_cidquery= "";
        if($CTERM_form_option=='CTERM_radio_activecust')
        {
            $CTERM_cidquery= "SELECT CUSTOMERID FROM VW_TERMINATION_ACTIVE_CUSTOMER WHERE CUSTOMERNAME ='$CTERM_cname' GROUP BY CUSTOMERID";
        }
        else if($CTERM_form_option=='CTERM_radio_untermnonactive')
        {
            $CTERM_temptable=$this->CTERM_Calluntermcustsp($USERSTAMP);
            $CTERM_cidquery= "SELECT CUSTOMERID FROM $CTERM_temptable[1]  WHERE CUSTOMERNAME ='$CTERM_cname' GROUP BY CUSTOMERID";
        }
        else
        {
            $CTERM_cidquery= "SELECT CUSTOMERID FROM VW_TERMINATION_TERMINATED_CUSTOMER WHERE CUSTOMERNAME ='$CTERM_cname' GROUP BY CUSTOMERID" ;
        }
        $CTERM_cidres = $this->db->query($CTERM_cidquery);
        foreach($CTERM_cidres->result_array() as $row)
        {
            $CTERM_cidarray[]=$row["CUSTOMERID"];
        }
        if($CTERM_form_option=='CTERM_radio_untermnonactive')
        {
            $this->DropUntermTables($CTERM_temptable);
        }
        return $CTERM_cidarray;
    }
    //FUNCTION TO GET CUSTOMER DETAILS FOR THE SELECTED CUSTOMER NAME
    public function CTERM_getCustomerdtls($CTERM_custid,$CTERM_radio_termoption,$USERSTAMP,$timeZoneFormat)
    {
        $CTERM_final_dtls_result=[];
        $this->db->query("CALL SP_CUSTOMER_TERMINATION_TEMP_FEE_DETAIL('$CTERM_custid','$USERSTAMP',@CTERM_FEETMPTBLNAM)");
        $CTERM_feetemptbl_query="SELECT @CTERM_FEETMPTBLNAM";
        $CTERM_feetemptblres=$this->db->query($CTERM_feetemptbl_query);
        $CTERM_tempfeetblname="";
        foreach($CTERM_feetemptblres->result_array() as $row)
        {
            $CTERM_tempfeetblname=$row['@CTERM_FEETMPTBLNAM'];
        }
        $CTERM_count=0;
        if($CTERM_radio_termoption=="CTERM_radio_activecust")
        {
            $CTERM_custdtlsquery="SELECT  CED.UASD_ID,CACD.CACD_VALID_TILL,CED.CED_LEASE_PERIOD,CED.CED_QUARTERS,CED.CED_RECHECKIN,CED.CED_PRETERMINATE,CTD.CLP_TERMINATE,U.UNIT_NO,UASD.UASD_ACCESS_CARD,CTD.CLP_GUEST_CARD,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,NC.NC_DATA,TF.CC_DEPOSIT,TF.CC_PAYMENT_AMOUNT,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,TF.CC_ELECTRICITY_CAP,TF.CC_AIRCON_FIXED_FEE,TF.CC_AIRCON_QUARTERLY_FEE,TF.CC_DRYCLEAN_FEE,TF.CC_PROCESSING_FEE,TF.CC_CHECKOUT_CLEANING_FEE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CED.CED_NOTICE_PERIOD,CED.CED_NOTICE_START_DATE,CPD.CPD_DOB,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CED.CED_EXTENSION,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CPD.CPD_COMMENTS,ULD.ULD_LOGINID,CTD.CLP_PRETERMINATE_DATE,DATE_FORMAT(CONVERT_TZ(CTD.CLP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CTDTIMESTAMP FROM  CUSTOMER_ENTRY_DETAILS CED  LEFT JOIN CUSTOMER_LP_DETAILS CTD ON CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND(CTD.CED_REC_VER=CED.CED_REC_VER)LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN CUSTOMER_ACCESS_CARD_DETAILS CACD ON CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND   CTD.UASD_ID=CACD.UASD_ID LEFT JOIN $CTERM_tempfeetblname TF ON  CED.CUSTOMER_ID=TF.CUSTOMER_ID LEFT JOIN CUSTOMER C ON CED.CUSTOMER_ID=C.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID LEFT JOIN UNIT_ACCESS_STAMP_DETAILS UASD ON CACD.UASD_ID=UASD.UASD_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=CTD.ULD_ID AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='$CTERM_custid') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=TF.CUSTOMER_VER) AND (CLP_STARTDATE<=CURDATE() OR CLP_STARTDATE>=CURDATE()) AND CED.CED_CANCEL_DATE IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC";
        }
        if($CTERM_radio_termoption=="CTERM_radio_untermnonactive")
        {
            $CTERM_custdtlsquery="SELECT  CED.UASD_ID,CACD.CACD_VALID_TILL,CED.CED_LEASE_PERIOD,CED.CED_QUARTERS,CED.CED_RECHECKIN,CED.CED_PRETERMINATE,CTD.CLP_TERMINATE,U.UNIT_NO,UASD.UASD_ACCESS_CARD,CTD.CLP_GUEST_CARD,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,NC.NC_DATA,TF.CC_DEPOSIT,TF.CC_PAYMENT_AMOUNT,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,TF.CC_ELECTRICITY_CAP,TF.CC_AIRCON_FIXED_FEE,TF.CC_AIRCON_QUARTERLY_FEE,TF.CC_DRYCLEAN_FEE,TF.CC_PROCESSING_FEE,TF.CC_CHECKOUT_CLEANING_FEE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CED.CED_NOTICE_PERIOD,CED.CED_NOTICE_START_DATE,CPD.CPD_DOB,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CED.CED_EXTENSION,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CPD.CPD_COMMENTS,ULD.ULD_LOGINID,CTD.CLP_PRETERMINATE_DATE,DATE_FORMAT(CONVERT_TZ(CTD.CLP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CTDTIMESTAMP FROM  CUSTOMER_ENTRY_DETAILS CED  LEFT JOIN CUSTOMER_LP_DETAILS CTD ON CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND(CTD.CED_REC_VER=CED.CED_REC_VER)LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN CUSTOMER_ACCESS_CARD_DETAILS CACD ON CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND   CTD.UASD_ID=CACD.UASD_ID LEFT JOIN $CTERM_tempfeetblname TF ON  CED.CUSTOMER_ID=TF.CUSTOMER_ID LEFT JOIN CUSTOMER C ON CED.CUSTOMER_ID=C.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID LEFT JOIN UNIT_ACCESS_STAMP_DETAILS UASD ON CACD.UASD_ID=UASD.UASD_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=CTD.ULD_ID AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='$CTERM_custid') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=TF.CUSTOMER_VER) AND (CLP_STARTDATE<=CURDATE() OR CLP_STARTDATE>=CURDATE()) AND CED.CED_CANCEL_DATE IS NULL AND IF(CTD.CLP_PRETERMINATE_DATE IS NOT NULL,CLP_PRETERMINATE_DATE<=CURDATE(),CLP_ENDDATE<=CURDATE()) ORDER BY CED.CED_REC_VER,CTD.CLP_GUEST_CARD ASC";
        }
        if($CTERM_radio_termoption=="CTERM_radio_reactivecust")
        {
            $CTERM_custdtlsquery="SELECT CED.UASD_ID,CACD.CACD_VALID_TILL,CED.CED_LEASE_PERIOD,CED.CED_QUARTERS,CED.CED_RECHECKIN,CED.CED_PRETERMINATE,CTD.CLP_TERMINATE,U.UNIT_NO,UASD.UASD_ACCESS_CARD,CTD.CLP_GUEST_CARD,C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,NC.NC_DATA,TF.CC_DEPOSIT,TF.CC_PAYMENT_AMOUNT,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,TF.CC_ELECTRICITY_CAP,TF.CC_AIRCON_FIXED_FEE,TF.CC_AIRCON_QUARTERLY_FEE,TF.CC_DRYCLEAN_FEE,TF.CC_PROCESSING_FEE,TF.CC_CHECKOUT_CLEANING_FEE,CPD.CPD_EP_NO,CPD.CPD_EP_DATE,CPD.CPD_PASSPORT_NO,CPD.CPD_PASSPORT_DATE,CED.CED_NOTICE_PERIOD,CED.CED_NOTICE_START_DATE,CPD.CPD_DOB,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_EMAIL,CCD.CCD_OFFICE_NO,CED.CED_EXTENSION,CED.CED_REC_VER,CED.CED_CANCEL_DATE,CPD.CPD_COMMENTS,ULD.ULD_LOGINID,CTD.CLP_PRETERMINATE_DATE,DATE_FORMAT(CONVERT_TZ(CTD.CLP_TIMESTAMP,$timeZoneFormat),'%d-%m-%Y %T') AS CTDTIMESTAMP FROM  CUSTOMER_ENTRY_DETAILS CED  LEFT JOIN CUSTOMER_LP_DETAILS CTD ON CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND(CTD.CED_REC_VER=CED.CED_REC_VER)LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN CUSTOMER_ACCESS_CARD_DETAILS CACD ON CED.CUSTOMER_ID=CACD.CUSTOMER_ID   AND CTD.UASD_ID=CACD.UASD_ID LEFT JOIN UNIT_ACCESS_STAMP_DETAILS UASD ON CACD.UASD_ID=UASD.UASD_ID LEFT JOIN $CTERM_tempfeetblname TF ON  CED.CUSTOMER_ID=TF.CUSTOMER_ID LEFT JOIN CUSTOMER C ON CED.CUSTOMER_ID=C.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC ,UNIT U,VW_RECHECKIN_CUSTOMER VRC,USER_LOGIN_DETAILS ULD  WHERE   ULD.ULD_ID=CTD.ULD_ID AND CED.CUSTOMER_ID=VRC.CUSTOMER_ID AND CED.CED_REC_VER=VRC.CED_REC_VER AND (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='$CTERM_custid') AND (CPD.NC_ID=NC.NC_ID) AND (CED.CED_REC_VER=TF.CUSTOMER_VER) AND (CLP_STARTDATE<=CURDATE() OR CLP_STARTDATE>=CURDATE()) AND  CTD.CLP_TERMINATE IS NOT NULL AND CED.CED_CANCEL_DATE IS NULL AND IF(CTD.CLP_PRETERMINATE_DATE IS NOT NULL,CLP_PRETERMINATE_DATE<=CURDATE(),CLP_ENDDATE<=CURDATE()) ORDER BY CED.CED_REC_VER,CTD.CLP_GUEST_CARD ASC";
        }
        $CTERM_custdtlsrs = $this->db->query($CTERM_custdtlsquery);
        foreach($CTERM_custdtlsrs->result_array() as $row)
        {
            $CTERM_chkkenddate = strtotime($row["CLP_ENDDATE"]);
            $CTERM_chkkptd = $row["CLP_PRETERMINATE_DATE"];

            if($CTERM_chkkptd!=null)
            {
                $CTERM_chkkptd = strtotime($row["CLP_PRETERMINATE_DATE"]);
                $CTERM_chkkenddate=$CTERM_chkkptd;
            }

            $CTERM_cardno = $row["UASD_ACCESS_CARD"];
            if($CTERM_cardno==null){$CTERM_cardno="";}
            $CTERM_validtill=$row["CACD_VALID_TILL"];
            if($CTERM_validtill==null){ $CTERM_validtill=""; }
            $CTERM_term = $row["CLP_TERMINATE"];
            if($CTERM_term==null){ $CTERM_term=""; }
            if(($CTERM_radio_termoption=="CTERM_radio_activecust"&&$CTERM_validtill==""&&$CTERM_chkkenddate>strtotime(date('Y-m-d')))||($CTERM_radio_termoption=="CTERM_radio_untermnonactive"&&($CTERM_cardno==""||($CTERM_cardno!=""&&$CTERM_validtill=="")))||($CTERM_radio_termoption=="CTERM_radio_reactivecust"))
            {
                $CTERM_rmtypid=$row["UASD_ID"];
                $CTERM_unitno = $row["UNIT_NO"];
                $CTERM_firstname = $row["CUSTOMER_FIRST_NAME"];
                $CTERM_lastname = $row["CUSTOMER_LAST_NAME"];
                $CTERM_startdate = $row["CLP_STARTDATE"];
                $CTERM_enddate = $row["CLP_ENDDATE"];
                $CTERM_rental = $row["CC_PAYMENT_AMOUNT"];
                $CTERM_select_roomtype="SELECT URTD.URTD_ROOM_TYPE from UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD,UNIT U,CUSTOMER_ENTRY_DETAILS CED WHERE U.UNIT_ID=UASD.UNIT_ID AND U.UNIT_ID=CED.UNIT_ID AND U.UNIT_NO='$CTERM_unitno' AND (CED.CUSTOMER_ID='$CTERM_custid') and(UASD.UASD_ID=CED.UASD_ID)AND CED.UASD_ID='$CTERM_rmtypid' and(UASD.URTD_ID=URTD.URTD_ID)";
                $CTERM_rs = $this->db->query($CTERM_select_roomtype);
                    $CTERM_roomtype = $CTERM_rs->row()->URTD_ROOM_TYPE;
                $CTERM_gstcard= $row["CLP_GUEST_CARD"];
                if($CTERM_gstcard==null){ $CTERM_gstcard=""; }
                $CTERM_extension= $row["CED_EXTENSION"];
                if($CTERM_extension==null){ $CTERM_extension=""; }
                $CTERM_redver = $row["CED_REC_VER"];
                if($CTERM_count==0){
                    $cterm_activerv = $CTERM_redver;
                }
                $CTERM_comments = $row["CPD_COMMENTS"];
                if($CTERM_comments==null){ $CTERM_comments=""; }
                $CTERM_userstamp = $row["ULD_LOGINID"];
                $CTERM_timestamp = $row["CTDTIMESTAMP"];
                $CTERM_preterminatedate = $row["CLP_PRETERMINATE_DATE"];
                if($CTERM_preterminatedate==null){ $CTERM_preterminatedate=""; }
                $CTERM_lp = $row["CED_LEASE_PERIOD"];
                if($CTERM_lp==null){ $CTERM_lp=""; }
                $CTERM_qtrs = $row["CED_QUARTERS"];
                if($CTERM_qtrs==null){ $CTERM_qtrs=""; }
                $CTERM_rechk = $row["CED_RECHECKIN"];
                if($CTERM_rechk==null){ $CTERM_rechk=""; }
                $CTERM_preterm = $row["CED_PRETERMINATE"];
                if($CTERM_preterm==null){ $CTERM_preterm=""; }
                $CTERM_final_result=(object)['unitno'=>$CTERM_unitno,'firstname'=>$CTERM_firstname,'lastname'=>$CTERM_lastname,'roomtype'=>$CTERM_roomtype,'cardno'=>$CTERM_cardno,'extension'=>$CTERM_extension,'rental'=>$CTERM_rental,'comments'=>$CTERM_comments,'userstamp'=>$CTERM_userstamp,'timestamp'=>$CTERM_timestamp,'startdate'=>$CTERM_startdate,'enddate'=>$CTERM_enddate,'preterminatedate'=>$CTERM_preterminatedate,'redver'=>$CTERM_redver,'guestcard'=>$CTERM_gstcard,'lp'=>$CTERM_lp,'quartors'=>$CTERM_qtrs,'rechk'=>$CTERM_rechk,'preterm'=>$CTERM_preterm,'term'=>$CTERM_term,'globalrecver'=>$cterm_activerv];
                $CTERM_final_dtls_result[]=$CTERM_final_result;
                $CTERM_count++;
            }
        }
         //DROP TEMP TABLE FOR FEE DETAILS
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_tempfeetblname);
        $CTERM_final_resultdts=(object)["finaldts"=>$CTERM_final_dtls_result];
        return $CTERM_final_resultdts;
    }

}