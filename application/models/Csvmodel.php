<?php
error_reporting(0);
class Csvmodel extends CI_Model {
    public function getCSVfileRecords($service)
    {
        $this->db->select("PCN_DATA");
        $this->db->from('PAYMENT_CONFIGURATION');
        $this->db->where('CGN_ID=49');
        $query = $this->db->get()->row()->PCN_DATA;
        $children1 = $service->children->listChildren($query);
        $filearray1=$children1->getItems();
        foreach ($filearray1 as $child1)
        {
            $fileid=$service->files->get($child1->getId())->id;
            $filename=$service->files->get($child1->getId())->title;
            if($filename=='201504.CSV')
            {
                $data = $service->files->get($fileid);
                $url=$data->downloadUrl;
                $data=$this->downloadFile($service,$url);
                $data = array_map("str_getcsv", preg_split('/\r*\n+|\r+/', $data));
                break;
            }
            else
            {
              $flag="NoFile";
              return $flag;
            }
        }
        $monthname=explode('.',$filename);
        $year=substr($monthname[0],0,4);
        $month=substr($monthname[0],4,2);
        $selectedmonthcsv=$monthname[0].'%';
        /************************OCBC TABLE RECORDS************************************/
        $updatedrecordquery="SELECT OBR_TRANSACTION_DESC_DETAILS,OBR_CLIENT_REFERENCE,OBR_REF_ID,OBR_BANK_REFERENCE,OBR_POST_DATE FROM OCBC_BANK_RECORDS WHERE OBR_REF_ID LIKE '201504%' ORDER BY OBR_REF_ID ASC";
        $resultset=$this->db->query($updatedrecordquery);
        $CSV_DB_Records=array();
        $AfterDBRecords=array();
        foreach ($resultset-> result_array() as $val)
        {
            $postdate = str_replace(str_split('-'), '', $val['OBR_POST_DATE']);
            $csvrow_Refid=$val['OBR_REF_ID'].'!~'.$postdate.'_'.$val['OBR_CLIENT_REFERENCE'].'_'.$val['OBR_TRANSACTION_DESC_DETAILS'].'_'.$val['OBR_BANK_REFERENCE'];
            $csvnewrowfindkey=$postdate.'_'.$val['OBR_CLIENT_REFERENCE'].'_'.$val['OBR_TRANSACTION_DESC_DETAILS'].'_'.$val['OBR_BANK_REFERENCE'];
            array_push($CSV_DB_Records,$csvrow_Refid);
            array_push($AfterDBRecords,$csvnewrowfindkey);
        }
        $DBcount=count($CSV_DB_Records);
//        return $DBcount;
        /************************END OF OCBC TABLE RECORDS************************************/
        /************************CSV FILE RECORDS***************************************/
        $CSV_File_comparisionRecords=array();
        $CSV_Files_Records=array();
        for($h=0;$h<count($data);$h++)
        {
            $CSV_array = $data[$h];
            if ($CSV_array != '' && $CSV_array != null && $CSV_array[11]!='')
            {
                $csv_compdate= $CSV_array[11].'_'.$CSV_array[16].'_'.$CSV_array[17].'_'.$CSV_array[18];
                array_push($CSV_File_comparisionRecords,$csv_compdate);
                $csvRecordsobj=$CSV_array[0].','.$CSV_array[1].','.$CSV_array[2].','.$CSV_array[3].','.$CSV_array[4].','.$CSV_array[5].','.$CSV_array[6].','.$CSV_array[7].','.$CSV_array[8].','.$CSV_array[9].','.$CSV_array[10].','.$CSV_array[11].','.$CSV_array[12].','.$CSV_array[13].','.$CSV_array[14].','.$CSV_array[15].','.$CSV_array[16].','.$CSV_array[17].','.$CSV_array[18].','.$CSV_array[19];
                array_push($CSV_Files_Records,$csvRecordsobj);
            }
        }
        $CSVcount=count($CSV_File_comparisionRecords);
        /***************************END OF CSV FILE RECORDS***************************************/
        /****************************ARRAY COMPARISION ******************************************/
        $REF_id=array();
        $CSV_Old_Records=array();
        for($i=0;$i<count($CSV_DB_Records);$i++)
        {
              $splitrefid=explode('!~',$CSV_DB_Records[$i]);
              array_push($REF_id,$splitrefid[1]);
            for($j=0;$j<count($CSV_File_comparisionRecords);$j++)
            {
                if($splitrefid[1]==$CSV_File_comparisionRecords[$j])
                {
                    $Refidconcat=$splitrefid[0].','.$CSV_Files_Records[$j];
                    array_push($CSV_Old_Records,$Refidconcat);
                }
            }
        }
        $Old_rcordsCount=count($CSV_Old_Records);
        $updationdata=array();
        if($Old_rcordsCount==$DBcount)
        {
            for($k=0;$k<count($CSV_Old_Records);$k++)
              {
                  $UpdateRecordsplit=explode(',',$CSV_Old_Records[$k]);
                  $valuedate=$this->DateConversion($UpdateRecordsplit[13]);
                  $oldrecordupdatequery="UPDATE OCBC_BANK_RECORDS SET OBR_VALUE_DATE='$valuedate',OBR_LAST_BALANCE='$UpdateRecordsplit[6]',OBR_NO_OF_CREDITS='$UpdateRecordsplit[7]',OBR_NO_OF_DEBITS='$UpdateRecordsplit[9]',OBR_OLD_BALANCE='$UpdateRecordsplit[10]',OBR_CLOSING_BALANCE='$UpdateRecordsplit[5]',OBR_D_AMOUNT='$UpdateRecordsplit[11]' WHERE OBR_REF_ID='$UpdateRecordsplit[0]'";
                  $this->db->query($oldrecordupdatequery);
                  array_push($updationdata,$oldrecordupdatequery);
              }
                $c=0;
              $newcsvfilerecords=array();
              $oldcsvcount=$DBcount+1;
              for($h=0;$h<count($CSV_Files_Records);$h++)
               {
                 $array2=explode(',',$CSV_Files_Records[$h]);
                 $reference_id=$monthname[0].''.$oldcsvcount;
                 $clientrefe=$array2[16];
                 if($clientrefe=='000000000001')
                 {
                  $clientrefe=1;
                 }
                 $CSV_newRecord=$array2[11].'_'.$clientrefe.'_'.$array2[17].'_'.$array2[18];
                 if(!in_array($CSV_newRecord,$AfterDBRecords))
                    {
                     $csvRecordsobject=$reference_id.'!~'.$array2[0].'!~'.$array2[1].'!~'.$array2[2].'!~'.$array2[3].'!~'.$array2[4].'!~'.$array2[5].'!~'.$array2[6].'!~'.$array2[7].'!~'.$array2[8].'!~'.$array2[9].'!~'.$array2[10].'!~'.$array2[11].'!~'.$array2[12].'!~'.$array2[13].'!~'.$array2[14].'!~'.$array2[15].'!~'.$clientrefe.'!~'.$array2[17].'!~'.$array2[18].'!~'.$array2[19];
                     array_push($newcsvfilerecords,$csvRecordsobject);
                     $oldcsvcount++;
                    }
                  $c++;
               }
        }
        else
        {

        }
        if(count($newcsvfilerecords)!=0)
        {
            $csvlength=1;
            $date_array=array();
            $Ref_array=array();
            $debit_array=array();
            $credit_array=array();
            $mailrecord_array=array();
            $newdatearray=array();
            $creditcount=0;
            $debitcount=0;
            $timestamp=array();
            $csv_timstamp=date("Y-m-d H:i:s");;
            for($csv=0;$csv<count($newcsvfilerecords);$csv++)
            {
                $mailflag=1;
                $CSV_array=explode('!~',$newcsvfilerecords[$csv]);
                $transdate=$this->DateConversion($CSV_array[8]);
                $postdate=$this->DateConversion($CSV_array[12]);
                $valuedate=$this->DateConversion($CSV_array[13]);
                $refid=$CSV_array[0];
                $debitamt=$CSV_array[14];
                if($debitamt!="0.00" && $debitamt!=0 && $debitamt!=" " && $debitamt!="")
                {
                    $debitcount++;
                }
                array_push($debit_array,$debitamt);
                $creditamt=$CSV_array[15];
                if($creditamt!="0.00" && $creditamt!=0 && $creditamt!=" " && $creditamt!="")
                {
                    $creditcount++;
                }
                array_push($credit_array,$creditamt);
                $concat=$CSV_array[17].'-'.$CSV_array[18].'-'.$CSV_array[19];
                $csvmailrecord=$value_date.',,'.$debitamt.',,'.$creditamt.',,'.$concat;
                array_push($mailrecord_array,$csvmailrecord);
                array_push($Ref_array,$concat);
                array_push($newdatearray,$CSV_array[13]);
                $creditamt=$creditamt;
                $debitamt=$debitamt;
                $bankreff=$CSV_array[17];
                if($bankreff=='000000000001')
                {
                    $bankreff=1;
                }
                if($bankreff!="" && $bankreff!=1)
                {
                    $bankreff=$this->db->escape_like_str($bankreff);
                }
                $transaction_details=$CSV_array[18];
                if($transaction_details!="")
                {
                    $transaction_details=$this->db->escape_like_str($transaction_details);
                }
                $bankreference=$CSV_array[19];
                if($bankreference!="")
                {
                    $bankreference=$this->db->escape_like_str($bankreference);
                }
                if($creditamt==" " || $creditamt=="")
                {
                    $creditamt=null;
                }
                if($debitamt==" " || $debitamt=="")
                {
                    $debitamt=null;
                }
                if($CSV_array[10]=="" || $CSV_array[10]==" ")
                {
                    $csv_oldbal=0;
                }
                else
                {
                    $csv_oldbal=$CSV_array[10];
                }
                $OCBC_CSV_insertquery="INSERT INTO OCBC_BANK_RECORDS(OBR_ACCOUNT_NUMBER,OBR_CURRENCY,OBR_PREVIOUS_BALANCE,OBR_OPENING_BALANCE,OBR_CLOSING_BALANCE,OBR_LAST_BALANCE,OBR_NO_OF_CREDITS,OBR_TRANS_DATE,OBR_NO_OF_DEBITS,OBR_OLD_BALANCE,OBR_D_AMOUNT,OBR_POST_DATE,OBR_VALUE_DATE,OBR_DEBIT_AMOUNT,OBR_CREDIT_AMOUNT,OCN_ID,OBR_CLIENT_REFERENCE,OBR_TRANSACTION_DESC_DETAILS,OBR_BANK_REFERENCE,OBR_TRX_TYPE,OBR_REF_ID,ULD_ID,OBR_TIMESTAMP) VALUES( (SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA= '$CSV_array[1]'),(SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA= '$CSV_array[2]' ),'$CSV_array[3]', '$CSV_array[4]', '$CSV_array[5]', '$CSV_array[6]', '$CSV_array[7]','$transdate', '$CSV_array[9]', '$csv_oldbal', '$CSV_array[11]', '$postdate', '$valuedate','$debitamt', '$creditamt',(SELECT OCN_ID FROM OCBC_CONFIGURATION WHERE OCN_DATA='$CSV_array[16]'), '$bankreff','$transaction_details','$bankreference','$CSV_array[20]','$CSV_array[0]',(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='kumar.r@ssomens.com'),'$csv_timstamp')";
                $this->db->query($OCBC_CSV_insertquery);
              }

             if($mailflag==1)
             {
              for($ar=0;$ar<count($newdatearray);$ar++)
                {
                    $value_date=$this->Dateconversionnewdateformat($newdatearray[$ar]);
                    array_push($date_array,$value_date);
                }
                $final_count=array();
                $current = null;
                $cnt = 0;
                 for ($i = 0; $i < count($date_array); $i++)
                  {
                    if ($date_array[$i] != $current) {
                    if ($cnt > 0)
                    {
                        array_push($final_count, $cnt);
                    }
                 $current = $date_array[$i];
                 $cnt = 1;
              }
              else
               {
                   $cnt++;
               }
              }
              if ($cnt > 0) {
                  array_push($final_count,$cnt);
              }
             }
            //************MAIL PART*****************//
            //MAIL SENDING PART
            $totalcount=$creditcount+$debitcount;
//            $unique=array_unique($date_array);
            $unique=$this->make_unique($date_array, '');
            $d=$unique." = ".$totalcount." ( ".$creditcount." - CREDIT(S) ,".$debitcount." - DEBIT(S) ) NEW RECORDS UPDATED SUCCESSFULLY";
            $message = '<body><br><h> '.$d.'</h><br><br><table border="1"  width="800">';
            $message.='<tr bgcolor="#6495ed" style="color:white" align="center" >';
            $message.='<td width=12%><h3>DATE</h3></td><td width=9%><h3>CREDIT</h3></td><td width=9%><h3>DEBIT</h3></td><td width=50%><h3>BANK REFERENCE</h3></td></tr>';
            $sum=0;
          for($v=0;$v<count($final_count);$v++)
          {
            $limit=$sum+$final_count[$v];
            for($b=$sum;$b<$limit;$b++)
            {
              if($mailrecord_array[$b]=="0.00" || $mailrecord_array[$b]==0)
              {
                  $creditamount="";
              }
              else
              {
                  $creditamount=$mailrecord_array[$b];
              }
              if($mailrecord_array[$b]=="0.00" || $mailrecord_array[$b]==0)
              {
                  $debitamount="";
              }
              else
              {
                  $debitamount=$mailrecord_array[$b];
              }
              if($b==$sum)
              {
                  if($b!=0)
                  {
                      $headerdata=$unique[$date_array[$limit]];
                      $message.='<tr align="center" ><td align="center" style="font-weight:bold;border-top:2px solid blue;" width=12% rowspan='.$final_count[$v].'>'.$unique[$date_array[$limit]].'</td><td width=9% style="border-top:2px solid blue;">'.creditamount.'</td><td width=9% style="border-top:2px solid blue;">'.$debitamount.'</td><td width=50% style="border-top:2px solid blue;">'.$mailrecord_array[$b].'</td></tr>';
                  }
                  else
                  {
//                      $headerdata=$headerdata.','.$unique[$date_array[$limit]];
                      $message.='<tr align="center" ><td align="center" style="font-weight:bold;" width=12% rowspan='.$final_count[$v].'>'.$unique[$date_array[$limit]].'</td><td width=9% >'.$creditamount.'</td><td width=9%>'.$debitamount.'</td><td width=50% >'.$mailrecord_array[$b].'</td></tr>';
                  }
              }
              else
              {
                  $message.='<tr align="center" ><td width=9%>'.$creditamount.'</td><td width=9%>'.$debitamount.'</td><td width=50%>'.$mailrecord_array[$b].'</td></tr>';
              }
            }
            $sum=$sum+$final_count[$v];
          }
            $message.='</table></body>';
            $subjectmess='DATABASE UPDATED-'.$headerdata;
        }
        else
        {
            return 'No New Records';
        }
        if($mailflag==1)
        {

        }
        return "Records Inserted";
    }
    public function getTriggerConfiguration()
    {
     $Selectquery="SELECT TC_ID,TC_DATA FROM TRIGGER_CONFIGURATION WHERE CGN_ID=31 ORDER BY TC_DATA ASC";
     $resultset=$this->db->query($Selectquery);
     return $resultset->result();
    }
    function downloadFile($service, $downloadUrl)
    {
        if ($downloadUrl) {
            $request = new Google_Http_Request($downloadUrl, 'GET', null, null);
            $httpRequest = $service->getClient()->getAuth()->authenticatedRequest($request);
            if ($httpRequest->getResponseHttpCode() == 200) {
                return $httpRequest->getResponseBody();
            } else {
                echo "errr";
                return null;
            }
        } else {
            echo "empty";
            return null;
        }
    }
    function DateConversion($input)
    {
        $year=substr($input,0,4);
        $month=substr($input,4,2);
        $day=substr($input,6,2);
        return $year.'-'.$month.'-'.$day;
    }
    function Dateconversionnewdateformat($input)
    {

        $year=substr($input,0,4);
        $month=substr($input,4,2);
        $day=substr($input,6,2);
        return $day.'-'.$month.'-'.$year;
    }
    function make_unique($array, $ignore)
    {
        while($values = each($array))
        {
            if(!in_array($values[1], $ignore))
            {
                $dupes = array_keys($array, $values[1]);
                unset($dupes[0]);
                foreach($dupes as $rmv)
                {
                    unset($array[$rmv]);
                }
            }
        }
        return $array;
    }
}