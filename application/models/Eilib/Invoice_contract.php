<?php
/**
* Created by PhpStorm.
* User: SSOMENS-021
* Date: 18/5/15
* Time: 7:54 PM
*/
//include "./application/controllers/GET_USERSTAMP.php";
//echo $UserStamp;
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
$editorfile= URSRC_GetAllEditors($service,$docid);
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
$editorfile= URSRC_GetAllEditors($service,$docid);
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
$editorfile= URSRC_GetAllEditors($service,$fileid);
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
          $startdate_array[]= date("Y-m-d",$startdate);
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
  $startdate_array[] =date("Y-m-d",$startdate);
  $enddate_array[] =date("Y-m-d",$enddate);
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
    if($s_day!=1 && i==0)
    {
        $startdate_array[]=date("Y-m-d", $startdate);
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
//    $value=$docowner;
//    $type='user';
//    $role='owner';
//    $email=$docowner;
//    $newPermission = new Google_Service_Drive_Permission();
//    $newPermission->setValue($value);
//    $newPermission->setType($type);
//    $newPermission->setRole($role);
//    $newPermission->setEmailAddress($email);
//    $service->permissions->insert($invdocid, $newPermission);
//    $value=$docowner;
//    $type='user';
//    $role='owner';
//    $email=$docowner;
//    $newPermission = new Google_Service_Drive_Permission();
//    $newPermission->setValue($value);
//    $newPermission->setType($type);
//    $newPermission->setRole($role);
//    $newPermission->setEmailAddress($email);
//    $service->permissions->insert($contdocid, $newPermission);
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
public function CUST_invoicemail($service,$unit,$customername,$companyname,$invoiceid,$invoicesno,$invoicedate,$rent,$process,$deposit,$sdate,$edate,$roomtype,$Leaseperiod,$rentcheck,$docowner,$formname,$waived,$custid) {
    $fileid="1q3EmDlsoIuTOxlcCX8pWRgd4UfbfllIDBz_3ob0oC0w";
    try {
        $file = new Google_Service_Drive_DriveFile();
        $this->load->model('Eilib/Common_function');
        $fileid= $this->Common_function->CUST_TargetFolderId();
        $parentId=$this->getTemplatesFolderId();
//        $parentId="0Bzvv-O9jT9r_fmhRYmU4ejJLbFpPaDEyX092OWQwNjFjbEVIT21jei16R1AwRWFxWkFET2c";
//        $fileid="1q3EmDlsoIuTOxlcCX8pWRgd4UfbfllIDBz_3ob0oC0w";
            $file = $service->files->get($fileid);
            $title=$file->getTitle();
            $description=$file->getDescription();
            $mimeType=$file->getMimeType();
        $file->setMimeType($mimeType);
        // Set the parent folder.
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        $filecontent=file_get_contents("./application/models/Eilib/invoiceTemplate.docx");
        $filecontent =str_replace('image','<img src="https://lh5.googleusercontent.com/SVfRz3bO5qXc63vV8qowPur1VpD_p3ks_WGk9LpMSBWDaiPB5RUNlFc1JrgHmMFB9r5kaZMyu9p88UBrbtEjIa1m2iQUdil6B_nnSp9ngGT-ffSCxcRKK30BrmHMXt55aQDO8WM">', $filecontent);
        file_put_contents("./application/models/Eilib/invoiceReplaced.docx",$filecontent);
        $filecontent=file_get_contents("./application/models/Eilib/invoiceReplaced.docx");
        $result=$this->insertFile($service,$title, $description, $parentId, $mimeType, $filecontent);
        echo $result->embedLink;
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
}
//CUSTOMER CONTRACT MAIL
public   function CUST_contractmail($service,$unitno,$checkindate,$checkoutdate,$companyname,$customername,$noticeperiod,$passportno,$passportdate,$epno,$epdate,$noticedate,$lp,$cardno,$rent,$airquartfee,$airfixedfee,$electcap,$dryclean,$chkoutfee,$procfee,$deposit,$waived,$roomtype,$rent_check,$formname,$filecontent) {
  $fileid="1OScbLPz0naY82-jG4bvVkRuQdIL8InLKAH9Tte6TPmM";
    $parentId="0Bzvv-O9jT9r_fmhRYmU4ejJLbFpPaDEyX092OWQwNjFjbEVIT21jei16R1AwRWFxWkFET2c";
    try {
        $this->load->model('Eilib/Common_function');
        $fileid= $this->Common_function->CUST_FileId_invoiceTem();
        $parentId=$this->getTemplatesFolderId();
        $file = $service->files->get($fileid);
        $title=$file->getTitle();
        $description=$file->getDescription();
        $mimeType=$file->getMimeType();
//            $filecontent=$this->downloadFile($service, $file);
        $filecontent=file_get_contents("./application/models/Eilib/contractTemplate.docx");
//                        $arrAlpha=['0','a.','b.','c.','d.','e.','f.','g.','h.','i.','j.','k.','l.','m.','n.','o.','p.','q.','r.','s.','t.'];
//                $splitNumeric=explode("1. ",$filecontent);
//            $leaseSplit=explode($splitNumeric[3],$filecontent);
//            $leaseSplit=explode("4. ",$leaseSplit[1]);
//           $oldValue=$leaseSplit[0];
//            $newValue=$oldValue;
//            $leaseSplitThree=explode("1. ",$leaseSplit[0]);
//            for($s=0;$s<count($leaseSplitThree);$s++){
//                $convertAlphpa=$arrAlpha[$s+1];
////                echo $convertAlphpa.'***';
//                $newValue =preg_replace("/1. /",'<b>'.$arrAlpha[$s+1].'</b>', $newValue,1);
//            }
//            $filecontent =str_replace($oldValue,$newValue, $filecontent);
//            $leaseSplitFour=explode("1.",$leaseSplit[1]);
//            $oldValue=$leaseSplit[1];
//            $newValue=$oldValue;
//            for($s=0;$s<count($leaseSplitFour);$s++){
//                $newValue =preg_replace("/1. /",$arrAlpha[$s+1], $newValue,1);
//            }
//            $filecontent =str_replace($oldValue,$newValue, $filecontent);
//            $filecontent =str_replace($oldValue,$newValue, $filecontent);
        $filecontent= $this->CUST_contract($unitno,$checkindate,$checkoutdate,$companyname,$customername,$noticeperiod,$passportno,$passportdate,$epno,$epdate,$noticedate,$lp,$cardno,$rent,$airquartfee,$airfixedfee,$electcap,$dryclean,$chkoutfee,$procfee,$deposit,$waived,$roomtype,$rent_check,$formname,$filecontent);
        file_put_contents("./application/models/Eilib/contractReplace.docx",$filecontent);
        $replacedData=file_get_contents("./application/models/Eilib/contractReplace.docx");
        $newfile=$this->insertFile($service, $title, $description, $parentId, $mimeType, $replacedData);
        echo $newfile->embedLink;
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
}
public function downloadFile($service, $file) {
    $downloadUrl = $file->getExportLinks()['text/plain'];//['application/vnd.openxmlformats-officedocument.wordprocessingml.document'];//$file->getDownloadUrl();
    if ($downloadUrl) {
        $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
        $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
        if ($httpRequest->getResponseHttpCode() == 200) {
            return $httpRequest->getResponseBody();
        } else {
            echo "errr";
            // An error occurred.
            return null;
        }
    } else {
        echo "empty";
        // The file doesn't have any content stored on Drive.
        return null;
    }}
public  function insertFile($service, $title, $description, $parentId, $mimeType, $filedata) {
    $file = new Google_Service_Drive_DriveFile();
    $file->setTitle($title);
    $file->setDescription($description);
    $file->setMimeType($mimeType);
    // Set the parent folder.
    if ($parentId != null) {
        $parent = new Google_Service_Drive_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));
    }
    try {
        $data =$filedata;//file_get_contents("model.txt");
        $createdFile = $service->files->insert($file, array(
            'data' => $data,
            'mimeType' =>'application/vnd.openxmlformats-officedocument.wordprocessingml.document',//$mimeType,
            'uploadType'=>'media'
        ));
        // Uncomment the following line to print the File ID
        print 'File ID: %s' % $createdFile->getId();
        return $createdFile;//$createdFile->getId();
    } catch (Exception $e) {
        print "An error occurred: " . $e->getMessage();
    }
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
//CUSTOMER CONTRACT DOCUMENT
public function CUST_contract($unitno,$checkindate,$checkoutdate,$companyname,$customername,$noticeperiod,$passportno,$passportdate,$epno,$epdate,$noticedate,$lp,$cardno,$rent,$airquartfee,$airfixedfee,$electcap,$dryclean,$chkoutfee,$procfee,$deposit,$waived,$roomtype,$rent_check,$formname,$filecontent)
{
//    $cust_config_array=[];
  $unitno="<b>".$unitno."</b>";
    $cust_config_array=$this->CUST_invoice_contractreplacetext();
    $contractidcode =$cust_config_array[10];
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
    $todaydat =date('d-m-Y');
    $dateStringCheckin=strtotime($checkindate);
 $check_in_dated_lastmonth = strtotime ("-1 month",$dateStringCheckin);
    $check_in_date= date("Y-m-d",$check_in_dated_lastmonth);
    $check_in_dated=date("d-m-Y",$check_in_dated_lastmonth);
    $datecheckedin = intval(date("d", $check_in_dated_lastmonth));
    $dateStringCheckOut=strtotime($checkindate);
    $check_out_dated_lastmonth = strtotime ("+1 month",$dateStringCheckOut);
    $check_out_date= date("Y-m-d",$check_out_dated_lastmonth);
    $cexdd=date("d-m-Y",$check_out_dated_lastmonth);
    $datecheckedin = intval(date("d", $check_out_dated_lastmonth));
    // to generate last date of a month
    //start
    $lastMonthString= strtotime ("+1 month",$check_in_dated_lastmonth);
    $LastMonth = date("Y-m-d",$lastMonthString);
    $LastMonthformat=date("d-m-Y",$lastMonthString);
    //end
    //  *************************************************************
    if( $noticedate!="")
    {            $dateStringNotice=strtotime($noticedate);
        $notice_lastmonth = strtotime ("-1 month",$dateStringNotice);
        $ntc_date1=date("d-m-Y",$notice_lastmonth);
        $noticeSt=$cust_config_array[11];
        $filecontent= str_replace('NOTICESTATEMENT ',$noticeSt, $filecontent);
    }
    else
    {
        $filecontent= str_replace('NOTICESTATEMENT '," ", $filecontent);
    }
    $webloginfetch1 ="10T1900";//$this->CUST_GetLogindtls($unitno);
    if ($webloginfetch1!=null)
    {
        strpos($webloginfetch1,"T1")==false?$indext1=-1:$indext1=strpos($webloginfetch1,"T1");
        strpos($webloginfetch1,"T2")==false?$indext2=-1:$indext2=strpos($webloginfetch1,"YT2ar");
    }
    if(($indext1>=0)||($indext2>=0))
    {
        if($indext1>=0)
        {
            $address1value=$cust_config_array[12];
            $filecontent= str_replace('UNITADDRESS ',$address1value, $filecontent);
        }
        else if($indext2>=0)
        {
            $address2value=$cust_config_array[13];
            $filecontent= str_replace('UNITADDRESS ',$address2value, $filecontent);
        }
    }
    else
    {
        $address3value=$cust_config_array[14];
        $filecontent= str_replace('UNITADDRESS ',$address3value, $filecontent);
    }
    if($waived != "")
    {
        $waived = "(WAIVED)";
        $filecontent= str_replace('Waived ',$waived, $filecontent);
    }
    else
    {
        $notwaived = " ";
        $filecontent= str_replace('Waived ',$notwaived, $filecontent);
    }
    if($cardno == "")
    {
        $filecontent= str_replace('ACES',"        ", $filecontent);
    }
    else
    {
        $filecontent= str_replace('ACES',"$cardno", $filecontent);
    }
    if($fixedaircon_fetch!=null)
    {
        $fixedstmtfetch=$cust_config_array[16];
        $fixedstmtfetch=str_replace("AIRFIXED",$fixedaircon_fetch,$fixedstmtfetch);
        $filecontent= str_replace('AIRCONSTATEMENT',"$fixedstmtfetch", $filecontent);
    }
    else if($quartaircon_fetch!=null)
    {
        $quartstmtfetch=$cust_config_array[15];
        $quartstmtfetch=str_replace("AIRQ",$quartaircon_fetch,$quartstmtfetch);
        $filecontent= str_replace('AIRCONSTATEMENT',$quartstmtfetch, $filecontent);
    }
    else
    {
        $filecontent= str_replace("AIRCONSTATEMENT","$00.00", $filecontent);
    }
    $finalep_pass = "";
    if(($epno =="") && ($passportno ==""))
    {
        $epno="";
        $passportno="";
        $finalep_pass ="";
        $noepcontlineno=$cust_config_array[19];
    }
    else if($epno =="")
    {
        $epno="";
        $finalep_pass ="PASSPORT NO: ".$passportno;
    }
    else if($passportno=="")
    {
        $passportno="";
        $finalep_pass ="EP NO: ".$epno;
    }
    if(($epno != "") && ($passportno !=""))
    {$finalep_pass = "EP NO: ".$epno;
    }
    if($passportdate=="")
    {
        $passportdate="";
    }
    if($epdate=="")
    {
        $epdate="";
    }
    if($noticeperiod==null)
    {
        $noticeperiod="";
    }
    if($passportdate!="")
    {
        $dateStringPassport=strtotime($passportdate);
        $passport_dated_lastmonth = strtotime ("-1 month",$dateStringPassport);
        $passportdate= date("d-m-Y",$passport_dated_lastmonth);
    }
    if($epdate!="")
    {
        $dateStringEP=strtotime($epdate);
        $EP_lastmonth = strtotime ("-1 month",$dateStringEP);
        $epdate= date("d/m/Y",$EP_lastmonth);
    }
    if($noticeperiod=="")
    {
        $filecontent= str_replace('"NOTI"',"", $filecontent);
    }
    else
    {
        $filecontent= str_replace('NOTI',$noticeperiod, $filecontent);
    }

    $filecontent=str_replace("nname",$customername,$filecontent);
  $filecontent   =str_replace("eepno",$epno,$filecontent); // EP number
       $filecontent =str_replace("expep",$epdate,$filecontent);  // EP expire date
      $filecontent  =str_replace("ppass",$passportno,$filecontent);  // passport number
      $filecontent  =str_replace("passda",$passportdate,$filecontent) ; // passport expire date
       $filecontent =str_replace("roomtype",$roomtype,$filecontent);  // room type
      $filecontent  =str_replace("unitno",$unitno,$filecontent);  // Unit Number
      $filecontent  =str_replace("checkin",$check_in_dated,$filecontent); // customer check in date
         $filecontent  =str_replace("checkout",$cexdd,$filecontent); // customer check out date
         $filecontent  =str_replace("prochkout",$LastMonthformat,$filecontent);
  $filecontent  =str_replace("RENTALAMOUNT",$RENTword,$filecontent);  // Rental amount in words
         $filecontent  =str_replace("RRENT",$rent,$filecontent) ; // rental amount in numbers
         $filecontent  =str_replace("cusss",$customername,$filecontent);  // name
         $filecontent  =str_replace("uunni",$unitno,$filecontent) ; // unit no
         $filecontent  =str_replace("ECP",$elec_fetch,$filecontent) ;  //Electricity capped
         $filecontent  =str_replace("PRWORD",$PROCESSword,$filecontent);  // processing cost in words
         $filecontent  =str_replace("PCO",$PROCESSno,$filecontent);  // processing cost in numbers
         $filecontent  =str_replace("DEPPOSI",$DEPOSITEword,$filecontent) ; // deposite amount in words
         $filecontent  =str_replace("DDEE",$DEPOSITno,$filecontent) ;  // deposite amount in numbers
         $filecontent  =str_replace("DRI",$dryclean_fetch,$filecontent); // dry clean amount
         $filecontent  =str_replace("NoticStDate",$ntc_date1,$filecontent);
  $filecontent  =str_replace("TDAYDATE",$todaydat,$filecontent); // today's date
         $filecontent  =str_replace("TYMPERIOD",$lp,$filecontent) ; // period between start date and end date
         $filecontent  =str_replace("epnoandpassno",$finalep_pass,$filecontent);
  $filecontent  =str_replace("CKCLE",$checkoutfee_fetch,$filecontent); // checkout cleaning fee
    $pro_lbl=$cust_config_array[17];//get prorated label
    $pro_rated_lineno=intval($cust_config_array[18]);//get prorated label line no
  $prlbl1  =str_replace("checkin",$check_in_dated,$pro_lbl) ;
  $prlbl2  =str_replace("prochkout",$LastMonthformat,$prlbl1) ;
  return $filecontent;
    //CHECK LESS THAN A MONTH OR GREATER THAN A MONTH
    $rent_check=$rent_check;
    strpos($lp,"Year")==false?$yearchk=-1:$yearchk=strpos($lp,"Year");
    strpos($lp,"Months")==false?$monthschk=-1:$monthschk=strpos($lp,"Months");
    strpos($lp,"Month")==false?$monthchk=-1:$monthchk=strpos($lp,"Month");
    strpos($lp,"Day")==false?$daychk=-1:$daychk=strpos($lp,"Day");
    if($formname=="EXTENSION")
    {
        if((($yearchk>0)||($monthschk>0)||(($monthchk>0)&&($daychk>0)))&&($rent_check=='true'))//greater than a month,prorated
        {
            $proratedrent=sMonthProratedCalc($check_in_date,$rent);
            if($proratedrent!=0)
            {
                $filecontent= str_replace('PRORATED','$'+$proratedrent, $filecontent);
                $filecontent= str_replace('prochkout',$LastMonthformat, $filecontent);
            }
            else
            {
//              $para1[$pro_rated_lineno].removeFromParent();
            }
        }
        else if((($yearchk>0)||($monthschk>0)||(($monthchk>0)&&($daychk>0)))&&($rent_check=='false'))//greater than a month,non prorated
        {
//          $para1[$pro_rated_lineno].removeFromParent();
        }
        else if(((($yearchk<0)&&($monthschk<0)&&($daychk>0)&&($monthchk<0))||(($yearchk<0)&&($monthschk<0)&&($daychk<0)&&($monthchk>0)))&&($rent_check=='true'))//less than a month,prorated
        {
            if((date("Y", $check_in_dated_lastmonth)==date("Y", $check_out_dated_lastmonth))&&(date("m", $check_in_dated_lastmonth)==date("m", $check_out_dated_lastmonth)))
            {
                $proratedrent=wMonthProratedCalc($check_in_date,$check_out_date,$rent);
                if($proratedrent!='0.00')
                {
                    $filecontent= str_replace("PRORATED",'$'.$proratedrent, $filecontent);
                    $filecontent= str_replace("prochkout",$cexdd, $filecontent);
                }
                else
                {
//                  $para1[$pro_rated_lineno].removeFromParent();
                }
            }
            else if((date("Y", $check_in_dated_lastmonth)==date("Y", $check_out_dated_lastmonth))||(date("m", $check_in_dated_lastmonth)==date("m", $check_out_dated_lastmonth)))
            {
                $proratedsmonth=sMonthProratedCalc($check_in_date,$rent);
                $proratedemonth=eMonthProratedCalc($check_out_date,$rent);
                $proratedrent=sprintf("%01.2f", (floatval($proratedsmonth)+floatval($proratedemonth)));
                if($proratedrent!='0.00')
                {
                    $filecontent= str_replace("PRORATED",'$'.$proratedrent, $filecontent);
                    $filecontent= str_replace("prochkout",$cexdd, $filecontent);
                }
                else
                {
//                  $para1[$pro_rated_lineno].removeFromParent();
                }
            }
        }
    }
    else
    {
        $prlbl1= str_replace("checkin",$check_in_dated, $pro_lbl);
        $prlbl2= str_replace("prochkout",$LastMonthformat, $prlbl1);
        //LESS THAN EQUAL TO A MONTH
        if(((($yearchk<0)&&($monthschk<0)&&($daychk>0)&&($monthchk<0))||(($yearchk<0)&&($monthschk<0)&&($daychk<0)&&($monthchk>0))))
        {
            if($rent_check=='false')
            {
//              $para1[$pro_rated_lineno].removeFromParent();
            }
        }
        //GREATER THAN A MONTH
        else
        {
            $proratedrent= sMonthProratedCalc($check_in_date,$rent);
            if($proratedrent!=0)
            if($proratedrent!=0)
            {
                if($rent_check=='true')
                {
                    $filecontent= str_replace("PRORATED",'$'.$proratedrent, $filecontent);
                }
                else if($rent_check=='false')
                {
//                  $para1[$pro_rated_lineno].removeFromParent();
                }
            }
            else
            {
//              $para1[$pro_rated_lineno].removeFromParent();
            }
        }
        return $filecontent;
    }
}
//FUNCTION TO CREATE INVOICE
public  function CUST_invoice($unit,$customername,$companyname,$invoiceid,$invoicesno,$invoicedate,$rent,$process,$deposit,$sdate,$edate,$roomtype,$Leaseperiod,$rentcheck,$docowner,$formname,$waived,$custid)
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
if(  $formname=="CREATION" ||   $formname=="RECHECKIN")
{
  if((  $yearchk>0)||(  $monthschk>0)||((  $monthchk>0)&&(  $daychk>0)))
  {
      if(  $rent_check=='false')
      {
          $proratedrentflag=1;
          $month_calculation=nonproratedmonthcalculation(  $check_in_date,  $check_out_date);
          $startdate_array=  $month_calculation[0];
          $enddate_array=  $month_calculation[1];
          $length=  count($startdate_array);
  }
      else
      {
          $proratedrentflag=2;
          $month_calculation=proratedmonthcalculation($check_in_date,$check_out_date);
          $startdate_array=$month_calculation[0];
    $enddate_array=$month_calculation[1];
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
      $month_calculation=proratedmonthcalculation( $check_in_date, $check_out_date);
      $startdate_array= $month_calculation[0];
      $enddate_array= $month_calculation[1];
      $length=count( $startdate_array);
}
  else if((( $yearchk>0)||( $monthschk>0)||(( $monthchk>0)&&( $daychk>0)))&&( $rent_check=='false'))//greater than a month-rent check false
  {
      $proratedrentflag=1;
      $month_calculation=nonproratedmonthcalculation( $check_in_date, $check_out_date);
      $startdate_array= $month_calculation[0];
      $enddate_array= $month_calculation[1];
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
      $proratedrent=wMonthProratedCalc($check_in_date,$check_out_date,$A5);
      $sum1 = $das+$pc+floatval($proratedrent);
      $sum = round($sum1, 2);//sprintf("%01.2f", $sum1);//$sum1.toFixed(2);
  }
         else if((date("Y", $check_in_dated_minus)!=date("Y", $check_out_dated_lastmonth)) &&(date("m", $check_in_dated_minus)!=date("m", $check_out_dated_lastmonth)))
  {
      $proratedsmonth=sMonthProratedCalc($check_in_date,$A5);
      $proratedemonth=eMonthProratedCalc($check_out_date,$A5);
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
  $fileContentsInvoice=file_get_contents("./application/models/Eilib/invoiceTemplate.docx");
$tableAppendRent='<table>';
  for($i=0; $i<$length; $i++){
      $tableAppendRent.='<tr><td>Rent customer'.$i.'start to customer'.$i.'end</td><td>rent'.$i.'amount</td><td></td></tr>';
}
  $tableAppendRent.='</table>';
  $fileContentsInvoice= str_replace("REPLACE",$tableAppendRent, $fileContentsInvoice);
  $reminingmonths=0;
  $fileContentsInvoice= str_replace("todayssll",($todaysDate+$Slno), $fileContentsInvoice);
//  // parseInt is used to convert string to integer
if($proratedrentflag==0)///rent check false Less than one month
{
  if($formname=="EXTENSION")
  {
      $fileContentsInvoice= str_replace("rent0amount",$proratedrent, $fileContentsInvoice);
      $fileContentsInvoice= str_replace("customer0start",$cdate1, $fileContentsInvoice);
      $fileContentsInvoice= str_replace("customer0end",$cdate2, $fileContentsInvoice);
      $fileContentsInvoice= str_replace("sum",$sum, $fileContentsInvoice);
}
  else
  {
      $fileContentsInvoice= str_replace("rent0amount",$A5, $fileContentsInvoice);
      $fileContentsInvoice= str_replace("customer0start",$cdate1, $fileContentsInvoice);
      $fileContentsInvoice= str_replace("customer0end",$cdate2, $fileContentsInvoice);

  $pcanddep=floatval($das)+floatval($pc)+floatval($A5);
      $fileContentsInvoice= str_replace("sum",$pcanddep, $fileContentsInvoice);
}
}
if($proratedrentflag==2)  /////////rent check true greater than month PRORATED
{
  $sumamount=$das+$pc;
  $reminingmonths=0;
  for($i=0;$i<$length;$i++)
{
    $startdate=$startdate_array[$i];
    $enddate=$enddate_array[$i];
  if(date("d", strtotime($startdate))!=1 && $i==0){$amount=$this->sMonthProratedCalc($check_in_date,$A5);}else{$amount=$A5;}
  if($i==$length-1)
  {
      $date = new DateTime();
      $date->setDate(date("Y", strtotime($enddate)),(intval(date("m", strtotime($enddate)))+1),date("d", strtotime($enddate)));
      $finaldate=$date->format('Y-m-d');
      if(date("d", strtotime($enddate))==date("d", strtotime($finaldate))-1)
      {$amount=$A5;}else{$amount=$this->eMonthProratedCalc($check_out_date,$A5);}
  }
    $checkdate1= date("Y-M-d",strtotime($startdate));
    $checkdate2= date("Y-M-d",strtotime($enddate));
    $fileContentsInvoice= str_replace("rent"+$i+"amount",$amount, $fileContentsInvoice);
    $fileContentsInvoice= str_replace("customer"+$i+"start",$checkdate1, $fileContentsInvoice);
    $fileContentsInvoice= str_replace("customer"+$i+"end",$checkdate2, $fileContentsInvoice);
  if($i==0)
  {
      $singlemonth= round(floatval($sumamount)+floatval($amount),2);
      $fileContentsInvoice= str_replace("singlemonth",$singlemonth, $fileContentsInvoice);

  }
  else
  {
      $reminingmonths=floatval($reminingmonths)+floatval($amount);
      $reminingmonths= round($reminingmonths,2);
  }
}
}
if($proratedrentflag==1)   ////NONPRORATED
{
  $sumamount=$das+$pc;
  $reminingmonths=0;
  for($i=0;$i<$length;$i++)
{
    $startdate=$startdate_array[$i];
    $enddate=$enddate_array[$i];
    $amount=$A5;
  if($i==$length-1)
  {
      if(date('Y',strtotime($startdate))==date('Y',strtotime($enddate)) &&date('m',strtotime($startdate))==date('m',strtotime($enddate)))
      {
         $amount=$this->wMonthProratedCalc($startdate,$enddate,$A5);
      }
      else if(date('Y',strtotime($startdate))!=date('Y',strtotime($enddate)) ||date('m',strtotime($startdate))!=date('m',strtotime($enddate)))
      {
          $proratedsmonth=$this->sMonthProratedCalc($startdate,$A5);
          $proratedemonth=$this->eMonthProratedCalc($enddate,$A5);
          $amount=round(floatval($proratedsmonth)+floatval($proratedemonth),2);
      }
  }
            $checkdate1= date("Y-M-d",strtotime($startdate));
  $checkdate2=date("Y-M-d",strtotime($enddate));
            $fileContentsInvoice= str_replace("rent".$i."amount",$amount, $fileContentsInvoice);
            $fileContentsInvoice= str_replace("customer".$i."start",$checkdate1, $fileContentsInvoice);
            $fileContentsInvoice= str_replace("customer".$i."end",$checkdate2, $fileContentsInvoice);
  $sum = round($sumamount,2);
  if($i==0)
  {
      $singlemonth= round(floatval($sumamount)+floatval($amount),2);
      $fileContentsInvoice= str_replace("singlemonth",$singlemonth, $fileContentsInvoice);
  }
  else
  {
      $reminingmonths= round(floatval($reminingmonths)+floatval($reminingmonths),2);

  }
}
}
if($company_fetch==" ")
{
  $fileContentsInvoice= str_replace("company/",$company_fetch, $fileContentsInvoice);

}
else
{
  $fileContentsInvoice= str_replace("company",$company_fetch, $fileContentsInvoice);

}
  $fileContentsInvoice= str_replace("name",$tenant_fetch, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("custid",$custid, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("Todaydate",$todaydat, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("customerdate",$todaydatestring, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("deposite",$A3, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("proces",$A4, $fileContentsInvoice);

  $fileContentsInvoice= str_replace("sum",$reminingmonths, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("roM",$roomtype, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("unit",$unit_fetch, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("checkin",$cdate1, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("CUST_NAME",$tenant_fetch, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("UNIT_NO",$unit, $fileContentsInvoice);
  $fileContentsInvoice= str_replace("final",$cdate2, $fileContentsInvoice);
       file_put_contents("./application/models/Eilib/testdoc1.docx",$fileContentsInvoice);
        $replacedData=file_get_contents("./application/models/Eilib/testdoc1.docx");
  return $replacedData;
}
} 