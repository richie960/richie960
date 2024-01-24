<?php
// Assuming you have a database connection, replace the connection details accordingly
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    // Get the 'id' value from the URL
    $id = $_GET['id'];

    // Fetch the row details from the 'cart' table
    $fetchQuery = "SELECT * FROM cart WHERE ID = '$id'";
    $result = $conn->query($fetchQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $maftua = $row['MAFUTA'];
        $quantity = $row['QUANTITY'];

        // Update the 'SOLD' column to 1 in the 'cart' table
        $updateCartQuery = "UPDATE cart SET SOLD = 1 WHERE ID = '$id'";
        if ($conn->query($updateCartQuery) === TRUE) {
            // Subtract the 'QUANTITY' in 'cart' from 'QUANTITY' in 'calculations'
            $updateCalculationsQuery = "UPDATE calculations SET QUANTITY = QUANTITY - $quantity WHERE MAFUTA = '$maftua'";
            if ($conn->query($updateCalculationsQuery) === TRUE) {
                // Redirect to the original page with a success message
                $message = "Good sold ssuccessfully!✔️";
                header("Location: CART.php?message=" . urlencode($message));
                exit();
            } else {
                echo "Error updating 'calculations' table: " . $conn->error;
            }
        } else {
            echo "Error updating 'cart' table: " . $conn->error;
        }
    } else {
        //echo "Row not found in the 'cart' table.";
        $message = "Row not found in the 'cart' table.🚨❌";
        header("Location: CART.php?message=" . urlencode($message));
        exit();
    }
} else {
    echo "ID parameter not found in the URL.";
}

// Close the connection
$conn->close();
?>