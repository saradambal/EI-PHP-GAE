<?php
require_once "Header.php";
?>
<html>
<head>
    <script type="text/javascript">
        // document ready function
        $(document).ready(function(){
            $('textarea').autogrow({onInitialize: true});
            $('#CA_custname').hide();
            $('#CA_personaldetails').hide();
            $('#CA_cardno_radio').hide();
            $('#CA_avail_cardno').hide();
            $('#CA_feedetails').hide();
            $('#CA_custid').hide();
            $('#CA_comment').hide();
            $('#CA_guest_cardno > div').remove();
            // initial data
            $('#spacewidth').height('0%');
            var CA_available_card=[];
            var CA_allcust_values;
            var CA_errorAarray;
            var CA_cust_id;
            $('#CA_btn_submitbutton').hide();
            $('#CA_btn_resetbutton').hide();
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('Cnlr_Customer_access_card_card_assign/Initialdata'); ?>",
                data:{'ErrorList':'337,169,105,400'},
                success: function(data){
                    var value_array=JSON.parse(data);
                    $('.preloader').hide();

                    CA_errorAarray=value_array[1];
                    CA_allcust_values=value_array[0];
                    if(CA_allcust_values.length==0)
                    {
                        $('#cardassign_form').replaceWith('<form id="cardassign_form" class="form-horizontal content" role="form"><div class="panel-body"><fieldset><div class="form-group"><label class="errormsg"> '+CA_errorAarray[4].EMC_DATA+'</label></div></fieldset></div></form>');
                    }
                    else
                    {
                        var CA_unit_array=[];
                        var CA_unitno_options ='<option>SELECT</option>';
                        for(var k=0;k<CA_allcust_values.length;k++)
                        {
                            CA_unit_array.push(CA_allcust_values[k].UNIT_NO)
                        }
                        CA_unit_array=unique(CA_unit_array);
                        for (var i = 0; i < CA_unit_array.length; i++)
                        {
                            CA_unitno_options += '<option value="' + CA_unit_array[i] + '">' + CA_unit_array [i]+ '</option>';
                        }
                        $('#CA_lb_unitno').html(CA_unitno_options);
                    }
                    $('#CA_lb_unitno').show();
                }
            });
            function unique(a) {
                var result = [];
                $.each(a, function(i, e) {
                    if ($.inArray(e, result) == -1) result.push(e);
                });
                return result;
            }
        // GET CUSTOMER NAME FOR THE SELECTED UNIT
            $('#CA_lb_unitno').change(function(){
                var CA_unit = $(this).val();
                if(CA_unit=='SELECT'){
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_custid > div').remove();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_custid]').attr('checked',false);
                    $('#CA_lb_custname').val('SELECT').hide();
                    $('#CA_custname').hide();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    $('#CA_lbl_error').hide();
                }
                else
                {
                    $('#CA_div_cardassigned').hide();
                    $('#CA_lbl_error').hide();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_custid > div').remove();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_lb_custname').val('SELECT').hide();
                    $('#CA_custname').show();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    var CA_namearray=[];
                    for(var k=0;k<CA_allcust_values.length;k++)
                    {
                        if(CA_allcust_values[k].UNIT_NO==CA_unit)
                        {
                            CA_namearray.push(CA_allcust_values[k].CUSTOMERNAME);
                        }
                    }
                    CA_namearray=unique(CA_namearray);
                    var CA_custname_options ='<option>SELECT</option>'
                    for (var i = 0; i < CA_namearray.length; i++) {
                        var CA_myarray=CA_namearray[i].split('_');
                        var CA_custname=CA_myarray[0]+' '+CA_myarray[1];
                        CA_custname_options += '<option value="' + CA_namearray[i] + '">' + CA_custname + '</option>';
                    }
                    $('#CA_lb_custname').html(CA_custname_options);
                    $('#CA_lb_custname').show();
                }
            });
        // GET DETAIL'S FOR SELECTED CUSTOMER NAME
            $('#CA_lb_custname').change(function(){
                var CA_name=$(this).val();
                if(CA_name=='SELECT')
                {
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_custid > div').remove();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_custid]').attr('checked',false);
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_leaseperiod').hide();
                    $('#CA_lbl_error').hide();
                }
                else
                {
                    $(".preloader").show();
                    $('#CA_lbl_error').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('#CA_custid > div').remove();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_leaseperiod').hide();
                    var CA_name_id_array=[];
                    var CA_unit=$('#CA_lb_unitno').val();
                    for(var k=0;k<CA_allcust_values.length;k++)
                    {
                        if(CA_allcust_values[k].CUSTOMERNAME==CA_name && CA_allcust_values[k].UNIT_NO==CA_unit)
                        {
                            CA_name_id_array.push(CA_allcust_values[k].CUSTOMER_ID);
                        }
                    }
                    CA_name_id_array=unique(CA_name_id_array);
                    if(CA_name_id_array.length!=1)
                    {
                        $(".preloader").hide();
                        $('#CA_personaldetails').hide();
                        $('#CA_cardno_radio').hide();
                        $('#CA_feedetails').hide();
                        $('#CA_custid').show();
                        $('#CA_leaseperiod').hide();
                        var CA_customername=$('#CA_lb_custname').val();
                        var CA_myarray=CA_customername.split('_');
                        var CA_custname=CA_myarray[0]+' '+CA_myarray[1];
                        var CA_radio_value='';
                        for (var i = 0; i < CA_name_id_array.length; i++) {
                            var final=CA_custname+' '+CA_name_id_array[i];
                            CA_radio_value ='<div class="col-sm-offset-3" style="padding-left:15px"><div class="radio"><label><input type="radio" name="custid" id='+CA_name_id_array[i]+' value='+CA_name_id_array[i]+' class="CA_class_custid" />'+ final +'</label></div></div>';
                            $('#CA_custid').append(CA_radio_value);
                        }
                    }
                    else{
                        CA_cust_id=CA_name_id_array[0];
                        CA_load_customer_recver(CA_name_id_array[0]);
                        $('#CA_custid > div').remove();
                    }
                }
            });
        // FUNCTION TO CALL TO SHOW CUSTOMER DETAIL'S FROM RADIO BUTTON
            $(document).on("change",'.CA_class_custid', function ()
            {
                $(".preloader").show();
                var CA_customerid=$("input[name=custid]:checked").val();
                CA_cust_id=CA_customerid;
                var CA_unit=$('#CA_lb_unitno').val();
                $('#CA_personaldetails').hide();
                $('#CA_cardno_radio').hide();
                $('#CA_feedetails').hide();
                $('#CA_lbl_radioerror').hide();
                $('#CA_avail_cardno > div').remove();
                $('#CA_guest_cardno > div').remove();
                $('input:radio[name=CA_selectcard]').attr('checked',false);
                $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                $('#CA_leaseperiod').hide();
                $('#CA_btn_resetbutton').hide();
                $('#CA_comment').hide();
                $('#CA_lbl_error').hide();
                CA_load_customer_recver(CA_customerid);
            });
        // FUNCTION TO LOAD CUSTOMER RECORD VERSION
            function CA_load_customer_recver(cust_id){
                var CA_cust_recver=[];
                var CA_unit=$('#CA_lb_unitno').val();
                for(var k=0;k<CA_allcust_values.length;k++)
                {
                    if(CA_allcust_values[k].CUSTOMER_ID==cust_id && CA_allcust_values[k].UNIT_NO==CA_unit)
                    {
                        CA_cust_recver.push(CA_allcust_values[k].CED_REC_VER+'_'+CA_allcust_values[k].CLP_STARTDATE+'_'+CA_allcust_values[k].CLP_ENDDATE);
                    }
                }
                CA_cust_recver=unique(CA_cust_recver);
                var CA_recver_options ='<option>SELECT</option>';
                for (var i = 0; i < CA_cust_recver.length; i++)
                {
                    var value=CA_cust_recver[i].split("_");
                    CA_recver_options += '<option value="' + value[0] + '" title="'+value[1]+"---"+value[2]+'">' + value[0]+ '</option>';
                }
                $('#CA_lb_leaseperiod').html(CA_recver_options);
                $('#CA_leaseperiod').show();
                $(".preloader").hide();
            }
        // GET AVAILABLE CARD's FOR SELECTED UNIT
            $('.radio_selected').change(function(){
                var radio=$("input[name=CA_selectcard]:checked").val();
                $('#CA_avail_cardno > div').remove();
                $('#CA_avail_cardno').hide();
                $('#CA_lbl_radioerror').hide();
                var CA_unit=$('#CA_lb_unitno').val();
                var CA_fname=$('#CA_tb_firstname').val();
                var CA_lname=$('#CA_tb_lastname').val();
                var CA_recver=$('#CA_lb_leaseperiod').val();
                if(radio=='CARD'){
                    $('#CA_btn_submitbutton').attr("disabled","disabled");
                    $(".preloader").show();
                    CA_load_availablecards(available_card);
                }
                else{
                    $('#CA_btn_submitbutton').removeAttr('disabled');
                }
            });
        // FUNCTION TO CALL TO DISPLAY AVAILABLE CARD'S
            function CA_load_availablecards(CA_result_card)
            {
                $(".preloader").hide();
                CA_available_card=CA_result_card;
                var CA_cust_cardarray=[];
                var CA_availablecard_array=[];
                CA_cust_cardarray=CA_result_card[0];
                CA_availablecard_array=CA_result_card[1];
                if(CA_availablecard_array.length==0 &&CA_cust_cardarray.length==0)
                {
                    $('#CA_lbl_radioerror').text(CA_errorAarray[0].EMC_DATA);
                    $('#CA_lbl_radioerror').css("color","red");
                    $('#CA_lbl_radioerror').show();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                }
                else{
                    var unit=$('#CA_lb_unitno').val();
                    if(CA_cust_cardarray.length!=0){
                        $('#CA_rd_selectcard').attr('checked',true);
                        CA_show_cards(CA_result_card);
                    }
                    else{
                        CA_show_cards(CA_result_card);
                    }
                }
            }
        // FUNCTION TO SHOW AVAILABLE CARD'S
            function CA_show_cards(CA_result_card)
            {
                var CA_gcardarray=[];
                CA_gcardarray=CA_result_card[0];
                var CA_cardArray= [];
                CA_cardArray=CA_result_card[1];
                var CA_cardlbl_array=[];
                CA_cardlbl_array=CA_result_card[2];
                $('#CA_avail_cardno > div').remove();
                if(CA_gcardarray.length!=0){
                    for(var j=0;j<CA_gcardarray.length;j++){
                        var CA_checkboxid1='CA_cb_cardnumber'+j;
                        var CA_listboxid='CA_lb_selectnamelist'+j;
    //                    var va='CA_ta_selectnamelist1'+j;
                        var CA_myarray=CA_gcardarray[j].split('/');
                        var CA_cust_cardno=CA_myarray[0];
                        if(j==0){
                            var CA_custname=CA_myarray[1];
                            var CA_custname1=CA_custname.replace(/__/g," ");
                            var name=CA_custname1.split('_');
                            var customername=name[0]+' '+name[1];
                        }
                        else
                        {
                            var CA_custname=CA_myarray[1]+j;
                        }
                        if(CA_cardArray.length==0 && CA_gcardarray.length==1){
    //                        var CA_cardno1 ='<tr><td >                                                                      <input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked" disabled  />' + CA_cust_cardno + '</td><td>                              <select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber" disabled  /></td><td><input type="text" id='+va+' name="CA_selectnamelist1" value='+CA_gcardarray[j]+' hidden    /></td></tr>';
                            var CA_cardno1 ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked" disabled/>' + CA_cust_cardno + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" readonly></select></div></div>';
                        }
                        else
                        {
    //                        var CA_cardno1 ='<tr><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    <input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked"   />' + CA_cust_cardno + '</td><td>                             <select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber" disabled  /></td><td><input type="text" id='+va+' name="CA_selectnamelist1" value='+CA_gcardarray[j]+' hidden    /></td></tr>';
                            var CA_cardno1 ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cust_cardno+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" checked="checked"/>' + CA_cust_cardno + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" readonly></select></div></div>';
                        }
                        $('#CA_avail_cardno').append(CA_cardno1);
                        $('#CA_avail_cardno').show();
                        var options ='<option>SELECT</option>';
                        if(j==0){
                            options+='<option value=' + CA_custname + '>' + customername + '</option>';
                        }
                        else{
                            options+='<option value=' + CA_custname + '>' + CA_custname + '</option>';
                        }
                        $('#CA_lb_selectnamelist'+j).html(options);
                        $('#CA_lb_selectnamelist'+j).prop('selectedIndex',1)
                    }
                    for (var i=0;i<CA_cardArray.length;i++)
                    {
                        var CA_listboxid='CA_lb_selectnamelist'+j;
                        var CA_checkboxid1='CA_cb_cardnumber'+j;
                        var va='CA_ta_selectnamelist1'+j;
                        if(CA_gcardarray.length==4)
                        {
    //                        var CA_cardno ='<tr><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    <input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" disabled  />' + CA_cardArray[i] + '</td><td>                               <select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber" visibility: hidden;   /></td><td><input type="text" id='+va+' name="CA_selectnamelist1" hidden   /></td></tr>';
                            var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber" disabled/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" visibility: hidden;></select></div></div>';
                        }
                        else{
    //                        var CA_cardno ='<tr><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    <input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"   />' + CA_cardArray[i] + '</td><td>                              <select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber" visibility: hidden;   /></td><td><input type="text" id='+va+' name="CA_selectnamelist1"  hidden  /></td></tr>';
                            var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" visibility: hidden;></select></div></div>';
                        }
                        $('#CA_avail_cardno').append(CA_cardno);
                        $('#CA_avail_cardno').show();
                        var options ='<option>SELECT</option>';
                        for(var k=0;k<CA_cardlbl_array.length;k++)
                        {
                            options += '<option value="' + CA_cardlbl_array[k] + '">' + CA_cardlbl_array[k] + '</option>';
                        }
                        $('#CA_lb_selectnamelist'+j).html(options);
                        j++;
                    }
                }
                if(CA_gcardarray.length==0){
                    for (var i=0;i<CA_cardArray.length;i++)
                    {
                        var CA_listboxid='CA_lb_selectnamelist'+i;
                        var CA_checkboxid1='CA_cb_cardnumber'+i;
                        var va='CA_ta_selectnamelist1'+i;
    //                    var CA_cardno ='<tr><td >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;    <input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"   />' + CA_cardArray[i] + '</td><td>                              <select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber"  visibility: hidden; /></td><td><input type="text" id='+va+' name="CA_selectnamelist1" hidden   /></td></tr>';
                        var CA_cardno ='<div class="row form-group"><div class="col-md-2"><div class="checkbox"><label><input type="checkbox" value='+CA_cardArray[i]+' id='+CA_checkboxid1+' name="checkbox" class="CA_class_cardnumber"/>' + CA_cardArray[i] + '</label></div></div><div class="col-md-5"><select id='+CA_listboxid+' name="CA_selectnamelist" class="CA_class_cardnumber CA_formvalidation form-control" visibility: hidden;></select></div></div>';
                        $('#CA_avail_cardno').append(CA_cardno);
                        $('#CA_avail_cardno').show();
                    }
                    for(var i=0;i<CA_cardArray.length;i++){
                        var options ='<option>SELECT</option>';
                        for(var j=0;j<CA_cardlbl_array.length;j++)
                        {
                            if(j==0){
                                var CA_custname=CA_cardlbl_array[j];
                                var name=CA_custname.split('_');
                                var customername=name[0]+' '+name[1];
                                options += '<option value="' + CA_custname + '">' +customername+ '</option>';
                            }
                            else{
                                options += '<option value="' + CA_cardlbl_array[j] + '">' + CA_cardlbl_array[j] + '</option>';
                            }
                        }
                        $('#CA_lb_selectnamelist'+i).html(options);
                    }
                }
            }
        // CHANGE EVENT FOR LEASE PERIOD
            $('#CA_lb_leaseperiod').change(function(){
                var CA_recver=$(this).val();
                if(CA_recver=="SELECT"){
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('#CA_btn_resetbutton').hide();
                    $('#CA_lbl_error').hide();
                }
                else{
                    $(".preloader").show();
                    $('#CA_lbl_radioerror').hide();
                    $('#CA_cardassigndiv').hide();
                    $('#CA_avail_cardno > div').remove();
                    $('#CA_guest_cardno > div').remove();
                    $('input:radio[name=CA_selectcard]').attr('checked',false);
                    $('#CA_btn_submitbutton').attr("disabled","disabled").hide();
                    $('#CA_btn_resetbutton').hide();
                    var CA_unit=$('#CA_lb_unitno').val();
                    $.ajax({
                        type:'POST',
                        url:"<?php echo site_url('Cnlr_Customer_access_card_card_assign/Customerdetails'); ?>",
                        data:{'CA_recver':CA_recver,'CA_unit':CA_unit,'CA_cust_id':CA_cust_id},
                        success: function(data){
                            var value_array=JSON.parse(data);
//                            CCARD_load_customerdetails(value_array)
                        }
                    })
                }
            });
        // FUNCTION TO LOAD CUSTOMER DETAILS'S
