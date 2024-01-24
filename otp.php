<?php
// Include the database connection file
include 'dbconnection.php';

// Assume that the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve the house number from the form
    $houseNumber = mysqli_real_escape_string($db, $_POST["houseNumber"]);

    // Check if the house number exists in the database
    $query = "SELECT * FROM login_details WHERE HouseNumber = '$houseNumber'";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        // House number found, update 'sent' to 1 and generate a random 4-digit OTP
        $otp = mt_rand(1000, 9999);
        $updateQuery = "UPDATE login_details SET sent = 1, otp = '$otp' WHERE HouseNumber = '$houseNumber'";
        
        if ($db->query($updateQuery) === TRUE) {
            // Redirect to another page
            header("Location: otpchecker.php");
            exit();
        } else {
            echo "Error updating record: " . $db->error;
        }
    } else {
        //echo "House number not found.";
        header("Location: https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/login.html");
    }
}
?>
