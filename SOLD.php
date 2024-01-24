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
        left: 100px;
        padding: 10px;
        background-color: #2196F3;
        color: white;
        display: flex;
        flex-direction:column;
        
        

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


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate Total Form and Product Search Results</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            width: 50%;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h1 {
            color: #333;
        }

        label {
            font-weight: bold;
            margin-right: 10px;
        }

        input[type="text"] {
            padding: 8px;
            margin-right: 10px;
            width: 70%; /* Adjust width for responsiveness */
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }

        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
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

        /* Responsive styles */
        @media screen and (max-width: 600px) {
            form {
                width: 90%;
            }

            input[type="text"] {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div>
        <form action="" method="post">
            <label for="idNumber">Enter IDNO:</label>
            <input type="text" name="idNumber" id="idNumber" required>
            <input type="submit" value="Calculate Total">
        </form>
    </div>
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

            // Fetch rows with the same 'IDNO' where 'SOLD' is one for the current day
            $fetchQuery = "SELECT SUM(QUANTITY) AS totalQuantity, SUM(TOTAL) AS totalAmount FROM cart WHERE IDNO = '$idNumber' AND SOLD = 1 AND DATE(TIMESTAMP) = CURDATE()";
            $result = $conn->query($fetchQuery);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $totalQuantity = $row['totalQuantity'];
                $totalAmount = $row['totalAmount'];

                // Output the results
                echo "IDNO: $idNumber<br>";
                echo "Total Quantity Sold Today: $totalQuantity<br>";
                echo "Total Amount Sold Today: $totalAmount<br>";
            } else {
                echo "No records found for the entered IDNO today.";
            }

            // Fetch total quantity and total amount sold for previous days
            $previousDaysQuery = "SELECT SUM(QUANTITY) AS totalQuantity, SUM(TOTAL) AS totalAmount FROM cart WHERE IDNO = '$idNumber' AND SOLD = 1 AND DATE(TIMESTAMP) < CURDATE()";
            $previousDaysResult = $conn->query($previousDaysQuery);

            if ($previousDaysResult->num_rows > 0) {
                $previousDaysRow = $previousDaysResult->fetch_assoc();
                $previousDaysTotalQuantity = $previousDaysRow['totalQuantity'];
                $previousDaysTotalAmount = $previousDaysRow['totalAmount'];

                // Output the results for previous days
                echo "<br>Previous Days Summary:<br>";
                echo "Total Quantity Sold: $previousDaysTotalQuantity<br>";
                echo "Total Amount Sold: $previousDaysTotalAmount<br>";
            } else {
                echo "<br>No records found for the entered IDNO on previous days.";
            }
        } else {
            echo "IDNO parameter not found in the form submission.";
        }

        // Close the connection
        $conn->close();
        ?>
    </div>

    <div>
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

            // Fetch rows with the same 'IDNO' where 'SOLD' is equal to 1
            $searchQuery = "SELECT MAFUTA, ID, QUANTITY, TOTAL, TIMESTAMP FROM cart WHERE IDNO = '$idNumber' AND SOLD = 1";
            $result = $conn->query($searchQuery);

            if ($result->num_rows > 0) {
                // Display the rows in a table
                echo "<table border='1'>";
                echo "<tr><th>MAFUTA</th><th>ID</th><th>QUANTITY</th><th>TOTAL</th><th>TIMESTAMP</th></tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["MAFUTA"] . "</td>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["QUANTITY"] . "</td>";
                    echo "<td>" . $row["TOTAL"] . "</td>";
                    echo "<td>" . $row["TIMESTAMP"] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No products found for the entered IDNO with SOLD equal to 1.";
            }
        }

        // Close the connection
        $conn->close();
        ?>
    </div>
</body>

</html>
<?php
ob_start(); // Start output buffering

// Your existing PHP code goes here
// ...

$message = "Welcome search for sold products!";
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
        <img src="https://lh3.googleusercontent.com/pw/ABLVV873C6kj6mWbTdBnROilrmenC2RO_vXuJE4LaHuDGJjcVOtn1zklLDgCPEqHX95EXzLZ-g-L6OzsCm_oaDk02FQzwwDvX9H6NCEKIeHgOJu-fulpPh05JC0AI2GfYxM-0y2dO_yKpPvkVz5DDC3uXjeartx-RJwdzILxNSlwK4DkNT_gyGfXcQhf5zJEWVgGYJfuZE4iX3K04HK8KtlKJw4e-czVK7DbHQhIomXe6iOYTDK3JDRN29SojeseLF-Z-2Ttl_lJm1tw3THE1Q6TZ8Gdz31QHG4bCI0xbRXs20Zc505B9uheq_hQO_uaV8rb6cIg-suOuFbzFCZz1zMWRVEaWX8vRBwWCVFyA6aKh69FRV0cl6cGvDyUHqT1_2yB-DMjDFWNf9ShPy3K8Mif9hFTP-28MfqprGLc7xmDyLKHREj__Ddn9-AP99fm388b0fa4z_wi73LwZ3FaB_KOJI4GO-FIr9DH7Doq5LZjcz60EU-tAxPxBHIXWdPCdhmRfmP9QX2wvPdgsWZHN-v-zR7xJU_kAXEAWapw_Uy0xN4XrFR-VL7aBlC1ePkOgjhpxQPuGIMCbLrr9fXqI047A22I3uqFsfH-Wy5ORPeTtZMeMJYvxEOLFfgvajv9BtzuxSYW6NESo7S-IQP6eh-YlXrbm46jLxOrp_mrBoZJ6JTZdQzjzF7mNdNr66X_cHc_JbGmWjgrirb8nW9VSIOjboAcGbg9G4Ae1jk_upziXPk0h_E6a4vzWM1TSIKO-GPAWen0iMesIeOOgNjnw-kkEAJFAveU4X9a8omG1lgb88kLvjdNwpg5OBIFNVkpuB25VmdcD2IvBdb2LD7zx10E1ezIS061a0BVVomrOhr6eJpx0E9RzmRkmDyOORjuC9MHyw=w427-h641-s-no-gm?authuser=0" alt="Hosted by Richie">
        <p>This site is hosted by Richie</p>
    </div>
</body>

</html>
