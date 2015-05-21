<html>
<head>
<?php
include "Header.php";
?>
<script>
var ErrorControl ={AmountCompare:'InValid'}
$(document).ready(function(){
    $('#spacewidth').height('0%');
    $('textarea').autogrow({onInitialize: true});
    $(document).on('click','#PDLY_SEARCH_tbl_htmltable tr td input[type="radio"]',function() {
        $('#PDLY_SEARCH_tbl_htmltable tr').removeClass('higlightrow');
        $(this).closest('tr').addClass('higlightrow');
    });
    $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
    $("#PDLY_SEARCH_tb_fromamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,smallerthan:'PDLY_SEARCH_tb_toamount'}});
    $("#PDLY_SEARCH_tb_toamount").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2,greaterthan:'PDLY_SEARCH_tb_fromamount'}});
    $(".autosize").doValidation({rule:'general',prop:{autosize:true}});
    var PDLY_SEARCH_flag_deleteupd=0;
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_lb_babysearchoption').hide();
        $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
        $("#PDLY_SEARCH_btn_babybutton").hide();
        $("#PDLY_SEARCH_div_htmltable").hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        var PDLY_SEARCH_babyexpensecategArray=[];
        var PDLY_SEARCH_typofexpensesarray=[];
        var PDLY_SEARCH_carexpensecategArray=[];
        var PDLY_SEARCH_personalexpensecategArray=[];
        var PDLY_SEARCH_hdrmsgArray=[];
        var PDLY_SEARCH_typeid=[];
        var PDLY_SEARCH_expensepersonalArray=[];
        var PDLY_SEARCH_expensecarloanArray=[];
        var PDLY_SEARCH_expensecarArray=[];
        var PDLY_SEARCH_expensebabyArray=[];
        var PDLY_SEARCH_expenseArray=[];
        var PDLY_SEARCH_errorArraye=[];
        var PDLY_SEARCH_dataArray=[];
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/commondata",
            success: function(res) {
                $('.preloader').hide();
                var arrayvalues=JSON.parse(res);
                PDLY_SEARCH_expensepersonalArray=arrayvalues[0];
                PDLY_SEARCH_expensecarloanArray=arrayvalues[3];
                PDLY_SEARCH_expensecarArray=arrayvalues[2];
                PDLY_SEARCH_expensebabyArray=arrayvalues[1];
                var PDLY_SEARCH_errmsgarr=arrayvalues[7];
                $(".PDLY_SEARCH_class_numonly").prop("title",PDLY_SEARCH_errmsgarr[0]);
                for(var e=0;e<=PDLY_SEARCH_errmsgarr.length-1;e++){
                    PDLY_SEARCH_hdrmsgArray[e]=PDLY_SEARCH_errmsgarr[e+1];
                }
                PDLY_SEARCH_babyexpensecategArray=arrayvalues[4];
                PDLY_SEARCH_errorArraye=arrayvalues[8];
                PDLY_SEARCH_carexpensecategArray=arrayvalues[5];
                PDLY_SEARCH_personalexpensecategArray=arrayvalues[6];
                PDLY_SEARCH_dataArray=arrayvalues[0];
                var PDLY_SEARCH_options ='';
                for (var i = 0; i < PDLY_SEARCH_errorArraye.length; i++) {
                    if(i>=0 && i<=3)
                    {
                        PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                    }
                }
                $('#PDLY_SEARCH_lb_typelist').html(PDLY_SEARCH_options);
                PDLY_SEARCH_Sortit('PDLY_SEARCH_lb_typelist');

            }
            });
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchabycmt" ).keypress(function(){
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        if($( "#PDLY_SEARCH_tb_searchabycmt" ).val()=="")
        {
            $('#PDLY_SEARCH_btn_babybutton').hide();
        }
        PDLY_SEARCH_highlightSearchText();
        $( "#PDLY_SEARCH_tb_searchabycmt" ).autocomplete({
            source: csearchval,
            select: PDLY_SEARCH_AutoCompleteSelectHandler
        });
    });
//FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function PDLY_SEARCH_highlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
//FUNCTION TO GET SELECTED VALUE//
    function PDLY_SEARCH_AutoCompleteSelectHandler(event, ui) {
        $('#PDLY_SEARCH_btn_babybutton').show();
        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
    }
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchbyinvfrom" ).keypress(function(){
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        PDLY_SEARCH_invfromhighlightSearchText();
        $( "#PDLY_SEARCH_tb_searchbyinvfrom" ).autocomplete({
            source: Ivsearchval,
            select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
        });
    });
//CALL FUNCTION TO HIGHLIGHT SEARCH TEXT//
    $( "#PDLY_SEARCH_tb_searchbyinvitem" ).keypress(function(){
        PDLY_SEARCH_invfromhighlightSearchText();
        $('#PDLY_SEARCH_btn_babybutton').hide();
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_SEARCH_btn_searchbutton').hide();
        $('#PDLY_SEARCH_btn_deletebutton').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $('#PDLY_SEARCH_btn_sbutton,#PDLY_SEARCH_btn_rbutton').hide();
        $( "#PDLY_SEARCH_tb_searchbyinvitem" ).autocomplete({
            source: itmIvsearchval,
            select: PDLY_SEARCH_invfromAutoCompleteSelectHandler
        });
    });
//FUNCTION TO HIGHLIGHT SEARCH TEXT//
    function PDLY_SEARCH_invfromhighlightSearchText() {
        $.ui.autocomplete.prototype._renderItem = function( ul, item) {
            var re = new RegExp(this.term, "i") ;
            var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + t + "</a>" )
                .appendTo( ul );
        };
    }
//FUNCTION TO GET SELECTED VALUE//
    function PDLY_SEARCH_invfromAutoCompleteSelectHandler(event, ui) {
        $('#PDLY_SEARCH_btn_babybutton').show();
        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
    }
//SORTING
        function PDLY_SEARCH_Sortit(lbid) {
            var $r = $("#"+lbid+" "+"option");
            $r.sort(function(a,b){
                if (a.text < b.text) return -1;
                if (a.text == b.text) return 0;
                return 1;
            });
            $($r).remove();
            $("#"+lbid).append($($r));
            $("#"+lbid+" "+"option").eq(0).before('<option value="SELECT">SELECT</option>')
            $("select#"+lbid)[0].selectedIndex = 0;
        }
//SEARCH BY TYPE OF EXPENSE//
        $('#PDLY_SEARCH_lb_typelist').change(function(){
            $(".preloader").show();
            $('#PDLY_SEARCH_tble_carloan').hide();
            $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
            $("#PDLY_SEARCH_lbl_bybabycmts").hide();
            $("#PDLY_SEARCH_tble_multi").hide();
            $("#PDLY_SEARCH_tble_searchtable").hide();
            $("#PDLY_SEARCH_btn_babybutton").hide();
            $("#PDLY_SEARCH_div_htmltable").hide();
            $("#PDLY_SEARCH_btn_searchbutton").hide();
            $("#PDLY_SEARCH_btn_deletebutton").hide();
            $('#PDLY_SEARCH_btn_sbutton').hide();
            $('#PDLY_SEARCH_btn_rbutton').hide();
            $('#PDLY_SEARCH_lb_babysearchoption').hide();
            $('#PDLY_SEARCH_lbl_babysearchoption').hide();
            var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            if(PDLY_SEARCH_lb_typelistvalue=="SELECT")
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_flextableheader').hide();
                $("#PDLY_SEARCH_lbl_bybabycmts").hide();
                $("#PDLY_SEARCH_tble_multi").hide();
                $("#PDLY_SEARCH_tble_searchtable").hide();
                $("#PDLY_SEARCH_btn_babybutton").hide();
                $("#PDLY_SEARCH_div_htmltable").hide();
                $("#PDLY_SEARCH_btn_searchbutton").hide();
                $("#PDLY_SEARCH_btn_deletebutton").hide();
                $('#PDLY_SEARCH_btn_sbutton').hide();
                $('#PDLY_SEARCH_btn_rbutton').hide();
                $('#PDLY_SEARCH_lb_babysearchoption').hide();
                $('#PDLY_SEARCH_lbl_babysearchoption').hide();
            }
            if(PDLY_SEARCH_lb_typelistvalue==36)
            {
                if((PDLY_SEARCH_expensebabyArray).length==0)
                {
                    $(".preloader").hide();
                    $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[32].EMC_DATA);
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                }
                else
                {
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                    PDLY_SEARCH_loadbabydata();
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==35)
            {
                if((PDLY_SEARCH_expensecarArray).length==0)
                {
                    $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[33].EMC_DATA);
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                    $(".preloader").hide();
                }
                else
                {
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                    PDLY_SEARCH_loadbabydata();
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==38)
            {
                if((PDLY_SEARCH_expensecarloanArray).length==0)
                {
                    $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[34].EMC_DATA);
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                    $(".preloader").hide();
                }
                else
                {
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                    PDLY_SEARCH_loadbabydata();
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==37)
            {
                if((PDLY_SEARCH_expensepersonalArray).length==0)
                {
                    $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_hdrmsgArray[29].EMC_DATA);
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").show();
                    $(".preloader").hide();
                }
                else
                {
                    $("#PDLY_SEARCH_lbl_nodataerrormsg").hide();
                    PDLY_SEARCH_loadbabydata();
                }
            }
        });

