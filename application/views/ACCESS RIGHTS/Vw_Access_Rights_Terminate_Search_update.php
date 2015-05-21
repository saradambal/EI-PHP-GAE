<!--*********************************************************************************************************//-->
<!--//*******************************************FILE DESCRIPTION*********************************************//
//************************************ACCESS RIGHTS_TERMINATE-SEARCH/UPDATE***********************************************//
//DONE BY PUNI
//VER 1.1 -SD:22/12/2014,ED:22/12/2014,TRACKER NO:840,added drop table function from eilib to avoid temp table drop issue for pf
//VER 1.0-SD:24/09/2014 ED:26/09/2014;TRACKER NO 465;1.trimmed script fr the repeatd functions,2.corrected validation in search /update option,3.corrected search update query,4.implemented rollback n commit,5.changed driveapp to docslist to remove editors,6.changed preloader n msgbox position,7.changed new lib links,8.added AG fr textarea
//DONE BY SAFI,SARADA
//VER 0.09-SD:21/07/2014 ED:21/07/2014;TRACKER NO 465;UPDATED DRIVEAPP AS DOCSLIST FOR SHARING/UNSHARING DOCS
//VER 0.08-SD:05/07/2014 ED:05/07/2014;TRACKER NO:465;UPDATED CUSTOMER MSG AND SHARED TEMPLATE FOLDER 
//VER 0.07-SD:11/06/2014 ED:12/06/2014:TRACKER NO:465;UPDATED FAILURE HANDLER AND IMPLEMENT SUPER ADMIN NOT TO TERMINATE
//VER 0.06-SD:06/06/2014 ED:06/06/2014;TRACKER NO:465;CHANGED JQUERY LINK
//VER 0.05-SD:27/05/2014 ED:31/05/2014;TRACKER NO:465-IMPLEMENT UNSHARE CAL,DOCS,SITE WHILE LONGIN TERMINATE
//ver 0.04- SD:15/05/2014,ED:15/05/2014;TRACKER NO:465-IMPLEMENT CALENDER SHARING AND DYANAMIC SP-SAFI
//VER 0.03-TRACKER NO:465,SD:12/03/2014,ED:13/01/2014-implement sql enhancement.apply sp for rejoin and terminate login id by safiyullah
//VER 0.02 TRACKER NO:465,SD:13/01/2014,ED:13/01/2014-Added Custom role wile rejoin by safiyullah
//VER 0.01-INITIAL VERSION,TRACKER NO:465,SD:03/12/2013,ED:10/12/2013-sarada-->
<?php

include "Header.php";

?>

<html>
<head>

<script>


