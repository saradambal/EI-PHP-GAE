<?php
class Mdl_staff_daily_entry_search_update_delete extends CI_Model{
    public function Initial_data($ErrorMessage)
    {
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID IN (26,23)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result1 = $query->result();

        $this->db->select('DISTINCT CONCAT(ED.EMP_FIRST_NAME," ",ED.EMP_LAST_NAME) AS EMPLOYEE_NAME,ED.EMP_ID,EDSS.EDSS_ID,EDSS.EDSS_CPF_NUMBER,EDSS.EDSS_LEVY_AMOUNT,EDSS.EDSS_SALARY_AMOUNT,EDSS.EDSS_CPF_AMOUNT',FALSE);
        $this->db->from('EMPLOYEE_DETAILS ED,EXPENSE_DETAIL_STAFF_SALARY EDSS');
        $this->db->where('ED.EMP_ID=EDSS.EMP_ID');
        $query = $this->db->get();
        $result2 = $query->result();

        $this->db->select('EMP_ID');
        $this->db->from('EMPLOYEE_DETAILS');
        $query = $this->db->get();
        $result3 = $query->result();

        return $result[]=array($result1,$result2,$result3,$ErrorMessage);
    }
    //FUNCTION FOR SAVE PART
    public function STDLY_INPUT_insert($USERSTAMP){
        global  $USERSTAMP;
        $STDLY_INPUT_lbtypeofexpense=$_POST['staffdly_lb_type'];
//        echo $STDLY_INPUT_lbtypeofexpense;
        if($STDLY_INPUT_lbtypeofexpense==39)
        {
            $STDLY_INPUT_commision_date=$_POST['staffdly_invdate'];
            $STDLY_INPUT_commision_date = date('Y-m-d',strtotime($STDLY_INPUT_commision_date));
            $STDLY_INPUT_commision_amount=$_POST['staffdly_tb_comisnamt'];
            $STDLY_INPUT_comments=$_POST['staffdly_ta_agentcomments'];
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments='null';
            }
            else{
                $STDLY_INPUT_comments="'$STDLY_INPUT_comments'";
            }
        $insertquery = "INSERT INTO EXPENSE_AGENT(ULD_ID,EA_DATE,EA_COMM_AMOUNT,EA_COMMENTS) VALUES((SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),'$STDLY_INPUT_commision_date','$STDLY_INPUT_commision_amount',$STDLY_INPUT_comments)";


            $this->db->query($insertquery);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
            else {
                return false;
            }
        }
       else if($STDLY_INPUT_lbtypeofexpense==40)
        {
//            echo 'jlj';
            $STDLY_INPUT_paid_date=$_POST['staffdly_paiddate'];
            $STDLY_INPUT_paid_date = date('Y-m-d',strtotime($STDLY_INPUT_paid_date));
            $STDLY_INPUT_from_period=$_POST['staffdly_fromdate'];
            $STDLY_INPUT_from_period = date('Y-m-d',strtotime($STDLY_INPUT_from_period));
            $STDLY_INPUT_to_period=$_POST['staffdly_todate'];
            $STDLY_INPUT_to_period = date('Y-m-d',strtotime($STDLY_INPUT_to_period));
            $STDLY_INPUT_cpfamount = $_POST['staffdly_tb_newcpfamt'];
//            $STDLY_INPUT_levyradio = $_POST['salarylevyamtopt'];
            $STDLY_INPUT_levyradio =(isset($_POST["salarylevyamtopt"]));
//            $STDLY_INPUT_levyradio = ($_POST['salarylevyamtopt']=="")?"":$_POST['salarylevyamtopt'];
//echo 'pop';
//            echo $STDLY_INPUT_levyradio;
//            exit;

            $STDLY_INPUT_hidencpfamount= $_POST['staffdly_tb_curcpfamt'];
            if($STDLY_INPUT_cpfamount=='undefined' || $STDLY_INPUT_cpfamount=='')
            {
                $STDLY_INPUT_cpfamount=null;
            }
            if($STDLY_INPUT_cpfamount=='on')
            {
                if(($STDLY_INPUT_cpfamount=='undefined')||($STDLY_INPUT_cpfamount==''))
                {
                    $STDLY_INPUT_cpfamount=$STDLY_INPUT_hidencpfamount;
                }
            }
            $STDLY_INPUT_levyamount = $_POST['staffdly_tb_newlevyamt'];
            $STDLY_INPUT_hidenlevyamount = $_POST['staffdly_tb_curlevyamt'];

            if($STDLY_INPUT_levyamount=='undefined' || $STDLY_INPUT_levyamount=='' )
            {
                $STDLY_INPUT_levyamount='null';
            }
            if($STDLY_INPUT_levyradio=='undefined')
            {
                $STDLY_INPUT_levyamount='null';
            }
            else{
                if(($STDLY_INPUT_levyamount=='undefined')||($STDLY_INPUT_levyamount==''))
                {
                    $STDLY_INPUT_levyamount="'$STDLY_INPUT_hidenlevyamount'";
                }
            }
            $STDLY_INPUT_salaryamount = $_POST['staffdly_tb_newsalary'];
            $STDLY_INPUT_hidensalaryamount = $_POST['staffdly_tb_cursalary'];
            if($STDLY_INPUT_salaryamount=='undefined' || $STDLY_INPUT_salaryamount=='')
            {
                $STDLY_INPUT_salaryamount='null';
            }
            if(($STDLY_INPUT_salaryamount=='undefined')||($STDLY_INPUT_salaryamount==''))
            {
                $STDLY_INPUT_salaryamount="'$STDLY_INPUT_hidensalaryamount'";
            }
            $STDLY_INPUT_comments=$_POST['staffdly_ta_salarycomments'];
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments='null';
            }
            else{
                $STDLY_INPUT_comments="'$STDLY_INPUT_comments'";
            }
            $STDLY_INPUT_radio_employee=(isset($_POST["staffdly_rd_employee"]));
//echo $STDLY_INPUT_radio_employee;
//           exit;
            if($STDLY_INPUT_radio_employee=='' || $STDLY_INPUT_radio_employee=='undefined')
            {
                $STDLY_INPUT_edssid=$_POST['staffdly_hidden_edssid'];
            }
            else{
                $STDLY_INPUT_edssid=$STDLY_INPUT_radio_employee;
            }
//            echo 'kj';
//            echo $STDLY_INPUT_edssid;
//            exit;
           // var insert_salary_detailswithcomment = "CALL SP_STAFFDLY_STAFF_SALARY_INSERT("+STDLY_INPUT_edssid+",'"+STDLY_INPUT_paid_date+"','"+STDLY_INPUT_from_period+"','"+STDLY_INPUT_to_period+"',"+STDLY_INPUT_cpfamount+","+STDLY_INPUT_levyamount+","+STDLY_INPUT_salaryamount+","+STDLY_INPUT_comments+",'"+UserStamp+"',@SUCCESS_MSG)";
//       echo "CALL SP_STAFFDLY_STAFF_SALARY_INSERT('$STDLY_INPUT_edssid','$STDLY_INPUT_paid_date','$STDLY_INPUT_from_period','$STDLY_INPUT_to_period','$STDLY_INPUT_cpfamount',$STDLY_INPUT_levyamount,$STDLY_INPUT_salaryamount,$STDLY_INPUT_comments,'$USERSTAMP',@SUCCESS_MSG)";
            $insertquery = "CALL SP_STAFFDLY_STAFF_SALARY_INSERT('$STDLY_INPUT_edssid','$STDLY_INPUT_paid_date','$STDLY_INPUT_from_period','$STDLY_INPUT_to_period','$STDLY_INPUT_cpfamount',$STDLY_INPUT_levyamount,$STDLY_INPUT_salaryamount,$STDLY_INPUT_comments,'$USERSTAMP',@SUCCESS_MSG)";
           $query = $this->db->query($insertquery);
           $this->db->select('@SUCCESS_MSG as SUCCESSMSG', FALSE);
           $result = $this->db->get()->result_array();
           return  $result;
       }

    }
    //FUNCTION FOR SAVE staff PART
    public function STDLY_INPUT_insertstaff($USERSTAMP){
        global  $USERSTAMP;
//        echo 'inside';
//        exit;
//        $STDLY_INPUT_expenselist=array();
//        $STDLY_INPUT_invoiceDate=array();
//        $STDLY_INPUT_in_items=array();
//        $STDLY_INPUT_invoiceAmount=array();
//        $STDLY_INPUT_comments=array();
//        $STDLY_INPUT_comments1=array();
        $STDLY_INPUT_expenselist=$_POST['STDLY_INPUT_lb_category'];

        $STDLY_INPUT_invoiceDate=$_POST['STDLY_INPUT_db_invdate'];
        $STDLY_INPUT_in_items=$_POST['STDLY_INPUT_ta_invitem'];
        $STDLY_INPUT_invoiceAmount=$_POST['STDLY_INPUT_lb_incamtrp'];
        $PDLY_INPUT_inv_from=$_POST['STDLY_INPUT_tb_invfrom'];
        $STDLY_INPUT_comments=$_POST['STDLY_INPUT_tb_comments'];
        $STDLY_INPUT_lbtypeofexpense = $_POST['staffdly_lb_type'];
//
//        $STDLY_INPUT_counting=$STDLY_INPUT_comments1;
//        $STDLY_INPUT_array_length=$STDLY_INPUT_counting.length;
//        $STDLY_INPUT_array_length=$STDLY_INPUT_counting.length;
        $STDLY_INPUT_comments_split='';$STDLY_INPUT_invfrom_split='';$STDLY_INPUT_invitem_split='';
        $STDLY_INPUT_ctrylist=''; $STDLY_INPUT_amountsplit='';$STDLY_INPUT_datesplit='';
        if((is_array($PDLY_INPUT_inv_from))==true){
            for($i=0;$i<count($PDLY_INPUT_inv_from);$i++)
      {
          if($STDLY_INPUT_comments[$i]==''){
          if($i==0)
              $STDLY_INPUT_comments_split .=' ';
            else
                $STDLY_INPUT_comments_split .='^^'.' ';
          }
        else{
          if($i==0){
              $STDLY_INPUT_comments_split.=$this->db->escape_like_str($STDLY_INPUT_comments[$i]);
          }
          else{
              $STDLY_INPUT_comments_split.='^^'.$this->db->escape_like_str($STDLY_INPUT_comments[$i]);
          }
        }
        if($i==0){
            $STDLY_INPUT_invitem_split.=$this->db->escape_like_str($STDLY_INPUT_in_items[$i]);
            $STDLY_INPUT_invfrom_split.=$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
            $STDLY_INPUT_datesplit=date('Y-m-d',strtotime($STDLY_INPUT_invoiceDate[$i]));
            $STDLY_INPUT_ctrylist=$STDLY_INPUT_expenselist[$i];
            $STDLY_INPUT_amountsplit=$STDLY_INPUT_invoiceAmount[$i];
        }
        else{
            $STDLY_INPUT_invitem_split.='^^'.$this->db->escape_like_str($STDLY_INPUT_in_items[$i]);
            $STDLY_INPUT_invfrom_split.='^^'.$this->db->escape_like_str($PDLY_INPUT_inv_from[$i]);
            $STDLY_INPUT_datesplit.=",".date('Y-m-d',strtotime($STDLY_INPUT_invoiceDate[$i]));
            $STDLY_INPUT_ctrylist.=",".$STDLY_INPUT_expenselist[$i];
            $STDLY_INPUT_amountsplit.=",".$STDLY_INPUT_invoiceAmount[$i];

        }


      }}
        else
        {
            if($STDLY_INPUT_comments==''){
                $STDLY_INPUT_comments_split='';}
            else{
                $STDLY_INPUT_comments_split=$this->db->escape_like_str($STDLY_INPUT_comments);
                $STDLY_INPUT_datesplit=date('Y-m-d',strtotime($STDLY_INPUT_invoiceDate));
            $STDLY_INPUT_invfrom_split=$this->db->escape_like_str($PDLY_INPUT_inv_from);
            $STDLY_INPUT_invitem_split=$this->db->escape_like_str($STDLY_INPUT_in_items);
            $STDLY_INPUT_ctrylist=$STDLY_INPUT_expenselist;
            $STDLY_INPUT_amountsplit=$STDLY_INPUT_invoiceAmount;
            }
        }
//        print_r($STDLY_INPUT_ctrylist);

//        echo "CALL SP_STAFFDLY_STAFF_INSERT('$STDLY_INPUT_ctrylist','$STDLY_INPUT_datesplit','$STDLY_INPUT_amountsplit','$STDLY_INPUT_invitem_split','$STDLY_INPUT_invfrom_split','$STDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
//        exit;
        $insertquery = "CALL SP_STAFFDLY_STAFF_INSERT('$STDLY_INPUT_ctrylist','$STDLY_INPUT_datesplit','$STDLY_INPUT_amountsplit','$STDLY_INPUT_invitem_split','$STDLY_INPUT_invfrom_split','$STDLY_INPUT_comments_split','$USERSTAMP',@FLAG_INSERT)";
        $this->db->query($insertquery);
        $STDLY_INPUT_rs_flag = 'SELECT @FLAG_INSERT as FLAGINSERT';
        $query = $this->db->query($STDLY_INPUT_rs_flag);
        return $query->result();
    }