//LOADA THE TYPE OF SEARCH OPTION BY BABY  SEARCH//
        function PDLY_SEARCH_loadbabydata()//PDLY_SEARCH_loadbabydatavalue
        {
            $(".preloader").hide();
            var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_options ='';
            for (var i = 0; i < PDLY_SEARCH_errorArraye.length; i++) {
                if(PDLY_SEARCH_lb_typelistvalue==36 && i>=4 && i<=9)
                {
                    PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==35 && i>=10 && i<=15)
                {
                    PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==38 && i>=16 && i<=20)
                {
                    PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==37 && i>=21 && i<=26)
                {
                    PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_errorArraye[i].ECN_ID + '">' + PDLY_SEARCH_errorArraye[i].ECN_DATA + '</option>';
                }
            }
            $('#PDLY_SEARCH_lb_babysearchoption').empty();
            $('#PDLY_SEARCH_lbl_babysearchoption').show();
            $('#PDLY_SEARCH_lb_babysearchoption').html(PDLY_SEARCH_options);
            PDLY_SEARCH_Sortit('PDLY_SEARCH_lb_babysearchoption');
            $('#PDLY_SEARCH_lb_babysearchoption').show();
            $("select#PDLY_SEARCH_lb_babysearchoption")[0].selectedIndex = 0;
        }
//SEARCH BY THE BABY EXPENSE//
        $('#PDLY_SEARCH_lb_babysearchoption').change(function(){
            $(".preloader").show();
            $('#PDLY_SEARCH_db_enddate,#PDLY_SEARCH_db_startdate,#PDLY_SEARCH_tb_searchbyinvfrom').val('');
            $('#PDLY_SEARCH_lbl_searchbyinvitem,#PDLY_SEARCH_lbl_searchbyinvfrom,#PDLY_SEARCH_tb_searchbyinvfrom').hide();
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
            $('#PDLY_SEARCH_btn_babybutton').hide();
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            $("#PDLY_SEARCH_tble_multi").hide();
            $("#PDLY_SEARCH_lbl_bybabycmts").hide();
            $("#PDLY_SEARCH_tble_searchtable").hide();
            $("#PDLY_SEARCH_div_htmltable").hide();
            $("#PDLY_SEARCH_btn_searchbutton").hide();
            $("#PDLY_SEARCH_btn_deletebutton").hide();
            $('#PDLY_SEARCH_btn_sbutton').hide();
            $('#PDLY_SEARCH_btn_rbutton').hide();
            $('#PDLY_SEARCH_tble_carloan').hide();
            if(PDLY_SEARCH_lb_babysearchoptionvalue=="SELECT")
            {
                $(".preloader").hide();
                $("#PDLY_SEARCH_lbl_bybabycmts").hide();
                $("#PDLY_SEARCH_tble_multi").hide();
                $("#PDLY_SEARCH_tble_searchtable").hide();
                $("#PDLY_SEARCH_div_htmltable").hide();
                $("#PDLY_SEARCH_btn_searchbutton").hide();
                $("#PDLY_SEARCH_btn_deletebutton").hide();
                $('#PDLY_SEARCH_btn_sbutton').hide();
                $('#PDLY_SEARCH_btn_rbutton').hide();
            }
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_toamount').hide();
                $('#PDLY_SEARCH_tb_toamount').hide();
                $('#PDLY_SEARCH_lbl_fromamount').hide();
                $('#PDLY_SEARCH_tb_fromamount').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').val('').hide();
                $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lbl_startdate').show();
                $('#PDLY_SEARCH_db_startdate').val('').show();
                $('#PDLY_SEARCH_lbl_enddate').show();
                $('#PDLY_SEARCH_db_enddate').val('').show();
                $('#PDLY_SEARCH_btn_babybutton').hide();
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
//SEARCH BY BABY CATEGORY//
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
            {
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_toamount').hide();
                $('#PDLY_SEARCH_tb_toamount').hide();
                $('#PDLY_SEARCH_lbl_fromamount').hide();
                $('#PDLY_SEARCH_tb_fromamount').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').hide();
                var categorydata=$('#PDLY_SEARCH_lb_babysearchoption').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_lb_babysearchoptionvalue",
                    data:'&categorydata='+categorydata,
                    success: function(res) {
                        $(".preloader").hide();
                        var PDLY_SEARCH_babyexpensecategArray=JSON.parse(res);
                        var PDLY_SEARCH_options =' <option>SELECT</option>';
                        for (var i = 0; i < PDLY_SEARCH_babyexpensecategArray.length; i++) {
                            PDLY_SEARCH_options += '<option value="' + PDLY_SEARCH_babyexpensecategArray[i].ECN_DATA + '">' + PDLY_SEARCH_babyexpensecategArray[i].ECN_DATA + '</option>';
                        }
                        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                        $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                        if(PDLY_SEARCH_lb_babysearchoptionvalue==52)
                        {
                            $('#PDLY_SEARCH_lbl_babyexpansecategory').text('BABY EXPENSE CATEGORY').show();
                        }
                        if(PDLY_SEARCH_lb_babysearchoptionvalue==58)
                        {
                            $('#PDLY_SEARCH_lbl_babyexpansecategory').text('CAR EXPENSE CATEGORY').show();
                        }
                        if(PDLY_SEARCH_lb_babysearchoptionvalue==69)
                        {
                            $('#PDLY_SEARCH_lbl_babyexpansecategory').text('PERSONAL EXPENSE CATEGORY').show();
                        }
                        $('#PDLY_SEARCH_lb_babyexpansecategory').html(PDLY_SEARCH_options);
                        $('#PDLY_SEARCH_lb_babyexpansecategory').show();
                        $("select#PDLY_SEARCH_lb_babyexpansecategory")[0].selectedIndex = 0;
                        $('#PDLY_SEARCH_lbl_startdate').show();
                        $('#PDLY_SEARCH_db_startdate').val('').show();
                        $('#PDLY_SEARCH_lbl_enddate').show();
                        $('#PDLY_SEARCH_db_enddate').val('').show();
                        $('#PDLY_SEARCH_btn_babybutton').show();
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }

            });
            }
