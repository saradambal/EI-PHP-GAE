<?php
error_reporting(0);
class Customercreation extends CI_Model
{
        public function Customer_Creation_Save($UserStamp,$Leaseperiod,$Quoters,$service)
        {
            $FirstName=$_POST['CCRE_FirstName'];
            $Lastname=$_POST['CCRE_LastName'];
            $CompanyName=$_POST['CCRE_CompanyName'];
            $CompanyAddress=$_POST['CCRE_CompanyAddress'];
            $CompanyPostalCode=$_POST['CCRE_CompanyPostalCode'];
            $Emailid=$_POST['CCRE_Emailid'];
            $Mobile=$_POST['CCRE_Mobile'];
            $IntlMobile=$_POST['CCRE_IntlMobile'];
            $Officeno=$_POST['CCRE_Officeno'];
            $DOB=$_POST['CCRE_DOB'];
            $Nationality=$_POST['CCRE_Nationality'];
            $PassportNo=$_POST['CCRE_PassportNo'];
            $PassportDate=$_POST['CCRE_PassportDate'];
            $EpNo=$_POST['CCRE_EpNo'];
            $EPDate=$_POST['CCRE_EPDate'];
            $Uint=$_POST['CCRE_UnitNo'];
            $RoomType=$_POST['CCRE_RoomType'];
            $Startdate=$_POST['CCRE_Startdate'];
            $S_starttime=$_POST['CCRE_SDStarttime'];
            $S_endtime=$_POST['CCRE_SDEndtime'];
            $Enddate=$_POST['CCRE_Enddate'];
            $E_starttime=$_POST['CCRE_EDStarttime'];
            $E_endtime=$_POST['CCRE_EDEndtime'];
            $NoticePeriod=$_POST['CCRE_NoticePeriod'];
            $NoticePeriodDate=$_POST['CCRE_NoticePeriodDate'];
            $Quaterlyfee=$_POST['CCRE_Quaterlyfee'];
            $Fixedaircon_fee=$_POST['CCRE_Fixedaircon_fee'];
            $ElectricitycapFee=$_POST['CCRE_ElectricitycapFee'];
            $Curtain_DrycleanFee=$_POST['CCRE_Curtain_DrycleanFee'];
            $CheckOutCleanFee=$_POST['CCRE_CheckOutCleanFee'];
            $DepositFee=$_POST['CCRE_DepositFee'];
            $Rent=$_POST['CCRE_Rent'];
            $ProcessingFee=$_POST['CCRE_ProcessingFee'];
            $Comments=$this->db->escape_like_str($_POST['CCRE_Comments']);
            $CardArray=$_POST['temptex'];
            $Option=$_POST['AccessCard'];
            $waived=$_POST['CCRE_process_waived'];
            if($waived=='on'){$processwaived='X';}else{$processwaived='';}
            $prorated=$_POST['CCRE_Rent_Prorated'];
            if($prorated=='on'){$Prorated='X';}else{$Prorated='';}
            $Name=$FirstName.' '.$Lastname;
            if($Option=='Cardnumber')
            {
                $cardlist='';
                for($i=0;$i<count($CardArray);$i++)
                {
                    if($CardArray[$i]!='')
                    {
                        if($cardlist=='')
                        {
                            $cardlist=$CardArray[$i];
                        }
                        else{
                            $cardlist=$cardlist.','.$CardArray[$i];
                        }
                    }
                }
             $cardnames=explode(',',$cardlist);
             $counting=count($cardnames);
             $cardno='';
             $accesscard='';
             for($k=0;$k<$counting;$k++)
             {
               $cardnamessplit=explode('/',$cardnames[$k]);
                if($cardnamessplit[1]==$Name)
                 {
                     if($accesscard=='')
                     {
                         $accesscard=$cardnamessplit[0].', ';
                         $cardno=$cardnamessplit[0];

                     }
                     else
                     {
                         $accesscard=$accesscard.','.$cardnamessplit[0].', ';
                         $cardno=$cardno.','.$cardnamessplit[0];
                     }
                 }
                 else
                 {
                     if($accesscard=='')
                     {
                         $accesscard=$cardnamessplit[0].',X';
                         $cardno=$cardnamessplit[0];
                     }
                     else
                     {
                         $accesscard=$accesscard.','.$cardnamessplit[0].',X';
                         $cardno=$cardno.','.$cardnamessplit[0];
                     }
                 }
             }
            }
            else
            {
                $cardno='';
                $accesscard='';
            }
            $CCRE_quators=$Quoters;
            $StartDate=date('Y-m-d',strtotime($Startdate));
            $EndDate=date('Y-m-d',strtotime($Enddate));
            $CallQuery="CALL SP_CUSTOMER_CREATION_INSERT('$FirstName','$Lastname','$CompanyName','$CompanyAddress','$CompanyPostalCode','$Officeno',$Uint,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime','$Leaseperiod',$CCRE_quators,'$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate',$Rent,'$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee','$cardno','$StartDate','$UserStamp','$StartDate','$EndDate','$accesscard','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments',@CUSTOMER_CREATION_TEMPTBLNAME,@CUSTOMER_SUCCESSFLAG)";
            $this->db->query($CallQuery);
            $outparm_query = 'SELECT @CUSTOMER_CREATION_TEMPTBLNAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $temptable=$outparm_result->row()->TEMP_TABLE;
            $this->db->query('DROP TABLE IF EXISTS '.$temptable);
            $Confirm_query = 'SELECT @CUSTOMER_SUCCESSFLAG AS CONFIRM';
            $Confirm_result = $this->db->query($Confirm_query);
            $Confirm_Meessage=$Confirm_result->row()->CONFIRM;
            $Customerid_query = 'SELECT CUSTOMER_ID FROM CUSTOMER ORDER BY CUSTOMER_ID DESC LIMIT 1';
            $Customer_result = $this->db->query($Customerid_query);
            $Customerid=$Customer_result->row()->CUSTOMER_ID;
            $filetempname=$_FILES['CC_fileupload']['tmp_name'];
            $filename=$_FILES['CC_fileupload']['name'];
            $filename=$Uint.'-'.$Customerid.'-'.$FirstName.' '.$Lastname;
            $mimetype='application/pdf';
            $file_id_value =$this->insertFile($service,$filename,'PersonalDetails','0B1AhtyM5U79zREp5QkpiYmphODg',$mimetype,$filetempname);
            if($Confirm_Meessage)
            {
               $return_data=array($Confirm_Meessage,$Customerid,$StartDate,$S_starttime,$S_endtime,$EndDate,$E_starttime,$E_endtime,$FirstName,$Lastname,$Mobile,$IntlMobile,$Officeno,$Emailid,$Uint,$RoomType);
               return $return_data;
            }
            else
            {
               return $Confirm_Meessage;
            }
        }
   public function insertFile($service, $title, $description, $parentId,$mimeType,$uploadfilename)
    {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType($mimeType);
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try
        {
            $data =file_get_contents($uploadfilename);
            $createdFile = $service->files->insert($file, array(
                'data' => $data,
                'mimeType' => 'application/pdf',
                'uploadType' => 'media',
            ));
            $fileid = $createdFile->getId();
       }
        catch (Exception $e)
        {
            $file_flag=0;

        }
        return $fileid;

    }

