<?php
// Get the house number and OTP from the URL
$houseNumber = isset($_GET['houseNumber']) ? $_GET['houseNumber'] : null;
$otp = isset($_GET['otp']) ? $_GET['otp'] : null;

if (!$houseNumber || !$otp) {
    die('House number or OTP not provided.');
}

// Include database connection
include 'dbconnection.php';

try {
    // Perform a SQL query to retrieve information from the transactions table
    $query = "SELECT Amount, MpesaReceiptNumber, PhoneNumber, TransTime
              FROM transactions
              WHERE HouseNumber = ?";

    // Prepare the SQL statement
    $statement = $db->prepare($query);

    if (!$statement) {
        die('Error in preparing the SQL statement: ' . mysqli_error($db));
    }

    // Bind the parameter
    $result = $statement->bind_param('s', $houseNumber);

    if (!$result) {
        die('Error in binding parameters: ' . mysqli_error($db));
    }

    // Execute the query
    $result = $statement->execute();

    if (!$result) {
        die('Error in executing the SQL statement: ' . mysqli_error($db));
    }

    // Fetch the result
    $result = $statement->get_result();

    // Check if a result is found
    if ($result->num_rows > 0) {
        // Create CSV file content
        $csvContent = "Amount,MpesaReceiptNumber,PhoneNumber,TransTime\n";

        // Loop through the result set and append each row to the CSV content
        while ($row = $result->fetch_assoc()) {
            $csvContent .= "{$row['Amount']},{$row['MpesaReceiptNumber']},{$row['PhoneNumber']},{$row['TransTime']}\n";
        }

        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="report.csv"');

        // Output the CSV content
        echo $csvContent;

        // Exit to prevent further output
        exit;
    } else {
        // Handle the case when no transactions are found
        echo "No transactions found for house number: " . $houseNumber;
    }
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
} finally {
    // Close the database connection
    $db->close();
}
?>
