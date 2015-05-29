<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 18/5/15
 * Time: 7:54 PM
 */
include "./application/controllers/GET_USERSTAMP.php";
//require_once 'google/appengine/api/mail/Message.php';
//use \google\appengine\api\mail\Message;


class Invoice_contract extends CI_Model{
//COMMON FUNCTION TO CREATE CALENDAR ID
    public function createCalendarService($ClientId,$ClientSecret,$RedirectUri,$DriveScopes,$CalenderScopes,$Refresh_Token){
//create start event
        $drive = new Google_Client();
        $drive->setClientId($ClientId);
        $drive->setClientSecret($ClientSecret);
        $drive->setRedirectUri($RedirectUri);
        $drive->setScopes(array($DriveScopes,$CalenderScopes));
        $drive->setAccessType('online');
        $authUrl = $drive->createAuthUrl();
        $access_token=$drive->getAccessToken();
        $refresh_token=$Refresh_Token;
        $drive->refreshToken($refresh_token);
        $service = new Google_Service_Drive($drive);
        return $service;
    }
//SET DOC OWNER FUNCTIONS
    public function SetDocOwner($service,$docid,$docowner,$semailid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$docid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            if($editorfile[$j]!=$semailid)
            {
                try {
                    $this->URSRC_RemoveEditor($service,$docid,$editorfile[$j]);
                } catch (Exception $e) {
                }
            }
        }
        if($docowner!=$semailid)
        {
            try {
                $this->URSRC_AddEditor($service,$docid,$semailid);
            } catch (Exception $e) {
            }
        }
        SetDocOwnerGivenId($service,$docid,$docowner);
    }
    public   function CUST_SetDocOwner($service,$docid,$docowner,$semailid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$docid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            if($editorfile[$j]!=$semailid)
            {
                try {
                    $this->URSRC_RemoveEditor($service,$docid,$editorfile[$j]);
                } catch (Exception $e) {
                }
            }
        }
        if($docowner!=$semailid)
        {
            try {
                $this->URSRC_AddEditor($service,$docid,$semailid);
            } catch (Exception $e) {
            }
        }
    }
//FUNCTION TO REMOVE EDITORS IF SESSION ID NOT OWNER OR EDITOR
    public function RemoveEditors($service,$docid,$email_fetch,$docowner,$UserStamp)
    {
        SetDocOwnerGivenId($service,$docid,$docowner);
        if(($email_fetch!=$UserStamp)&&($docowner!=$UserStamp))
        {
            try {
                $this->URSRC_RemoveEditor($service,$docid,$email_fetch);
            } catch (Exception $e) {
            }
        }
    }
//***********UNSHARE FILE**********************/
    public  function CUST_UNSHARE_FILE($service,$fileid)
    {
        $editorfile= $this->URSRC_GetAllEditors($service,$fileid);
        for($j=0;$j<count($editorfile);$j++)
        {
            if($editorfile[$j]=="")continue;
            try {
                $this->URSRC_RemoveEditor($service,$fileid,$editorfile[$j]);
            } catch (Exception $e) {
            }
        }
        try {
            $service->files->trash($fileid);
        } catch (Exception $e) {
        }
    }
    public function URSRC_GetAllEditors($service,$fileid){
        try {
            $permission_id=array();
            $emailadrress=array();
            $role_array=array();
            $permissions = $service->permissions->listPermissions($fileid);
            $return_value= $permissions->getItems();
            foreach ($return_value as $key => $value) {
                $permission_id[]=$value->id;
                $emailadrress[]=$value->emailAddress;
                $role_array[]=$value->role;
            }
        } catch (Exception $e) {
            $emailadrress=array();
        }
        return $emailadrress;
    }
//GET TEMPLATE FOLDER ID
    public  function getTemplatesFolderId()
    {
        $this->db->select("FP_FOLDER_ID");
        $this->db->from('FILE_PROFILE');
        $this->db->where('FP_ID=1');
        return $this->db->get()->row()->FP_FOLDER_ID;
    }
