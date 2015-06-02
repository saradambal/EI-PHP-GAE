<?php
/**
 * Created by PhpStorm.
 * User: SSOMENS-021
 * Date: 12/5/15
 * Time: 1:30 PM
 */
//******************************************FOR PERIOD VALIDATION********************************************//
//DONE BY:SARADAMBAL
//VER 0.01-SD:13/05/2015 ED:13/02/2015,COMPLETED FOR PERIOD VALIDATION
//*******************************************************************************************************//
class ForPeriodValidation extends CI_Model {
//PAYMENT FORPERIOD TERMINATED CUSTOMER VALIDATION
 public  function Payment_forperiod_TermCustvalidation($unit,$customer)
{
    $queryCustomer=$this->db->query("SELECT DISTINCT CED.CED_REC_VER,DATE_FORMAT(CTD.CLP_STARTDATE,'%d-%m-%Y'),IF(CTD.CLP_PRETERMINATE_DATE IS NULL,DATE_FORMAT(CTD.CLP_ENDDATE,'%d-%m-%Y') ,DATE_FORMAT(CTD.CLP_PRETERMINATE_DATE,'%d-%m-%Y')) AS ENDDATE FROM CUSTOMER_LP_DETAILS CTD,CUSTOMER_ENTRY_DETAILS CED,CUSTOMER C WHERE CED.CUSTOMER_ID=CTD.CUSTOMER_ID AND CED.CED_REC_VER=CTD.CED_REC_VER AND C.CUSTOMER_ID=CED.CUSTOMER_ID AND C.CUSTOMER_ID='".$customer."' AND CTD.CLP_GUEST_CARD IS NULL AND CED.UNIT_ID=(SELECT UNIT_ID FROM UNIT WHERE UNIT_NO='".$unit."') ORDER BY CTD.CED_REC_VER ASC");
    return array($queryCustomer->row_array(),$customer,$this->FIN_paiddate_validation($customer));
}
//PAYMENT FORPERIOD ACTIVE CUSTOMER VALIDATION
   public function Payment_forperiod_ActiveCustvalidation($unit,$customerid)
{
    $this->db->select("DATE_FORMAT(CLP_STARTDATE,'%d-%m-%Y') ,IF(CLP_PRETERMINATE_DATE IS NULL,DATE_FORMAT(CLP_ENDDATE,'%d-%m-%Y') ,DATE_FORMAT(CLP_PRETERMINATE_DATE,'%d-%m-%Y')) AS ENDDATE ,CED_REC_VER");
    $this->db->from('VW_CURRENT_ACTIVE_CUSTOMER');
    $this->db->where("CUSTOMER_ID=".$customerid." AND UNIT_NO=".$unit);
    $this->db->order_by("CED_REC_VER", "ASC");
    return array($this->db->get()->result_array(),$this->FIN_paiddate_validation($customerid));
}
 public function FIN_paiddate_validation($customerid)
{
    $this->db->select("CLP_STARTDATE");
    $this->db->from('CUSTOMER_LP_DETAILS');
    $this->db->where('CUSTOMER_ID',$customerid);
    $this->db->order_by("CED_REC_VER", "ASC LIMIT 1");
    return $this->db->get()->first_row('array')['CLP_STARTDATE'];
}
}