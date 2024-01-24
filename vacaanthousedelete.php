<!DOCTYPE html>
<html>
<head>
    <title>Delete and Update House Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding:50px;        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<?php include 'nav.php'?>
<br><br>
<body>
    <h2>Delete House Records and Update Status</h2>

<?php
include 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $houseNumber = $_POST['house_number'];

    // Check if house number exists
    $checkQuery = "SELECT COUNT(*) FROM default_deposits WHERE HouseNumber = ?";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->bind_param("s", $houseNumber);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Delete records associated with the house number in the transactions table
        $deleteQueryTransactions = "DELETE FROM transactions WHERE HouseNumber = ?";
        $deleteStmtTransactions = $db->prepare($deleteQueryTransactions);
        $deleteStmtTransactions->bind_param("s", $houseNumber);
        $deleteStmtTransactions->execute();
        $deleteStmtTransactions->close();

        // Delete records associated with the house number in the login_details table
        $deleteQueryLoginDetails = "DELETE FROM login_details WHERE HouseNumber = ?";
        $deleteStmtLoginDetails = $db->prepare($deleteQueryLoginDetails);
        $deleteStmtLoginDetails->bind_param("s", $houseNumber);
        $deleteStmtLoginDetails->execute();
        $deleteStmtLoginDetails->close();

        // Update Status column to "vacant" for the specified house number
        $updateQuery = "UPDATE default_deposits SET Status = 'vacant' WHERE HouseNumber = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bind_param("s", $houseNumber);
        $updateStmt->execute();
        $updateStmt->close();

        echo "Records deleted and status updated for house number: " . $houseNumber;
    } else {
        echo "House number does not exist.";
    }
}

$db->close();
?>

    
     
    <form method="post" action="">
        <label for="house_number">Enter House Number:</label>
        <input type="text" name="house_number" id="house_number" required>
        <button type="submit">Delete and Update</button>
    </form>
</body>
<br>
<br><br><br>
<br><br><br>
<br><br>
<br><br><br>
<br><br><br>
<br>

<?php include 'footer.php';?>
</html>
