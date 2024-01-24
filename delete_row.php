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

// Check if the ID number is provided in the URL
if (isset($_GET['id'])) {
    $idNumber = $_GET['id'];

    // Delete the row with the specified ID number from the 'cart' table
    $deleteQuery = "DELETE FROM cart WHERE ID = '$idNumber'";
    if ($conn->query($deleteQuery) === TRUE) {
      //  echo "Row deleted successfully.";
      $message = " DELETION COMPLETE✔✔";

      // Redirect to a new page with a message as a query parameter
      header("Location: CART.php?message=" . urlencode($message));
      exit();
    } else {
        //echo "Error deleting row: " . $conn->error;
        $message = "Somethig is not good❌";

        // Redirect to a new page with a message as a query parameter
        header("Location: SELLING.php?message=" . urlencode($message));
        exit();
    }
}

// Close the connection
$conn->close();
?>