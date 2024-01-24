<?php
include('dbconnection.php');

// Get HouseNumber and OTP from the URL
$houseNumber = $_GET['houseNumber'];
$otp = $_GET['otp'];

// Check if OTP is associated with the provided HouseNumber in logindetails
$checkOtpSql = "SELECT HouseNumber FROM login_details WHERE HouseNumber = ? AND otp = ? LIMIT 1";
$otpStmt = $db->prepare($checkOtpSql);
$otpStmt->bind_param("ss", $houseNumber, $otp);
$otpStmt->execute();
$otpResult = $otpStmt->get_result();

if ($otpResult->num_rows > 0) {
    // Search transactions table for the provided HouseNumber
    $transactionSql = "SELECT Amount FROM transactions WHERE HouseNumber = ?";
    $transactionStmt = $db->prepare($transactionSql);
    $transactionStmt->bind_param("s", $houseNumber);
    $transactionStmt->execute();
    $transactionResult = $transactionStmt->get_result();

    // Calculate total amount from transactions
    $totalAmount = 0;
    while ($transactionRow = $transactionResult->fetch_assoc()) {
        $totalAmount += $transactionRow['Amount'];
    }

    // Search default_deposits table for DefaultDeposit related to the provided HouseNumber
    $depositSql = "SELECT DefaultDeposit FROM default_deposits WHERE HouseNumber = ? LIMIT 1";
    $depositStmt = $db->prepare($depositSql);
    $depositStmt->bind_param("s", $houseNumber);
    $depositStmt->execute();
    $depositResult = $depositStmt->get_result();

    // Retrieve DefaultDeposit
    if ($depositResult->num_rows > 0) {
        $depositRow = $depositResult->fetch_assoc();
        $defaultDeposit = $depositRow['DefaultDeposit'];

        // Display the total amount and default deposit
       // echo "Total Amount: $totalAmount<br>";
       // echo "Default Deposit: $defaultDeposit<br>";

        // Calculate percentage of payment
        $paymentPercentage = ($totalAmount / $defaultDeposit) * 100;

        // Display the payment percentage
      //  echo "Payment Percentage: $paymentPercentage%";
    } else {
        echo "No Default Deposit found for HouseNumber: $houseNumber";
    }
} else {
    echo "Invalid OTP for HouseNumber: $houseNumber";
}

// Close connections
//$otpStmt->close();
//$transactionStmt->close();
//$depositStmt->close();
//$db->close();

?>


<?php
// Assuming you have a database connection established
// $db = new mysqli("hostname", "username", "password", "database");

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get HouseNumber from the URL
$houseNumber = $_GET['houseNumber'];

// Fetch FirstName from transactions table based on HouseNumber
$fetchFirstNameSql = "SELECT FirstName FROM transactions WHERE HouseNumber = ? LIMIT 1";
$fetchFirstNameStmt = $db->prepare($fetchFirstNameSql);

if (!$fetchFirstNameStmt) {
    // Handle the error, e.g., display an error message or log the error
    die("Error in preparing fetchFirstName statement: " . $db->error);
}

$fetchFirstNameStmt->bind_param("s", $houseNumber);
$fetchFirstNameStmt->execute();
$fetchFirstNameStmt->bind_result($firstName);

// Check if a row is found
if ($fetchFirstNameStmt->fetch()) {
    // The FirstName associated with the HouseNumber is now in the $firstName variable
   // echo "FirstName: " . $firstName;
} else {
    // No matching record found for the given HouseNumber
    echo "No record found for HouseNumber: " . $houseNumber;
}

// Close the statement
$fetchFirstNameStmt->close();

// Close the database connection
//$db->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client Dashboard
    </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">K G A
                    <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="#
                ">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>PAY_RENT </span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">PAY RENT STK_PUSH</h6>
                        <a  class="collapse-item"  id="collapse" href="">PAYRENT</a>
               
</a>
<script>
    // Get the current URL's search parameters
const urlParams = new URLSearchParams(window.location.search);

// Get the values you want from the search parameters
const houseNumber = urlParams.get('houseNumber');
const otp = urlParams.get('otp');

