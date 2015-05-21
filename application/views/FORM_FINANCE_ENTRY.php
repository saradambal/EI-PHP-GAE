<html>
<head>
    <?php include 'Header.php'; ?>
    <?php include 'EI_MENU.php'?>
</head>
<script>
    $(document).ready(function() {
        $(".amtonly").doValidation({rule:'numbersonly',prop:{realpart:5,imaginary:2}});
        $('#Finance_Entry_Update').hide();
        $("#Finance_Entry_Paiddate").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true,
            changeMonth: true
        });
        $('#Finance_Entry_Forperiod').datepicker( {
            changeMonth: true,      //provide option to select Month
            changeYear: true,       //provide option to select year
            showButtonPanel: true,  // button panel having today and done button
            dateFormat: 'yy-mm-dd',    //set date format
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));//here set the date when closing.
                $(this).blur();//remove focus input box
            }
        });
        $("#Finance_Entry_Forperiod").focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });
        var CCRE_d = new Date();
        var CCRE_year = CCRE_d.getFullYear()-2;
        var changedmonth=new Date(CCRE_d.setFullYear(CCRE_year));
        $('#Finance_Entry_Paiddate').datepicker("option","maxDate",new Date());
        $('#Finance_Entry_Paiddate').datepicker("option","minDate",changedmonth);
        //******************PAYMENT INITIAL DATA LODING***********************//
        $.ajax({
            type: "POST",
            url: '/index.php/Finance_Controller/All_Active_Unit',
            success: function(data){
                var value_array=JSON.parse(data);
                for(var i=0;i<value_array[0].length;i++)
                {
                    var data=value_array[0][i];
                    $('#Finance_Entry_unit').append($('<option>').text(data.UNIT_NO).attr('value', data.UNIT_NO));
                }
                for(var i=0;i<value_array[1].length;i++)
                {
                    var data=value_array[1][i];
                    $('#Finance_Entry_Payment').append($('<option>').text(data.PP_DATA).attr('value', data.PP_DATA));
                }
            },
            error: function(data){
                alert('error in getting'+JSON.stringify(data));
            }
        });
        //******************PAYMENT CANCEL VALIDATION*************************//
        $(document).on('click','#Finance_Entry_Cancel',function(){
            $('#Finance_Entry_Active_Customer')[0].reset();
        });
        //******************PAYMENT INPUT ROW VALIDATION*************************//
        $(document).on('change','.validation',function(){
            if($('#Finance_Entry_unit').val()!="" &&  $('#Finance_Entry_Customer').val()!="" && $('#Finance_Entry_LP').val()!=""
                && $('#Finance_Entry_Payment').val()!="" &&  $('#Finance_Entry_Amount').val()!="" && $('#Finance_Entry_Forperiod').val()!=""
                && $('#Finance_Entry_Paiddate').val()!="" &&  $('#Finance_Entry_Comments').val()!="")
            {
                $('#Finance_Entry_Save').removeAttr('disabled');
                $('#Finance_Entry_Update').removeAttr('disabled');
            }
            else
            {
                $('#Finance_Entry_Save').attr('disabled','disabled');
                $('#Finance_Entry_Update').attr('disabled','disabled');
            }
        });
        var t = $('#Finance_Entry_Table').DataTable();
        //******************PAYMENT ADD NEW ROWS*************************//