    public function getRecheckinCustomer($unit)
        {
            $this->db->select("CUSTOMER_ID,CUSTOMERNAME,CED_REC_VER");
            $this->db->order_by("CUSTOMERNAME", "ASC");
            $this->db->from('VW_RECHECKIN_CUSTOMER');
            $this->db->where("UNIT_NO=".$unit);
            $this->db->distinct();
            $query = $this->db->get();
            return $query->result();
        }
        public function getRecheckinCustomer_PersonalDetails($customerid,$Recver)
        {
            $CRCHK_detailsquery='SELECT C.CUSTOMER_FIRST_NAME,C.CUSTOMER_LAST_NAME,CCD.CCD_COMPANY_NAME,CCD.CCD_COMPANY_ADDR,CCD.CCD_POSTAL_CODE,CCD.CCD_OFFICE_NO,CPD.CPD_MOBILE,CPD.CPD_INTL_MOBILE,CPD.CPD_PASSPORT_NO,DATE_FORMAT(CPD.CPD_PASSPORT_DATE,"%d-%m-%Y") AS CPD_PASSPORT_DATE,DATE_FORMAT(CPD.CPD_DOB,"%d-%m-%Y") AS CPD_DOB,CPD.CPD_EMAIL,NC.NC_DATA,C.CUSTOMER_ID,CPD.CPD_COMMENTS,CPD.CPD_EP_NO,DATE_FORMAT(CPD.CPD_EP_DATE,"%d-%m-%Y") AS CPD_EP_DATE from CUSTOMER_ENTRY_DETAILS CED left join CUSTOMER_COMPANY_DETAILS CCD on CED.CUSTOMER_ID=CCD.CUSTOMER_ID left join CUSTOMER C on CED.CUSTOMER_ID=C.CUSTOMER_ID left join CUSTOMER_PERSONAL_DETAILS CPD on CED.CUSTOMER_ID=CPD.CUSTOMER_ID ,NATIONALITY_CONFIGURATION NC where (C.CUSTOMER_ID='.$customerid.') AND (CPD.NC_ID=NC.NC_ID) AND CED.CED_REC_VER='.$Recver;
            $resultset=$this->db->query($CRCHK_detailsquery);
            return $resultset->result();
        }
        public function getRecheckin_Enddates($customerid,$Recver)
        {
            $CRCHK_Enddatequery='SELECT CLP_ENDDATE,CLP_PRETERMINATE_DATE FROM CUSTOMER_LP_DETAILS WHERE CUSTOMER_ID='.$customerid.' AND CED_REC_VER='.$Recver.' AND CLP_GUEST_CARD IS NULL';
            $resultset=$this->db->query($CRCHK_Enddatequery);
            return $resultset->result();
        }
        public function Customer_Recheckin_Save($UserStamp,$Leaseperiod)
        {
            $Customerid=$_POST['CCRE_CustomerId'];
            $FirstName=$_POST['CCRE_FirstName'];
            $Lastname=$_POST['CCRE_LastName'];
            $CompanyName=$_POST['CCRE_CompanyName'];
            $CompanyAddress=$_POST['CCRE_CompanyAddress'];
            $CompanyPostalCode=$_POST['CCRE_CompanyPostalCode'];
            $Emailid=$_POST['CCRE_Emailid'];
            $Mobile=$_POST['CCRE_Mobile'];
            $IntlMobile=$_POST['CCRE_IntlMobile'];
            $Officeno=$_POST['CCRE_Officeno'];
            $DOB=$_POST['CCRE_DOB'];
            $Nationality=$_POST['CCRE_Nationality'];
            $PassportNo=$_POST['CCRE_PassportNo'];
            $PassportDate=$_POST['CCRE_PassportDate'];
            $EpNo=$_POST['CCRE_EpNo'];
            $EPDate=$_POST['CCRE_EPDate'];
            $Uint=$_POST['CCRE_UnitNo'];
            $RoomType=$_POST['CCRE_RoomType'];
            $Startdate=$_POST['CCRE_Startdate'];
            $S_starttime=$_POST['CCRE_SDStarttime'];
            $S_endtime=$_POST['CCRE_SDEndtime'];
            $Enddate=$_POST['CCRE_Enddate'];
            $E_starttime=$_POST['CCRE_EDStarttime'];
            $E_endtime=$_POST['CCRE_EDEndtime'];
            $NoticePeriod=$_POST['CCRE_NoticePeriod'];
            $NoticePeriodDate=$_POST['CCRE_NoticePeriodDate'];
            $Quaterlyfee=$_POST['CCRE_Quaterlyfee'];
            $Fixedaircon_fee=$_POST['CCRE_Fixedaircon_fee'];
            $ElectricitycapFee=$_POST['CCRE_ElectricitycapFee'];
            $Curtain_DrycleanFee=$_POST['CCRE_Curtain_DrycleanFee'];
            $CheckOutCleanFee=$_POST['CCRE_CheckOutCleanFee'];
            $DepositFee=$_POST['CCRE_DepositFee'];
            $Rent=$_POST['CCRE_Rent'];
            $ProcessingFee=$_POST['CCRE_ProcessingFee'];
            $Comments=$this->db->escape_like_str($_POST['CCRE_Comments']);
            $CardArray=$_POST['temptex'];
            $Option=$_POST['AccessCard'];
            $waived=$_POST['CCRE_process_waived'];
            if($waived=='on'){$processwaived='X';}else{$processwaived='';}
            $prorated=$_POST['CCRE_Rent_Prorated'];
            if($prorated=='on'){$Prorated='X';}else{$Prorated='';}
            $Name=$FirstName.' '.$Lastname;
            if($Option=='Cardnumber')
            {
                $cardlist='';
                for($i=0;$i<count($CardArray);$i++)
                {
                    if($CardArray[$i]!='')
                    {
                        if($cardlist=='')
                        {
                            $cardlist=$CardArray[$i];
                        }
                        else{
                            $cardlist=$cardlist.','.$CardArray[$i];
                        }
                    }
                }
                $cardnames=explode(',',$cardlist);
                $counting=count($cardnames);
                $cardno='';
                $accesscard='';
                for($k=0;$k<$counting;$k++)
                {
                    $cardnamessplit=explode('/',$cardnames[$k]);
                    if($cardnamessplit[1]==$Name)
                    {
                        if($accesscard=='')
                        {
                            $accesscard=$cardnamessplit[0].', ';
                            $cardno=$cardnamessplit[0];

                        }
                        else
                        {
                            $accesscard=$accesscard.','.$cardnamessplit[0].', ';
                            $cardno=$cardno.','.$cardnamessplit[0];
                        }
                    }
                    else
                    {
                        if($accesscard=='')
                        {
                            $accesscard=$cardnamessplit[0].',X';
                            $cardno=$cardnamessplit[0];
                        }
                        else
                        {
                            $accesscard=$accesscard.','.$cardnamessplit[0].',X';
                            $cardno=$cardno.','.$cardnamessplit[0];
                        }
                    }
                }
            }
            else
            {
                $cardno='';
                $accesscard='';
            }
            $CCRE_quators="1";
            $StartDate=date('Y-m-d',strtotime($Startdate));
            $EndDate=date('Y-m-d',strtotime($Enddate));
            $CallQuery="CALL SP_CUSTOMER_RECHECKIN_INSERT('$Customerid','$FirstName','$Lastname','$CompanyName','$CompanyAddress','$CompanyPostalCode','$Officeno',$Uint,'$RoomType','$S_starttime','$S_endtime','$E_starttime','$E_endtime','$Leaseperiod',$CCRE_quators,'$processwaived','$Prorated','$NoticePeriod','$NoticePeriodDate',$Rent,'$DepositFee','$ProcessingFee','$Fixedaircon_fee','$Quaterlyfee','$ElectricitycapFee','$CheckOutCleanFee','$Curtain_DrycleanFee','$cardno','$StartDate','$UserStamp','$StartDate','$EndDate','$accesscard','$Nationality','$Mobile','$IntlMobile','$Emailid','$PassportNo','$PassportDate','$DOB','$EpNo','$EPDate','$Comments',@CUSTOMER_RECHECKIN_TEMPTBLNAME,@CUSTOMER_RECHECKIN_FLAG)";
            $this->db->query($CallQuery);
            $outparm_query = 'SELECT @CUSTOMER_RECHECKIN_TEMPTBLNAME AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $temptable=$outparm_result->row()->TEMP_TABLE;
            $this->db->query('DROP TABLE IF EXISTS '.$temptable);
            $Confirm_query = 'SELECT @CUSTOMER_RECHECKIN_FLAG AS CONFIRM';
            $Confirm_result = $this->db->query($Confirm_query);
            $Confirm_Meessage=$Confirm_result->row()->CONFIRM;
            if($Confirm_Meessage)
            {
                $return_data=array($Confirm_Meessage,$Customerid,$StartDate,$S_starttime,$S_endtime,$EndDate,$E_starttime,$E_endtime,$FirstName,$Lastname,$Mobile,$IntlMobile,$Officeno,$Emailid,$Uint,$RoomType);
                return $return_data;
            }
            else
            {
                return $Confirm_Meessage;
            }
//            $this->db->query('COMMIT');
        }
   }