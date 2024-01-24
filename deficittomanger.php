<?php
// Include the database connection file
include 'dbconnection.php';

// Start output buffering
ob_start();

// Function to send SMS using cURL
function sendSMS($url) {
    $ch = curl_init($url);
    curl_exec($ch);
    curl_close($ch);
}

// Query to get distinct house numbers from transactions table
$distinctHouseNumbersQuery = "SELECT DISTINCT HouseNumber FROM transactions";
$distinctHouseNumbersResult = mysqli_query($db, $distinctHouseNumbersQuery);

if (!$distinctHouseNumbersResult) {
    die("Error fetching distinct house numbers: " . mysqli_error($db));
}

while ($row = mysqli_fetch_assoc($distinctHouseNumbersResult)) {
    $houseNumber = $row['HouseNumber'];

    // Query to check the status in default_deposits table
    $statusQuery = "SELECT Status, DefaultDeposit FROM default_deposits WHERE HouseNumber = '$houseNumber'";
    $statusResult = mysqli_query($db, $statusQuery);

    if (!$statusResult) {
        die("Error fetching status: " . mysqli_error($db));
    }

    $statusRow = mysqli_fetch_assoc($statusResult);
    $status = $statusRow['Status'];
    $defaultDeposit = $statusRow['DefaultDeposit'];

    // Query to check if SMS has already been sent for this house number
    $smsSentQuery = "SELECT Smssent FROM transactions WHERE HouseNumber = '$houseNumber' LIMIT 1";
    $smsSentResult = mysqli_query($db, $smsSentQuery);

    if (!$smsSentResult) {
        die("Error fetching SMS sent status: " . mysqli_error($db));
    }

    $smsSentRow = mysqli_fetch_assoc($smsSentResult);
    $smsSent = $smsSentRow['Smssent'];

    // Query to total the amount for the specific house number
    $totalAmountQuery = "SELECT SUM(Amount) AS totalAmount FROM transactions WHERE HouseNumber = '$houseNumber'";
    $totalAmountResult = mysqli_query($db, $totalAmountQuery);

    if (!$totalAmountResult) {
        die("Error calculating total amount: " . mysqli_error($db));
    }

    $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);
    $totalAmount = $totalAmountRow['totalAmount'];

    // Compare total amount with the default deposit and check if SMS has not been sent
    if ($status == 'Occupied' && $totalAmount < $defaultDeposit && $smsSent == 0) {
        // Send message to the caretaker
        $caretakerMessage = "Please check House $houseNumber. Total Amount: $totalAmount. Payment needed: " . ($defaultDeposit - $totalAmount);

        // Parameters for sending SMS to the caretaker
        $caretakerMobile = '254722295457';  // Replace with the actual caretaker's phone number
        $partnerID = '8854';  // Replace with your SMS provider's partner ID
        $apikey = '70efa65617bcc559666d74e884c3abb6';  // Replace with your SMS provider's API key
        $shortcode = 'Savvy_sms';  // Replace with your SMS provider's shortcode

        // Construct the URL with parameters for sending SMS
        $caretakerUrl = 'https://sms.savvybulksms.com/api/services/sendsms';
        $caretakerUrl .= '?partnerID=' . urlencode($partnerID);
        $caretakerUrl .= '&mobile=' . urlencode($caretakerMobile);
        $caretakerUrl .= '&apikey=' . urlencode($apikey);
        $caretakerUrl .= '&shortcode=' . urlencode($shortcode);
        $caretakerUrl .= '&message=' . urlencode($caretakerMessage);

        // Update the transactions table to mark the SMS as sent
        $updateSMSSentQuery = "UPDATE transactions SET Smssent = 1 WHERE HouseNumber = '$houseNumber'";
        mysqli_query($db, $updateSMSSentQuery);

        // Send the SMS using cURL
        sendSMS($caretakerUrl);

        echo "SMS sent for House $houseNumber.\n";
    } else {
        echo "No action needed for House $houseNumber.\n";
    }
}

// Close the database connection
mysqli_close($db);

// End output buffering
ob_end_flush();
?>