//SEARCH BY INVOICE AMOUNT//
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').hide();
                $('#PDLY_SEARCH_lbl_toamount').show();
                $('#PDLY_SEARCH_tb_toamount').val('').show();
                $('#PDLY_SEARCH_lbl_fromamount').show();
                $('#PDLY_SEARCH_tb_fromamount').val('').show();
                $('#PDLY_SEARCH_lbl_startdate').show();
                $('#PDLY_SEARCH_db_startdate').val('').show();
                $('#PDLY_SEARCH_lbl_enddate').show();
                $('#PDLY_SEARCH_db_enddate').val('').show();
                $('#PDLY_SEARCH_btn_babybutton').show();
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
//SEARCH BY BABY EXPENSE INVOICE DATE//
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_toamount').hide();
                $('#PDLY_SEARCH_tb_toamount').hide();
                $('#PDLY_SEARCH_lbl_fromamount').hide();
                $('#PDLY_SEARCH_tb_fromamount').hide();
                $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').hide();
                $('#PDLY_SEARCH_lbl_startdate').show();
                $('#PDLY_SEARCH_db_startdate').val('').show();
                $('#PDLY_SEARCH_lbl_enddate').show();
                $('#PDLY_SEARCH_db_enddate').val('').show();
                $('#PDLY_SEARCH_btn_babybutton').show();
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_toamount').hide();
                $('#PDLY_SEARCH_tb_toamount').hide();
                $('#PDLY_SEARCH_lbl_fromamount').hide();
                $('#PDLY_SEARCH_tb_fromamount').hide();
                $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').show();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').text('INVOICE FROM').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').val('').hide();
                $('#PDLY_SEARCH_lbl_startdate').show();
                $('#PDLY_SEARCH_db_startdate').val('').show();
                $('#PDLY_SEARCH_lbl_enddate').show();
                $('#PDLY_SEARCH_db_enddate').val('').show();
                $('#PDLY_SEARCH_btn_babybutton').hide();
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
            {
                $(".preloader").hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').text('SEARCH BY '+$('#PDLY_SEARCH_lb_typelist').find('option:selected').text()+' EXPENSE ' +$('#PDLY_SEARCH_lb_babysearchoption').find('option:selected').text()).show();
                $("#PDLY_SEARCH_tble_searchtable").show();
                $('#PDLY_SEARCH_lbl_toamount').hide();
                $('#PDLY_SEARCH_tb_toamount').hide();
                $('#PDLY_SEARCH_lbl_fromamount').hide();
                $('#PDLY_SEARCH_tb_fromamount').hide();
                $('#PDLY_SEARCH_lbl_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lb_babyexpansecategory').hide();
                $('#PDLY_SEARCH_lbl_searchabycmt').hide();
                $('#PDLY_SEARCH_tb_searchabycmt').hide();
                $('#PDLY_SEARCH_lbl_bybabycmts').show();
                $('#PDLY_SEARCH_lbl_searchbyinvfrom').hide();
                $('#PDLY_SEARCH_tb_searchbyinvfrom').val('').hide();
                $('#PDLY_SEARCH_tb_searchbyinvitem').val('').hide();
                $('#PDLY_SEARCH_lbl_searchbyinvitem').hide();
                $('#PDLY_SEARCH_lbl_startdate').show();
                $('#PDLY_SEARCH_db_startdate').val('').show();
                $('#PDLY_SEARCH_lbl_enddate').show();
                $('#PDLY_SEARCH_db_enddate').val('').show();
                $('#PDLY_SEARCH_btn_babybutton').hide();
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
        });

//DATE PICKER USED IN THE UPDATE FORM//
        $('#PDLY_SEARCH_db_invdate').datepicker("option","maxDate",new Date());
        $(".PDLY_SEARCH_db_invdate").datepicker({dateFormat:'dd-mm-yy',
            changeYear: true,
            changeMonth: true});
//DATEPICKER FOR  START DATE AND END DATE//
        $(".datebox").datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true,maxDate:new Date(),
            onSelect: function(date){
                PDLY_SEARCH_searchvalue();
                $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
                $('#PDLY_SEARCH_div_htmltable').hide();
                $('#PDLY_SEARCH_tble_multi').hide();
                $("#PDLY_SEARCH_btn_searchbutton").hide();
                $("#PDLY_SEARCH_btn_deletebutton").hide();
                $('#PDLY_SEARCH_btn_sbutton').hide();
                $('#PDLY_SEARCH_btn_rbutton').hide();
                $('#PDLY_SEARCH_tble_carloan').hide();
                var PDLY_SEARCH_startdate = $('#PDLY_SEARCH_db_startdate').datepicker('getDate');
                var date = new Date( Date.parse( PDLY_SEARCH_startdate ) );
                date.setDate( date.getDate() );
                var PDLY_SEARCH_newDate = date.toDateString();
                PDLY_SEARCH_newDate = new Date( Date.parse( PDLY_SEARCH_newDate ) );
                $('#PDLY_SEARCH_db_enddate').datepicker("option","minDate",PDLY_SEARCH_newDate);
                var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                $('#PDLY_SEARCH_lbl_flextableheader').hide();
                if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
                {
                    if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_tb_searchabycmt").val()==""))
                    {
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                    }
                }
//VALIDATION FOR SEARCH BUTTON (BABY EXPASE CATEGORY//
                if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
                {
                    if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_lb_babyexpansecategory").val()=="SELECT"))
                    {
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                    }
                }
//VALIDATION TO SEARCH ,BY BABY INVOICE AMOUNT//
                if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
                {
                    if(($("#PDLY_SEARCH_db_startdate").val()!="")||($("#PDLY_SEARCH_db_enddate").val()!=""))
                    {
                        if(($("#PDLY_SEARCH_tb_fromamount").val()!="")||($("#PDLY_SEARCH_tb_toamount").val()!=""))
                        {
                            if(ErrorControl.AmountCompare=='Valid')
                            {
                                $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                            }
                            else
                            {
                                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                                $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1]).show();
                            }
                        }
                    }
                }
//VALIDATION TO SEARCH  , SEARCH BY BABY INVOICE DATE//
                if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
                {
                    if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()==""))
                    {
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                    }
                }
