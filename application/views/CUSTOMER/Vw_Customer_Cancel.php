<!--//*******************************************FILE DESCRIPTION*********************************************//
//************************************CUSTOMER CANCEL***********************************************//
//DONE BY:PUNI
//VER 1.2-SD:22/12/2014 ED:22/12/2014;TRACKER NO:790;added droptemp table function from eilib
//VER 1.1-SD:08/10/2014 ED:08/10/2014;TRACKER NO:790;CHANGED PRELOADER N MSGBOX POSITION
//DONE BY:SAFIYULLAH.M
//VER 1.0-31/07/2014 ED:04/08/2014;TRACKER NO:790;UPDATED SCRIPT SIDE ROLLBACK AND COMMIT
//VER 0.09-SD:09/07/2014 ED:10/07/2014;TRACKER NO:790;UPDATED ALIGNMENT AND UPADTED EILIB CALENDER EVENT FUNCTION FOR UNCANCEL
//VER 0.08-SD:17/06/2014 ED:17/06/2014;TRACKER NO:790;updated CALENDER ERROR MSG AND updated failure msg
VER 0.07-SD:06/06/2014 ED:06/06/2014;TRACKER NO:770;CHANGED JQUERY LINK
//VER 0.06-SD:20/05/2014 ED:20/05/2014:TRACKER NO:770;UPDATED RETURN FUNCTION
//VER 0.05- SD:06/05/2014 ED:08/05/2014:TRACKER NO:770;UPDATED TEMP TABLE DYNAMICALLY.
VER 0.04-SD:04/02/2014 ED:04/02/2014;TRACKER NO: 331;updated error msg getting from eilib,updated query as per entry details table updated and added convert function for spl char.
VER 0.03- SD:30/12/2013 ED:30/12/2013;TRACKER NO: 331;updated Eilib functions
VER 0.02 - SD:05/11/2013 ED:28/11/2013;TRACKER NO: 331;CHANGED SP ,FORM DESIGN AND CONNECTION STRING AND REMOVED SCRIPLET 
VER 0.01 - INITIAL VERSION-SD:28/08/2013 ED:13/09/2013;TRACKER NO: 331
//*********************************************************************************************************//
-->
<?php
require_once "Header.php";
?>
<html>
<head>
<script>

$(document).ready(function(){

    $(".preloader").show();
    $('textarea').autogrow({onInitialize: true});
    var CCAN_errorAarray=[];

    $.ajax({
        type:'post',
        'url':"<?php echo base_url();?>"+"index.php/Ctrl_Customer_Cancel/CCAN_getcustomer",
        success:function(data){
            $(".preloader").hide();
            var CCAN_initialvalues_result=JSON.parse(data);
            CCAN_errorAarray=CCAN_initialvalues_result[0].CCAN_error_msg;
            var CCAN_check_customer=CCAN_initialvalues_result[0].CCAN_cust_values;
            if(CCAN_check_customer=='true'){
                $('#CCAN_tble_main').show();
            }
            else{
                var CCAN_err_msg=CCAN_errorAarray[1].EMC_DATA+'  &  '+CCAN_errorAarray[3].EMC_DATA;
                $('#CCAN_form_cancelform').replaceWith('<p><label class="errormsg"> '+CCAN_err_msg+'</label></p>');
            }
        }

    });
    $('#CCAN_radio_cancellist').change(function(){
        var  newPos= adjustPosition($(this).position(),100,260);
        resetPreloader(newPos);
        $(".preloader").show();
        var CCAN_select_type=$('#CCAN_radio_cancellist').val()
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_lbl_errmsg').hide();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_tble_guest_cardno tr').remove();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_lbl_cname').hide();
        $('#CCAN_div_uncancelbuttons').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        $('#CCAN_tble_id tr').remove();
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_lbl_title').text("CANCEL CUSTOMER").show();
        $.ajax({
            type:'post',
            'url':"<?php echo base_url();?>"+"index.php/Ctrl_Customer_Cancel/CCAN_getcustomer_details",
            data:{'CCAN_select_type':CCAN_select_type},
            success:function(data){
                var response_unit=JSON.parse(data);
                CCAN_loadUnitNo(response_unit)  ;
            }
        });
    });
    $('#CCAN_radio_uncancellist').change(function(){
        var  newPos= adjustPosition($(this).position(),100,260);
        resetPreloader(newPos);
        $(".preloader").show();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_lbl_errmsg').hide();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_tble_guest_cardno tr').remove();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_lbl_cname').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        $('#CCAN_tble_id tr').remove();
        var CCAN_select_type=$('#CCAN_radio_uncancellist').val()
        $('#CCAN_tble_unitno').hide();
        $('#CCAN_lbl_title').text("UNCANCEL CUSTOMER").show();
        $.ajax({
            type:'post',
            'url':"<?php echo base_url();?>"+"index.php/Ctrl_Customer_Cancel/CCAN_getcustomer_details",
            data:{'CCAN_select_type':CCAN_select_type},
            success:function(data){
                var response_unit=JSON.parse(data);
                CCAN_loadUnitNo(response_unit)  ;
            }
        });
    });
