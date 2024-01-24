<?php
include 'dbconnection.php';

if (isset($_POST['add'])) {
    $houseNumber = $_POST['house_number'];
    $defaultDeposit = $_POST['default_deposit'];
    $status = $_POST['status'];

    // Check if a record with the same HouseNumber already exists
    $checkQuery = "SELECT * FROM default_deposits WHERE HouseNumber = '$houseNumber'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        $insertQuery = "INSERT INTO default_deposits (HouseNumber, DefaultDeposit, Status) 
                        VALUES ('$houseNumber', $defaultDeposit, '$status')";
        mysqli_query($db, $insertQuery);
    } else {
        echo "A record with the same HouseNumber already exists.";
    }
}

if (isset($_POST['update'])) {
    $updateHouseNumber = $_POST['update'];
    $updatedDefaultDeposit = $_POST['updated_default_deposit'];
    $updatedStatus = $_POST['updated_status'];

    // Update the row with the new values
    $updateQuery = "UPDATE default_deposits SET DefaultDeposit='$updatedDefaultDeposit', Status='$updatedStatus' WHERE HouseNumber='$updateHouseNumber'";
    mysqli_query($db, $updateQuery);
}

if (isset($_GET['delete'])) {
    $houseNumberToDelete = $_GET['delete'];
    $deleteQuery = "DELETE FROM default_deposits WHERE HouseNumber = '$houseNumberToDelete'";
    mysqli_query($db, $deleteQuery);
}

mysqli_close($db);
?>
