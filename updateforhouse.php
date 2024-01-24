<?php
// Assuming you have a database connection established
// $db = new mysqli("hostname", "username", "password", "database");
include 'dbconnection.php';
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check for rows with NULL HouseNumber in transactions table
$checkTransactionsSql = "SELECT ID, PhoneNumber FROM transactions WHERE HouseNumber IS NULL";
$checkTransactionsResult = $db->query($checkTransactionsSql);

if (!$checkTransactionsResult) {
    // Handle the error, e.g., display an error message or log the error
    die("Error in checking transactions table: " . $db->error);
}

while ($row = $checkTransactionsResult->fetch_assoc()) {
    $phoneNumber = $row['PhoneNumber'];
    $transactionID = $row['ID'];

    // Search for the PhoneNumber in login_details table
    $getHouseNumberSql = "SELECT HouseNumber FROM login_details WHERE PhoneNumber = ? LIMIT 1";
    $getHouseNumberStmt = $db->prepare($getHouseNumberSql);

    if (!$getHouseNumberStmt) {
        // Handle the error, e.g., display an error message or log the error
        die("Error in preparing getHouseNumber statement: " . $db->error);
    }

    $getHouseNumberStmt->bind_param("s", $phoneNumber);
    $getHouseNumberStmt->execute();
    $getHouseNumberStmt->bind_result($houseNumber);

    // If PhoneNumber exists in login_details
    if ($getHouseNumberStmt->fetch()) {
        // Close the result set before preparing the next statement
        $getHouseNumberStmt->close();

        // Update HouseNumber in transactions
        $updateHouseNumberSql = "UPDATE transactions SET HouseNumber = ? WHERE ID = ?";
        $updateHouseNumberStmt = $db->prepare($updateHouseNumberSql);

        if (!$updateHouseNumberStmt) {
            // Handle the error, e.g., display an error message or log the error
            die("Error in preparing updateHouseNumber statement: " . $db->error);
        }

        $updateHouseNumberStmt->bind_param("si", $houseNumber, $transactionID);
        $updateHouseNumberStmt->execute();

        echo "HouseNumber updated successfully for Transaction ID: $transactionID";
    } else {
        echo "No HouseNumber found in login_details for PhoneNumber: $phoneNumber.";
    }
}

// Close the result set after the loop
$checkTransactionsResult->close();

// Close the database connection
$db->close();
?>
