<?php
// Include the database connection file
include 'dbconnection.php';

// Query to get rows where twilosent is 1 and caretaker is 0
$pendingMessagesQuery = "SELECT HouseNumber, FirstName,Amount, MAX(MpesaReceiptNumber) AS latestMpesaReceipt
                        FROM transactions
                        WHERE twilosent = 1 AND caretaker = 0
                        GROUP BY HouseNumber";
$pendingMessagesResult = mysqli_query($db, $pendingMessagesQuery);

if (!$pendingMessagesResult) {
    die("Error fetching pending messages: " . mysqli_error($db));
}

while ($row = mysqli_fetch_assoc($pendingMessagesResult)) {
    $houseNumber = $row['HouseNumber'];
    $firstName = $row['FirstName'];
    $totalAmount = $row['Amount'];
    $latestMpesaReceipt = $row['latestMpesaReceipt'];

    // Construct the SMS message for the manager with total amount information
    $managerMessage = " Hello Manager, confirm payment for House Number: $houseNumber. Tenant: $firstName.  Amount: $totalAmount. Latest Mpesa Receipt: $latestMpesaReceipt.";

    // Parameters for sending SMS to the manager
    $managerMobile = '254722295457';  // Replace with the actual manager's phone number
    $partnerID = '8854';  // Replace with your SMS provider's partner ID
    $apikey = '70efa65617bcc559666d74e884c3abb6';  // Replace with your SMS provider's API key
    $shortcode = 'Savvy_sms';  // Replace with your SMS provider's shortcode

    // Construct the URL with parameters for sending SMS
    $managerUrl = 'https://sms.savvybulksms.com/api/services/sendsms';
    $managerUrl .= '?partnerID=' . urlencode($partnerID);
    $managerUrl .= '&mobile=' . urlencode($managerMobile);
    $managerUrl .= '&apikey=' . urlencode($apikey);
    $managerUrl .= '&shortcode=' . urlencode($shortcode);
    $managerUrl .= '&message=' . urlencode($managerMessage);

    // Send SMS to the manager by redirecting to the constructed URL
    header("Location: $managerUrl");

    // Update caretaker column to 1 after sending the message
    $updateCaretakerQuery = "UPDATE transactions SET caretaker = 1 WHERE HouseNumber = '$houseNumber'";
    mysqli_query($db, $updateCaretakerQuery);
}

// Close the database connection
mysqli_close($db);
?>
