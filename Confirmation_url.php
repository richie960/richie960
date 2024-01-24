<?php
// Include the database connection file
include 'dbconnection.php';

// Capture the JSON data from the request
$mpesaResponse = file_get_contents('php://input');
$logFile = "C2bPesaResponse.json";
$log = fopen($logFile, "a");
fwrite($log, $mpesaResponse);
fclose($log);

// Decode the JSON data
$data = json_decode($mpesaResponse);

// Extract data from the JSON

$TransactionType = $data->TransactionType;
$TransID = $data->TransID;
$TransTime = $data->TransTime;
$TransAmount = $data->TransAmount;
$BusinessShortCode = $data->BusinessShortCode;
$BillRefNumber = $data->BillRefNumber;
$MSISDN = $data->MSISDN;
$FirstName = $data->FirstName;



// Debug: Output the decoded JSON data for inspection
echo "Debug: Decoded JSON Data:<br>";
echo "TransactionType: " . $TransactionType . "<br>";
echo "TransID: " . $TransID . "<br>";
echo "TransTime: " . $TransTime . "<br>";
echo "TransAmount: " . $TransAmount . "<br>";
echo "BusinessShortCode: " . $BusinessShortCode . "<br>";
echo "BillRefNumber: " . $BillRefNumber . "<br>";
echo "MSISDN: " . $MSISDN . "<br>";
echo "FirstName: " . $FirstName . "<br>";


// Prepare and execute the SQL query
$query = "INSERT INTO transactions (MpesaReceiptNumber, TransTime, Amount, BusinessShortCode, HouseNumber, PhoneNumber, FirstName ) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($db, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssssss", $TransID, $TransTime, $TransAmount, $BusinessShortCode, $BillRefNumber, $MSISDN, $FirstName);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Data inserted successfully
        echo json_encode(array("ResultCode" => 0, "ResultDesc" => "Data Inserted Successfully"));
    } else {
        // Error inserting data
        echo json_encode(array("ResultCode" => 1, "ResultDesc" => "Failed to Insert Data: " . mysqli_error($db)));
    }

    mysqli_stmt_close($stmt);
} else {
    // Error in preparing the statement
    echo json_encode(array("ResultCode" => 1, "ResultDesc" => "Database Error: " . mysqli_error($db)));
}

// Close the database connection
mysqli_close($db);
?>