//VALIDATION TO SEARCH , SEARCH BY BABY INVOICE FROM//
                if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
                {
                    if(($("#PDLY_SEARCH_tb_searchbyinvfrom").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
                    {
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                    }
                }
//VALIDATION TO SEARCH , SEARCH BY STAFF INVOICE ITEMS//
                if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
                {
                    if(($("#PDLY_SEARCH_tb_searchbyinvitem").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
                    {
                        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                    }
                    else
                    {
                        $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                    }
                }
            }
        });
    var csearchval=[];
    var Ivsearchval = [];
    var itmIvsearchval = [];
        function PDLY_SEARCH_searchvalue()
        {
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
            if(($('#PDLY_SEARCH_db_startdate').val()!="") && ($('#PDLY_SEARCH_db_enddate').val()!=""))
            {
                var PDLY_SEARCH_lb_getstartvaluevalue=$('#PDLY_SEARCH_db_startdate').val();
                var PDLY_SEARCH_lb_getendvaluevalue=$('#PDLY_SEARCH_db_enddate').val();
                var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
                if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
                {
                    $('.preloader').show();
                    var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_lb_comments",
                        data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue,
                        success: function(res) {
                            $('.preloader').hide();
                            var values=JSON.parse(res);
                            if(PDLY_SEARCH_lb_typelistvalue==36)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EB_COMMENTS!='' && values[m].EB_COMMENTS!=null)
                                        csearchval.push(values[m].EB_COMMENTS);
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==35)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EC_COMMENTS!='' && values[m].EC_COMMENTS!=null)
                                        csearchval.push(values[m].EC_COMMENTS);
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==37)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EP_COMMENTS!='' && values[m].EP_COMMENTS!=null)
                                        csearchval.push(values[m].EP_COMMENTS);
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==38)
                            {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].ECL_COMMENTS!='' && values[m].ECL_COMMENTS!=null)
                                        csearchval.push(values[m].ECL_COMMENTS);
                                }
                            }

                            var response_len=values.length;
                            if(response_len>0){
                                $('#PDLY_SEARCH_tb_searchabycmt').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                            }
                            else{
                                $('#PDLY_SEARCH_tb_searchabycmt').attr("disabled", "disabled").attr('placeholder','No Matchs').val('');
                            }
                            $('#PDLY_SEARCH_lbl_searchabycmt').show();
                            $('#PDLY_SEARCH_tb_searchabycmt').show();
                            $('#PDLY_SEARCH_btn_babybutton').hide();
                            if(PDLY_SEARCH_flag_deleteupd==1){
                                PDLY_SEARCH_flag_deleteupd=0;
                                var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                                var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
                                show_msgbox("PERSONAL EXPENSE: SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                            }
                        }
                        });
                }
                if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
                {
                    $('.preloader').show();
                    var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_lb_invoicefrom",
                        data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue+'&PDLY_SEARCH_lb_babysearchoptionvalue='+PDLY_SEARCH_lb_babysearchoptionvalue,
                        success: function(res) {
                            $('.preloader').hide();
                            var values=JSON.parse(res);
                            if(PDLY_SEARCH_lb_typelistvalue==36)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==55)
                                {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EB_INVOICE_FROM!='' && values[m].EB_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EB_INVOICE_FROM);
                                }
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==35)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==61)
                                {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EC_INVOICE_FROM!='' && values[m].EC_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EC_INVOICE_FROM);
                                }
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==37)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==72)
                                {
                                for(var m=0;m<values.length;m++)
                                {
                                    if(values[m].EP_INVOICE_FROM!='' && values[m].EP_INVOICE_FROM!=null)
                                        Ivsearchval.push(values[m].EP_INVOICE_FROM);
                                }
                                }
                            }

                            $('#PDLY_SEARCH_lbl_searchbyinvfrom').show();
                            $('#PDLY_SEARCH_tb_searchbyinvfrom').show();
                            var response_len=values.length;
                            if(response_len>0){
                                $('#PDLY_SEARCH_tb_searchbyinvfrom').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                            }
                            else{
                                $('#PDLY_SEARCH_tb_searchbyinvfrom').attr("disabled", "disabled").attr('placeholder','No Matchs').val('');
                            }
                            $('#PDLY_SEARCH_btn_babybutton').hide();
                            if(PDLY_SEARCH_flag_deleteupd==1){
                                PDLY_SEARCH_flag_deleteupd=0;
                                var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                                var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
                                show_msgbox("PERSONAL EXPENSE: SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                            }
                        }
                    });
                }
                if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
                {
                    $('.preloader').show();
                    var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_lb_invoiceitems",
                        data:'&PDLY_SEARCH_lb_typelistvalue='+PDLY_SEARCH_lb_typelistvalue+'&PDLY_SEARCH_lb_getstartvaluevalue='+PDLY_SEARCH_lb_getstartvaluevalue+'&PDLY_SEARCH_lb_getendvaluevalue='+PDLY_SEARCH_lb_getendvaluevalue+'&PDLY_SEARCH_lb_babysearchoptionvalue='+PDLY_SEARCH_lb_babysearchoptionvalue,
                        success: function(res) {
                            $('.preloader').hide();
                            var values=JSON.parse(res);
                            if(PDLY_SEARCH_lb_typelistvalue==36)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==54)
                                {
                                    for(var m=0;m<values.length;m++)
                                    {
                                        if(values[m].EB_INVOICE_ITEMS!='' && values[m].EB_INVOICE_ITEMS!=null)
                                            itmIvsearchval.push(values[m].EB_INVOICE_ITEMS);
                                    }
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==35)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==60)
                                {
                                    for(var m=0;m<values.length;m++)
                                    {
                                        if(values[m].EC_INVOICE_ITEMS!='' && values[m].EC_INVOICE_ITEMS!=null)
                                            itmIvsearchval.push(values[m].EC_INVOICE_ITEMS);
                                    }
                                }
                            }
                            if(PDLY_SEARCH_lb_typelistvalue==37)
                            {
                                if(PDLY_SEARCH_lb_babysearchoptionvalue==71)
                                {
                                    for(var m=0;m<values.length;m++)
                                    {
                                        if(values[m].EP_INVOICE_ITEMS!='' && values[m].EP_INVOICE_ITEMS!=null)
                                            itmIvsearchval.push(values[m].EP_INVOICE_ITEMS);
                                    }
                                }
                            }
                            $('#PDLY_SEARCH_tb_searchbyinvitem').val('').show();
                            $('#PDLY_SEARCH_lbl_searchbyinvitem').show();
                            $('#PDLY_SEARCH_btn_babybutton').hide();
                            var response_len=values.length;
                            if(response_len>0){
                                $('#PDLY_SEARCH_tb_searchbyinvitem').removeAttr("disabled").attr('placeholder',response_len+' Records Matching').val('');
                            }
                            else{
                                $('#PDLY_SEARCH_tb_searchbyinvitem').attr("disabled", "disabled").attr('placeholder','No Matchs').val('');
                            }
                            if(PDLY_SEARCH_flag_deleteupd==1){
                                PDLY_SEARCH_flag_deleteupd=0;
                                var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
                                var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].replace('[TYPE]', PDLY_SEARCH_expensetype);
                                show_msgbox("PERSONAL EXPENSE: SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
                            }
                            }
                         });
                }
            }
        }
