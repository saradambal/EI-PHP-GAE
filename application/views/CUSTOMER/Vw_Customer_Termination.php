<?php
include "Header.php";
?>
<script>
    $(document).ready(function(){
        $('#spacewidth').height('0%');
        $('textarea').autogrow({onInitialize: true});
        //FUNCTION TO UNIQUE ARRAY VALUES
        function unique(a) {
            var result = [];
            $.each(a, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
            return result;
        }
//FUNCTION TO CALL DATE PICKER FORMAT
        function FormTableDateFormat(inputdate){
            var string = inputdate.split("-");
            return string[2]+'-'+ string[1]+'-'+string[0];
        }
        var CTERM_ptdfrmtime=[];
        var CTERM_minptdcustdate="";
        var CTERM_custptdchkflag=false;
        var CTERM_errmsgs=[];
        var CTERM_result_array=[];
//CALL GS FUNCTION TO CALENDAR EVENT TIME N ERROR MESSAGES
        $.ajax({
            type: "POST",
            'url': "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getErrMsgCalTime",
            success: function(res) {
                $('.preloader').hide();
                var result=JSON.parse(res);
                CTERM_getErrMsgCalTime_result(result)
             }
        });
//FUNCTION TO SET CALENDAR EVENT TIME RESULT
        function CTERM_getErrMsgCalTime_result(cterm_errtime)
        {
            CTERM_errmsgs=cterm_errtime.errormsg;
            CTERM_ptdfrmtime=cterm_errtime.calfrmtime;
            if(cterm_errtime.namelen==0)
            {
                $('#CTERM_form').replaceWith('<p><label class="errormsg"> '+CTERM_errmsgs[0]+' & '+CTERM_errmsgs[4].EMC_DATA+'</label></p>')
            }
            else
            {
                $('#CTERM_form').show();
            }
        }
        //OPTION RADIO BUTTON CHANGE
        $("input[name='CTERM_radio_termoption']").on("change", function () {
            $(".preloader").show();
            $('#CTERM_lbl_custname').hide();
            $('#CTERM_lb_custname').hide();
            $('#CTERM_div_custid').hide();
            $('#CTERM_div_errmsg').hide();
            $('#CTERM_div_srctable').hide();
            $('#CTERM_div_srcbtn').hide();
            $('#CTERM_div_termform').hide();
            if(this.value=="CTERM_radio_activecust")
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    }
                });
            }
            if(this.value=="CTERM_radio_untermnonactive")
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    }
                });
            }
            if(this.value=="CTERM_radio_reactivecust")
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getCustomerName",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerName_result(result)
                    }
                });
            }
        });
        //FUNCTION TO SET CUSTOMER NAME
        function CTERM_getCustomerName_result(CTERM_cname)
        {
            var cterm_err="";
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val();
            $('#CTERM_div_custid').hide();
            if(CTERM_cname.length==0)
            {
                $('#CTERM_lbl_custname').hide();
                $('#CTERM_lb_custname').val("SELECT").hide();
                if(CTERM_radio_termoption=="CTERM_radio_reactivecust")
                {
                    cterm_err=CTERM_errmsgs[4]
                }
                else
                {
                    cterm_err=CTERM_errmsgs[0]
                }
                $('#CTERM_div_errmsg').text(cterm_err).removeClass("srctitle").addClass("errormsg").show();
            }
            else
            {
                $('#CTERM_div_errmsg').text("")
                var CTERM_nameres='<option>SELECT</option>';
                for(var i=0;i<CTERM_cname.length;i++)
                {
                    var CTERM_custname=CTERM_cname[i].split("_");
                    CTERM_nameres += '<option value="' + CTERM_cname[i] + '">' + CTERM_custname[0]+" "+CTERM_custname[1] + '</option>';
                }
                $('#CTERM_lbl_custname').show();
                $('#CTERM_lb_custname').html(CTERM_nameres).show();
            }
        }
        //GET CUSTOMER ID FOR THE SELECTED CUSTOMER NAME
        $('#CTERM_lb_custname').change(function()
        {
            $('#CTERM_div_custid').hide();
            $('#CTERM_div_errmsg').hide();
            $('#CTERM_div_srctable').hide();
            $('#CTERM_div_srcbtn').hide();
            $('#CTERM_div_termform').hide();
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            if(CTERM_lb_custname!='SELECT')
            {
                $(".preloader").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getCustomerId",
                    data:$('#CTERM_form').serialize(),
                    success: function(res) {
                        alert(res)
                        var result=JSON.parse(res);
                        CTERM_getCustomerId_result(result)
                    }
                });
            }
            else
            {
                $('#CTERM_div_custid').hide();
                $('#CTERM_div_srctable').hide();
            }
        });
        //ADD CUSTOMER ID IN THE  RADIO BUTTON
        function CTERM_getCustomerId_result(CTERM_Cid)
        {
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            var CTERM_radio_termoption=$("input[name=CTERM_radio_termoption]:checked").val();
            var CTERM_custname=CTERM_lb_custname.split("_");
            if(CTERM_Cid.length==1)
            {
                $('#CTERM_hidden_custid').val(CTERM_Cid[0]);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + "index.php/Ctrl_Customer_Termination/CTERM_getCustomerdtls",
                    data:{'custid':CTERM_Cid[0],'radiooption':CTERM_radio_termoption},
                    success: function(res) {
                        alert(res)
                        $('.preloader').hide();
                        var result=JSON.parse(res);
                        CTERM_getCustomerdtls_result(result)
                    }
                });
                $('#CTERM_div_custid').hide();
            }
            else
            {
                $(".preloader").hide();
               //get table rows lengh
                var tablelen=$('#CTERM_tble_custid tr').length;
                $('#CTERM_tble_custid tr').remove();
                for(var i=0;i<CTERM_Cid.length;i++)
                {
                    var CTERM_result='<tr id="custid"><td> <input type=radio name="CTERM_radiocustid" id='+CTERM_Cid[i]+' value='+CTERM_Cid[i]+' class="CTERM_class_custid"></td><td>'+CTERM_custname[0]+" "+CTERM_custname[1]+' '+CTERM_Cid[i]+'</tr>';
                    $('#CTERM_tble_custid').append(CTERM_result);
                }
                $('#CTERM_div_custid').show();
            }
        }
        //FUNCTION TO SET DETAILS IN TABLE FOR THE SELECTED CUSTOMER NAME
        function CTERM_getCustomerdtls_result(result)
        {
            $('#CTERM_tbl_srctable').html("")
            var CTERM_lb_custname=$('#CTERM_lb_custname').val();
            var CTERM_custname=CTERM_lb_custname.split("_");
            var CTERM_radio_termoption =$("input[name='CTERM_radio_termoption']:checked").val()
            CTERM_result_array=result.finaldts;
            alert(CTERM_result_array)
            if(CTERM_result_array.length==0)
            {
                $('#CTERM_div_errmsg').text(CTERM_errmsgs[3].EMC_DATA.replace('[CNAME]',(CTERM_custname[0]+" "+CTERM_custname[1]))).removeClass("srctitle").addClass("errormsg").show();
            }
            else
            {
                $('#CTERM_div_errmsg').text(CTERM_errmsgs[2].EMC_DATA.replace('[FIRST NAME + LAST NAME]',CTERM_custname[0]+" "+CTERM_custname[1])).removeClass("errormsg").addClass("srctitle").show();
//START SET WIDTH FOR SEARCH TABLE DIV
                if(CTERM_result_array.length > 10){ var px = '400px'}
                else
                {
                    var x = CTERM_result_array.length*70;
                    if(x <=100){var px = '200px'}
                    else{
                        var px = x+"px" }
                }
                if(CTERM_result_array.length == 1) {var px ="150px"}
                $('#CTERM_div_srctable').css('height',px)
//END SET WIDTH FOR SEARCH TABLE DIV
                var CTERM_table_value='';
                var CTERM_table_header='<thead><tr><th style="width:40px">UNIT NUMBER</th><th >FIRST NAME</th><th >LAST NAME</th><th style="width:95px">START DATE</th><th style="width:75px">END DATE</th><th style="width:75px">PRETERMINATE DATE</th><th style="width:30px">LEASE PERIOD</th><th style="width:180px">ROOM TYPE</th><th style="width:55px">CARD NUMBER</th ><th style="width:10px">GUEST CARD</th><th style="width:10px">PRETERMINATE</th><th style="width:10px">EXTENSION</th><th style="width:10px">RECHECKIN</th><th style="width:10px">TERMINATE</th><th style="width:100px">LEASE PERIOD DURATION</th><th style="width:30px">QUARTERS</th><th style="width:55px">RENT</th><th style="width:500px">COMMENTS</th><th style="width:170px">USERSTAMP</th><th style="width:140px">TIMESTAMP</th></tr></thead>'
                $('#CTERM_tbl_srctable').html(CTERM_table_header);
                for(var i=0;i<CTERM_result_array.length;i++)
                {
                    var CTERM_values=CTERM_result_array[i]
                    var CTERM_startdate=CTERM_values.startdate;
                    CTERM_startdate=FormTableDateFormat(CTERM_startdate);
                    var CTERM_enddate=CTERM_values.enddate;
                    CTERM_enddate=FormTableDateFormat(CTERM_enddate);
                    var CTERM_preterminatedate=CTERM_values.preterminatedate;
                    if(CTERM_preterminatedate!=""){
                        CTERM_preterminatedate=FormTableDateFormat(CTERM_preterminatedate)
                    }
                    CTERM_table_value='<tbody><tr ><td>'+CTERM_values.unitno+'</td><td>'+CTERM_values.firstname+'</td><td>'+CTERM_values.lastname+'</td><td>'+CTERM_startdate+'</td><td>'+CTERM_enddate+'</td><td>'+CTERM_preterminatedate+'</td><td>'+CTERM_values.redver+'</td><td>'+CTERM_values.roomtype+'</td><td>'+CTERM_values.cardno+'</td><td>'+CTERM_values.guestcard+'</td><td>'+CTERM_values.preterm+'</td><td>'+CTERM_values.extension+'</td><td>'+CTERM_values.rechk+'</td><td>'+CTERM_values.term+'</td><td>'+CTERM_values.lp+'</td><td>'+CTERM_values.quartors+'</td><td>'+CTERM_values.rental+'</td><td>'+CTERM_values.comments+'</td><td>'+CTERM_values.userstamp+'</td><td>'+CTERM_values.timestamp+'</td></tr>'
                    $('#CTERM_tbl_srctable').append(CTERM_table_value)
                }
                $('#CTERM_div_srctable').show();
                if(CTERM_radio_termoption=="CTERM_radio_activecust")
                {
                    $('#CTERM_btn_srcbtn').val("SEARCH").removeClass("maxbtn").addClass("btn");
                }
                else if(CTERM_radio_termoption=="CTERM_radio_untermnonactive")
                {
                    $('#CTERM_btn_srcbtn').val("TERMINATE").removeClass("btn").addClass("maxbtn");
                }
                else
                {
                    $('#CTERM_btn_srcbtn').val("RE-ACTIVE").removeClass("btn").addClass("maxbtn");
                }
                $('#CTERM_div_srcbtn').show();
            }
            $(".preloader").hide();
        }
    });
