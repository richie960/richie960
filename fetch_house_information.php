<?php
include 'dbconnection.php';

try {
    // Fetch all unique house numbers from the transactions table
    $houseNumberQuery = "SELECT DISTINCT HouseNumber FROM transactions";
    $houseNumberResult = mysqli_query($db, $houseNumberQuery);

    // Check for errors in the query
    if (!$houseNumberResult) {
        throw new Exception(mysqli_error($db));
    }

    // Fetch all house numbers into an array
    $houseNumbers = [];
    while ($row = mysqli_fetch_assoc($houseNumberResult)) {
        $houseNumbers[] = $row['HouseNumber'];
    }

    // Initialize an empty array to store the data
    $data = [];

    // Iterate through each house number
    foreach ($houseNumbers as $houseNumber) {
        // Fetch the total amount for the current house number where debt is equal to 1
        $totalAmountQuery = "SELECT HouseNumber, SUM(Amount) as TotalAmount FROM transactions 
                             WHERE HouseNumber = '$houseNumber' AND debt = 1
                             GROUP BY HouseNumber";
        $totalAmountResult = mysqli_query($db, $totalAmountQuery);

        // Check for errors in the query
        if (!$totalAmountResult) {
            throw new Exception(mysqli_error($db));
        }

        $result = mysqli_fetch_assoc($totalAmountResult);

        if ($result) {
            $totalAmount = $result['TotalAmount'];

            // Check if 1 is in default_deposits table
            $defaultDepositQuery = "SELECT DefaultDeposit FROM default_deposits
                                    WHERE HouseNumber = '$houseNumber'";
            $defaultDepositResult = mysqli_query($db, $defaultDepositQuery);

            // Check for errors in the query
            if (!$defaultDepositResult) {
                throw new Exception(mysqli_error($db));
            }

            $defaultDepositResult = mysqli_fetch_assoc($defaultDepositResult);

            if ($defaultDepositResult) {
                $remainingAmount = $defaultDepositResult['DefaultDeposit'] - $totalAmount;

                // Add the data to the array
                $data[] = [
                    'houseNumber' => $houseNumber,
                    'Amount' => $totalAmount,
                    'remainingAmount' => $remainingAmount
                ];
            } else {
                $data[] = ['error' => "House Number $houseNumber does not have DefaultDeposit in default_deposits table."];
            }
        } else {
            // $data[] = ['error' => "No records found for House Number $houseNumber in Transactions table."];
        }
    }

    // Output the data as JSON
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>