/*-------------------------------------FUNCTION FOR CHANGE DATE FORMAT---------------------------*/
function FormTableDateFormat(URT_SRC_inputdate){
    var string  = URT_SRC_inputdate.split("-");
    return string[2]+'-'+ string[1]+'-'+string[0];
}
$(document).ready(function(){
    $('textarea').autogrow({onInitialize: true});
    var URT_SRC_arr_loginid=[];
    var URT_SRC_arr_errormsg=[];
    var URT_SRC_customrole=[]
    var URT_SRC_loginid ='';
    var URT_SRC_upd_edate=''
    var URT_SRC_upd_rson='';
    var URT_SRC_flag_emaiid='';
    google.script.run.withSuccessHandler(URT_SRC_success_errmsg_loginid).withFailureHandler(URT_SRC_onFailure).URT_SRC_errormsg_loginid('URT_SRC_flag_errmsg');
    /*------------------------------------------SUCCESS FUNCTION FOR ERROR MSG & LOAD EMAIL_ID--------------------------------*/
    function URT_SRC_success_errmsg_loginid(URT_SRC_response_errmsg_loginid) {
//TO HIDE PRELOADER START
        SubPage=0;
        CheckPageStatus();
//TO HIDE PRELOADER END
        URT_SRC_arr_loginid=URT_SRC_response_errmsg_loginid.URT_SRC_obj_loginid;
        URT_SRC_arr_errormsg=URT_SRC_response_errmsg_loginid.URT_SRC_obj_errmsg;
        URT_SRC_customrole=URT_SRC_response_errmsg_loginid.URT_SRC_customerole;
        var URT_SRC_flag_emailid=URT_SRC_response_errmsg_loginid.URT_SRC_obj_source;
        var URT_SRC_flg_login=URT_SRC_response_errmsg_loginid.URT_SRC_obj_flg_login;
        if(URT_SRC_flg_login==false){
            $('#URT_SRC_form_terminatesrcupd').replaceWith('<p><label class="errormsg"> '+URT_SRC_arr_errormsg[6]+'</label></p>')
        }
        else if((URT_SRC_flag_emailid!='URT_SRC_flag_errmsg')&&(URT_SRC_flag_emailid!=undefined)){
            if(URT_SRC_arr_loginid.length==0){
                if(URT_SRC_flag_emailid=='URT_SRC_radio_loginterminate')
                    var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[3];
                else if(URT_SRC_flag_emailid=='URT_SRC_radio_rejoin')
                    var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[4];
                else if(URT_SRC_flag_emailid=='URT_SRC_radio_optsrcupd')
                    var URT_SRC_errormsg_nodata=URT_SRC_arr_errormsg[5];
                $('#URT_SRC_lbl_errormsg_nodata').text(URT_SRC_errormsg_nodata)
            }
            else{
                URT_SRC_loginid +='<option>SELECT</option>';
                for (var i = 0; i < URT_SRC_arr_loginid.length; i++) {
                    URT_SRC_loginid += '<option value="' + URT_SRC_arr_loginid[i]  + '">' + URT_SRC_arr_loginid[i] + '</option>';
                }
                URT_SRC_flag_emaiid=URT_SRC_flag_emailid;
                $("#URT_SRC_tble_emailid").empty();
                $('<tr><td><label class="srctitle">LOGIN ID<em>*</em></label></td></tr><tr><td><select id="URT_SRC_lb_loginid" name="URT_SRC_lb_loginid" class="URT_SRC_class_terminatevalid URT_SRC_class_rejoinvalid URT_SRC_class_srchupdvalid">'+URT_SRC_loginid+'</select></td><td><label id="URT_SRC_lbl_recordversion" class="srctitle" hidden>RECORD VERSION<em>*</em></label></td><td><select name="URT_SRC_lb_recordversion" id="URT_SRC_lb_recordversion" hidden></select></td></tr>').appendTo($("#URT_SRC_tble_emailid"))
            }
        }
    }
    /*-------------------------------------CHANGE EVENT FUNCTION FOR RADIO BUTTON FOR LOGIN/SRCH UPDATE-------------------------------------------*/
    $(document).on('click','.URT_SRC_class_loginterminate_srcupd',function(){
        var URT_SRC_source=  $(this).attr('id');
        $("#URT_SRC_tble_emailid").empty();
        $("#URT_SRC_tble_srchupd").empty();
        $("#URT_SRC_tble_loginterm").empty();
        $("#URT_SRC_tble_rejoin").empty();
        $("#URT_SRC_tble_optsrchupd").empty();
        $("#URT_SRC_lbl_errormsg_nodata").text('');
        /*-------------------------------------------CLICK EVENT FUNCTION FOR LOGIN DETAILS-----------------------------------*/
        if(URT_SRC_source=='URT_SRC_radio_loginterminate'){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            URT_SRC_loginid ='';
            google.script.run.withSuccessHandler(URT_SRC_success_errmsg_loginid).withFailureHandler(URT_SRC_onFailure).URT_SRC_errormsg_loginid(URT_SRC_source);
        }
        else if(URT_SRC_source=='URT_SRC_radio_srcupd'){
            $('<tr><td><label class="srctitle">SELECT A OPTION</label></td></tr><tr><td><input type="radio" id="URT_SRC_radio_rejoin" name="URT_SRC_radio_rejoin_srcupd" class="URT_SRC_class_rejoin_srcupd"><label>REJOIN</label></td></tr><tr><td><input type="radio" id="URT_SRC_radio_optsrcupd" name="URT_SRC_radio_rejoin_srcupd" class="URT_SRC_class_rejoin_srcupd"><label>SEARCH/UPDATE</label></td></tr>').appendTo($("#URT_SRC_tble_srchupd"));
        }
    });
    /*-------------------------------------CHANGE EVENT FUNCTION FOR EMAIL_ID TO GET JOIN DATE-------------------------------------------*/
    $(document).on('change','#URT_SRC_lb_loginid',function(){
        if($("#URT_SRC_lb_loginid").val()!='SELECT'){
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $("#URT_SRC_tble_loginterm").empty();
            $("#URT_SRC_tble_rejoin").empty();
            $("#URT_SRC_tble_optsrchupd").empty();
            $("#URT_SRC_db_logindate").val('')
            if(URT_SRC_flag_emaiid=='URT_SRC_radio_loginterminate'){
                $("#URT_SRC_tble_srchupd").empty();
                google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_enddate($("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver','URT_SRC_check_enddate','URT_SRC_recvrsion_one')}
            else if(URT_SRC_flag_emaiid=='URT_SRC_radio_rejoin')
                google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_enddate($("#URT_SRC_lb_loginid").val(),'URT_SRC_recdver','URT_SRC_check_rejoindate','URT_SRC_recvrsion_one')
            else if(URT_SRC_flag_emaiid=='URT_SRC_radio_optsrcupd')
                google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_recordversion($("#URT_SRC_lb_loginid").val(),'URT_SRC_flag_recver','URT_SRC_recvrsion_one')
        }
        else{
            $(".preloader").hide();
            $("#URT_SRC_tble_loginterm").empty();
            $("#URT_SRC_tble_rejoin").empty();
            $("#URT_SRC_tble_optsrchupd").empty();
            $("#URT_SRC_db_logindate").val('')
        }});
    /*---------------------------------------SUCCESS FUNCTION-----------------------------------*/
    function URT_SRC_success_enddate(URT_SRC_response_enddate){
        $(".preloader").hide();
        var URT_SRC_arr_recordversion=[];
        if(URT_SRC_response_enddate.URT_SRC_obj_recordversion!=undefined){
            URT_SRC_arr_recordversion=URT_SRC_response_enddate.URT_SRC_obj_recordversion;}
        if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_check_enddate')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){
            $('<tr><td><label class="srctitle">SELECT A END DATE</label><em>*</em></td></tr><tr><td><input type="textbox" id="URT_SRC_db_logindate" name="URT_SRC_db_logindate" style="width:75px" class="URT_SRC_class_terminatevalid datemandtry"></td></tr><tr><td><label class="srctitle">REASON OF TERMINATION<em>*</em></label></td></tr><tr><td><textarea id="URT_SRC_ta_reasonterm" name="URT_SRC_ta_reasonterm" class="URT_SRC_class_terminatevalid"></textarea></td></tr><tr><td><input type="button" id="URT_SRC_btn_terminate" name="URT_SRC_btn_terminate" value="TERMINATE" class="maxbtn" disabled></td></tr>').appendTo($("#URT_SRC_tble_loginterm"));
            $("#URT_SRC_db_logindate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
            var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
            date.setDate( date.getDate() + 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#URT_SRC_db_logindate').datepicker("option","minDate",newDate);
            $('#URT_SRC_db_logindate').datepicker("option","maxDate",new Date());
        }
        else if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_check_rejoindate')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){
            var URT_SRC_roles='<tr><td><label class="srctitle">SELECT ROLE ACCESS<em>*</em></label></td></tr>';
            for (var i = 0; i < URT_SRC_customrole.length; i++) {
                var id1="URSRC_role_array"+i;
                var value=URT_SRC_customrole[i].replace(" ","_")
                URT_SRC_roles += '  <tr ><td><input type="radio" name="customrole" id='+id1+' value='+value+' class="URT_SRC_class_rejoinvalid"   />' + URT_SRC_customrole[i] + '</td></tr>';
            }
            URT_SRC_roles +='<tr><td><label class="srctitle">SELECT A REJOIN DATE<em>*</em></label></td></tr><tr><td><input type="textbox" id="URT_SRC_db_rejoindate" name="URT_SRC_db_rejoindate" style="width:75px" class="URT_SRC_class_rejoinvalid datemandtry"></td></tr><tr><td><input type="button" id="URT_SRC_btn_rejoin" name="URT_SRC_btn_rejoin" value="REJOIN" class="btn" disabled></td></tr>'
            $("#URT_SRC_tble_rejoin").append(URT_SRC_roles);
            $("#URT_SRC_db_rejoindate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
            var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_endate ) );
            date.setDate( date.getDate() + 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#URT_SRC_db_rejoindate').datepicker("option","minDate",newDate);
            $('#URT_SRC_db_rejoindate' ).datepicker( "option", "maxDate", new Date() );
        }
        else if(URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_flag_recver'){
            var URT_SRC_recver ='<option>SELECT</option>';
            for (var i = 0; i < URT_SRC_arr_recordversion.length; i++) {
                URT_SRC_recver += '<option value="' + URT_SRC_arr_recordversion[i]  + '">' + URT_SRC_arr_recordversion[i] + '</option>';
            }
            $('#URT_SRC_lbl_recordversion').show();
            $('#URT_SRC_lb_recordversion').html(URT_SRC_recver).show();
        }
        else if((URT_SRC_response_enddate.URT_SRC_obj_srcupd=='URT_SRC_srcupd')&&(URT_SRC_response_enddate.URT_SRC_obj_srcupd!=undefined)){
            $('<tr><td><label class="srctitle">SELECT A END DATE<em>*</em></label></td></tr><tr><td><input type="textbox" id="URT_SRC_db_upd_enddate" name="URT_SRC_db_upd_enddate" style="width:75px" class="URT_SRC_class_srchupdvalid datemandtry"></td></tr><tr><td><label class="srctitle">REASON OF TERMINATION<em>*</em></label></td></tr><tr><td><textarea id="URT_SRC_ta_upd_reasonterm" name="URT_SRC_ta_upd_reasonterm" class="URT_SRC_class_srchupdvalid"></textarea></td></tr><tr><td><input type="button" id="URT_SRC_btn_update" name="URT_SRC_btn_update" value="UPDATE" class="btn" disabled></td></tr>').appendTo($("#URT_SRC_tble_optsrchupd"));
            $("#URT_SRC_db_upd_enddate").datepicker({dateFormat: "dd-mm-yy" ,changeYear:true,changeMonth:true });
            var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
            date.setDate( date.getDate() + 1 );
            var newDate = date.toDateString();
            newDate = new Date( Date.parse( newDate ) );
            $('#URT_SRC_db_upd_enddate').datepicker("option","minDate",newDate);
            $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",new Date());
            if(URT_SRC_arr_recordversion.length==1){
                $('#URT_SRC_lbl_recordversion').hide();
                $('#URT_SRC_lb_recordversion').hide();}
            else{
                var date = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_joindate ) );
                date.setDate( date.getDate() + 1 );
                var newDate = date.toDateString();
                newDate = new Date( Date.parse( newDate ) );
                $('#URT_SRC_db_upd_enddate').datepicker("option","minDate",newDate);
                $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",new Date());
                if(URT_SRC_response_enddate.URT_SRC_obj_next_jdate!='URT_SRC_nomore_recver'){
                    var enddate = new Date( Date.parse( URT_SRC_response_enddate.URT_SRC_obj_next_jdate ) );
                    enddate.setDate( enddate.getDate() - 1 );
                    var neweDate = enddate.toDateString();
                    neweDate = new Date( Date.parse( neweDate ) );
                    $('#URT_SRC_db_upd_enddate').datepicker("option","maxDate",neweDate);
                }}
            $('#URT_SRC_db_upd_enddate').val(FormTableDateFormat(URT_SRC_response_enddate.URT_SRC_obj_endate));
            URT_SRC_upd_edate=FormTableDateFormat(URT_SRC_response_enddate.URT_SRC_obj_endate)
            URT_SRC_upd_rson=URT_SRC_response_enddate.URT_SRC_obj_reason
            $('#URT_SRC_ta_upd_reasonterm').val(URT_SRC_response_enddate.URT_SRC_obj_reason);
        }}
    /*-------------------------------------CLICK EVENT FUNCTION FOR RADIO BUTTON FOR REJOIN FORM-------------------------------------------*/
    $(document).on('click','.URT_SRC_class_rejoin_srcupd',function(){
        var  newPos= adjustPosition($(this).position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        $("#URT_SRC_lbl_errormsg_nodata").text('');
        var URT_SRC_source=  $(this).attr('id');
        $("#URT_SRC_tble_emailid").empty();
        $("#URT_SRC_tble_rejoin").empty();
        $("#URT_SRC_tble_optsrchupd").empty();
        if(URT_SRC_source=='URT_SRC_radio_rejoin'){
            URT_SRC_loginid ='';
            google.script.run.withSuccessHandler(URT_SRC_success_errmsg_loginid).withFailureHandler(URT_SRC_onFailure).URT_SRC_errormsg_loginid(URT_SRC_source);
        }
        else if(URT_SRC_source=='URT_SRC_radio_optsrcupd'){
            URT_SRC_loginid ='';
            google.script.run.withSuccessHandler(URT_SRC_success_errmsg_loginid).withFailureHandler(URT_SRC_onFailure).URT_SRC_errormsg_loginid(URT_SRC_source);
        }
    });
    /*-------------------------------CLICK FUNCTION FOR TERMINATE----------------------------*/
    $(document).on('click','#URT_SRC_btn_terminate',function(){
        var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        google.script.run.withSuccessHandler(URT_SRC_success_update_rejoin_terminate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_terminate($('#URT_SRC_lb_loginid').val(),$('#URT_SRC_db_logindate').val(),$('#URT_SRC_ta_reasonterm').val(),'URT_SRC_flag_terminate')
    });
    /*---------------------------CLICK FUNCTION FOR REJOIN----------------------------*/
    $(document).on('click','#URT_SRC_btn_rejoin',function(){
        var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        google.script.run.withSuccessHandler(URT_SRC_success_update_rejoin_terminate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_rejoin($('#URT_SRC_lb_loginid').val(),$('#URT_SRC_db_rejoindate"').val(),$("input[name=customrole]:checked").val(),'URT_SRC_flag_rejoin')
    });
    /*----------------------------CLICK FUNCTION FOR UPDATE-----------------------------*/
    $(document).on('click','#URT_SRC_btn_update',function(){
        var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
        resetPreloader(newPos);
        $(".preloader").show();
        google.script.run.withSuccessHandler(URT_SRC_success_update_rejoin_terminate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_update($('#URT_SRC_lb_loginid').val(),$('#URT_SRC_lb_recordversion').val(),$('#URT_SRC_db_upd_enddate"').val(),$('#URT_SRC_ta_upd_reasonterm').val(),'URT_SRC_flag_updation',URT_SRC_upd_edate,URT_SRC_upd_rson)
    });
    /*---------------------------------------SUCCESS FUNCTION-----------------------------------*/
    function URT_SRC_success_update_rejoin_terminate(URT_SRC_response_upd_rejoin){
        if(URT_SRC_response_upd_rejoin.toString().match("SCRIPT EXCEPTION:"))
        {
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_response_upd_rejoin,position:{top:150,left:500}}});
        }
        else if(URT_SRC_response_upd_rejoin[1]==0)
        {
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[7],position:{top:150,left:500}}});
        }
        else
        {
            if(URT_SRC_response_upd_rejoin[1]==1){
                if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_updation')&&(URT_SRC_response_upd_rejoin[0]!=undefined)){
                    var URT_SRC_err_term_rejoin_srcupd=URT_SRC_arr_errormsg[0].replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_err_term_rejoin_srcupd,position:{top:150,left:500}}});}
                else if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_rejoin')&&(URT_SRC_response_upd_rejoin[0]!=undefined))
                    var URT_SRC_err_term_rejoin_srcupd=URT_SRC_arr_errormsg[2].replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())
                else if((URT_SRC_response_upd_rejoin[0]=='URT_SRC_flag_terminate')&&(URT_SRC_response_upd_rejoin[0]!=undefined))
                    var URT_SRC_err_term_rejoin_srcupd=URT_SRC_arr_errormsg[1].replace('[LOGIN ID]',$("#URT_SRC_lb_loginid").val())
                if(URT_SRC_response_upd_rejoin[0]!=undefined)
                    $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_err_term_rejoin_srcupd,position:{top:150,left:500}}});
            }
            $(':input','#URT_SRC_form_terminatesrcupd').removeAttr('checked');
            $("#URT_SRC_tble_rejoin").empty();
            $("#URT_SRC_tble_emailid").empty();
            $("#URT_SRC_tble_optsrchupd").empty();
            $("#URT_SRC_tble_loginterm").empty();
            $("#URT_SRC_tble_srchupd").empty();
        }
        $(".preloader").hide();
    }
    /*-----------------------------------------CHANGE FUNCTION TERMINATE BTN VALIDATION--------------------------*/
    $(document).on('change','.URT_SRC_class_terminatevalid',function(){
        if(($('#URT_SRC_lb_loginid').val()!='SELECT')&&($('#URT_SRC_db_logindate').val()!='')&&($('#URT_SRC_ta_reasonterm').val()!='')){
            $("#URT_SRC_btn_terminate").removeAttr("disabled");
        }
        else
            $('#URT_SRC_btn_terminate').attr("disabled", "disabled")
    });
    /*-----------------------------------------CHANGE FUNCTION REJOIN BTN VALIDATION--------------------------*/
    $(document).on('change','.URT_SRC_class_rejoinvalid',function(){
        var URT_SRC_role_select=$("input[name=customrole]").is(":checked");
        if(($('#URT_SRC_lb_loginid_srchupd').val()!='SELECT')&&($('#URT_SRC_db_rejoindate').val()!='')&&(URT_SRC_role_select==true)){
            $("#URT_SRC_btn_rejoin").removeAttr("disabled");
        }
        else
            $('#URT_SRC_btn_rejoin').attr("disabled", "disabled")
    });
    /*-----------------------------------------CHANGE FUNCTION UPDATE BTN VALIDATION--------------------------*/
    $(document).on('change','.URT_SRC_class_srchupdvalid',function(){
        if(($('#URT_SRC_lb_upd_loginid').val()=='SELECT')||($('#URT_SRC_db_upd_enddate').val()=='')||($('#URT_SRC_ta_upd_reasonterm').val()=='')||(($('#URT_SRC_db_upd_enddate').val()==URT_SRC_upd_edate)&&($('#URT_SRC_ta_upd_reasonterm').val()==URT_SRC_upd_rson))){
            $('#URT_SRC_btn_update').attr("disabled", "disabled")
        }
        else
            $("#URT_SRC_btn_update").removeAttr("disabled");
    });
    /*-------------------------------------CHANGE EVENT FUNCTION FOR EMAIL_ID TO GET END DATE,REASON-------------------------------------------*/
    $(document).on('change','#URT_SRC_lb_upd_loginid',function(){
        if($("#URT_SRC_lb_upd_loginid").val()!="SELECT")
        {
            var  newPos= adjustPosition($(this).position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_recordversion($("#URT_SRC_lb_upd_loginid").val(),'URT_SRC_flag_recver')
        }
        else
        {
            $("#URT_SRC_lbl_recordversion").hide();
            $("#URT_SRC_lb_recordversion").hide();
            $("#URT_SRC_db_logindate").val('').hide()
            $("#URT_SRC_ta_reasonterm").val('').hide()
        }
    });
    /*----------------------------CHANGE EVENT FUNCTION FOR RECORD VERSION TO GET ENDDATE,REASON TO UPDATE-------------------------------------------*/
    $(document).on('change','#URT_SRC_lb_recordversion',function(){
        if($("#URT_SRC_lb_recordversion").val()!="SELECT")
        {
            var  newPos= adjustPosition($("#URT_SRC_lb_loginid").position(),100,270);
            resetPreloader(newPos);
            $(".preloader").show();
            $("#URT_SRC_tble_optsrchupd").empty();
            google.script.run.withSuccessHandler(URT_SRC_success_enddate).withFailureHandler(URT_SRC_onFailure).URT_SRC_func_enddate($("#URT_SRC_lb_loginid").val(),$("#URT_SRC_lb_recordversion").val(),'URT_SRC_srcupd','URT_SRC_recvrsion_more')
        }
        else{
            $("#URT_SRC_db_logindate").val('').hide()
            $("#URT_SRC_ta_reasonterm").val('').hide()
        }
    });
    function URT_SRC_onFailure(URT_SRC_error){
        $(".preloader").hide();
        if(URT_SRC_error=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
        {
            URT_SRC_error="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
            $('#URT_SRC_form_terminatesrcupd').replaceWith('<center><label class="dberrormsg">'+URT_SRC_error+'</label></center>');
        }
        else if((URT_SRC_error=='ReferenceError: "Calendar" is not defined.')||(URT_SRC_error=='ScriptError: Access Not Configured. Please use Google Developers Console to activate the API for your project.')){
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[8],position:{top:150,left:500}}});
        }
        else if(URT_SRC_error=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.'){

            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[9],position:{top:150,left:500}}});
        }
        else if((URT_SRC_error=='ScriptError: Forbidden')||(URT_SRC_error=='ScriptError: You do not have permission to perform that action.')){
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[11],position:{top:150,left:500}}});

        }
        else if((URT_SRC_error=='ScriptError: Not Found')||(URT_SRC_error=='Not Found')){
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"ACCESS RIGHTS-SEARCH/UPDATE",msgcontent:URT_SRC_arr_errormsg[10],position:{top:150,left:500}}});

        }
        else{
            $(document).doValidation({rule:'messagebox',prop:{msgtitle:"TERMINATE - SEARCH/UPDATE",msgcontent:URT_SRC_error.message,position:{top:150,left:500}}});
        }
    }
});
</script>
<!--SCRIPT TAG END-->
</head>
<body>
<div class="container">
<div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>

