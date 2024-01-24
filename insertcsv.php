<?php

// Database connection parameters for XAMPP
$servername = "";
$username = "root";
$password = "";
$database = "stock";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Path to your CSV file
$csvFile = '';

// Read the CSV file
$csvData = array_map('str_getcsv', file($csvFile));

// Get the headers (first row) to use as column names
$headers = array_shift($csvData);

// Create a table if not exists
$createTableQuery = "CREATE TABLE IF NOT EXISTS calculations (";
foreach ($headers as $header) {
    $createTableQuery .= "`$header` VARCHAR(255), ";
}
$createTableQuery = rtrim($createTableQuery, ', ') . ")";
$conn->query($createTableQuery);

// Insert data into the database
foreach ($csvData as $row) {
    // Escape values to prevent SQL injection
    $escapedValues = array_map([$conn, 'real_escape_string'], $row);
    
    // Build the SQL query
    $insertQuery = "INSERT INTO calculations (`" . implode("`, `", $headers) . "`) VALUES ('" . implode("', '", $escapedValues) . "')";
    
    // Execute the query
    $conn->query($insertQuery);
}

// Close the connection
$conn->close();

echo "Data imported successfully.";

?>