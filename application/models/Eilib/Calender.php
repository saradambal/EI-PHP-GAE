<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 13/5/15
 * Time: 10:25 AM
 */
class Calender  extends CI_Model {
    //TIME CONVERSION
    public function CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime){
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startdate.'T'.$startdate_starttime.'.000+08:00');
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($startdate.'T'.$startdate_endtime.'.000+08:00');
        return array($start,$end);
    }
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
        $refresh_token= $Refresh_Token;
        $drive->refreshToken($refresh_token);
        $cal = new Google_Service_Calendar($drive);
        return $cal;
    }
//FUNCTION TO GET CALENDAR ID
    function GetEICalendarId()
    {
        $this->db->select('CCN_DATA');
        $this->db->from('CUSTOMER_CONFIGURATION');
        $this->db->where('CGN_ID',75);
        $URSRC_select_calenderid=$this->db->get();
        foreach($URSRC_select_calenderid->result_array() as $row){
            $calendarId=$row["CCN_DATA"];
        }
        return $calendarId;
    }
//SAMPLE TESTING
    public function test($cal){
        $this->CUST_customercalendercreation($cal,10,"2015-09-14","10:00","10:30","2015-09-16","10:00","10:30","SARADA","MUNUSAMY","99999999","34324","TEST","SARADA@GMAIL.COM","0810","ROOM TYPE","ROOM TYPE");
//$event = new Google_Service_Calendar_Event();
//$start = new Google_Service_Calendar_EventDateTime();
//$start->setDateTime('2016-04-15T10:00:00.000-00:00');//setDate('2014-11-18');
//$event->setStart($start);
////       $event->setEnd($start);
//
//$end = new Google_Service_Calendar_EventDateTime();
//$end->setDateTime('2016-04-16T10:00:00.000-00:00');//2014-8-23T10:25:00.000+05:30
//$event->setEnd($end);
//try{
//   $createdEvent = $cal->events->insert('ssomens.com_i7h5a6b4dfee8afi84kkrqqmlc@group.calendar.google.com', $event);
//   $cal_flag=1;
//   return $createdEvent->getId();
//}
//catch(Exception $e){
//   $cal_flag=0;
//   return $e->getMessage();
//}
    }
//CALENDAR EVENT CREATION FOR STARHUB N UNIT FORM
    public  function  StarHubUnit_CreateCalEvent($cal,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$TypeOfExp,$unitno,$accountno,$starteventtype,$endeventtype,$eiornonei,$rent)
    {
        $calId=$this->GetEICalendarId();
        if($eiornonei=="X")
        {$eiornonei="EI";}
        else
        {$eiornonei="NON EI";}
        if($TypeOfExp=="STARHUB")
        {
            $calseventtitle=$TypeOfExp." ".$unitno." - ".$starteventtype;//title of start event
            $calseventdesc=$unitno." - ".$accountno." - ".$starteventtype;//description of start event
            $calseventloc=$unitno." - ".$accountno;//location of start event
        }
        else//UNIT
        {
            $calseventtitle=$unitno." - "."LEASE ".$starteventtype;//title of start event
            $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
            $calseventloc=$unitno." - ".$eiornonei;//location of start event
        }
        $event = new Google_Service_Calendar_Event();
        $startEndCal= $this->CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime);
        $event->setStart($startEndCal[0]);
        $event->setEnd($startEndCal[1]);
        $event->setDescription($calseventdesc);
        $event->setLocation($calseventloc);
        $event->setSummary($calseventtitle);
        $cal->events->insert($calId, $event);
        if($TypeOfExp=="STARHUB")
        {
            $calseventtitle=$TypeOfExp." ".$unitno." - ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$accountno." - ".$endeventtype;//description of start event
            $calseventloc=$unitno." - ".$accountno;//location of start event
        }
        else//UNIT
        {
            $calseventtitle=$unitno." - "."LEASE ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
            $calseventloc=$unitno." - ".$eiornonei;//location of start event
        }
        $startEndCal= $this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
        $event->setStart($startEndCal[0]);
        $event->setEnd($startEndCal[1]);
        $event->setDescription($calseventdesc);
        $event->setLocation($calseventloc);
        $event->setSummary($calseventtitle);
        $cal->events->insert($calId, $event);
    }
