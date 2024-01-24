<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    body {
        margin: 0;
        font-family: "Arial", sans-serif;
    }

    #sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #2196F3;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    #sidebar a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    #sidebar a:hover {
        color: #f1f1f1;
    }

    #sidebar .close-btn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    #main {
        transition: margin-left 0.5s;
        padding: 16px;
    }

    .open-btn {
        font-size: 30px;
        cursor: pointer;
        background-color: #2196F3;
        color: white;
        padding: 15px 20px;
        border: none;
        position: fixed;
        top: 0;
        left: 0;
    }

    #greeting {
        position: fixed;
        top: 0;
        left: 450px;
        padding: 10px;
        background-color: #2196F3;
        color: white;
    }
    </style>
</head>

<body>

    <div id="greeting">
        <h1 id="greeting-text">Greetings will appear here</h1>
    </div>

    <div id="sidebar">
        <button class="close-btn" onclick="closeNav()">&times;</button>
        <a href="SELLING.php">HOME</a>
        <a href="CART.php">Cart</a>
        <a href="SOLD.php">Sold_products</a>
    </div>

    <div id="main">
        <button class="open-btn" onclick="openNav()">&#9776;</button>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current hour
        var currentHour = new Date().getHours();

        // Get the greeting based on the current hour
        var greeting;
        if (currentHour >= 0 && currentHour < 12) {
            greeting = "Good morning!";
        } else if (currentHour >= 12 && currentHour < 18) {
            greeting = "Good afternoon!";
        } else {
            greeting = "Good evening!";
        }

        // Display the greeting
        document.getElementById("greeting-text").innerText = greeting;
    });

    function openNav() {
        document.getElementById("sidebar").style.width = "250px";
        document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("sidebar").style.width = "0";
        document.getElementById("main").style.marginLeft = "0";
    }
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENTER CART NUMBER</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="text"] {
        padding: 8px;
        margin-bottom: 10px;
        width: 200px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        padding: 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        cursor: pointer;
    }

    table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4caf50;
        color: white;
    }

    button {
        padding: 5px 10px;
        background-color: #4caf50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }
    </style>
</head>

<body>


    <form action="" method="post">
        <label for="idNumber">Enter IDNO:</label>
        <input type="text" name="idNumber" id="idNumber" required>
        <input type="submit" value="Search">
    </form>

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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $idNumber = $_POST["idNumber"];

        // Fetch rows related to the entered IDNO from the 'cart' table where SOLD is zero
        $searchQuery = "SELECT MAFUTA, ID, QUANTITY, TOTAL, TIMESTAMP FROM cart WHERE IDNO = '$idNumber' AND SOLD = 0";
        $result = $conn->query($searchQuery);

        if ($result->num_rows > 0) {
            // Display the rows in a table
            echo "<table border='1'>";
            echo "<tr><th>MAFUTA</th><th>ID</th><th>QUANTITY</th><th>TOTAL</th><th>TIMESTAMP</th><th>Action</th> <th>Action</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["MAFUTA"] . "</td>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["QUANTITY"] . "</td>";
                echo "<td>" . $row["TOTAL"] . "</td>";
                echo "<td>" . $row["TIMESTAMP"] . "</td>";
                echo "<td><button onclick='deleteRow(\"" . $row["ID"] . "\")'>Delete</button></td>";
                echo "<td><button onclick='sellRow(\"" . $row["ID"] . "\")'>Sell</button></td>";
                echo "</tr>";
            }

            echo "</table>";

        } else {
            //echo "No unsold rows found for the entered IDNO.";
           // $message = "THE ID HAS NOT SOLD OR IS ALRREADY CAUGHT UP!❌🚨";

            // Redirect to a new page with a message as a query parameter
         //   header("Location: CART.php?message=" . urlencode($message));
            

    }
    }



    // Close the connection
    $conn->close();
    ?>
    <?php
ob_start(); // Start output buffering

