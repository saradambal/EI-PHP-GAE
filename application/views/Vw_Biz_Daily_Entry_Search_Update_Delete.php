<?php
include "Header.php";
?>
<script xmlns="http://www.w3.org/1999/html">

    $(document).ready(function(){
        $('#BDLY_INPUT_lb_unitno').hide();
        $('#BDLY_INPUT_lb_selectexptype').hide();
        $('textarea').autogrow({onInitialize: true});
//VALIDATION USED IN THE FORMS//
        $('.includeminusfour').doValidation({rule:'numbersonly',prop:{integer:true,realpart:4,imaginary:2}});
        $('.includeminus').doValidation({rule:'numbersonly',prop:{integer:true,realpart:3,imaginary:2}});
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $("#BDLY_INPUT_tb_petty_cashin,#BDLY_INPUT_tb_petty_cashout").doValidation({rule:'numbersonly',prop:{realpart:4,imaginary:2}});
        $(".amtonlyfivedigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $(".thramtonly").doValidation({rule:'numbersonly',prop:{realpart:3,imaginary:2}});
        $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
        $(".numonly").doValidation({rule:'numbersonly',prop:{realpart:5}});
        $(".hrnumonly").doValidation({rule:'numbersonly',prop:{realpart:2}});
        $('#BDLY_INPUT_btn_multisubmitbutton').hide();
        $('#BDLY_INPUT_btn_submitbutton').hide();
        $('#BDLY_INPUT_btn_resetbutton').hide();
        var BDLY_INPUT_tableerrmsgarr=[];
        var BDLY_INPUT_access_flag='';
        var BDLY_INPUT_access_flag1=1;
        var BDLY_INPUT_petty_date;
        var BDLY_INPUT_id_no;
        var BDLY_INPUT_arraylength;
        var BDLY_INPUT_uexp_id_no;
        var BDLY_INPUT_star_id_no;
        var BDLY_INPUT_unitno=[];
        var BDLY_INPUT_customername_array=[];
        var BDLY_INPUT_exptype_array=[];
        var BDLY_INPUT_unitenddate;
        var BDLY_INPUT_unitstartdate;
        var BDLY_INPUT_unitinvdate;
        var BDLY_INPUT_load_allunitnovalues;
        var BDLY_INPUT_unitno_options ='';
        var BDLY_INPUT_arr_autocmp='';
        $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',changeYear: true,changeMonth: true});
        $(".datepickdate").datepicker("option","maxDate",new Date());
    //RADIO BUTTON CLICK FUNCTION
        var initial_values=[];
            $('.BE_rd_selectform').click(function(){
            var radiooption=$(this).val();
            if(radiooption=='bizentryform')
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Daily_Entry_Search_Update_Delete/initialvalues",
                    data:{"ErrorList":'2,8,9,10,105,169,204,205,206,207,208,242,245,246,247,248,250,256,258,400'},
                    success: function(res) {
                        $('.preloader').hide();
                        initial_values=JSON.parse(res);
                        BDLY_INPUT_load_initialvalue(initial_values)
                    }
            });
            }
    });
        //LOAD THE INITIAL DATA IN THE LIST BOX//
        var BDLY_INPUT_airconservice=[];
        var BDLY_INPUT_allunittables;
        var BDLY_INPUT_allcarpark=[];
        var BDLY_INPUT_alldetaildigitalvoice=[];
        var BDLY_INPUT_alldetailelsec=[];
        var BDLY_INPUT_allempdetailsarry=[];
        var BDLY_INPUT_allsetailstarhub=[];
        var BDLY_INPUT_allcustentrydtl=[];
        function BDLY_INPUT_load_initialvalue(initial_values)
        {
            BDLY_INPUT_exptype_array=initial_values.BDLY_INPUT_expanse_array;
            var BDLY_INPUT_errmsgarr=initial_values.BDLY_INPUT_tableerrmsgarr;
            $(".BDLY_INPUT_class_numonly").prop("title",BDLY_INPUT_errmsgarr[0]);
            for(var e=0;e<=BDLY_INPUT_errmsgarr.length-1;e++){
                BDLY_INPUT_tableerrmsgarr[e]=BDLY_INPUT_errmsgarr[e+1];
            }
            BDLY_INPUT_airconservice=initial_values.BDLY_INPUT_detailairconservice;
            BDLY_INPUT_allunittables=initial_values.BDLY_INPUT_unittable;
            BDLY_INPUT_allcarpark=initial_values.BDLY_INPUT_detailcarpark;
            BDLY_INPUT_alldetaildigitalvoice=initial_values.BDLY_INPUT_detaildigitalvoice;
            BDLY_INPUT_alldetailelsec=initial_values.BDLY_INPUT_detailelecticity;
            BDLY_INPUT_allempdetailsarry=initial_values.BDLY_INPUT_empdetailsarry;
            BDLY_INPUT_allsetailstarhub=initial_values.BDLY_INPUT_detailstarhub;
            BDLY_INPUT_allcustentrydtl=initial_values.BDLY_INPUT_customerentrydetails;
            if((initial_values.BDLY_INPUT_unittable.length!=0)&&(initial_values.BDLY_INPUT_customer.length!=0)&&(initial_values.BDLY_INPUT_customerentrydetails.length!=0)&&(initial_values.BDLY_INPUT_detailairconservice.length!=0)&&(initial_values.BDLY_INPUT_detailstarhub.length!=0)&&(initial_values.BDLY_INPUT_detailelecticity.length!=0))
            {
                $('#BDLY_INPUT_form_dailyentry').show();
                $('#BDLY_INPUT_table_errormsg tr').remove().hide();
            }
            else
            {
                if((initial_values.BDLY_INPUT_unittable).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[14].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_customer).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[16].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_customerentrydetails).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[17].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailairconservice).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[9].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailstarhub).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[5].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
                if((initial_values.BDLY_INPUT_detailelecticity).length==0)
                {
                    $('#BDLY_INPUT_form_dailyentry').hide();
                    var uniterrormsg='<p><label class="errormsg">'+BDLY_INPUT_tableerrmsgarr[6].EMC_DATA+'</label></p>';
                    $('#BDLY_INPUT_table_errormsg').append(uniterrormsg);
                }
            }
            var expense_id=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_id;
            var expense_Data=BDLY_INPUT_exptype_array.BDLY_INPUT_expanse_date;
            var BDLY_INPUT_exptype_options =''
            for (var i = 0; i <expense_id.length ; i++) {
                if(i>=0 && i<=11)
                {
                    BDLY_INPUT_exptype_options += '<option value="' + expense_id[i] + '">' + expense_Data[i]+ '</option>';
                }
            }
            $('#BDLY_INPUT_lb_selectexptype').html(BDLY_INPUT_exptype_options)
            $('#BDLY_INPUT_lb_selectexptype').show();
            $('#BDLY_INPUT_lbl_exptype').show();
            BDLY_INPUT_Sortit('BDLY_INPUT_lb_selectexptype');
        }
        function BDLY_INPUT_Sortit(lbid) {
            var $r = $("#"+lbid+" "+"option");
            $r.sort(function(a, b) {
                if (a.text < b.text) return -1;
                if (a.text == b.text) return 0;
                return 1;
            });
            $($r).remove();
            $("#"+lbid).append($($r));
            $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
            $("select#"+lbid)[0].selectedIndex = 0;
        }
        $("#BDLY_INPUT_tb_pay_unitnocheck").blur(function()
        {
            $('#BDLY_INPUT_lbl_checkcardno').val("");
            BDLY_INPUT_checkunitno();
        });
        var checkunit;
        //CHECK THE UNITNO VALIDATION//
        function BDLY_INPUT_checkunitno()
        {
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(BDLY_INPUT_unitval.length==4)
            {
                $('.preloader').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Daily_Entry_Search_Update_Delete/BDLY_INPUT_checkexistunit",
                    data:{"BDLY_INPUT_unitval":BDLY_INPUT_unitval},
                    success: function(res) {
                        $('.preloader').hide();
                        checkunit=res;
                        BDLY_INPUT_checkunitnoexist(checkunit)
                    }
                });