//-----UNIT NO CHANGE FUNCTION-----------------
    $('#CCAN_lb_selectunit').change(function(){

        var CCAN_unit = $(this).val();
        if(CCAN_unit=='SELECT'){
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_tble_guest_cardno tr').remove();
            $('#CCAN_lb_selectname').hide();
            $('#CCAN_lb_selectname').prop('selectedIndex',0);
            $('#CCAN_lbl_cname').hide();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id tr').remove();
        }
        else{
//$(".preloader").show();
            $('#CCAN_lb_selectname').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_lb_selectname').prop('selectedIndex',0);
            $('#CCAN_lbl_cname').hide();
            $('#CCAN_div_cancelform').hide();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id tr').remove();
            $('#CCAN_tble_guest_cardno tr').remove();
            var CCAN_namearray=[];

            for(var k=0;k<CCAN_all_result.length;k++)
            {
                if(CCAN_all_result[k].unit==CCAN_unit)
                {

                    CCAN_namearray.push(CCAN_all_result[k].name);
                }
            }
            CCAN_namearray=unique(CCAN_namearray);

            var CCAN_custname_options ='<option>SELECT</option>'
            for (var i = 0; i < CCAN_namearray.length; i++) {
                var CCAN_myarray=CCAN_namearray[i].split('_');
                var CCAN_custname=CCAN_myarray[0]+' '+CCAN_myarray[1];
                CCAN_custname_options += '<option value="' + CCAN_namearray[i] + '">' + CCAN_custname + '</option>';
            }
            $('#CCAN_lb_selectname').html(CCAN_custname_options)
            $('#CCAN_lb_selectname').show();
            $('#CCAN_custname').show();

        }
    });
//------------CUSTOMER NAME CHANGE FUNCTION------------------
    $('#CCAN_lb_selectname').change(function(){
        var CCAN_name=$(this).val();
        var CCAN_unit_no=$('#CCAN_lb_selectunit').val();
        if(CCAN_name=='SELECT')
        {
            $('#CCAN_lbl_error').hide();
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_tble_guest_cardno tr').remove();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id tr').remove();
        }
        else{
            $(".preloader").show();
            $('#CCAN_lbl_error').hide();
            $('#CCAN_div_buttons').hide();
            $('#CCAN_div_uncancelbuttons').hide();
            $('#CCAN_div_cancelform').hide();
            $('#CCAN_tble_guest_cardno tr').remove();
            $('input:radio[name=CCAN_id]').attr('checked',false);
            $('#CCAN_tble_id tr').remove();
            var CCAN_name_id_array=[];
            for(var k=0;k<CCAN_all_result.length;k++)
            {
                if((CCAN_all_result[k].name==CCAN_name)&& (CCAN_all_result[k].unit==CCAN_unit_no))
                {
                    CCAN_name_id_array.push(CCAN_all_result[k].customerid);
                }
            }
            CCAN_name_id_array=CCAN_name_id_array.sort();
            if(CCAN_name_id_array.length!=1){
                $(".preloader").hide();
                $('#CCAN_tble_personaldetails').hide();
                $('#CCAN_tble_third').hide();
                $('#CCAN_div_buttons').hide();
                $('#CCAN_div_uncancelbuttons').hide();
                $('#CCAN_tble_feedetails').hide();
                $('#CCAN_tble_id').show();
                var CCAN_myarray=CCAN_name.split('_');
                var CCAN_custname=CCAN_myarray[0]+' '+CCAN_myarray[1];
                var CCAN_custid_radio='';
                for (var i = 0; i < CCAN_name_id_array.length; i++) {
                    var final=CCAN_custname+' '+CCAN_name_id_array[i]
                    CCAN_custid_radio = '<tr id=123><td><input type="radio" name="custid" id='+CCAN_name_id_array[i]+' value='+CCAN_name_id_array[i]+' class="CCAN_class_custid" /></td><td>' + final + '</td></tr>';
                    $('#CCAN_tble_id').append(CCAN_custid_radio);
                }
            }
            else{
                var CCAN_name_recver;
                for(var k=0;k<CCAN_all_result.length;k++)
                {
                    if(CCAN_all_result[k].customerid==CCAN_name_id_array[0])
                    {
                        CCAN_name_recver=(CCAN_all_result[k].recver);
                    }
                }
//HANDLER TO GET CUSTOMER DETAIL'S
                var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
                $.ajax({
                    type:'post',
                    'url':"<?php echo base_url();?>"+"index.php/Ctrl_Customer_Cancel/CCAN_get_customervalues",
                    data:{'CCAN_select_type':CCAN_select_type,'CCAN_name_recver':CCAN_name_recver,'cust_name':CCAN_name_id_array[0]},
                    success:function(data){
                        var response_unit=JSON.parse(data);
                        CCAN_load_customerdetails(response_unit)  ;
                    }


                });
//                google.script.run.withFailureHandler(CCAN_error).withSuccessHandler(CCAN_load_customerdetails).CCAN_get_customervalues(CCAN_name_id_array[0],CCAN_select_type,CCAN_name_recver)
                $('#CCAN_tble_id tr').remove();
            }
        }
    });
    $('.clear').click(function(){
        CCAN_clear('RESET');
    });
    $('#CCAN_lb_selectname').hide();
    $('#CCAN_lbl_cname').hide();
    $('#CCAN_lbl_unitno').hide();
    $('#CCAN_lb_selectunit').hide();
