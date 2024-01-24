<?php
include 'dbconnection.php';

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $updateID = $_POST['update_id'];
        $newHouseNumber = $_POST['new_house_number'];
        $newAmount = $_POST['new_amount'];
        $newMpesaReceiptNumber = $_POST['new_receipt_number'];

        $updateQuery = "UPDATE transactions 
                        SET HouseNumber = '$newHouseNumber', Amount = '$newAmount', MpesaReceiptNumber = '$newMpesaReceiptNumber'
                        WHERE MerchantRequestID = '$updateID'";
        if (mysqli_query($db, $updateQuery)) {
            header("Location: ".$_SERVER['PHP_SELF']."?message=Record+updated+successfully");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }
    }

    if (isset($_POST['delete'])) {
        $deleteID = $_POST['delete_id'];

        $deleteQuery = "DELETE FROM transactions WHERE MerchantRequestID = '$deleteID'";
        if (mysqli_query($db, $deleteQuery)) {
            header("Location: ".$_SERVER['PHP_SELF']."?message=Record+deleted+successfully");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($db);
        }
    }
}

$searchHouseNumber = isset($_POST['search_house_number']) ? $_POST['search_house_number'] : "";
$searchColumns = isset($_POST['search_columns']) ? $_POST['search_columns'] : array();

// ... rest of your code ...
// Build the WHERE clause only if there are selected search columns
$whereClause = "";
if (!empty($searchColumns)) {
    $whereConditions = array();
    foreach ($searchColumns as $column) {
        $whereConditions[] = "$column = '$searchHouseNumber'";
    }
    $whereClause = "WHERE " . implode(" OR ", $whereConditions);
}

// Query to retrieve records based on search columns
$query = "SELECT * FROM transactions $whereClause";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}
$query = "SELECT * FROM transactions $whereClause";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($db));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your head section ... -->
    <style>
        /* Style for the form container */
form {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
}

/* Style for form labels */
label {
    display: block;
    margin-bottom: 8px;
}

/* Style for form input fields */
input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Style for form select fields */
select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

/* Style for form buttons */
button[type="submit"] {
    padding: 8px 16px;
    background-color: #2980b9;
    color: #fff;
    border: none;
    border-radius: 3px;
    cursor: pointer;
}

/* Style for the results table */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

/* Style for update and delete buttons */
form button {
    background-color: #2980b9;
    color: #fff;
    border: none;
    border-radius: 3px;
    padding: 6px 12px;
    cursor: pointer;
}

/* Add more styles as needed */

    </style>
</head>
<?php include 'nav.php';?>
<body>
    <h2>Search Transactions</h2>
    
    <form action="" method="post">
        <label for="search_house_number">Enter Value:</label>
        <input type="text" id="search_house_number" name="search_house_number" value="<?php echo $searchHouseNumber; ?>" required>
        <br>
        <label for="search_columns">Search Columns:</label>
        <select name="search_columns[]" id="search_columns" multiple required>
            <option value="HouseNumber">House Number</option>
            <option value="Amount">Amount</option>
            <option value="MpesaReceiptNumber">MpesaReceiptNumber</option>
            <!-- Add more columns as needed -->
        </select>
        <br>
        <button type="submit">Search</button>
    </form>
    
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Display search results table
        echo "<h3>Results for Search:</h3>";
        echo "<table border='1'>
            <tr>
                <th>userphone</th>
                <th>House Number</th>
                <th>Amount</th>
                <th>MpesaReceiptNumber</th>
                <th>TransTime</th>
                <!-- Add more columns as needed -->
            </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['PhoneNumber']}</td>
                <td>{$row['HouseNumber']}</td>
                <td>{$row['Amount']}</td>
                <td>{$row['MpesaReceiptNumber']}</td>
                <td>{$row['TransTime']}</td>
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='update_id' value='{$row['PhoneNumber']}'>
                        <input type='text' name='new_house_number' value='{$row['HouseNumber']}'>
                        <input type='text' name='new_amount' value='{$row['Amount']}'>
                        <input type='text' name='new_receipt_number' value='{$row['MpesaReceiptNumber']}'>
                        <input type='text' name='TransTime' value='{$row['TransTime']}'>
                        <button type='submit' name='update'>Update</button>
                    </form>
                </td>
                <td>
                    <form action='' method='post'>
                        <input type='hidden' name='delete_id' value='{$row['PhoneNumber']}'>
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No records found for the search criteria.</p>";
    }
    ?>

</body>
<?php include 'footer.php';?>
</html>