//FUNCTION TO CALCULATE PRORATED RENT
    public  function proratedmonthcalculation($startdate,$enddate) {
        $startdateString = strtotime ($startdate);
        $enddateString = strtotime ($enddate);
        $s_day=date("d", $startdateString);
        $s_month=date("m", $startdateString);
        $s_year=date("Y", $startdateString);
        $e_day=date("d", $enddateString);
        $e_month=date("m", $enddateString);
        $e_year=date("Y", $enddateString);

        $dateStringCheckin=strtotime($startdate);
        $startdate_oneMonth = strtotime ("+1 month",$dateStringCheckin);
        $newstartdate= date("Y-m-d",$startdate_oneMonth);
        $startdate_array=[];
        $enddate_array=[];
        if(($e_month!=$s_month)||($e_year!=$s_year))
        {
            $startdates=$startdate;
            for($i=0;$i<100;$i++)
            {
                $dateStringCheckin=strtotime($startdate);
                $startdate_oneMonth = strtotime ("+".$i." month",$dateStringCheckin);
                $startdates= date("Y-m-d",$startdate_oneMonth);
                if($startdates<=$enddate)
                {
                    if($s_day!=1 && $i==0)
                    {
                        $startdate_array[]= date("Y-m-d",strtotime($startdate));
                    }else{$startdate_array[]=$startdates;}
                    $monthenddate = strtotime ("+".($i+1)." month",$dateStringCheckin);
                    $monthenddate= date("Y-m-d",$monthenddate);
                    $month_enddateString=strtotime($monthenddate);
                    $startdate_oneDay = strtotime ("-1 day",$month_enddateString);
                    $month_enddate= date("Y-m-d",$startdate_oneDay);
                    if($e_month!=date("m", strtotime($month_enddate)) || $e_year!=date("Y", strtotime($month_enddate)))
                    {
                        $MonthMinusDay = strtotime ("-1 day",strtotime($monthenddate));
                        $month_enddate= date("Y-m-d",$startdate_oneDay);
                        $date = new DateTime();
                        $date->setDate($s_year,(intval($s_month)+$i+1),date("d", strtotime($MonthMinusDay)));
                        $enddate_array[]=$date->format('Y-m-d') ;
                    }
                    else{$enddate_array[]=$enddate;}
                }
                else
                {
                    break;
                }
            }
        }
        else
        {
            $startdate_array[] =date("Y-m-d",strtotime($startdate));
            $enddate_array[] =date("Y-m-d",strtotime($enddate));
        }
        $return_array=[$startdate_array,$enddate_array];
        return $return_array;
    }
//FUNCTION TO CALCULATE NON PRORATED RENT
    public  function nonproratedmonthcalculation($startdate,$enddate)
    {
        $startdateString = strtotime ($startdate);
        $enddateString = strtotime ($enddate);
        $s_day=date("d", $startdateString);
        $s_month=date("m", $startdateString);
        $s_year=date("Y", $startdateString);
        $e_day=date("d", $enddateString);
        $e_month=date("m", $enddateString);
        $e_year=date("Y", $enddateString);
        $dateStringCheckin=strtotime($startdate);
        $startdate_oneMonth = strtotime ("+1 month",$dateStringCheckin);
        $newstartdate= date("Y-m-d",$startdate_oneMonth);
        $startdate_array=[];
        $enddate_array=[];
        $startdates=$startdate;
        for($i=0;$i<100;$i++)
        {
            $dateStringCheckin=strtotime($startdate);
            $startdate_oneMonth = strtotime ("+".$i." month",$dateStringCheckin);
            $startdates= date("Y-m-d",$startdate_oneMonth);
            if($startdates<=$enddate)
            {
                if($s_day!=1 && $i==0)
                {
                    $startdate_array[]=date("Y-m-d", strtotime($startdate));
                }
                else
                {
                    $startdate_array[]=$startdates;
                }
                $dateStringCheckin=strtotime($startdate);
                $startdate_oneMonth = strtotime ("+".(intval($i)+1)." month",$dateStringCheckin);
                $monthenddate= date("Y-m-d",$startdate_oneMonth);
                if($monthenddate<$enddate)
                {
                    $MonthMinusDay = strtotime ("-1 day",strtotime($monthenddate));
                    $date = new DateTime();
                    $date->setDate($s_year,(intval($s_month)+$i+1),date("d", strtotime($MonthMinusDay)));
                    $enddate_array[]=$date->format('Y-m-d') ;
                }
                else
                {
                    $enddate_array[]=$enddate;
                }
            }
            else
            {
                break;
            }
        }
        $return_array=[$startdate_array,$enddate_array];
        return $return_array;
    }