//FUNCTION TO CHECK CUSTOMER AVAILABLE
    function CCAN_checkcustomer(CCAN_initialvalues_result){
        CCAN_errorAarray=CCAN_initialvalues_result[0].CCAN_error_msg;
        var CCAN_check_customer=CCAN_initialvalues_result[0].CCAN_cust_values;
        if(CCAN_check_customer=='true'){
            $('#CCAN_tble_main').show();
        }
        else{
            var CCAN_err_msg=CCAN_errorAarray[1]+'  &  '+CCAN_errorAarray[3]
            $('#CCAN_form_cancelform').replaceWith('<p><label class="errormsg"> '+CCAN_err_msg+'</label></p>');
        }
//TO HIDE PRELOADER START
        SubPage=0;
        CheckPageStatus();
//TO HIDE PRELOADER END
    }
//FUNCTION TO LOAD INITIAL VALUES
    var CCAN_all_result=[]
    function CCAN_loadUnitNo(CCAN_unitno)
    {
        $(".preloader").hide();
        CCAN_all_result=CCAN_unitno;
        var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
        if(CCAN_all_result.length==0)
        {
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                $('#CCAN_lbl_title').hide();
                $('#CCAN_lbl_errmsg').text(CCAN_errorAarray[1].EMC_DATA).show();
            }
            else{
                $('#CCAN_lbl_title').hide();
                $('#CCAN_lbl_errmsg').text(CCAN_errorAarray[3].EMC_DATA).show();
            }
        }
        else
        {
            var unit_array=[];
            for(var k=0;k<CCAN_all_result.length;k++)
            {
                unit_array.push(CCAN_all_result[k].unit)
            }
            unit_array=unique(unit_array);
            var CCAN_unitno_options ='<option>SELECT</option>'
            for (var i = 0; i < unit_array.length; i++) {
                CCAN_unitno_options += '<option value="' + unit_array[i] + '">' + unit_array [i]+ '</option>';
            }
            $('#CCAN_lb_selectunit').html(CCAN_unitno_options);
            $('#CCAN_tble_unitno').show();
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').show();
        }
    }
    function unique(a) {
        var result = [];
        $.each(a, function(i, e) {
            if ($.inArray(e, result) == -1) result.push(e);
        });
        return result;
    }
//FUNCTION TO CALL RADIO BUTTON CLICK
    $(document).on("change",'.CCAN_class_custid', function ()
    {
        $(".preloader").show();
        var CCAN_customer_id=$("input[name=custid]:checked").val();
        var CCAN_name_recver;
        for(var k=0;k<CCAN_all_result.length;k++)
        {
            if(CCAN_all_result[k].customerid==CCAN_customer_id)
            {
                CCAN_name_recver=(CCAN_all_result[k].recver);
            }
        }
        $('#CCAN_tble_personaldetails').hide();
        $('#CCAN_tble_feedetails').hide();
        $('#CCAN_lbl_error').hide();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_div_uncancelbuttons').hide();
        $('#CCAN_tble_comment').hide();
        $('#CCAN_tble_guest_cardno tr').remove();
        $('input:radio[name=CCAN_selectcard]').attr('checked',false);
//HANDLER TO GET CUSTOMER DETAIL'S
        var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
        google.script.run.withFailureHandler(CCAN_error).withSuccessHandler(CCAN_load_customerdetails).CCAN_get_customervalues(CCAN_customer_id,CCAN_select_type,CCAN_name_recver)
    });