//        var counter = 1;
//        $('#Finance_Entry_Save').on( 'click', function () {
//            var unit=$('#Finance_Entry_unit').val();
//            var customer=$('#Finance_Entry_Customer').val();
//            var LP=$('#Finance_Entry_LP').val();
//            var payment=$('#Finance_Entry_Payment').val();
//            var amount=$('#Finance_Entry_Amount').val();
//            var forperiod=$('#Finance_Entry_Forperiod').val();
//            var paiddate=$('#Finance_Entry_Paiddate').val();
//            var comments=$('#Finance_Entry_Comments').val();
//            var customername='';
//            $.ajax({
//                type: "POST",
//                url: '/index.php/Finance_Controller/CustomerName',
//                data:{"CUSTOMERID":customer},
//                success: function(data){
//                    var value=JSON.parse(data);
//                    customername=value[0].CUSTOMER_FIRST_NAME+' '+value[0].CUSTOMER_LAST_NAME;
//                    var editrowid="Edit_"+counter;
//                    var deleterowid="Delete_"+counter;
//                    t.row.add( [
//                        '<a href="#"  class="Edit" id='+editrowid+'><span style="color:green;text-align:center" class="glyphicon glyphicon-edit"></span></a>                    ' +
//                            '<a href="#" class="Delete" id='+deleterowid+'><span style="color:red;text-align:center" class="glyphicon glyphicon-trash" id='+deleterowid+'></span></a>',
//                        unit,
//                        customername,
//                        LP,
//                        payment,
//                        amount,
//                        forperiod,
//                        paiddate,
//                        comments
//                    ] ).draw();
//                },
//                error: function(data){
//                    alert('error in getting'+JSON.stringify(data));
//                }
//            });
//
//
//            counter++;
//            $('#Finance_Entry_Active_Customer')[0].reset();
//        } );
        $(document).on('click','.Edit',function(){
            alert(this.id);
        });
        $(document).on('change','.LoadCustomer',function(){
            var unit=$('#Finance_Entry_unit').val();
            $.ajax({
                type: "POST",
                url: '/index.php/Finance_Controller/Active_Customer',
                data:{"UNIT":unit},
                success: function(data){
                    var value_array=JSON.parse(data);
                    var options ='<option value="">SELECT</option>';
                    for (var i = 0; i < value_array.length; i++)
                    {
                        var data=value_array[i];
                        options += '<option value="' + data.CUSTOMER_ID + '">' + data.CUSTOMERNAME + '</option>';
                    }
                    $('#Finance_Entry_Customer').html(options);
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
        $(document).on('change','.LoadLeaseperiod',function(){
            var unit=$('#Finance_Entry_unit').val();
            var customerid=$('#Finance_Entry_Customer').val();
            $.ajax({
                type: "POST",
                url: '/index.php/Finance_Controller/Active_Customer_LP',
                data:{"UNIT":unit,"CUSTOMERID":customerid},
                success: function(data){
                    var value_array=JSON.parse(data);
                    var options ='<option value="">SELECT</option>';
                    for (var i = 0; i < value_array.length; i++)
                    {
                        var data=value_array[i];
                        var recverdateperiod=data.CLP_STARTDATE+' --- '+data.CLP_ENDDATE;
                        options += '<option title="'+recverdateperiod+'" value="' + data.CED_REC_VER + '">' + data.CED_REC_VER + '</option>';
                    }
                    $('#Finance_Entry_LP').html(options);
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        });
        $(document).on('click','#Finance_Entry_Save',function(){
            var unit=$('#Finance_Entry_unit').val();
            var customer=$('#Finance_Entry_Customer').val();
            var LP=$('#Finance_Entry_LP').val();
            var payment=$('#Finance_Entry_Payment').val();
            var amount=$('#Finance_Entry_Amount').val();
            var forperiod=$('#Finance_Entry_Forperiod').val();
            var paiddate=$('#Finance_Entry_Paiddate').val();
            var comments=$('#Finance_Entry_Comments').val();
            $.ajax({
                type: "POST",
                url: '/index.php/Finance_Controller/Active_Customer_EntrySave',
                data:{"unit":unit,"customer":customer,"lp":LP,"payment":payment,"amount":amount,"period":forperiod,"paiddate":paiddate,"comments":comments},
                success: function(data){
                    alert(data);
                    $('#Finance_Entry_Active_Customer')[0].reset();
                },
                error: function(data){
                    alert('error in getting'+JSON.stringify(data));
                }
            });
        })
    });
</script>
<body>
<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">PAYMENT ENTRY-ACTIVE CUSTOMER</h3>
        </div>
        <div class="panel-body">
            <form id="Finance_Entry_Active_Customer">
                <div id="Finance_Entry_form">
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>UNIT<span class="labelrequired"><em>*</em></span></label>
                            <SELECT class="form-control  validation LoadCustomer" name="Finance_Entry_unit" style="width:150px" required id="Finance_Entry_unit">
                                <OPTION>SELECT</OPTION>
                            </SELECT/>
                        </div>
                        <div class="col-md-3">
                            <label>CUSTOMER<span class="labelrequired"><em>*</em></span></label>
                            <SELECT class="form-control  validation LoadLeaseperiod" name="Finance_Entry_Customer" required id="Finance_Entry_Customer">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                        <div class="col-md-2">
                            <label>LEASE PERIOD<span class="labelrequired"><em>*</em></span></label>
                            <SELECT class="form-control  validation" name="Finance_Entry_LP" required id="Finance_Entry_LP">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                        <div class="col-md-2">
                            <label>PAYMENT<span class="labelrequired"><em>*</em></span></label>
                            <SELECT class="form-control  validation" name="Finance_Entry_Payment" required id="Finance_Entry_Payment">
                                <OPTION>SELECT</OPTION>
                            </SELECT>
                        </div>
                        <div class="col-md-2">
                            <label>AMOUNT<span class="labelrequired"><em>*</em></span></label>
                            <input class="form-control  validation amtonly" name="Finance_Entry_Amount" required id="Finance_Entry_Amount"/>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label>FOR PERIOD<span class="labelrequired"><em>*</em></span></label>
                            <input class="form-control  validation" name="Finance_Entry_Forperiod" required id="Finance_Entry_Forperiod"/>
                        </div>
                        <div class="col-md-2">
                            <label>PAID DATE<span class="labelrequired"><em>*</em></span></label>
                            <input class="form-control  validation" name="Finance_Entry_Paiddate" required id="Finance_Entry_Paiddate"/>
                        </div>
                        <div class="col-md-2">
                            <label>BANKREF COMMENTS<span class="labelrequired"><em>*</em></span></label>
                            <textarea class="form-control  validation" name="Finance_Entry_Comments" required id="Finance_Entry_Comments"></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-offset-10 col-lg-12">
                            <button type="button" id="Finance_Entry_Save" class="btn btn-success" disabled>Save</button> <button type="button" id="Finance_Entry_Update" class="btn btn-primary" disabled>Save</button> <a href="#" id="Finance_Entry_Cancel" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
                <!--                <div id="Finance_Entry_Container" class="table-responsive">-->
                <!--                    <section>-->
                <!--                        <table id="Finance_Entry_Table" class='table table-striped table-bordered src' border="1" width="100%">-->
                <!--                            <thead style="background-color: #4285f4;color:#ffffff">-->
                <!--                            <tr>-->
                <!--                                <th>ACTION</th>-->
                <!--                                <th>UNIT</th>-->
                <!--                                <th>CUSTOMER</th>-->
                <!--                                <th>LEASE PERIOD</th>-->
                <!--                                <th>PAYMENT</th>-->
                <!--                                <th>AMOUNT</th>-->
                <!--                                <th>FOR PERIOD</th>-->
                <!--                                <th>PAID DATE</th>-->
                <!--                                <th>COMMENTS</th>-->
                <!--                            </tr>-->
                <!--                            </thead>-->
                <!--                        </table>-->
                <!--                    </section>-->
                <!--                </div>-->
            </form>
        </div>
    </div>
</div>
</body>
</html>