//FUNCTION TO REMOVE EDITORS FOR INVOICE N CONTRACT
    public function InvAndConRemoveEditors($service,$invdocid,$contdocid,$email_fetch,$docowner,$UserStamp)
    {
        SetDocOwnerGivenId($service,$invdocid,$docowner);
        SetDocOwnerGivenId($service,$contdocid,$docowner);
        if(($email_fetch!=$UserStamp)&&($docowner!=$UserStamp))
        {
            $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$invdocid,$email_fetch);
            $URSRC_sharedocflag=$this->URSRC_RemoveEditor($service,$contdocid,$email_fetch);
        }
    }
    public  function URSRC_RemoveEditor($service,$fileid,$URSRC_loginid){
        $URSRC_sharedocflag='';
        try {
            $permissions = $service->permissions->listPermissions($fileid);
            $return_value= $permissions->getItems();
            $permission_id='';
            foreach ($return_value as $key => $value) {
                if ($value->emailAddress==$URSRC_loginid) {
                    $permission_id=$value->id;
                }
            }
            if($permission_id!=''){
                try {
                    $service->permissions->delete($fileid, $permission_id);
//        $ss_flag=1;
                } catch (Exception $e) {
//        print "An error occurred: " . $e->getMessage();
//        $ss_flag=0;
                }
            }
            $URSRC_sharedocflag=1;

        } catch (Exception $e) {
            $URSRC_sharedocflag=0;
        }
        return $URSRC_sharedocflag;
    }
    public  function URSRC_AddEditor($service,$fileid,$URSRC_loginid){
        $value=$URSRC_loginid;
        $type='user';
        $role='writer';
        $email=$URSRC_loginid;
        $newPermission = new Google_Service_Drive_Permission();
        $newPermission->setValue($value);
        $newPermission->setType($type);
        $newPermission->setRole($role);
        $newPermission->setEmailAddress($email);
        try {
            $service->permissions->insert($fileid, $newPermission);
        } catch (Exception $e) {
        }
    }
    public function URSRC_GetAllFiles($service,$folderid){
        $children1 = $service->children->listChildren($folderid);
        $filearray1=$children1->getItems();
        $emp_uploadfilenamelist=array();
        foreach ($filearray1 as $child1) {
            $emp_uploadfilenamelist[]=($child1->getId());
        }
        return $emp_uploadfilenamelist;
    }
