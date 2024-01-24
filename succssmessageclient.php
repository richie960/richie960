<?php
// Include the database connection
require 'dbconnection.php';

// Parameters
$partnerID = '8854';
$apikey = '70efa65617bcc559666d74e884c3abb6';
$shortcode = 'Savvy_sms';

// Query to get distinct house numbers with status = 1 and twilosent = 0
$houseNumbersQuery = "SELECT DISTINCT HouseNumber FROM transactions WHERE status = 1 AND twilosent = 0";
$houseNumbersResult = mysqli_query($db, $houseNumbersQuery);

if (!$houseNumbersResult) {
    echo "Error fetching house numbers: " . mysqli_error($db) . "\n";
    mysqli_close($db);
    exit();
}

// Check if there are house numbers that meet the criteria
if (mysqli_num_rows($houseNumbersResult) > 0) {
    while ($row = mysqli_fetch_assoc($houseNumbersResult)) {
        $houseNumber = $row['HouseNumber'];

        // Query to get associated phone numbers and total amount for the current house number
        $phoneNumbersQuery = "SELECT PhoneNumber, FirstName, SUM(Amount) AS TotalAmount FROM transactions WHERE HouseNumber = '$houseNumber' GROUP BY PhoneNumber";
        $phoneNumbersResult = mysqli_query($db, $phoneNumbersQuery);

        if (!$phoneNumbersResult) {
            echo "Error fetching phone numbers: " . mysqli_error($db) . "\n";
            continue;  // Skip to the next house number
        }

        while ($phoneRow = mysqli_fetch_assoc($phoneNumbersResult)) {
            $phoneNumber = $phoneRow['PhoneNumber'];
            $firstName = $phoneRow['FirstName'];
            $totalAmount = $phoneRow['TotalAmount'];

            // Construct the SMS message with the total amount
            $message = "Hey $firstName, Rent has been successfully paid for $houseNumber. Current total amount: $totalAmount.";

            // Construct the URL with parameters
            $url = 'https://sms.savvybulksms.com/api/services/sendsms';
            $url .= '?partnerID=' . urlencode($partnerID);
            $url .= '&mobile=' . urlencode($phoneNumber);
            $url .= '&apikey=' . urlencode($apikey);
            $url .= '&shortcode=' . urlencode($shortcode);
            $url .= '&message=' . urlencode($message);

            // Send SMS by redirecting to the constructed URL
            header("Location: $url");
        }

        // Update twilosent to 1 after sending messages for all associated phone numbers
        $updateTwiloSentQuery = "UPDATE transactions SET twilosent = 1 WHERE HouseNumber = '$houseNumber'";
        mysqli_query($db, $updateTwiloSentQuery);
    }

    echo "All houses are good and messages have been sent.";
} else {
    echo "No houses meet the criteria.";
}

// Close the database connection
mysqli_close($db);
