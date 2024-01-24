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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $idNumber = $_POST["idNumber"];
    $quantity = $_POST["quantity"];
    $sellingPrice = $_POST["sellingPrice"];
    $productName = $_POST["productName"];

    // Validate the ID number against the records in the 'registration' table
    $idCheckQuery = "SELECT * FROM registration WHERE IDNO = '$idNumber'";
    $idCheckResult = $conn->query($idCheckQuery);

    if ($idCheckResult->num_rows > 0) {
        // ID number exists in the 'registration' table, proceed to insert into 'cart' table
        $insertCartQuery = "INSERT INTO cart (MAFUTA, TOTAL, IDNO, QUANTITY) VALUES ('$productName', '$sellingPrice', '$idNumber', '$quantity')";
        
        if ($conn->query($insertCartQuery) === TRUE) {
           // echo "Record inserted into 'cart' table successfully.";
           $message = "Product has been added to cart successfully!✔✔";

           // Redirect to a new page with a message as a query parameter
           header("Location: SELLING.php?message=" . urlencode($message));
           exit();
        } else {
            echo "Error: " . $insertCartQuery . "<br>" . $conn->error;
        }
    } else {
        //echo "ID number not found in the 'registration' table.";
        $message = "ID NUMBER IS NOT KNOWN! 🚨❌";

        // Redirect to a new page with a message as a query parameter
        header("Location: SELLING.php?message=" . urlencode($message));
        exit();
    }
}

$conn->close();
?>