//SUBMIT BUTTON  VALIDATION FOR SEARCHING FORM//
    $(".submitval").change(function(){
        $('textarea').height(20);
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if((PDLY_SEARCH_lb_babysearchoptionvalue==56)||(PDLY_SEARCH_lb_babysearchoptionvalue==62)||(PDLY_SEARCH_lb_babysearchoptionvalue==73)||(PDLY_SEARCH_lb_babysearchoptionvalue==67))
        {
            if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_tb_searchabycmt").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION FOR SEARCH BUTTON (BABY EXPASE CATEGORY//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==52)||(PDLY_SEARCH_lb_babysearchoptionvalue==58)||(PDLY_SEARCH_lb_babysearchoptionvalue==69))
        {
            if(($("#PDLY_SEARCH_db_startdate").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_lb_babyexpansecategory").val()=="SELECT"))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH  , SEARCH BY BABY INVOICE DATE//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==53)||(PDLY_SEARCH_lb_babysearchoptionvalue==59)||(PDLY_SEARCH_lb_babysearchoptionvalue==70)||(PDLY_SEARCH_lb_babysearchoptionvalue==63)||(PDLY_SEARCH_lb_babysearchoptionvalue==66)||(PDLY_SEARCH_lb_babysearchoptionvalue==64))
        {
            if(($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY BABY INVOICE FROM//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==55)||(PDLY_SEARCH_lb_babysearchoptionvalue==61)||(PDLY_SEARCH_lb_babysearchoptionvalue==72))
        {
            if(($("#PDLY_SEARCH_tb_searchbyinvfrom").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
//VALIDATION TO SEARCH , SEARCH BY STAFF INVOICE ITEMS//
        if((PDLY_SEARCH_lb_babysearchoptionvalue==54)||(PDLY_SEARCH_lb_babysearchoptionvalue==60)||(PDLY_SEARCH_lb_babysearchoptionvalue==71))
        {
            if(($("#PDLY_SEARCH_tb_searchbyinvitem").val()=="")||($("#PDLY_SEARCH_db_enddate").val()=="")||($("#PDLY_SEARCH_db_startdate").val()==""))
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
            }
        }
        if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
        {
            if(($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                }
            }
            if(($("#PDLY_SEARCH_db_startdate").val()!="")&&($("#PDLY_SEARCH_db_enddate").val()!="")&&($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
        }
    });
    $(".amtsubmitval").blur(function(){
        $('#PDLY_SEARCH_div_htmltable').hide();
        $('#PDLY_SEARCH_tble_multi').hide();
        $("#PDLY_SEARCH_btn_searchbutton").hide();
        $("#PDLY_SEARCH_btn_deletebutton").hide();
        $('#PDLY_SEARCH_btn_sbutton').hide();
        $('#PDLY_SEARCH_btn_rbutton').hide();
        $('#PDLY_SEARCH_tble_carloan').hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_lbl_flextableheader').hide();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if((PDLY_SEARCH_lb_babysearchoptionvalue==51)||(PDLY_SEARCH_lb_babysearchoptionvalue==57)||(PDLY_SEARCH_lb_babysearchoptionvalue==68)||(PDLY_SEARCH_lb_babysearchoptionvalue==65))
        {
            if(($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            if(($("#PDLY_SEARCH_db_startdate").val()!="")&&($("#PDLY_SEARCH_db_enddate").val()!="")&&($("#PDLY_SEARCH_tb_fromamount").val()!="")&&($("#PDLY_SEARCH_tb_toamount").val()!=""))
            {
                $('#PDLY_SEARCH_btn_babybutton').removeAttr("disabled");
                if(ErrorControl.AmountCompare=='Valid')
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#PDLY_SEARCH_lbl_amounterrormsg').text(PDLY_SEARCH_hdrmsgArray[1].EMC_DATA).show();
                    $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
                }
            }
            else
            {
                $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            }
        }
    });

    //SEND VALUES TO DB FOR LOAD THE FLEX TABLES//
    $('#PDLY_SEARCH_btn_babybutton').click(function(){
        $(".preloader").show();
        PDLY_SEARCH_loadflextable();
    });
    var  PDLY_SEARCH_babysearchdetailsvalues=[];
    function PDLY_SEARCH_loadflextable()
    {$(".preloader").show();
        var PDLY_SEARCH_lb_babysearchoptionmatch=$("#PDLY_SEARCH_lb_babysearchoption").val();
        if((PDLY_SEARCH_lb_babysearchoptionmatch==56)||(PDLY_SEARCH_lb_babysearchoptionmatch==62)||(PDLY_SEARCH_lb_babysearchoptionmatch==73)||(PDLY_SEARCH_lb_babysearchoptionmatch==67))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments=$('#PDLY_SEARCH_tb_searchabycmt').val();
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
        if((PDLY_SEARCH_lb_babysearchoptionmatch==52)||(PDLY_SEARCH_lb_babysearchoptionmatch==58)||(PDLY_SEARCH_lb_babysearchoptionmatch==69))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
        if((PDLY_SEARCH_lb_babysearchoptionmatch==51)||(PDLY_SEARCH_lb_babysearchoptionmatch==57)||(PDLY_SEARCH_lb_babysearchoptionmatch==68)||(PDLY_SEARCH_lb_babysearchoptionmatch==65))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount=$('#PDLY_SEARCH_tb_fromamount').val();
            var PDLY_SEARCH_toamount=$('#PDLY_SEARCH_tb_toamount').val();
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE DATE//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==53)||(PDLY_SEARCH_lb_babysearchoptionmatch==59)||(PDLY_SEARCH_lb_babysearchoptionmatch==70)||(PDLY_SEARCH_lb_babysearchoptionmatch==63)||(PDLY_SEARCH_lb_babysearchoptionmatch==66)||(PDLY_SEARCH_lb_babysearchoptionmatch==64))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE FROM//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==55)||(PDLY_SEARCH_lb_babysearchoptionmatch==61)||(PDLY_SEARCH_lb_babysearchoptionmatch==72))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom="";
            var PDLY_SEARCH_invfromcomt=$('#PDLY_SEARCH_tb_searchbyinvfrom').val();
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
//SEARCH BY BABY EXPENSE INVOICE ITEM//
        if((PDLY_SEARCH_lb_babysearchoptionmatch==54)||(PDLY_SEARCH_lb_babysearchoptionmatch==60)||(PDLY_SEARCH_lb_babysearchoptionmatch==71))
        {
            var PDLY_SEARCH_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
            var PDLY_SEARCH_startdate=$('#PDLY_SEARCH_db_startdate').val();
            var PDLY_SEARCH_enddate=$('#PDLY_SEARCH_db_enddate').val();
            var PDLY_SEARCH_searchcomments="";
            var PDLY_SEARCH_fromamount="";
            var PDLY_SEARCH_toamount="";
            var PDLY_SEARCH_babysearchoption=$('#PDLY_SEARCH_lb_babysearchoption').val();
            var PDLY_SEARCH_invitemcom=$('#PDLY_SEARCH_tb_searchbyinvitem').val();
            var PDLY_SEARCH_invfromcomt="";
            var PDLY_SEARCH_babycategory="";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + "index.php/Expense_personal_daily_entry_search_update_delete_controller/PDLY_SEARCH_searchbybaby",
                data:'&PDLY_SEARCH_typelistvalue='+PDLY_SEARCH_typelistvalue+'&PDLY_SEARCH_startdate='+PDLY_SEARCH_startdate+'&PDLY_SEARCH_enddate='+PDLY_SEARCH_enddate+'&PDLY_SEARCH_babysearchoption='+PDLY_SEARCH_babysearchoption+'&PDLY_SEARCH_fromamount='+PDLY_SEARCH_fromamount+'&PDLY_SEARCH_toamount='+PDLY_SEARCH_toamount+'&PDLY_SEARCH_searchcomments='+PDLY_SEARCH_searchcomments+'&PDLY_SEARCH_invitemcom='+PDLY_SEARCH_invitemcom+'&PDLY_SEARCH_invfromcomt='+PDLY_SEARCH_invfromcomt+'&PDLY_SEARCH_babycategory='+PDLY_SEARCH_babycategory,
                success: function(res) {
                    PDLY_SEARCH_babysearchdetailsvalues=JSON.parse(res);
                    PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)

                }
            });
        }
    }
    //FUNCTION TO CONVERT DATE FORMAT//
    function FormTableDateFormat(inputdate){
        var string = inputdate.split("-");
        return string[2]+'-'+ string[1]+'-'+string[0];
    }
    //LOAD THE FLEX TABLE  FOR THE  BABY SEARCH//
    function PDLY_SEARCH_babysearchdetails(PDLY_SEARCH_babysearchdetailsvalues)
    {
        var PDLY_SEARCH_babytable_header='';
        $('#PDLY_SEARCH_tbl_htmltable').html('');
        $(".preloader").hide();
        $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
        $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
        var PDLY_SEARCH_lb_typelistvalue=$('#PDLY_SEARCH_lb_typelist').val();
        var PDLY_SEARCH_searchoption=$("#PDLY_SEARCH_lb_babysearchoption").val();
        var PDLY_SEARCH_lb_babysearchoptionvalue=$('#PDLY_SEARCH_lb_babysearchoption').val();
        if(PDLY_SEARCH_babysearchdetailsvalues.length==0)
        {$('#PDLY_SEARCH_tbl_htmltable').hide();
            $('#PDLY_SEARCH_lbl_flextableheader').hide();
            $('#PDLY_SEARCH_btn_searchbutton').hide();
            $('#PDLY_SEARCH_btn_deletebutton').hide();
            $('#PDLY_SEARCH_div_htmltable').hide();
            if((PDLY_SEARCH_lb_typelistvalue==36)||(PDLY_SEARCH_lb_typelistvalue==35)||(PDLY_SEARCH_lb_typelistvalue==37))
            {
                if((PDLY_SEARCH_searchoption==52)||(PDLY_SEARCH_searchoption==58)||(PDLY_SEARCH_searchoption==69))
                {
                    var PDLY_SEARCH_category=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[5].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[TEXP]', PDLY_SEARCH_category);
                }
                if((PDLY_SEARCH_searchoption==51)||(PDLY_SEARCH_searchoption==57)||(PDLY_SEARCH_searchoption==68)||(PDLY_SEARCH_searchoption==65))
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[7].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if((PDLY_SEARCH_searchoption==53)||(PDLY_SEARCH_searchoption==59)||(PDLY_SEARCH_searchoption==70)||(PDLY_SEARCH_searchoption==63)||(PDLY_SEARCH_searchoption==66)||(PDLY_SEARCH_searchoption==64))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[6].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==55)||(PDLY_SEARCH_searchoption==61)||(PDLY_SEARCH_searchoption==72))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==54)||(PDLY_SEARCH_searchoption==60)||(PDLY_SEARCH_searchoption==71))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==56)||(PDLY_SEARCH_searchoption==62)||(PDLY_SEARCH_searchoption==73)||(PDLY_SEARCH_searchoption==67))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[0].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[START DATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[END DATE ]', PDLY_SEARCH_edate);
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==38)
            {
                if(PDLY_SEARCH_searchoption==65)
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[7].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if(PDLY_SEARCH_searchoption==67)
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[10].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                if(PDLY_SEARCH_searchoption==63)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==66)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==64)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[28].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
            }
            $('#PDLY_SEARCH_lbl_nodataerrormsg').text(PDLY_SEARCH_CONFSAVEMSG);
            $('#PDLY_SEARCH_lbl_nodataerrormsg').show();
        }
        else
        {
            $('#PDLY_SEARCH_lbl_nodataerrormsg').hide();
//            var PDLY_SEARCH_result_array=PDLY_SEARCH_babysearchdetailsvalues;
//            if(PDLY_SEARCH_result_array.length > 10){ var px = '400px'}
//            else
//            {
//                var x = PDLY_SEARCH_result_array.length*60;
//                if(x <=100){var px ='240px'}
//                else{
//                    var px = x+"px" }
//            }
//            if(PDLY_SEARCH_result_array.length > 20){ var px = '500px'}
//            if(PDLY_SEARCH_result_array.length <= 3){ var px = '200px'}
//            if(PDLY_SEARCH_result_array.length == 1) {var px ="120px"}
//            $('#PDLY_SEARCH_div_htmltable').css('height',px)
            $('#PDLY_SEARCH_btn_babybutton').attr("disabled", "disabled");
            var PDLY_SEARCH_babyvalue=PDLY_SEARCH_babysearchdetailsvalues;
            var PDLY_SEARCH_babytable_value='';
            if((PDLY_SEARCH_lb_typelistvalue==36)||(PDLY_SEARCH_lb_typelistvalue==35)||(PDLY_SEARCH_lb_typelistvalue==37))
            {
                if((PDLY_SEARCH_searchoption==52)||(PDLY_SEARCH_searchoption==58)||(PDLY_SEARCH_searchoption==69))
                {
                    var PDLY_SEARCH_category=$('#PDLY_SEARCH_lb_babyexpansecategory').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[11].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[TEXP]', PDLY_SEARCH_category);
                }
                if((PDLY_SEARCH_searchoption==51)||(PDLY_SEARCH_searchoption==57)||(PDLY_SEARCH_searchoption==68)||(PDLY_SEARCH_searchoption==65))
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[13].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if((PDLY_SEARCH_searchoption==53)||(PDLY_SEARCH_searchoption==59)||(PDLY_SEARCH_searchoption==70)||(PDLY_SEARCH_searchoption==63)||(PDLY_SEARCH_searchoption==66)||(PDLY_SEARCH_searchoption==64))
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[12].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if((PDLY_SEARCH_searchoption==55)||(PDLY_SEARCH_searchoption==61)||(PDLY_SEARCH_searchoption==72))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchbyinvfrom').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[15].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[INVFROM]', PDLY_SEARCH_fromcomt);
                }
                if((PDLY_SEARCH_searchoption==54)||(PDLY_SEARCH_searchoption==60)||(PDLY_SEARCH_searchoption==71))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchbyinvitem').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[14].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[INVITEM]', PDLY_SEARCH_fromcomt);
                }
                if((PDLY_SEARCH_searchoption==56)||(PDLY_SEARCH_searchoption==62)||(PDLY_SEARCH_searchoption==73)||(PDLY_SEARCH_searchoption==67))
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[16].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                $('#PDLY_SEARCH_lbl_flextableheader').text(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_lbl_flextableheader').show();
                if(PDLY_SEARCH_lb_typelistvalue==36)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>TYPE OF BABY EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px" >INVOICE ITEMS</th><th style="width:230px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EB_INVOICE_DATE);
                        PDLY_SEARCH_babytable_header+='<tr id ='+PDLY_SEARCH_values.EB_ID+' ><td>'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap>'+PDLY_SEARCH_date+'</td><td>'+PDLY_SEARCH_values.EB_AMOUNT+'</td><td>'+PDLY_SEARCH_values.EB_INVOICE_FROM+'</td><td>'+PDLY_SEARCH_values.EB_INVOICE_ITEMS+'</td><td>'+PDLY_SEARCH_values.EB_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==35)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>TYPE OF CAR EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px">INVOICE ITEMS</th><th style="width:230px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EC_INVOICE_DATE);
                        PDLY_SEARCH_babytable_header+='<tr id ='+PDLY_SEARCH_values.EC_ID+' ><td>'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap>'+PDLY_SEARCH_date+'</td><td>'+PDLY_SEARCH_values.EC_AMOUNT+'</td><td>'+PDLY_SEARCH_values.EC_INVOICE_FROM+'</td><td>'+PDLY_SEARCH_values.EC_INVOICE_ITEMS+'</td><td>'+PDLY_SEARCH_values.EC_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
                if(PDLY_SEARCH_lb_typelistvalue==37)
                {
                    var PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th>TYPE OF PERSONAL EXPENSE</th><th style="width:75px" class="uk-date-column"">INVOICE DATE</th><th style="width:60px">INVOICE AMOUNT</th><th style="width:200px">INVOICE FROM</th><th style="width:200px">INVOICE ITEMS</th><th style="width:230px">COMMENTS</th><th>USERSTAMP</th><th class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';
                    for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                    {
                        var rowid=(i+1);
                        var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                        var PDLY_SEARCH_date=FormTableDateFormat(PDLY_SEARCH_values.EP_INVOICE_DATE);
                        PDLY_SEARCH_babytable_header+='<tr id ='+PDLY_SEARCH_values.EP_ID+' ><td>'+PDLY_SEARCH_values.ECN_DATA+'</td><td nowrap>'+PDLY_SEARCH_date+'</td><td>'+PDLY_SEARCH_values.EP_AMOUNT+'</td><td>'+PDLY_SEARCH_values.EP_INVOICE_FROM+'</td><td>'+PDLY_SEARCH_values.EP_INVOICE_ITEMS+'</td><td>'+PDLY_SEARCH_values.EP_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                    }
                    PDLY_SEARCH_babytable_header+='</tbody></table>';
                }
            }
            if(PDLY_SEARCH_lb_typelistvalue==38)
            {
                if(PDLY_SEARCH_searchoption==65)
                {
                    var PDLY_SEARCH_famt=$('#PDLY_SEARCH_tb_fromamount').val();
                    var PDLY_SEARCH_tamt=$('#PDLY_SEARCH_tb_toamount').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[18].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[FAMT]', PDLY_SEARCH_famt);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[TAMT]', PDLY_SEARCH_tamt);
                }
                if(PDLY_SEARCH_searchoption==67)
                {
                    var PDLY_SEARCH_fromcomt=$('#PDLY_SEARCH_tb_searchabycmt').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[16].EMC_DATA;
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_conformsg.replace('[COMTS]', PDLY_SEARCH_fromcomt);
                }
                if(PDLY_SEARCH_searchoption==63)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[20].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==66)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[27].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                if(PDLY_SEARCH_searchoption==64)
                {
                    var PDLY_SEARCH_edate=$('#PDLY_SEARCH_db_enddate').val();
                    var PDLY_SEARCH_sdate=$('#PDLY_SEARCH_db_startdate').val();
                    var PDLY_SEARCH_conformsg=PDLY_SEARCH_hdrmsgArray[22].EMC_DATA;
                    var PDLY_SEARCH_errormsgs = PDLY_SEARCH_conformsg.replace('[SDATE]', PDLY_SEARCH_sdate);
                    var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_errormsgs.replace('[EDATE]', PDLY_SEARCH_edate);
                }
                $('#PDLY_SEARCH_lbl_flextableheader').text(PDLY_SEARCH_CONFSAVEMSG);
                $('#PDLY_SEARCH_lbl_flextableheader').show();
                PDLY_SEARCH_babytable_header='<table id="PDLY_SEARCH_tbl_htmltable" border="1"  cellspacing="0" data-class="table" class="srcresult"><thead bgcolor="#6495ed" style="color:white"><tr><th width="75px" class="uk-date-column"">PAID DATE</th><th width="60px">INVOICE AMOUNT</th><th width="75px" class="uk-date-column"">FROM PERIOD</th><th width="75px" class="uk-date-column"">TO PERIOD</th><th width="230px">COMMENTS</th><th width="250px">USERSTAMP</th><th width="150px" class="uk-timestp-column">TIMESTAMP</th></tr></thead><tbody>';

                for(var i=0;i<PDLY_SEARCH_babyvalue.length;i++)
                {
                    var rowid=(i+1);
                    var PDLY_SEARCH_values=PDLY_SEARCH_babyvalue[i];
                    var PDLY_SEARCH_paiddate=FormTableDateFormat(PDLY_SEARCH_values.ECL_PAID_DATE);
                    var PDLY_SEARCH_fromdate=FormTableDateFormat(PDLY_SEARCH_values.ECL_FROM_PERIOD);
                    var PDLY_SEARCH_todate=FormTableDateFormat(PDLY_SEARCH_values.ECL_TO_PERIOD);
                    PDLY_SEARCH_babytable_header+='<tr id='+PDLY_SEARCH_values.ECL_ID+' ><td nowrap>'+PDLY_SEARCH_paiddate+'</td><td>'+PDLY_SEARCH_values.ECL_AMOUNT+'</td><td nowrap>'+PDLY_SEARCH_fromdate+'</td><td nowrap>'+PDLY_SEARCH_todate+'</td><td>'+PDLY_SEARCH_values.ECL_COMMENTS+'</td><td>'+PDLY_SEARCH_values.ULD_LOGINID+'</td><td nowrap>'+PDLY_SEARCH_values.TIMESTMP+'</td></tr>';
                }
                PDLY_SEARCH_babytable_header+='</tbody></table>';
                $('section').html(PDLY_SEARCH_babytable_header);
                $('#PDLY_SEARCH_div_htmltable').show();
            }
            $('section').html(PDLY_SEARCH_babytable_header);
            $('#PDLY_SEARCH_tbl_htmltable').show();
            $('#PDLY_SEARCH_div_htmltable').show();
            $('#PDLY_SEARCH_lbl_flextableheader').show();
            $('#PDLY_SEARCH_btn_searchbutton').hide();
            $('#PDLY_SEARCH_btn_deletebutton').hide();
            $('#PDLY_SEARCH_btn_searchbutton').attr("disabled", "disabled");
            $('#PDLY_SEARCH_btn_deletebutton').attr("disabled", "disabled");
        }
        var PDLY_SEARCH_expensetype=$('#PDLY_SEARCH_lb_typelist').find('option:selected').text();
        if(PDLY_SEARCH_flag_deleteupd==1){
            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[3].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
            show_msgbox("PERSONAL EXPENSE: SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
            PDLY_SEARCH_flag_deleteupd=0;
        }
        if(PDLY_SEARCH_flag_deleteupd==2){
            var PDLY_SEARCH_CONFSAVEMSG = PDLY_SEARCH_hdrmsgArray[4].EMC_DATA.replace('[TYPE]', PDLY_SEARCH_expensetype);
            show_msgbox("PERSONAL EXPENSE: SEARCH/UPDATE/DELETE",PDLY_SEARCH_CONFSAVEMSG,"success",false)
            PDLY_SEARCH_flag_deleteupd=0;
        }
        $('#PDLY_SEARCH_tbl_htmltable').DataTable( {
            "aaSorting": [],
            "pageLength": 10,
            "sPaginationType":"full_numbers",
            "aoColumnDefs" : [
                { "aTargets" : ["uk-date-column"] , "sType" : "uk_date"}, { "aTargets" : ["uk-timestp-column"] , "sType" : "uk_timestp"} ]

        });
        sorting()
    }
    //FUNCTION FOR SORTING
    function sorting(){
        jQuery.fn.dataTableExt.oSort['uk_date-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_date-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a)));
            var y = new Date( Date.parse(FormTableDateFormat(b)) );
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_timestp-asc']  = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };
        jQuery.fn.dataTableExt.oSort['uk_timestp-desc'] = function(a,b) {
            var x = new Date( Date.parse(FormTableDateFormat(a.split(' ')[0]))).setHours(a.split(' ')[1].split(':')[0],a.split(' ')[1].split(':')[1],a.split(' ')[1].split(':')[2]);
            var y = new Date( Date.parse(FormTableDateFormat(b.split(' ')[0]))).setHours(b.split(' ')[1].split(':')[0],b.split(' ')[1].split(':')[1],b.split(' ')[1].split(':')[2]);
            return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
        };
    }
    });
