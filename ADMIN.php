<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #f4f4f4;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #333;
    }

    form {
        margin-top: 20px;
    }

    form input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    form input[type="submit"] {
        background-color: #2196F3;
        color: #fff;
        cursor: pointer;
    }

    form input[type="submit"]:hover {
        background-color: #0b7dda;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Product Information</h2>
        <form action="" method="post">
            <label for="mafuta">MAFUTA:</label>
            <input type="text" name="mafuta" id="mafuta" required>

            <label for="quantity">QUANTITY:</label>
            <input type="text" name="quantity" id="quantity">

            <label for="factory_price">FACTORY PRICE:</label>
            <input type="text" name="factory_price" id="factory_price">

            <label for="at">AT:</label>
            <input type="text" name="at" id="at">

            <label for="selling_price">SELLING PRICE:</label>
            <input type="text" name="selling_price" id="selling_price">

            <label for="selling_price1">SELLING PRICE 1:</label>
            <input type="text" name="selling_price1" id="selling_price1">

            <label for="selling_price2">SELLING PRICE 2:</label>
            <input type="text" name="selling_price2" id="selling_price2">

            <label for="total_selling_price">TOTAL SELLING PRICE:</label>
            <input type="text" name="total_selling_price" id="total_selling_price">

            <label for="total_factory_price">TOTAL FACTORY PRICE:</label>
            <input type="text" name="total_factory_price" id="total_factory_price">

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stock";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mafuta = $_POST["mafuta"];
    $quantity = $_POST["quantity"];
    $factoryPrice = $_POST["factory_price"];
    $at = $_POST["at"];
    $sellingPrice = $_POST["selling_price"];
    $sellingPrice1 = $_POST["selling_price1"];
    $sellingPrice2 = $_POST["selling_price2"];
    $totalSellingPrice = $_POST["total_selling_price"];
    $totalFactoryPrice = $_POST["total_factory_price"];

    $mafuta = mysqli_real_escape_string($conn, $mafuta);

    $checkExistQuery = "SELECT * FROM calculations WHERE MAFUTA = '$mafuta'";
    $result = $conn->query($checkExistQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        echo "Product Details:<br>";
        echo "MAFUTA: " . $row["MAFUTA"] . "<br>";
        echo "QUANTITY: " . $row["QUANTITY"] . "<br>";
        echo "FACTORY PRICE: " . $row["FACTORY PRICE"] . "<br>";
        echo "AT: " . $row["AT"] . "<br>";
        echo "SELLING PRICE: " . $row["SELLINGPRICE"] . "<br>";
        echo "SELLING PRICE 1: " . $row["SELLINGPRICE1"] . "<br>";
        echo "SELLING PRICE 2: " . $row["SELLINGPRICE2"] . "<br>";
        echo "TOTAL SELLING PRICE: " . $row["TOTALSELLINGPRICE"] . "<br>";
        echo "TOTAL FACTORY PRICE: " . $row["TOTALFACTORYPRICE"] . "<br>";

        echo "<h2>Update Product Information</h2>";
        echo "<form action='' method='post'>";
        echo "<input type='hidden' name='mafuta' value='" . $row["MAFUTA"] . "'>";
        echo "QUANTITY: <input type='text' name='quantity' value='" . $row["QUANTITY"] . "'><br>";
        echo "FACTORY PRICE: <input type='text' name='factory_price' value='" . $row["FACTORY PRICE"] . "'><br>";
        echo "AT: <input type='text' name='at' value='" . $row["AT"] . "'><br>";
        echo "SELLING PRICE: <input type='text' name='selling_price' value='" . $row["SELLINGPRICE"] . "'><br>";
        echo "SELLING PRICE 1: <input type='text' name='selling_price1' value='" . $row["SELLINGPRICE1"] . "'><br>";
        echo "SELLING PRICE 2: <input type='text' name='selling_price2' value='" . $row["SELLINGPRICE2"] . "'><br>";
        echo "TOTAL SELLING PRICE: <input type='text' name='total_selling_price' value='" . $row["TOTALSELLINGPRICE"] . "'><br>";
        echo "TOTAL FACTORY PRICE: <input type='text' name='total_factory_price' value='" . $row["TOTALFACTORYPRICE"] . "'><br>";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        $insertQuery = "INSERT INTO calculations (MAFUTA, QUANTITY, FACTORY PRICE, AT, SELLINGPRICE, SELLINGPRICE1, SELLINGPRICE2, TOTALSELLINGPRICE, TOTALFACTORYPRICE)
                        VALUES ('$mafuta', '$quantity', '$factoryPrice', '$at', '$sellingPrice', '$sellingPrice1', '$sellingPrice2', '$totalSellingPrice', '$totalFactoryPrice')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "New record inserted successfully";
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_mafuta'])) {
    $editMafuta = $_GET['edit_mafuta'];
    $updatedQuantity = $_POST["quantity"];
    $updatedFactoryPrice = $_POST["factory_price"];
    $updatedAt = $_POST["at"];
    $updatedSellingPrice = $_POST["selling_price"];
    $updatedSellingPrice1 = $_POST["selling_price1"];
    $updatedSellingPrice2 = $_POST["selling_price2"];
    $updatedTotalSellingPrice = $_POST["total_selling_price"];
    $updatedTotalFactoryPrice = $_POST["total_factory_price"];

    $updateQuery = "UPDATE calculations SET
                        QUANTITY='$updatedQuantity',
                        FACTORY PRICE='$updatedFactoryPrice',
                        AT='$updatedAt',
                        SELLINGPRICE='$updatedSellingPrice',
                        SELLINGPRICE1='$updatedSellingPrice1',
                        SELLINGPRICE2='$updatedSellingPrice2',
                        TOTALSELLINGPRICE='$updatedTotalSellingPrice',
                        TOTALFACTORYPRICE='$updatedTotalFactoryPrice'
                        WHERE MAFUTA='$editMafuta'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>