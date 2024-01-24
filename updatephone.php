<?php
// Include the database connection file
include 'dbconnection.php';

// Check the database connection
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Retrieve distinct HouseNumber values from the login_details table
$query = "SELECT DISTINCT HouseNumber FROM login_details";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Error fetching HouseNumbers: " . mysqli_error($db));
}

while ($row = mysqli_fetch_assoc($result)) {
    $houseNumber = $row['HouseNumber'];

    // Retrieve the PhoneNumber associated with this HouseNumber from login_details
    $query2 = "SELECT PhoneNumber FROM login_details WHERE HouseNumber = ?";
    $stmt2 = mysqli_prepare($db, $query2);

    if (!$stmt2) {
        die("Error in preparing the statement: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt2, "s", $houseNumber);

    if (!mysqli_stmt_execute($stmt2)) {
        die("Error executing the statement: " . mysqli_error($db));
    }

    mysqli_stmt_bind_result($stmt2, $phoneNumber);

    if (mysqli_stmt_fetch($stmt2)) {
        // Close the statement before updating
        mysqli_stmt_close($stmt2);

        // Update PhoneNumber in the transactions table for matching HouseNumber
        $updateQuery = "UPDATE transactions SET PhoneNumber = ? WHERE HouseNumber = ?";
        $updateStmt = mysqli_prepare($db, $updateQuery);

        if (!$updateStmt) {
            die("Error in preparing the update statement: " . mysqli_error($db));
        }

        mysqli_stmt_bind_param($updateStmt, "ss", $phoneNumber, $houseNumber);

        if (!mysqli_stmt_execute($updateStmt)) {
            die("Error updating PhoneNumber: " . mysqli_error($db));
        }

        mysqli_stmt_close($updateStmt);
    }
}

// Close the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($db);

echo "PhoneNumber updates completed.";
?>
