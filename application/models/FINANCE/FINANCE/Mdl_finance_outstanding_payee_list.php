<?php
//error_reporting(0);
class Mdl_finance_outstanding_payee_list extends CI_Model
{
    public function OPL_list_creation($UserStamp)
    {
        try
        {
                $period = $_POST['FIN_OPL_db_period'];
                $mailid = $_POST['FIN_OPL_lb_mailid'];
                $MailidSplit = explode('@', $mailid);
                $Username = strtoupper($MailidSplit[0]);
                $Maildate = strtoupper($period);
                $Option = $_POST['Radio'];
                if ($Option == 'OPL_list') {
                    $EmilTemplateSelectQuery = "SELECT ETD_EMAIL_SUBJECT,ETD_EMAIL_BODY FROM EMAIL_TEMPLATE_DETAILS WHERE ET_ID=6";
                    $result = $this->db->query($EmilTemplateSelectQuery);
                    foreach ($result->result_array() as $key => $val) {
                        $Email_sub = $val['ETD_EMAIL_SUBJECT'];
                        $Email_Body = $val['ETD_EMAIL_BODY'];
                    }
                    $flag = 0;
                    $Email_sub = str_replace("[MM-YYYY]", $Maildate, $Email_sub);
                    $Email_Body = str_replace("[MM-YYYY]", $Maildate, $Email_Body);
                    $Email_Body = str_replace("[MAILID_USERNAME]", $Username, $Email_Body);
                    $FIN_OPL_message = '<body><br><h> ' . $Email_Body . '</h><br><br><table border="1" style="color:white" width="800"><tr  bgcolor=" #498af3" align="center" ><td  width=50%><h3>UNIT-CUSTOMER</h3></td><td width=15%><h3>RENT</h3></td><td width=15%><h3>DEPOSIT</h3></td><td width=20%><h3>PROCESSING FEE</h3></td></tr></table></body>';
                    $OPLSelectQuery = "CALL SP_OUTSTANDING_PAYMENTLIST('$period','$UserStamp',@TEMP_FINAL_NONPAIDCUSTOMER)";
                    $this->db->query($OPLSelectQuery);
                    $outparm_query = 'SELECT @TEMP_FINAL_NONPAIDCUSTOMER AS TEMP_TABLE';
                    $outparm_result = $this->db->query($outparm_query);
                    $csrc_tablename = $outparm_result->row()->TEMP_TABLE;
                    $FIN_OPL_listquery = "SELECT *FROM $csrc_tablename ORDER BY UNIT_NO,CUSTOMERNAME";
                    $result = $this->db->query($FIN_OPL_listquery);
                    foreach ($result->result_array() as $key => $value) {
                        $flag = 1;
                        $unit = $value["UNIT_NO"];
                        $customername = $value["CUSTOMERNAME"];
                        $enddate = $value["FINAL_ENDDATE"];
                        $payment = $value["PAYMENT"];
                        if ($payment == "NULL") {
                            $payment = " ";
                        }
                        $deposit = $value["DEPOSIT"];
                        if ($deposit == "NULL") {
                            $deposit = " ";
                        }
                        $process = $value["PROCESSINGFEE"];
                        if ($process == "NULL") {
                            $process = " ";
                        }
                        if ($enddate != null) {
                            $enddate = date('d-m-Y', strtotime($enddate));
                            $opldataname = $unit . '-' . $customername;//.'  -  '.$enddate;
                        } else {
                            $opldataname = $unit . '-' . $customername;
                        }
                        $opldataname = str_replace('_', ' ', $opldataname);
                        if (($payment == 'X') && ($deposit == "X") && ($process == "X")) {

                            $FIN_OPL_message .= '<body><table border="1"width="800" ><tr><td bgcolor="#FF0000" width="50%">' . $opldataname . '<span style="background-color:red;color:white">' . $enddate . '</span></td><td width=15% align="center">' . $payment . '</td><td width=15% align="center">' . $deposit . '</td><td width=20% align="center">' . $process . '</td></tr></table></body>';
                        } else {
                            $FIN_OPL_message .= '<body><table border="1"width="800" ><tr><td width="50%">' . $opldataname . '<span style="background-color:red;color:white">' . $enddate . '</span></td><td width=15% align="center">' . $payment . '</td><td width=15% align="center">' . $deposit . '</td><td width=20% align="center">' . $process . '</td></tr></table></body>';
                        }
                    }
                    $this->db->query('DROP TABLE IF EXISTS ' . $csrc_tablename);
                    $returnMessage = array($Email_sub, $FIN_OPL_message, $flag, $Option);
                    return $returnMessage;
                } else {
                    $flag = 1;
                    $period = $_POST['FIN_OPL_db_period'];
                    $activecclist = "CALL SP_ACTIVE_CUSTOMERLIST('$period','$UserStamp',@TEMP_OPL_ACTIVECUSTOMER_TABLE,@TEMP_OPL_SORTEDACTIVECUSTOMER_TABLE)";
                    $this->db->query($activecclist);
                    $outparm_query = 'SELECT @TEMP_OPL_ACTIVECUSTOMER_TABLE AS TEMP_TABLE1,@TEMP_OPL_SORTEDACTIVECUSTOMER_TABLE AS TEMP_TABLE2';
                    $outparm_result = $this->db->query($outparm_query);
                    $activelisttablename = $outparm_result->row()->TEMP_TABLE1;
                    $sortactivelisttablename = $outparm_result->row()->TEMP_TABLE2;
                    $FIN_Active_listquery = "SELECT *FROM $activelisttablename ORDER BY UNIT_NO,CUSTOMERNAME";
                    $result1 = $this->db->query($FIN_Active_listquery);
                    $numrows=$this->db->affected_rows();
                    $FIN_Active_sortlistquery = "SELECT *FROM $sortactivelisttablename ORDER BY UNIT_NO,CUSTOMERNAME";
                    $sortresult = $this->db->query($FIN_Active_sortlistquery);
                    $sortnumrows=$this->db->affected_rows();
                    $headerdata='UNIT,CUSTOMER,STARTDATE,ENDDATE,RENT,DEPOSIT,PROCESSING FEE,TERMINATE,PRE TERMINATE,PRE TERMINATE DATE,COMMENTS';
                    $FIN_ACT_folresult=$this->db->query("SELECT PCN_DATA FROM PAYMENT_CONFIGURATION WHERE CGN_ID=49");
                    $folderid=$FIN_ACT_folresult->row()->PCN_DATA;
                    $this->load->library('Google');
                    $this->load->model('EILIB/Mdl_eilib_common_function');
                    $service = $this->Mdl_eilib_common_function->get_service_document();
                    $this->load->model('EILIB/Mdl_eilib_common_function');
                    $FILEID=$this->Mdl_eilib_common_function->NewSpreadsheetCreation($service, 'ACTIVE CC LIST', 'CUSTOMER_DETAILS', $folderid);
                    $ActiveCustomerList = array('ACtiveflag'=>10,'header'=>$headerdata,"Rows"=>$numrows,"period"=>$period,"SortRows"=>$sortnumrows,"Fileid"=>$FILEID);
                    $i = 0;
                    foreach ($result1->result_array() as $key => $value) {
                        $key = 'data'.$i;
                        $unit = $value["UNIT_NO"];
                        $customername = $value["CUSTOMERNAME"];
                        $Startdate = $value["STARTDATE"];
                        $Enddate = $value["ENDDATE"];
                        $Payment = $value["PAYMENT_AMOUNT"];
                        $Deposit = $value["DEPOSIT"];
                        $ProcessingFee = $value['PROCESSING_FEE'];
                        $Terminate = $value['CLP_TERMINATE'];
                        $Preterminate = $value['PRETERMINATE'];
                        $Preterminatedate = $value['PRETERMINATEDATE'];
                        $Comments = $value['COMMENTS'];
                        $data = $unit . '!~' . $customername . '!~' . $Startdate . '!~' . $Enddate . '!~' . $Payment . '!~' . $Deposit . '!~' . $ProcessingFee . '!~' . $Terminate . '!~' . $Preterminate . '!~' . $Preterminatedate . '!~' . $Comments;
                        $ActiveCustomerList[$key] = $data;
                        $i++;
                    }
                    $i = 0;
                    foreach ($sortresult->result_array() as $key => $value) {
                        $key = 'sortdata'.$i;
                        $unit = $value["UNIT_NO"];
                        $customername = $value["CUSTOMERNAME"];
                        $Startdate = $value["STARTDATE"];
                        $Enddate = $value["ENDDATE"];
                        $Payment = $value["PAYMENT_AMOUNT"];
                        $Deposit = $value["DEPOSIT"];
                        $ProcessingFee = $value['PROCESSING_FEE'];
                        $Terminate = $value['CLP_TERMINATE'];
                        $Preterminate = $value['PRETERMINATE'];
                        $Preterminatedate = $value['PRETERMINATEDATE'];
                        $Comments = $value['COMMENTS'];
                        $data = $unit . '!~' . $customername . '!~' . $Startdate . '!~' . $Enddate . '!~' . $Payment . '!~' . $Deposit . '!~' . $ProcessingFee . '!~' . $Terminate . '!~' . $Preterminate . '!~' . $Preterminatedate . '!~' . $Comments;
                        $ActiveCustomerList[$key] = $data;
                        $i++;
                    }
                    $this->db->query('DROP TABLE IF EXISTS ' . $activelisttablename);
                    $this->db->query('DROP TABLE IF EXISTS ' . $sortactivelisttablename);
                    $Returnvalue=$this->Mdl_eilib_common_function->Func_curl($ActiveCustomerList);
                    $temptable = array($Returnvalue, $Username, $Maildate);
                    return $temptable;
                }
            }
            catch (Exception $e)
            {
                return $e->getMessage();

            }
        }

}