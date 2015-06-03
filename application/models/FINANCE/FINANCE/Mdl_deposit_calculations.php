<?php
class Mdl_deposit_calculations extends CI_Model{
    // GET THE UNIT  FOR LOAD IN THE  FORM
    public function Initial_data($UserStamp){
        $this->load->model('EILIB/Common_function');
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
            $filenamelist=array();
            foreach ($children1->getItems() as $child) {
                if($service->files->get($child->getId())->getExplicitlyTrashed()==1)continue;
                $fileid=$service->files->get($child->getId())->id;
                $filename=$service->files->get($child->getId())->title;
                $filenamelist[]=['id'=>$fileid,'title'=>$filename];break;
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
        $DDC_recverarray='';
        $recverlen=[];
        for($i=0;$i<count($rbuttonX1);$i++)
        {
            $DDC_splitalvalue=explode('^',$rbuttonX1[$i]);
            $DDC_id=$DDC_splitalvalue[0];
            $DDC_recver=$DDC_splitalvalue[1];
            $DDC_startdate=$DDC_splitalvalue[2];
            $DDC_enddate=$DDC_splitalvalue[3];
            $recverlen[]=$DDC_recver;
            if($i==0){
                $DDC_recverarray=$DDC_recver;
            }
            else{
                $DDC_recverarray=$DDC_recverarray.','.$DDC_recver;
            }
            $selectedrecverlength=count($recverlen);
        }
        $flag='X';
        $DDC_nooftimescalculat='';
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
        $DDC_getfiles = $this->GetAllFilesName($service,$DDC_folderid);
        $DDC_flag_ss=0;
        $DDC_ssname_getid='';
        $DDC_currentfile_id='';
        $DDC_ssname_oldyear='';
        for($i=0;$i<count($DDC_getfiles);$i++)
        {
            $DDC_oldfile=$DDC_getfiles[$i]['title'];
            $DDC_oldfile_id=$DDC_getfiles[$i]['id'];
            if($DDC_oldfile==$DDC_ssname_currentyear)
            {
                $DDC_currentfile_id=$DDC_oldfile_id;
                $DDC_flag_ss=1;
            }
            $DDC_olddateyear=$date[1]-1;
            $DDC_ssname_oldyear='EI_DEPOSIT_DEDUCTIONS_'.$DDC_olddateyear;
            if($DDC_ssname_oldyear==$DDC_oldfile){
                $DDC_ssname_getid=$DDC_oldfile_id;
            }
        }
        if($DDC_flag_ss!=1){
            if($DDC_ssname_getid=='')
            {
                $DDC_getfiles = $this->GetAllFilesName($service,$DDC_folderid);
                for($i=0;$i<count($DDC_getfiles);$i++)
                {
                    $DDC_oldfile=$DDC_getfiles[$i]['title'];
                    $DDC_oldfile_id=$DDC_getfiles[$i]['id'];
                    if($DDC_oldfile==$DDC_ssname_currentyear)
                    {
                        $this->deleteFile($service,$DDC_oldfile_id);
                    }
                }
                return ['DDC_flag_nosheet',$DDC_ssname_oldyear];
            }
            $this->load->model('EILIB/Invoice_contract');
            $this->load->model('EILIB/common_function');
            $parentId=$this->Invoice_contract->getTemplatesFolderId();
            $DDC_newspread_ssid=$this->insertFile($service, $DDC_ssname_currentyear, 'DD Calculation', $parentId);
            $this->db->query("UPDATE FILE_PROFILE SET FP_FILE_ID='".$DDC_newspread_ssid."' WHERE FP_ID=1");
            $DDC_docowner=$this->common_function->CUST_documentowner($UserStamp);
            $this->Invoice_contract->SetDocOwner($service,$DDC_newspread_ssid,$DDC_docowner,$DDC_docowner);
            // GIVE PERMISSION TO EDITORS WHEN NEW SS CREATED USING EILIB
//            $this->common_function->Deposit_Deduction_fileSharing($DDC_newspread_ssid, $DDC_folderid);
            $DDC_flg_tempsht=0;
            $data=array('ssflag'=>1,'DDC_newspread_ssid'=>$DDC_newspread_ssid,'DDC_ssname_getid'=>$DDC_ssname_getid,'DDC_currentmonth'=>$DDC_currentmonth);
            $ssnameload=array();
            $ssnameload=$this->Func_curl($data);
            $ssnameload=explode(',',$ssnameload);
            $DDC_flg_tempsht=$ssnameload[0];
            $DDC_currentfile_id=$ssnameload[1];
            // RETURN ERR MSG
            if($DDC_flg_tempsht==0 ){
                $DDC_getfiles = $this->GetAllFilesName($service,$DDC_folderid);
                for($i=0;$i<count($DDC_getfiles);$i++)
                {
                    $DDC_oldfile=$DDC_getfiles[$i]['title'];
                    $DDC_oldfile_id=$DDC_getfiles[$i]['id'];
                    if($DDC_oldfile==$DDC_ssname_currentyear)
                    {
                        $this->deleteFile($service,$DDC_oldfile_id);
                    }
                }
                return [$DDC_flg_tempsht];
            }
        }
        // IF CURRENT SS NOT HAVING TEMPLATE SHEET IT LL CREATE THEM TEMPLATE AND SENDING EMAIL
        else{
            $data1=array('ssflag'=>2,'DDC_currentfile_id'=>$DDC_currentfile_id,'DDC_ssname_getid'=>$DDC_ssname_getid,'DDC_ssname_oldyear'=>$DDC_ssname_oldyear);
            $ssnametemp=array();
            $ssnametemp=$this->Func_curl($data1);
            $ssnametemp=explode(',',$ssnametemp);
            if($ssnametemp[0]=='DDC_flag_nosheet'){
                return $ssnametemp;
            }
        }
        $DDC_callstorepcedurquery="CALL SP_DD_CALCULATION('".$unit_value."','".$dep_custid."','".$DDC_recverarray."','".$flag."','".$UserStamp."',@TEMP_DD_DYNAMICTBLE)";
        $this->db->query($DDC_callstorepcedurquery);
        $DDC_rs_temptble=$this->db->query("SELECT @TEMP_DD_DYNAMICTBLE AS TEMP_DD_DYNAMICTBLE");
        $DDC_temptble_name=$DDC_rs_temptble->row()->TEMP_DD_DYNAMICTBLE;
        for($i=0;$i<$DDC_nooftimescalculat;$i++)
        {
            $DDC_chargtype=[];
            $DDC_chargamount=[];
            $DDC_electrcap=[];
            $DDC_sprecverarray=[];
            $DDC_startdatearrary=[];
            $DDC_enddatearrary=[];
            $DDC_no_ofdivision='';
            $DDC_cardcount='';
            $DDC_cardamount='';
            $DDC_dryclean = [];
            $DDC_checkoutclean = [];
            $DDC_aircon = [];
            $DDC_airconquater = [];
            $DDC_quaters = [];
            $DDC_depositeunpaid = [];
            $DDC_depositeamount = [];
            $DDC_proratedunpaid = '';
            $DDC_payunpaiddate = [];
            $DDC_paymentrecver = [];
            $DDC_custpaymentid = [];
            $DDC_unitinvoiceitem = [];
            $DDC_unitdivamount = [];
            $DDC_unitamount = [];
            $DDC_unitinvoicedate = [];
            $DDC_eledivamount = [];
            $DDC_eleamount = [];
            $DDC_invoicedate = [];
            $DDC_cardtilldate = '';
            $DDC_custid=[];
            $DDC_sumofquater=[];
            $DDC_quatertotal='';
            $DDC_fixedaircon='';
            if($flag=="")
            {
                $DDC_calltemptable="SELECT * FROM ".$DDC_temptble_name;
            }
            if($flag=="X")
            {
                $DDC_calltemptable="SELECT * FROM ".$DDC_temptble_name." where DDRECVER=".$recverlen[$i];
            }
            $DDC_temptblresult=$this->db->query($DDC_calltemptable);
            foreach($DDC_temptblresult->result_array() as $row)
            {
                if($row['DDCUSTOMERID']!=null)
                {
                    $DDC_custid=$row["DDCUSTOMERID"];
                }
                if($row["DDRECVER"]!=null)
                {
                    $DDC_sprecverarray = $row["DDRECVER"];
                }
                if($row["DDSTARTDATE"]!=null)
                {
                    if((is_array($row["DDSTARTDATE"]))==true){
                        $DDC_startdatearrary=$row["DDSTARTDATE"];
                    }
                    else
                    {
                        $DDC_startdatearrary[]=($row["DDSTARTDATE"]);
                    }
                }
                if($row["DDENDDATE"]!=null)
                {
                    if((is_array($row["DDENDDATE"]))==true){
                        $DDC_enddatearrary=$row["DDENDDATE"];
                    }
                    else
                    {
                        $DDC_enddatearrary[]=($row["DDENDDATE"]);
                    }
                }
                if($row["DDNOOFDIVISION"]!=null)
                {
                    $DDC_no_ofdivision = $row["DDNOOFDIVISION"];
                }
                if($row["DDCARDCOUNT"]!=null)
                {
                    $DDC_cardcount = $row["DDCARDCOUNT"];
                }
                if($row["DDCARDAMOUNT"]!=null)
                {
                    $DDC_cardamount = $row["DDCARDAMOUNT"];
                }
                if($row["DDCARDTILLDATE"]!=null)
                {
                    $DDC_cardtilldate = $row["DDCARDTILLDATE"];
                }
                if($row["DDEEINVOICEDATE"]!=null)
                {
                    $DDC_invoicedate[]=((object)['value'=>$row["DDEEINVOICEDATE"],'key'=>$row["DDRECVER"]]);
                }
                if($row["DDEEAMOUNT"]!=null)
                {
                    if((is_array($row["DDEEAMOUNT"]))==true){
                        $DDC_eleamount=$row["DDEEAMOUNT"];
                    }
                    else
                    {
                        $DDC_eleamount[]=($row["DDEEAMOUNT"]);
                    }
                }
                if($row["DDEEDIVAMOUNT"]!=null)
                {
                    if((is_array( $row["DDEEDIVAMOUNT"]))==true){
                        $DDC_eledivamount= $row["DDEEDIVAMOUNT"];
                    }
                    else
                    {
                        $DDC_eledivamount[]=( $row["DDEEDIVAMOUNT"]);
                    }
                }
                if($row["DDUNITINVOICEDATE"]!=null)
                {
                    if((is_array( $row["DDUNITINVOICEDATE"]))==true){
                        $DDC_unitinvoicedate= $row["DDUNITINVOICEDATE"];
                    }
                    else
                    {
                        $DDC_unitinvoicedate[]=( $row["DDUNITINVOICEDATE"]);
                    }
                }
                if($row["DDUNITAMOUNT"]!=null)
                {
                    if((is_array( $row["DDUNITAMOUNT"]))==true){
                        $DDC_unitamount= $row["DDUNITAMOUNT"];
                    }
                    else
                    {
                        $DDC_unitamount[]=( $row["DDUNITAMOUNT"]);
                    }
                }
                if($row["DDUNITDIVAMOUNT"]!=null)
                {
                    if((is_array( $row["DDUNITDIVAMOUNT"]))==true){
                        $DDC_unitdivamount= $row["DDUNITDIVAMOUNT"];
                    }
                    else
                    {
                        $DDC_unitdivamount[]=($row["DDUNITDIVAMOUNT"]);
                    }
                }
                if($row["DDUNITINVOICEITEM"]!=null)
                {
                    if((is_array( $row["DDUNITINVOICEITEM"]))==true){
                        $DDC_unitinvoiceitem= $row["DDUNITINVOICEITEM"];
                    }
                    else
                    {
                        $DDC_unitinvoiceitem[]=($row["DDUNITINVOICEITEM"]);
                    }
                }
                if($row["DDCPPID"]!=null)
                {
                    $DDC_custpaymentid=$row["DDCPPID"];
                }
                if($row["DDPAYMENTUNPAIDDATE"]!=null)
                {
                    $DDC_payunpaiddate[]=($row["DDPAYMENTUNPAIDDATE"].'(LP:'.$DDC_sprecverarray.') ');
                }
                if($row["DDEECAP"]!=null)
                {
                    $DDC_electrcap[]=((object)['value'=>$row["DDEECAP"],'key'=>$row["DDRECVER"]]);
                }
                if($row["DDPROCUNPAID"]!=null)
                {
                    $DDC_proratedunpaid=$row["DDPROCUNPAID"];
                }
                if($row["DDDEPOAMOUNT"]!=null)
                {
                    $DDC_depositeamount[]=($row["DDDEPOAMOUNT"]);
                }
                //CHARGE AMOUNT//
                if($row["DDCHARGETYPE"]!=null)
                {
                    if((is_array($row["DDCHARGETYPE"]))==true){
                        $DDC_chargtype=$row["DDCHARGETYPE"];
                    }
                    else
                    {
                        $DDC_chargtype[]=($row["DDCHARGETYPE"]);
                    }
                }
                if($row["DDCHARGE"]!=null)
                {
                    if((is_array($row["DDCHARGE"]))==true){
                        $DDC_chargamount=$row["DDCHARGE"];
                    }
                    else
                    {
                        $DDC_chargamount[]=($row["DDCHARGE"]);
                    }
                }
                if($row["DDDEPOUNPAID"]!=null)
                {
                    $DDC_depositeunpaid[]=((object)['value'=>$row["DDDEPOUNPAID"],'key'=>$row["DDRECVER"]]);
                }
                if($row["DDQUATERS"]!=null)
                {
                    $DDC_quaters[]=((object)['value'=>$row["DDQUATERS"],'key'=>$row["DDRECVER"]]);
                }
                if($row["DDAIRCONQ"]!=null)
                {
                    $DDC_airconquater[]=((object)['value'=>$row["DDAIRCONQ"],'key'=>$row["DDRECVER"]]);
                }
                if($row["DDAIRCON"]!=null)
                {
                    if($row["DDAIRCONQ"]==null){
                        $DDC_fixedaircon=(object)['value'=>$row["DDAIRCON"],'key'=>$row["DDRECVER"]];
                    }
                    else{
                        $DDC_aircon[]=((object)['valueDiff'=>$row["DDAIRCON"],'value'=>$row["DDAIRCONQ"],'key'=>$row["DDRECVER"],'quater'=>$row["DDQUATERS"]]);
                    }
                }
                if($row["DDCHECKOUTCLEAN"]!=null)
                {
                    $DDC_checkoutclean=(object)['value'=>$row["DDCHECKOUTCLEAN"],'key'=>$row["DDRECVER"]];
                }
                if($row["DDQUATERTOTAL"]!=null)
                {
                    $DDC_sumofquater[]=((object)['value'=>$row["DDPERQUATER"],'quater'=>$row["DDSUMOFQUATER"],'total'=>$row["DDQUATERTOTAL"]]);
                }
                if($row["DDDRYCLEAN"]!=null)
                {
                    $DDC_dryclean=(object)['value'=>$row["DDDRYCLEAN"],'key'=>$row["DDRECVER"]];
                }
                $DDC_electsubtotal=$row["DDSUBTOTAL_ONE"];
                if($DDC_electsubtotal==null)
                {
                    $DDC_electsubtotal="";
                }
                $DDC_airconsubtotal=$row["DDSUBTOTAL_TWO"];
                if($DDC_airconsubtotal==null)
                {
                    $DDC_airconsubtotal="";
                }
                $DDC_unitsubtotal=$row["DDSUBTOTAL_THREE"];
                if($DDC_unitsubtotal==null)
                {
                    $DDC_unitsubtotal="";
                }
                $DDC_totalallsubtl=$row["DDTOTAL_DD"];
                if($DDC_totalallsubtl==null)
                {
                    $DDC_totalallsubtl="";
                }
                $DDC_tefundtotal=$row["DDTOTAL_REFUND"];
                if($DDC_tefundtotal==null)
                {
                    $DDC_tefundtotal="";
                }
            }
            //SET THE START DATE//
            if($flag=="")
            {
                $DDC_startdatearrary=$DDC_startdatearrary[0];
                $DDC_enddatearrary=$DDC_enddatearrary[count($DDC_enddatearrary)-1];
            }
            else{
                $DDC_startdatearrary=$DDC_startdatearrary[$i];
                $DDC_enddatearrary=$DDC_enddatearrary[$i];
            }
            if($DDC_recverlgth==$selectedrecverlength)
            {
                $DDC_recverarray=$recverlen[$i];
            }
            else
            {
                $DDC_recverarray=$recverlen[$i];
            }
            //DEPOSITE VALUE FILL IN THE SHEET//
            $depcomment='';$rentalcase='';$dep_value=0;
            $DDC_depositeunpaid_rec='';
            if($flag=="X"){
                if(count($DDC_depositeamount)==0)
                {
                    $dep_value = 0;
                }
                if(count($DDC_depositeunpaid)!=0){
                    if(count($DDC_depositeamount)==0 && $DDC_depositeunpaid[0]->value=="UNPAID")
                    {
                        $entalcase=3;
                        $dep_value = 0;
                        $depcomment="DEPO NT PAID";
                    }
                }
            }
            else if($flag=="")
            {
                $sum=0;
                for($D=0;$D<count($DDC_depositeamount);$D++){
                    $sum=$sum+intval($DDC_depositeamount[$D]);
                    $dep_value=$sum;
                }
                for($k=0;$k<count($DDC_depositeunpaid);$k++){
                    if($k==0){
                        $DDC_depositeunpaid_rec=$DDC_depositeunpaid[$k]->key;
                    }
                    else{
                        $DDC_depositeunpaid_rec=$DDC_depositeunpaid_rec.','.$DDC_depositeunpaid[$k]->key;
                    }
                    $rentalcase=3;
                }
                $depcomment="DEPO NT PAID FR LEASE PERIOD ".$DDC_depositeunpaid_rec;
            }
            $DDC_pay_unpaiddate='';
            if($DDC_payunpaiddate!="")
            {
                for($l=0;$l<count($DDC_payunpaiddate);$l++){
                    if($l==0){
                        $DDC_pay_unpaiddate=$DDC_payunpaiddate[$l];
                    }
                    else{
                        $DDC_pay_unpaiddate=$DDC_pay_unpaiddate.','.$DDC_payunpaiddate[$l];
                    }
                }
            }
            $lastcarddate="ACCESS CARD LOST = ".$DDC_cardtilldate;
            //CHECK ABOUT THE ELECTRICITY AMOUNT//
            $DDC_cap ='';
            $DDC_cap_flag =1;
            $DDC_sheet_range='';
            for($C=0;$C<count($DDC_electrcap);$C++){
                if($C==0){
                    $DDC_chk_cap=$DDC_electrcap[$C]->value;
                }
                if($DDC_chk_cap!=$DDC_electrcap[$C]->value){
                    $DDC_cap_flag =0;
                    break;
                }
            }
            if($DDC_cap_flag==1){
                $DDC_cap ='$'.$DDC_chk_cap .' Capped ';
            }
            else{
                $DDC_cap='';
            }
            //SET THE ELECTRICITY VALUES IN THE SHEET//
            $DDC_electrcap=uasort($DDC_electrcap, 'compare');
            $DDC_cap_rec=[];
            $DDC_cap_rec=$DDC_electrcap[0]->key;
            for($c=0;$c<count($DDC_electrcap);$c++){
                $cap='$'.$DDC_electrcap[$c]->value.' CAP  LP :'.$DDC_electrcap[$c]->key;
                $modify='';
                if($c!=0){
                    if($DDC_electrcap[$c]->value==$DDC_electrcap[$c-1]->value){
                        $DDC_cap_rec .=','.$DDC_electrcap[$c]->key;
                        $modify='$'.$DDC_electrcap[$c]->value.' CAP  LP :'.$DDC_cap_rec;
                        $cap='';
                    }
                    else{
                        $cap=' $'.$DDC_electrcap[$c]->value.' CAP  LP :'.$DDC_electrcap[$c]->key;
                        $DDC_cap_rec='';
                        $DDC_cap_rec=$DDC_electrcap[$c]->key;
                    }
                }
                $caps='';$modifies='';
                if($c==0){
                    $caps=$cap;
                    $modifies=$modify;
                }
                else{
                    $caps=$caps.'^^'.$cap;
                    $modifies=$modifies.'^^'.$modify;
                }
            }

            $data2=array('ssflag'=>3,'DDC_currentfile_id'=>$DDC_currentfile_id,'DDC_currentmonth'=>$DDC_currentmonth,'unit_value'=>$unit_value,'name'=>$name,
                'flag'=>$flag,'DDC_startdatearrary'=>$DDC_startdatearrary,'DDC_enddatearrary'=>$DDC_enddatearrary,'DDC_recverlgth'=>$DDC_recverlgth,
                'selectedrecverlength'=>$selectedrecverlength,'DDC_recverarray'=>$DDC_recverarray,'dep_value'=>$dep_value,'depcomment'=>$depcomment,
                'rentalcase'=>$rentalcase,'DDC_proratedunpaid'=>$DDC_proratedunpaid,'DDC_pay_unpaiddate'=>$DDC_pay_unpaiddate,'lastcarddate'=>$lastcarddate,
                'DDC_cardcount'=>$DDC_cardcount,'DDC_cardamount'=>$DDC_cardamount,'DDC_cap'=>$DDC_cap,'DDC_no_ofdivision'=>$DDC_no_ofdivision,
                'caps'=>$caps,'modifies'=>$modifies);
            $ssreangtemp=array();
            $ssreangtemp=$this->Func_curl($data2);
            return $ssreangtemp;
            $ssreangtemp=explode(',',$ssreangtemp);
            if($ssreangtemp[0]==0 && $ssreangtemp[1]==1){
                return [0,1];
            }
        }
    }
    // Comparison function
    function compare($a, $b) {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

}