<!--    <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif"  /></div></div></div>-->
    <div class="title text-center"><h4><b>TERMINATE - SEARCH/UPDATE</b></h4></div>
    <form class="content" name="URT_SRC_form_terminatesrcupd" id="URT_SRC_form_terminatesrcupd">
        <table>
            <tr><td><input type="radio" id="URT_SRC_radio_loginterminate" name="URT_SRC_radio_loginterminate_srcupd" value="URT_SRC_loginterminate" class="URT_SRC_class_loginterminate_srcupd"><label>LOGIN TERMINATION</label></td></tr>
            <tr><td><input type="radio" id="URT_SRC_radio_srcupd" name="URT_SRC_radio_loginterminate_srcupd" value="URT_SRC_srcupd" class="URT_SRC_class_loginterminate_srcupd"><label>SEARCH/UPDATE</label></td></tr>
            <tr></tr>
        </table>
        <table id="URT_SRC_tble_srchupd"></table>
        <table id="URT_SRC_tble_emailid"></table>
        <table id="URT_SRC_tble_loginterm"></table>
        <table id="URT_SRC_tble_rejoin"></table>
        <table id="URT_SRC_tble_optsrchupd"></table>
        <label id="URT_SRC_lbl_errormsg_nodata" class="errormsg"></label>
        <div>
        </div>
        <div>
        </div>
    </form>
</div>
</body>
</html>