//GET DATA BY AGENT SEARCH......................
    public function STDLY_SEARCH_searchby_agent()
    {
        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('CGN_ID IN (26,23)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result1 = $query->result();


        $this->db->select('ECN_ID,ECN_DATA');
        $this->db->from('EXPENSE_CONFIGURATION');
        $this->db->where('ECN_ID BETWEEN 76 AND 93 OR CGN_ID IN (23,26)');
        $this->db->order_by('ECN_ID');
        $query = $this->db->get();
        $result2 = $query->result();


//        $this->db->select('DISTINCT CONCAT(ED.EMP_FIRST_NAME," ",ED.EMP_LAST_NAME) AS EMPLOYEE_NAME,ED.EMP_ID,EDSS.EDSS_ID,EDSS.EDSS_CPF_NUMBER,EDSS.EDSS_LEVY_AMOUNT,EDSS.EDSS_SALARY_AMOUNT,EDSS.EDSS_CPF_AMOUNT',FALSE);
//        $this->db->from('EMPLOYEE_DETAILS ED,EXPENSE_DETAIL_STAFF_SALARY EDSS');
//        $this->db->where('ED.EMP_ID=EDSS.EMP_ID');
//        $query = $this->db->get();
//        $result2 = $query->result();



//        $this->db->select('EMP_ID');
//        $this->db->from('EMPLOYEE_DETAILS');
//        $query = $this->db->get();
//        $result3 = $query->result();

        $this->db->select('EDSS_CPF_NUMBER');
        $this->db->from('EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS');
        $this->db->where('ESS.EDSS_ID=EDSS.EDSS_ID AND EDSS_CPF_NUMBER IS NOT NULL ');
        $this->db->order_by('EDSS_CPF_NUMBER');
        $query = $this->db->get();
        $result3 = $query->result();

        return $result[]=array($result1,$result2,$result3);
    }
    public function fetch_data()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
        if($STDLY_SEARCH_searchoptio==78)
        {

        $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
        $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
        $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
        $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
        $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
        $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
        $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
        $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
        $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EA_COMM_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
        $this->db->order_by("DATE", "ASC");
        $query = $this->db->get();
        return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==76)
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=EA.ULD_ID AND (EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==77)
       {
           $STDLY_SEARCH_searchcomments=$_POST['STDLY_SEARCH_searchcomments'];
           $this->db->select("EA.EA_ID,DATE_FORMAT(EA.EA_DATE,'%d-%m-%Y') AS DATE,EA.EA_COMM_AMOUNT AS AMNT,EA.EA_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS userstamp,DATE_FORMAT(CONVERT_TZ(EA.EA_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_AGENT EA,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=EA.ULD_ID AND EA_COMMENTS ='$STDLY_SEARCH_searchcomments' ");
           $this->db->order_by("DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
    }
    public function STDLY_SEARCH_comments()
    {
        $STDLY_SEARCH_sec_searchoption=$_POST['STDLY_SEARCH_sec_searchoption'];
        $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
        $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
        $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
        $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
        $STDTL_SEARCH_autocomplete=[];
        if($STDLY_SEARCH_sec_searchoption==77)
        {
            $this->db->select("EA_COMMENTS");
            $this->db->from("EXPENSE_AGENT");
            $this->db->where("EA_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND EA_COMMENTS IS NOT NULL ");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['EA_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
       elseif($STDLY_SEARCH_sec_searchoption==85)
        {
            $this->db->select("ESS_SALARY_COMMENTS");
            $this->db->from("EXPENSE_STAFF_SALARY");
            $this->db->where("ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ESS_SALARY_COMMENTS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ESS_SALARY_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==82)//INVOICE FORM -STAFF
        {
            $this->db->select("ES_INVOICE_FROM");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_INVOICE_FROM IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_INVOICE_FROM'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==83)//INVOICE FORM -STAFF
        {
            $this->db->select("ES_INVOICE_ITEMS");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_INVOICE_ITEMS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_INVOICE_ITEMS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
        elseif($STDLY_SEARCH_sec_searchoption==79)//INVOICE FORM -COMMENTS
        {
            $this->db->select("ES_COMMENTS");
            $this->db->from("EXPENSE_STAFF");
            $this->db->where("ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate' AND ES_COMMENTS IS NOT NULL");
            $STDTL_SEARCH_COMMENTS = $this->db->get();
            foreach ($STDTL_SEARCH_COMMENTS->result_array() as $row)
            {
                $STDTL_SEARCH_autocomplete[]=$row['ES_COMMENTS'];
            }
            return $STDTL_SEARCH_autocomplete;
        }
    }
    //GET DATA FOR SALARY SEARCH OPTIONS.................................FROM SALARY ENTRY...........
    public function fetch_salarydata()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
//echo $STDLY_SEARCH_searchoptio;

        if($STDLY_SEARCH_searchoptio==86)
        {
//echo $STDLY_SEARCH_searchoptio;
//            exit;
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
//echo $STDLY_SEARCH_fromamount;echo $STDLY_SEARCH_toamount;
//            exit;
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_CPF_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
//            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==87)//LEVY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_LEVY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==88)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ESS.ESS_SALARY_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==91)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_FROM_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==92)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_TO_PERIOD BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
        else if($STDLY_SEARCH_searchoptio==89)//SALARY
        {
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,DATE_FORMAT(ESS.ESS_INVOICE_DATE,'%d-%m-%Y') AS INVOICE,DATE_FORMAT(ESS.ESS_TO_PERIOD,'%d-%m-%Y') AS TOPERIOD,DATE_FORMAT(ESS.ESS_FROM_PERIOD,'%d-%m-%Y') AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')");
            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
//        else if($STDLY_SEARCH_searchoptio==85)//SALARY
//        {
//            $STDLY_SEARCH_searchcomments=$_POST['STDLY_SEARCH_searchcomments'];
//            $this->db->select("ESS.ESS_ID,EDSS.EDSS_CPF_AMOUNT AS CPF,EDSS.EDSS_LEVY_AMOUNT AS LEVY,EDSS.EDSS_SALARY_AMOUNT AS SALARY,EMPDTL.EMP_FIRST_NAME AS FIRST,EMPDTL.EMP_LAST_NAME AS LAST,EDSS.EDSS_CPF_NUMBER AS CPFNO,ESS.ESS_INVOICE_DATE AS INVOICE,ESS.ESS_TO_PERIOD AS TOPERIOD,ESS.ESS_FROM_PERIOD AS FROMPERIOD,ESS.ESS_CPF_AMOUNT AS CPF,ESS.ESS_LEVY_AMOUNT AS LEY,ESS.ESS_SALARY_AMOUNT AS SALARY,ESS.ESS_SALARY_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ESS.ESS_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
//            $this->db->from('EMPLOYEE_DETAILS EMPDTL,EXPENSE_DETAIL_STAFF_SALARY EDSS,EXPENSE_STAFF_SALARY ESS,USER_LOGIN_DETAILS ULD');
//            $this->db->where("ULD.ULD_ID=ESS.ULD_ID AND (EMPDTL.EMP_ID=EDSS.EMP_ID) AND (EDSS.EDSS_ID=ESS.EDSS_ID) AND (ESS.ESS_SALARY_COMMENTS='$STDLY_SEARCH_searchcomments')");
//            $this->db->order_by("ESS.ESS_INVOICE_DATE", "ASC");
//            $query = $this->db->get();
//            return $query->result();
//        }
    }
    //INLINE SUBJECT UPDATE
    public  function update_agentdata($USERSTAMP,$id)
    {
        $STDLY_SEARCH_lbtypeofexpense=$_POST['STDLY_SEARCH_typelist'];
        if($STDLY_SEARCH_lbtypeofexpense==39)
        {
            $STDLY_SEARCH_date=$_POST['agentdate'];
            $STDLY_SEARCH_date = date('Y-m-d',strtotime($STDLY_SEARCH_date));
            $STDLY_SEARCH_commission_amount=$_POST['STDTL_SEARCH_agentcommissionamt'];
            $STDLY_SEARCH_comments=$_POST['STDLY_SEARCH_comments'];
            if($STDLY_SEARCH_comments==''){
                $STDLY_SEARCH_comments='null';
            }
            else{
                $STDLY_SEARCH_comments="'$STDLY_SEARCH_comments'";
            }
            $updatequery = "UPDATE EXPENSE_AGENT SET EA_DATE='$STDLY_SEARCH_date',EA_COMM_AMOUNT='$STDLY_SEARCH_commission_amount',EA_COMMENTS=$STDLY_SEARCH_comments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP') WHERE EA_ID='$id'";
        $this->db->query($updatequery);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        else {
            return false;
        }
        }
        if($STDLY_SEARCH_lbtypeofexpense==41)
        {
//            var STDLY_SEARCH_staffexpense_update_query = "UPDATE EXPENSE_STAFF SET ES_INVOICE_DATE='"+STDLY_SEARCH_dbinvoicedate+"',ES_INVOICE_AMOUNT='"+STDLY_SEARCH_staff_fullamount+"',ES_INVOICE_ITEMS='"+STDLY_SEARCH_tbinvoiceitems+"',ES_INVOICE_FROM='"+STDLY_SEARCH_tbinvoicefrom+"',ES_COMMENTS="+STDLY_SEARCH_tbcomments+",ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='"+UserStamp+"'),ECN_ID="+STDLY_SEARCH_lbstaffexpense+" WHERE ES_ID="+STDLY_SEARCH_esid+"";
            $STDLY_SEARCH_lbstaffexpense=$_POST['STDLY_SEARCH_lbstaffexpense'];
            $STDLY_SEARCH_selectquery= $this->db->query("SELECT EXPSTAFF.ECN_ID AS CATEGORYID FROM EXPENSE_STAFF EXPSTAFF , EXPENSE_CONFIGURATION CONFIG WHERE CONFIG.ECN_DATA='$STDLY_SEARCH_lbstaffexpense' and CONFIG.ECN_ID=EXPSTAFF.ECN_ID ");
            $STDLY_SEARCH_lbstaffexpense = $STDLY_SEARCH_selectquery->row()->CATEGORYID;
            $STDLY_SEARCH_dbinvoicedate=$_POST['STDLY_SEARCH_dbinvoicedate'];
            $STDLY_SEARCH_dbinvoicedate = date('Y-m-d',strtotime($STDLY_SEARCH_dbinvoicedate));
            $STDLY_SEARCH_staff_fullamount=$_POST['STDLY_SEARCH_staff_fullamount'];
            $STDLY_SEARCH_tbinvoiceitems=$_POST['STDLY_SEARCH_tbinvoiceitems'];
            $STDLY_SEARCH_tbinvoicefrom=$_POST['STDLY_SEARCH_tbinvoicefrom'];
            $STDLY_SEARCH_tbcomments=$_POST['STDLY_SEARCH_tbcomments'];
            if($STDLY_SEARCH_tbcomments==''){
                $STDLY_SEARCH_tbcomments='null';
            }
            else{
                $STDLY_SEARCH_tbcomments="'$STDLY_SEARCH_tbcomments'";
            }
//            echo "UPDATE EXPENSE_STAFF SET ES_INVOICE_DATE='$STDLY_SEARCH_dbinvoicedate',ES_INVOICE_AMOUNT='$STDLY_SEARCH_staff_fullamount',ES_INVOICE_ITEMS='$STDLY_SEARCH_tbinvoiceitems',ES_INVOICE_FROM='$STDLY_SEARCH_tbinvoicefrom',ES_COMMENTS=$STDLY_SEARCH_tbcomments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID='$STDLY_SEARCH_lbstaffexpense' WHERE ES_ID='$id'";
//            exit;
            $updatequery = "UPDATE EXPENSE_STAFF SET ES_INVOICE_DATE='$STDLY_SEARCH_dbinvoicedate',ES_INVOICE_AMOUNT='$STDLY_SEARCH_staff_fullamount',ES_INVOICE_ITEMS='$STDLY_SEARCH_tbinvoiceitems',ES_INVOICE_FROM='$STDLY_SEARCH_tbinvoicefrom',ES_COMMENTS=$STDLY_SEARCH_tbcomments,ULD_ID=(SELECT ULD_ID FROM USER_LOGIN_DETAILS WHERE ULD_LOGINID='$USERSTAMP'),ECN_ID='$STDLY_SEARCH_lbstaffexpense' WHERE ES_ID='$id'";
            $this->db->query($updatequery);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
            else {
                return false;
            }
        }
    }
    //GET DATA FOR SALARY SEARCH OPTIONS.................................FROM SALARY ENTRY...........
    public function fetch_staffsalarydata()
    {
        $STDLY_SEARCH_searchoptio=$_POST['STDLY_SEARCH_searchoptio'];
//echo $STDLY_SEARCH_searchoptio;

        if($STDLY_SEARCH_searchoptio==80)
        {
//echo $STDLY_SEARCH_searchoptio;
//            exit;
            $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
//echo $STDLY_SEARCH_fromamount;echo $STDLY_SEARCH_toamount;
//            exit;
            $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (EXPCONFIG.ECN_DATA='$STDLY_SEARCH_staffexpansecategory') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
            $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==84)
        {
//echo $STDLY_SEARCH_searchoptio;
//            exit;
            $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
            $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
            $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
            $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
            $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
            $STDLY_SEARCH_fromamount=$_POST['STDLY_SEARCH_fromamount'];
            $STDLY_SEARCH_toamount=$_POST['STDLY_SEARCH_toamount'];
//echo $STDLY_SEARCH_fromamount;echo $STDLY_SEARCH_toamount;
//            exit;
            $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
            $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
            $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate') AND (ES.ES_INVOICE_AMOUNT BETWEEN '$STDLY_SEARCH_fromamount' AND '$STDLY_SEARCH_toamount') AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
            $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
            $query = $this->db->get();
            return $query->result();
        }
       else if($STDLY_SEARCH_searchoptio==81)
       {
//echo $STDLY_SEARCH_searchoptio;
//            exit;
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID)");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==82)
       {
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $STDLY_SEARCH_invfromcomt=$_POST['STDLY_SEARCH_invfromcomt'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_FROM='$STDLY_SEARCH_invfromcomt') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==83)
       {
           $STDLY_SEARCH_staffexpansecategory=$_POST['STDLY_SEARCH_staffexpansecategory'];
           $STDLY_SEARCH_startdate=$_POST['STDLY_SEARCH_startdate'];
           $STDLY_SEARCH_startdate = date('Y-m-d',strtotime($STDLY_SEARCH_startdate));
           $STDLY_SEARCH_enddate=$_POST['STDLY_SEARCH_enddate'];
           $STDLY_SEARCH_enddate = date('Y-m-d',strtotime($STDLY_SEARCH_enddate));
           $STDLY_SEARCH_invitemcom=$_POST['STDLY_SEARCH_invitemcom'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID AND (ES.ES_INVOICE_DATE BETWEEN '$STDLY_SEARCH_startdate' AND '$STDLY_SEARCH_enddate')  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_INVOICE_ITEMS='$STDLY_SEARCH_invitemcom') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
       else if($STDLY_SEARCH_searchoptio==79)
       {
           $STDLY_SEARCH_searchcomments=$_POST['STDLY_SEARCH_searchcomments'];
           $this->db->select("ES.ES_ID,EXPCONFIG.ECN_DATA AS STDLY_SEARCH_type,DATE_FORMAT(ES.ES_INVOICE_DATE,'%d-%m-%Y') AS STDLY_SEARCH_date,ES.ES_INVOICE_AMOUNT AS STDLY_SEARCH_amount,ES.ES_INVOICE_ITEMS AS STDLY_SEARCH_items,ES.ES_INVOICE_FROM AS STDLY_SEARCH_from,ES.ES_COMMENTS AS COMMENTS,ULD.ULD_LOGINID AS USERSTAMP,DATE_FORMAT(CONVERT_TZ(ES.ES_TIMESTAMP,'+00:00','+05:30'), '%d-%m-%Y %T') AS timestamp");
           $this->db->from('EXPENSE_STAFF ES,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD');
           $this->db->where("ULD.ULD_ID=ES.ULD_ID  AND (EXPCONFIG.ECN_ID=ES.ECN_ID) AND (ES.ES_COMMENTS='$STDLY_SEARCH_searchcomments') ");
           $this->db->order_by("ES.ES_INVOICE_DATE", "ASC");
           $query = $this->db->get();
           return $query->result();
       }
    }
}