</script>
<body>
<div class="container">
    <div class="preloader" hidden><span class="Centerer"></span><img class="preloaderimg"/></div>
    <div class="title text-center"><h4><b>CUSTOMER TERMINATION</b></h4></div>
            <form class="content" name="CTERM_form" id="CTERM_form" hidden>
                <div class="panel-body">
                    <div class="form-group">
                    <div class="radio">
                        <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_activecust" value="CTERM_radio_activecust">ACTIVE CUSTOMER</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_untermnonactive" value="CTERM_radio_untermnonactive">UNTERMINATED NON ACTIVE CUSTOMER</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="CTERM_radio_termoption" id="CTERM_radio_reactivecust" value="CTERM_radio_reactivecust">RE-ACTIVE CUSTOMER</label>
                   </div>
                   </div>
                    <div class="form-group">
                        <label id="CTERM_lbl_custname" class="col-sm-2" hidden>CUSTOMER NAME<em>*</em></label>
                        <div class="col-sm-5">
                            <select name="CTERM_lb_custname" id="CTERM_lb_custname" class="form-control" style="display:none;" hidden></select>
                        </div>
                    </div>
                    <div id="CTERM_div_custid" class="form-group">
                                <table id="CTERM_tble_custid">
                                </table>
                    </div>
                <div id="CTERM_div_errmsg"  class="form-group"></div>
                <div id="CTERM_div_srctable" class="table-responsive" hidden>
                    <table id="CTERM_tbl_srctable" border="1"  cellspacing="0" class="srcresult"  style="width:2500px"></table>
                </div>
                <div id="CTERM_div_srcbtn"  hidden>
                    <input type="button" id="CTERM_btn_srcbtn" value="SEARCH" class="btn">
                </div>
                <div  class="form-group" id="CTERM_div_termform" hidden>
                    <table id="CTERM_tble_termfrm" class="table-responsive" cellspacing="5">
                    </table>
                        <div class="form-group">
                          <label class="col-sm-2">COMMENTS</label>
                          <div class="col-sm-3"><textarea name="CTERM_ta_comments" id="CTERM_ta_comments" class="form-control" maxlength="50"></textarea>
                           </div>
                        </div>
                        <div class="col-lg-offset-1">
                            <input type="button" id="CTERM_btn_termbtn" value="TERMINATE" class="maxbtn" disabled>
                        </div>
                </div>
                <input type=hidden name="CTERM_hidden_custid" id="CTERM_hidden_custid" />
                <input type=hidden name="CTERM_hidden_custptd" id="CTERM_hidden_custptd" />
                <input type=hidden name="CTERM_hidden_finalcards" id="CTERM_hidden_finalcards" />
                </div>
            </form>

</div>
</body>