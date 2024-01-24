<?php include 'nav.php'; ?>
<br>
<br>
<br>
<br>
<br><br>
<br>

<?php
// Include the database connection file

include 'dbconnection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the entered house number and phone number from the form
    $enteredHouseNumber = $_POST['house_number'];
    $enteredPhoneNumber = $_POST['phone_number'];

    // Remove the first zero and replace it with '254' in the phone number
    $formattedPhoneNumber = '254' . substr($enteredPhoneNumber, 1);

    // Update the phone number in the login_details table
    $updatePhoneNumberQuery = "UPDATE login_details SET PhoneNumber = '$formattedPhoneNumber' WHERE HouseNumber = '$enteredHouseNumber'";

    // Perform the query
    if (mysqli_query($db, $updatePhoneNumberQuery)) {
        echo "Phone number updated successfully.";
    } else {
        echo "Error updating phone number: " . mysqli_error($db);
    }

    // Close the database connection
    mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Phone Number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            width: 90%;
            max-width: 400px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .goback-btn {
            display: block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .goback-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <!-- HTML Form -->
    <h6>UPDATE A PHONE NUMBER</h6>
    <form method="post" action="">
        <!-- Other form fields can be added as needed -->
        House Number: <input type="text" name="house_number" placeholder="e.g. M4"><br>
        Phone Number: <input type="text" name="phone_number" placeholder="e.g. 0712345678"><br>
        <input type="submit" value="Submit">
    </form>
    <a href="javascript:history.back()" class="goback-btn">Go Back</a>
</body>
</html>

<br>
<br>
<br>
<br>
<br>
<br><br>
<br>
<br>
<br>
<br>
<br><br>
<br>
<br>
<br>
<?php include 'footer.php' ?>