///////////////************ FUNCTION TO LOAD CUSTOMER DETAILS***********////////////////////
    function CCAN_load_customerdetails(data)
    {
        $(".preloader").hide();
        var CCAN_customer_details=[];
        CCAN_customer_details=data[0];
        var CCAN_guest_array=data[1];
        var CCAN_fname_length=(CCAN_customer_details.firstname).length;
        var CCAN_lname_length=(CCAN_customer_details.lastname).length
        var CCAN_email_length=(CCAN_customer_details.email).length
        var CCAN_nation_length=(CCAN_customer_details.nationality).length;
        if(CCAN_customer_details.company!=null){
            var CCAN_companyname_length=(CCAN_customer_details.company).length;
            $('#CCAN_tb_companyname').attr("size",CCAN_companyname_length+9)
        }
        var CCAN_roomtype_length=(CCAN_customer_details.roomtype).length;
        if(CCAN_customer_details.cardno!=null){
            var CCAN_card_no_length=(CCAN_customer_details.cardno).length;
            $('#CCAN_tb_cardno').attr("size",CCAN_card_no_length)
        }
        else{
            $('#CCAN_tb_cardno').attr("size",7)

        }
        var CCAN_startdate=CCAN_customer_details.startdate;
        CCAN_startdate=FormTableDateFormat(CCAN_startdate);
        var CCAN_enddate=CCAN_customer_details.enddate;
        CCAN_enddate=FormTableDateFormat(CCAN_enddate);
        var CCAN_passportdate=CCAN_customer_details.passportdate;
        if(CCAN_passportdate!=null)
        {
            CCAN_passportdate=FormTableDateFormat(CCAN_passportdate);
        }
        var CCAN_dob=CCAN_customer_details.dob;
        if(CCAN_dob!=null){
            CCAN_dob=FormTableDateFormat(CCAN_dob);
        }
        var CCAN_passportdate=CCAN_customer_details.passportdate;
        if(CCAN_passportdate!=null){
            CCAN_passportdate=FormTableDateFormat(CCAN_passportdate)
        }
        var CCAN_epdate=CCAN_customer_details.epdate;
        if(CCAN_epdate!=null){
            CCAN_epdate=FormTableDateFormat(CCAN_epdate)
        }
        var CCAN_noticedate=CCAN_customer_details.noticedate;
        if(CCAN_noticedate!=null){
            CCAN_noticedate=FormTableDateFormat(CCAN_noticedate)
        }
        $('#CCAN_tb_lastname').attr("size",CCAN_lname_length+3);
        $('#CCAN_tb_firstname').attr("size",CCAN_fname_length+3);
        $('#CCAN_tb_email').attr("size",CCAN_email_length+4);
        $('#CCAN_tb_nation').attr("size",CCAN_nation_length+6);
        $('#CCAN_tb_roomtype').attr("size",CCAN_roomtype_length+3);
        $('#CCAN_tb_firstname').val(CCAN_customer_details.firstname);
        $('#CCAN_tb_lastname').val(CCAN_customer_details.lastname);
        $('#CCAN_tb_email').val(CCAN_customer_details.email);$('#CCAN_tb_mobileno').val(CCAN_customer_details.mobile1);
        $('#CCAN_tb_intmobileno').val(CCAN_customer_details.mobile2);$('#CCAN_tb_officeno').val(CCAN_customer_details.officeno);
        $('#CCAN_tb_dob').val(CCAN_dob);$('#CCAN_tb_passno').val(CCAN_customer_details.passportno);
        $('#CCAN_tb_passdate').val(CCAN_passportdate);$('#CCAN_tb_epno').val(CCAN_customer_details.epno);
        $('#CCAN_tb_epdate').val(CCAN_epdate);$('#CCAN_tb_roomtype').val(CCAN_customer_details.roomtype);
        $('#CCAN_tb_cardno').val(CCAN_customer_details.cardno);
        $('#CCAN_tb_startdate').val(CCAN_startdate);
        $('#CCAN_tb_enddate').val(CCAN_enddate);
        $('#CCAN_tb_noticeperiod').val(CCAN_customer_details.noticeperiod);
        $('#CCAN_tb_noticedate').val(CCAN_noticedate);$('#CCAN_tb_elect').val(CCAN_customer_details.electricitycap);
        $('#CCAN_tb_drycleanfee').val(CCAN_customer_details.drycleanfee);$('#CCAN_tb_checkoutcleaningfee').val(CCAN_customer_details.checkoutcleaningfee);
        $('#CCAN_tb_deposit').val(CCAN_customer_details.deposit);$('#CCAN_tb_rent').val(CCAN_customer_details.rental);
        $('#CCAN_tb_processingfee').val(CCAN_customer_details.processingfee);
        $('#CCAN_ta_comments').height(20);
        $('#CCAN_ta_comments').val(CCAN_customer_details.comments);
        $('#CCAN_tb_companyname').val(CCAN_customer_details.company);
        $('#CCAN_tb_nation').val(CCAN_customer_details.nationality);
        var CCAN_quaterlyfee=CCAN_customer_details.airconquartelyfee
        var CCAN_fixedfee=CCAN_customer_details.airconfixedfee
        if(CCAN_quaterlyfee==null)
        {
            $('#CCAN_tb_fixed').val(CCAN_customer_details.airconfixedfee)
            $('#CCAN_lbl_fixedfee').text("AIRCON FIXED FEE")
            $('#CCAN_tb_fixed').show();
        }
        else
        {
            $('#CCAN_tb_fixed').val(CCAN_customer_details.airconquartelyfee)
            $('#CCAN_lbl_fixedfee').text("AIRCON QUATERLY FEE")
            $('#CCAN_tb_fixed').show();
        }
        if(CCAN_guest_array.length!=0)
        {
            var CCAN_guestcard='';
            for (var i = 0; i < CCAN_guest_array.length; i++) {
                CCAN_guestcard = '<tr ><td >&nbsp;&nbsp;<label style="width:230px" >GUEST'+(i+1)+' CARD </label></td> <td><input type="text" name="CCAN_tb_cardno" id='+CCAN_guest_array[i]+' value='+CCAN_guest_array[i]+' style="width:50px;" class="rdonly" readonly  /></td></tr>';
                $('#CCAN_tble_guest_cardno').append(CCAN_guestcard);
            }
        }
        else
        {
            $('#CCAN_tble_guest_cardno tr').remove();
        }
        $('#CCAN_tble_personaldetails').show();
        $('#CCAN_tble_third').show();
        $('#CCAN_tble_feedetails').show();
        $('#CCAN_tble_guest_cardno').show();
        $('#CCAN_div_cancelform').show();
        $('#CCAN_tble_comment').show();
        var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
        if(CCAN_select_type=="CANCEL CUSTOMER"){
            $('#CCAN_div_buttons').show();
            $('#CCAN_div_uncancelbuttons').hide();
        }
        if(CCAN_select_type=="UNCANCEL CUSTOMER")
        {
            $('#CCAN_div_uncancelbuttons').show();
            $('#CCAN_div_buttons').hide();
        }
    }
