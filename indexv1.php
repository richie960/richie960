<?php

// Function to get the visitor's IP address
function getVisitorIP() {
    $ip = $_SERVER['REMOTE_ADDR'];

    // If you are using a proxy or load balancer, use the following code to get the real IP
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return $ip;
}

// Function to save IP address to a file
function saveIPToFile($ip) {
    $filename = 'ip_addresses.txt';
    $file = fopen($filename, 'a');
    fwrite($file, $ip . PHP_EOL);
    fclose($file);
}

// Function to read and count unique IP addresses from the file
function countUniqueIPs() {
    $filename = 'ip_addresses.txt';
    if (file_exists($filename)) {
        $ipAddresses = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $uniqueIPs = array_unique($ipAddresses);
        $totalUniqueIPs = count($uniqueIPs);

        return $totalUniqueIPs;
    } else {
        return 0;
    }
}

// Main logic
$visitorIP = getVisitorIP();
saveIPToFile($visitorIP);
$totalUniqueIPs = countUniqueIPs();

// Flagging new user
$newUserMessage = "";
if (in_array($visitorIP, file('ip_addresses.txt', FILE_IGNORE_NEW_LINES))) {
    $newUserMessage = "Welcome back!";
} else {
    $newUserMessage = "Welcome, new user!";
}

?><?php

include 'dbconnection.php';

if ($db
    ->connect_error) {
    die("Connection failed: " . $db
    ->connect_error);
}

// SQL query to calculate the total amount
$sql = "SELECT SUM(Amount) as totalAmount FROM transactions";

$result = $db
->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalEarnings = $row["totalAmount"];
} else {
    $totalEarnings = 0;
}

//$db->close();



// Assume your database table is named default_deposits
$tableName = "default_deposits";

// Query to fetch and sum DefaultDeposit for occupied houses (case-insensitive)
$query = "SELECT SUM(DefaultDeposit) AS totalDeposit FROM $tableName WHERE LOWER(status) = 'Occupied'";

// Perform the query
$result = $db->query($query);

// Check for query execution errors
if ($result === false) {
    echo "Error executing the query: " . $db->error;
} else {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Check if the result is not empty
    if ($row !== null) {
        // Get the total deposit
        $totalDeposit1 = $row['totalDeposit'];

        // Output the result
        //echo "Total DefaultDeposit for occupied houses: $totalDeposit";

        // Close the result set
        $result->close();
    } else {
        // Handle the case where the query returned no results
        echo "No results found for the query.";
    }
}

// Close the database connection
$db->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">


    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard

                    </span></a>
                    
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
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">CUSTOM COMPONENTS:</h6>
                        <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/SERACH.php">UPDATEHOUSENUMBER</a>
         <a class="collapse-item" href="  https://kabaritacoltd.000webhostapp.com/kabarita/addphone.php">REGISTER CUSTOMER</a>
