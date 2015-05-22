<?php
include "Header.php";
?>
<style>
    td, th {
        padding: 7px;
    }
    textarea{
        resize: none;
        overflow: hidden;
    }
    .glyphicon-remove,.glyphicon-trash{
        color:red;
    }
</style>

<script>
    //CHECK PRELOADER STATUS N HIDE END
    /*-------------------------------------FUNCTION FOR CHANGE DATE FORMAT---------------------------*/
    function BDTL_FormTableDateFormat(BDTL_inputdate){
        var BDTL_string  = BDTL_inputdate.split("-");
        return BDTL_string[2]+'-'+ BDTL_string[1]+'-'+BDTL_string[0];
    }
    $(document).ready(function(){
        $('.preloader').hide();
        var BDTL_flag_date=1;
        $('#spacewidth').height('0%');
        var BDTL_INPUT_errorarr=[];
        var BDTL_INPUT_expensearr=[];
        var BDTL_INPUT_invoicearr=[];
        var BDTL_INPUT_arr_aircon=[];
        var BDTL_glb_startdate='';
        var BDTL_INPUT_configmonth='';
    //RADIO  BUTTON CLICK FUNCTION
        $('.BDE_rd_selectform').click(function(){
            var radiooption=$(this).val();
            if(radiooption=='bizdetailentryform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Detail_Entry_Search_Update_Delete/BDTL_INPUT_expense_err_invoice",
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var result=JSON.parse(res);
                        BDTL_INPUT_resultset(result);

                    }
                });
            }
        });
        /*----------------------------------------------SUCCESS FUNCTION FOR EXPENSE TYPES,INVOICE & ERROR MSG--------------------------------------------------------*/
        function BDTL_INPUT_resultset(BDTL_INPUT_result){
            BDTL_INPUT_errorarr=BDTL_INPUT_result.BDTL_INPUT_error;
            BDTL_INPUT_expensearr=BDTL_INPUT_result.BDTL_INPUT_expense;
            BDTL_INPUT_invoicearr=BDTL_INPUT_result.BDTL_INPUT_invoice;
            var BDTL_INPUT_flag_unit=BDTL_INPUT_result.BDTL_INPUT_obj_unitflag;
            BDTL_INPUT_arr_aircon=BDTL_INPUT_result.BDTL_INPUT_obj_aircon;
            BDTL_INPUT_configmonth=BDTL_INPUT_result.BDTL_INPUT_obj_configmonth;
            if(BDTL_INPUT_flag_unit==false){
                $('#BDTL_INPUT_form_biz_detail').replaceWith('<p><label class="errormsg"> '+BDTL_INPUT_errorarr[5].EMC_DATA+'</label></p>')
            }
            else{
                var BDTL_INPUT_invoice_options ='<option>SELECT</option>';
                for (var i = 0; i < BDTL_INPUT_invoicearr.length; i++) {
                    BDTL_INPUT_invoice_options += '<option value="' + BDTL_INPUT_invoicearr[i].BDTL_INPUT_expensetypes_id + '">' + BDTL_INPUT_invoicearr[i].BDTL_INPUT_expensetypes_data+ '</option>';
                }
                $('#BDTL_INPUT_lb_digital_invoiceto').html(BDTL_INPUT_invoice_options);
                $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').html(BDTL_INPUT_invoice_options);
                $('#BDTL_INPUT_lb_starhub_invoiceto').html(BDTL_INPUT_invoice_options);
                var BDTL_INPUT_expense_options ='<option>SELECT</option>';
                for (var i = 0; i < BDTL_INPUT_expensearr.length; i++) {
                    BDTL_INPUT_expense_options += '<option value="' + BDTL_INPUT_expensearr[i].BDTL_INPUT_expensetypes_id + '">' + BDTL_INPUT_expensearr[i].BDTL_INPUT_expensetypes_data + '</option>';
                }
                $('#BDTL_INPUT_lb_expense_type').html(BDTL_INPUT_expense_options).show();
                $('#BDTL_INPUT_lbl_expensetype').show();
                $('#BDTL_INPUT_form_biz_detail').show();
                $("#BDTL_INPUT_tb_exp_digivoiceno").prop("title",BDTL_INPUT_errorarr[1].EMC_DATA)
            }
        }
        var BDTL_INPUT_flag_newaircon='';
        /*-----------------------------------------VALIDATION FOR CHARACTER,NUMBERS AND ALPHA NUMERIC--------------------------------------------------------*/
        $('textarea').autogrow({onInitialize: true});
        $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $(".alphanumeric").doValidation({rule:'alphanumeric'});
        $(".alphanumericdot").doValidation({rule:'alphanumeric',prop:{allowdot:true}});
        $(".numbersonly").doValidation({rule:'numbersonly',prop:{realpart:8},leadzero:true});
        $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
        $(".general").doValidation({rule:'general',prop:{uppercase:false,autosize:true}});
        $("#BDTL_INPUT_db_appl_date").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $(".BDTL_INPUT_comments").doValidation({rule:'general',prop:{uppercase:false}});
        /*--------------------------------------DATE VALIDATION FOR CABLE,INTERNET START DATE & END DATE------------------------*/
        $("#BDTL_INPUT_db_cable_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $("#BDTL_INPUT_db_internet_enddate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true});
        $("#BDTL_INPUT_db_cable_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
            onSelect: function(date){
                if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                    $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                else
                    $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#BDTL_INPUT_db_cable_startdate').val())) );
                BDTL_startdate.setDate( BDTL_startdate.getDate());
                var BDTL_newsDate = BDTL_startdate.toDateString();
                BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                $('#BDTL_INPUT_db_cable_enddate').datepicker("option","minDate",BDTL_newsDate);
            }});
        $("#BDTL_INPUT_db_internet_startdate").datepicker({dateFormat: "dd-mm-yy",changeYear: true,changeMonth: true,
            onSelect: function(date){
                if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                    $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                else
                    $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                var BDTL_startdate = new Date( Date.parse( BDTL_FormTableDateFormat( $('#BDTL_INPUT_db_internet_startdate').val())) );
                BDTL_startdate.setDate( BDTL_startdate.getDate());
                var BDTL_newsDate = BDTL_startdate.toDateString();
                BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
                $('#BDTL_INPUT_db_internet_enddate').datepicker("option","minDate",BDTL_newsDate);
            }});
        /*----------------------------------------------------CHANGE FUNCTION FOR EXPENSE TYPE-----------------------------------------------------*/
        $('#BDTL_INPUT_lb_expense_type').change(function(){
            $("textarea").height(116);
            $('#BDTL_INPUT_form_biz_detail').find('input:text').val('');
            $('textarea').val('');
            $('#BDTL_INPUT_div_errmsg_aircon,#BDTL_INPUT_div_exp_detail_err').text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            var BDTL_INPUT_all_expense_types = $(this).val();
            $('#BDTL_INPUT_lb_unitno_list').hide();
            $('#BDTL_INPUT_lbl_unitno_list').hide();
            $('#BDTL_INPUT_div_aircon').hide();
            $('#BDTL_INPUT_div_carpark').hide();
            $('#BDTL_INPUT_div_digitalvoice').hide();
            $('#BDTL_INPUT_div_electricity').hide();
            $('#BDTL_INPUT_div_starhub').hide();
            $('#BDTL_INPUT_lb_digital_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_starhub_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_airconservicedby').val('SELECT');
            $('#BDTL_INPUT_tble_btn').hide();
            if(BDTL_INPUT_all_expense_types!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Detail_Entry_Search_Update_Delete/BDTL_INPUT_all_exp_types_unitno",
                    data:{'BDTL_INPUT_all_expense_types':BDTL_INPUT_all_expense_types},
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
                        var result=JSON.parse(res);
                        BDTL_INPUT_loadunitno(result);

                    }
                });
            }
            else
            {
                $('#BDTL_INPUT_lb_unitno_list').hide();
                $('#BDTL_INPUT_lbl_unitno_list').hide();
            }
        });
        /*-----------------------------------------SUCCESS FUNCTION FOR CODING TO LOAD UNIT NO IN UNIT NO LISTBOX-----------------------------------------*/
        function BDTL_INPUT_loadunitno(BDTL_INPUT_response){
            $(".preloader").hide();
            var BDTL_INPUT_unitnosArray = [];
            BDTL_INPUT_unitnosArray = BDTL_INPUT_response;
            var options ='<option>SELECT</option>'
            if(BDTL_INPUT_unitnosArray.length==0){
                var BDTL_INPUT_oldvalue = BDTL_INPUT_errorarr[4].EMC_DATA;
                var BDTL_INPUT_newvalue = BDTL_INPUT_oldvalue.replace("[TYPE]",$('#BDTL_INPUT_lb_expense_type').find('option:selected').text());
                $('#BDTL_INPUT_div_exp_detail_err').text(BDTL_INPUT_newvalue)
            }
            else
            {
                for (var i = 0; i < BDTL_INPUT_unitnosArray.length; i++)
                {
                    options += '<option value="' + BDTL_INPUT_unitnosArray[i].BDTL_INPUT_obj_unitid + '">' + BDTL_INPUT_unitnosArray[i].BDTL_INPUT_obj_unitno + '</option>';
                }
                $('#BDTL_INPUT_lb_unitno_list').html(options);
                $('#BDTL_INPUT_lb_unitno_list').show();
                $('#BDTL_INPUT_lbl_unitno_list').show();
            }
        }
        /*--------------------------------------------------CHANGE EVENT FUNCTION FOR UNIT NUMBER------------------------------------------------------------------*/
        $('#BDTL_INPUT_lb_unitno_list').change(function(){
            $('#BDTL_INPUT_div_aircon').hide();
            $('#BDTL_INPUT_div_carpark').hide();
            $('#BDTL_INPUT_div_digitalvoice').hide();
            $('#BDTL_INPUT_div_electricity').hide();
            $('#BDTL_INPUT_div_starhub').hide();
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            $('#BDTL_INPUT_form_biz_detail').find('input:text').val('');
            $('textarea').val('');
            $("textarea").height(116);
            $('#BDTL_INPUT_div_errmsg_aircon').text('');
            $('#BDTL_INPUT_lb_digital_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_starhub_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val('SELECT');
            $('#BDTL_INPUT_lb_airconservicedby').val('SELECT');
            $('#BDTL_INPUT_tble_btn').hide();
            var BDTL_INPUT_unit_num = $(this).val();
            if(BDTL_INPUT_unit_num!='SELECT'){
                var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val();
                if(BDTL_INPUT_types_of_expense==16)
                {
                    if($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)
                    {
                        $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid"><option>SELECT</option></select>');
                        $('#BDTL_INPUT_btn_remove_aircon').replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
                    }
                    if(BDTL_INPUT_arr_aircon.length==0){
                        $('#BDTL_INPUT_lb_airconservicedby').replaceWith('<input type="text" name="BDTL_INPUT_tb_newaircon" id="BDTL_INPUT_tb_newaircon" maxlength="50" class="autosize BDTL_INPUT_class_save_valid charonly"/>');
                        $('#BDTL_INPUT_btn_add_aircon').hide();
                        $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
                        $('#BDTL_INPUT_div_errmsg_aircon').text('')
                    }
                    else{
                        var BDTL_INPUT_aircon ='<option>SELECT</option>';
                        for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                        {
                            BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                        }
                        $('#BDTL_INPUT_lb_airconservicedby').show();
                        $('#BDTL_INPUT_lb_airconservicedby').html(BDTL_INPUT_aircon);
                        $('#BDTL_INPUT_btn_add_aircon').show();
                    }
                    $('#BDTL_INPUT_div_aircon').show();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==17)
                {
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').show();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==15)
                {
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').show();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==13)
                {
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').show();
                    $('#BDTL_INPUT_div_starhub').hide();
                }
                else if(BDTL_INPUT_types_of_expense==14)
                {
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').show();
                    $('.preloader').show();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Detail_Entry_Search_Update_Delete/BDTL_INPUT_get_SDate_EDate",
                        data:{'unitselectedlist':$('#BDTL_INPUT_lb_unitno_list').find('option:selected').text()},
                        success: function(res) {
                            $('.preloader').hide();
                            var result=JSON.parse(res);
                            BDTL_INPUT_success_unitdate(result);

                        }
                    });
                }
                $('#BDTL_INPUT_tble_btn').show();
            }});
        /*--------------------------------------SETTING MIN DATE AND MAX DATE FOR APPL DATE,CABLE SDATE EDATE AND INTERNET SDATE EDATE-----------------------*/
        function BDTL_INPUT_success_unitdate(BDTL_INPUT_response_unitdate){
            $('.preloader').hide();
            BDTL_glb_startdate=BDTL_INPUT_response_unitdate.unitsdate
            var BDTL_startdate = new Date( Date.parse( BDTL_INPUT_response_unitdate.unitsdate) );
            BDTL_startdate.setDate( BDTL_startdate.getDate());
            var BDTL_newsDate = BDTL_startdate.toDateString();
            BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
            $('#BDTL_INPUT_db_appl_date,#BDTL_INPUT_db_cable_startdate,#BDTL_INPUT_db_internet_startdate,#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker("option","minDate",BDTL_newsDate);
            var BDLY_INPUT_enddate=new Date(Date.parse( BDTL_INPUT_response_unitdate.unitedate));
            var BIZDLY_SRC_chkoutdate=BDLY_INPUT_enddate.getDate();
            var BIZDLY_SRC_chkoutmonth=BDLY_INPUT_enddate.getMonth()+parseInt(BDTL_INPUT_configmonth);
            var BIZDLY_SRC_chkoutyear=BDLY_INPUT_enddate.getFullYear();
            var BDLY_INPUT_enddate_unit = new Date(BIZDLY_SRC_chkoutyear,BIZDLY_SRC_chkoutmonth,BIZDLY_SRC_chkoutdate);
            if(BDLY_INPUT_enddate_unit.setHours(0,0,0,0)<=new Date().setHours(0,0,0,0))
            {
                var BDLY_INPUT_unit_end_date=BDLY_INPUT_enddate_unit;
            }
            else{
                var BDLY_INPUT_unit_end_date=new Date();
            }
            $('#BDTL_INPUT_db_appl_date,#BDTL_INPUT_db_cable_startdate,#BDTL_INPUT_db_internet_startdate').datepicker("option","maxDate",BDLY_INPUT_unit_end_date);
            $('#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker("option","maxDate",BDLY_INPUT_enddate_unit);
        }
        /*-------------------------------------------------------REPLACE NEW AIRCON SERVICES--------------------------------------------------------------*/
        $(document).on('click','#BDTL_INPUT_btn_add_aircon,#BDTL_INPUT_btn_remove_aircon',function(){
            BDTL_INPUT_flag_newaircon='';
            $('#BDTL_INPUT_div_errmsg_aircon').text('');
            $('#BDTL_INPUT_tb_newaircon').text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            if($(this).attr('id')=="BDTL_INPUT_btn_add_aircon"){
                $('#BDTL_INPUT_lb_airconservicedby').replaceWith('<input type="text" name="BDTL_INPUT_tb_newaircon" id="BDTL_INPUT_tb_newaircon" maxlength="50" class="autosize BDTL_INPUT_class_save_valid charonly form-control"/>');
                $(this).replaceWith('<input type="button" name="BDTL_INPUT_btn_remove_aircon"  value="CLEAR" id="BDTL_INPUT_btn_remove_aircon" class="btn" />');
                $('.autosize').doValidation({rule:'general',prop:{autosize:true}});
                $(".charonly").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            }
            if($(this).attr('id')=='BDTL_INPUT_btn_remove_aircon'){
                var BDTL_INPUT_aircon='<option>SELECT</option>'
                for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                {
                    BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                }
                $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control">'+BDTL_INPUT_aircon+'</select>');
                $(this).replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
            }});
        /*------------------------------------------------CHANGE EVENT FUNCTION FOR NEW AIRCON SERVICED BY-------------------------------------------*/
        $(document).on('blur','#BDTL_INPUT_tb_newaircon',function(){
            var BDTL_INPUT_newaircon=$(this).val();
            if(BDTL_INPUT_newaircon.length==0)
            {
                BDTL_INPUT_flag_newaircon='';
                $('#BDTL_INPUT_div_errmsg_aircon').text('');
                $("#BDTL_INPUT_tb_newaircon").removeClass('invalid');
                $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            }else if(BDTL_INPUT_newaircon.length>0)
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Detail_Entry_Search_Update_Delete/BDTL_INPUT_airconservicedby_check",
                    data:{'BDTL_INPUT_newaircon':BDTL_INPUT_newaircon},
                    success: function(res) {
                        $('.preloader').hide();
                        BDTL_INPUT_airconresult(res);

                    }
                });
            }});
        /*------------------------------------------SUCCESS FUNCTION FOR NEW AIRCON SERVICED BY---------------------------------------------------*/
        function BDTL_INPUT_airconresult(BDTL_INPUT_response){
            $(".preloader").hide();
            if(BDTL_INPUT_response=='true'){
                BDTL_INPUT_flag_newaircon='false';
                $('#BDTL_INPUT_div_errmsg_aircon').text(BDTL_INPUT_errorarr[2].EMC_DATA);
                $("#BDTL_INPUT_tb_newaircon").addClass('invalid');
                $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            }
            else if((BDTL_INPUT_response=='false')&&($('#BDTL_INPUT_lb_airconservicedby').val()==undefined))
            {
                BDTL_INPUT_flag_newaircon='true';
                $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                $('#BDTL_INPUT_div_errmsg_aircon').text('');
                $("#BDTL_INPUT_tb_newaircon").removeClass('invalid');
            }
        }
        /*-------------------------------------- CHANGE EVENT FOR ACCOUNT NO VALIDATION----------------------*/
        $(document).on("change blur",'#BDTL_INPUT_tb_exp_digiaccno,#BDTL_INPUT_tb_starhub_account_no,#BDTL_INPUT_tb_exp_carno',function(){
            if(parseInt($('#BDTL_INPUT_tb_exp_digiaccno').val())==0)
                $('#BDTL_INPUT_tb_exp_digiaccno').val('')
            if(parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)
                $('#BDTL_INPUT_tb_starhub_account_no').val('')
            if(parseInt($('#BDTL_INPUT_tb_exp_carno').val())==0)
                $('#BDTL_INPUT_tb_exp_carno').val('')
        });
        /*-------------------------------------- CHANGE EVENT FOR ENABLING SUBMIT BUTTON UNTIL MANDATORY VALUES ARE GIVEN----------------------*/
        $(document).on("blur change",'.BDTL_INPUT_class_save_valid',function(){
            var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val()
            if(BDTL_INPUT_types_of_expense!='SELECT')
            {
                if(BDTL_INPUT_types_of_expense==16)
                {
                    if((($('#BDTL_INPUT_lb_airconservicedby').val()=='SELECT')&&($('#BDTL_INPUT_tb_newaircon').val()==undefined))||(($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)&&($('#BDTL_INPUT_tb_newaircon').val()==''))||(BDTL_INPUT_flag_newaircon=='false')||($('#BDTL_INPUT_tb_newaircon').val()=='')||(($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)&&(BDTL_INPUT_flag_newaircon=='')))
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                    else
                    {
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    }
                }
                else if(BDTL_INPUT_types_of_expense==17)
                {
                    if(($('#BDTL_INPUT_tb_exp_carno').val()!='')&&(parseInt($('#BDTL_INPUT_tb_exp_carno').val())!=0))
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                }
                else if(BDTL_INPUT_types_of_expense==15)
                {
                    if(($('#BDTL_INPUT_tb_exp_digivoiceno').val()!='')&&(parseInt($('#BDTL_INPUT_tb_exp_digivoiceno').val())!=0)&&(parseInt($('#BDTL_INPUT_tb_exp_digiaccno').val())!=0)&&($('#BDTL_INPUT_tb_exp_digiaccno').val()!=''))
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
                }
                else if(BDTL_INPUT_types_of_expense==13)
                {
                    if($('#BDTL_INPUT_lb_bizdetail_electricity_invoiceto').val()!='SELECT')
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");
                    else
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")
                }
                else if(BDTL_INPUT_types_of_expense==14)
                {
                    if((parseInt($('#BDTL_INPUT_tb_starhub_account_no').val())==0)||($('#BDTL_INPUT_tb_starhub_account_no').val()=='')||(($('#BDTL_INPUT_db_cable_startdate').val()=='')&&($('#BDTL_INPUT_db_cable_enddate').val()!=''))||(($('#BDTL_INPUT_db_cable_startdate').val()!='')&&($('#BDTL_INPUT_db_cable_enddate').val()==''))||(($('#BDTL_INPUT_db_internet_startdate').val()=='')&&($('#BDTL_INPUT_db_internet_enddate').val()!=''))||(($('#BDTL_INPUT_db_internet_startdate').val()!='')&&($('#BDTL_INPUT_db_internet_enddate').val()=='')))
                        BDTL_flag_date=0;
                    else
                        BDTL_flag_date=1;
                    if(BDTL_flag_date==0){
                        $('#BDTL_INPUT_btn_save').attr("disabled", "disabled")}
                    else {
                        $('#BDTL_INPUT_btn_save').removeAttr("disabled");}
                }}});
        /*------------------------------------------------CLICK FUNCTION FOR SAVE BIZ DETAILS-------------------------------------------------------*/
        $(document).on("click",'#BDTL_INPUT_btn_save',function(){
            var BDTL_INPUT_types_of_expense = $('#BDTL_INPUT_lb_expense_type').val();
            var BDTL_INPUT_unit_num = $('#BDTL_INPUT_lb_unitno_list').val();
            if(BDTL_INPUT_types_of_expense!='SELECT'){
                $('#BDTL_INPUT_hidden_unitno').val($('#BDTL_INPUT_lb_unitno_list').find('option:selected').text())
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Detail_Entry_Search_Update_Delete/BDTL_INPUT_save",
                    data:$('#BDTL_INPUT_form_biz_detail').serialize(),
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        var result=JSON.parse(res)
                        BDTL_INPUT_bizSuccess(result);

                    }
                });
