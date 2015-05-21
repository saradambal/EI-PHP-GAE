<!DOCTYPE html>
<html lang="en">
    <?php include 'Header.php'; ?> 
	</head>
	<body>
    		   <div class="panel panel-primary">
                                <div class="panel-heading">
                                  <h3 class="panel-title">EMPLOYEE LIST</h3>
                                </div>
                                <div class="panel-body">
                                   <div class="col-lg-10 container">  
                                      <section>
			  		<table id="sampletable" border=1 cellspacing='0' data-class='table'  class=' srcresult table'  width='auto'>
                                            <thead style="background-color: #4285f4;color:#ffffff"><tr>
                                                <th class="text-center">#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th></tr>
                                            </thead>
                                            <tbody>
                                            <?php if(is_array($EMPLOYEES) && count($EMPLOYEES) )
                                                {
                                                    foreach($EMPLOYEES as $loop)
                                                      { ?>
                                            <tr>
                                            <td><?=$loop->EMPLOYEE_ID;?></td>
                                            <td><?=$loop->FIRST_NAME;?></td>
                                            <td><?=$loop->LAST_NAME;?></td>
                                            <td><?=$loop->EMAIL;?></td>
                                            </tr>
                                            <?php
                                                } 
                                            }?>
					</tbody>
                                        </table>
                                      </section>
				  </div>
                                </div>
                              </div>				
	</body>
         <script>
        $(document).ready(function() {  
                   $('#sampletable').DataTable( {
                        "aaSorting": [],
                        "pageLength": 10,
                        "responsive": true,
                        "sPaginationType":"full_numbers"
              });
        });
    </script>
</html>