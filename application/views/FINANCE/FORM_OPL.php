<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        var Message;
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_Outstanding_Payee_list/ProfileEmailId',
            data:{"ErrorList":'6'},
            success: function(data){
                var value_array=JSON.parse(data);
                $('.preloader').hide();
                Message=value_array[1];
                if(value_array[0].lengt!=0)
                {
                    var options ='<option value="SELECT">SELECT</option>';
                    for (var i = 0; i < value_array[0].length; i++)
                    {
                        var data=value_array[0][i];
                        options += '<option value="'+data+'">' + data+ '</option>';
                    }
                    $('#FIN_OPL_lb_mailid').html(options);
                    $('#Form_ErrorMessage').html('');
                }
                else
                {
                    var appeneddata='<h4 class="errormsg">'+Message[0].EMC_DATA+'</h4>';
                    $('#Form_ErrorMessage').html(appeneddata);
                    $('#FIN_OPL_outstanding_form').hide();
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });

//************************FORM VALIDATION FUNCTION START******************************//
        $('#FIN_OPL_outstanding_form').change(function(){
            FIN_OPL_formvalidation()
        });
        function FIN_OPL_formvalidation()
        {
            if($("#FIN_OPL_db_period").val()==""||($('input:radio[name=Radio]').is(':checked')==false)||($("#FIN_OPL_lb_mailid").val()=="SELECT"))
            {
                $("#FIN_OPL_btn_save").attr("disabled", "disabled");
            }
            else
            {
                $("#FIN_OPL_btn_save").removeAttr("disabled");
            }
        }
//************************FORM VALIDATION FUNCTION END******************************//
//************************FOR PERIOD DATE PICKER FUNCTION START******************************//
        $("#FIN_OPL_db_period").datepicker(
            {
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM-yy',
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).datepicker('setDate', new Date(year, month, 1));
                    FIN_OPL_formvalidation();
                }
            });
        $('#FIN_OPL_db_period').datepicker("option","maxDate",new Date());
        $('#FIN_OPL_db_period').datepicker("option","minDate",new Date(2010,00));
 //************************FOR PERIOD DATE PICKER FUNCTION START******************************//
 //************************FORM RESET FUNCTION START******************************//
        $('#FIN_OPL_btn_reset').click(function(){
            oplreset();
        });
        function oplreset()
        {
            $("#FIN_OPL_radio_outstanding").attr('checked',false);
            $("#FIN_OPL_radio_active").attr('checked', false);
            $("#FIN_OPL_lb_mailid")[0].selectedIndex = 0;
            $('#FIN_OPL_outstanding_form').find('input[type=text]').val('');
            $("#FIN_OPL_btn_save").attr("disabled", "disabled");
        }
 //************************FORM RESET FUNCTION START******************************//
        $(document).on('click','#FIN_OPL_btn_save',function(){
            $('.preloader').show();
            var FormElements=$('#FIN_OPL_outstanding_form').serialize();
            $.ajax({
                type: "POST",
                url: "/index.php/Ctrl_Outstanding_Payee_list/FIN_OPL_opllist",
                data:FormElements,
                success: function(data){
                    $('.preloader').hide();
                    var returnvalue=JSON.parse(data);
                    if(returnvalue==1)
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",'EMAIL SENT WITH THE CURRENT OUTSTANDING PAYEES LIST',"success",false);
                    }
                    else
                    {
                        show_msgbox("OUTSTANDING PAYEES LIST",'EMAIL NOT SENT WITH THE CURRENT OUTSTANDING PAYEES LIST',"success",false);
                    }
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
<style type="text/css">
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
        <div class="row title text-center"><h4><b>OUTSTANDING PAYEES LIST</b></h4></div>
        <div class ='row content'>
                <div id="Form_ErrorMessage">

                </div>
            <form id="FIN_OPL_outstanding_form" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>SELECT THE OPTION</label>
                        </div>
                        <div class="col-md-6">
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <input type="radio" name="Radio" id='FIN_OPL_radio_outstanding'  value="OPL_list"><label id="FIN_OPL_lbl_outstanding" >OUTSTANDING PAYEE LIST</label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-5">
                                    <input type="radio"  name="Radio" id='FIN_OPL_radio_active' value="option2"><label id="FIN_OPL_lbl_active">ACTIVE CUSTOMER LIST</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>FOR PERIOD </label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="datemandtry form-control" id="FIN_OPL_db_period" name="FIN_OPL_db_period" style="width:125px" placeholder="For Period">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>EMAIL ID<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" id="FIN_OPL_lb_mailid"  name="FIN_OPL_lb_mailid">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" class="btn" name="FIN_OPL_btn_save" id="FIN_OPL_btn_save" disabled value="SUBMIT">         <input type="button" class="btn" name="FIN_OPL_btn_reset" id="FIN_OPL_btn_reset"  value="RESET">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<!--BODY TAG END-->
</html>
<!--HTML TAG END-->