//UNIT AND STARHUB CALENDAR UPDATION
    public  function StarHubUnit_DeleteCalEvent($cal,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$TypeOfExp,$unitno,$accountno,$starteventtype,$endeventtype,$eiornonei,$rent
        ,$oldStartDate,$oldEndDate){
        $calId=$this->GetEICalendarId();
        //create start event
        $events = $cal->events->listEvents($calId);
        foreach ($events->getItems() as $event) {
            $summaryStarUnit= $event->getSummary();
            if(preg_match("/-/",(String)$summaryStarUnit)){
                $descriptionName=explode(' - ',$event->getSummary());
                $startDateCheck=explode('T',$event->getstart()->dateTime);
                $endDateCheck=explode('T',$event->getetart()->dateTime);
                if($event->getSummary()!='')
                    $checkStartEndDateFlag=$descriptionName[1];
                else
                    $checkStartEndDateFlag='';
                if($TypeOfExp=='UNIT'){
                    $checkStarUnit=$unitno;
                }
                else{
                    $checkStarUnit=$TypeOfExp.' '.$unitno;
                    $checkStartEndDateFlag=$descriptionName[1];
                }
                if( $descriptionName[0] === $checkStarUnit && $startDateCheck[0] == $oldStartDate && $starteventtype==$checkStartEndDateFlag){
                    $eventUpdate = $cal->events->get($calId, $event->getId());
                    $startEndCal=$this->CalenderTime_Convertion($startdate,$startdate_starttime,$startdate_endtime);
                    $eventUpdate->setStart($startEndCal[0]);
                    $eventUpdate->setEnd($startEndCal[1]);
                    $getDescLocTiltle=$this->getConcateOfDescLoc($TypeOfExp,$unitno,$starteventtype,$accountno,$eiornonei,$rent);
                    $eventUpdate->setDescription($getDescLocTiltle[1]);
                    $eventUpdate->setLocation($getDescLocTiltle[2]);
                    $eventUpdate->setSummary($getDescLocTiltle[0]);
                    $updatedEvent = $cal->events->update($calId, $eventUpdate->getId(), $eventUpdate);
                }
                if( $descriptionName[0] === $checkStarUnit && $endDateCheck[0] == $oldEndDate && $starteventtype==$checkStartEndDateFlag){
                    $eventUpdate = $cal->events->get($calId, $event->getId());
                    $startEndCal=$this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
                    $eventUpdate->setStart($startEndCal[0]);
                    $eventUpdate->setEnd($startEndCal[1]);
                    $getDescLocTiltle=$this->getConcateOfDescLoc($TypeOfExp,$unitno,$starteventtype,$accountno,$eiornonei,$rent);
                    $eventUpdate->setDescription($getDescLocTiltle[1]);
                    $eventUpdate->setLocation($getDescLocTiltle[2]);
                    $eventUpdate->setSummary($getDescLocTiltle[0]);
                    $updatedEvent = $cal->events->update($calId, $eventUpdate->getId(), $eventUpdate);
                }
            }
        }
    }
//COMMON FUNCTION FOR CONCATING THE STARHUB AND UNIT
    function getConcateOfDescLoc($TypeOfExp,$unitno,$endeventtype,$accountno,$eiornonei,$rent){
        if($TypeOfExp=="STARHUB")
        {
            $calseventtitle=$TypeOfExp." ".$unitno." - ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$accountno." - ".$endeventtype;//description of start event
            $calseventloc=$unitno." - ".$accountno;//location of start event
        }
        else//UNIT
        {
            $calseventtitle=$unitno." - "."LEASE ".$endeventtype;//title of start event
            $calseventdesc=$unitno." - ".$eiornonei." - "."RENT :".$rent;//description of start event
            $calseventloc=$unitno." - ".$eiornonei;//location of start event
        }
        return array($calseventtitle,$calseventdesc,$calseventloc);
    }
