<?php
class Mdl_ocbcmodel extends CI_Model
{
    Public function getOCBCData($Period)
    {
        $SplittedPeriod=explode('-',$Period);
        $string = $SplittedPeriod[0];
        $month_number = date("n",strtotime($string));
        if($month_number<10)
        { $month_number='0'.$month_number; }
        $Forperiod=$SplittedPeriod[1].'-'.$month_number.'%';
        $SelectQuery="SELECT OBR.OBR_ID,OCA.OCN_DATA AS CURRENCY,OCB.OCN_DATA AS ACCOUNT,OBR.OBR_OPENING_BALANCE,OBR.OBR_CLOSING_BALANCE,OBR.OBR_PREVIOUS_BALANCE,OBR.OBR_LAST_BALANCE,OBR.OBR_OLD_BALANCE,OBR.OBR_NO_OF_CREDITS,OBR.OBR_NO_OF_DEBITS,DATE_FORMAT(OBR.OBR_POST_DATE,'%d-%m-%Y')AS OBR_POST_DATE,DATE_FORMAT(OBR.OBR_TRANS_DATE,'%d-%m-%Y')AS OBR_TRANS_DATE,DATE_FORMAT(OBR.OBR_VALUE_DATE,'%d-%m-%Y')AS OBR_VALUE_DATE,OBR.OBR_D_AMOUNT,OBR.OBR_DEBIT_AMOUNT,OBR.OBR_CREDIT_AMOUNT,OCN.OCN_DATA,OBR.OBR_CLIENT_REFERENCE,OBR.OBR_TRANSACTION_DESC_DETAILS,OBR.OBR_BANK_REFERENCE,OBR.OBR_TRX_TYPE,OBR.OBR_REFERENCE FROM OCBC_CONFIGURATION OCN,OCBC_BANK_RECORDS OBR LEFT JOIN OCBC_CONFIGURATION OCA ON OBR.OBR_CURRENCY=OCA.OCN_ID LEFT JOIN OCBC_CONFIGURATION OCB ON OBR.OBR_ACCOUNT_NUMBER=OCB.OCN_ID  WHERE OBR.OCN_ID=OCN.OCN_ID AND((OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_TRANS_DATE LIKE '$Forperiod') OR (OBR.OBR_POST_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')OR(OBR.OBR_TRANS_DATE LIKE '$Forperiod' AND OBR.OBR_VALUE_DATE LIKE '$Forperiod')) ORDER BY OBR.OBR_VALUE_DATE,OBR_REF_ID";
        $resultset=$this->db->query($SelectQuery);
        return $resultset->result();
    }
    public function RecordSave($unit,$customerid,$recver,$payment,$amount,$period,$comments,$flag,$id,$UserStamp)
    {
      $CallQuery="CALL SP_OCBC_PAYMENT_DETAIL_INSERT('$unit','$customerid','$recver','$payment','$amount','$flag','$period','$comments','$UserStamp','$id',@FINAL_MESSAGE)";
      $this->db->query($CallQuery);
      $outparm_query = 'SELECT @FINAL_MESSAGE AS TEMP_TABLE';
      $outparm_result = $this->db->query($outparm_query);
      $Confirm_Meessage=$outparm_result->row()->TEMP_TABLE;
      return $Confirm_Meessage;
    }
}