//            var available_card;
//            var CCARD_guest_array;
//            function CCARD_load_customerdetails(value_array)
//            {
//                var CCARD_customerdetails=[];
//                CCARD_customerdetails=data[0];
//                CCARD_guest_array=data[1];
//                available_card=data[2]
//                var check_card_flag=data[3];
//                var check_rec_ver=data[4];
//                var CCARD_fname_length=(CCARD_customerdetails.firstname).length;
//                var CCARD_lname_length=(CCARD_customerdetails.lastname).length
//                var CCARD_email_length=(CCARD_customerdetails.email).length
//                var CCARD_nation_length=(CCARD_customerdetails.nationality).length;
//                var CCARD_startdate=CCARD_customerdetails.startdate;
//                CCARD_startdate=FormTableDateFormat(CCARD_startdate);
//                var CCARD_enddate=CCARD_customerdetails.enddate;
//                CCARD_enddate=FormTableDateFormat(CCARD_enddate);
//                var CCARD_passportdate=CCARD_customerdetails.passportdate;
//                if(CCARD_customerdetails.company!=null){
//                    var CCARD_companyname_length=(CCARD_customerdetails.company).length;
//                    $('#CCARD_tb_companyname').attr("size",CCARD_companyname_length+9)
//                }
//                else{
//                    $('#CCARD_tb_companyname').attr("size",5)
//                }
//                if(CCARD_passportdate!=null)
//                {
//                    CCARD_passportdate=FormTableDateFormat(CCARD_passportdate);
//                }
//                var CCARD_dob=CCARD_customerdetails.dob;
//                if(CCARD_dob!=null){
//                    CCARD_dob=FormTableDateFormat(CCARD_dob);
//                }
//                var CCARD_passportdate=CCARD_customerdetails.passportdate;
//                if(CCARD_passportdate!=null){
//                    CCARD_passportdate=FormTableDateFormat(CCARD_passportdate)
//                }
//                var CCARD_epdate=CCARD_customerdetails.epdate;
//                if(CCARD_epdate!=null){
//                    CCARD_epdate=FormTableDateFormat(CCARD_epdate)
//                }
//                var CCARD_noticedate=CCARD_customerdetails.noticedate;
//                if(CCARD_noticedate!=null){
//                    CCARD_noticedate=FormTableDateFormat(CCARD_noticedate)
//                }
//                var CCARD_roomtype_length=(CCARD_customerdetails.roomtype).length;
//                $('#CCARD_tb_roomtype').attr("size",CCARD_roomtype_length+3);
//                $('#CCARD_tb_lastname').attr("size",CCARD_lname_length+3);
//                $('#CCARD_tb_firstname').attr("size",CCARD_fname_length+3);
//                $('#CCARD_tb_email').attr("size",CCARD_email_length);
//                $('#CCARD_tb_nation').attr("size",CCARD_nation_length+6);
//                $('#CCARD_tb_firstname').val(CCARD_customerdetails.firstname);
//                $('#CCARD_tb_lastname').val(CCARD_customerdetails.lastname);
//                $('#CCARD_tb_email').val(CCARD_customerdetails.email);$('#CCARD_tb_mobileno').val(CCARD_customerdetails.mobile1);
//                $('#CCARD_tb_intmobileno').val(CCARD_customerdetails.mobile2);$('#CCARD_tb_officeno').val(CCARD_customerdetails.officeno);
//                $('#CCARD_tb_dob').val(CCARD_dob);$('#CCARD_tb_passno').val(CCARD_customerdetails.passportno);
//                $('#CCARD_tb_passdate').val(CCARD_passportdate);$('#CCARD_tb_epno').val(CCARD_customerdetails.epno);
//                $('#CCARD_tb_epdate').val(CCARD_epdate);$('#CCARD_tb_roomtype').val(CCARD_customerdetails.roomtype);
//                $('#CCARD_tb_cardno').val(CCARD_customerdetails.cardno);
//                $('#CCARD_tb_startdate').val(CCARD_startdate);
//                $('#CCARD_tb_enddate').val(CCARD_enddate);
//                $('#CCARD_tb_noticeperiod').val(CCARD_customerdetails.noticeperiod);
//                $('#CCARD_tb_noticedate').val(CCARD_noticedate);$('#CCARD_tb_elect').val(CCARD_customerdetails.electricitycap);
//                $('#CCARD_tb_drycleanfee').val(CCARD_customerdetails.drycleanfee);$('#CCARD_tb_checkoutcleaningfee').val(CCARD_customerdetails.checkoutcleaningfee);
//                $('#CCARD_tb_deposit').val(CCARD_customerdetails.deposit);$('#CCARD_tb_rent').val(CCARD_customerdetails.rental);
//                $('#CCARD_tb_processingfee').val(CCARD_customerdetails.processingfee);$('#CCARD_ta_comments').val(CCARD_customerdetails.comments);
//                $('#CCARD_tb_companyname').val(CCARD_customerdetails.company);
//                $('#CCARD_tb_nation').val(CCARD_customerdetails.nationality);
//                $('#CCARD_ta_comments').height(20);
//                var CCARD_quaterlyfee=CCARD_customerdetails.airconquartelyfee
//                var CCARD_fixedfee=CCARD_customerdetails.airconfixedfee
//                if(CCARD_quaterlyfee==null)
//                {
//                    $('#CCARD_tb_fixed').val(CCARD_customerdetails.airconfixedfee)
//                    $('#CCARD_lbl_fixedfee').text("AIRCON FIXED FEE")
//                    $('#CCARD_tb_fixed').show();
//                }
//                else if(CCARD_fixedfee==null)
//                {
//                    $('#CCARD_tb_fixed').val(CCARD_customerdetails.airconquartelyfee)
//                    $('#CCARD_lbl_fixedfee').text("AIRCON QUATERLY FEE")
//                    $('#CCARD_tb_fixed').show();
//                }
//                if((CCARD_customerdetails.cardno==null)){
//                    $('#CCARD_radio_null').attr("disabled","disabled")
//                }
//                else{
//                    CCARD_load_availablecards(available_card)
//                    $('#CCARD_radio_null').removeAttr("disabled")
//                }
//                if(CCARD_guest_array.length!=0)
//                {
//                    var CCARD_value='';
//                    for (var i = 0; i < CCARD_guest_array.length; i++) {
//                        CCARD_value = '<tr ><td style="width:223px"><lable style="width:223px" visibility:hidden; >GUEST '+(i+1)+ ' CARD </lable></td>    <td>    </td><td>   </td>  <td></td><td></td><td></td><td></td><td><input type="text" name="CCARD_tb_cardno" id='+CCARD_guest_array[i]+' value='+CCARD_guest_array[i]+' style="width:50px;"  readonly hidden /></td></tr>';
//                        $('#CCARD_tble_guest_cardno').append(CCARD_value);
//                    }
//                }
//                else
//                {
//                    $('#CCARD_tble_guest_cardno tr').remove();
//                }
//                if(check_card_flag==0){
//                    $('#CCARD_tble_personaldetails').show();
//                    $('#CCARD_tble_cardno_radio').show();
//                    $('#CCARD_tble_feedetails').show();
//                    $('#CCARD_div_cardassigned').show();
//                    $('#CCARD_btn_submitbutton').show();
//                    $('#CCARD_btn_resetbutton').show();
//                    $('#CCARD_tble_comment').show();
//                    $('#CCARD_lbl_err').hide();
//                }
//                else{
//                    $('#CCARD_tble_personaldetails').hide();
//                    $('#CCARD_tble_cardno_radio').hide();
//                    $('#CCARD_tble_feedetails').hide();
//                    $('#CCARD_div_cardassigned').hide();
//                    $('#CCARD_btn_submitbutton').hide();
//                    $('#CCARD_btn_resetbutton').hide();
//                    $('#CCARD_tble_comment').hide();
//                    var CCARD_LP=check_rec_ver;
//                    var msg=(CCARD_errorAarray[6]).replace('[LP]',CCARD_LP)
//                    $('#CCARD_lbl_err').text(msg);
//                    $('#CCARD_lbl_err').show();
//                    $('#CCARD_lb_selecrecver').prop('selectedIndex',0);
//                }
//                $(".preloader").hide();
//            }
        });
    </script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>CUSTOMER CARD ASSIGN</b></h4></div>
    <form id="cardassign_form" name="cardassign_form" class="form-horizontal content" role="form">
        <div class="panel-body">
            <fieldset>
                <div class="form-group" id="CA_unitno">
                    <label class="col-sm-3">UNIT NUMBER <em>*</em></label>
                    <div class="col-sm-2"> <select name="CA_lb_unitno" id="CA_lb_unitno" class="form-control CA_formvalidation"></select></div>
                </div>
                <div class="form-group" id="CA_custname" hidden>
                    <label class="col-sm-3">CUSTOMER NAME <em>*</em></label>
                    <div class="col-sm-3"><select name="CA_lb_custname" id="CA_lb_custname" class="CA_formvalidation form-control"></select></div>
                </div>
                <div class="form-group" id="CA_custid" hidden>
                </div>
                <div class="form-group" id="CA_leaseperiod" hidden>
                    <label class="col-sm-3">LEASE PERIOD <em>*</em></label>
                    <div class="col-sm-2"><select name="CA_lb_leaseperiod" id="CA_lb_leaseperiod" class="CA_formvalidation form-control"></select></div>
                </div>
                <div class="col-sm-offset-3 col-sm-10" id="CA_error">
                    <label id="CA_lbl_error" name="CA_lbl_error" class="errormsg"></label>
                </div>
                <div id="CA_cardassigndiv">
                    <div id='CA_personaldetails'>
                        <div class="form-group">
                            <label class="col-sm-3">FIRST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_firstname" id="CA_tb_firstname"  class="form-control CA_formvalidation" maxlength="50" readonly placeholder="First Name"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">LAST NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_lastname" id="CA_tb_lastname"  maxlength="50" class="form-control CA_formvalidation" placeholder="Last Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">COMPANY NAME</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_companyname" id="CA_tb_companyname"  class="form-control CA_formvalidation" placeholder="Company Name" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EMAIL ID</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_email" id="CA_tb_email"  maxlength="50" class="form-control CA_formvalidation" placeholder="Email Id" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_mobileno" id="CA_tb_mobileno"  maxlength="6" class="form-control CA_formvalidation" placeholder="Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">INT'L MOBILE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_intmobileno" id="CA_tb_intmobileno"  maxlength="15" class="form-control CA_formvalidation" placeholder="Int'l Mobile No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">OFFICE NO</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_officeno" id="CA_tb_officeno"  maxlength="8" class="form-control CA_formvalidation" placeholder="Office No" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DATE OF BIRTH</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_dob" id="CA_tb_dob"  maxlength="50" class="form-control CA_formvalidation" placeholder="DOB" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NATIONALITY</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_nation" id="CA_tb_nation"  maxlength="50" class="form-control CA_formvalidation" placeholder="Nationality" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT NUMBER</label>
                            <div class="col-sm-3"> <input type="text" name="CA_tb_passno" id="CA_tb_passno"  maxlength="15" class="form-control CA_formvalidation" placeholder="Passport Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PASSPORT EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_passdate" id="CA_tb_passdate"  maxlength="50" class="form-control CA_formvalidation" placeholder=" Passport Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP NUMBER</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_epno" id="CA_tb_epno"  maxlength="15" class="form-control CA_formvalidation" placeholder="EP Number" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">EP EXPIRY DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_epdate" id="CA_tb_epdate" class="form-control CA_formvalidation" placeholder="EP Expiry Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ROOM TYPE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_roomtype" id="CA_tb_roomtype" class="form-control CA_formvalidation" placeholder="Room Type" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CUSTOMER CARD </label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_cardno" id="CA_tb_cardno" class="form-control CA_formvalidation" placeholder="Customer Card" readonly/></div>
                        </div>
                    </div>
                    <div id="CA_cardno_radio">
                        <div class="form-group">
                            <label class="col-sm-3">SELECT THE CARD <em>*</em></label>
                            <div class="col-md-9">
                                <div class="radio">
                                    <label><input type="radio" name="CA_selectcard" id="CA_rd_selectcard" value='CARD' class='radio_selected'>CARD NUMBER</label>
                                </div>
                                <div id="CA_avail_cardno" style="padding-left: 10px">
                                </div>
                                <label align='bottom' name='error' id='CA_lbl_radioerror' visible="false" class='errormsg'></label>
                                <div class="radio">
                                    <label><input type="radio" name="CA_selectcard" id="CA_radio_null" value='NULL' class='radio_selected'>NULL</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="CA_feedetails">
                        <div class="form-group">
                            <label class="col-sm-3">CHECK IN DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_startdate" id="CA_tb_startdate" class="form-control CA_formvalidation" placeholder="Check in Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECK OUT DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_enddate" id="CA_tb_enddate" class="form-control CA_formvalidation" placeholder="Check out Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE PERIOD</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_noticeperiod" id="CA_tb_noticeperiod" class="form-control CA_formvalidation" placeholder="Notice Period" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">NOTICE DATE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_noticedate" id="CA_tb_noticedate" class="form-control CA_formvalidation" placeholder="Notice Date" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">ELECTRICITY CAPPED</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_elect" id="CA_tb_elect" class="form-control CA_formvalidation" placeholder="Electricity Capped" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">AIRCON FIXED FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_fixed" id="CA_tb_fixed" class="form-control CA_formvalidation" placeholder="Aircon Fixd Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CURTAIN DRY CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_drycleanfee" id="CA_tb_drycleanfee"  maxlength="50" class="form-control CA_formvalidation" placeholder="Curtain Dry Cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">CHECKOUT CLEANING FEE</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_checkoutcleaningfee" id="CA_tb_checkoutcleaningfee"  maxlength="50" class="form-control CA_formvalidation" placeholder="Checkout cleaning Fee" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">DEPOSIT</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_deposit" id="CA_tb_deposit"  maxlength="50" class="form-control CA_formvalidation" placeholder="Deposit" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">RENT</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_rent" id="CA_tb_rent"  maxlength="50" class="form-control CA_formvalidation" placeholder="Rent" readonly/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3">PROCESSING COST</label>
                            <div class="col-sm-2"> <input type="text" name="CA_tb_processingfee" id="CA_tb_processingfee" maxlength="50" class="form-control CA_formvalidation" placeholder="Processing Cost" readonly/></div>
                        </div>
                    </div>
                    <div id='CA_comment'>
                        <div class="form-group">
                            <label class="col-sm-3">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="CA_ta_comments" id="CA_ta_comments" class="form-control CA_formvalidation" rows="5"></textarea></div>
                        </div>
                    </div>
                    <div id="CA_guest_cardno" hidden>
                    </div>
                    <div class="form-group" id="buttons">
                        <div class="col-sm-offset-1 col-sm-3">
                            <input class="btn btn-info" type="button" id="CA_btn_submitbutton" name="ASSIGN" value="ASSIGN" disabled/>
                            <input class="btn btn-info" type="button" id="CA_btn_resetbutton" name="RESET" value="RESET"/>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </form>
</div>
</body>
</html>