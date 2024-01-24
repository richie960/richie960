<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Rank</title>
    <style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

h2 {
    margin-top: 0;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="email"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    background-color: #2980b9;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #1c5a85;
}

p {
    color: #d9534f;
    font-weight: bold;
    margin-top: 10px;
}
    
    </style>
</head>
<?php include 'nav.php';?>
<body>
    <?php
    include 'dbconnection.php'; // Include your database connection here

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $newRank = $_POST['new_rank'];

        // Check if the email exists in the login_details table
        $checkQuery = "SELECT * FROM login_details WHERE email = '$email'";
        $checkResult = mysqli_query($db, $checkQuery);

        if (!$checkResult) {
            echo "<p>Error checking email: " . mysqli_error($db) . "</p>";
        } else if (mysqli_num_rows($checkResult) > 0) {
            // Update the rank if email exists
            $updateQuery = "UPDATE login_details SET rank = '$newRank' WHERE email = '$email'";
        
            if (mysqli_query($db, $updateQuery)) {
                echo "<p>Rank updated successfully.</p>";
            } else {
                echo "<p>Error updating rank: " . mysqli_error($db) . "</p>";
            }
        } else {
            echo "<p>Email not found.</p>";
        }

        mysqli_close($db);
    }
    ?>

    <h2>Update Rank</h2>
    
    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="new_rank">New Rank:</label>
        <input type="number" id="new_rank" name="new_rank" value="1" readonly required>
        <br>
        <button type="submit">Update Rank</button>
    </form>
</body>
<br>
<br>
<br>
</br>
<?php include 'footer.php';?>
</html>
