<?php
$partnerID = '8854';
$apikey = '70efa65617bcc559666d74e884c3abb6';
$shortcode = 'Savvy_sms';

include 'dbconnection.php';

// Get all distinct house numbers that meet the condition
$sql = "SELECT DISTINCT HouseNumber FROM login_details WHERE sent = 1";
$result = $db->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $houseNumber = $row['HouseNumber'];

        // Fetch associated phone number and OTP
        $dataSql = "SELECT PhoneNumber, otp FROM login_details WHERE HouseNumber = ? AND sent = 1 LIMIT 1";
        $stmt = $db->prepare($dataSql);

        // Bind parameters
        $stmt->bind_param("s", $houseNumber);

        // Execute the query
        $stmt->execute();

        // Get the result
        $dataResult = $stmt->get_result();

        if ($dataResult) {
            if ($dataResult->num_rows > 0) {
                $dataRow = $dataResult->fetch_assoc();
                $mobile = $dataRow['PhoneNumber'];
                $otp = $dataRow['otp'];

                // Update 'sent' to 0 before sending the message
                $updateSql = "UPDATE login_details SET sent = 0 WHERE HouseNumber = ?";
                $updateStmt = $db->prepare($updateSql);
                $updateStmt->bind_param("s", $houseNumber);

                if ($updateStmt->execute()) {
                    // Construct the URL with parameters
                    $url = 'https://sms.savvybulksms.com/api/services/sendsms';
                    $url .= '?partnerID=' . urlencode($partnerID);
                    $url .= '&mobile=' . urlencode($mobile);
                    $url .= '&apikey=' . urlencode($apikey);
                    $url .= '&shortcode=' . urlencode($shortcode);
                    $url .= '&message=' . urlencode("Your OTP is: $otp");

                    // Redirect to the constructed URL
                    header("Location: $url");
                    exit; // Ensure that no further code is executed after the redirect

                } else {
                    echo "Error updating 'sent' column: " . $updateStmt->error;
                }
            } else {
                echo "No data found for HouseNumber: $houseNumber";
            }
        } else {
            echo "Error in data query: " . $db->error;
        }
        
        // Close the statement
        $stmt->close();
    }
} else {
    echo "Error in main query: " . $db->error;
}

$db->close();
?>