//FUNCTION TO CREATE CALENDAR EVENT FOR CUSTOMER
    public function  CUST_customercalendercreation($calPrimary,$custid,$startdate,$startdate_starttime,$startdate_endtime,$enddate,$enddate_starttime,$enddate_endtime,$firstname,$lastname,$mobile,$intmobile,$office,$customermailid,$unit,$roomtype,$unitrmtype)
    {
        $calId=$this->GetEICalendarId();
        $initialsdate=$startdate;
        $initialedate=$enddate;
        $calendername= $firstname.' '.$lastname;
        $contactno="";
        $contactaddr="";
        if($mobile!=null)
        {$contactno=$mobile;}
        else if($intmobile!=null)
        {$contactno=$intmobile;}
        else if($office!=null)
        {$contactno=$office;}
        if($contactno!=null && $contactno!="")
        {
            $contactaddr=$custid." "."EMAIL :".$customermailid.",CONTACT NO :".$contactno;
        }
        else
        {
            $contactaddr=$custid." "."EMAIL :".$customermailid;
        }
        if($unitrmtype!="")
        {
            $details =$unit. " " . $calendername . " " .$unitrmtype." ". "CHECKIN";
        }
        else
        {
            $details =$unit. " " . $calendername . " " . "CHECKIN";
        }
        $details1 =$unit. " " .$roomtype ;
        if($initialsdate!="")
        {
            $event = new Google_Service_Calendar_Event();
            $startevents=$this->CalenderTime_Convertion($startdate, $startdate_starttime, $startdate_endtime);
            $event->setStart($startevents[0]);
            $event->setEnd($startevents[1]);
            $event->setDescription($contactaddr);
            $event->setLocation($details1);
            $event->setSummary($details);
            $createdEvent = $calPrimary->events->insert($calId, $event); // to create a event
        }
        $endevents=$this->CalenderTime_Convertion($enddate,$enddate_starttime,$enddate_endtime);
        $detailsend =$unit. " " . $calendername . " " . "CHECKOUT";
        $detailsend1 =$unit. " " .$roomtype ;
        if($initialedate!="")
        {
            $event = new Google_Service_Calendar_Event();
            $event->setStart($endevents[0]);
            $event->setEnd($endevents[1]);
            $event->setDescription($contactaddr);
            $event->setLocation($detailsend1);
            $event->setSummary($detailsend);
            $createdEvent = $calPrimary->events->insert($calId, $event); // to create a event
        }
    }
//FUNCTION TO DELETE CALENDER EVENTS
    public function CUST_customercalenderdeletion($calPrimary,$custid,$startdate,$start_time_in,$start_time_out,$enddate,$end_time_in,$end_time_out,$formname)
    {
        $calId=$this->GetEICalendarId();
        if($formname=='UNCANCEL')
        {
            $eventsCheckOut = $calPrimary->events->listEvents($calId);

            foreach ($eventsCheckOut->getItems() as $event) {
                if((intval(explode(' ',$event->getDescription())[0])==$custid && $startdate==(explode('T',$event->getstart())[0])) || (intval(explode(' ',$event->getDescription())[0])==$custid && $enddate==(explode('T',$event->getend())[0]))){
                    $calPrimary->events->delete($calId, $event->getId());}
            }
        }
        else{
            $optDate= array('timeMax' => $startdate.'T'.$start_time_out.':00+08:00','timeMin' => $startdate.'T'.$start_time_in.':00+08:00');
            $eventsCheckOut = $calPrimary->events->listEvents($calId,$optDate);
            foreach ($eventsCheckOut->getItems() as $event) {
                if(intval(explode(' ',$event->getDescription())[0])==$custid ){
                    $calPrimary->events->delete($calId, $event->getId());}
            }
            $optDate= array('timeMax' => $enddate.'T'.$end_time_out.':00+08:00','timeMin' => $enddate.'T'.$end_time_in.':00+08:00');
            $eventsEnddate = $calPrimary->events->listEvents($calId,$optDate);
            foreach ($eventsEnddate->getItems() as $event) {
                if(intval(explode(' ',$event->getDescription())[0])==$custid ){
                    $calPrimary->events->delete($calId, $event->getId());}
            }
        }
    }
//FUNCTION TO DELETE CC CALENDER EVENTS
    public function CUST_CREATION_customercalenderdeletion($calPrimary,$customer_id,$calevent_array)
    {
        $calId=$this->GetEICalendarId();
        for($c=0;$c<count($calevent_array);$c++)
        {
            $eventdetails=$calevent_array[c];
            $optDate= array('timeMax' => $eventdetails[0].'T'.$eventdetails[1].':00+08:00','timeMin' => $eventdetails[0].'T'.$eventdetails[2].':00+08:00');
            $eventsCheckOut = $calPrimary->events->listEvents($calId,$optDate);
            foreach ($eventsCheckOut->getItems() as $event) {
                if(intval(explode(' ',$event->getDescription())[0])==$customer_id ){
                    $calPrimary->events->delete($calId, $event->getId());}
            }
        }
    }
