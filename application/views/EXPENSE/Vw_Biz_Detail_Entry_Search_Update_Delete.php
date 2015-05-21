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
                $("#BDTL_INPUT_tb_exp_digivoiceno").prop("title",BDTL_INPUT_errorarr[1])
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
            $("textarea").height(20);
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
//                        var result=JSON.parse(res);
//                        BDTL_INPUT_resultset(result);

                    }
                });
//                google.script.run.withSuccessHandler(BDTL_INPUT_loadunitno).withFailureHandler(BDTL_INPUT_onFailure).BDTL_INPUT_all_exp_types_unitno(BDTL_INPUT_all_expense_types);
            }
            else
            {
                $('#BDTL_INPUT_lb_unitno_list').hide();
                $('#BDTL_INPUT_lbl_unitno_list').hide();
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
            </div>
        </div>
    </form>
</div>
</body>
</html>