</script>
</head>
<body>
<div class="container">
    <div class="preloader"><span class="Centerer"></span><img class="preloaderimg"/> </div>
    <div class="title text-center"><h4><b>PERSONAL EXPENSE SEARCH/UPDATE/DELETE</b></h4></div>
    <form id="personalexpense" class="form-horizontal content">
        <div class="panel-body">
        <div class="form-group">
            <label id="PDLY_SEARCH_lbl_type" class="col-sm-2" >TYPE OF EXPENSE<em>*</em></label>
            <div class="col-sm-2">
                <select id='PDLY_SEARCH_lb_typelist' name="PDLY_SEARCH_lb_typelist"  class="form-control" >
                    <option value='SELECT' selected="selected"> SELECT</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label id='PDLY_SEARCH_lbl_babysearchoption'  class="col-sm-2" hidden>SEARCH OPTION<em>*</em></label>
            <div class="col-sm-2">
                 <select  id='PDLY_SEARCH_lb_babysearchoption' name="PDLY_SEARCH_lb_babysearchoption" class="form-control"  hidden>
                 <option>SELECT</option>
                </select>
            </div>
        </div>
        <div>
            <label class="srctitle" id='PDLY_SEARCH_lbl_bybabycmts'  hidden>SEARCH BY BABY EXPENSE COMMENTS<em>*</em></label>
        </div>
        <div id='PDLY_SEARCH_tble_searchtable'>
            <div class="form-group">
                <label  id='PDLY_SEARCH_lbl_babyexpansecategory' class="col-sm-2" hidden>BABY EXPENSE CATEGORY<em>*</em></label>
                <div class="col-sm-2"><select class="submitval form-control" id='PDLY_SEARCH_lb_babyexpansecategory'  name="PDLY_SEARCH_lb_babyexpansecategory"  hidden>
                        <option>SELECT</option>
                    </select></div>
            </div>
        <div class="form-group">
            <label  id='PDLY_SEARCH_lbl_startdate' class="col-sm-2" hidden> START DATE <em>*</em></label>
            <div class="col-sm-2">
              <input  type="text" class="datebox submitval datemandtry"  name="PDLY_SEARCH_db_startdate" id="PDLY_SEARCH_db_startdate" style="width:70px;" hidden />
            </div>
        </div>
         <div class="form-group">
             <label id='PDLY_SEARCH_lbl_enddate' class="col-sm-2" hidden> END DATE <em>*</em></label>
               <div class="col-sm-2">
                   <input  type="text" class="datebox submitval datemandtry" name="PDLY_SEARCH_db_enddate" id="PDLY_SEARCH_db_enddate" style="width:70px;" hidden />
               </div>
         </div>
         <div class="form-group">
             <label  id='PDLY_SEARCH_lbl_searchabycmt' class="col-sm-2" class="auto"  hidden> COMMENTS <em>*</em></label>
                <div class="col-sm-2">
                    <textarea name="PDLY_SEARCH_tb_searchabycmt" class="submitval" id="PDLY_SEARCH_tb_searchabycmt"hidden ></textarea>
                </div>
         </div>
         <div><label id='PDLY_SEARCH_lbl_babyshowcomments' class="errormsg" hidden >  </label></div>
         <div class="form-group">
             <label  id='PDLY_SEARCH_lbl_searchbyinvfrom' class="col-sm-2" hidden> INVOICE FROM <em>*</em></label>
              <div class="col-sm-2">
                  <input   type="text" class="submitval "name ="PDLY_SEARCH_tb_searchbyinvfrom" id="PDLY_SEARCH_tb_searchbyinvfrom"   style="width:330px;"hidden />
              </div>
         </div>
          <div class="form-group">
          <label  id='PDLY_SEARCH_lbl_searchbyinvitem' class="col-sm-2" hidden> INVOICE ITEM <em>*</em></label>
              <div class="col-sm-2">
                  <textarea   type="text" class="submitval" name ="PDLY_SEARCH_tb_searchbyinvitem" id="PDLY_SEARCH_tb_searchbyinvitem"   style="width:330px;"hidden ></textarea>
              </div>
          </div>
          <div class="form-group">
             <label  id='PDLY_SEARCH_lbl_fromamount' class="col-sm-2" hidden> FROM AMOUNT <em>*</em></label>
              <div class="col-sm-2">
                <input   type="text" name ="PDLY_SEARCH_tb_fromamount" id="PDLY_SEARCH_tb_fromamount"  class="amtsubmitval" style="width:60px;"hidden />
              </div>
          </div>
           <div class="form-group">
               <label  id='PDLY_SEARCH_lbl_toamount' class="col-sm-2" hidden> TO AMOUNT <em>*</em></label>
               <div class="col-sm-2">
                <input   type="text" name ="PDLY_SEARCH_tb_toamount" id="PDLY_SEARCH_tb_toamount"  class="amtsubmitval" style="width:60px;"hidden />
               </div>
               <label class="errormsg" id='PDLY_SEARCH_lbl_amounterrormsg'  hidden></label>
           </div>
            <div class="col-lg-offset-2">
            <input type="button"   id="PDLY_SEARCH_btn_babybutton" disabled  value="SEARCH" class="btn" hidden />
            </div>
          </div>
            <div>
                <label  id='PDLY_SEARCH_lbl_flextableheader' class="srctitle" hidden></label>
           </div>
            <div  id ="PDLY_SEARCH_div_htmltable" class="table-responsive">
                <section>

                </section>
            </div>
            <div class="col-lg-offset-1">
                <input type="button"   id="PDLY_SEARCH_btn_searchbutton" disabled  value="SEARCH" class="btn" hidden />
                <input type="button"   id="PDLY_SEARCH_btn_deletebutton" disabled  value="DELETE" class="btn" hidden />
            </div>
            <!--CREATION OF ELEMENT FOR PERSONAL ,BABY , AND CAR EXPENSE-->
            <div  id="PDLY_SEARCH_tble_multi">
            <div class="form-group">
                <label id="PDLY_SEARCH_lbl_category" class="col-sm-2" hidden>CATEGORY OF EXPENSE<em>*</em></label>
                <div class="col-sm-2">
                    <select class="submultivalid"   name="PDLY_SEARCH_lb_category" id="PDLY_SEARCH_lb_category" hidden ><option >SELECT</option> </select>
                </div>
            </div>
            <div class="form-group">
                <label  id="PDLY_SEARCH_lbl_invdate" hidden>INVOICE DATE<em>*</em></label>
                <div class="col-sm-2"><input class="submultivalid updatedatepicker datemandtry"   type="text" name ="PDLY_SEARCH_db_invdate" id="PDLY_SEARCH_db_invdate" style="width:70px;" hidden /> </div>
            </div>
            <div class="form-group">
                <label id="PDLY_SEARCH_lbl_invamt" class="col-sm-2" hidden>INVOICE AMOUNT<em>*</em></label>
                <div class="col-sm-2"><input   type="text" name ="PDLY_SEARCH_tb_incamtrp" id="PDLY_SEARCH_tb_incamtrp"  class="amtonly submultivalid PDLY_SEARCH_class_numonly" style="width:55px;"  hidden /></div>
            </div>
            <div class="form-group">
                <label id="PDLY_SEARCH_lbl_invfrom" class="col-sm-2" hidden>INVOICE FROM<em>*</em></label>
                <div class="col-sm-2"><input class="textboxsubmultivalid autosize"  type="text" name ="PDLY_SEARCH_tb_invfrom" id="PDLY_SEARCH_tb_invfrom"hidden /></div>
            </div>
            <div class="form-group">
                <label id="PDLY_SEARCH_lbl_invitm" class="col-sm-2" hidden>INVOICE ITEMS<em>*</em></label>
                <div class="col-sm-2"><textarea class="submultivalid"  type="text" name="PDLY_SEARCH_ta_invitem" id="PDLY_SEARCH_ta_invitem"  hidden ></textarea></div>
            </div>
            <div class="form-group">
                <label id="PDLY_SEARCH_lbl_invcmt" class="col-sm-2" hidden>COMMENTS</label>
                <div class="col-sm-2"><textarea  class="submultivalid" type="text" name ="PDLY_SEARCH_tb_comments" id="PDLY_SEARCH_tb_comments" hidden ></textarea></div>
            </div>
            </div>
            <!--CAR LOAN EXPENSE-->
            <div id="PDLY_SEARCH_tble_carloan">
                <div class="form-group">
                    <label  id="PDLY_SEARCH_lbl_carpaiddate" class="col-sm-2" hidden>PAID DATE<em>*</em></label>
                    <div class="col-sm-2"><input class="carsubmultivalid datemandtry"   type="text" name ="PDLY_SEARCH_db_carpaiddate" id="PDLY_SEARCH_db_carpaiddate" style="width:70px;" hidden /> </div>
                </div>
                <div class="form-group">
                    <label  id="PDLY_SEARCH_lbl_carfromdate" class="col-sm-2" hidden>FROM PERIOD<em>*</em></label>
                    <div class="col-sm-2"><input class="carsubmultivalid datemandtry"   type="text" name ="PDLY_SEARCH_db_carfromdate" id="PDLY_SEARCH_db_carfromdate" style="width:70px;" hidden /> </div>
                </div>
                <div class="form-group">
                    <label  id="PDLY_SEARCH_lbl_cartodate" class="col-sm-2" hidden>TO PERIOD <em>*</em></label></td>
                    <div class="col-sm-2"><input class="carsubmultivalid datemandtry"   type="text" name ="PDLY_SEARCH_db_cartodate" id="PDLY_SEARCH_db_cartodate" style="width:70px;" hidden /> </div>
                </div>
                <div class="form-group">
                    <label id="PDLY_SEARCH_lbl_carloanamt" class="col-sm-2" hidden>INVOICE AMOUNT<em>*</em></label>
                    <div class="col-sm-2"><input   type="text" name ="PDLY_SEARCH_tb_carloanamt" id="PDLY_SEARCH_tb_carloanamt"  class="amtonly carsubmultivalid PDLY_SEARCH_class_numonly" style="width:55px;"  hidden /></div>
                </div>
                <div class="form-group">
                    <label id="PDLY_SEARCH_lbl_carloancmt" class="col-sm-2" hidden>COMMENTS</label>
                    <div class="col-sm-2"><textarea class="carsubmultivalid"  type="text" name ="PDLY_SEARCH_ta_carloancmt" id="PDLY_SEARCH_ta_carloancmt" hidden ></textarea></div>
                </div>
            </div>
            <div class="col-lg-offset-5">
                    <input type="button"   id="PDLY_SEARCH_btn_sbutton" disabled  value="UPDATE" class="btn submit" hidden />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button"  id="PDLY_SEARCH_btn_rbutton" value="RESET" class="btn  resetsubmit" hidden />
            </div>
            <div><input   type="text" name ="PDLY_SEARCH_tb_hideid" id="PDLY_SEARCH_tb_hideid"  hidden /></div>
            <div id="PDLY_SEARCH_tble_nodataerrormsg">
                <div ><label class="errormsg" id="PDLY_SEARCH_lbl_nodataerrormsg" hidden></label></div>
            </div>
    </form>
</div>
</body>
</html>​

