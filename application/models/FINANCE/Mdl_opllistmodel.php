<?php
//error_reporting(0);
class Mdl_opllistmodel extends CI_Model
{
    public function OPL_list_creation($UserStamp)
    {
        $period=$_POST['FIN_OPL_db_period'];
        $mailid=$_POST['FIN_OPL_lb_mailid'];
        $MailidSplit=explode('@',$mailid);
        $Username = strtoupper($MailidSplit[0]);
        $Maildate=strtoupper($period);
        $Option=$_POST['Radio'];
        if($Option=='OPL_list')
        {
            $EmilTemplateSelectQuery="SELECT ETD_EMAIL_SUBJECT,ETD_EMAIL_BODY FROM EMAIL_TEMPLATE_DETAILS WHERE ET_ID=6";
            $result = $this->db->query($EmilTemplateSelectQuery);
            foreach ($result->result_array() as $key=>$val)
            {
                $Email_sub=$val['ETD_EMAIL_SUBJECT'];
                $Email_Body=$val['ETD_EMAIL_BODY'];
            }
            $Email_sub=str_replace("[MM-YYYY]",$Maildate,$Email_sub);
            $Email_Body=str_replace("[MM-YYYY]",$Maildate,$Email_Body);
            $Email_Body=str_replace("[MAILID_USERNAME]",$Username,$Email_Body);
            $FIN_OPL_message = '<body><br><h> '.$Email_Body.'</h><br><br><table border="1" style="color:white" width="800"><tr  bgcolor=" #498af3" align="center" ><td  width=50%><h3>UNIT-CUSTOMER</h3></td><td width=15%><h3>RENT</h3></td><td width=15%><h3>DEPOSIT</h3></td><td width=20%><h3>PROCESSING FEE</h3></td></tr></table></body>';
            $OPLSelectQuery="CALL SP_OUTSTANDING_PAYMENTLIST('$period','$UserStamp',@TEMP_FINAL_NONPAIDCUSTOMER)";
            $this->db->query($OPLSelectQuery);
            $outparm_query = 'SELECT @TEMP_FINAL_NONPAIDCUSTOMER AS TEMP_TABLE';
            $outparm_result = $this->db->query($outparm_query);
            $csrc_tablename=$outparm_result->row()->TEMP_TABLE;
            $FIN_OPL_listquery="SELECT *FROM $csrc_tablename ORDER BY UNIT_NO,CUSTOMERNAME";
            $result = $this->db->query($FIN_OPL_listquery);

            foreach ($result->result_array() as $key=>$value)
            {
                $unit=$value["UNIT_NO"];
                $customername=$value["CUSTOMERNAME"];
                $enddate=$value["FINAL_ENDDAT"];
                $payment=$value["PAYMENT"];
                if($payment=="NULL"){$payment=" ";}
                $deposit=$value["DEPOSIT"];
                if($deposit=="NULL"){$deposit=" ";}
                $process=$value["PROCESSINGFEE"];
                if($process=="NULL"){$process=" ";}
                if($enddate!=null)
                {
                    $enddate=date('d-m-Y',strtotime($enddate));
                    $opldataname=$unit.'-'.$customername.'  -  '.$enddate;
                }
                else
                {
                    $opldataname=$unit.'-'.$customername;
                }
                $opldataname=str_replace('_',' ',$opldataname);
                if(($payment=='X')&&($deposit=="X")&&($process=="X"))
                {
                    $FIN_OPL_message .='<body><table border="1"width="800" ><tr><td bgcolor="#FF0000" width="50%">'.$opldataname.'</td><td width=15% align="center">'.$payment.'</td><td width=15% align="center">'.$deposit.'</td><td width=20% align="center">'.$process.'</td></tr></table></body>';
                }
                else
                {
                   $FIN_OPL_message .='<body><table border="1"width="800" ><tr><td width="50%">'.$opldataname.'</td><td width=15% align="center">'.$payment.'</td><td width=15% align="center">'.$deposit.'</td><td width=20% align="center">'.$process.'</td></tr></table></body>';
                }
            }
            $returnMessage=array($Email_sub,$FIN_OPL_message);
            return $returnMessage;
        }
        else
        {
          return "NOT IMPLEMENTED";
        }

    }
}