//                google.script.run.withSuccessHandler(BDTL_INPUT_bizSuccess).withFailureHandler(BDTL_INPUT_onFailure).BDTL_INPUT_save(document.getElementById('BDTL_INPUT_form_biz_detail'));
            }});
        /*------------------------------------------SUCCESS FUNCTION FOR INSERTING ------------------------------------------*/
        function BDTL_INPUT_bizSuccess(BDTL_INPUT_response){
                if(BDTL_INPUT_response[1]==1){
                    var BDTL_INPUT_expensetypes='';
                    if($('#BDTL_INPUT_lb_expense_type').val()==16){
                        BDTL_INPUT_arr_aircon=BDTL_INPUT_response[0];
                    }
                    var BDTL_INPUT_errormsg_replace = BDTL_INPUT_errorarr[3].EMC_DATA.replace("[TYPE]",$('#BDTL_INPUT_lb_expense_type').find('option:selected').text());
                    show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BDTL_INPUT_errormsg_replace,"success",false);
                    $(':input,textarea','#BDTL_INPUT_form_biz_detail')
                        .not(':button')
                        .val('')
                        .removeAttr('selected');
                    $('#BDTL_INPUT_lb_unitno_list').hide();
                    $('#BDTL_INPUT_lbl_unitno_list').hide();
                    $('#BDTL_INPUT_div_aircon').hide();
                    $('#BDTL_INPUT_div_carpark').hide();
                    $('#BDTL_INPUT_div_digitalvoice').hide();
                    $('#BDTL_INPUT_div_electricity').hide();
                    $('#BDTL_INPUT_div_starhub').hide();
                    $('#BDTL_INPUT_tble_btn').hide();
                    $('#BDTL_INPUT_lb_expense_type').prop('selectedIndex',0);
                    BDTL_INPUT_reset();
                }
                else
                    show_msgbox("BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE",BDTL_INPUT_errorarr[6].EMC_DATA,"success",false);
            }
        /*----------------------------------------------------COMMON FUNCTION FOR CLEARING ALL VALUES------------------------------------*/
        function BDTL_INPUT_reset(){
            var BDTL_startdate = new Date( Date.parse( BDTL_glb_startdate) );
            BDTL_startdate.setDate( BDTL_startdate.getDate());
            var BDTL_newsDate = BDTL_startdate.toDateString();
            BDTL_newsDate = new Date( Date.parse( BDTL_newsDate ) );
            $('#BDTL_INPUT_db_cable_enddate,#BDTL_INPUT_db_internet_enddate').datepicker('option', {minDate: BDTL_newsDate});
            $("#BDTL_INPUT_div_errmsg_aircon").text('');
            $('#BDTL_INPUT_btn_save').attr("disabled", "disabled");
            $('#BDTL_INPUT_ta_starhub_comments').prop("rows",2).prop("cols",20);
            $('#BDTL_INPUT_form_biz_detail').find('input:text').prop("size","20");
        }
        /*------------------------------------------------FUNCTION FOR RESET---------------------------------------------------*/
        $(document).on("click",'#BDTL_INPUT_btn_reset',function(){
            $("#BDTL_INPUT_lb_starhub_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_bizdetail_electricity_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_digital_invoiceto").val('SELECT');
            $("#BDTL_INPUT_lb_airconservicedby").val('SELECT');
            $(':input[type=text]','#BDTL_INPUT_form_biz_detail').val('').not(':button');
            $("textarea").val('');
            $("textarea").height(116);
            BDTL_INPUT_reset();
            if($('#BDTL_INPUT_lb_airconservicedby').val()==undefined)
            {
                var BDTL_INPUT_aircon='<option>SELECT</option>'
                for (var i = 0; i < BDTL_INPUT_arr_aircon.length; i++)
                {
                    BDTL_INPUT_aircon += '<option value="' + BDTL_INPUT_arr_aircon[i] + '">' + BDTL_INPUT_arr_aircon[i] + '</option>';
                }
                $('#BDTL_INPUT_tb_newaircon').replaceWith('<select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control">'+BDTL_INPUT_aircon+'</select>');
                $('#BDTL_INPUT_btn_remove_aircon').replaceWith('<input type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon" class="btn"/>');
            }
        });
    });
