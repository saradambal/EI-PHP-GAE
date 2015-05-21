<html>
<head>
    <?php include 'Header.php'; ?>
</head>
<script>
    $(document).ready(function() {
        $('#spacewidth').height('0%');
        $('#ERM_Entry_MovingDate').datepicker({
            dateFormat: "dd-mm-yy",
            changeYear: true,
            changeMonth: true
        });
        $('#ERM_Entry_Others').hide();
        $("#ERM_Entry_Contactno").doValidation({rule:'numbersonly',prop:{realpart:20,leadzero:true}});
        $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
        $('#ERM_Entry_Emailid').doValidation({rule:'email',prop:{uppercase:false,autosize:true}});
        $(".compautosize").doValidation({prop:{autosize:true}});
        $(".numonly").doValidation({rule:'numbersonly'});
        $("#ERM_Entry_Rent").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        //INITIAL DATA
        var errormsg;
        $.ajax({
            type: "POST",
            url: '/index.php/Ctrl_Erm_Forms/ERM_InitialDataLoad',
            data:{"Formname":'ERM_Entry',"ErrorList":'1,2,3,6,36,382,400'},
            success: function(data){
                $('.preloader').hide();
                var value_array=JSON.parse(data);
                errormsg=value_array[1];
                for(var i=0;i<value_array[0].length;i++)
                {
                    var data=value_array[0][i];
                    $('#ERM_Entry_Nationality').append($('<option>').text(data.NC_DATA).attr('value', data.NC_DATA));
                }
                for(var i=0;i<value_array[2].length;i++)
                {
                    var data=value_array[2][i];
                    $('#ERM_Entry_Occupation').append($('<option>').text(data.ERMO_DATA).attr('value', data.ERMO_DATA));
                }
                $('#ERM_Entry_Customername').prop('title',errormsg[0].EMC_DATA)
                $('#ERM_Entry_Rent').prop('title',errormsg[1].EMC_DATA);
                $('#ERM_Entry_Contactno').prop('title',errormsg[1].EMC_DATA);
                $('#CERM_ENTRY_lbl_emailiderrormsg').text(errormsg[4].EMC_DATA);
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        var CERM_id = new Date();
        $('#ERM_Entry_MovingDate').datepicker("option","minDate",new Date(CERM_id.getFullYear()-1,CERM_id.getMonth(),CERM_id.getDate()));
        $('#ERM_Entry_MovingDate').datepicker("option","maxDate",new Date(CERM_id.getFullYear(),CERM_id.getMonth()+3,CERM_id.getDate()));
         $(document).on('change','#ERM_Entry_Occupation',function(){
            if($('#ERM_Entry_Occupation').val()=='OTHERS')
            {
                $('#ERM_Entry_Others').show();
            }
             else
            {
               $('#ERM_Entry_Others').hide();
            }
         });
        //*************ERM SUBMIT BUTTON VALIDATION*******************//
        $('#ERM_Form_Entry').change(function(){
            //************************MAIL ID VALIDATION******************//
            var CERM_ENTRY_emailid=$("#ERM_Entry_Emailid").val();
            if(CERM_ENTRY_emailid.length>0)
            {
                var CERM_ENTRY_atpos=CERM_ENTRY_emailid.indexOf("@");
                var CERM_ENTRY_dotpos=CERM_ENTRY_emailid.lastIndexOf(".");
                if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(CERM_ENTRY_emailid) || "" == CERM_ENTRY_emailid)&&(CERM_ENTRY_dotpos-1!=CERM_ENTRY_emailid.indexOf(".")))
                {
                    var CERM_ENTRY_emailchk="valid";
                    $('#ERM_Entry_Emailid').removeClass('invalid');
                    $('#CERM_ENTRY_lbl_emailiderrormsg').hide();
                    $('#ERM_Entry_Emailid').val($('#ERM_Entry_Emailid').val().toLowerCase());
                }
                else
                {
                    CERM_ENTRY_emailchk="invalid"
                    $('#ERM_Entry_Emailid').addClass('invalid');
                    $('#CERM_ENTRY_lbl_emailiderrormsg').show();
                }
            }
            else
            {
                CERM_ENTRY_emailchk="valid";
                $('#ERM_Entry_Emailid').removeClass('invalid');
                $('#CERM_ENTRY_lbl_emailiderrormsg').hide();
            }
            if($('#ERM_Entry_Occupation').val()!="OTHERS")
            {
                //***********************IF OCCUPATION IS NOT= OTHERS THE FOLLOWING ID DATA'S ARE MANDATORY************************//
                if($('#ERM_Entry_Customername').val()!="" && $('#ERM_Entry_Rent').val()!="" && $('#ERM_Entry_MovingDate').val()!="" && $('#ERM_Entry_Minimumstay').val()!="" &&
                    $('#ERM_Entry_Occupation').val()!="SELECT" && $('#ERM_Entry_Comments').val()!="" &&(CERM_ENTRY_emailchk=="valid"))
                {
                    $("#CERM_ENTRY_btn_savebutton").removeAttr("disabled");
                }
                else
                {
                    $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
                }
            }
            else
            {
                //***********************IF OCCUPATION IS EQUAL TO OTHERS THE FOLLOWING ID DATA'S ARE MANDATORY************************//
                if($('#ERM_Entry_Customername').val()!="" && $('#ERM_Entry_Rent').val()!="" && $('#ERM_Entry_MovingDate').val()!="" && $('#ERM_Entry_Minimumstay').val()!="" &&
                    $('#ERM_Entry_Occupation').val()!="SELECT" && $('#ERM_Entry_Others').val()!=""&& $('#ERM_Entry_Comments').val()!="")
                {
                    $("#CERM_ENTRY_btn_savebutton").removeAttr("disabled");
                }
                else
                {
                    $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
                }
            }
        });
      $(document).on('click','#CERM_ENTRY_btn_savebutton',function(){
          var FormElements=$('#ERM_Form_Entry').serialize();
          $.ajax({
                type: "POST",
                url: "/index.php/Ctrl_Erm_Forms/ERM_Entry_Save",
                data:FormElements,
                success: function(data){
                var returnflag=JSON.parse(data);
                if(returnflag[0].FLAG_INSERT==1)
                {
                    show_msgbox("ERM ENTRY",errormsg[2].EMC_DATA,"success",false);
                    $('#ERM_Form_Entry')[0].reset();
                    $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
                }
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
          });
      });
      $(document).on('click','#CERM_ENTRY_btn_reset',function(){
          $('#ERM_Form_Entry')[0].reset();
          $("#CERM_ENTRY_btn_savebutton").attr("disabled", "disabled");
      });
    });
</script>
<body>
<div class="container">
    <div class="wrapper">
        <div  class="preloader MaskPanel"><div class="preloader statusarea" ><div style="padding-top:90px; text-align:center"><img src="https://googledrive.com/host/0B5pkfK_IBDxjU1FrR3hVTXB4a28/Loading.gif" /></div></div></div>
        <div class="row title text-center"><h4><b>ERM ENTRY</b></h4></div>
        <div class ='row content'>
            <form id="ERM_Form_Entry" class="form-horizontal" role="form">
                <div class="panel-body">
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>CUSTOMER NAME<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control autosize" name="ERM_Entry_Customername" maxlength="50" required id="ERM_Entry_Customername"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>RENT<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control amtonly" name="ERM_Entry_Rent" style="width:100px" required id="ERM_Entry_Rent"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>MOVING DATE<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control datemandtry" name="ERM_Entry_MovingDate"  style="max-width:120px;" id="ERM_Entry_MovingDate" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>MINIMUM STAY<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" name="ERM_Entry_Minimumstay" maxlength="10"  style="max-width:120px;" id="ERM_Entry_Minimumstay" />
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>OCCUPATION<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="ERM_Entry_Occupation"  id="ERM_Entry_Occupation">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                            <input class="form-control autosize" name="ERM_Entry_Others" id="ERM_Entry_Others" hidden/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>NATIONALITY</label>
                        </div>
                        <div class="col-md-3">
                            <SELECT class="form-control" name="ERM_Entry_Nationality" id="ERM_Entry_Nationality">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>NUMBER OF GUESTS</label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control alphanumonly" name="ERM_Entry_Numberofguests" maxlength="10" style="max-width:120px;" id="ERM_Entry_Numberofguests"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>AGE</label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control alphanumonly" name="ERM_Entry_Age" maxlength="10" style="max-width:120px;" id="ERM_Entry_Age"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>CONTACT NO</label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" name="ERM_Entry_Contactno" maxlength="20" style="max-width:150px;" id="ERM_Entry_Contactno"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>EMAIL ID</label>
                        </div>
                        <div class="col-md-3">
                            <input class="form-control" name="ERM_Entry_Emailid" maxlength="40" id="ERM_Entry_Emailid"/>
                        </div>
                        <div class="col-md-3"><label id="CERM_ENTRY_lbl_emailiderrormsg" class='errormsg' hidden></label></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <label>COMMENTS<span class="labelrequired"><em>*</em></span></label>
                        </div>
                        <div class="col-md-3">
                            <textarea class="form-control" name="ERM_Entry_Comments" id="ERM_Entry_Comments"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-offset-2 col-lg-3">
                            <input type="button" id="CERM_ENTRY_btn_savebutton" class="btn" value="SAVE" disabled>         <input type="button" id="CERM_ENTRY_btn_reset" class="btn" value="RESET">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

