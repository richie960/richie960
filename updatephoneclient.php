<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Update Phone Number</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container-fluid {
            padding: 50px;
        }

        .bg-login-image {
            background-image: url('your-background-image.jpg'); /* Replace 'your-background-image.jpg' with your image path */
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .text-gray-900 {
            color: #343a40;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control-user,
        .btn-user {
            border-radius: 30px;
            padding: 15px;
            font-size: 16px;
        }

        .btn-user {
            background-color: #4e73df;
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn-user:hover {
            background-color: #2e59d9;
        }

        @media (max-width: 768px) {
            .bg-login-image {
                display: none;
            }

            .col-lg-6 {
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container-fluid">

        <div class="row justify-content-center">

            <div class="col-xl-8 col-lg-10 col-md-9">

                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Update Phone Number</h1>
                    </div>
                    <!-- HTML Form -->
                    <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <input type="text" class="form-control-user" name="houseNumber" placeholder="Enter House Number" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-user" name="oldPhoneNumber" placeholder="Enter Old Phone Number" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-user" name="newPhoneNumber" placeholder="Enter New Phone Number" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control-user" name="otp" placeholder="Enter last otp you were sent" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Update Phone Number
                        </button>
                    </form>
                    <!-- End of HTML Form -->
                </div>

            </div>

        </div>

    </div>

    <!-- Add your script tags and other body elements here -->

</body>

</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

    <!-- Your existing styles and scripts -->

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px; /* Add padding for better visual */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        button {
            background-color: #3498db; /* Blue color */
            color: #ffffff; /* White text color */
            padding: 15px 20px; /* Adjust padding for better visual */
            font-size: 16px; /* Font size */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            margin-top: 20px; /* Add margin to separate button from page content */
        }

        button:hover {
            background-color: #2980b9; /* Darker blue on hover */
        }

        .arrow {
            margin-right: 5px; /* Space between arrow and text */
        }
    </style>
</head>
<body>

    <!-- Your existing page content -->

    <div>
        <!-- Your existing content goes here -->

    </div>

    <script>
        function goBack() {
            // Use the history object to navigate back
            window.history.back();
        }
    </script>

    <!-- Button container -->
    <div>
        <button onclick="goBack()">
            <span class="arrow">&#8592;</span> Go Back
        </button>
    </div>

</body>
</html>

<!-- Rest of your HTML code -->


<?php
// Assuming you have a database connection established
// $db = new mysqli("hostname", "username", "password", "database");
include 'dbconnection.php';

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $houseNumber = $_POST["houseNumber"];
    $oldPhoneNumber = $_POST["oldPhoneNumber"];
    $newPhoneNumber = $_POST["newPhoneNumber"];
    $otp = $_POST["otp"];

    // Transform oldPhoneNumber and newPhoneNumber
    $oldPhoneNumber = preg_replace('/^0/', '254', $oldPhoneNumber);
    $newPhoneNumber = preg_replace('/^0/', '254', $newPhoneNumber);

    // Call the function to update PhoneNumber
    updatePhoneNumber($houseNumber, $oldPhoneNumber, $newPhoneNumber, $otp, $db);
}

// Function to update PhoneNumber
function updatePhoneNumber($houseNumber, $oldPhoneNumber, $newPhoneNumber, $otp, $db) {
    // Check if HouseNumber exists in login_details table
    $checkHouseNumberSql = "SELECT otp FROM login_details WHERE HouseNumber = ? LIMIT 1";
    $checkHouseNumberStmt = $db->prepare($checkHouseNumberSql);

    if (!$checkHouseNumberStmt) {
        die("Error in preparing checkHouseNumber statement: " . $db->error);
    }

    $checkHouseNumberStmt->bind_param("s", $houseNumber);
    $checkHouseNumberStmt->execute();
    $checkHouseNumberStmt->bind_result($storedOtp);
    $checkHouseNumberStmt->fetch();
    $checkHouseNumberStmt->close();

    // Verify if the provided OTP matches the stored OTP for the HouseNumber
    if ($otp === $storedOtp) {
        // Check if old PhoneNumber matches the one already stored
        $checkOldPhoneNumberSql = "SELECT PhoneNumber FROM login_details WHERE HouseNumber = ? LIMIT 1";
        $checkOldPhoneNumberStmt = $db->prepare($checkOldPhoneNumberSql);

        if (!$checkOldPhoneNumberStmt) {
            die("Error in preparing checkOldPhoneNumber statement: " . $db->error);
        }

        $checkOldPhoneNumberStmt->bind_param("s", $houseNumber);
        $checkOldPhoneNumberStmt->execute();
        $checkOldPhoneNumberStmt->bind_result($storedOldPhoneNumber);
        $checkOldPhoneNumberStmt->fetch();
        $checkOldPhoneNumberStmt->close();

        // Verify if the provided old PhoneNumber matches the stored old PhoneNumber
        if ($oldPhoneNumber === $storedOldPhoneNumber) {
            // Update PhoneNumber in login_details
            $updatePhoneNumberSql = "UPDATE login_details SET PhoneNumber = ? WHERE HouseNumber = ?";
            $updatePhoneNumberStmt = $db->prepare($updatePhoneNumberSql);

            if (!$updatePhoneNumberStmt) {
                die("Error in preparing updatePhoneNumber statement: " . $db->error);
            }

            $updatePhoneNumberStmt->bind_param("ss", $newPhoneNumber, $houseNumber);
            $updatePhoneNumberStmt->execute();
            $updatePhoneNumberStmt->close();

            echo "PhoneNumber updated successfully for HouseNumber: $houseNumber";
        } else {
            echo "Old PhoneNumber does not match the one already stored for HouseNumber: $houseNumber";
        }
    } else {
        echo "Invalid OTP for HouseNumber: $houseNumber";
    }
}
?>