//                google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_checkunitnoexist).BDLY_INPUT_checkexistunit(BDLY_INPUT_unitval);
            }
        }
        function BDLY_INPUT_checkunitnoexist(checkunit)
        {
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(checkunit==true)
            {
                $(".preloader").hide();
                $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[1].EMC_DATA).show();
                $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
            }
            if(checkunit==false)
            {
                $(".preloader").hide();
                if(BDLY_INPUT_unitval!='')
                {
                    if(BDLY_INPUT_unitval.length<4)
                    {$(".preloader").hide();
                        $('#BDLY_INPUT_tb_pay_unitnocheck').addClass('invalid');
                        $('#BDLY_INPUT_lbl_pay_uniterrmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA).show();
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }else
                    {
                        $('#BDLY_INPUT_tb_pay_unitno').removeClass('invalid');
                        if($("#BDLY_INPUT_lbl_checkcardno").val()=="")
                        {
                            $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
                        }
                        else
                        {$(".preloader").show();
                            google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_clearalldatas).BDLY_INPUT_save_values(document.getElementById('BDLY_INPUT_form_dailyentry'));
                        }
                    }
                }
            }
            var BDLY_INPUT_unitval=$('#BDLY_INPUT_tb_pay_unitnocheck').val();
            if(BDLY_INPUT_unitval==''||BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
            {
                if(BDLY_INPUT_unitval!=''&&BDLY_INPUT_unitval!=undefined)
                {
                    if((BDLY_INPUT_unitval.length==4)&&($('#BDLY_INPUT_tb_pay_unitnocheck').val()!='')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
            var BDLY_INPUT_unitvalno=$('#BDLY_INPUT_tb_pay_unitno').val();
            if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!=undefined)
            {
                if(BDLY_INPUT_unitvalno!=""&&BDLY_INPUT_unitvalno!="SELECT"&&BDLY_INPUT_unitvalno!=undefined)
                {
                    if((BDLY_INPUT_unitvalno.length==4)&&($('#BDLY_INPUT_tb_pay_unitno').val()!=''&&$('#BDLY_INPUT_tb_pay_unitno').val()!='SELECT')&&($('#BDLY_INPUT_tb_pay_invoiceamt').val()!='')&&(parseFloat($('#BDLY_INPUT_tb_pay_invoiceamt').val())!=0)&&($('#BDLY_INPUT_tb_pay_forperiod').val()!='')&&($('#BDLY_INPUT_tb_pay_paiddate').val()!='')){
                        $('#BDLY_INPUT_btn_submitbutton').removeAttr('disabled')
                    }
                    else{
                        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                    }
                }
                else{
                    $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled')
                }
            }
        }
      //  /SELECT THE EXPENSE//
        var BDLY_INPUT_unitno_result_auto=[];
    $(document).on('change','#BDLY_INPUT_lb_selectexptype',function() {
        BDLY_INPUT_clearalldates();
        $('textarea').height(20);
        $('#BDLY_INPUT_tble_electricity').hide();
        $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid')
        $('#BDLY_INPUT_tble_starhub').hide();
        $('#BDLY_INPUT_tble_unitexpense').hide();
        $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
        $('#BDLY_INPUT_lbl_pay_uniterrmsg').hide();
        $('#BDLY_INPUT_tble_housepayment').hide();
        $('#BDLY_INPUT_lbl_hourmsg').hide();
        $('#BDLY_INPUT_lbl_minmsg').hide();
        $('#BDLY_INPUT_tble_aircon').hide();
        $('#BDLY_INPUT_lbl_unitno').hide();
        $('#BDLY_INPUT_lb_unitno').hide();
        $('#BDLY_INPUT_tble_cardpark').hide();
        $('#BDLY_INPUT_tble_digitalvoice').hide();
        $('#BDLY_INPUT_tble_facility').hide();
        $('#BDLY_INPUT_tble_moving').hide();
        $('#BDLY_INPUT_tble_purchase').hide();
        $('#BDLY_INPUT_btn_submitbutton').hide();
        $('#BDLY_INPUT_btn_resetbutton').hide();
        $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
        $('#BDLY_INPUT_tble_pettycash').hide();
        $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled');
        $('#BDLY_INPUT_btn_multisubmitbutton').hide();
        $('#BDLY_INPUT_lb_elect_unit-1').prop('selectedIndex',0)
        $('#BDLY_INPUT_db_invoicedate1').val("").hide();
        $('#BDLY_INPUT_db_fromperiod1').val('').hide();
        $('#BDLY_INPUT_db_toperiod1').val('').hide();
        $('#BDLY_INPUT_lb_elect_payment1').prop('selectedIndex',0).hide()
        $('#BDLY_INPUT_tb_elect_amount1').val('').hide();
        $('#BDLY_INPUT_tb_elect_minusamt1').val('').hide();
        $('#BDLY_INPUT_ta_comments1').hide()
        $('#BDLY_INPUT_tb_invoiceto1').val('').hide();
        $('#BDLY_INPUT_tble_electricity').hide();
        var BDLY_INPUT_flag_notsave=[];
        BDLY_INPUT_flag_notsave[0]='BDLY_INPUT_flag_notsave'
        BDLY_INPUT_clear_electricity(BDLY_INPUT_flag_notsave);
        BDLY_INPUT_clear_unitExpanse(BDLY_INPUT_flag_notsave);
        BDLY_INPUT_clear_starhub(BDLY_INPUT_flag_notsave);
        $('#BDLY_INPUT_db_star_invoicedate1').val('').hide()
        $('#BDLY_INPUT_tb_star_amount1').val("").hide()
        $('#BDLY_INPUT_db_star_toperiod1').val('').hide();
        $('#BDLY_INPUT_db_star_fromperiod1').val('').hide();
        $('#BDLY_INPUT_star_add1').attr("disabled", "disabled").show();
        $('#BDLY_INPUT_star_del1').attr("disabled", "disabled").show();
        $('#BDLY_INPUT_lb_star_unit-1').prop('selectedIndex',0);
        $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
        $('#BDLY_INPUT_lb_star_invoice-1').hide();
        $('#BDLY_INPUT_tb_star_accno1').hide();
        $('#BDLY_INPUT_tble_unitexpense').hide();
        var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val()
        if(BDLY_INPUT_type=="SELECT"){
            $('#BDLY_INPUT_tble_aircon').hide();
            $('#BDLY_INPUT_lbl_unitno').hide();
            $('#BDLY_INPUT_lb_unitno').hide();
            $('#BDLY_INPUT_tble_cardpark').hide();
            $('#BDLY_INPUT_tble_digitalvoice').hide();
            $('#BDLY_INPUT_tble_facility').hide();
            $('#BDLY_INPUT_tble_moving').hide();
            $('#BDLY_INPUT_tble_purchase').hide();
            $('#BDLY_INPUT_btn_submitbutton').hide();
            $('#BDLY_INPUT_btn_resetbutton').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            $('#BDLY_INPUT_tble_pettycash').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr('disabled','disabled');
            $('#BDLY_INPUT_btn_multisubmitbutton').hide();
            $('#BDLY_INPUT_tble_electricity').hide();
            $('#BDLY_INPUT_tble_housekeeping').hide();
            $('#BDLY_INPUT_tble_housepayment').hide();
            $('#BDLY_INPUT_tble_pettycash').hide();
            $('#BDLY_INPUT_lbl_checkcardno').hide();
            $('#BDLY_INPUT_lbl_hourmsg').hide();
        }
        if(BDLY_INPUT_type!="SELECT"){
            $('#BDLY_INPUT_btn_submitbutton').hide();
            $(".preloader").show();
             if(BDLY_INPUT_allunittables.length==0)
            {
                $(".preloader").hide();
                $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA);
                $('#BDLY_INPUT_lbl_hourmsg').show();
            }else
            if(BDLY_INPUT_type==9 ||BDLY_INPUT_type==8||BDLY_INPUT_type==5||BDLY_INPUT_type==4||BDLY_INPUT_type==7||BDLY_INPUT_type==6||BDLY_INPUT_type==1||BDLY_INPUT_type==3||BDLY_INPUT_type==2){
                $('#BDLY_INPUT_tble_housepayment').hide();
                $('#BDLY_INPUT_tble_housekeeping').hide();
                $('#BDLY_INPUT_tble_digitalvoice').hide();
                $('#BDLY_INPUT_btn_submitbutton').hide();
                if((BDLY_INPUT_type==9)&&(BDLY_INPUT_airconservice.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[9].EMC_DATA);
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else if((BDLY_INPUT_type==8)&&(BDLY_INPUT_allcarpark.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[7].EMC_DATA);//
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else if((BDLY_INPUT_type==5)&&(BDLY_INPUT_alldetaildigitalvoice.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[8].EMC_DATA);//
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else if((BDLY_INPUT_type==1)&&(BDLY_INPUT_alldetailelsec.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[6].EMC_DATA);
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else if((BDLY_INPUT_type==2)&&(BDLY_INPUT_allsetailstarhub.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[5].EMC_DATA);
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else if((BDLY_INPUT_type==3)&&(BDLY_INPUT_allcustentrydtl.length==0))
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[17].EMC_DATA);
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }
                else
                {
                    $('#BDLY_INPUT_lbl_checkcardno').hide();
                    $('#BDLY_INPUT_lbl_hourmsg').hide();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Daily_Entry_Search_Update_Delete/BDLY_INPUT_get_unitno",
                        data:{"BDLY_INPUT_type":BDLY_INPUT_type},
                        success: function(res) {
                            $('.preloader').hide();
                            BDLY_INPUT_unitno_result_auto=JSON.parse(res);
                            BDLY_INPUT_load_unitno(BDLY_INPUT_unitno_result_auto)
                        }
                    });
//                    google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_load_unitno).BDLY_INPUT_get_unitno(BDLY_INPUT_type);
                }
            }
            if(BDLY_INPUT_type==10)
            {
                $('#BDLY_INPUT_lbl_checkcardno').hide();
                $('#BDLY_INPUT_lbl_hourmsg').hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Daily_Entry_Search_Update_Delete/BDLY_INPUT_get_balance",
                    success: function(res) {
                        $('.preloader').hide();
                        balance_result=JSON.parse(res);
                        BDLY_INPUT_load_balance(balance_result)
                    }
                });
//                google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_load_balance).BDLY_INPUT_get_balance();
            }
            if(BDLY_INPUT_type==11){
                $('#BDLY_INPUT_tble_starhub').hide();
                $('#BDLY_INPUT_tble_housepayment').hide();
                if(BDLY_INPUT_allempdetailsarry.length==0)
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').text(BDLY_INPUT_tableerrmsgarr[10].EMC_DATA);//
                    $('#BDLY_INPUT_lbl_checkcardno').show();
                }else
                {
                    $('#BDLY_INPUT_lbl_checkcardno').hide();
                    $('#BDLY_INPUT_lbl_hourmsg').hide();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Biz_Daily_Entry_Search_Update_Delete/BDLY_INPUT_get_cleanername",
                        success: function(res) {
                            $('.preloader').hide();
                            cleanername=JSON.parse(res);
                            BDLY_INPUT_load_cleanername(cleanername)
                        }
                    });
//                    google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_load_cleanername).BDLY_INPUT_get_cleanername();
                }
            }
            if(BDLY_INPUT_type==12){
                if(BDLY_INPUT_allunittables.length==0)
                {
                    $(".preloader").hide();
                    $('#BDLY_INPUT_lbl_checkcardno').hide();
                    $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[14].EMC_DATA);
                    $('#BDLY_INPUT_lbl_hourmsg').show();
                }else
                {
                    $('#BDLY_INPUT_lbl_checkcardno').hide();
                    $('#BDLY_INPUT_lbl_hourmsg').hide();
                    google.script.run.withFailureHandler(BDLY_INPUT_error).withSuccessHandler(BDLY_INPUT_load_allunitno).BDLY_INPUT_get_allunitno();
                }
                $('#BDLY_INPUT_tble_housekeeping').hide();
            }
        }
    });
        //FUNCTION TO LOAD UNIT NO//
        function BDLY_INPUT_load_unitno(BDLY_INPUT_unitno_result_auto)
        {
            $(".preloader").hide();
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            BDLY_INPUT_unitno=BDLY_INPUT_unitno_result_auto[0];
            BDLY_INPUT_arr_autocmp=BDLY_INPUT_unitno_result_auto[1];
            var BDLY_INPUT_unitno_result=BDLY_INPUT_unitno_result_auto[0];
            if(BDLY_INPUT_unitno_result.length==0)
            {
            }
            else
            {
                BDLY_INPUT_unitno_options ='<option>SELECT</option>';
                for (var i = 0; i < BDLY_INPUT_unitno_result.length; i++){
                    BDLY_INPUT_unitno_options += '<option value="' + BDLY_INPUT_unitno_result[i] + '">' + BDLY_INPUT_unitno_result [i]+ '</option>';
                }
                if(BDLY_INPUT_type==1){
                    $('#BDLY_INPUT_tble_electricity').show();
                    $('#BDLY_INPUT_lb_elect_unit-1').html(BDLY_INPUT_unitno_options);
                    $('#BDLY_INPUT_tble_electricity').show();
                    $('#BDLY_INPUT_lb_elect_unit-1').show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_comments1').hide();
                }
                else if(BDLY_INPUT_type==3){
                    $('#BDLY_INPUT_tble_unitexpense').show();
                    $('#BDLY_INPUT_lb_uexp_unit-1').html(BDLY_INPUT_unitno_options).show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_uexpcomments1').hide();
                }
                else if(BDLY_INPUT_type==2){
                    $('#BDLY_INPUT_tble_starhub').show();
                    $('#BDLY_INPUT_lb_star_unit-1').html(BDLY_INPUT_unitno_options).show();
                    $('#BDLY_INPUT_tble_starhub').show();
                    $('#BDLY_INPUT_add1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_del1').attr("disabled", "disabled").show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                    $('#BDLY_INPUT_btn_multisubmitbutton').show();
                    $('#BDLY_INPUT_ta_star_comments1').hide();
                }
                else{
                    $('#BDLY_INPUT_lb_unitno').html(BDLY_INPUT_unitno_options);
                    $('#BDLY_INPUT_lbl_unitno').show();
                    $('#BDLY_INPUT_lb_unitno').show();
                    $('#BDLY_INPUT_btn_submitbutton').hide();
                }
                $('#BDLY_INPUT_btn_resetbutton').hide();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
                $('#BDLY_INPUT_btn_multisubmitbutton').attr("disabled", "disabled");
            }
        }
        var balance_result=[];