//
//CUSTOMER CONTRACT MAIL
    public   function CUST_contract($service,$unitno,$checkindate,$checkoutdate,$companyname,$customername,$noticeperiod,$passportno,$passportdate,$epno,$epdate,$noticedate,$lp,$cardno,$rent,$airquartfee,$airfixedfee,$electcap,$dryclean,$chkoutfee,$procfee,$deposit,$waived,$roomtype,$rent_check,$formname,$sendmailid,$docowner) {
        $fileid="1OScbLPz0naY82-jG4bvVkRuQdIL8InLKAH9Tte6TPmM";
        $parentId="0B_f0d7mdbV_USzUyaC1ZUWpyU2M";
        try {$noticeperiod="90.88";
            $this->load->model('Eilib/Common_function');
            $fileid= $this->Common_function->CUST_FileId_invoiceTem();
            $parentId= $this->Common_function->CUST_TargetFolderId();
            $url = "https://script.google.com/macros/s/AKfycbyv58HZU2XsR2kbCMWZjNzMWSmOwoE7xsg_fesXktGk4Kj574u1/exec";
            $cust_config_array=$this->CUST_invoice_contractreplacetext();
//    $this->load->model('Eilib/currencyToWord');
//    $RENTword= $this->currencyToWord->currency_To_Word($rent);
//    $DEPOSITword=$this->currencyToWord->currency_To_Word($deposit);
//    $PROCESSword=$this->currencyToWord->currency_To_Word($procfee);
//    $noticeperiod=$this->currencyToWord->currency_To_Word($noticeperiod);
            $webloginfetch=$this->Common_function->CUST_GetLogindtls($unitno);
            $cust_config_array_concate=$cust_config_array[0];
            for($s=1;$s<count($cust_config_array);$s++){
                $cust_config_array_concate.='^~^'.$cust_config_array[$s];
            }
            $rentstring = $rent;//.toString();
            $this->load->model('Eilib/currencyToWord');
            $RENTword= $this->currencyToWord->currency_To_Word($rentstring);
            $quartaircon_fetch=$airquartfee;
            $fixedaircon_fetch=$airfixedfee;
            $electricity=$electcap;
            if($electricity==null)
            {
                $elec_fetch="00.00";
            }
            else
            {
                $elec_fetch=$electricity;
            }
            $dryclean=$dryclean;
            if($dryclean==null)
            {
                $dryclean_fetch="00.00";
            }
            else
            {
                $dryclean_fetch=$dryclean;
            }
            $checkout=$chkoutfee;
            if($checkout==null)
            {
                $checkoutfee_fetch="00.00";
            }
            else
            {
                $checkoutfee_fetch=$checkout;
            }
            if($procfee ==null)
            {
                $PROCESSno="00.00";
                $PROCESSword = "  ";
            }
            else
            {
                $PROCESSno= $procfee;
                $prostring =  $PROCESSno;//.toString();
                $this->load->model('Eilib/currencyToWord');
                $PROCESSword= $this->currencyToWord->currency_To_Word($prostring);
            }
            if($deposit == null)
            {
                $DEPOSITno="00.00";
                $DEPOSITEword="  ";
            }
            else
            {
                $DEPOSITno=$deposit;
                $depstring =$DEPOSITno;//.toString();
                $this->load->model('Eilib/currencyToWord');
                $DEPOSITEword= $this->currencyToWord->currency_To_Word($depstring);
            }
            $data = array('elec_fetch'=> $elec_fetch,'dryclean_fetch'=> $dryclean_fetch,'checkoutfee_fetch'=> $checkoutfee_fetch,'PROCESSno'=> $PROCESSno,'DEPOSITno'=> $DEPOSITno,'weblogin'=>$webloginfetch,'flag'=>1,'cust_config_array' => $cust_config_array_concate, 'RENTword' => $RENTword, 'PROCESSword' => $PROCESSword,'DEPOSITword'=>$DEPOSITword, 'proratedrent' => "shld present in word", 'proratedsmonth' => "2014-09-09"
            , 'proratedemonth' => "2014-09-09", 'unitno' => $unitno, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'companyname' => $companyname, 'customername' => $customername, 'noticeperiod' => $noticeperiod,
                'passportno'=>   $passportno,'passportdate'=>$passportdate,'epno'=>$epno,'epdate'=>$epdate,'noticedate'=>$noticedate,'lp'=>$lp,'cardno'=>$cardno,'rent'=>$rent,
                'airquartfee'=>$airquartfee,'airfixedfee'=>$airfixedfee,'electcap'=>$electcap,'dryclean'=>$dryclean,'chkoutfee'=>$chkoutfee,'procfee'=>$procfee,
                'deposit'=>$deposit,'waived'=>$waived,'roomtype'=>$roomtype,'rent_check'=>$rent_check,'formname'=>$formname,
                'targetFolderId'=>"TEST" );
            $ch = curl_init();
            $data=http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
            try {
                $response = curl_exec($ch);
            }
            catch(Exception $e){
                echo   $e->getMessage();
            }
            curl_close($ch);
            $file = new Google_Service_Drive_DriveFile();
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
            try {
                $service->files->patch($response, $file);
            }
            catch(Exception $e){
                echo   $e->getMessage();
            }
            return $response;
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
        $this->CUST_SetDocOwner($service,$response,$docowner,$sendmailid);
    }

//GET INVOICE ID ,CONTRACT ID ,SERIAL NO,INVOIC DATE
    public function CUST_invoice_contractreplacetext()
    {
        $this->db->select("CCN_DATA");
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CCN_ID IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,35,37,43)');
        $result=array();
        foreach ($this->db->get()->result_array() as $key=>$val)
        {
            $result[]=$val['CCN_DATA'];
        }
        return $result;
    }
