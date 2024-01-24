<?php
include 'dbconnection.php';

// Function to generate a random alphanumeric password
function generatePassword($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $password;
}

// Generate a new password
$newPassword = generatePassword();

// Check if an admin password already exists
$checkQuery = "SELECT COUNT(*) FROM login_details";
$checkStmt = $db->prepare($checkQuery);
$checkStmt->execute();
$checkStmt->bind_result($rowCount);
$checkStmt->fetch();
$checkStmt->close();

if ($rowCount > 0) {
    // Update the existing password in the "login_details" table
    $updateQuery = "UPDATE login_details SET adminpassword = ? LIMIT 1";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bind_param("s", $newPassword);

    if ($updateStmt->execute()) {
        echo '<p style="font-size: 50px;">Updated Password: ' . $newPassword . '</p>';
    } else {
        echo "Error updating password: " . $updateStmt->error;
    }

    $updateStmt->close();
} else {
    // Insert the new password into the "login_details" table
    $insertQuery = "INSERT INTO login_details (adminpassword) VALUES (?)";
    $insertStmt = $db->prepare($insertQuery);
    $insertStmt->bind_param("s", $newPassword);

    if ($insertStmt->execute()) {
        echo '<p style="font-size: 50px;">New Password expires in 5 minutes: ' . $newPassword . '</p>';
    } else {
        echo "Error inserting password: " . $insertStmt->error;
    }

    $insertStmt->close();
}

// Close the database connection
$db->close();
?>
