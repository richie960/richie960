<?php
include 'dbconnection.php'; // Include your database connection here

$query = "SELECT * FROM transactions";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

// Specify the directory where you want to save the file
$directory = "saveddata"; // Replace with the actual directory path
$filename = $directory . "/transactions_data.txt";

if (file_exists($filename)) {
    $existingData = file_get_contents($filename); // Read existing data
} else {
    $existingData = ''; // Initialize as an empty string
}

$file = fopen($filename, "a"); // Append mode

while ($row = mysqli_fetch_assoc($result)) {
    $transactionID = $row['MpesaReceiptNumber'];
    
    // Check if the transaction ID already exists in the file and the record has MpesaReceiptNumber
    if (strpos($existingData, $transactionID) === false && !empty($transactionID)) {
      
        $line = "Transaction ID: {$transactionID}\n";
        $line .= "Phone Number: {$row['PhoneNumber']}\n";
        $line .= "House Number: {$row['HouseNumber']}\n";
        $line .= "Amount: {$row['Amount']}\n";
        $line .= "Mpesa Receipt Number: {$row['MpesaReceiptNumber']}\n";
        date_default_timezone_set('Africa/Nairobi');
        $line .= date('Y-m-d H:i:s') . "\n";
        
        $line .= "------------kabarita general agency----------------\n";

        fwrite($file, $line);
    }
}

fclose($file);

mysqli_close($db);

echo "Data saved to $filename";
?>
