<?php

Class Pdf_model extends CI_Model
{
public function Pdfexport($PDLY_SEARCH_typelistvalue,$PDLY_SEARCH_startdate,$PDLY_SEARCH_enddate,$PDLY_SEARCH_babysearchoption,$PDLY_SEARCH_fromamount,$PDLY_SEARCH_toamount,$PDLY_SEARCH_searchcomments,$PDLY_SEARCH_invitemcom,$PDLY_SEARCH_invfromcomt,$PDLY_SEARCH_babycategory)
{
if($PDLY_SEARCH_typelistvalue==36)
{

$PDLY_SEARCH_selectquery[56]=$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[52] =$this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[51] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[53] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPBABY.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[55]= $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID,  DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"),"%d-%m-%Y %T") AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[54] = $this->db->query('SELECT EXPBABY.EB_ID,EXPBABY.EB_INVOICE_DATE,EXPBABY.EB_AMOUNT,EXPBABY.EB_INVOICE_ITEMS,EXPBABY.EB_INVOICE_FROM,EXPBABY.EB_COMMENTS,ULD.ULD_LOGINID, DATE_FORMAT(CONVERT_TZ(EXPBABY.EB_TIMESTAMP,"+00:00","+08:00"),"%d-%m-%Y %T")  AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_BABY EXPBABY,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPBABY.ULD_ID AND (EXPBABY.EB_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPBABY.EB_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPBABY.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPBABY.EB_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==35)
{
$PDLY_SEARCH_selectquery[62] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_COMMENTS ="'.$PDLY_SEARCH_searchcomments.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[58] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID)ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[57] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" )AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_AMOUNT BETWEEN  "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[59] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPCAR.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[61] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[60] = $this->db->query('SELECT EXPCAR.EC_ID,EXPCAR.EC_INVOICE_DATE,EXPCAR.EC_AMOUNT,EXPCAR.EC_INVOICE_ITEMS,EXPCAR.EC_INVOICE_FROM,EXPCAR.EC_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPCAR.EC_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_CAR EXPCAR,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPCAR.ULD_ID AND (EXPCAR.EC_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCAR.EC_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'")AND (EXPCAR.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPCAR.EC_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==37)
{
$PDLY_SEARCH_selectquery[73] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_COMMENTS="'.$PDLY_SEARCH_searchcomments.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[69] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_DATA="'.$PDLY_SEARCH_babycategory.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID)ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[68] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[70] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPCONFIG.ECN_ID=EXPPERSONAL.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[72] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_FROM="'.$PDLY_SEARCH_invfromcomt.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
$PDLY_SEARCH_selectquery[71] = $this->db->query('SELECT EXPPERSONAL.EP_ID,EXPPERSONAL.EP_INVOICE_DATE,EXPPERSONAL.EP_AMOUNT,EXPPERSONAL.EP_INVOICE_ITEMS,EXPPERSONAL.EP_INVOICE_FROM,EXPPERSONAL.EP_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPPERSONAL.EP_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP,EXPCONFIG.ECN_DATA FROM EXPENSE_PERSONAL EXPPERSONAL,EXPENSE_CONFIGURATION EXPCONFIG ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPPERSONAL.ULD_ID AND (EXPPERSONAL.EP_INVOICE_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (EXPPERSONAL.EP_INVOICE_ITEMS="'.$PDLY_SEARCH_invitemcom.'") AND (EXPPERSONAL.ECN_ID=EXPCONFIG.ECN_ID) ORDER BY EXPPERSONAL.EP_INVOICE_DATE ASC');
}
if($PDLY_SEARCH_typelistvalue==38)
{
$PDLY_SEARCH_selectquery[65] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_AMOUNT BETWEEN "'.$PDLY_SEARCH_fromamount.'" AND "'.$PDLY_SEARCH_toamount.'")ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[67] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") AND (ECL_COMMENTS="'.$PDLY_SEARCH_searchcomments.'")ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[63] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_PAID_DATE BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[66] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_FROM_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
$PDLY_SEARCH_selectquery[64] = $this->db->query('SELECT EXPENSE_CAR_LOAN.ECL_ID,EXPENSE_CAR_LOAN.ECL_PAID_DATE,EXPENSE_CAR_LOAN.ECL_AMOUNT,EXPENSE_CAR_LOAN.ECL_TO_PERIOD,EXPENSE_CAR_LOAN.ECL_FROM_PERIOD,EXPENSE_CAR_LOAN.ECL_COMMENTS,ULD.ULD_LOGINID,DATE_FORMAT(CONVERT_TZ(EXPENSE_CAR_LOAN.ECL_TIMESTAMP,"+00:00","+08:00"), "%d-%m-%Y %T" ) AS TIMESTMP FROM EXPENSE_CAR_LOAN ,USER_LOGIN_DETAILS ULD WHERE ULD.ULD_ID=EXPENSE_CAR_LOAN.ULD_ID AND (ECL_TO_PERIOD BETWEEN "'.$PDLY_SEARCH_startdate.'" AND "'.$PDLY_SEARCH_enddate.'") ORDER BY ECL_PAID_DATE ASC');
}
$arrayvalues= $PDLY_SEARCH_selectquery[$PDLY_SEARCH_babysearchoption];
    $PDLY_SEARCH_babytable_header='';
    if($PDLY_SEARCH_typelistvalue==36)
    {
        $PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF BABY EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;" >INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $ebcategory=$row['ECN_DATA'];
            $eb_invoicedate=$row['EB_INVOICE_DATE'];
            $eb_invoicedate=date('d-m-Y',strtotime($eb_invoicedate));
            $eb_invoceamount=$row['EB_AMOUNT'];
            $eb_invoicefrom=$row['EB_INVOICE_FROM'];
            $eb_invoiceitem=$row['EB_INVOICE_ITEMS'];
            $eb_comments=$row['EB_COMMENTS'];
            if($eb_comments==null){$eb_comments='';}
            $eb_userstamp=$row['ULD_LOGINID'];
            $eb_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$ebcategory.'</td><td>'.$eb_invoicedate.'</td><td>'.$eb_invoceamount.'</td><td>'.$eb_invoicefrom.'</td><td>'.$eb_invoiceitem.'</td><td>'.$eb_comments.'</td><td>'.$eb_userstamp.'</td><td nowrap>'.$eb_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==35)
    {
        $PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1" style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF CAR EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $eccategory=$row['ECN_DATA'];
            $ec_invoicedate=$row['EC_INVOICE_DATE'];
            $ec_invoicedate=date('d-m-Y',strtotime($ec_invoicedate));
            $ec_invoceamount=$row['EC_AMOUNT'];
            $ec_invoicefrom=$row['EC_INVOICE_FROM'];
            $ec_invoiceitem=$row['EC_INVOICE_ITEMS'];
            $ec_comments=$row['EC_COMMENTS'];
            if($ec_comments==null){$ec_comments='';}
            $ec_userstamp=$row['ULD_LOGINID'];
            $ec_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$eccategory.'</td><td>'.$ec_invoicedate.'</td><td>'.$ec_invoceamount.'</td><td>'.$ec_invoicefrom.'</td><td>'.$ec_invoiceitem.'</td><td>'.$ec_comments.'</td><td>'.$ec_userstamp.'</td><td nowrap>'.$ec_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==37)
    {
        $PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TYPE OF PERSONAL EXPENSE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">INVOICE DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE FROM</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:200px;font-weight: bold;">INVOICE ITEMS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';
        foreach ($arrayvalues->result_array() as $row)
        {
            $epcategory=$row['ECN_DATA'];
            $ep_invoicedate=$row['EP_INVOICE_DATE'];
            $ep_invoicedate=date('d-m-Y',strtotime($ep_invoicedate));
            $ep_invoceamount=$row['EP_AMOUNT'];
            $ep_invoicefrom=$row['EP_INVOICE_FROM'];
            $ep_invoiceitem=$row['EP_INVOICE_ITEMS'];
            $ep_comments=$row['EP_COMMENTS'];
            if($ep_comments==null){$ep_comments='';}
            $ep_userstamp=$row['ULD_LOGINID'];
            $ep_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$epcategory.'</td><td>'.$ep_invoicedate.'</td><td>'.$ep_invoceamount.'</td><td>'.$ep_invoicefrom.'</td><td>'.$ep_invoiceitem.'</td><td>'.$ep_comments.'</td><td>'.$ep_userstamp.'</td><td nowrap>'.$ep_timestamp.'</td></tr>';
        }
        $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    if($PDLY_SEARCH_typelistvalue==38)
    {
    $PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  style="border-collapse: collapse;" cellspacing="0" data-class="table" class="srcresult"><thead><tr><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">PAID DATE</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:60px;font-weight: bold;">INVOICE AMOUNT</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">FROM PERIOD</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:75px;font-weight: bold;">TO PERIOD</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:230px;font-weight: bold;">COMMENTS</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:250px;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;width:150px;font-weight: bold;">TIMESTAMP</th></tr></thead><tbody>';

        foreach ($arrayvalues->result_array() as $row)
        {
            $eclpaiddate=$row['ECL_PAID_DATE'];
            $eclpaiddate=date('d-m-Y',strtotime($eclpaiddate));
            $eclfromperiod=$row['ECL_FROM_PERIOD'];
            $eclfromperiod=date('d-m-Y',strtotime($eclfromperiod));
            $eclTPeriod=$row['ECL_TO_PERIOD'];
            $eclTPeriod=date('d-m-Y',strtotime($eclTPeriod));
            $ecl_invoceamount=$row['ECL_AMOUNT'];
            $ecl_comments=$row['ECL_COMMENTS'];
            if($ecl_comments==null){$ecl_comments='';}
            $ecl_userstamp=$row['ULD_LOGINID'];
            $ecl_timestamp=$row['TIMESTMP'];
            $PDLY_SEARCH_babytable_header.='<tr><td>'.$eclpaiddate.'</td><td>'.$ecl_invoceamount.'</td><td nowrap>'.$eclfromperiod.'</td><td nowrap>'.$eclTPeriod.'</td><td>'.$ecl_comments.'</td><td>'.$ecl_userstamp.'</td><td nowrap>'.$ecl_timestamp.'</td></tr>';
        }
            $PDLY_SEARCH_babytable_header.='</tbody></table>';
    }
    return $PDLY_SEARCH_babytable_header;

}
}