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
            if($filename=='201505.CSV')
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
            $csvrow=$val['OBR_REF_ID'].'_'.$postdate.'_'.$val['OBR_CLIENT_REFERENCE'].'_'.$val['OBR_TRANSACTION_DESC_DETAILS'].'_'.$val['OBR_BANK_REFERENCE'];
            array_push($CSV_DB_Records,$csvrow_Refid);
            array_push($AfterDBRecords,$csvrow);
        }
        $DBcount=count($CSV_DB_Records);
        /************************END OF OCBC TABLE RECORDS************************************/
        /************************CSV FILE RECORDS***************************************/
        $CSV_File_comparisionRecords=array();
        $CSV_Files_Records=array();
        for($h=0;$h<count($data);$h++)
        {
            $CSV_array = $data[$h];
            if ($CSV_array != '' && $CSV_array != null && $CSV_array[11]!='')
            {
//                if($CSV_array[16]=='000000000001'){$cleientref=1;}else{$cleientref='';}
                $csv_compdate= $CSV_array[11].'_'.$CSV_array[16].'_'.$CSV_array[17].'_'.$CSV_array[18];
                array_push($CSV_File_comparisionRecords,$csv_compdate);
                $csvRecordsobj=$CSV_array[0].','.$CSV_array[1].','.$CSV_array[2].','.$CSV_array[3].','.$CSV_array[4].','.$CSV_array[5].','.$CSV_array[6].','.$CSV_array[7].','.$CSV_array[8].','.$CSV_array[9].','.$CSV_array[10].','.$CSV_array[11].','.$CSV_array[12].','.$CSV_array[13].','.$CSV_array[14].','.$CSV_array[15].','.$CSV_array[16].','.$CSV_array[17].','.$CSV_array[18].','.$CSV_array[19];
                array_push($CSV_Files_Records,$csvRecordsobj);
            }
        }
        $CSVcount=count($CSV_File_comparisionRecords);
//        return $CSVcount;
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
//        return $CSV_Old_Record;
        if($Old_rcordsCount==$DBcount)
        {
             for($k=0;$k<count($CSV_Old_Records);$k++)
             {
               $UpdateRecordsplit=explode(',',$CSV_Old_Records[$k]);
               $valuedate=$this->DateConversion($UpdateRecordsplit[12]);
               return $CSV_Old_Records;
             }
        }
        else
        {
            return 'Records Count Not Match';
        }
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
}