// Build the modified URL with the extracted information
const modifiedLink = `https://kabaritageneralagency.wuaze.com/kabarita/index.php?houseNumber=${houseNumber}&otp=${otp}`;

// Set the modified link as the href of your button or link
document.getElementById('collapse').href = modifiedLink;
</script>
                                 <a   id="generateReportBtn">
    <i class="fas fa-download fa-sm text-white-50"></i>GENERATE REPORT
</a>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>UTILITIES</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">CHANGEPHONENUMBER:</h6>
               <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/updatephoneclient.php">CHANGEPHONE</a>
<a class="collapse-item" id="richi" href="">HISTORY</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the current URL's search parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Get the values you want from the search parameters
        const houseNumber = urlParams.get('houseNumber');
        const otp = urlParams.get('otp');

        // Build the modified URL with the extracted information
        const modifiedLink = `https://kabaritacoltd.000webhostapp.com/kabarita/Searchsingle.php?houseNumber=${houseNumber}&otp=${otp}`;

        // Set the modified link as the href of your button or link
        document.getElementById('richi').href = modifiedLink;
    });
</script>

                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                     
                    </div>
                </div>
            </li>

       

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

         
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                       

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo "$firstName"?> </span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/updatephoneclient.php">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="generateReportBtn">
    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
</a>

<script>
$(document).ready(function() {
    // Attach a click event handler to the "Generate Report" button
    $('#generateReportBtn').click(function(e) {
        e.preventDefault(); // Prevent the default action of the link

        // Get the house number and OTP from the URL
        var houseNumber = getParameterByName('houseNumber');
        var otp = getParameterByName('otp');

        // Check if both parameters are present
        if (houseNumber && otp) {
            // Create a new URL for the download
            var downloadUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/downloadcsv.php?houseNumber=' + houseNumber + '&otp=' + otp;

            // Trigger the download by creating a hidden iframe
            var iframe = $('<iframe>', {
                src: downloadUrl,
                style: 'display:none;'
            }).appendTo('body');

            // Redirect to the original page after a delay (adjust the delay as needed)
            setTimeout(function() {
                window.location.href = 'index.php?houseNumber=' + houseNumber + '&otp=' + otp;
            }, 5000); // 5000 milliseconds (5 seconds) delay in this example
        } else {
            // Handle the case when house number or OTP is not provided
            alert('House number or OTP not provided!');
        }
    });

    // Function to get a parameter value from the URL
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
});
</script>

                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php
// Get the current hour in 24-hour format
date_default_timezone_set('Africa/Nairobi');
$currentHour = date('G');

// Greet based on the time of day
if ($currentHour >= 5 && $currentHour < 12) {
    $greeting = "Good morning 🌄";
} elseif ($currentHour >= 12 && $currentHour < 18) {
    $greeting = "Good afternoon 🌤";
} else {
    $greeting = "Good evening 🌚";
}

// Output the greeting
echo $greeting;
?> <?php echo "$firstName"?>👋🏿 </h1>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<!-- Your content here -->

<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="generateReportBtn">
    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
</a>

<script>
$(document).ready(function() {
    // Attach a click event handler to the "Generate Report" button
    $('#generateReportBtn').click(function(e) {
        e.preventDefault(); // Prevent the default action of the link

        // Get the house number and OTP from the URL
        var houseNumber = getParameterByName('houseNumber');
        var otp = getParameterByName('otp');

        // Check if both parameters are present
        if (houseNumber && otp) {
            // Create a new URL for the download
            var downloadUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/downloadcsv.php?houseNumber=' + houseNumber + '&otp=' + otp;

            // Trigger the download by creating a hidden iframe
            var iframe = $('<iframe>', {
                src: downloadUrl,
                style: 'display:none;'
            }).appendTo('body');

            // Redirect to the original page after a delay (adjust the delay as needed)
            setTimeout(function() {
                window.location.href = 'index.php?houseNumber=' + houseNumber + '&otp=' + otp;
            }, 5000); // 5000 milliseconds (5 seconds) delay in this example
        } else {
            // Handle the case when house number or OTP is not provided
            alert('House number or OTP not provided!');
        }
    });

    // Function to get a parameter value from the URL
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
});
</script>

