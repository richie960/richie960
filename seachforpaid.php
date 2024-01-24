
<?php
include 'nav.php';
include 'dbconnection.php';

$searchResult = '';

if (isset($_POST['houseNumber'])) {
    $houseNumber = $_POST['houseNumber'];

    $searchQuery = "SELECT dd.HouseNumber, dd.DefaultDeposit, 
                           CASE WHEN t.status = 1 THEN 'Paid' ELSE 'Not Paid' END AS status, 
                           t.Amount, t.TransactionDate,dd .Status, t. FirstName
                    FROM default_deposits dd
                    LEFT JOIN transactions t ON dd.HouseNumber = t.HouseNumber
                    WHERE dd.HouseNumber = ?";
    $stmt = mysqli_prepare($db, $searchQuery);

    // Bind parameter
    mysqli_stmt_bind_param($stmt, "s", $houseNumber);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $searchResult = mysqli_stmt_get_result($stmt);
}
?>


  <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search House Payment Status</title>
    <style>
    /* Your CSS styles go here */
     body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        height : 320px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    p {
        text-align: center;
        color: #666;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search House Payment Status</h2>

        <!-- Form for entering house number and password -->
        <form action="" method="post">
            <label for="houseNumber">House Number:</label>
            <input type="text" id="houseNumber" name="houseNumber" required>
            
            
            <button type="submit">Submit</button>
        </form>
<br>
<br><br>
<br>
<br>
<br>


        <?php if ($searchResult && mysqli_num_rows($searchResult) > 0) { ?>
            <h3>Search Result:</h3>
            <table>
                <tr>
                    <th>House Number</th>
                    <th>Default Deposit</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Date/Time</th>
   <th>Residence</th>

                 <th>FirstName</th>
    
                </tr>
                <?php while ($row = mysqli_fetch_assoc($searchResult)) { ?>
                    <tr>
                        <td><?php echo $row['HouseNumber']; ?></td>
                        <td><?php echo $row['DefaultDeposit']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['Amount']; ?></td>
                        <td><?php echo $row['TransactionDate']; ?></td>
                        
                               <td><?php echo $row['Status']; ?></td>     
                     <td><?php echo $row['FirstName']; ?></td>       
                    </tr>
            <?php } ?>
            </table>
<?php include 'footer.php'; ?> 
        <?php } elseif ($searchResult && mysqli_num_rows($searchResult) === 0) { ?>
            <p>No results found for the given house number.</p>
        <?php } ?>

       
</body>
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

        <!-- Your existing HTML content goes here -->

        
    </div>
</body>
<br>
<br>
<br>
</br>
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
<br>
<br>
<br>
</br>

<br>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</br>
<?php// include 'footer.php'; ?>
</html>
