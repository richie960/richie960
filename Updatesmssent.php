<?php
// Include the database connection file
include 'dbconnection.php';

// Update the Smssent column to zero for all rows in the transactions table
$updateSMSSentQuery = "UPDATE transactions SET Smssent = 0";
$result = mysqli_query($db, $updateSMSSentQuery);

if (!$result) {
    die("Error updating Smssent column: " . mysqli_error($db));
} else {
    echo "Smssent column updated successfully for all rows.\n";
}

// Close the database connection
mysqli_close($db);
?>
