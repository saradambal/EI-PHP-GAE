<?php
require_once "Header.php";
?>
<style>
    .errormsg{
        padding-top:12px;
    }
</style>
<script>
    $(document).ready(function(){
        var Allunits;
        var SRC_ErrorMsg;
        var modelnames;
        $.ajax({
            type: "POST",
            url: "/index.php/Ctrl_Banktt_Search_Forms/Banktt_initialdatas",
            data:{'ErrorList':'1,2,4,6,45,247,385,401'},
            success: function(data){
                $('.preloader').show();
                var value=JSON.parse(data);
                var searchoption=value[0];
                Allunits=value[2];
                SRC_ErrorMsg=value[1];
                modelnames=value[3];
                var searchoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < searchoption.length; i++)
                {
                    var data=searchoption[i];
                    searchoptions += '<option value="' + data.BCN_ID + '">' + data.BCN_DATA + '</option>';
                }
                $('#Banktt_SRC_SearchOption').html(searchoptions);
                $('.preloader').hide();
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        var AllaccnameArray=[];
        $(document).on('change','#Banktt_SRC_SearchOption',function() {
            $('#Banktt_Search_DataTable').hide();
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            if(searchoption==1)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">UNIT NUMBER SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NUMBER<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control" name="Banktt_SRC_Uintsearch"  id="Banktt_SRC_Uintsearch" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Banktt_SRC_Uintsearch').html(unitoptions);
                $('.preloader').hide();
            }
            if(searchoption==2)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">CUSTOMER NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>UNIT NO<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Banktt_SRC_unit"  id="Banktt_SRC_unit" style="max-width: 120px"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control customer_btn_validation" name="Banktt_SRC_Customer"  id="Banktt_SRC_Customer" disabled><option>SELECT</option></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var unitoptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < Allunits.length; i++)
                {
                    var data=Allunits[i];
                    unitoptions += '<option value="' + data.UNIT_NO + '">' + data.UNIT_NO + '</option>';
                }
                $('#Banktt_SRC_unit').html(unitoptions);
                $('.preloader').hide();
            }
            if(searchoption==3)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">DATE RANGE SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>FROM DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_fromdate"  id="Banktt_SRC_fromdate" style="max-width: 120px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>TO DATE<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input class="form-control Date_btn_validation datemandtry" name="Banktt_SRC_todate"  id="Banktt_SRC_todate" style="max-width: 120px"></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                $("#Banktt_SRC_fromdate").datepicker({
                    dateFormat: "dd-mm-yy",
                    changeYear: true,
                    changeMonth: true});
                var CCRE_d = new Date();
                var changedmonth=new Date(CCRE_d.setFullYear(2009));
                $('#Banktt_SRC_fromdate').datepicker("option","minDate",changedmonth);
                $('#Banktt_SRC_fromdate').datepicker("option","maxDate",changeyear);
                $('.preloader').hide();
            }
            if(searchoption==5)
            {
                var appenddata='<BR><h4 style="color:#498af3;">AMOUNT RANGE SEARCH</h4><BR>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>FROM AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><input type=text class="form-control amountonly Amount_btn_validation" name="Banktt_SRC_FromAmount"  id="Banktt_SRC_FromAmount" style="max-width:120px;" /></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-md-2"><label>TO AMOUNT<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-2"><input type=text class="form-control amountonly Amount_btn_validation" name="Banktt_SRC_ToAmount"  id="Banktt_SRC_ToAmount" style="max-width:120px;" /></div>';
                appenddata+='<div class="col-md-6"><label id="Banktt_SRC_lbl_amounterrormsg" class="errormsg" hidden></label></div></div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                $(".amountonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
                $('#Banktt_SRC_lbl_amounterrormsg').text(SRC_ErrorMsg[4].EMC_DATA);
                $('.preloader').hide();
            }
            if(searchoption==6)
            {
                $('.preloader').show();
                var appenddata='<h4 style="color:#498af3;">MODEL NAME SEARCH</h4><br>';
                appenddata+='<div class="row form-group" style="padding-left:40px;">';
                appenddata+='<div class="col-md-2"><label>MODEL NAME<span class="labelrequired"><em>*</em></span></label></div>';
                appenddata+='<div class="col-md-3"><SELECT class="form-control" name="Banktt_SRC_Modelsearch"  id="Banktt_SRC_Modelsearch"></SELECT></div>';
                appenddata+='</div>';
                appenddata+='<div class="row form-group">';
                appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                $('#Banktt_SearchformDiv').html(appenddata);
                var modeloptions='<OPTION>SELECT</OPTION>';
                for (var i = 0; i < modelnames.length; i++)
                {
                    var data=modelnames[i];
                    modeloptions += '<option value="' + data.BTM_DATA + '">' + data.BTM_DATA + '</option>';
                }
                $('#Banktt_SRC_Modelsearch').html(modeloptions);
                $('.preloader').hide();
            }
            else if(searchoption==4)
            {
                $.ajax({
                    type: "POST",
                    url: '/index.php/Ctrl_Banktt_Search_Forms/Banktt_getAccname',
                    success: function(data){
                        var value_array=JSON.parse(data);
                        var appenddata='<BR><h4 style="color:#498af3;">ACCOUNT NAME SEARCH</h4><BR>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-md-2"><label>ACCOUNT NAME<span class="labelrequired"><em>*</em></span></label></div>';
                        appenddata+='<div class="col-md-3"><input type=text class="form-control contactnoautovalidate" name="Banktt_SRC_accname"  id="Banktt_SRC_accname"/></div>';
                        appenddata+='<div class="col-md-5"><label id="autocompleteerrormsg" class="errormsg" hidden></label></div>';
                        appenddata+='</div>';
                        appenddata+='<div class="row form-group">';
                        appenddata+='<div class="col-lg-offset-1 col-lg-2">';
                        appenddata+='<input type="button" id="Banktt_src_btn_search" class="btn" value="SEARCH" disabled></div></div>';
                        $('#Banktt_SearchformDiv').html(appenddata);
                        for (var i = 0; i < value_array.length; i++)
                        {
                            var data=value_array[i].BT_ACC_NAME;
                            AllaccnameArray.push(data);
                        }
                        $('#autocompleteerrormsg').text(SRC_ErrorMsg[6].EMC_DATA);
                        $('.preloader').hide();
                    },
                    error: function(data){
                        show_msgbox("BANKTT/SEARCH/UPDATE",JSON.stringify(data),"success",false);
                        $('.preloader').hide();
                    }
                });
            }
        });
        var Banktt_chequeflag;
        $(document).on('keypress','#Banktt_SRC_accname',function() {
            Banktt_chequeflag=0;
            BANKTT_SEARCH_invfromhighlightSearchText();
            $("#Banktt_SRC_accname").autocomplete({
                source: AllaccnameArray,
                select: BANKTT_SEARCH_AutoCompleteSelectHandler
            });
        });
        function BANKTT_SEARCH_AutoCompleteSelectHandler(event, ui) {
            Banktt_chequeflag=1;
            $('#autocompleteerrormsg').hide();
            $('#Banktt_src_btn_search').removeAttr("disabled");
        }
        $(document).on('change','.contactnoautovalidate',function(){
            if(Banktt_chequeflag==1){
                $('#autocompleteerrormsg').hide();
            }
            else
            {
                $('#autocompleteerrormsg').show();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
            if($('#Banktt_SRC_accname').val()=="")
            {
                $('#autocompleteerrormsg').hide();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //FUNCTION TO HIGHLIGHT SEARCH TEXT//
        function BANKTT_SEARCH_invfromhighlightSearchText() {
            $.ui.autocomplete.prototype._renderItem = function( ul, item) {
                var re = new RegExp(this.term, "i") ;
                var t = item.label.replace(re,"<span class=autotxt>" + this.term + "</span>");//higlight color,class shld be same as here
                return $( "<li></li>" )
                    .data( "item.autocomplete", item )
                    .append( "<a>" + t + "</a>" )
                    .appendTo( ul );
            };}
        $(document).on('change','#Banktt_SRC_unit',function() {
            $('.preloader').show();
            var unit=$('#Banktt_SRC_unit').val();
            if(unit!='SELECT')
            {
                $.ajax({
                    type: "POST",
                    url: '/index.php/Ctrl_Banktt_Search_Forms/Banktt_customer',
                    data:{Unit:unit},
                    success: function(data){
                        var valuearray=JSON.parse(data);
                        var customeroptions='<OPTION>SELECT</OPTION>';
                        for (var i = 0; i < valuearray.length; i++)
                        {
                            var data=valuearray[i];
                            customeroptions += '<option value="' + data.CUSTOMER_FIRST_NAME+'_'+data.CUSTOMER_LAST_NAME + '">' + data.CUSTOMER_FIRST_NAME+' '+data.CUSTOMER_LAST_NAME + '</option>';
                        }
                        $('#Banktt_SRC_Customer').html(customeroptions);
                        $('#Banktt_SRC_Customer').prop("disabled", false);
                        $('.preloader').hide();
                    },
                    error: function(data){
                        alert('error in getting'+JSON.stringify(data));
                        $('.preloader').hide();
                    }
                });
            }
            else
            {
                $('#Banktt_SRC_Customer').prop("disabled", true);
                $('#Banktt_SRC_Customer').val('SELECT');
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
                $('.preloader').hide();
            }
        });
        //PAIDDATE TO DATE PICKER
        var CCRE_d = new Date();
        var maxyear=CCRE_d.getFullYear()+parseInt(2);
        var changeyear=new Date(CCRE_d.setFullYear(maxyear));
        $(document).on('change','#Banktt_SRC_fromdate',function() {
            $("#Banktt_SRC_todate").datepicker({
                dateFormat: "dd-mm-yy",
                changeYear: true,
                changeMonth: true});
            var to_mindate=Form_dateConversion($('#Banktt_SRC_fromdate').val());
            $('#Banktt_SRC_todate').datepicker("option","minDate",to_mindate);
            $('#Banktt_SRC_todate').datepicker("option","maxDate",changeyear);
        });
        function Form_dateConversion(inputdate)
        {
            var inputdate=inputdate.split('-');
            var newunitstartdate=new Date(inputdate[2],inputdate[1]-1,parseInt(inputdate[0])+parseInt(1));
            return newunitstartdate;
        }
        //MODEL NAME SEARCH BUTTON VALIDATION
        $(document).on('change','#Banktt_SRC_Modelsearch',function() {
            if($('#Banktt_SRC_Modelsearch').val()!='SELECT')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //UNIT SEARCH BUTTON VALIDATION
        $(document).on('change','#Banktt_SRC_Uintsearch',function() {
            if($('#Banktt_SRC_Uintsearch').val()!='SELECT')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //CUSTOMER SEARCH BUTTON VALIDATION
        $(document).on('change','.customer_btn_validation',function() {
            if($('#Banktt_SRC_unit').val()!='SELECT' && $('#Banktt_SRC_Customer').val()!='SELECT' && $('#Banktt_SRC_Customer').val()!=undefined && $('#Banktt_SRC_Customer').val()!='')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        //DATE SEARCH BUTTON VALIDATION
        $(document).on('change','.Date_btn_validation',function() {
            if($('#Banktt_SRC_fromdate').val()!='' && $('#Banktt_SRC_todate').val()!='')
            {
                $('#Banktt_src_btn_search').removeAttr("disabled");
            }
            else
            {
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        $(document).on('change','.Amount_btn_validation',function() {
            var Banktt_SRC_fromamt=$('#Banktt_SRC_FromAmount').val();
            var Banktt_SRC_toamt=$('#Banktt_SRC_ToAmount').val();
            if(Banktt_SRC_fromamt!='' && Banktt_SRC_toamt!='')
            {
                if(parseFloat(Banktt_SRC_fromamt)<=parseFloat(Banktt_SRC_toamt))
                {
                    $("#Banktt_src_btn_search").removeAttr("disabled");
                    $('#Banktt_SRC_lbl_amounterrormsg').hide();
                }
                else
                {
                    $('#Banktt_SRC_lbl_amounterrormsg').show();
                    $("#Banktt_src_btn_search").attr("disabled", "disabled");
                }
            }
            else
            {
                $('#Banktt_SRC_lbl_amounterrormsg').hide();
                $("#Banktt_src_btn_search").attr("disabled", "disabled");
            }
        });
        var BT_id=[];
        $(document).on('click','#Banktt_src_btn_search',function() {
            var searchoption=$('#Banktt_SRC_SearchOption').val();
            $("#Banktt_src_btn_search").attr("disabled", "disabled");
            $('.preloader').show();
            if(searchoption==1)
            {
                var unit=$('#Banktt_SRC_Uintsearch').val();
                var inputdata={"Option":1,"Unit":unit,"Customer":''};
                var header="DETAILS OF SELECTED UNIT : "+unit;
                $('#Banktt_SRC_Uintsearch').val('SELECT');
            }
            if(searchoption==2)
            {
                var unit=$('#Banktt_SRC_unit').val();
                var customer=$('#Banktt_SRC_Customer').val()
                var inputdata={"Option":2,"Unit":unit,Customer:customer};
                var header="DETAILS OF SELECTED UNIT : "+unit +" AND CUSTOMER "+customer;
                $('#Banktt_SRC_unit').val('SELECT');
                $('#Banktt_SRC_Customer').val('SELECT');
                $('#Banktt_SRC_Customer').prop("disabled", true);
            }
            if(searchoption==4)
            {
                var accname=$('#Banktt_SRC_accname').val();
                var inputdata={"Option":4,"Unit":accname,Customer:''};
                var header="DETAILS OF SELECTED ACC NAME : "+accname;
                $('#Banktt_SRC_accname').val('');
            }
            if(searchoption==3)
            {
                var fromdate=$('#Banktt_SRC_fromdate').val();
                var todate=$('#Banktt_SRC_todate').val();
                var inputdata={"Option":3,"Unit":fromdate,Customer:todate};
                var header="DETAILS OF SELECTED DATE RANGE : "+fromdate+" TO "+todate
                $('#Banktt_SRC_fromdate').val('');
                $('#Banktt_SRC_todate').val('');
            }
            if(searchoption==5)
            {
                var Banktt_SRC_fromamt=$('#Banktt_SRC_FromAmount').val();
                var Banktt_SRC_toamt=$('#Banktt_SRC_ToAmount').val();
                var inputdata={"Option":5,"Unit":Banktt_SRC_fromamt,Customer:Banktt_SRC_toamt};
                var header="DETAILS OF SELECTED AMOUNT RANGE : "+Banktt_SRC_fromamt+" TO "+Banktt_SRC_toamt
                $('#Banktt_SRC_FromAmount').val('');
                $('#Banktt_SRC_ToAmount').val('');
            }
            if(searchoption==6)
            {
                var modelname=$('#Banktt_SRC_Modelsearch').val();
                var inputdata={"Option":6,"Unit":modelname,Customer:''};
                var header="DETAILS OF SELECTED MODEL : "+modelname
                $('#Banktt_SRC_Modelsearch').val('SELECT');
            }
            $.ajax({
                type: "POST",
                url: '/index.php/Ctrl_Banktt_Search_Forms/Banktt_Search_Details',
                data:inputdata,
                success: function(data){
                   var valuearray=JSON.parse(data);
                    var tabledata="<table id='Banktt_Datatable' border=1 cellspacing='0' data-class='table'  class='srcresult table' style='width:3000px;' >";
                    tabledata+="<thead class='headercolor'><tr class='head' style='text-align:center'>";
                    tabledata+="<th style='text-align:center;vertical-align: top'>EDIT/UPDATE</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top'>TRANSACTION TYPE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>ACCOUNT NAME<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>ACCOUNT NO<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>AMOUNT<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>UNIT</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CUSTOMER<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>STATUS<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>DEBITED / REJECTED DATE<span class='labelrequired'><em>*</em></span></th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>BANK CODE</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>BRANCH CODE</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>BANK ADDRESS</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>SWIFT CODE</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CHARGES TO</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>CUST REF</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>INV DETAILSS</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>COMMENTS</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>USERSTAMP</th>";
                    tabledata+="<th style='text-align:center;vertical-align: top''>TIMESTAMP</th>";
                    tabledata+="</tr></thead><tbody>";
                    for(var i=0;i<valuearray.length;i++)
                    {
                        var Ermid=valuearray[i].BT_ID;
                        BT_id.push(Ermid)
                        var edit="Editid_"+valuearray[i].BT_ID;
                        var del="Deleteid_"+valuearray[i].BT_ID;
                        if(valuearray[i].BT_ACC_NAME==null){var accname='';}else{accname=valuearray[i].BT_ACC_NAME;}
                        if(valuearray[i].BT_ACC_NO==null){var accno='';}else{accno=valuearray[i].BT_ACC_NO;}
                        if(valuearray[i].UNIT_NO==null){var unit='';}else{unit=valuearray[i].UNIT_NO;}
                        if(valuearray[i].CUSTOMERNAME==null){var customer='';}else{customer=valuearray[i].CUSTOMERNAME;}
                        if(valuearray[i].TRANSACTION_STATUS==null){var status='';}else{status=valuearray[i].TRANSACTION_STATUS;}
                        if(valuearray[i].BT_DEBITED_ON==null){var debitedon='';}else{debitedon=valuearray[i].BT_DEBITED_ON;}
                        if(valuearray[i].BT_BANK_CODE==null){var bankcode='';}else{bankcode=valuearray[i].BT_BANK_CODE;}
                        if(valuearray[i].BT_BRANCH_CODE==null){var branchcode='';}else{branchcode=valuearray[i].BT_BRANCH_CODE;}
                        if(valuearray[i].BT_BANK_ADDRESS==null){var bankaddress='';}else{bankaddress=valuearray[i].BT_BANK_ADDRESS;}
                        if(valuearray[i].BT_SWIFT_CODE==null){var swiftcode='';}else{swiftcode=valuearray[i].BT_SWIFT_CODE;}
                        if(valuearray[i].BANK_TRANSFER_CHARGES_TO==null){var chargesto='';}else{chargesto=valuearray[i].BANK_TRANSFER_CHARGES_TO;}
                        if(valuearray[i].BT_CUST_REF==null){var custoref='';}else{custoref=valuearray[i].BT_CUST_REF;}
                        if(valuearray[i].BT_INV_DETAILS==null){var invdetails='';}else{invdetails=valuearray[i].BT_INV_DETAILS;}
                        if(valuearray[i].BT_COMMENTS==null){var comments='';}else{comments=valuearray[i].BT_COMMENTS;}
                        tabledata+='<tr id='+valuearray[i].BT_ID+'>' +
                            "<td style='width:80px !important;vertical-align: middle'><div class='col-lg-2'><span style='display: block;color:green' title='Edit' class='glyphicon glyphicon-edit Cheque_editbutton' disabled id="+edit+"></div></td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+valuearray[i].BANK_TRANSFER_TYPE+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center' >"+valuearray[i].BT_DATE+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+accname+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+accno+"</td>" +
                            "<td style='width:120px !important;vertical-align: middle;text-align: center'>"+valuearray[i].BT_AMOUNT+"</td>" +
                            "<td style='width:150px !important;vertical-align: middle;text-align: center'>"+unit+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+customer+"</td>" +
                            "<td style='width:100px !important;vertical-align: middle;text-align: center'>"+status+"</td>" +
                            "<td style='width:250px !important;vertical-align: middle'>"+debitedon+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+bankcode+"</td>" +
                            "<td style='width:150px !important;vertical-align: middle'>"+branchcode+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+bankaddress+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+swiftcode+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+chargesto+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+custoref+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+invdetails+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+comments+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+valuearray[i].ULD_LOGINID+"</td>" +
                            "<td style='width:200px !important;vertical-align: middle'>"+valuearray[i].BT_TIME_STAMP+"</td>" +
                            "</tr>";
                    }
                    tabledata+="</body>";
                    $('section').html(tabledata);
                    $('#Banktt_Search_DataTable').show();
                    $('#Banktt_Datatable').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "sPaginationType":"full_numbers"
                    });
                    $('.preloader').hide();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                    $('.preloader').hide();
                }
              });
          });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
        <div class="row title text-center"><h4><b>BANK TT SEARCH / UPDATE</b></h4></div>
        <div class ='row content'>
            <div class="panel-body">
                <fieldset>
                    <div class="row form-group" style="padding-left:20px;">
                        <div class="col-md-3">
                            <label>BANKTT SEARCH BY<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="Banktt_SRC_SearchOption"  id="Banktt_SRC_SearchOption">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <br>
                    <div id="Banktt_SearchformDiv">

                    </div>
                    <div id="Banktt_Search_DataTable" class="table-responsive" hidden>
                        <h4 style="color:#498af3;" id="tableheader"></h4>
                        <section>

                        </section>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
</div>
