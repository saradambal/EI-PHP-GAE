<html>
	<head>
            <?php include 'Header.php'; ?>       
	</head>
        <script>
        $(document).ready(function() {
       $(".autosize").doValidation({rule:'alphabets',prop:{whitespace:true,autosize:true}});
            $(document).on("click",'.Reset', function (){
            $('#sampleform')[0].reset();
            });         
            $('#email').change(function(){                
                var emailid=$("#email").val();
                var atpos=emailid.indexOf("@");
                var dotpos=emailid.lastIndexOf(".");
                if(emailid.length>0)
                {
                if ((/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(emailid) || "" == emailid)&&(atpos-1!=emailid.indexOf(".")))
                {
                $('#email').removeClass('invalid');
                $('#email').val(emailid.toLowerCase());
                }
                else
                {
                $('#email').addClass('invalid');
                }
                }
                else
                {
                $('#email').removeClass('invalid');
                }
            });
            ///**************************************SET DOB DATEPICKER**************************************/
            var CCRE_d = new Date();
            var CCRE_year = CCRE_d.getFullYear() - 18;
            CCRE_d.setFullYear(CCRE_year);
            $('#CCRE_db_BirthDate').datepicker({dateFormat: 'dd-mm-yy',
            changeYear: true,
            changeMonth: true,
            yearRange: '1920:' + CCRE_year + '',
            defaultDate: CCRE_d
            });
            $('#CCRE_db_BirthDate').blur(function()
{
});
        });
       </script>
	<body>
	  <div class="col-lg-12"> 
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">SAMPLE FORM</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" id="sampleform" role="form" action='<?= base_url();?>index.php/sample/save' method="post">
                            <div class="form-group">
                                <label for="firstName" class="col-lg-3 control-label">First Name<em>*</em></label>
				    <div class="col-lg-4">
				      <input type="text" class="form-control autosize" name="firstName" id="firstName" placeholder="First Name">
				    </div>
				  </div>	
				  <div class="form-group">
				    <label for="lastName" class="col-lg-3 control-label">Last Name<em>*</em></label>
				    <div class="col-lg-4">
				      <input type="text" class="form-control autosize" name="lastName" id="lastName" placeholder="Last Name">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="email" class="col-lg-3 control-label">Email<em>*</em></label>
				    <div class="col-lg-4">
				      <input type="text" class="form-control" name="email" id="email" placeholder="Email">
				    </div>
				  </div>
                                  <div class="form-group">
				    <label for="email" class="col-lg-3 control-label">DOB<em>*</em></label>
				    <div class="col-lg-4">
				      <input type="text" class="form-control" name="Dateofbirth" id="Dateofbirth" placeholder="Dateofbirth">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-lg-offset-3 col-lg-10">
				      <button type="submit" class="btn btn-success">Save</button> <a href="#" class="btn btn-primary Reset">Cancel</a>
				    </div>
				  </div>
                        </form>
                    </div>
                </div>
		</div>
	</body>
</html>