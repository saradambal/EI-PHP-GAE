<?php
/**
/*********************************************GLOBAL DECLARATION******************************************-->
//*********************************************************************************************************/
//*******************************************FILE DESCRIPTION*********************************************//
//****************************************USER SEARCH DETAILS*************************************************//
//DONE BY:safi
//VER 0.01-INITIAL VERSION,SD:19/05/2015 ED:19/05/2015
//******************************************************************************************************

class Mdl_access_rights_user_search_details extends  CI_Model{

    public  function USD_SRC_flextable_getdatas($timeZoneFormat){
        $errormessages=array();
        $this->load->model('EILIB/Mdl_eilib_common_function');
        $URD_SRC_errorarray=$this->Mdl_eilib_common_function->getErrorMessageList('355');
        //FETCHING USER LOGIN DETAILS RECORDS
        $this->db->select("UA.UA_ID,ULD.ULD_LOGINID,RC.RC_NAME,UA.UA_REC_VER,UA.UA_REASON,UA.UA_USERSTAMP,DATE_FORMAT(UA.UA_JOIN_DATE,'%d-%m-%Y') AS UA_JOIN_DATE,DATE_FORMAT(UA.UA_END_DATE,'%d-%m-%Y') AS UA_END_DATE,DATE_FORMAT(CONVERT_TZ(UA.UA_TIMESTAMP,".$timeZoneFormat."),'%d-%m-%Y %T')  AS TIMESTAMP");
        $this->db->from("USER_RIGHTS_CONFIGURATION URC");
        $this->db->join("ROLE_CREATION RC","URC.URC_ID=RC.URC_ID");
        $this->db->join("USER_ACCESS UA","UA.RC_ID=RC.RC_ID");
        $this->db->join("USER_LOGIN_DETAILS ULD","ULD.ULD_ID=UA.ULD_ID");
        $this->db->order_by("ULD.ULD_LOGINID");
        $USD_SRC_flextable_query=$this->db->get();
        $ure_values=array();
        $final_values=array();
        foreach($USD_SRC_flextable_query->result_array() as $row){
            $USD_SRC_loginid=$row["ULD_LOGINID"];
            $USD_SRC_rcid=$row["RC_NAME"];
            $USD_SRC_recver=$row["UA_REC_VER"];
            $USD_SRC_joindate=$row["UA_JOIN_DATE"];
            $USD_SRC_enddate=$row["UA_END_DATE"];
            $USD_SRC_reason=$row["UA_REASON"];
            $USD_SRC_userstamp=$row["UA_USERSTAMP"];
            $USD_SRC_timestamp=$row["TIMESTAMP"];
            $final_values=(object)['loginid' =>$USD_SRC_loginid,'rcid' =>$USD_SRC_rcid,'recordver'=>$USD_SRC_recver,'joindate'=>$USD_SRC_joindate,'terminationdate'=>$USD_SRC_enddate,'reasonoftermination'=>$USD_SRC_reason,'userstamp'=>$USD_SRC_userstamp,'timestamp'=>$USD_SRC_timestamp];
            $ure_values[]=$final_values;
        }
        $finalvalue=array($ure_values,$URD_SRC_errorarray);
        return $finalvalue;
    }
    public  function  User_Details_pdf($timeZoneFormat){
        $values=$this->USD_SRC_flextable_getdatas($timeZoneFormat);
        $values_array=$values[0];
        $USU_table_header='<table id="USD_SRC_SRC_tble_htmltable" border="1"  cellspacing="0" class="srcresult" style="width:2000px" style="border-collapse: collapse;" ><sethtmlpageheader name="header" page="all" value="on" show-this-page="1"/><thead  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;"><tr><th nowrap style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">LOGIN ID</th><th style="width: 50px" style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;" nowrap>ROLE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">REC VER</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">JOIN DATE</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">TERMINATION DATE</th><th style="width:850px;" style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">REASON OF TERMINATION</th><th style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;">USERSTAMP</th><th  style="color:#fff !important; background-color:#498af3;text-align:center;font-weight: bold;" nowrap>TIMESTAMP</th></tr></thead><tbody>';
        for($j=0;$j<count($values[0]);$j++){
                $USD_SRC_loginid=$values_array[$j]->loginid;
                $USD_SRC_rcid=$values_array[$j]->rcid;
                $USD_SRC_recordver=$values_array[$j]->recordver;
                $USD_SRC_joindate=$values_array[$j]->joindate;
                $USD_SRC_terminationdate=$values_array[$j]->terminationdate;
                if(($USD_SRC_terminationdate=='null')||($USD_SRC_terminationdate=='undefined'))
                {
                    $USD_SRC_terminationdate='';
                }
                $USD_SRC_reasonoftermination=$values_array[$j]->reasonoftermination;
                if(($USD_SRC_reasonoftermination=='null')||($USD_SRC_reasonoftermination=='undefined'))
                {
                    $USD_SRC_reasonoftermination='';
                }
                $USD_SRC_userstamp=$values_array[$j]->userstamp;
                $USD_SRC_timestamp=$values_array[$j]->timestamp;
                $USU_table_header.='<tr><td nowrap>'.$USD_SRC_loginid.'</td><td align="center" style="width:100px;" nowrap>'.$USD_SRC_rcid.'</td><td align="center">'.$USD_SRC_recordver.'</td><td nowrap align="center">'.$USD_SRC_joindate.'</td><td style="width:10px;" align="center">'.$USD_SRC_terminationdate.'</td><td style="width:850px;">'.$USD_SRC_reasonoftermination.'</td><td align="center">'.$USD_SRC_userstamp.'</td><td  style="min-width:150px;" align="center" nowrap>'.$USD_SRC_timestamp.'</td></tr>';
        }
        $USU_table_header.='</tbody></table>';
        return $USU_table_header;
    }

} 