//DOCUMENT OWNER
    public  function SetDocOwnerGivenId($service,$fileid,$URSRC_loginid){
        $value=$URSRC_loginid;
        $type='user';
        $role='owner';
        $email=$URSRC_loginid;
        $newPermission = new Google_Service_Drive_Permission();
        $newPermission->setValue($value);
        $newPermission->setType($type);
        $newPermission->setRole($role);
        $newPermission->setEmailAddress($email);
        try {
            $service->permissions->insert($fileid, $newPermission);
        } catch (Exception $e) {
        }
    }
//FUNCTION TO CREATE INVOICE
    public  function CUST_invoice($UserStamp,$service,$unit,$customername,$companyname,$invoiceid,$invoicesno,$invoicedate,$rent,$process,$deposit,$sdate,$edate,$roomtype,$Leaseperiod,$rentcheck,$docowner,$formname,$waived,$custid)
    {
        $invoiceidcode=$invoiceid;
        $Slno=$invoicesno;
        $Sdate=$invoicedate;
        $tenant_fetch=$customername;
        $unit_fetch=$unit;
        $company_fetch=$companyname;
        if($company_fetch==null||$company_fetch=="")
        { $company_fetch=' ';}
        $checkin_fetch=$sdate;
        $checkout_fetch=$edate;
        $deposit=$deposit;
        if($deposit==null)
        {  $A3='00.00';  }  else  {    $A3=$deposit;  }
        $process=$process;
        if($process==null||$waived!="")
        {$A4='00.00';}else{$A4=$process;}
        $A5=$rent;
        $lease_fetch=$Leaseperiod;
        $SdateD = $Sdate;
        $sysdate =date('d-m-Y');
        $todaydatc = date('Y-m-d');// Utilities.formatDate(new Date(sysdate), TimeZone, "yyyy/MM/dd");
        $todaysDate=strtotime($todaydatc);
        $todaydat = date('d-m-Y');//Utilities.formatDate(new Date(), TimeZone, "dd/MM/yyyy");
        $todaydatR =date('m-d-Y');// Utilities.formatDate(new Date(), TimeZone, "MM/dd/yyyy");
        if(strtotime($SdateD) == strtotime("today"))
        {
            $Slno++;
            if(0>=$Slno && $Slno<=9){
                $Slno= (String)("00"+$Slno);
            }
            else if(10>=$Slno && $Slno<=99){
                $Slno= "0".$Slno;
            }
            $this->load->model('Eilib/Common_function');
            $this->Common_function->CUST_invoicesearialnoupdation($Slno);
        }
        else
        {
            $Slno = 1;
            if($Slno==1){
                $Slno= (String)("00"+$Slno);
            }

            $todaydatc = date("d/m/Y");// Utilities.formatDate(new Date(sysdate), TimeZone, "dd/MM/yyyy");
            $cc_invoicedate = date("Y/m/d");//  Utilities.formatDate(new Date(sysdate), TimeZone, "yyyy/MM/dd");
            $this->load->model('Eilib/Common_function');
//      $this->Common_function->CUST_invoiceserialandinvoicedateupdation($Slno, $cc_invoicedate);
        }
        $todaydatestring =  date("Y-M-d");
        $pc = floatval($A3); // processing cost to float
        $ren = floatval($A5); // rent amount to float
        $das = floatval($A4); // deposite amount to float
        $date_fetch=strtotime($checkin_fetch);
        $check_in_dated_minus = strtotime ("-1 month",$date_fetch);
        $check_in_date= date("Y-m-d",$check_in_dated_minus);

        $dateStringCheckin=strtotime($check_in_date);
        $check_in_dated_lastmonth = strtotime ("+1 month",$dateStringCheckin);
        $check_in_date1= date("Y-M-d",$check_in_dated_lastmonth);

        $dateStringCheckOut=strtotime($checkout_fetch);
        $check_out_dated_lastmonth = strtotime ("-1 month",$dateStringCheckOut);
        $check_out_date= date("Y-m-d",$check_out_dated_lastmonth);
        $check_out_date1= date("Y-M-d",$check_out_dated_lastmonth);
// to generate last date of a month
        $curr_date = 0;

        $curr_month = intval(date("m", $check_in_dated_minus));
        $curr_month++;
        $curr_year = intval(date("Y", $check_in_dated_minus));
        $cdate1="";
        $cdate2="";
        strpos($lease_fetch,"Year")==false?$yearchk=-1:$yearchk=strpos($lease_fetch,"Year");
        strpos($lease_fetch,"Months")==false?$monthschk=-1:$monthschk=strpos($lease_fetch,"Months");
        strpos($lease_fetch,"Month")==false?$monthchk=-1:$monthchk=strpos($lease_fetch,"Month");
        strpos($lease_fetch,"Day")==false?$daychk=-1:$daychk=strpos($lease_fetch,"Day");
        $check_in_dated_lastmonth = strtotime ("+1 month",$dateStringCheckin);
        $LastMonth= date("Y-m-d",$check_in_dated_lastmonth);
        $rent_check=$rentcheck;
        $this->load->model('Eilib/Invoice_contract');
        $nonPror_monthCal=    $this->Invoice_contract->nonproratedmonthcalculation($check_in_date,$check_out_date);
        $prorated_monthCal=    $this->Invoice_contract->proratedmonthcalculation($check_in_date,$check_out_date);
        $Pror_monthCal_concate_start='';$Pror_monthCal_concate_end='';
        $this->load->model('Eilib/ProratedCalc');
        $proratedrent=$this->ProratedCalc->wMonthProratedCalc($check_in_date,$check_out_date,$rent);
        $proratedsmonth=$this->ProratedCalc->sMonthProratedCalc($check_in_date,$rent);
        $proratedemonth=$this->ProratedCalc->eMonthProratedCalc($check_out_date,$rent);
        echo $formname;
        if(  $formname=="CREATION" ||   $formname=="RECHECKIN")
        {
            if((  $yearchk>0)||(  $monthschk>0)||((  $monthchk>0)&&(  $daychk>0)))
            {
                if(  $rent_check=='false')
                {
                    echo 'if';
                    $proratedrentflag=1;
                    $month_calculation=$this->nonproratedmonthcalculation(  $check_in_date,  $check_out_date);
                    $startdate_array=  $month_calculation[0];
                    $enddate_array=  $month_calculation[1];
                    $Pror_monthCal_concate_start=$month_calculation[0][0];
                    $Pror_monthCal_concate_end=$month_calculation[1][0];
                    for($k=1;$k<count($month_calculation[0]);$k++){
                        $Pror_monthCal_concate_start.= '^^'.$prorated_monthCal[0][$k];
                    }
                    for($k=1;$k<count($month_calculation[1]);$k++){
                        $Pror_monthCal_concate_end.= '^^'.$prorated_monthCal[1][$k];
                    }
                    $length=  count($startdate_array);
                }
                else{
                    echo 'else';
                    $proratedrentflag=2;
                    $month_calculation=$this->proratedmonthcalculation($check_in_date,$check_out_date);
                    $startdate_array=$month_calculation[0];
                    $enddate_array=$month_calculation[1];
                    $Pror_monthCal_concate_start=$month_calculation[0][0];
                    $Pror_monthCal_concate_end=$month_calculation[1][0];
                    for($k=1;$k<count($month_calculation[0]);$k++){
                        $Pror_monthCal_concate_start.= '^^'.$prorated_monthCal[0][$k];
                    }
                    for($k=1;$k<count($month_calculation[1]);$k++){
                        $Pror_monthCal_concate_end.= '^^'.$prorated_monthCal[1][$k];
                    }
                    $length=count($startdate_array);
                }
            }
            else
            {
                $length=1;
                $proratedrentflag=0;
                $cdate1=$check_in_date1;
                $cdate2=$check_out_date1;
                $sum1 = $das+$pc+floatval($A5);
                $sum = round($sum1, 2);
                //$sum =sprintf("%01.2f", $sum1);//$sum1.toFixed(2);
            }
        }
        else if( $formname=="EXTENSION")//extension....
        {
            if((( $yearchk>0)||( $monthschk>0)||(( $monthchk>0)&&( $daychk>0)))&&( $rent_check=='true'))//greater than a month-rent check true
            {
                $proratedrentflag=2;
                $month_calculation=$this->proratedmonthcalculation( $check_in_date, $check_out_date);
                $startdate_array= $month_calculation[0];
                $enddate_array= $month_calculation[1];
                $Pror_monthCal_concate_start=$month_calculation[0][0];
                $Pror_monthCal_concate_end=$month_calculation[1][0];
                for($k=1;$k<count($month_calculation[0]);$k++){
                    $Pror_monthCal_concate_start.= '^^'.$prorated_monthCal[0][$k];
                }
                for($k=1;$k<count($month_calculation[1]);$k++){
                    $Pror_monthCal_concate_end.= '^^'.$prorated_monthCal[1][$k];
                }
                $length=count( $startdate_array);
            }
            else if((( $yearchk>0)||( $monthschk>0)||(( $monthchk>0)&&( $daychk>0)))&&( $rent_check=='false'))//greater than a month-rent check false
            {
                $proratedrentflag=1;
                $month_calculation=$this->nonproratedmonthcalculation( $check_in_date, $check_out_date);
                $startdate_array= $month_calculation[0];
                $enddate_array= $month_calculation[1];
                $Pror_monthCal_concate_start=$month_calculation[0][0];
                $Pror_monthCal_concate_end=$month_calculation[1][0];
                for($k=1;$k<count($month_calculation[0]);$k++){
                    $Pror_monthCal_concate_start.= '^^'.$prorated_monthCal[0][$k];
                }
                for($k=1;$k<count($month_calculation[1]);$k++){
                    $Pror_monthCal_concate_end.= '^^'.$prorated_monthCal[1][$k];
                }

                $length=count($startdate_array);
            }
            else if(((( $yearchk<0)&&( $monthschk<0)&&( $daychk>0)&&( $monthchk<0))||(( $yearchk<0)&&( $monthschk<0)&&( $daychk<0)&&( $monthchk>0)))&&( $rent_check=='true'))//less than or equal to a month
            {
                $length=1;
                $proratedrentflag=0;
                $cdate1= $check_in_date1;
                $cdate2= $check_out_date1;
                if((date("Y", $check_in_dated_minus)==date("Y", $check_out_dated_lastmonth)) &&(date("m", $check_in_dated_minus)==date("m", $check_out_dated_lastmonth)))
                {
                    $proratedrent=$this->ProratedCalc->wMonthProratedCalc($check_in_date,$check_out_date,$A5);
                    $sum1 = $das+$pc+floatval($proratedrent);
                    $sum = round($sum1, 2);//sprintf("%01.2f", $sum1);//$sum1.toFixed(2);
                }
                else if((date("Y", $check_in_dated_minus)!=date("Y", $check_out_dated_lastmonth)) &&(date("m", $check_in_dated_minus)!=date("m", $check_out_dated_lastmonth)))
                {
                    $proratedsmonth=$this->ProratedCalc->sMonthProratedCalc($check_in_date,$A5);
                    $proratedemonth=$this->ProratedCalc->eMonthProratedCalc($check_out_date,$A5);
                    $proratedrent=round(floatval($proratedsmonth)+floatval($proratedemonth),2);//.toFixed(2);
                    if($proratedrent!='0.00')
                    {
                        $sum1 = $das+$pc+floatval($proratedrent);
                        $sum = round($sum1,2);
                    }
                    else
                    {
                        $sum1 = $das+$pc+$ren;
                        $sum = round($sum1,2);//.toFixed(2);
                    }
                }
            }
        }

        $data = array(
            'Pror_monthCal_concate_start'=>$Pror_monthCal_concate_start,'Pror_monthCal_concate_end'=>$Pror_monthCal_concate_end,'todaydat'=>$todaydat,'todaydatestring'=>$todaydatestring,'A3'=>$A3,'A4'=>$A4,'das'=>$das,'pc'=>$pc,'A5'=>$A5,'sum'=>$sum,'cdate1'=>$cdate1,'cdate2'=>$cdate2,'todaysDate'=>$todaysDate,'Slno'=>$Slno,'tenant_fetch' => $tenant_fetch,'length'=>$length,'proratedrentflag'=>$proratedrentflag,
            'nonPror_monthCal'=>$nonPror_monthCal,'flag'=>2,'prorated_monthCal' => $prorated_monthCal, 'proratedrent' => $proratedrent, 'proratedsmonth' => $proratedsmonth,'proratedemonth'=>$proratedemonth,
            'unit' => $unit, 'customername' => $customername
        , 'companyname' =>$company_fetch, 'invoiceid' => $invoiceid,'invoicesno' => $invoicesno, 'invoicedate' => $invoicedate,
            'rent' => $rent, 'process' => $process, 'deposit' => $deposit,'sdate'=>$sdate,'edate'=>$edate,'roomtype'=>$roomtype,
            'Leaseperiod'=>$Leaseperiod,'Leaseperiod'=>$Leaseperiod,'rentcheck'=>$rentcheck,'docowner'=>$docowner,'formname'=>$formname,
            'waived'=>$waived,'custid'=>$custid );
        $url="https://script.google.com/macros/s/AKfycbyv58HZU2XsR2kbCMWZjNzMWSmOwoE7xsg_fesXktGk4Kj574u1/exec";
        $ch = curl_init();
        $data=http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// This is what solved the issue (Accepting gzip encoding)
        curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");
        try {
            $response = curl_exec($ch);
        }
        catch(Exception $e){
            echo   $e->getMessage();
        }
        curl_close($ch);
        echo '****'.$response;
        $parentId= $this->Common_function->CUST_TargetFolderId();
        $file = new Google_Service_Drive_DriveFile();
        $parent = new Google_Service_Drive_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));
        try {
            $service->files->patch($response, $file);
        }
        catch(Exception $e){
            echo   $e->getMessage();
        }



    }
} 