<?php
include 'dbconnection.php';

// Handle record addition
if (isset($_POST['add'])) {
    $houseNumber = $_POST['house_number'];
    $defaultDeposit = $_POST['default_deposit'];
    $status = $_POST['status']; // Ensure the status is either "Occupied" or "Vacant"

    // Check if the House Number already exists
    $checkQuery = "SELECT * FROM default_deposits WHERE HouseNumber = '$houseNumber'";
    $checkResult = mysqli_query($db, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        if ($status === "Occupied" || $status === "Vacant") {
            // Insert the new record into default_deposits table
            $insertQuery = "INSERT INTO default_deposits (HouseNumber, DefaultDeposit, Status) 
                            VALUES ('$houseNumber', $defaultDeposit, '$status')";
            mysqli_query($db, $insertQuery);
        } else {
            echo "Invalid status value. Please enter 'Occupied' or 'Vacant'.";
        }
    } else {
        echo "A record with the same House Number already exists.";
    }
}

// Handle record deletion
if (isset($_GET['delete'])) {
    $houseNumberToDelete = $_GET['delete'];
    $deleteQuery = "DELETE FROM default_deposits WHERE HouseNumber = '$houseNumberToDelete'";
    mysqli_query($db, $deleteQuery);
}

// Handle record search and deletion
if (isset($_POST['search'])) {
    $searchHouseNumber = $_POST['search_house_number'];
    $searchQuery = "SELECT * FROM default_deposits WHERE HouseNumber = '$searchHouseNumber'";
    $searchResult = mysqli_query($db, $searchQuery);
}

// Fetch all records from default_deposits table
$fetchAllQuery = "SELECT * FROM default_deposits";
$fetchAllResult = mysqli_query($db, $fetchAllQuery);

mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Default Deposits</title>
<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
}

h1, h2, h3 {
  text-align: center;
}

form {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"], input[type="number"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button[type="submit"] {
  display: block;
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th, td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: center;
}

a {
  text-decoration: none;
  color: #007bff;
}

a:hover {
  color: #0056b3;
}
  
</style>
<!-- Add your CSS styles here -->
</head>
<?php include 'nav.php';?>
<br>

    
    <h1>Manage Default Deposits</h1>

    <!-- Add new record form -->
    <h2>Add New Record</h2>
    <form action="" method="post">
        <label for="house_number">House Number:</label>
        <input type="text" id="house_number" name="house_number" required><br>
        <label for="default_deposit">Default Deposit:</label>
        <input type="number" id="default_deposit" name="default_deposit" required><br>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" placeholder="Occupied or Vacant" required><br>
        <button type="submit" name="add">Add Record</button>
        
        
    </form>

    <!-- Search and delete form -->
    <h2>Search and Delete Record</h2>
    <form action="" method="post">
        <label for="search_house_number">Search House Number:</label>
        <input type="text" id="search_house_number" name="search_house_number" required><br>
        <button type="submit" name="search">Search</button>
    </form>

    <!-- Display search results and existing records in a table -->
    <h2>Records</h2>
    <table>
        <tr>
            <th>House Number</th>
            <th>Default Deposit</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        if (isset($searchResult)) {
            while ($row = mysqli_fetch_assoc($searchResult)) { ?>
                <tr>
                    <td><?php echo $row['HouseNumber']; ?></td>
                    <td><?php echo $row['DefaultDeposit']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['HouseNumber']; ?>">Delete</a>
                    </td>
                </tr>
            <?php }
        } else {
            while ($row = mysqli_fetch_assoc($fetchAllResult)) { ?>
                <tr>
                    <td><?php echo $row['HouseNumber']; ?></td>
                    <td><?php echo $row['DefaultDeposit']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                    <td>
                        <a href="?delete=<?php echo $row['HouseNumber']; ?>">Delete</a>
                    </td>
                </tr>
            <?php }
        }
        ?>
    </table>
    <script>
     // Parse the URL to get the query string
        const queryString = window.location.search;
        
        // Create a new URLSearchParams object with the query string
        const params = new URLSearchParams(queryString);
        
        // Get the value of the 'message' parameter
        const message = params.get('message');
        
        // Display the message on the page
        if (message) {
            const messageElement = document.createElement('p');
            messageElement.textContent = message;
            document.body.appendChild(messageElement);
        }  
     
    </script>
</body>
<?php include 'footer.php';?>
</html>