//******************** FUNCTION TO SHOW EXCEPTION**********************
    function CCAN_error(error)
    {
        if(error=="ScriptError: Failed to establish a database connection. Check connection string, username and password.")
        {
            error="DB USERNAME/PWD WRONG, PLZ CHK UR CONFIG FILE FOR THE CREDENTIALS."
            $('#CCAN_form_cancelform').replaceWith('<center><label class="dberrormsg">'+error+'</label></center>');
        }
        else{
            if(error=='TypeError: Cannot call method "getEvents" of undefined.'||error=='TypeError: Cannot call method "createEvent" of undefined.')
            {
                error=CCAN_errorAarray[6];
            }
            else if(error=='ScriptError: No item with the given ID could be found, or you do not have permission to access it.')
            {
                error=CCAN_errorAarray[6];
            }
            else{
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:error,position:{top:150,left:500}}});
            }
        }
    }
//*********************FUNCTION TO CLEAR FORM*************************
    function CCAN_clear(response)
    {
        $(".preloader").hide();
        $('#CCAN_div_cancelform').hide();
        $('#CCAN_lbl_cname').hide();
        $('#CCAN_lb_selectname').hide();
        $('#CCAN_lb_selectname').prop('selectedIndex',0);
        $('#CCAN_tble_id tr').remove();
        $('#CCAN_div_buttons').hide();
        $('#CCAN_div_uncancelbuttons').hide();
        $('input:radio[name=CCAN_id]').attr('checked',false);
        if(response==1)
        {
            $('#CCAN_lbl_unitno').hide();
            var CCAN_select_type = $('input:radio[name=CCAN_mainradiobutton]:checked').val();
            google.script.run.withFailureHandler(CCAN_error).withSuccessHandler(CCAN_loadUnitNo).CCAN_getcustomer_details(CCAN_select_type);
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).hide();
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:CCAN_errorAarray[0],position:{top:150,left:500}}});
            }
            else{
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:CCAN_errorAarray[4],position:{top:150,left:500}}});
            }
        }
        else if(response==0)
        {
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:CCAN_errorAarray[5],position:{top:150,left:500}}});
            }
            else{
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:CCAN_errorAarray[5],position:{top:150,left:500}}});
            }
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();
        }
        else if(response=='RESET'){
            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();
        }
        else{
            if(CCAN_select_type=="CANCEL CUSTOMER"){
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:response,position:{top:150,left:500}}});
            }
            else{
                $(document).doValidation({rule:'messagebox',prop:{msgtitle:"CUSTOMER CANCELLATION",msgcontent:response,position:{top:150,left:500}}});
            }

            $('#CCAN_lbl_unitno').show();
            $('#CCAN_lb_selectunit').prop('selectedIndex',0).show();

        }
    }
//FUNCTION TO CALL SUBMIT BUTTON
    $('#CCAN_btn_submitbutton').click(function(){
        $(".preloader").show();
        google.script.run.withFailureHandler(CCAN_error).withSuccessHandler(CCAN_clear).CCAN_cancel(document.getElementById('CCAN_form_cancelform'))
    });
    $('#CCAN_btn_uncancelbutton').click(function(){
        $(".preloader").show();
        google.script.run.withFailureHandler(CCAN_error).withSuccessHandler(CCAN_clear).CCAN_uncancel(document.getElementById('CCAN_form_cancelform'))
    });