// Your existing PHP code goes here
// ...

$message = "Welcome to cart!";
//echo "<p>$message</p>";

// JavaScript to modify the URL
echo "<script>";
echo "var currentUrl = window.location.href;";
echo "var separator = currentUrl.includes('?') ? '&' : '?';";
echo "var newUrl = currentUrl + separator + 'message=' + encodeURIComponent('$message');";
echo "window.history.replaceState({}, '', newUrl);";
echo "</script>";

// Flush the output buffer
ob_end_flush();
?>

    <script>
    function deleteRow(id) {
        var confirmation = confirm("Are you sure you want to delete this good?");
        if (confirmation) {
            // Redirect to a PHP script that handles the deletion
            window.location.href = "delete_row.php?id=" + encodeURIComponent(id);
        }
    }
    </script>
    <script>
    function sellRow(id) {
        var confirmation = confirm("Are you sure you want to sell this good?");
        if (confirmation) {
            // Redirect to a PHP script that handles the deletion
            window.location.href = "update_cart.php?id=" + encodeURIComponent(id);
        }
    }
    </script>
</body>

</html>

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

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNumber'])) {
    // Get the 'idNumber' value from the form
    $idNumber = $_POST['idNumber'];

    // Fetch rows with the same 'IDNO' where 'SOLD' is zero
    $fetchQuery = "SELECT * FROM cart WHERE IDNO = '$idNumber' AND SOLD = 0";
    $result = $conn->query($fetchQuery);

    if ($result->num_rows > 0) {
        // Initialize total variable
        $total = 0;

        // Loop through the rows to calculate the total
        while ($row = $result->fetch_assoc()) {
            $total += $row['TOTAL'];
        }

        // Output the total
        echo "Total for IDNO $idNumber: $total";
    } else {
        echo "No unsold rows found for the entered IDNO.";
    }
} else {
    echo "IDNO parameter not found in the form submission.";
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliding Sidebar</title>

    </body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Message from URL</title>
    <style>
    #messageBox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        display: none;
        transition: opacity 1s ease-in-out;
    }

    #messageBox.success {
        background-color: green;
        color: white;
    }

    #messageBox.error {
        background-color: red;
        color: white;
    }
    </style>
</head>

<body>

    <?php
// Extract the message from the URL
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Determine if the message contains the word "not"
$hasNot = stripos($message, 'not') !== false;

// Apply the class based on the presence of "not"
$class = $hasNot ? 'error' : 'success';

echo "<div id='messageBox' class='$class'>$message</div>";
?>

    <script>
    // JavaScript to display the message box
    document.addEventListener("DOMContentLoaded", function() {
        var messageBox = document.getElementById('messageBox');
        if (messageBox) {
            messageBox.style.display = 'block';
            setTimeout(function() {
                messageBox.style.opacity = 0;
            }, 10000);
        }
    });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Page</title>
    <script>
    // Push a new state to the browser history
    history.pushState(null, null, document.URL);

    // Listen for the back/forward button event
    window.addEventListener('popstate', function() {
        // Push another state to prevent going back
        history.pushState(null, null, document.URL);
    });
    </script>
</head>

<body>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Richie's Hosted Image and Text</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            position: fixed;
            bottom: 0;
            right: 0;
            padding: 10px;
            background-color: #f0f0f0;
            z-index: 999;
        }

        .container img {
            width: 50px; /* Adjust the size as needed */
            height: 50px; /* Adjust the size as needed */
            border-radius: 50%;
        }

        .container p {
            margin: 5px 0 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="https://media.istockphoto.com/id/628848462/photo/dot-com-the-most-important-domain-ending.jpg?b=1&s=612x612&w=0&k=20&c=c-zdqZtAZjvcbxzXxNoJ7Q9MbkEODAw_T9qSXExCwvg=" alt="Hosted by Richie">
        <p>This site is hosted by Richie</p>
    </div>
</body>

</html>
