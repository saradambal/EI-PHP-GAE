<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'Header.php'; ?>
    <style>
        .container-fluid{
            background-color: #4285f4;
            color:#ffffff;
            border: none;
        }
        .navbar-inverse{
            border-color:#4285f4;
        }
        .navbar-inverse .navbar-brand {
            color: white;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">EXPATS INTEGRATED</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">CUSTOMER<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">CUSTOMER CREATION</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">FINANCE<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/index.php/Finance_Controller/Active_Customer_Entry">PAYMENT ACTIVE CUSTOMER</a></li>
                        <li><a href="#">PAYMENT SEARCH/UPDATE</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