//FUNCTION TO CONVERT DATE FORMAT
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
});
</script>
<!---SCRIPT TAG END--->
</head>
<!---HEAD TAG END--->
<!---BODY TAG START--->
<body>
<!--<div class="wrapper">-->
<!--    <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif"  /></div></div></div>-->
<!--    <div class="title" id="fhead" ><div style="padding-left:500px; text-align:left;"><p><b>CUSTOMER CANCELLATION</b><p></div></div>-->
<!--    <form action="" id="CCAN_form_cancelform" name="CCAN_cancel_form" class ='content'>-->
<!--        <table>-->
<!--            <tr>-->
<!--
<!--                <div>-->
<!--                    <table id='CCAN_tble_unitno' cellspacing="10" hidden>-->
<!--                        <tr>-->
<!--                            <td style="width:235px"><lable  id='CCAN_lbl_unitno'>UNIT NUMBER<em>*</em></lable></td>-->
<!--                            <td><select id='CCAN_lb_selectunit' name="CCAN_unitnumber"   >-->
<!--                                    <option value='SELECT' selected="selected"> SELECT</option>-->
<!--                                </select></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:235px"><lable for='cname' id='CCAN_lbl_cname' >CUSTOMER NAME <em>*</em></lable></td>-->
<!--                            <td><select id='CCAN_lb_selectname' name="CCAN_name"  >-->
<!--                                    <option value='SELECT' selected="selected"> SELECT</option>-->
<!--                                </select></td>-->
<!--                        </tr>-->
<!--                        <tr><td></td><td><table id='CCAN_tble_id' name='CCAN_id'></table></tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--                <div id="CCAN_div_cancelform" hidden>-->
<!--                    <table id='CCAN_tble_personaldetails' >-->
<!--                        <tr>-->
<!--                            <td style="width:250px">&nbsp;&nbsp;<label>FIRST NAME</label></td><td> <input type="text" name="CCAN_tb_firstname" id="CCAN_tb_firstname"  maxlength="50"  class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>LAST NAME</label></td><td> <input type="text" name="CCAN_tb_lastname" id="CCAN_tb_lastname"  maxlength="50"  class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>COMPANY NAME</label></td><td> <input type="text" name="CCAN_tb_companyname" id="CCAN_tb_companyname"  maxlength="50"  class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>EMAIL ID</label></td><td> <input type="text" name="CCAN_tb_email" id="CCAN_tb_email"  maxlength="50"  class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>MOBILE NO</label></td><td> <input type="text" name="CCAN_tb_mobileno" id="CCAN_tb_mobileno"  maxlength="6" style="width:60px;" class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>INT'L MOBILE NO</label></td><td> <input type="text" name="CCAN_tb_intmobileno" id="CCAN_tb_intmobileno"  maxlength="15" style="width:110px;"class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>OFFICE NO</label></td><td> <input type="text" name="CCAN_tb_officeno" id="CCAN_tb_officeno"  maxlength="8" style="width:60px;" class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>DATE OF BIRTH</label></td><td> <input type="text" name="CCAN_tb_dob" id="CCAN_tb_dob"  maxlength="50" style="width:75px;" class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>NATIONALITY</label></td><td> <input type="text" name="CCAN_tb_nation" id="CCAN_tb_nation"  maxlength="50"  class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label style="width:230px">PASSPORT NUMBER</label></td><td> <input type="text" name="CCAN_tb_passno" id="CCAN_tb_passno"  maxlength="15" style="width:125px;" class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label style="width:230px">PASSPORT EXPIRY DATE</label></td><td> <input type="text" name="CCAN_tb_passdate" id="CCAN_tb_passdate"  maxlength="50" style="width:75px;" class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>EP NUMBER</label></td><td> <input type="text" name="CCAN_tb_epno" id="CCAN_tb_epno"  maxlength="15" style="width:125px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>EP EXPIRY DATE</label></td><td> <input type="text" name="CCAN_tb_epdate" id="CCAN_tb_epdate"   style="width:75px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>ROOM TYPE</label></td><td> <input type="text" name="CCAN_tb_roomtype" id="CCAN_tb_roomtype"  class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:250px">&nbsp;&nbsp;<label>CUSTOMER CARD </label></td><td> <input type="text" name="CCAN_tb_cardno" id="CCAN_tb_cardno" style="width:50px;"   class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                    <table style="width:385px" id="CCAN_tble_guest_cardno">-->
<!--                    </table>-->
<!--                    <table id="CCAN_tble_feedetails">-->
<!--                        <tr>-->
<!--                            <td style="width:250px">&nbsp;&nbsp;<label>CHECK IN DATE</label></td><td> <input type="text" name="CCAN_tb_startdate" id="CCAN_tb_startdate"   style="width:75px;" class="rdonly" readonly   /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label style="width:230px">CHECK OUT DATE</label></td><td> <input type="text" name="CCAN_enddate" id="CCAN_tb_enddate"   style="width:75px;" class="rdonly"readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>NOTICE PERIOD</label></td><td> <input type="text" name="CCAN_tb_noticeperiod" id="CCAN_tb_noticeperiod"   style="width:30px;" class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>&nbsp;&nbsp;<label>NOTICE DATE</label></td><td> <input type="text" name="CCAN_tb_noticedate" id="CCAN_tb_noticedate"   style="width:75px;"readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td >&nbsp;&nbsp;<label >ELECTRICITY CAPPED</label></td><td> <input type="text" name="CCAN_tb_elect" id="CCAN_tb_elect"   style="width:45px;" class="rdonly" readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td >&nbsp;&nbsp;<label id="CCAN_lbl_fixedfee"  ></label></td><td> <input type="text" name="CCAN_tb_fixed" id="CCAN_tb_fixed"   style="width:45px;" class="rdonly" readonly hidden /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label >CURTAIN DRY CLEANING FEE</label></td><td> <input type="text" name="CCAN_tb_drycleanfee" id="CCAN_tb_drycleanfee"   style="width:45px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label style="width:230px">CHECKOUT CLEANING FEE</label></td><td> <input type="text" name="CCAN_tb_checkoutcleaningfee" id="CCAN_tb_checkoutcleaningfee"   style="width:45px;" class="rdonly"readonly /></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>&nbsp;&nbsp;<label>DEPOSIT</label></td><td> <input type="text" name="CCAN_tb_deposit" id="CCAN_tb_deposit"   style="width:55px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>RENT</label></td><td> <input type="text" name="CCAN_tb_rent" id="CCAN_tb_rent"   style="width:55px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label style="width:230px">PROCESSING COST</label></td><td> <input type="text" name="CCAN_tb_processingfee" id="CCAN_tb_processingfee"   style="width:55px;"class="rdonly" readonly/></td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                    <table id="CCAN_tble_comment"><tr>-->
<!--                            <td style="width:245px">&nbsp;&nbsp;<label>COMMENTS</label></td><td> <textarea name="CCAN_ta_comments" id="CCAN_ta_comments"></textarea></td> </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--                <div  id="CCAN_div_buttons" style="position:relative;left:130px;" hidden>-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <td ><input class="btn" type="button"  id="CCAN_btn_submitbutton" name="submit" value="CANCEL"  /></td>-->
<!--                            <td ><input class="btn clear" type="button"  id="CCAN_btn_resetbutton" name="reset" value="RESET"  /></td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--                <div  id="CCAN_div_uncancelbuttons" style="position:relative;left:130px;" hidden>-->
<!--                    <table>-->
<!--                        <tr>-->
<!--                            <td ><input class="maxbtn" type="button"  id="CCAN_btn_uncancelbutton" name="submit" value="UNCANCEL"  /></td>-->
<!--                            <td ><input class="maxbtn clear" type="button"  id="CCAN_btn_resetbutton1" name="reset" value="RESET"  /></td>-->
<!--                        </tr>-->
<!--                    </table>-->
<!--                </div>-->
<!--            </tr>-->
<!--        </table>-->
<!--    </form>-->
<!--</div>-->
<body>
<div class="container">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif"  /></div></div></div>

