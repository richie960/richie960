<?php
include 'dbconnection.php';

// Get the list of distinct house numbers from the database
$houseNumbersQuery = "SELECT DISTINCT HouseNumber FROM transactions";
$houseNumbersResult = mysqli_query($db, $houseNumbersQuery);

if (!$houseNumbersResult) {
    echo "Error fetching house numbers: " . mysqli_error($db) . "\n";
    mysqli_close($db);
    exit();
}

while ($row = mysqli_fetch_assoc($houseNumbersResult)) {
    $houseNumber = $row['HouseNumber'];

    // Calculate the total amount for the house number
    $totalAmountQuery = "SELECT SUM(Amount) AS TotalAmount FROM transactions WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
    $totalAmountResult = mysqli_query($db, $totalAmountQuery);

    if (!$totalAmountResult) {
        echo "Error calculating total amount: " . mysqli_error($db) . "\n";
        continue; // Move to the next house number
    }

    $amountRow = mysqli_fetch_assoc($totalAmountResult);
    $totalAmount = $amountRow['TotalAmount'];

    // Search for the house number in the default deposit table
    $defaultQuery = "SELECT * FROM default_deposits WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
    $defaultResult = mysqli_query($db, $defaultQuery);

    if (!$defaultResult) {
        echo "Error searching default deposit: " . mysqli_error($db) . "\n";
        continue; // Move to the next house number
    }

    if (mysqli_num_rows($defaultResult) > 0) {
        $defaultRow = mysqli_fetch_assoc($defaultResult);
        $defaultDeposit = $defaultRow['DefaultDeposit'];

        // Subtract the default deposit from the total amount
        $updatedAmount = $totalAmount - $defaultDeposit;

        // Update the amount to zero for the rest of the rows
        $updateZeroAmountQuery = "UPDATE transactions SET Amount = 0 WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
        mysqli_query($db, $updateZeroAmountQuery);

        // Update the amount in the transactions table for all rows
        $updateAmountQuery = "UPDATE transactions SET Amount = $updatedAmount WHERE LOWER(HouseNumber) = LOWER('$houseNumber') LIMIT 1";
        mysqli_query($db, $updateAmountQuery);

        // Update the status column to zero for all rows
        $updateStatusQuery = "UPDATE transactions SET Status = 0 WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
        mysqli_query($db, $updateStatusQuery);

        // Update the twilosent column to zero for all rows
        $updateTwiloSentQuery = "UPDATE transactions SET twilosent = 0 WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
        mysqli_query($db, $updateTwiloSentQuery);

        // Update the remaining columns for all rows
        $updateRemainingColumnsQuery = "UPDATE transactions SET debt = 0, caretaker = 0, messageSent = 0 WHERE LOWER(HouseNumber) = LOWER('$houseNumber')";
        mysqli_query($db, $updateRemainingColumnsQuery);

        echo "Updated amount and status for House $houseNumber: $updatedAmount\n";
    }
}

// Close the database connection
mysqli_close($db);
?>
