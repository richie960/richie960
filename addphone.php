<?php include 'nav.php'?>
<!DOCTYPE html>
<html>
<head>
    <title>Phone Number and House Number Entry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        form {
            background: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h2>Enter Phone Number and House Number</h2>
    <form method="post" action="">
        <label for="phoneNumber">Phone Number:</label>
        <input type="text" id="phoneNumber" name="phoneNumber" required placeholder ="eg.0712345678"><br><br>

        <label for="houseNumber">House Number:</label>
        <input type="text" id="houseNumber" name="houseNumber" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
include 'dbconnection.php';

// Check the database connection
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the phone number and house number from the form
if (isset($_POST['phoneNumber']) && isset($_POST['houseNumber'])) {
    $phoneNumber = $_POST['phoneNumber'];
    $houseNumber = $_POST['houseNumber'];

    // Remove the leading 0 and add "254" to the phone number
    $phoneNumber = preg_replace('/^0/', '254', $phoneNumber);

    // Check if the house number exists in the default_deposit table
    $query = "SELECT HouseNumber FROM default_deposits WHERE HouseNumber = ?";
    $stmt = mysqli_prepare($db, $query);


   
    if (!$stmt) {
        die("Error in preparing the statement: " . mysqli_error($db));
    }

    mysqli_stmt_bind_param($stmt, "s", $houseNumber);

    if (!mysqli_stmt_execute($stmt)) {
        die("Error executing the statement: " . mysqli_error($db));
    }

    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_close($stmt); // Close the previous statement

        // Now create a new prepared statement
        $query = "SELECT HouseNumber FROM login_details WHERE HouseNumber = ?";
        $stmt = mysqli_prepare($db, $query);

        if (!$stmt) {
            die("Error in preparing the statement: " . mysqli_error($db));
        }

        mysqli_stmt_bind_param($stmt, "s", $houseNumber);

        if (!mysqli_stmt_execute($stmt)) {
            die("Error executing the statement: " . mysqli_error($db));
        }

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) == 0) {
            mysqli_stmt_close($stmt); // Close the previous statement

            // Phone number is not associated with any house number, insert both
            $query = "INSERT INTO login_details (PhoneNumber, HouseNumber) VALUES (?, ?)";
            $stmt = mysqli_prepare($db, $query);

            if (!$stmt) {
                die("Error in preparing the statement: " . mysqli_error($db));
            }

            mysqli_stmt_bind_param($stmt, "ss", $phoneNumber, $houseNumber);

            if (mysqli_stmt_execute($stmt)) {
                echo "Phone number and house number have been successfully inserted.";
            } else {
                die("Error inserting data into login_details: " . mysqli_error($db));
            }
        } else {
            echo "House number is already associated with a phone number.";
        }
    } else {
        echo "House number does not exist in the default_deposit table.";
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($db);
}
?>

<br>
<br>

<?PHP include 'footer.php' ?>


