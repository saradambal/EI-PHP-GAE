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
                $CTERM_final_result=(object)['unitno'=>$CTERM_unitno,'firstname'=>$CTERM_firstname,'lastname'=>$CTERM_lastname,'roomtype'=>$CTERM_roomtype,'cardno'=>$CTERM_cardno,'extension'=>$CTERM_extension,'rental'=>$CTERM_rental,'comments'=>$CTERM_comments,'userstamp'=>$CTERM_userstamp,'timestamp'=>$CTERM_timestamp,'startdate'=>$CTERM_startdate,'enddate'=>$CTERM_enddate,'preterminatedate'=>$CTERM_preterminatedate,'redver'=>$CTERM_redver,'guestcard'=>$CTERM_gstcard,'lp'=>$CTERM_lp,'quartors'=>$CTERM_qtrs,'rechk'=>$CTERM_rechk,'preterm'=>$CTERM_preterm,'term'=>$CTERM_term];
                $CTERM_final_dtls_result[]=$CTERM_final_result;
                $CTERM_count++;
            }
        }
         //DROP TEMP TABLE FOR FEE DETAILS
        $this->db->query('DROP TABLE IF EXISTS '.$CTERM_tempfeetblname);
        $CTERM_final_resultdts=(object)["finaldts"=>$CTERM_final_dtls_result,'globalrecver'=>$cterm_activerv];
        return $CTERM_final_resultdts;
    }
    //FUNCTION TO GET MIN PTD AFTER FULL PTD A GUEST IN SELECTED RV N TO CHK EXTN LPS FOR PTD<=SD
    public function CTERM_getMinPTD($CTERM_custid,$CTERM_radio_termoption,$CTERM_custrv)
    {
        $CTERM_custid=explode('@',$CTERM_custid)[0];
        $CTERM_custptdempty=false;
        $CTERM_allptddate=[];
        $CTERM_final_dtls_result=[];
        $CTERM_custdtlsquery="SELECT CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTD.CLP_PRETERMINATE_DATE,CACD.CACD_VALID_TILL,CTD.CLP_GUEST_CARD FROM  CUSTOMER_ENTRY_DETAILS CED  LEFT JOIN CUSTOMER_LP_DETAILS CTD ON CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND(CTD.CED_REC_VER=CED.CED_REC_VER) LEFT JOIN CUSTOMER_ACCESS_CARD_DETAILS CACD ON CED.CUSTOMER_ID=CACD.CUSTOMER_ID AND   CTD.UASD_ID=CACD.UASD_ID  LEFT JOIN CUSTOMER C ON CED.CUSTOMER_ID=C.CUSTOMER_ID LEFT JOIN UNIT_ACCESS_STAMP_DETAILS UASD ON CACD.UASD_ID=UASD.UASD_ID ,UNIT U  WHERE   (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID='$CTERM_custid')  AND CED.CED_REC_VER='$CTERM_custrv' AND (CLP_STARTDATE<=CURDATE() OR CLP_STARTDATE>=CURDATE()) AND CED.CED_CANCEL_DATE IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC";
        $CTERM_custdtls_lastptdrs = $this->db->query($CTERM_custdtlsquery);
        foreach($CTERM_custdtls_lastptdrs->result_array() as $row)
        {
            $CTERM_chkkenddate = strtotime($row["CLP_ENDDATE"]);
            $CTERM_chkksddate = strtotime($row["CLP_STARTDATE"]);
            $CTERM_chkkptd = $row["CLP_PRETERMINATE_DATE"];
            $CTERM_ctdguestflag=$row["CLP_GUEST_CARD"];
            if($CTERM_chkkptd!=null)
            {
                $CTERM_ptddtime=strtotime($row["CLP_PRETERMINATE_DATE"]);
                if($CTERM_ctdguestflag!=null&&$CTERM_ptddtime<=strtotime(date('Y-m-d')))
                {
                    $CTERM_allptddate[]=$CTERM_ptddtime;
                }
                if($CTERM_ctdguestflag==null&&$CTERM_ptddtime<=$CTERM_chkksddate)
                {
                    $CTERM_custptdempty=true;
                }
            }
        }
        $CTERM_minptd="";
        if(count($CTERM_allptddate)>0)
        {
            sort($CTERM_allptddate);
            $CTERM_minptd=$CTERM_allptddate[count($CTERM_allptddate)-1];
            $CTERM_minptd= date('d-m-Y',$CTERM_minptd);
        }
        $CTERM_finalptdncustptdchk=["cterm_mincustptd"=>$CTERM_minptd,"cterm_custptdchk"=>$CTERM_custptdempty];
        return $CTERM_finalptdncustptdchk;
    }

    //FUNCTION TO UPDATE PTD DTLS
    public function CTERM_UpdatePtd($USERSTAMP,$timeZoneFormat)
    {
        $CTERM_lb_custname=$_POST['CTERM_lb_custname'];
        $CTERM_radio_termoption=$_POST['CTERM_radio_termoption'];
        $CTERM_ta_comments=$_POST['CTERM_ta_comments'];
        if($CTERM_ta_comments!="")
        {
            $CTERM_ta_comments=$this->db->escape_like_str($CTERM_ta_comments);
        }
        $CTERM_custidrv=$_POST['CTERM_hidden_custid'];
        if(strpos($CTERM_custidrv,'@'))
        {
        $CTERM_custid=explode('@',$CTERM_custidrv)[0];
        $CTERM_recver=explode('@',$CTERM_custidrv)[1];
        }
        else{
        $CTERM_custid=$CTERM_custidrv;
        }
        $CTERM_unitno=$_POST['CTERM_unitno'];
        $CTERM_cb_cardnos=[];
        $CTERM_hidden_finalcards=$_POST['CTERM_hidden_finalcards'];
//        try
//        {
            $this->load->model('Eilib/Common_function');
            $CTERM_UserStampId=$this->Common_function->getUserStampId($USERSTAMP);
            $CTERM_tddate=$this->Common_function->gettimezone24HRS();
            if($CTERM_radio_termoption=="CTERM_radio_reactivecust")
            {
                $this->db->query("CALL SP_CUSTOMER_REACTIVE_UPDATE('$CTERM_custid','$USERSTAMP',@TERMRESULT_FLAG)");
            }
            else if($CTERM_radio_termoption=="CTERM_radio_untermnonactive")
            {
                $this->db->query("CALL SP_CUSTOMER_UNTERMINATED_NON_ACTIVE_UPDATE('$CTERM_custid','$USERSTAMP','$CTERM_tddate',@TERMRESULT_FLAG)");
            }
            else if($CTERM_radio_termoption=="CTERM_radio_activecust")
            {

                $CTERM_find=(strlen(strstr($CTERM_hidden_finalcards,",")));
                if($CTERM_find>0)
                {
                    $finalarray=explode(',',$CTERM_hidden_finalcards);
                    for($i=0;$i<count($finalarray);$i++)
                    {
                        $CTERM_cb_cardnos[]=$finalarray[$i];
                    }
                }
                else
                {
                    $CTERM_cb_cardnos=$CTERM_hidden_finalcards;
                }
                $CTERM_db_ptddate=$_POST['CTERM_db_ptddate'];
                $CTERM_lb_ptdfrmtime=$_POST['CTERM_lb_ptdfrmtime'];
                $CTERM_lb_ptdtotime=$_POST['CTERM_lb_ptdtotime'];
                $CTERM_customename=explode('_',$CTERM_lb_custname)[0].' '.explode('_',$CTERM_lb_custname)[1];
                $CTERM_lb_custname=preg_replace('/some_regexp/',"_",$CTERM_lb_custname);
                $CTERM_ptddate="";
                $CTERM_customerptd="";
                $CTERM_ptdsttime="";
                $CTERM_ptdedtime="";
                $CTERM_accesscard="";
                $CTERM_guestcard="";
                $CTERM_ptdcalstime="";
                $CTERM_ptdcaletime="";
                if($CTERM_cb_cardnos!='undefined')
                {
                    $CTERM_find=(strlen(strstr($CTERM_cb_cardnos,",")));
                    echo $CTERM_cb_cardnos;
                    exit;
                    if($CTERM_find>0)
                    {
                        for($i=0;$i<count($CTERM_cb_cardnos);$i++)
                        {
                            $CTERM_cardno=explode('$',$CTERM_cb_cardnos[$i])[0];
//                            $CTERM_cardlbl=explode('@',(explode('$',$CTERM_cb_cardnos[$i])[1]))[0];
//                            $CTERM_ptd=date('Y-m-d',strtotime(explode('@',(explode('$',$CTERM_cb_cardnos[$i])[1]))[1]));
                            return [$CTERM_cardno];
//                            if(CTERM_cardlbl==CTERM_lb_custname)
//                            {
//                                CTERM_customerptd=CTERM_ptd;
//                                $CTERM_findtime=(CTERM_lb_ptdfrmtime.toString()).search(',');
//                                if(CTERM_findtime!=-1)
//                                {
//                                    for($ll=0;ll<CTERM_lb_ptdfrmtime.length;ll++)
//                                    {
//                                        if(CTERM_lb_ptdfrmtime[ll]!="SELECT")
//                                        {
//                                            CTERM_ptdsttime="'"+CTERM_lb_ptdfrmtime[ll]+"'";
//                                            CTERM_ptdcalstime=CTERM_lb_ptdfrmtime[ll];
//                                            $CTERM_findtotime=(CTERM_lb_ptdtotime.toString()).search(',');
//                                            if(CTERM_findtotime!=-1)
//                                            {
//                                                CTERM_ptdedtime="'"+CTERM_lb_ptdtotime[ll]+"'";
//                                                CTERM_ptdcaletime=CTERM_lb_ptdtotime[ll];
//                                            }
//                                            else
//                                            {
//                                                CTERM_ptdedtime="'"+CTERM_lb_ptdtotime+"'";
//                                                CTERM_ptdcaletime=CTERM_lb_ptdtotime;
//                                            }
//                                        }
                                    }
                                }
//                                else
//                                {
//                                    if(CTERM_lb_ptdfrmtime!="SELECT")
//                                    {
//                                        CTERM_ptdsttime="'"+CTERM_lb_ptdfrmtime+"'";
//                                        CTERM_ptdedtime="'"+CTERM_lb_ptdtotime+"'";
//                                        CTERM_ptdcalstime=CTERM_lb_ptdfrmtime;
//                                        CTERM_ptdcaletime=CTERM_lb_ptdtotime;
//                                    }
//                                }
//                                if(CTERM_accesscard=="")
//                                {
//                                    CTERM_accesscard=CTERM_cardno;
//                                    CTERM_guestcard=CTERM_cardno+','+' ';
//                                    CTERM_ptddate=CTERM_cardno+','+CTERM_ptd;
//                                }
//                                else
//                                {
//                                    CTERM_accesscard=CTERM_accesscard+','+CTERM_cardno;
//                                    CTERM_accesscard=CTERM_guestcard+','+CTERM_cardno+', ';
//                                    CTERM_ptddate+=CTERM_cardno+','+CTERM_ptd;
//                                }
//                            }
//                            else
//                            {
//                                if(CTERM_ptdsttime=="")
//                                {
//                                    CTERM_ptdsttime=null;
//                                    CTERM_ptdedtime=null;
//                                }
//                                if(CTERM_accesscard=="")
//                                {
//                                    CTERM_guestcard=CTERM_cardno+',X';
//                                    CTERM_accesscard=CTERM_cardno;
//                                    CTERM_ptddate=CTERM_cardno+','+CTERM_ptd;
//                                }
//                                else
//                                {
//                                    CTERM_accesscard=CTERM_accesscard+','+CTERM_cardno;
//                                    CTERM_guestcard=CTERM_guestcard+','+CTERM_cardno+',X';
//                                    CTERM_ptddate+=','+CTERM_cardno+','+CTERM_ptd;
//                                }
//                            }
//                        }
//                    }
//                    else
//                    {
//                        $CTERM_ptddate=CTERM_db_ptddate;
//                        $CTERM_cardno=CTERM_cb_cardnos.split("$")[0]
//                        $CTERM_cardlbl=(CTERM_cb_cardnos.split("$")[1]).split("@")[0];
//                        $CTERM_ptd=eilib.SqlDateFormat((CTERM_cb_cardnos.split("$")[1]).split("@")[1]);
//                        if(CTERM_cardlbl==CTERM_lb_custname)
//                        {
//                            CTERM_customerptd=CTERM_ptd;
//                            $CTERM_findtime=(CTERM_lb_ptdfrmtime.toString()).search(',');
//                            if(CTERM_findtime!=-1)
//                            {
//                                for($ll=0;ll<CTERM_lb_ptdfrmtime.length;ll++)
//                                {
//                                    if(CTERM_lb_ptdfrmtime[ll]!="SELECT")
//                                    {
//                                        CTERM_ptdsttime="'"+CTERM_lb_ptdfrmtime[ll]+"'";
//                                        CTERM_ptdcalstime=CTERM_lb_ptdfrmtime[ll];
//                                        $CTERM_findtotime=(CTERM_lb_ptdtotime.toString()).search(',');
//                                        if(CTERM_findtotime!=-1)
//                                        {
//                                            CTERM_ptdedtime="'"+CTERM_lb_ptdtotime[ll]+"'";
//                                            CTERM_ptdcaletime=CTERM_lb_ptdtotime[ll];
//                                        }
//                                        else
//                                        {
//                                            CTERM_ptdedtime="'"+CTERM_lb_ptdtotime+"'";
//                                            CTERM_ptdcaletime=CTERM_lb_ptdtotime
//                                        }
//                                    }
//                                }
//
//                            }
//                            else
//                            {
//                                if(CTERM_lb_ptdfrmtime!="SELECT")
//                                {
//                                    CTERM_ptdsttime="'"+CTERM_lb_ptdfrmtime+"'";
//                                    CTERM_ptdedtime="'"+CTERM_lb_ptdtotime+"'";
//                                    CTERM_ptdcalstime=CTERM_lb_ptdfrmtime
//                                    CTERM_ptdcaletime=CTERM_lb_ptdtotime
//                                }
//                            }
//                            if(CTERM_accesscard=="")
//                            {
//                                if(CTERM_cardno=="")//null card customer
//                                {
//                                    CTERM_cardno=0
//                                }
//                                CTERM_accesscard=CTERM_cardno;
//                                CTERM_guestcard=CTERM_cardno+','+' ';
//                                CTERM_ptddate=CTERM_cardno+','+CTERM_ptd;
//                            }
//                            else
//                            {
//                                CTERM_accesscard=CTERM_accesscard+','+CTERM_cardno;
//                                CTERM_accesscard=CTERM_guestcard+','+CTERM_cardno+', ';
//                                CTERM_ptddate+=','+CTERM_cardno+','+CTERM_ptd;
//                            }
//                        }
//                        else
//                        {
//                            if(CTERM_ptdsttime=="")
//                            {
//                                CTERM_ptdsttime=null;
//                                CTERM_ptdedtime=null;
//                            }
//                            if(CTERM_accesscard=="")
//                            {
//                                CTERM_guestcard=CTERM_cardno+',X';
//                                CTERM_accesscard=CTERM_cardno;
//                                CTERM_ptddate=CTERM_cardno+','+CTERM_ptd;
//                            }
//                            else
//                            {
//                                CTERM_accesscard=CTERM_accesscard+','+CTERM_cardno;
//                                CTERM_guestcard=CTERM_guestcard+','+CTERM_cardno+',X';
//                                CTERM_ptddate+=','+CTERM_cardno+','+CTERM_ptd;
//                            }
//                        }
//                    }
                }

//                //CALCULATE LP N QUARTERS START
//                $CTERM_lpqrts=[];
//                $CTERM_rvlpqrts="";
//                $CTERM_calptd=[];
//                $CTERM_allfincustdetails=[];
//                $CTERM_prevrvdtls=[];
//                if(CTERM_customerptd!="")
//                {
//                    $CTERM_lp="",CTERM_qrtrs="";
//                    $CTERM_lpqrtrsstmt= CTERM_custdtlsconn.createStatement();
//                    $CTERM_lpqrtrsquery="SELECT CED.CED_REC_VER,U.UNIT_NO,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTD.CLP_PRETERMINATE_DATE FROM  CUSTOMER_ENTRY_DETAILS CED,CUSTOMER_LP_DETAILS CTD,CUSTOMER C,UNIT U   WHERE CED.CED_REC_VER=CTD.CED_REC_VER AND CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND(CTD.CED_REC_VER=CED.CED_REC_VER) AND CED.CUSTOMER_ID=C.CUSTOMER_ID AND   (CED.UNIT_ID=U.UNIT_ID) AND (CED.CUSTOMER_ID="+CTERM_custid+")  AND (CTD.CLP_STARTDATE<=CURDATE() OR CTD.CLP_STARTDATE>=CURDATE()) AND CED.CED_CANCEL_DATE IS NULL AND IF(CTD.CLP_PRETERMINATE_DATE IS NOT NULL,CTD.CLP_PRETERMINATE_DATE>CURDATE(),CTD.CLP_ENDDATE>CURDATE()) AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC"
//                    $CTERM_lpqrtrsres = CTERM_lpqrtrsstmt.executeQuery(CTERM_lpqrtrsquery);
//                    $iv=0;
//                    while(CTERM_lpqrtrsres.next())
//                    {
//                        $CTERM_chkedflag=0,CTERM_chkpdflag=0,CTERM_chksdflag=0;
//                        $CTERM_recversion=CTERM_lpqrtrsres.getString("CED_REC_VER");
//                        $CTERM_nextrv=0;
//                        CTERM_nextrv=parseInt(CTERM_recversion)+1;
//                        $CTERM_stdate=CTERM_lpqrtrsres.getString("CLP_STARTDATE");
//                        $CTERM_eddate=CTERM_lpqrtrsres.getString("CLP_ENDDATE");
//                        $CTERM_endddate=CTERM_eddate
//                        $CTERM_ptddddate=CTERM_lpqrtrsres.getString("CLP_PRETERMINATE_DATE");
//                        $CTERM_Leaseperiod="";$CTERM_quators="";
//                        if(parseInt(CTERM_recversion)<parseInt(CTERM_recver))
//                        {
//                            $CTERM_lpqrtrsnextrv_edstmt= CTERM_custdtlsconn.createStatement();
//                            $CTERM_lpqrtrsnextrv_edquery="SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS WHERE CED_REC_VER="+CTERM_nextrv+" AND CLP_STARTDATE='"+CTERM_eddate+"' AND CUSTOMER_ID="+CTERM_custid+" AND CLP_GUEST_CARD IS NULL ";
//                            $CTERM_lpqrtrsnextrv_edres = CTERM_lpqrtrsnextrv_edstmt.executeQuery(CTERM_lpqrtrsnextrv_edquery);
//                            while(CTERM_lpqrtrsnextrv_edres.next())
//                            {
//                                CTERM_chkedflag=1;
//                                CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                            }
//                            if(CTERM_chkedflag==0 )
//                            {
//                                if(CTERM_ptddddate!=null)
//                                {
//                                    CTERM_eddate=CTERM_ptddddate;
//                                    CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                                }
//                                else
//                                {
//                                    CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                                }
//                            }
//                        }
//                        if(CTERM_ptddddate!=null)
//                        {
//                            CTERM_eddate=CTERM_ptddddate;
//                        }
//                        if(CTERM_chkedflag==0)
//                        {
//                            $CTERM_lpqrtrsnextrv_ptdstmt= CTERM_custdtlsconn.createStatement();
//                            if(CTERM_ptddddate !=null)
//                            {
//                                if(new Date(Utilities.formatDate(new Date(CTERM_stdate.split('-')[0],CTERM_stdate.split('-')[1]-1,CTERM_stdate.split('-')[2]),TimeZone, 'yyyy/MM/dd 00:00:00'))<new Date(Utilities.formatDate(new Date(CTERM_eddate.split('-')[0],CTERM_eddate.split('-')[1]-1,CTERM_eddate.split('-')[2]),TimeZone, 'yyyy/MM/dd 00:00:00')))
//                                {
//                                    $CTERM_lpqrtrsnextrv_ptdquery="SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS WHERE CLP_GUEST_CARD IS NULL AND CED_REC_VER="+CTERM_nextrv+" AND CLP_ENDDATE>'"+CTERM_ptddddate+"' AND (CLP_STARTDATE>'"+CTERM_ptddddate+"' OR CLP_STARTDATE<'"+CTERM_ptddddate+"') AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_PRETERMINATE_DATE>CURDATE(),CLP_ENDDATE>CURDATE()) AND CUSTOMER_ID="+CTERM_custid+"";
//                                    $CTERM_lpqrtrsnextrv_ptdres = CTERM_lpqrtrsnextrv_ptdstmt.executeQuery(CTERM_lpqrtrsnextrv_ptdquery);
//                                    while(CTERM_lpqrtrsnextrv_ptdres.next())
//                                    {
//                                        CTERM_prevrvdtls.push({'recver':CTERM_nextrv,'startdate':CTERM_ptddddate,'enddate':CTERM_eddate});
//                                        $chkrecverflag=0;
//                                        for($ij=0;ij<CTERM_prevrvdtls.length;ij++)
//                                        {
//                                            if(CTERM_prevrvdtls[ij].recver==CTERM_recversion)
//                                            {
//                                                chkrecverflag=1;
//                                            }
//                                        }
//                                        if(chkrecverflag==0)
//                                        {
//                                            CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                                        }
//                                        CTERM_chkpdflag=1;
//                                    }
//                                }
//                            }
//                            else
//                            {
//                                $CTERM_lpqrtrsnextrv_sdquery="SELECT CLP_STARTDATE FROM CUSTOMER_LP_DETAILS WHERE CLP_GUEST_CARD IS NULL AND CED_REC_VER="+CTERM_nextrv+" AND CLP_ENDDATE>'"+CTERM_eddate+"' AND (CLP_STARTDATE>'"+CTERM_eddate+"' OR CLP_STARTDATE<'"+CTERM_eddate+"') AND IF(CLP_PRETERMINATE_DATE IS NOT NULL,CLP_PRETERMINATE_DATE>CURDATE(),CLP_ENDDATE>CURDATE()) AND CUSTOMER_ID="+CTERM_custid+"";
//                                $CTERM_lpqrtrsnextrv_sdres = CTERM_lpqrtrsnextrv_ptdstmt.executeQuery(CTERM_lpqrtrsnextrv_sdquery);
//                                while(CTERM_lpqrtrsnextrv_sdres.next())
//                                {
//                                    CTERM_prevrvdtls.push({'recver':CTERM_nextrv,'startdate':CTERM_eddate,'enddate':CTERM_eddate});
//                                    $chkrecverflag=0;
//                                    for($ij=0;ij<CTERM_prevrvdtls.length;ij++)
//                                    {
//                                        if(CTERM_prevrvdtls[ij].recver==CTERM_recversion)
//                                        {
//                                            chkrecverflag=1;
//                                        }
//                                    }
//                                    if(chkrecverflag==0)
//                                    {
//                                        CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                                    }
//                                    CTERM_chksdflag=1;
//                                }
//                            }
//                            if(CTERM_chkpdflag==0&&CTERM_chkedflag==0)
//                            {
//                                if(CTERM_ptddddate!=null)
//                                {
//                                    CTERM_eddate=CTERM_ptddddate;
//                                }
//                            }
//                            $chkrecverflag=0;
//                            for($ij=0;ij<CTERM_prevrvdtls.length;ij++)
//                            {
//                                if(CTERM_prevrvdtls[ij].recver==CTERM_recversion)
//                                {
//                                    chkrecverflag=1;
//                                }
//                            }
//                            if(chkrecverflag==0)
//                            {
//                                CTERM_prevrvdtls.push({'recver':CTERM_recversion,'startdate':CTERM_stdate,'enddate':CTERM_eddate});
//                            }
//                        }
//                    }//END FIRST WHILE
//                }//END FIRST IF WITH CUST PTD !=""
//                for($l=0;l<CTERM_prevrvdtls.length;l++)
//                {
//                    CTERM_calptd.push({"calrv":CTERM_prevrvdtls[l].recver,"calptd":CTERM_prevrvdtls[l].enddate});
//                    //QUATORS N LEASE PERIOD CALC
//                    $CTERM_sdate=(CTERM_prevrvdtls[l].startdate).split('-');
//                    $CTERM_edate=(CTERM_prevrvdtls[l].enddate).split('-');
//                    if(parseInt(CTERM_prevrvdtls[l].recver)>=parseInt(CTERM_recver))
//                    {
//                        CTERM_edate=CTERM_customerptd.split('-');
//                    }
//                    if(new Date(Utilities.formatDate(new Date(CTERM_edate[0],CTERM_edate[1]-1,CTERM_edate[2]),TimeZone, 'yyyy/MM/dd 00:00:00'))>new Date(Utilities.formatDate(new Date(CTERM_sdate[0],CTERM_sdate[1]-1,CTERM_sdate[2]),TimeZone, 'yyyy/MM/dd 00:00:00')))
//                    {
//                        CTERM_quators  = eilib.quarterCalc(new Date(CTERM_sdate[0],CTERM_sdate[1]-1,CTERM_sdate[2]),new Date(CTERM_edate[0],CTERM_edate[1]-1,CTERM_edate[2]));
//                        CTERM_Leaseperiod  = eilib.leasePeriodCalc(new Date(CTERM_sdate[0],CTERM_sdate[1]-1,CTERM_sdate[2]),new Date(CTERM_edate[0],CTERM_edate[1]-1,CTERM_edate[2]));
//                    }
//                    else
//                    {
//                        CTERM_Leaseperiod=" ";
//                        CTERM_quators=" ";
//                    }
//                    if(CTERM_rvlpqrts=="")
//                    {
//                        CTERM_rvlpqrts=CTERM_prevrvdtls[l].recver+",&"+CTERM_Leaseperiod+",&"+CTERM_quators;
//                    }
//                    else
//                    {
//                        CTERM_rvlpqrts+=",&"+CTERM_prevrvdtls[l].recver+",&"+CTERM_Leaseperiod+",&"+CTERM_quators;
//                    }
//                }
//                //CALCULATE LP N QUARTERS END
//                $calenderIDcode=eilib.CUST_getCalenderId(CTERM_custdtlsconn);//get calendar name from eilib
//                //cal calendar event function if cust is ptd
//                if(CTERM_customerptd!="")
//                {
//                    $CALEVENTS=eilib.CTermExtn_GetCalevent(CTERM_custdtlsconn,CTERM_custid);
//                }
//                $CTERM_activervvalue=parseInt(PropertiesService.getUserProperties().getProperty("cterm_activerv"));
//                $CTERM_savestmt=CTERM_custdtlsconn.createStatement();
//                CTERM_savestmt.execute("CALL SP_CUSTOMER_MANUAL_TERMINATION_INSERT("+CTERM_custid+","+CTERM_recver+","+CTERM_activervvalue+",'"+CTERM_accesscard+"','"+CTERM_guestcard+"','"+CTERM_ptddate+"','"+CTERM_rvlpqrts+"',"+CTERM_ptdsttime+","+CTERM_ptdedtime+",'"+CTERM_ta_comments+"','"+UserStamp+"',@TERMRESULT_FLAG)");
//                CTERM_savestmt.close();
            }
//            $CTERM_updateflag=0;
//            $CTERM_updateflag_stmt=CTERM_custdtlsconn.createStatement();
//            $CTERM_updateflag_query="SELECT @TERMRESULT_FLAG";
//            $CTERM_updateflag_rs=CTERM_updateflag_stmt.executeQuery(CTERM_updateflag_query);
//            while(CTERM_updateflag_rs.next())
//            {
//                CTERM_updateflag=CTERM_updateflag_rs.getString(1);
//            }
//            if(CTERM_updateflag==1&&(CTERM_radio_termoption=="CTERM_radio_activecust"))
//            {
//                if(CTERM_customerptd!="")
//                {
//                    for($ijk=0;ijk<CALEVENTS.length;ijk++)
//                    {
//                        eilib.CUST_customerTermcalenderdeletion(CTERM_custid,calenderIDcode,CALEVENTS[ijk].sddate,CALEVENTS[ijk].sdtimein,CALEVENTS[ijk].sdtimeout,CALEVENTS[ijk].eddate,CALEVENTS[ijk].edtimein,CALEVENTS[ijk].edtimeout,"")
//                    }
//                    eilib.CTermExtn_Calevent(CTERM_custdtlsconn,CTERM_custid,CTERM_recver,calenderIDcode,"TERMINATION",CTERM_updateflag);
//                }
//            }
//            CTERM_updateflag_rs.close();
//            CTERM_updateflag_stmt.close();
//            CTERM_custdtlsconn.commit();
//            CTERM_custdtlsconn.close();
//            return CTERM_updateflag;
//        }
//        catch(err)
//        {
//            Logger.log("SCRIPT EXCEPTION:"+err)
//            CTERM_custdtlsconn.rollback();
//            if(CTERM_customerptd!=""&&CTERM_customerptd!=undefined)
//            {
//                eilib.CTermExtn_Calevent(CTERM_custdtlsconn,CTERM_custid,CTERM_recver,calenderIDcode,"TERMINATION",0);
//            }
//            return (Logger.getLog());
//        }
    }
}