</script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>BIZ EXPENSE DETAIL ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="BDTL_INPUT_form_biz_detail" class="form-horizontal content"  method="post" action="<?php echo site_url("Pdfcontroller/pdfexportbizexpense") ?>">
        <div class="panel-body">
            <div style="padding-bottom: 15px">
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizdetailentryform" class="BDE_rd_selectform">ENTRY</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio" value="bizdetailsearchform" class="BDE_rd_selectform">SEARCH/UDATE/DELETE</label>
                </div>
            </div>
            <div id="bizdetailentryform">
                <div class="form-group">
                    <label class="col-sm-2" id="BDTL_INPUT_lbl_expensetype" hidden>TYPE OF EXPENSE<em>*</em></label>
                    <div class="col-sm-3"><select id='BDTL_INPUT_lb_expense_type' name='BDTL_INPUT_lb_expense_type' class="BDTL_INPUT_class_save_valid form-control" style="display: none;">
                            <option>SELECT</option>
                        </select></div>
                </div>
                <div class="form-group">
                    <label id="BDTL_INPUT_lbl_unitno_list" class="col-sm-2" hidden>UNIT NO<em>*</em></label>
                    <div class="col-sm-2"><select id="BDTL_INPUT_lb_unitno_list"  name="BDTL_INPUT_lb_unitno_list" class="BDTL_INPUT_class_save_valid form-control" style="display: none;" hidden>
                            <option>SELECT</option>
                        </select>
                    </div>
                </div>
                <!-------------------------------------------------------CODING TO CREATE AIRON SERVICE EXPENSE FORM------------------------------------------------->
                <div id='BDTL_INPUT_div_aircon' hidden>
                        <div class="form-group">
                            <label class="col-sm-2">AIRCON SERVICED BY<em>*</em></label></td>
                            <div class="col-sm-4"><select id="BDTL_INPUT_lb_airconservicedby" name="BDTL_INPUT_lb_airconservicedby" class="BDTL_INPUT_class_save_valid form-control"><option>SELECT</option>
                                </select>
                            </div>
                            <div><input class="btn" type="button" name="BDTL_INPUT_btn_add_aircon" value="ADD" id="BDTL_INPUT_btn_add_aircon"/><td><td><input type="hidden" id="BDTL_INPUT_hidden_unitno" name="BDTL_INPUT_hidden_unitno"></td>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_aircon_comments" id="BDTL_INPUT_ta_aircon_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea>
                            </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-7"><div id="BDTL_INPUT_div_errmsg_aircon" name="BDTL_INPUT_div_errmsg_aircon" class="errormsg"></div>
                        </div>
                    </div>
                </div>
                <!------------------------------------------------------CODING TO CREATE CARPARK EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_carpark' hidden>
                        <div class="form-group">
                            <label class="col-sm-2">CAR NO<em>*</em></label>
                            <div class="col-sm-2"><input style="width:95px" type="text" name="BDTL_INPUT_tb_exp_carno" id="BDTL_INPUT_tb_exp_carno" maxlength='9' class='alphanumeric BDTL_INPUT_class_save_valid form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_carpark_comments" id="BDTL_INPUT_ta_carpark_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                </div>
                <!--------------------------------------------------CODING TO CREATE DIGITAL VOICE EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_digitalvoice' hidden>
                        <div class="form-group">
                            <label class="col-sm-2">INVOICE TO</label>
                            <div class="col-sm-3"><select id="BDTL_INPUT_lb_digital_invoiceto" name="BDTL_INPUT_lb_digital_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                    <option>SELECT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">DIGITAL VOICE NO<em>*</em></label>
                            <div class="col-sm-2"><input style="width:85px" type="text" name="BDTL_INPUT_tb_exp_digivoiceno" id="BDTL_INPUT_tb_exp_digivoiceno" class="numbersonly BDTL_INPUT_class_save_valid form-control" maxlength="8"/></div>
                        </div>
                        <div class="form-group">
                             <label class="col-sm-2">DIGITAL ACCOUNT NO<em>*</em></label>
                            <div class="col-sm-2"><input style="width:120px" type="text" name="BDTL_INPUT_tb_exp_digiaccno" id="BDTL_INPUT_tb_exp_digiaccno" maxlength="11" class='alphanumericdot BDTL_INPUT_class_save_valid form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_digitalvoice_comments" id="BDTL_INPUT_ta_digitalvoice_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                </div>
                <!-----------------------------------------CODING TO CREATE ELECTRICITY EXPENSE FORM-------------------------------------------------------------->
                <div id='BDTL_INPUT_div_electricity' hidden>
                        <div class="form-group">
                            <label class="col-sm-2">INVOICE TO<em>*</em></label>
                            <div class="col-sm-3"><select id="BDTL_INPUT_lb_bizdetail_electricity_invoiceto" name="BDTL_INPUT_lb_bizdetail_electricity_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                    <option>SELECT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_ectricity_comments" id="BDTL_INPUT_ta_ectricity_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                </div>
                <!-----------------------------------------------------------CODING TO CREATE STARHUB EXPENSE FORM------------------------------------------------------>
                <div id='BDTL_INPUT_div_starhub' hidden>
                        <div class="form-group">
                            <label class="col-sm-2">INVOICE TO</label>
                            <div class="col-sm-3"><select id="BDTL_INPUT_lb_starhub_invoiceto" name="BDTL_INPUT_lb_starhub_invoiceto" class="BDTL_INPUT_class_save_valid form-control">
                                    <option>SELECT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">STARHUB ACCOUNT NO<em>*</em></label>
                            <div class="col-sm-2"><input style="width:120px" type='text' name='BDTL_INPUT_tb_starhub_account_no' id='BDTL_INPUT_tb_starhub_account_no' maxlength='11' class='alphanumericdot BDTL_INPUT_class_save_valid form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">APPL DATE</label>
                            <div class="col-sm-2"><input style="width:100px" type="text" name="BDTL_INPUT_db_appl_date" id="BDTL_INPUT_db_appl_date" class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">CABLE START DATE</label>
                            <div class="col-sm-2"><input style="width:100px" type="text" name="BDTL_INPUT_db_cable_startdate"  id="BDTL_INPUT_db_cable_startdate" class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">CABLE END DATE</label>
                            <div class="col-sm-2"><input style="width:100px" type='text' name='BDTL_INPUT_db_cable_enddate' id='BDTL_INPUT_db_cable_enddate' class='BDTL_INPUT_class_datebox BDTL_INPUT_class_save_valid BDTL_INPUT_dateInput datenonmandtry form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">INTERNET START DATE</label>
                            <div class="col-sm-2"><input style="width:100px" type='text' name='BDTL_INPUT_db_internet_startdate' id='BDTL_INPUT_db_internet_startdate' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_save_valid datenonmandtry form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">INTERNET END DATE</label>
                            <div class="col-sm-2"><input style="width:100px"type='text' name='BDTL_INPUT_db_internet_enddate' id='BDTL_INPUT_db_internet_enddate' class='BDTL_INPUT_class_internet_datebox BDTL_INPUT_class_save_valid BDTL_INPUT_dateInput datenonmandtry form-control'/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">SSID</label>
                            <div class="col-sm-3"><input type='text' name='BDTL_INPUT_tb_ssid' id='BDTL_INPUT_tb_ssid' maxlength='25' class="general BDTL_INPUT_class_save_valid form-control"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">PWD</label>
                            <div class="col-sm-3"><input type='text' name='BDTL_INPUT_tb_pwd' id='BDTL_INPUT_tb_pwd' maxlength='25' class="general BDTL_INPUT_class_save_valid form-control"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">CABLE BOX SERIAL NO</label>
                            <div class="col-sm-5"><input type='text' name='BDTL_INPUT_tb_cablebox_sno' id='BDTL_INPUT_tb_cablebox_sno' maxlength='50' class="autosize BDTL_INPUT_class_save_valid form-control"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">MODEM SERIAL NO</label>
                            <div class="col-sm-5"><input type='text' name='BDTL_INPUT_tb_modem_sno' id='BDTL_INPUT_tb_modem_sno' maxlength='50' class="autosize BDTL_INPUT_class_save_valid form-control"/></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">BASIC GROUP</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_basic_group" id="BDTL_INPUT_ta_basic_group" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">ADDITIONAL CHANNEL</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_addtl_ch" id="BDTL_INPUT_ta_addtl_ch" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-3"><textarea name="BDTL_INPUT_ta_starhub_comments" id="BDTL_INPUT_ta_starhub_comments" class="BDTL_INPUT_class_save_valid BDTL_INPUT_comments form-control"></textarea></div>
                        </div>
                </div>
                    <div class="col-lg-offset-2" id="BDTL_INPUT_tble_btn" hidden>
                        <input type="button" style="cursor:pointer" disabled="" name="BDTL_INPUT_btn_save" id="BDTL_INPUT_btn_save" class="btn" value="SAVE"/>&nbsp;&nbsp;
                        <input type="button" style="cursor:pointer" name="BDTL_INPUT_btn_reset" id="BDTL_INPUT_btn_reset" class="btn" value="RESET" />
                    </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>