</body>
</html>

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                ACCOUNT BALANCE</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?PHP echo "$totalAmount"  ?>  KSH</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                YOUR RENT IS </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?PHP echo "$defaultDeposit" ?> KSH</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">payment completion
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?PHP echo "$paymentPercentage" ?>%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width:<?PHP echo "$paymentPercentage"; ?>%" aria-valuenow="50" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<h1 style="text-align: center; color: blue;">
    <strong>TRANSACTION DATA</strong>
</h1>

</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .table-container {
            margin: 20px;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .transaction-table, th, td {
            border: 1px solid #ddd;
            text-align: left;
        }

        th, td {
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        @media only screen and (max-width: 600px) {
            /* Add additional styling for smaller screens if needed */
            .table-container {
                overflow-x: auto; /* Enable horizontal scrolling on small screens */
            }
        }
    </style>
</head>
<body>

<div class="table-container">
<?php
// Include('dbconnection.php');

// Get HouseNumber and OTP from the URL
$houseNumber = $_GET['houseNumber'];
$otp = $_GET['otp'];

// Check if OTP is associated with the provided HouseNumber in login_details
$checkOtpSql = "SELECT HouseNumber FROM login_details WHERE HouseNumber = ? AND otp = ? LIMIT 1";
$otpStmt = $db->prepare($checkOtpSql);

if (!$otpStmt) {
    // Print the error message
    die("Error in preparing OTP statement: " . $db->error);
}

$otpStmt->bind_param("ss", $houseNumber, $otp);
$otpStmt->execute();
$otpResult = $otpStmt->get_result();

if ($otpResult->num_rows > 0) {
    // Fetch rows associated with HouseNumber in transactions table
    $fetchTransactionsSql = "SELECT MerchantRequestID, CheckoutRequestID, Amount, MpesaReceiptNumber, PhoneNumber, HouseNumber, TransTime, BusinessShortCode, FirstName, debt FROM transactions WHERE HouseNumber = ?";
    $fetchTransactionsStmt = $db->prepare($fetchTransactionsSql);

    if (!$fetchTransactionsStmt) {
        // Print the error message
        die("Error in preparing transactions statement: " . $db->error);
    }

    $fetchTransactionsStmt->bind_param("s", $houseNumber);
    $fetchTransactionsStmt->execute();
    $transactionsResult = $fetchTransactionsStmt->get_result();

    // Display the fetched data in a more mobile-friendly format
    echo "<table>";
    echo "<tr><th>Amount</th><th>MpesaReceiptNumber</th><th>PhoneNumber</th><th>HouseNumber</th><th>TransTime</th><th>BusinessShortCode</th><th>FirstName</th><th>debt</th
    ><th>MerchantRequestID</th><th>CheckoutRequestID</th>
    </tr>";

    while ($row = $transactionsResult->fetch_assoc()) {
        echo "<tr>";

        echo "<td>" . $row['Amount'] . "</td>";
        echo "<td>" . $row['MpesaReceiptNumber'] . "</td>";
        echo "<td>" . $row['PhoneNumber'] . "</td>";
        echo "<td>" . $row['HouseNumber'] . "</td>";
        echo "<td>" . $row['TransTime'] . "</td>";
        echo "<td>" . $row['BusinessShortCode'] . "</td>";
        echo "<td>" . $row['FirstName'] . "</td>";
        echo "<td>" . $row['debt'] . "</td>";
                echo "<td>" . $row['MerchantRequestID'] . "</td>";
        echo "<td>" . $row['CheckoutRequestID'] . "</td>";
        
        echo "</tr>";
    }

    echo "</table>";

    // Close the statement
    $fetchTransactionsStmt->close();
} else {
    echo "Invalid OTP for HouseNumber: $houseNumber";
}

// Close connections
$otpStmt->close();
$db->close();
?>
  
</div>

</body>
</html>

                       

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <style>
         .horizontal-bar {
            border-bottom: 2px solid #ccc;
            margin-top: 20px;
        }
  
    </style>
      <div class="horizontal-bar"></div>
</body>

</html>