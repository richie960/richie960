<?php
// Include the database connection file
include 'dbconnection.php';

// Start output buffering
ob_start();

// Parameters
$partnerID = '8854';
$apikey = '70efa65617bcc559666d74e884c3abb6';
$shortcode = 'Savvy_sms';

// Query to get distinct house numbers with total amount (including both positive and negative amounts)
$houseNumbersQuery = "SELECT DISTINCT HouseNumber FROM transactions";
$houseNumbersResult = mysqli_query($db, $houseNumbersQuery);

if (!$houseNumbersResult) {
    die("Error fetching house numbers: " . mysqli_error($db));
}

while ($row = mysqli_fetch_assoc($houseNumbersResult)) {
    $houseNumber = $row['HouseNumber'];

    // Query to get the total amount for the specific house number
    $totalAmountQuery = "SELECT SUM(Amount) AS TotalAmount FROM transactions WHERE HouseNumber = '$houseNumber'";
    $totalAmountResult = mysqli_query($db, $totalAmountQuery);

    if (!$totalAmountResult) {
        echo "Error calculating total amount: " . mysqli_error($db) . "\n";
        continue;  // Skip to the next house number
    }

    $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);
    $totalAmount = $totalAmountRow['TotalAmount'];

    // Query to check if there is a new row for this house number with debt not filled
    $newRowQuery = "SELECT COUNT(*) AS RowCount FROM transactions WHERE HouseNumber = '$houseNumber' AND debt = 0";
    $newRowResult = mysqli_query($db, $newRowQuery);

    if (!$newRowResult) {
        echo "Error checking for new row: " . mysqli_error($db) . "\n";
        continue;  // Skip to the next house number
    }

    $newRowRow = mysqli_fetch_assoc($newRowResult);
    $rowCount = $newRowRow['RowCount'];

    if ($rowCount > 0) {
        // Query to get associated phone numbers for the current house number
        $phoneNumbersQuery = "SELECT PhoneNumber, FirstName FROM transactions WHERE HouseNumber = '$houseNumber' AND debt = 0";
        $phoneNumbersResult = mysqli_query($db, $phoneNumbersQuery);

        if (!$phoneNumbersResult) {
            echo "Error fetching phone numbers: " . mysqli_error($db) . "\n";
            continue;  // Skip to the next house number
        }

        while ($phoneRow = mysqli_fetch_assoc($phoneNumbersResult)) {
            $phoneNumber = $phoneRow['PhoneNumber'];
            $firstName = $phoneRow['FirstName'];

            // Query to get the default deposit amount for the house number
            $defaultDepositQuery = "SELECT DefaultDeposit FROM default_deposits WHERE HouseNumber = '$houseNumber'";
            $defaultDepositResult = mysqli_query($db, $defaultDepositQuery);

            if (!$defaultDepositResult) {
                echo "Error fetching default deposit data: " . mysqli_error($db) . "\n";
                continue;  // Skip to the next house number
            }

            $defaultDepositRow = mysqli_fetch_assoc($defaultDepositResult);

            // Check if the result is not null before accessing offset
            if ($defaultDepositRow !== null) {
                $defaultDepositAmount = $defaultDepositRow['DefaultDeposit'];

                // Check if total amount is below the default deposit
                if ($totalAmount < $defaultDepositAmount) {
                    // Construct the SMS message with the amount being compared
                    $message = "Hey $firstName, Rent payment reminder for House $houseNumber. Your current demanded   total amount is deficited at $totalAmount. Your rent is $defaultDepositAmount. Please pay to avoid inconvenience.";

                    // Construct the URL with parameters
                    $url = 'https://sms.savvybulksms.com/api/services/sendsms';
                    $url .= '?partnerID=' . urlencode($partnerID);
                    $url .= '&mobile=' . urlencode($phoneNumber);
                    $url .= '&apikey=' . urlencode($apikey);
                    $url .= '&shortcode=' . urlencode($shortcode);
                    $url .= '&message=' . urlencode($message);

                    // Send SMS by redirecting to the constructed URL
                    header("Location: $url");

                    // Update debt to 1 after sending messages for all associated phone numbers
                    $updateDebtQuery = "UPDATE transactions SET debt = 1 WHERE HouseNumber = '$houseNumber' AND debt = 0";
                    mysqli_query($db, $updateDebtQuery);

                    exit; // Ensure that no further code is executed after the redirect
                } else {
                    //   echo "Total amount is not below the default deposit for House $houseNumber.\n";
                }
            }
        }
    } else {
        // echo "No new row for House $houseNumber.\n";
    }
}

// Close the output buffer
ob_flush();

// Close the database connection
mysqli_close($db);
?>