<!--    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>-->
    <div class="title text-center"><h4><b>CUSTOMER CANCELLATION</b></h4></div>
    <form id="CCAN_form_cancelform" name="CCAN_cancel_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div style="padding-bottom: 15px" id="CCAN_tble_main" hidden>
                    <div class="radio">
                        <label >
                            <input  type="radio"  name="CCAN_mainradiobutton" id="CCAN_radio_cancellist"  value="CANCEL CUSTOMER" >
                            CANCEL CUSTOMER
                        </label>
                    </div>
                    <div class="radio">
                        <label >
                            <input type="radio" name="CCAN_mainradiobutton" id="CCAN_radio_uncancellist" value="UNCANCEL CUSTOMER" >
                            UNCANCEL CUSTOMER
                        </label>

                    </div>
                    <div><label id="CCAN_lbl_title" class="srctitle" style="text-align:CENTER;width:400px" hidden></label></div>
                </div>
                <div id='CCAN_tble_unitno'  hidden>
                     <div class="form-group" id="CCAN_unitno">
                       <label class="col-sm-3">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CCAN_unitnumber" id="CCAN_lb_selectunit" class="form-control CCAN_formvalidation"></select></div>
                </div>
                </div>
                <div class="form-group" id="CCAN_custname" hidden>
                    <label class="col-sm-3">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-3"><select name="CCAN_name" id="CCAN_lb_selectname" class="CCAN_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CCAN_custid" hidden>
                </div>
                <div class="form-group" id="CCAN_leaseperiod" hidden>
                    <label class="col-sm-3">LEASE PERIOD <em>*</em></label>
                    <div class="col-sm-2"><select name="CCAN_lb_leaseperiod" id="CCAN_lb_leaseperiod" class="CCAN_formvalidation form-control"></select></div>
                </div>
                <div class="col-sm-offset-3 col-sm-10" id="CCAN_error">
                    <label id="CCAN_lbl_error" name="CCAN_lbl_error" class="errormsg"></label>
                </div>
                <div id="CCAN_CCANrdassigndiv" hidden>
                    <div id='CCAN_personaldetails'>
                        <div class="form-group">
                            <label class="col-sm-3">FIRST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_firstname" id="CCAN_tb_firstname"  class="form-control CCAN_formvalidation" maxlength="50" readonly placeholder="First Name"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">LAST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_lastname" id="CCAN_tb_lastname"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Last Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">COMPANY NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_companyname" id="CCAN_tb_companyname"  class="form-control CCAN_formvalidation" placeholder="Company Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EMAIL ID</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_email" id="CCAN_tb_email"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Email Id" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_mobileno" id="CCAN_tb_mobileno"  maxlength="6" class="form-control CCAN_formvalidation" placeholder="Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">INT'L MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_intmobileno" id="CCAN_tb_intmobileno"  maxlength="15" class="form-control CCAN_formvalidation" placeholder="Int'l Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">OFFICE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_officeno" id="CCAN_tb_officeno"  maxlength="8" class="form-control CCAN_formvalidation" placeholder="Office No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DATE OF BIRTH</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_dob" id="CCAN_tb_dob"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="DOB" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NATIONALITY</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_nation" id="CCAN_tb_nation"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Nationality" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT NUMBER</label>
                            <div class="col-sm-3"> <input type="text" name="CCAN_tb_passno" id="CCAN_tb_passno"  maxlength="15" class="form-control CCAN_formvalidation" placeholder="Passport Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_passdate" id="CCAN_tb_passdate"  maxlength="50" class="form-control CCAN_formvalidation" placeholder=" Passport Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP NUMBER</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_epno" id="CCAN_tb_epno"  maxlength="15" class="form-control CCAN_formvalidation" placeholder="EP Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_epdate" id="CCAN_tb_epdate" class="form-control CCAN_formvalidation" placeholder="EP Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ROOM TYPE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_roomtype" id="CCAN_tb_roomtype" class="form-control CCAN_formvalidation" placeholder="Room Type" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CUSTOMER CARD </label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_cardno[]" id="CCAN_tb_cardno" class="form-control CCAN_formvalidation" placeholder="Customer Card" readonly/></div>
                        </div>
                    </div>
                    <div id="CCAN_cardno_radio">
                        <div class="form-group">
                            <label class="col-sm-3">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="CCAN_selectcard" id="CCAN_rd_selectcard" value='CARD' class='radio_selected'>CARD NUMBER</label>
                                    <label align='bottom' name='error' id='CCAN_lbl_radioerror' visible="false" class='errormsg'></label>
                                </div>
                                <div id="CCAN_avail_cardno" style="padding-left: 10px;display: none;" hidden="hidden">
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="CCAN_selectcard" id="CCAN_radio_null" value='NULL' class='radio_selected'>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CCAN_feedetails">
                        <div class="form-group">
                            <label class="col-sm-3">CHECK IN DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_startdate" id="CCAN_tb_startdate" class="form-control CCAN_formvalidation" placeholder="Check in Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECK OUT DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_enddate" id="CCAN_tb_enddate" class="form-control CCAN_formvalidation" placeholder="Check out Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE PERIOD</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_noticeperiod" id="CCAN_tb_noticeperiod" class="form-control CCAN_formvalidation" placeholder="Notice Period" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_noticedate" id="CCAN_tb_noticedate" class="form-control CCAN_formvalidation" placeholder="Notice Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ELECTRICITY CAPPED</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_elect" id="CCAN_tb_elect" class="form-control CCAN_formvalidation" placeholder="Electricity Capped" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label id="CCAN_lbl_fixedfee" class="col-sm-3">AIRCON FIXED FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_fixed" id="CCAN_tb_fixed" class="form-control CCAN_formvalidation" placeholder="Aircon Fixd Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CURTAIN DRY CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_drycleanfee" id="CCAN_tb_drycleanfee"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Curtain Dry Cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECKOUT CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_checkoutcleaningfee" id="CCAN_tb_checkoutcleaningfee"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Checkout cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DEPOSIT</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_deposit" id="CCAN_tb_deposit"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Deposit" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">RENT</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_rent" id="CCAN_tb_rent"  maxlength="50" class="form-control CCAN_formvalidation" placeholder="Rent" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PROCESSING COST</label>
                            <div class="col-sm-2"> <input type="text" name="CCAN_tb_processingfee" id="CCAN_tb_processingfee" maxlength="50" class="form-control CCAN_formvalidation" placeholder="Processing Cost" readonly/></div>
                        </div>
                    </div>
                    <div id='CCAN_comment'>
                        <div class="form-group">
                            <label class="col-sm-3">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="CCAN_ta_comments" id="CCAN_ta_comments" class="form-control CCAN_formvalidation" rows="5"></textarea></div>
                        </div>
                    </div>
                    <div id="CCAN_guest_cardno" hidden>
                    </div>
                    <div class="form-group" id="buttons">
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" id="CCAN_btn_submitbutton" name="ASSIGN" value="ASSIGN" disabled/>
                            <input class="btn btn-info" type="button" id="CCAN_btn_resetbutton" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</body>
<!---BODY TAG END-->
</html>
<!---HTML TAG END-->