//FUNCTION TO DELETE CALENDER EVENTS FOR CUSTOMER TERMINATION N EXTENSION
    public function CUST_customerTermcalenderdeletion($calPrimary,$custid,$startdate,$start_time_in,$start_time_out,$enddate,$end_time_in,$end_time_out,$formname)
    {
        $calId=$this->GetEICalendarId();
        $optDate= array('timeMax' => $startdate.'T'.$start_time_out.':00+08:00','timeMin' => $startdate.'T'.$start_time_in.':00+08:00');
        $events = $calPrimary->events->listEvents($calId,$optDate);
        foreach ($events->getItems() as $event) {
            $matchSummary=(String)$event->getSummary();
            if(intval(explode(' ',$event->getDescription())[0])==$custid && preg_match("/CHECKIN/",(String)$matchSummary)==1)
                $calPrimary->events->delete($calId, $event->getId());
        }
        //CHECKOUT DELETION
        $optDate= array('timeMax' => $enddate.'T'.$end_time_out.':00+08:00','timeMin' => $enddate.'T'.$end_time_in.':00+08:00');
        $eventsCheckOut = $calPrimary->events->listEvents($calId,$optDate);
        foreach ($eventsCheckOut->getItems() as $event) {
            $matchSummary=(String)$event->getSummary();
            if(intval(explode(' ',$event->getDescription())[0])==$custid && preg_match("/CHECKOUT/",(String)$matchSummary)==1){
                $calPrimary->events->delete($calId, $event->getId());}
        }
    }
    //FUNCTION TO DELETE EXISTING EVENT N CREATE CURRENT CALENDAR EVENT DTS FOR EXTENSION N TERMINATION
    public function CTermExtn_Calevent($calPrimary,$CTermExtn_custid,$CTermExtn_recver,$ctermformname,$successflag)
    {
        $CTermExtn_custfirstname="";$CTermExtn_custlastname="";
        $CTermExtn_calevntchk_flag=0;
        $CTermExtn_prevunitno=[];
        $CTermExtn_prevroomtype=[];
        $CTermExtn_caleventcount=0;
        $sql = "CALL SP_CUSTOMER_MIN_MAX_RV(".$CTermExtn_custid.",@MIN_LP,@MAX_LP)";
        $this->db->query($sql);
        $this->db->select('@MIN_LP AS MIN,@MAX_LP AS MAX', FALSE);
        $cterm_minlp = $this->db->get()->row()->MIN;


        if($ctermformname=="EXTENSION")
        {
            $this->db->select('CED_REC_VER');
            $this->db->from('VW_EXTENSION_CUSTOMER');
            $this->db->where('CUSTOMER_ID='.$CTermExtn_custid);
            $recObj = $this->db->get()->row();
            $CTermExtn_recver=$recObj->CED_REC_VER;
        }
        $i=0;
        $queryCustomer=$this->db->query("SELECT  C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,CTD.CLP_ENDDATE,CTD.CLP_PRETERMINATE_DATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CTermExtn_custid.")AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND CED.CED_REC_VER>=".$cterm_minlp." AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC");
        $result []=$queryCustomer->row_array();
        for ($s=0;$s<count($result);$s++)
        {
            $CTermExtn_caleventcount=$CTermExtn_caleventcount+1;
            $CTermExtn_gstcard= $result[$s]["CLP_GUEST_CARD"];
            if($CTermExtn_gstcard==null)
            {
                $CTermExtn_custfirstname=$result[$s]["CUSTOMER_FIRST_NAME"];
                $CTermExtn_custlastname=$result[$s]["CUSTOMER_LAST_NAME"];
                $CTermExtn_stdate=$result[$s]["CLP_STARTDATE"];
                $CTermExtn_stdate1=$result[$s]["CLP_STARTDATE"];//get time--date
                $CTermExtn_eddate=$result[$s]["CLP_ENDDATE"];
                $CTermExtn_eddate1=$result[$s]["CLP_ENDDATE"];//get time with date
                $CTermExtn_ptddate=$result[$s]["CLP_PRETERMINATE_DATE"];
                $CTermExtn_start_time_in=$result[$s]["CED_SD_STIME"];
                $CTermExtn_start_time_out=$result[$s]["CED_SD_ETIME"];
                $CTermExtn_end_time_in=$result[$s]["CED_ED_STIME"];
                $CTermExtn_end_time_out=$result[$s]["CED_ED_ETIME"];
                $CTermExtn_recversion=$result[$s]["CED_REC_VER"];
                $finalResult[]=array('sddate'=>$result[$s]['CLP_STARTDATE'],'sdtimein'=>$result[$s]['CED_SD_STIME'],'sdtimeout'=>$result[$s]['CED_SD_ETIME'],'eddate'=>$result[$s]['CLP_STARTDATE'],'edtimein'=>$result[$s]['CLP_STARTDATE'],'edtimeout'=>$result[$s]['CLP_STARTDATE']);
            }
            if( $CTermExtn_ptddate!=null)
            {
                $CTermExtn_ptddate1=$result[$s]["CLP_PRETERMINATE_DATE"];//.getTime();
            }
            else
            {
                $CTermExtn_ptddate1= $CTermExtn_eddate1;
            }
            if(( $CTermExtn_ptddate!=null&&( $ctermformname=="TERMINATION"&& $CTermExtn_recversion<= $CTermExtn_recver&& $successflag==1))){
            }
            if(( $CTermExtn_ptddate!=null&&( $ctermformname=="TERMINATION"&& $successflag==0))||( $CTermExtn_ptddate!=null&&( $ctermformname=="TERMINATION"&& $CTermExtn_recversion<= $CTermExtn_recver&& $successflag==1))||( $CTermExtn_ptddate!=null&& $ctermformname=="EXTENSION"))
            {
                $CTermExtn_eddate= $CTermExtn_ptddate;
            }
            //call cal event delete function from eilib
            CUST_customerTermcalenderdeletion($calPrimary,$CTermExtn_custid,$CTermExtn_stdate,$CTermExtn_start_time_in,$CTermExtn_start_time_out,$CTermExtn_eddate,$CTermExtn_end_time_in,$CTermExtn_end_time_out,"");
            $CTermExtn_custunittype="";
            $CTermExtn_mobile=$result[$s]["CPD_MOBILE"];
            $CTermExtn_intmoblie=$result[$s]["CPD_INTL_MOBILE"];
            $CTermExtn_office=$result[$s]["CCD_OFFICE_NO"];
            $CTermExtn_emailid=$result[$s]["CPD_EMAIL"];
            $CTermExtn_unitno=$result[$s]["UNIT_NO"];
            $CTermExtn_roomtype=$result[$s]["URTD_ROOM_TYPE"];
            $date1 = new DateTime("now");
            $date2 = new DateTime("tomorrow");
            var_dump($date1 == $date2);
            if(new DateTime($CTermExtn_ptddate1)>new DateTime($CTermExtn_stdate1))//new Date(Utilities.formatDate(new Date(CTermExtn_ptddate1),TimeZone, 'yyyy/MM/dd 00:00:00'))<=new Date(Utilities.formatDate(new Date(CTermExtn_eddate1),TimeZone, 'yyyy/MM/dd 00:00:00')))
            {
                $CTermExtn_prevunitno []=$result[$s]["UNIT_NO"];
                $CTermExtn_prevroomtype[]=$result[$s]["URTD_ROOM_TYPE"];
                if($CTermExtn_caleventcount>1)
                {
                    if($CTermExtn_unitno!=$CTermExtn_prevunitno[$i-1]&&$CTermExtn_prevunitno[$i-1]!="undefined")
                    {
                        $CTermExtn_custunittype="DIFF UNIT";
                    }
                    else
                    {
                        if($CTermExtn_roomtype!=$CTermExtn_prevroomtype[$i-1]&&$CTermExtn_prevroomtype[$i-1]!="undefined")
                        {
                            $CTermExtn_custunittype="DIFF RM";
                        }
                        else
                        {
                            $CTermExtn_stdate="";
                            $CTermExtn_start_time_in="";
                            $CTermExtn_start_time_out="";
                        }
                    }
                }
                if($CTermExtn_recversion==$CTermExtn_recver)
                {
                    CUST_customercalendercreation($calPrimary,$CTermExtn_custid,$CTermExtn_stdate,$CTermExtn_start_time_in,$CTermExtn_start_time_out,$CTermExtn_eddate,$CTermExtn_end_time_in,$CTermExtn_end_time_out,$CTermExtn_custfirstname,$CTermExtn_custlastname,$CTermExtn_mobile,$CTermExtn_intmoblie,$CTermExtn_office,$CTermExtn_emailid,$CTermExtn_unitno,$CTermExtn_roomtype,$CTermExtn_custunittype);
                    $CTermExtn_calevntchk_flag=1;
                }
                if($CTermExtn_calevntchk_flag==0)
                {
                    CUST_customercalendercreation($calPrimary,$CTermExtn_custid,$CTermExtn_stdate,$CTermExtn_start_time_in,$CTermExtn_start_time_out,"","","",$CTermExtn_custfirstname,$CTermExtn_custlastname,$CTermExtn_mobile,$CTermExtn_intmoblie,$CTermExtn_office,$CTermExtn_emailid,$CTermExtn_unitno,$CTermExtn_roomtype,$CTermExtn_custunittype);
                }
            }
            $i=$i+1;
        }

    }
    //FUNCTION TO GET EVENTS BEFORE UPDATE TABLE
    public function CTermExtn_GetCalevent($CTermExtn_custid)
    {
        $sql = "CALL SP_CUSTOMER_MIN_MAX_RV(".$CTermExtn_custid.",@MIN_LP,@MAX_LP)";
        $this->db->query($sql);
        $this->db->select('@MIN_LP AS MIN,@MAX_LP AS MAX', FALSE);
        $minLP = $this->db->get()->row()->MIN;
        $queryCustomer=$this->db->query("SELECT  C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CED.CED_REC_VER,CTD.CLP_GUEST_CARD,CTD.CLP_STARTDATE,IF(CTD.CLP_PRETERMINATE_DATE IS NULL,CTD.CLP_ENDDATE ,CTD.CLP_PRETERMINATE_DATE) AS ENDDATE,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CCD.CCD_OFFICE_NO,CPD.CPD_EMAIL,U.UNIT_NO,URTD.URTD_ROOM_TYPE,CTPA.CTP_DATA AS CED_SD_STIME, CTPB.CTP_DATA AS CED_SD_ETIME,CTPC.CTP_DATA AS CED_ED_STIME, CTPD.CTP_DATA AS CED_ED_ETIME FROM  CUSTOMER_ENTRY_DETAILS CED LEFT JOIN CUSTOMER_TIME_PROFILE CTPA ON CED.CED_SD_STIME = CTPA.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPB ON CED.CED_SD_ETIME = CTPB.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPC ON CED.CED_ED_STIME = CTPC.CTP_ID LEFT JOIN CUSTOMER_TIME_PROFILE CTPD ON CED.CED_ED_ETIME = CTPD.CTP_ID LEFT JOIN CUSTOMER_COMPANY_DETAILS CCD ON CED.CUSTOMER_ID=CCD.CUSTOMER_ID LEFT JOIN  CUSTOMER_PERSONAL_DETAILS CPD ON CED.CUSTOMER_ID=CPD.CUSTOMER_ID,CUSTOMER_LP_DETAILS CTD,UNIT_ROOM_TYPE_DETAILS URTD, UNIT_ACCESS_STAMP_DETAILS UASD ,UNIT U,CUSTOMER C WHERE  CED.UNIT_ID=U.UNIT_ID AND (CED.CUSTOMER_ID=".$CTermExtn_custid.")AND (CTD.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CED.CED_REC_VER=CTD.CED_REC_VER) AND (CTD.CLP_GUEST_CARD IS NULL) AND CED.CED_CANCEL_DATE IS  NULL AND(UASD.UASD_ID=CED.UASD_ID) AND(UASD.URTD_ID=URTD.URTD_ID)  AND (C.CUSTOMER_ID=CED.CUSTOMER_ID) AND (CTD.CUSTOMER_ID=C.CUSTOMER_ID) AND CED.CED_REC_VER>=".$minLP." AND CTD.CLP_GUEST_CARD IS NULL ORDER BY CED.CED_REC_VER, CTD.CLP_GUEST_CARD ASC");
        $result []=$queryCustomer->row_array();
        for ($s=0;$s<count($result);$s++)
        {
            $finalResult[]=array('sddate'=>$result[$s]['CLP_STARTDATE'],'sdtimein'=>$result[$s]['CED_SD_STIME'],'sdtimeout'=>$result[$s]['CED_SD_ETIME'],'eddate'=>$result[$s]['CLP_STARTDATE'],'edtimein'=>$result[$s]['CLP_STARTDATE'],'edtimeout'=>$result[$s]['CLP_STARTDATE']);
        }
        return $finalResult;
    }
}