<a class="collapse-item" href="  https://kabaritacoltd.000webhostapp.com/kabarita/Searchtxt.php">SEARCH RECEIPTS</a>
                    <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/seachforpaid.php">CHECK STATUS</a> 
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">CUSTOM UTILITIES:</h6>
                        <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/edittransactions.php">TRANSACTION DATA</a>
                        <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt" download>DOWNLOAD RECIEPTS</a>
                        <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/vacaanthousedelete.php">MAKE A HOUSE VACANT</a>
                        <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/Searchhousetogetnumber.php">CALL A CUSTOMER</a>
                              <a class="collapse-item" href="https://kabaritacoltd.000webhostapp.com/kabarita/Adminnum.php">UPDATEPHONE</a>      
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

            <!-- Sidebar Message -->
        
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

                   

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">admin</span>
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
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
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
                        <h1 class="h3 mb-0 text-gray-800"> <?php
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
?> Shaban!👋🏿 </h1>
                        <a href="https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt" download class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
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
                                                Earnings (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">KSH <?php echo $totalEarnings ?>
                                                </div>
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
                                                    Monthly Target</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">KSH <?PHP echo $totalDeposit1 ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php $rich=$totalDeposit1-$totalEarnings;
$mega=$totalEarnings/$totalDeposit1*100 ;

?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">payments by paybill
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $mega ?>%</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: <?php echo $mega ?>%" aria-valuenow="50" aria-valuemin="0"
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

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Remaing Amount</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">KSH <?php echo $totalDeposit1-$totalEarnings ?> </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                            


 
                                    </div>
                                </div>
                            </div>
                        </div>
  <style>
        .date-range {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
        }
        .date-label {
            font-weight: bold;
        }
        .date-range span {
            margin-right:-5px; /* Increase the margin for spacing */
        }
    </style>
</head>
<body>
    
    <div class="date-range">
        <?php
        // Specify the URL of the text file
        $fileUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt';

        // Fetch the contents of the file from the URL
        $fileContent = file_get_contents($fileUrl);

        // Initialize variables to track the first and last dates
        $firstDate = null;
        $lastDate = null;

        // Split the file content into lines
        $lines = explode("\n", $fileContent);

        foreach ($lines as $line) {
            // Match lines with a date format (e.g., "YYYY-MM-DD HH:MM:SS")
            if (preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $line, $matches)) {
                $date = $matches[0];

                // Initialize the first date if it hasn't been set
                if ($firstDate === null) {
                    $firstDate = $date;
                }

                // Update the last date for each matched line
                $lastDate = $date;
            }
        }

        // Convert the first and last dates to month names
        $startMonthName = date('M', strtotime($firstDate));
        $endMonthName = date('M', strtotime($lastDate));

        // Display the date range horizontally with month names
        echo "<span class='date-label'>$startMonthName:</span> $firstDate";
        echo "<span class='date-label'>$endMonthName:</span> $lastDate";
  
        ?>
    </div>


    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
 
    <div style="width: auto; margin: 0 auto;">
        <canvas id="transactionChart"></canvas>
    </div>


 <script>
    // Create a bar graph using Chart.js
    var ctx = document.getElementById('transactionChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($monthlyAmounts)); ?>,
            datasets: [{
                label: 'Total Amount',
                data: <?php echo json_encode(array_values($monthlyAmounts)); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                borderColor: 'rgba(75, 192, 192, 1)', // Border color
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Amount'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
</script>

   
  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .date-range {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .date-label {
            font-weight: bold;
        }
        #chart-container {
            width: auto;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="date-range">
       
    </div>

 

   
    <?php
    // Specify the URL of the text file
    $fileUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt';

    // Fetch the contents of the file from the URL
    $fileContent = file_get_contents($fileUrl);

    // Define an array to store the amounts for each month
    $monthlyAmounts = [];

    // Split the file content into lines
    $lines = explode("\n", $fileContent);

    foreach ($lines as $line) {
        // Check if the line contains "Amount:"
        if (strpos($line, 'Amount:') !== false) {
            // Extract the amount value (assuming it's in the format "Amount: X.XX")
            $amount = (float)str_replace("Amount: ", "", $line);

            // Extract the year, month, and date using string manipulation
            $year = substr($line, 0, 4);
            $month = substr($line, 5, 2);
            $date = substr($line, 8, 2);
            
            // Combine year, month, and date to form YYYY-MM
            $formattedDate = "$year-$month-$date";

            // Debugging: Display the formatted date
          //  echo "Formatted Date: $formattedDate<br>";

            // Add the amount to the corresponding month in the array
            if (!isset($monthlyAmounts[$formattedDate])) {
                $monthlyAmounts[$formattedDate] = 0;
            }
            $monthlyAmounts[$formattedDate] += $amount;
                
        }
    }
    $formattedDates = array_map(function ($date) {
    return date('M d, Y', strtotime($date));
}, array_keys($monthlyAmounts));
    ?>
    

    <script>
        // Create a bar graph using Chart.js
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($monthlyAmounts)); ?>,
                datasets: [{
                    label: 'Total Amount',
                    data: <?php echo json_encode(array_values($monthlyAmounts)); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                    borderColor: 'rgba(75, 192, 192, 1)', // Border color
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Amount'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        });
    </script>
    
                     <h6 >  Revenue Sources</h6>
                 
                                  
          
    
</body>
</html>

                                   
                        <!-- Pie Chart -->
        <!-- index.php -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="houseChart" width="100" height="100"></canvas>
    <script>
        <?php
        // PHP code
        // Include the database connection file
     include 'dbconnection.php';
        // Query to get the count of occupied and vacant houses
        $query = "SELECT COUNT(*) AS count, Status FROM default_deposits GROUP BY Status";
        $result = mysqli_query($db, $query);

        if (!$result) {
            die("Error fetching data: " . mysqli_error($db));
        }

        // Initialize variables
        $occupied = 0;
        $vacant = 0;

        // Process the query result
        while ($row = mysqli_fetch_assoc($result)) {
            $status = strtolower($row['Status']);
            if ($status === 'occupied') {
                $occupied = $row['count'];
            } elseif ($status === 'vacant') {
                $vacant = $row['count'];
            }
        }

        // Close the database connection
        mysqli_close($db);
        ?>

        // JavaScript code
        // Create a pie chart
        var ctx = document.getElementById('houseChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Occupied', 'Vacant'],
                datasets: [{
                    data: [<?php echo $occupied; ?>, <?php echo $vacant; ?>],
                    backgroundColor: ['#FF6384', '#36A2EB'],
                }],
            },
        });
    </script>
</body>
</html>

            <!-- End of Main Content -->
<?php
$url = "https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/js/demo/server.php";
$content = file_get_contents($url);

echo $content;
?>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; kabarita general agency</span>
                    </div>
                </div>
            </footer>
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

</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitor Recognition</title>
   
<style>
    .red-box {
        background-color: #ff0000;
        color: #ffffff;
        padding: 10px;
        text-align: center;
        position: fixed;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        z-index: 999;
        opacity: 1;
        transition: opacity 2s ease-in-out;
    }
</style>

<script>
    // Function to fade out the red box after 5 seconds
    setTimeout(function() {
        document.getElementById("red-box").style.opacity = 0;
    }, 5000);
</script>

<div id="red-box" class="red-box">
    <p><?php echo $newUserMessage; ?></p>
    <p>Your IP address: <?php echo $visitorIP; ?></p>
    <p>Total unique visitors: <?php echo $totalUniqueIPs; ?></p>
</div>

</body>
</html>