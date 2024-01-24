<?php
// Include the database connection file
include 'dbconnection.php';

// Start output buffering
ob_start();

// Query to get distinct house numbers from transactions table
$distinctHouseNumbersQuery = "SELECT DISTINCT HouseNumber FROM transactions";
$distinctHouseNumbersResult = mysqli_query($db, $distinctHouseNumbersQuery);

if (!$distinctHouseNumbersResult) {
    die("Error fetching distinct house numbers: " . mysqli_error($db));
}

while ($row = mysqli_fetch_assoc($distinctHouseNumbersResult)) {
    $houseNumber = $row['HouseNumber'];

    // Query to check the status in default_deposits table (case-insensitive)
    $statusQuery = "SELECT Status FROM default_deposits WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
    $statusResult = mysqli_query($db, $statusQuery);

    if (!$statusResult) {
        die("Error fetching status: " . mysqli_error($db));
    }

    // Check if any rows are returned before trying to fetch values
    if (mysqli_num_rows($statusResult) > 0) {
        $statusRow = mysqli_fetch_assoc($statusResult);
        $status = $statusRow['Status'];

        if (strcasecmp($status, 'Occupied') === 0) {
            echo "No new user in transactions for House $houseNumber.\n";
        } else {
            // Query to total the amount for the specific house number
            $totalAmountQuery = "SELECT SUM(Amount) AS totalAmount FROM transactions WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
            $totalAmountResult = mysqli_query($db, $totalAmountQuery);

            if (!$totalAmountResult) {
                die("Error calculating total amount: " . mysqli_error($db));
            }

            $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);
            $totalAmount = $totalAmountRow['totalAmount'];

            // Query to get the default deposit amount for the house number
            $defaultDepositQuery = "SELECT DefaultDeposit FROM default_deposits WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
            $defaultDepositResult = mysqli_query($db, $defaultDepositQuery);

            if (!$defaultDepositResult) {
                die("Error fetching default deposit data: " . mysqli_error($db));
            }

            $defaultDepositRow = mysqli_fetch_assoc($defaultDepositResult);
            $defaultDepositAmount = $defaultDepositRow['DefaultDeposit'];

            // Subtract default deposit from total amount
            $newAmount = $totalAmount - $defaultDepositAmount;

            // Update all rows with the specified HouseNumber to have Amount set to zero
            $updateZeroQuery = "UPDATE transactions SET Amount = 0 WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
            mysqli_query($db, $updateZeroQuery);

            // Update one row with the subtracted amount
            $updateNewAmountQuery = "UPDATE transactions SET Amount = $newAmount WHERE LOWER(HouseNumber) = LOWER('$houseNumber') LIMIT 1";
            mysqli_query($db, $updateNewAmountQuery);

            // Update status in default_deposits table
            $updateStatusQuery = "UPDATE default_deposits SET Status = 'Occupied' WHERE HouseNumber = '$houseNumber'";
            mysqli_query($db, $updateStatusQuery);

            // Send SMS to the manager using the header function
            $managerMessage = "New user detected in House $houseNumber. Total Amount: $totalAmount. Default Deposit: $defaultDepositAmount.";

            $managerMobile = '254722295457';  // Replace with the actual manager's phone number
            $partnerID = '8854';  // Replace with your SMS provider's partner ID
            $apikey = '70efa65617bcc559666d74e884c3abb6';  // Replace with your SMS provider's API key
            $shortcode = 'Savvy_sms';  // Replace with your SMS provider's shortcode

            // Construct the URL with parameters
            $managerUrl = 'https://sms.savvybulksms.com/api/services/sendsms';
            $managerUrl .= '?partnerID=' . urlencode($partnerID);
            $managerUrl .= '&mobile=' . urlencode($managerMobile);
            $managerUrl .= '&apikey=' . urlencode($apikey);
            $managerUrl .= '&shortcode=' . urlencode($shortcode);
            $managerUrl .= '&message=' . urlencode($managerMessage);

            // Redirect to the constructed URL
        }
    } else {
        echo "No data found for House $houseNumber.\n";
    }
}

// Redirect outside the loop
header("Location: $managerUrl");
exit; // Ensure that no further code is executed after the redirect

// End output buffering and flush
ob_end_flush();

// Close the database connection
mysqli_close($db);
?>
