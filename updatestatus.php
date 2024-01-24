<?php
echo "Connecting to database...\n";

include 'dbconnection.php';

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected!\n";

// Query to get distinct HouseNumbers from transactions and default_deposits tables
$distinctHouseNumbersQuery = "SELECT DISTINCT transactions.HouseNumber FROM transactions JOIN default_deposits ON transactions.HouseNumber = default_deposits.HouseNumber";
echo "Querying for distinct HouseNumbers: $distinctHouseNumbersQuery\n";

$distinctHouseNumbersResult = mysqli_query($db, $distinctHouseNumbersQuery);

if (!$distinctHouseNumbersResult) {
    die("Query failed: " . mysqli_error($db));
}

// Check if there are any distinct HouseNumbers
if (mysqli_num_rows($distinctHouseNumbersResult) > 0) {
    echo "Found distinct HouseNumbers:\n";

    // Loop through each distinct HouseNumber
    while ($row = mysqli_fetch_assoc($distinctHouseNumbersResult)) {
        $houseNumber = $row['HouseNumber'];

        echo "Processing HouseNumber: $houseNumber\n";

        // Query to get total Amount for the HouseNumber from transactions table
        $totalAmountQuery = "SELECT SUM(Amount) AS TotalAmount FROM transactions WHERE transactions.HouseNumber = ?";
        echo "Total Amount query: $totalAmountQuery\n";

        $totalAmountStmt = mysqli_prepare($db, $totalAmountQuery);
        mysqli_stmt_bind_param($totalAmountStmt, 's', $houseNumber);
        mysqli_stmt_execute($totalAmountStmt);

        $totalAmountResult = mysqli_stmt_get_result($totalAmountStmt);

        if (!$totalAmountResult) {
            die("Query failed: " . mysqli_error($db));
        }

        $totalAmountRow = mysqli_fetch_assoc($totalAmountResult);
        $totalAmount = $totalAmountRow['TotalAmount'];

        echo "Total Amount: $totalAmount\n";

        // Query to get DefaultDeposit for the HouseNumber from default_deposits table
        $defaultDepositQuery = "SELECT DefaultDeposit FROM default_deposits WHERE default_deposits.HouseNumber = ?";
        echo "DefaultDeposit query: $defaultDepositQuery\n";

        $defaultDepositStmt = mysqli_prepare($db, $defaultDepositQuery);
        mysqli_stmt_bind_param($defaultDepositStmt, 's', $houseNumber);
        mysqli_stmt_execute($defaultDepositStmt);

        $defaultDepositResult = mysqli_stmt_get_result($defaultDepositStmt);

        if (!$defaultDepositResult) {
            die("Query failed: " . mysqli_error($db));
        }

        $defaultDepositRow = mysqli_fetch_assoc($defaultDepositResult);
        $defaultDeposit = $defaultDepositRow['DefaultDeposit'];

        echo "DefaultDeposit: $defaultDeposit\n";

        // Check if total Amount is lower than DefaultDeposit
        if ($totalAmount >= $defaultDeposit) {
            echo "Total Amount is lower than DefaultDeposit\n";

            // Update status column in transactions table to 1
            $updateStatusQuery = "UPDATE transactions SET status = 1 WHERE transactions.HouseNumber = ?";
            echo "Update status query: $updateStatusQuery\n";

            $updateStatusStmt = mysqli_prepare($db, $updateStatusQuery);
            mysqli_stmt_bind_param($updateStatusStmt, 's', $houseNumber);
            mysqli_stmt_execute($updateStatusStmt);

            if (!$updateStatusStmt) {
                die("Query failed: " . mysqli_error($db));
            }

            echo "Status updated for HouseNumber $houseNumber\n";
        } else {
            echo "Total Amount is not lower than DefaultDeposit\n";
        }
    }
} else {
    echo "No distinct HouseNumbers found\n";
}

mysqli_close($db);
?>
