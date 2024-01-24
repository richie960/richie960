<?php include 'nav.php'?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search House Payment Status</title>

    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            margin: 0 auto;
            width: 200px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid black;
        }

        button {
            background-color: green;
            color: white;
            padding: 10px;
            border: none;
        }
    </style>
</head>

<body>

    <h1>Search Phone Number</h1>

    <form action="" method="post">
        <input type="text" name="house_number" placeholder="Enter house number">
        <input type="submit" value="Search">
    </form>

    <?php

    try {
        // Include the database connection file
        include('dbconnection.php');

        // Validate user input
        if (isset($_POST['house_number']) && !empty($_POST['house_number'])) {
            // Get the house number from the user
            $house_number = mysqli_real_escape_string($db, $_POST['house_number']);

            // Query the database for the phone number associated with the house number
            $sql = "SELECT PhoneNumber FROM login_details WHERE HouseNumber = '$house_number'";
            $result = $db->query($sql);

            // Check if the query returned any results
            if ($result && $result->num_rows > 0) {
                // Get the phone number from the results
                $row = $result->fetch_assoc();
                $phone_number = $row['PhoneNumber'];

                // Display the phone number
                echo '<p>The phone number for house number ' . $house_number . ' is ' . $phone_number . '</p>';
            } else {
                // No phone number was found
                echo '<p>No phone number found for house number ' . $house_number . '</p>';
            }

            // Close the database connection
            $db->close();
        } else {
            // Handle empty or invalid input
            echo '<p>Invalid or empty house number input.</p>';
        }
    } catch (Exception $e) {
        // Handle any exceptions (e.g., database connection errors)
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
    ?>

</body>

</html>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?PHP include 'footer.php' ?>