//FUNCTION TO LOAD PETTY CASH BALANCE//
        function BDLY_INPUT_load_balance(balance_result){
            $(".preloader").hide();
            $('#BDLY_INPUT_tb_petty_balance').val(balance_result[0]);
            BDLY_INPUT_petty_date=balance_result[1];
            var date = new Date( Date.parse( BDLY_INPUT_petty_date ) );
            date.setDate( date.getDate() );
            var BDLY_INPUT_newDate = date.toDateString();
            BDLY_INPUT_newDate = new Date( Date.parse( BDLY_INPUT_newDate ) );
            $('#BDLY_INPUT_tb_petty_date').datepicker("option","minDate",BDLY_INPUT_newDate);
            $('#BDLY_INPUT_tble_pettycash').show();
            $('#BDLY_INPUT_btn_submitbutton').show();
            $('#BDLY_INPUT_btn_resetbutton').show();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
        }
        /*--------------------------FUNCTION TO UNIQUE FOR CUSTOMER NAME---------------------------------------------------*/
        function STDLY_INPUT_unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
        var cleanername=[];
        var BDLY_INPUT_arr_housekeepingname= [];
        //FUNCTION TO LOAD HOUSEKEEPING CLEANER NAME//
        function BDLY_INPUT_load_cleanername(cleanername){
            $(".preloader").hide();
            BDLY_INPUT_arr_housekeepingname=cleanername;
            var clearnername=BDLY_INPUT_arr_housekeepingname.BDLY_INPUT_cleanername;
            var empid=BDLY_INPUT_arr_housekeepingname.BDLY_INPUT_empid;
            if(clearnername.length==0)
            {
                $('#BDLY_INPUT_lbl_hourmsg').text(BDLY_INPUT_tableerrmsgarr[4].EMC_DATA).show();
            }
            else
            {
                var BDLY_INPUT_arr_uniquedata=[];
                for (var j = 0; j < clearnername.length; j++) {
                    BDLY_INPUT_arr_uniquedata[j]=clearnername[j];
                }
                BDLY_INPUT_arr_uniquedata=STDLY_INPUT_unique(BDLY_INPUT_arr_uniquedata)
                var BDLY_INPUT_cleanername_options ='<option>SELECT</option>'
                for (var i = 0; i < BDLY_INPUT_arr_uniquedata.length; i++) {
                    BDLY_INPUT_cleanername_options += '<option value="' + clearnername[i] + '">' + clearnername[i] + '</option>';
                }
                $('#BDLY_INPUT_lb_house_cleanername').html(BDLY_INPUT_cleanername_options);
                $('#BDLY_INPUT_tble_housekeeping').show();
                $('#BDLY_INPUT_btn_submitbutton').show();
                $('#BDLY_INPUT_btn_resetbutton').show();
                $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            }
        }
        // FUNCTION FOR CLEAR ALL DATES
        function BDLY_INPUT_clearalldates()
        {
            $('textarea').height(20);
            $('#BDLY_INPUT_tble_radioclearnername').empty();
            $('#BDLY_INPUT_lbl_pcarderrmsg').hide();
            $('#BDLY_INPUT_btn_submitbutton').attr("disabled", "disabled");
            var BDLY_INPUT_listvalue= $('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_listvalue==9)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_air_date').val("");
                $('#BDLY_INPUT_ta_aircon_comments').val("");
            }
            if(BDLY_INPUT_listvalue==8)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_cp_invoicedate').val("");
                $('#BDLY_INPUT_tb_cp_fromdate').val("");
                $('#BDLY_INPUT_tb_cp_todate').val("");
                $('#BDLY_INPUT_tb_cp_invoiceamt').val("");
                $('#BDLY_INPUT_ta_cp_comments').val("");
            }
            if(BDLY_INPUT_listvalue==5)
            {
                $('#BDLY_INPUT_lb_digi_invoiceto').prop('selectedIndex',0);
                $('#BDLY_INPUT_tb_digi_invoicedate').val("");
                $('#BDLY_INPUT_tb_digi_fromdate').val("");
                $('#BDLY_INPUT_tb_digi_todate').val("");
                $('#BDLY_INPUT_tb_digi_invoiceamt').val("");
                $('#BDLY_INPUT_ta_digi_comments').val("");
                BDLY_INPUT_setdatepick();
            }
            if(BDLY_INPUT_listvalue==4)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_fac_invoicedate').val("");
                $('#BDLY_INPUT_radio_fac_deposit').prop('checked',false);
                $('#BDLY_INPUT_radio_fac_invoiceamt').prop('checked',false);
                $('#BDLY_INPUT_tb_fac_depositamt').val("").hide();
                $('#BDLY_INPUT_tb_fac_invoiceamt').val("").hide();
                $('#BDLY_INPUT_ta_fac_comments').val("");
            }
            if(BDLY_INPUT_listvalue==11)
            {
                $('#BDLY_INPUT_ta_house_desc').val("");
                $('#BDLY_INPUT_lb_house_cleanername').val("");
                $('#BDLY_INPUT_tb_house_date').val("");
                $('#BDLY_INPUT_tb_house_hours').val("");
                $('#BDLY_INPUT_tb_house_min').val("");
                $('#BDLY_INPUT_tb_house_hours,#BDLY_INPUT_tb_house_min').removeClass("invalid");
                $('#BDLY_INPUT_lbl_hourmsg,#BDLY_INPUT_lbl_minmsg').text("");
            }
            if(BDLY_INPUT_listvalue==12)
            {
                $('#BDLY_INPUT_tb_pay_unitnocheck').val('');
                $('#BDLY_INPUT_tb_pay_unitnocheck').removeClass('invalid');
                $('#BDLY_INPUT_tb_pay_unitno').val('');
                $('#BDLY_INPUT_lbl_pay_uniterrmsg').text('');
                $('#BDLY_INPUT_tb_pay_unitno').prop('selectedIndex',0);
                $('#BDLY_INPUT_tb_pay_invoiceamt').val('');
                $('#BDLY_INPUT_tb_pay_forperiod').val('');
                $('#BDLY_INPUT_tb_pay_paiddate').val('');
                $('#BDLY_INPUT_ta_pay_comments').val('');
                $('input[name="BDLY_INPUT_radio_hk_oldnewentry"]').prop('checked', false);
            }
            if(BDLY_INPUT_listvalue==7)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_tb_mov_date').val('');
                $('#BDLY_INPUT_tb_mov_invoiceamt').val('');
                $('#BDLY_INPUT_ta_mov_comments').val('');
            }
            if(BDLY_INPUT_listvalue==10)
            {
                $('input[name="BDLY_INPUT_radio_petty"]').prop('checked', false);
                $('#BDLY_INPUT_tb_petty_cashin').val("").hide();
                $('#BDLY_INPUT_tb_petty_cashout').val("").hide();
                $('#BDLY_INPUT_ta_petty_comments').val('');
                $('#BDLY_INPUT_tb_petty_date').val('');
                $('#BDLY_INPUT_ta_petty_invoiceitem').val('');
            }
            if(BDLY_INPUT_listvalue==6)
            {
                BDLY_INPUT_setdatepick();
                $('#BDLY_INPUT_ta_access_comments').val('');
                $('#BDLY_INPUT_tb_access_cardno').val('');
                $('#BDLY_INPUT_tb_access_cardno').removeClass('invalid');
                $('#BDLY_INPUT_tb_access_date').val('');
                $('#BDLY_INPUT_tb_access_invoiceamt').val('');
            }
        }
   //FUNCATION FOR SETDATEPICKER
        function BDLY_INPUT_setdatepick()
        {
            var BDLY_INPUT_unit_end_date='';
            var BDLY_INPUT_enddate=new Date(Date.parse(BDLY_INPUT_unitenddate));
            var unitstardate = new Date( Date.parse( BDLY_INPUT_unitstartdate ) );
            var unitinvdate = new Date( Date.parse( BDLY_INPUT_unitinvdate ) );
//VALIDATION FOR EACH EXPENSE
            var BDLY_INPUT_type=$('#BDLY_INPUT_lb_selectexptype').val();
            if(BDLY_INPUT_type==3){
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_db_uexp_invoicedate'+BDLY_INPUT_uexp_id_no).datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==6){
                $('#BDLY_INPUT_tb_access_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_access_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==7){
                $('#BDLY_INPUT_tb_mov_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_mov_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==9){
                $('#BDLY_INPUT_tb_air_date').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_air_date').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==4){
                $('#BDLY_INPUT_tb_fac_invoicedate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_fac_invoicedate').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==8){
                $('#BDLY_INPUT_tb_cp_invoicedate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_cp_fromdate,#BDLY_INPUT_tb_cp_todate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_cp_invoicedate').datepicker("option","maxDate",unitinvdate);
                $('#BDLY_INPUT_tb_cp_fromdate,#BDLY_INPUT_tb_cp_todate').datepicker("option","maxDate",BDLY_INPUT_enddate);
            }
            if(BDLY_INPUT_type==5){
                $('#BDLY_INPUT_tb_digi_invoicedate,#BDLY_INPUT_tb_digi_fromdate,#BDLY_INPUT_tb_digi_todate').datepicker("option","minDate",unitstardate);
                $('#BDLY_INPUT_tb_digi_invoicedate,#BDLY_INPUT_tb_digi_fromdate,#BDLY_INPUT_tb_digi_todate').datepicker("option","maxDate",unitinvdate);
            }
            if(BDLY_INPUT_type==2){
                BDLY_INPUT_func_starhubperiod();
                $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_fromperiod"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_toperiod"+BDLY_INPUT_star_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_star_invoicedate"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_star_fromperiod"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_enddate);
                $("#BDLY_INPUT_db_star_toperiod"+BDLY_INPUT_star_id_no).datepicker("option","maxDate",BDLY_INPUT_enddate);
            }
            if(BDLY_INPUT_type==1){
                $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","minDate",unitstardate);
                $("#BDLY_INPUT_db_invoicedate"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_fromperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
                $("#BDLY_INPUT_db_toperiod"+BDLY_INPUT_id_no).datepicker("option","maxDate",unitinvdate);
            }
        }
//FUNCTION TO CLEAR ELECTRICITY
        function BDLY_INPUT_clear_electricity(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
            $('#BDLY_INPUT_tble_electricity').empty();
            $('<tr><td><label id="BDLY_INPUT_lbl_elect_unit" >UNIT</label><em>*</em> </td><td ><label  id="BDLY_INPUT_lbl_elect_invoiceto" >INVOICE TO</label><em>*</em></td><td > <label id="BDLY_INPUT_lbl_elect_invoicedate" >INVOICE DATE</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_elect_fromperiod" >FROM PERIOD</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_elect_toperiod" >TO PERIOD</label><em>*</em></td><td ><label id="BDLY_INPUT_lbl_elect_payment"  >PAYMENT OF</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_elect_amount" >AMOUNT</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_elect_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_elect_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_elect_del" ></label> </td></tr><tr><td> <select  class="BDLY_INPUT_class_unit submultivalid "  name="BDLY_INPUT_lb_elect_unit" id="BDLY_INPUT_lb_elect_unit-1" hidden><option value="">SELECT</option></select> </td> <td><input  class="submultivalid rdonly"  type="text" name ="BDLY_INPUT_tb_invoiceto" id="BDLY_INPUT_tb_invoiceto1"  hidden readonly/><input type="text" id="BDLY_INPUT_hidden_ecnid_elec1" name="BDLY_INPUT_hidden_ecnid_elec" hidden> </td><td><input  class="eledatepicker submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_invoicedate" id="BDLY_INPUT_db_invoicedate1" style="width:75px;" hidden /> </td><td><input  class="eledatepicker submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_fromperiod" id="BDLY_INPUT_db_fromperiod1" style="width:75px;" hidden/> </td><td><input  class="eledatepicker submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_toperiod" id="BDLY_INPUT_db_toperiod1" style="width:75px;" hidden/> </td><td><select  name="BDLY_INPUT_lb_elect_payment" class="submultivalid amtentry" id="BDLY_INPUT_lb_elect_payment1" hidden><option value="" >SELECT</option></select></td><td><input  class="amtonlyvalidation submultivalid" type="text" name ="BDLY_INPUT_tb_elect_amount" id="BDLY_INPUT_tb_elect_amount1" style="width:60px;" hidden /> <input  class="amtonlyvalidation submultivalid"  type="text" name ="BDLY_INPUT_tb_elect_minusamt" id="BDLY_INPUT_tb_elect_minusamt1" style="width:50px;" hidden /><input type="hidden" id="BDLY_INPUT_hidden_amt_elec1" name="BDLY_INPUT_hidden_amt_elec" ></td><td><textarea row="2" class=" submultivalid" name ="BDLY_INPUT_ta_comments" id="BDLY_INPUT_ta_comments1" hidden ></textarea> </td><td><input type="button" value="+" class="addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_add[]" id="BDLY_INPUT_add1" disabled > </td><td><input  type="button" value="-" class="deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_delete[]" id="BDLY_INPUT_del1" disabled ></td></tr>').appendTo($('#BDLY_INPUT_tble_electricity'));
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }}
//CLEARED UNIT EXPENSE MULTI  ROW //
        function BDLY_INPUT_clear_unitExpanse(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_btn_multisubmitbutton').attr('disabled','disabled')
            $('#BDLY_INPUT_tble_unitexpense').empty();
            $('<tr><td><label id="BDLY_INPUT_lbl_uexp_unit" >UNIT</label><em>*</em> </td><td ><label  id="BDLY_INPUT_lbl_uexp_category" >CATEGORY</label><em>*</em></td><td ><label  id="BDLY_INPUT_lbl_uexp_customer" hidden>CUSTOMER<em>*</em></label></td><td ><label  id="BDLY_INPUT_lbl_uexp_customerid" hidden></label></td><td > <label id="BDLY_INPUT_lbl_uexp_invoicedate" >INVOICE DATE</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_uexp_invoiceitem" >INVOICE ITEM</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_uexp_invoicefrom" >INVOICE FROM</label><em>*</em></td><td ><label id="BDLY_INPUT_lbl_uexp_amount" >AMOUNT</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_uexp_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_uexp_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_uexp_del" ></label> </td></tr><tr><td> <select  class="BDLY_INPUT_uexp_class_unit uexp_submultivalid "  name="BDLY_INPUT_lb_uexp_unit" id="BDLY_INPUT_lb_uexp_unit-1" hidden><option value="">SELECT</option></select> </td> <td><select  name="BDLY_INPUT_lb_uexp_category" class="uexp_submultivalid BDLY_INPUT_uexp_class_category " id="BDLY_INPUT_lb_uexp_category-1" hidden><option value="" >SELECT</option></select></td><td><select  name="BDLY_INPUT_lb_uexp_customer" class="uexp_submultivalid BDLY_INPUT_uexp_class_custname" id="BDLY_INPUT_lb_uexp_customer1" hidden><option value="" >SELECT</option></select></td><td ><table id="multiplecustomer-1" width="250px" hidden></table><td><input  class="datepickdate uexp_submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_uexp_invoicedate" id="BDLY_INPUT_db_uexp_invoicedate1" style="width:75px;" hidden /> </td><td><textarea  class="uexp_submultivalid"  name ="BDLY_INPUT_tb_uexp_invoiceitem" id="BDLY_INPUT_tb_uexp_invoiceitem1"  hidden/></textarea> </td><td><input  class="uexp_submultivalid autosize autocomplete" type="text" name ="BDLY_INPUT_tb_uexp_invoicefrom" id="BDLY_INPUT_tb_uexp_invoicefrom1"  hidden/> </td><td><input  class="amtonlyfivedigit uexp_submultivalid"  type="text" name ="BDLY_INPUT_tb_uexp_amount" id="BDLY_INPUT_tb_uexp_amount1" style="width:60px;" hidden /> </td><td><textarea row="2" name ="BDLY_INPUT_ta_uexpcomments" id="BDLY_INPUT_ta_uexpcomments1" class=" uexp_submultivalid" hidden ></textarea> </td><td><input type="button" value="+" class="uexp_addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_uexpadd[]" id="BDLY_INPUT_uexp_add1" disabled > </td><td><input  type="button" value="-" class="uexp_deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_uexpdelete[]" id="BDLY_INPUT_uexp_del1" disabled ></td><td><input    type="text" name ="BDLY_INPUT_tb_uexp_hideradioid" id="BDLY_INPUT_tb_uexp_hideradioid1" style="width:75px;" hidden/> </td></tr>').appendTo($('#BDLY_INPUT_tble_unitexpense'))
            $(".amtonlyfivedigit").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy', changeYear: true, changeMonth: true});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }}
//CLEARED STAR HUB MULTI  ROW //
        function BDLY_INPUT_clear_starhub(BDLY_INPUT_unit_response){
            $(".preloader").hide();
            $('#BDLY_INPUT_tble_starhub').empty();
            $('<tr> <td><label id="BDLY_INPUT_lbl_star_unit" >UNIT</label><em>*</em> </td><td ><label  id="BDLY_INPUT_lbl_star_invoiceto" >INVOICE TO</label><em>*</em></td><td ><label id="BDLY_INPUT_lbl_star_accountno"  >ACCOUNT NO</label><em>*</em> </td><td > <label id="BDLY_INPUT_lbl_star_invoicedate" >INVOICE DATE</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_star_fromperiod" >FROM PERIOD</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_star_toperiod" >TO PERIOD</label><em>*</em></td><td ><label id="BDLY_INPUT_lbl_star_amount" >AMOUNT</label><em>*</em> </td><td ><label id="BDLY_INPUT_lbl_star_comments" >COMMENTS</label> </td><td ><label id="BDLY_INPUT_lbl_star_add" ></label> </td><td ><label id="BDLY_INPUT_lbl_star_del" ></label> </td></tr><tr><td> <select  class="BDLY_INPUT_class_star_unit star_submultivalid"  name="BDLY_INPUT_lb_star_unit" id="BDLY_INPUT_lb_star_unit-1" hidden>'+BDLY_INPUT_unitno_options+'</select> </td> <td> <select  class="BDLY_INPUT_class_star_invoice star_submultivalid "  name="BDLYUT_lb_star_invoiceto" id="BDLY_INPUT_lb_star_invoice-1" hidden><option value="">SELECT</option></select><input type="hidden" id="BDLY_INPUT_hidden_star_ecnid1" name="BDLY_INPUT_hidden_star_ecnid"> </td><td><input  class="star_submultivalid rdonly"  type="text" name ="BDLY_INPUT_tb_star_accno" id="BDLY_INPUT_tb_star_accno1"  hidden readonly/> </td><td><input  class="starinvdatepickdate star_submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_star_invoicedate" id="BDLY_INPUT_db_star_invoicedate1" style="width:75px;" hidden /> </td><td><input  class="starfrmdatepickdate star_submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_star_fromperiod" id="BDLY_INPUT_db_star_fromperiod1" style="width:75px;" hidden/> </td><td><input  class="startodatepickdate star_submultivalid datemandtry"  type="text" name ="BDLY_INPUT_db_star_toperiod" id="BDLY_INPUT_db_star_toperiod1" style="width:75px;" hidden/> </td><td><input  class=" star_submultivalid includeminusfour"  type="text" name ="BDLY_INPUT_tb_star_amount" id="BDLY_INPUT_tb_star_amount1" style="width:60px;" maxlength=4 hidden /> </td><td><textarea row="2" class=" star_submultivalid"  name ="BDLY_INPUT_ta_star_comments" id="BDLY_INPUT_ta_star_comments1" hidden ></textarea> </td><td><input type="button" value="+" class="star_addbttn" alt="Add Row" height="30" width="30" name ="BDLY_INPUT_add[]" id="BDLY_INPUT_star_add1" disabled > </td><td><input  type="button" value="-" class="star_deletebttn" alt="delete Row" height="30" width="30" name ="BDLY_INPUT_delete[]" id="BDLY_INPUT_star_del1" disabled ></td></tr>').appendTo($('#BDLY_INPUT_tble_starhub'));
            $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
            $('.includeminusfour').doValidation({rule:'numbersonly',prop:{integer:true,realpart:4,imaginary:2}});
            $(".datepickdate").datepicker({dateFormat:'dd-mm-yy',
                changeYear: true,
                changeMonth: true});
            if(BDLY_INPUT_unit_response[0]!='BDLY_INPUT_flag_notsave'){
                BDLY_INPUT_load_unitno(BDLY_INPUT_unit_response);
            }
        }
});
</script>
</head>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>BIZ EXPENSE ENTRY/SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="BDLY_INPUT_form_dailyentry" class="form-horizontal content">
        <div class="panel-body">
                    <div style="padding-bottom: 15px">
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="bizentryform" class="BE_rd_selectform">ENTRY</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="optradio" value="bizsearchform" class="BE_rd_selectform">SEARCH/UDATE/DELETE</label>
                        </div>
                    </div>
            <div id="biz_expenseentryform">
                    <table id="BDLY_INPUT_table_errormsg">
                    </table>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_exptype' class="col-sm-2" hidden>TYPE OF EXPENSE <em>*</em></label>
                        <div class="col-sm-3">
                            <select id='BDLY_INPUT_lb_selectexptype' class="form-control" name="BDLY_INPUT_lb_selectexptype" hidden  >
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_unitno' class="col-sm-2" hidden>UNIT NO<em>*</em></label>
                        <div class="col-sm-2">
                            <select id='BDLY_INPUT_lb_unitno' class="form-control" name="BDLY_INPUT_lb_unitno" hidden >
                            <option value='SELECT' selected="selected"> SELECT</option>
                            </select>
                        </div>
                    </div>
                <!--CREATING AIRCON ELEMENT-->
                <div id="BDLY_INPUT_tble_aircon" hidden>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_serviceby' class="col-sm-2">AIRCON SERVICE BY<em>*</em></label>
                        <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_serviceby" name="BDLY_INPUT_tb_serviceby" class="BDLY_INPUT_class_submitvalidate autosize form-control" readonly  >
                            <input type="hidden" id="BDLY_INPUT_hidden_edasid" name="BDLY_INPUT_hidden_edasid">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  id='BDLY_INPUT_lbl_air_date' class="col-sm-2" >DATE<em>*</em></label>
                        <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_air_date" name="BDLY_INPUT_tb_air_date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" style="width:75px" ></div>
                    </div>
                    <div>
                        <label  id='BDLY_INPUT_lbl_comment' class="col-sm-2">COMMENTS</label>
                        <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_aircon_comments" id="BDLY_INPUT_ta_aircon_comments" class="form-control"  ></textarea></div>
                    </div>
                </div>
                    <!--CREATING OF CAR PARK ELEMENT-->
                    <div id="BDLY_INPUT_tble_cardpark" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_carno' class="col-sm-2">CAR NO<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_carno" name="BDLY_INPUT_tb_carno" class="BDLY_INPUT_class_submitvalidate rdonly form-control" readonly  ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_cp_invoicedate' class="col-sm-2" >INVOICE DATE<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_cp_invoicedate" name="BDLY_INPUT_tb_cp_invoicedate" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_cp_fromdate' class="col-sm-2">FROM PERIOD<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_cp_fromdate" name="BDLY_INPUT_tb_cp_fromdate" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_cp_todate' >TO PERIOD<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_cp_todate" name="BDLY_INPUT_tb_cp_todate" class="  BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_cp_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_cp_invoiceamt" name="BDLY_INPUT_tb_cp_invoiceamt" class="BDLY_INPUT_class_submitvalidate amtonly BDLY_INPUT_class_numonly form-control" style="width:50px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_cp_comment' class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-2"><textarea name="BDLY_INPUT_ta_cp_comments" id="BDLY_INPUT_ta_cp_comments" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF DIGITAL VOICE ELEMENT-->
                    <div id="BDLY_INPUT_tble_digitalvoice" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_invoiceto' class="col-sm-2">INVOICE TO<em>*</em></label>
                            <div class="col-sm-3"><select id='BDLY_INPUT_lb_digi_invoiceto' name="BDLY_INPUT_lb_digi_invoiceto" class="BDLY_INPUT_class_hksubmitvalidate rdonly form-control" readonly>
                                </select></div></div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_voiceno' class="col-sm-2">DIGITAL VOICE NO<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_voiceno" name="BDLY_INPUT_tb_digi_voiceno" class="BDLY_INPUT_class_submitvalidate rdonly form-control" readonly  ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_accno' class="col-sm-2">ACCOUNT NO<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_accno" name="BDLY_INPUT_tb_digi_accno" class="BDLY_INPUT_class_submitvalidate rdonly form-control"  readonly></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_invoicedate' class="col-sm-2">INVOICE DATE<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_digi_invoicedate" name="BDLY_INPUT_tb_digi_invoicedate" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_fromdate' class="col-sm-2">FROM PERIOD<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_digi_fromdate" name="BDLY_INPUT_tb_digi_fromdate" class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_todate' class="col-sm-2">TO PERIOD<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_digi_todate" name="BDLY_INPUT_tb_digi_todate"  class=" BDLY_INPUT_class_submitvalidate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_digi_invoiceamt' class="col-sm-2" >INVOICE AMOUNT<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_digi_invoiceamt" name="BDLY_INPUT_tb_digi_invoiceamt" class="BDLY_INPUT_class_submitvalidate includeminus BDLY_INPUT_class_numonly form-control" style="width:50px"></div>
                        </div>
                        <div class="form-group">
                            <<label  id='BDLY_INPUT_lbl_digi_comment' class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_digi_comments" id="BDLY_INPUT_ta_digi_comments" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF FACILITY ELEMENT-->
                    <div id="BDLY_INPUT_tble_facility" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_fac_invoicedate' class="col-sm-2">DATE<em>*</em></label>
                            <div class="col-sm-4"><input type="text" style="width:75px" id="BDLY_INPUT_tb_fac_invoicedate" name="BDLY_INPUT_tb_fac_invoicedate" class=" form-control datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry" ></div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" id="BDLY_INPUT_radio_fac_deposit" name="BDLY_INPUT_radio_facility"class="BDLY_INPUT_class_submitvalidate" value="deposit">DEPOSIT</label>
                                <input style="width:45px" type="text" id="BDLY_INPUT_tb_fac_depositamt" name="BDLY_INPUT_tb_fac_depositamt"  class=" amtonly BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control" hidden >
                            </div>
                            <div class="radio">
                                <label><input type="radio" id="BDLY_INPUT_radio_fac_invoiceamt" name="BDLY_INPUT_radio_facility"class="BDLY_INPUT_class_submitvalidate" value="invoiceamount">INVOICE AMOUNT</label>
                                <input style="width:45px" type="text" id="BDLY_INPUT_tb_fac_invoiceamt" name="BDLY_INPUT_tb_fac_invoiceamt" class="amtonly BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control" hidden >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2" id='BDLY_INPUT_lbl_fac_comment' >COMMENTS</label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_fac_comments" id="BDLY_INPUT_ta_fac_comments" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF MOVING IN AND OUT ELEMENT-->
                    <div id="BDLY_INPUT_tble_moving" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_mov_date' class="col-sm-2">INVOICE DATE<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_mov_date" name="BDLY_INPUT_tb_mov_date" class="BDLY_INPUT_class_hksubmitvalidate datepickdate datemandtry form-control" style="width:75px" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_mov_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_mov_invoiceamt" name="BDLY_INPUT_tb_mov_invoiceamt" class="BDLY_INPUT_class_submitvalidate thramtonly BDLY_INPUT_class_numonly form-control" style="width:45px" ></div>
                        </div>
                        <div class="form-group">
                             <label  id='BDLY_INPUT_lbl_mov_comment' class="col-sm-2">COMMENTS</label>
                            <div class="form-group"><textarea name="BDLY_INPUT_ta_mov_comments" id="BDLY_INPUT_ta_mov_comments" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF PURCHASE ELEMENT-->
                    <div id="BDLY_INPUT_tble_purchase" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_access_cardno' class="col-sm-2">CARD NO<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_access_cardno" name="BDLY_INPUT_tb_access_cardno" style="width:53px;" class="numonly BDLY_INPUT_class_hksubmitvalidate form-control" ></div>
                            <label class="errormsg" id="BDLY_INPUT_lbl_pcarderrmsg" ></label>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_access_date' class="col-sm-2">INVOICE DATE<em>*</em></label>
                            <div class="form-group"><input type="text" id="BDLY_INPUT_tb_access_date" name="BDLY_INPUT_tb_access_date" style="width:75px;" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_access_invoiceamt' class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_access_invoiceamt" name="BDLY_INPUT_tb_access_invoiceamt" style="width:45px;" class="BDLY_INPUT_class_hksubmitvalidate amtonly BDLY_INPUT_class_numonly form-control" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_access_comment' class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_access_comments" id="BDLY_INPUT_ta_access_comments" class="BDLY_INPUT_class_hksubmitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF PETTYCASH ELEMENT-->
                    <div id="BDLY_INPUT_tble_pettycash" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_petty_balance' class="col-sm-2" >CURRENT BALANCE<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_petty_balance" name="BDLY_INPUT_tb_petty_balance" style="width:60px;" class="rdonly form-control" readonly ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_petty_date'class="col-sm-2" >DATE<em>*</em></label>
                            <div class="col-sm-4"><input type="text" id="BDLY_INPUT_tb_petty_date" name="BDLY_INPUT_tb_petty_date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control"style="width:75px;" ></div><!--datepickdate-->
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label><input  type="radio" id="BDLY_INPUT_radio_petty_cashin" name="BDLY_INPUT_radio_petty" class="BDLY_INPUT_class_submitvalidate" value="cashin">CASH IN</label>
                                <input type="text" id="BDLY_INPUT_tb_petty_cashin" name="BDLY_INPUT_tb_petty_cashin"  class="BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control"  style="width:50px" hidden>
                            </div>
                            <div class="radio">
                                <label><input type="radio" id="BDLY_INPUT_radio_petty_cashout" name="BDLY_INPUT_radio_petty" class="BDLY_INPUT_class_submitvalidate" value="cashout">CASH OUT</label>
                                <input type="text" id="BDLY_INPUT_tb_petty_cashout" name="BDLY_INPUT_tb_petty_cashout" class="BDLY_INPUT_class_submitvalidate BDLY_INPUT_class_numonly form-control"  style="width:50px" hidden>
                            </div>
                        </div>
                         <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_petty_invoiceitem' class="col-sm-2">INVOICE ITEM<em>*</em></label>
                            <div class="col-sm-2"><textarea id="BDLY_INPUT_ta_petty_invoiceitem" name="BDLY_INPUT_ta_petty_invoiceitem" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_petty_comment'class="col-sm-2" >COMMENTS</label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_petty_comments" id="BDLY_INPUT_ta_petty_comments" class="form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF HOUSE KEEPING ELEMENT-->
                    <div id="BDLY_INPUT_tble_housekeeping" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_house_cleanername' class="col-sm-2">CLEANER NAME<em>*</em></label>
                            <div class="col-sm-3"><select id='BDLY_INPUT_lb_house_cleanername' name="BDLY_INPUT_lb_house_cleanername" class="BDLY_INPUT_class_submitvalidate form-control"  >
                                    <option value='SELECT' selected="selected"> SELECT</option>
                                </select></div></div>
                        <div><input type="hidden" id="BDLY_INPUT_hidden_edeid" name="BDLY_INPUT_hidden_edeid"></div>
                        <div><table id="BDLY_INPUT_tble_radioclearnername"></table></div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_house_date' class="col-sm-2">WORK DATE<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_house_date" name="BDLY_INPUT_tb_house_date" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" style="width:75px;" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_house_duration' class="col-sm-2">DURATION<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_house_hours" name="BDLY_INPUT_tb_house_hours" class="BDLY_INPUT_class_submitvalidate hrnumonly BDLY_INPUT_class_numonly form-control" style="width:30px;" >
                                <input type="text" id="BDLY_INPUT_tb_house_min" name="BDLY_INPUT_tb_house_min"  class="BDLY_INPUT_class_submitvalidate hrnumonly BDLY_INPUT_class_numonly form-control"  style="width:30px;" >
                                </div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_house_desc' class="col-sm-2">DESCRIPTION<em>*</em></label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_house_desc" id="BDLY_INPUT_ta_house_desc" class="BDLY_INPUT_class_submitvalidate form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF HOUSEKEEPING PAYMENT ELEMENT-->
                    <div id="BDLY_INPUT_tble_housepayment" hidden>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_pay_unitno' class="col-sm-2">UNIT NO<em>*</em></label>
                            <div class="col-sm-4"><select id='BDLY_INPUT_tb_pay_unitno' name="BDLY_INPUT_tb_pay_unitno" class="BDLY_INPUT_class_hksubmitvalidate form-control"  >
                                    <option value='SELECT' selected="selected"> SELECT</option>
                                </select></div>
                            <input class="btn" type="button"  id="BDLY_INPUT_btn_addbutton" name="BDLY_INPUT_btn_addbutton" value="ADD"  />
                            <label class="errormsg" hidden id='BDLY_INPUT_lbl_pay_uniterrmsg' ></label>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_pay_invoiceamt'  class="col-sm-2">INVOICE AMOUNT<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_pay_invoiceamt" name="BDLY_INPUT_tb_pay_invoiceamt" class="BDLY_INPUT_class_submitvalidate thramtonly BDLY_INPUT_class_numonly form-control" style="width:45px;" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_pay_forperiod' class="col-sm-2">FOR PERIOD<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_pay_forperiod" name="BDLY_INPUT_tb_pay_forperiod" class="BDLY_INPUT_class_forperiod BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" style="width:95px;"></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_pay_paiddate' class="col-sm-2">PAID DATE<em>*</em></label>
                            <div class="col-sm-2"><input type="text" id="BDLY_INPUT_tb_pay_paiddate" name="BDLY_INPUT_tb_pay_paiddate" class="datepickdate BDLY_INPUT_class_hksubmitvalidate datemandtry form-control" style="width:75px;" ></div>
                        </div>
                        <div class="form-group">
                            <label  id='BDLY_INPUT_lbl_pay_comment' class="col-sm-2">COMMENTS</label>
                            <div class="col-sm-4"><textarea name="BDLY_INPUT_ta_pay_comments" id="BDLY_INPUT_ta_pay_comments" class="form-control" ></textarea></div>
                        </div>
                    </div>
                    <!--CREATING OF ELECTRICITY ELEMENT-->
                    <div class="table-responsive">
                        <table id="BDLY_INPUT_tble_electricity" cellpadding="10" cellspacing="2" hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_elect_unit" >UNIT</label><em>*</em> </td>
                            <td ><label  id="BDLY_INPUT_lbl_elect_invoiceto" >INVOICE TO</label><em>*</em></td>
                            <td > <label id="BDLY_INPUT_lbl_elect_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_fromperiod" >FROM PERIOD</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_toperiod" >TO PERIOD</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_elect_payment"  >PAYMENT OF</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_amount" >AMOUNT</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_elect_del" ></label> </td>
                        </tr>
                        <tr><td> <select  class="BDLY_INPUT_class_unit submultivalid "  name="BDLY_INPUT_lb_elect_unit" id="BDLY_INPUT_lb_elect_unit-1" hidden><option value="">SELECT</option></select> </td>
                            <td><input  class=' submultivalid rdonly'  type="text" name ="BDLY_INPUT_tb_invoiceto" id="BDLY_INPUT_tb_invoiceto1"  hidden readonly/><input type="text" id="BDLY_INPUT_hidden_ecnid_elec1" name="BDLY_INPUT_hidden_ecnid_elec" hidden> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_invoicedate" id="BDLY_INPUT_db_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_fromperiod" id="BDLY_INPUT_db_fromperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class='eledatepicker submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_toperiod" id="BDLY_INPUT_db_toperiod1" style="width:75px;" hidden/> </td>
                            <td><select  name="BDLY_INPUT_lb_elect_payment" class="submultivalid amtentry" id='BDLY_INPUT_lb_elect_payment1' hidden><option value="" >SELECT</option></select></td>
                            <td><input  class="amtonlyvalidation submultivalid BDLY_INPUT_class_numonly" type="text" name ="BDLY_INPUT_tb_elect_amount" id="BDLY_INPUT_tb_elect_amount1" style="width:50px;" hidden /> <input  class="amtonlyvalidation submultivalid BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_elect_minusamt" id="BDLY_INPUT_tb_elect_minusamt1" style="width:50px;" hidden /><input type="text" id="BDLY_INPUT_hidden_amt_elec1" name="BDLY_INPUT_hidden_amt_elec" hidden></td>
                            <td><textarea row="2" class=" submultivalid" name ="BDLY_INPUT_ta_comments" id="BDLY_INPUT_ta_comments1" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_add[]' id='BDLY_INPUT_add1'disabled > </td><td>
                                <input  type='button' value='-' class='deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_delete[]' id='BDLY_INPUT_del1' disabled ></td>
                        </tr>
                    </table>
                    </div>
                    <!--CREATING OF UNIT EXPENSE ELEMENT-->
                    <div class="table-responsive">
                    <table id="BDLY_INPUT_tble_unitexpense" cellpadding="10" cellspacing="2" hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_uexp_unit" >UNIT</label><em>*</em> </td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_category" >CATEGORY</label><em>*</em></td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_customer" hidden>CUSTOMER<em>*</em></label></td>
                            <td ><label  id="BDLY_INPUT_lbl_uexp_customerid" hidden></label></td>
                            <td > <label id="BDLY_INPUT_lbl_uexp_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_invoiceitem" >INVOICE ITEM</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_invoicefrom" >INVOICE FROM</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_amount" >AMOUNT</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_uexp_del" ></label> </td>
                        </tr>
                        <tr><td> <select  class="BDLY_INPUT_uexp_class_unit uexp_submultivalid "  name="BDLY_INPUT_lb_uexp_unit" id="BDLY_INPUT_lb_uexp_unit-1" hidden><option value="">SELECT</option></select> </td>
                            <td><select  name="BDLY_INPUT_lb_uexp_category" class="uexp_submultivalid BDLY_INPUT_uexp_class_category " id='BDLY_INPUT_lb_uexp_category-1' hidden><option value="" >SELECT</option></select></td>
                            <td><select  name="BDLY_INPUT_lb_uexp_customer" class="uexp_submultivalid BDLY_INPUT_uexp_class_custname" id='BDLY_INPUT_lb_uexp_customer1' hidden><option value="" >SELECT</option></select></td>
                            <td ><table id="multiplecustomer-1" width="250px" hidden></table>
                            <td><input  class='datepickdate uexp_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_uexp_invoicedate" id="BDLY_INPUT_db_uexp_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><textarea  class='uexp_submultivalid'  name ="BDLY_INPUT_tb_uexp_invoiceitem" id="BDLY_INPUT_tb_uexp_invoiceitem1"  hidden></textarea> </td>
                            <td><input  class=' uexp_submultivalid autosize autocomplete'  type="text" name ="BDLY_INPUT_tb_uexp_invoicefrom" id="BDLY_INPUT_tb_uexp_invoicefrom1"  hidden/> </td>
                            <td><input  class="amtonlyfivedigit uexp_submultivalid BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_uexp_amount" id="BDLY_INPUT_tb_uexp_amount1" style="width:60px;" hidden /> </td>
                            <td><textarea row="2" name ="BDLY_INPUT_ta_uexpcomments" id="BDLY_INPUT_ta_uexpcomments1" class=" uexp_submultivalid" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='uexp_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_uexpadd[]' id='BDLY_INPUT_uexp_add1'disabled > </td><td>
                                <input  type='button' value='-' class='uexp_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_uexpdelete[]' id='BDLY_INPUT_uexp_del1' disabled ></td>
                            <td><input    type="text" name ="BDLY_INPUT_tb_uexp_hideradioid" id="BDLY_INPUT_tb_uexp_hideradioid1" style="width:75px;" hidden/> </td>
                        </tr>
                    </table>
                    </div>
                    <!--CREATING OF STARHUB ELEMENT-->
                  <div class="table-responsive">
                    <table id="BDLY_INPUT_tble_starhub" cellpadding="10" cellspacing="2" hidden>
                        <tr> <td><label id="BDLY_INPUT_lbl_star_unit" >UNIT</label><em>*</em> </td>
                            <td ><label  id="BDLY_INPUT_lbl_star_invoiceto" >INVOICE TO</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_star_accountno"  >ACCOUNT NO</label><em>*</em> </td>
                            <td > <label id="BDLY_INPUT_lbl_star_invoicedate" >INVOICE DATE</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_fromperiod" >FROM PERIOD</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_toperiod" >TO PERIOD</label><em>*</em></td>
                            <td ><label id="BDLY_INPUT_lbl_star_amount" >AMOUNT</label><em>*</em> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_comments" >COMMENTS</label> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_add" ></label> </td>
                            <td ><label id="BDLY_INPUT_lbl_star_del" ></label> </td>
                        </tr>
                        <tr>
                            <td> <select  class="BDLY_INPUT_class_star_unit star_submultivalid "  name="BDLY_INPUT_lb_star_unit" id="BDLY_INPUT_lb_star_unit-1" hidden><option value="">SELECT</option></select> </td>
                            <td> <select  class="BDLY_INPUT_class_star_invoice star_submultivalid "  name="BDLY_INPUT_lb_star_invoiceto" id="BDLY_INPUT_lb_star_invoice-1" hidden><option value="">SELECT</option></select><input type="hidden" id="BDLY_INPUT_hidden_star_ecnid1" name="BDLY_INPUT_hidden_star_ecnid"> </td>
                            <td><input  class=' star_submultivalid rdonly'  type="text" name ="BDLY_INPUT_tb_star_accno" id="BDLY_INPUT_tb_star_accno1"  hidden readonly/> </td>
                            <td><input  class='starinvdatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_invoicedate" id="BDLY_INPUT_db_star_invoicedate1" style="width:75px;" hidden /> </td>
                            <td><input  class='starfrmdatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_fromperiod" id="BDLY_INPUT_db_star_fromperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class='startodatepickdate star_submultivalid datemandtry'  type="text" name ="BDLY_INPUT_db_star_toperiod" id="BDLY_INPUT_db_star_toperiod1" style="width:75px;" hidden/> </td>
                            <td><input  class=" star_submultivalid includeminusfour BDLY_INPUT_class_numonly"  type="text" name ="BDLY_INPUT_tb_star_amount" id="BDLY_INPUT_tb_star_amount1" style="width:55px;" maxlength=4 hidden /> </td>
                            <td><textarea row="2" class=" star_submultivalid"  name ="BDLY_INPUT_ta_star_comments" id="BDLY_INPUT_ta_star_comments1" hidden ></textarea> </td><td>
                                <input type='button' value='+' class='star_addbttn' alt='Add Row' height='30' width='30' name ='BDLY_INPUT_add[]' id='BDLY_INPUT_star_add1'disabled > </td><td>
                                <input  type='button' value='-' class='star_deletebttn' alt='delete Row' height='30' width='30' name ='BDLY_INPUT_delete[]' id='BDLY_INPUT_star_del1' disabled ></td>
                        </tr>
                    </table>
                    </div>
                        <div class="col-lg-offset-1" id="BDLY_INPUT_tble_button">
                            <input class="btn" type="button"  id="BDLY_INPUT_btn_submitbutton" name="BDLY_INPUT_btn_submitbutton" value="SAVE" disabled  hidden/>&nbsp;&nbsp;<input class="btn" type="button"  id="BDLY_INPUT_btn_resetbutton" name="BDLY_INPUT_btn_resetbutton" value="RESET" hidden />
                      </div>

                    <div>
                      <input class="btn" type="button"  id="BDLY_INPUT_btn_multisubmitbutton" name="SAVE" value="SAVE" disabled hidden/>
                      <label class="errormsg" id="BDLY_INPUT_lbl_hourmsg" ></label>
                      <label class="errormsg" id="BDLY_INPUT_lbl_minmsg" ></label>
                      <label class="errormsg" id="BDLY_INPUT_lbl_checkcardno" ></label>
                    </div>
                    <input type="hidden" id="BDLY_INPUT_hidden_edcpid" name="BDLY_INPUT_hidden_edcpid">
                    <input type="hidden" id="BDLY_INPUT_hidden_customerid" name="BDLY_INPUT_hidden_customerid">
            </div>

        </div>
    </form>
</div>
</body>
</html>