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
    public function GetAllFilesName($service,$folderid){
        try{
            $children1 = $service->children->listChildren($folderid);
            $filearray1=$children1->getItems();
            $filenamelist=array();
            foreach ($filearray1 as $child1) {
                $fileid=$service->files->get($child1->getId())->id;
                $filename=$service->files->get($child1->getId())->title;
                $filenamelist[]=['id'=>$fileid,'title'=>$filename];
            }
            return $filenamelist;
        }
        catch(Exception $ex){
            return 0;
        }
    }
    function deleteFile($service, $fileId) {
        try {
            $service->files->delete($fileId);
        }
        catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    public  function insertFile($service, $title, $description, $parentId) {
        $file = new Google_Service_Drive_DriveFile();
        $file->setTitle($title);
        $file->setDescription($description);
        $file->setMimeType('application/vnd.google-apps.spreadsheet');
        if ($parentId != null) {
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
        }
        try {
            $createdFile = $service->files->insert($file, array(
            'mimeType' => 'application/vnd.google-apps.spreadsheet',//$mimeType,
            'convert' => TRUE,
            'uploadType'=>'resumable'
            ));
            return $createdFile->getId();
        }
        catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
    public function Func_curl($data){
        $url="https://script.google.com/macros/s/AKfycbzmlgt77SgxpUjRgRWbp5ksUEInKUeTaWV_TPJKut-rsmDuI9ng/exec";
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
            return $response;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        curl_close($ch);
    }
    public function DDC_depcal_submit($unit_value,$name,$chkbox,$radio,$startdate,$enddate,$dep_custid,$DDC_recverlgth,$DDC_recdate,$UserStamp,$service){
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
            $rbuttonX1=array();
            $rbuttonX1[]=$DDC_recdate;
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
            $DDC_recverarray=($DDC_recver);
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
        $curdate=date('M-Y');
        $date=explode('-',$curdate);
        $DDC_currentdateyear=$date[1];
        $DDC_currentmonth=$date[0];
        $DDC_ssname_currentyear='EI_DEPOSIT_DEDUCTIONS_'.$DDC_currentdateyear;
        $data=array('curyear'=>$DDC_currentdateyear,'folderid'=>$DDC_folderid,'flag'=>1);
        $ssnameload=array();
        $ssnameload=$this->Func_curl($data);
        $ssnameload=explode(',',$ssnameload);
        if($ssnameload[0]!=1){
            $newssfileid=$ssnameload[1];
            $this->load->model('Eilib/Invoice_contract');
            $parentId=$this->Invoice_contract->getTemplatesFolderId();
            $file = new Google_Service_Drive_DriveFile();
            $parent = new Google_Service_Drive_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));
            try {
                $service->files->patch($newssfileid, $file);
            }
            catch(Exception $e){
                echo $e->getMessage();
            }
            $errormsg_exequery ="UPDATE FILE_PROFILE SET FP_FILE_ID='".$newssfileid."' WHERE FP_ID=1";
            $errormsg_rs = $this->db->query($errormsg_exequery);
            $DDC_folderid=$errormsg_rs->row()->DDC_DATA;
        }
        else{
            return $ssnameload[0];
        }


    }
}