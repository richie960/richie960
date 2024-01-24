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
</body>

</html>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h2 {
    color: #333;
}

form {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="number"],
select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

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

h2 {
    margin-top: 40px;
}

/* Sidebar Styles */
.sidebar {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #111;
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
}

.sidebar a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 18px;
    color: #818181;
    display: block;
    transition: 0.3s;
}

.sidebar a:hover {
    color: #f1f1f1;
}

.sidebar .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

.openbtn {
    font-size: 20px;
    cursor: pointer;
    background-color: #111;
    color: white;
    padding: 10px 15px;
    border: none;
}

.openbtn:hover {
    background-color: #444;
}

#main {
    transition: margin-left .5s;
    padding: 16px;
}
</style>

<?php // Database connection parameters for XAMPP
$servername="localhost";
$username="root";
$password="";
$database="stock";

// Create connection
$conn=new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Fetch all product names from the database
$productQuery="SELECT MAFUTA FROM calculations";
$result=$conn->query($productQuery);

// Check if there are products
$products=[];

if ($result->num_rows > 0) {
    while ($row=$result->fetch_assoc()) {
        $products[]=$row['MAFUTA'];
    }
}

// Initialize variables to store fetched values
$selectedProduct=$sellingPrice=$sellingPrice1=$sellingPrice2=$at=$quantity=$mafuta="";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    // Get the selected product from the form
    $selectedProduct=$_POST["productSelect"];

    // Fetch columns associated with the selected product
    $searchQuery="SELECT SELLINGPRICE, SELLINGPRICE1, SELLINGPRICE2, AT, MAFUTA, QUANTITY FROM calculations WHERE MAFUTA = '$selectedProduct'";
    $result=$conn->query($searchQuery);

    // Check if the product is found
    if ($result->num_rows > 0) {
        $row=$result->fetch_assoc();
        $sellingPrice=$row['SELLINGPRICE'];
        $sellingPrice1=$row['SELLINGPRICE1'];
        $sellingPrice2=$row['SELLINGPRICE2'];
        $at=$row['AT'];
        $mafuta=$row['MAFUTA'];
        $quantity=$row['QUANTITY'];
    }

    else {
        echo "Product not found in the database.";
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
</head>

<body>
    <h2>Product Search</h2>
    <form action="" method="POST"><label for="productInput">Enter Product Name:</label><input type="text"
            name="productInput" id="productInput" oninput="filterProducts()"><label for="productSelect">Select a
            Product:</label><select name="productSelect" id="productSelect"><?php // Display all product options in the dropdown initially

foreach ($products as $product) {
    $selected=($product==$selectedProduct) ? "selected": "";
    echo "<option value=\"$product\" $selected>$product</option>";
}

?></select><input type="submit" value="Search"></form><?php // Display search result

if ($_SERVER["REQUEST_METHOD"]=="POST"&& $result->num_rows > 0) {
    echo "<h2>Search Result</h2>";
    echo "<p>Product: $mafuta</p>";
    echo "<p>Selling Price: $sellingPrice</p>";
    echo "<p>Selling Price 1: $sellingPrice1</p>";
    echo "<p>Selling Price 2: $sellingPrice2</p>";
    echo "<p>AT: $at</p>";
    echo "<p>QUANTITY: $quantity</p>";
    // Example: Assuming you have a variable $quantity;  // You can replace this with your actual variable

    // Check if the quantity is above zero
    if ($at > 0) {
        echo "The product is in packets.";
    }

    else {
        // echo "The product quantity is not in packets.";
    }


    // echo "<p><a href=\"#\">Back to Search</a></p>";
}

?><script>
    function filterProducts() {
        var input,
            filter,
            select,
            option,
            i;
        input = document.getElementById("productInput");
        filter = input.value.toUpperCase();
        select = document.getElementById("productSelect");
        option = select.getElementsByTagName("option");

        for (i = 0; i < option.length; i++) {
            if (option[i].value.toUpperCase().indexOf(filter) > -1) {
                option[i].style.display = "";
            } else {
                option[i].style.display = "none";
            }
        }
    }
    </script>
</body>

<body>
    <h2>SUBMIT TO CART</h2><?php // Your existing PHP code...

// Check if $at is zero
if ($at<!0) {
    // The following code will only be executed when $at is zero
    ?>
    <form action="process_form.php" method="POST"><label for="quantity">Quantity: </label> <input type="number"
            name="quantity" id="quantity" required max="<?php echo $quantity ?>"> <label for="sellingPrice">Selling
            Price:</label> <select name="sellingPrice" id="sellingPrice" required onchange="updateSellingPrice()">
            <option value="<?php echo $sellingPrice; ?>"> <?php echo $sellingPrice;
    ?></option>
            <option value="<?php echo $sellingPrice1; ?>"><?php echo $sellingPrice1;
    ?></option>
            <option value="<?php echo $sellingPrice2; ?>"><?php echo $sellingPrice2;

    ?></option>
        </select><label for="idNumber">ID Number:</label><input type="text" name="idNumber" id="idNumber"
            required><label for="productName">Product Name:</label><input type="text" name="productName"
            id="productName" value="<?php echo $mafuta ?>" required readonly><input type="submit" value="Submit">
    </form>
    <script>
    function updateSellingPrice() {
        // JavaScript code to update sellingprice if needed
    }
    </script>
    <script>
    function updateSellingPrice() {
        // Get the selected option value
        var selectedOption = document.getElementById('sellingPrice').value;
        console.log(result);
        // Set the value of $sellingprice based on the selected option
        <?php echo "var sellingprice = document.getElementById('sellingPrice').value;";
        ?>
    }
    </script>
    <div></div><?php
}

// Your existing PHP code...

// Check if $at is zero
if ($at >= 1) {
    // The following code will only be executed when $at is zero
    
     ?>
    <form id=" myForm" action="process_form1.php" method="POST"><label for="quantity">Pieces: </label>
        <input type="text" name="quantity" id="quantity" oninput="calculateAndFill()" required> <label
            for="sellingPrice">Selling Price:</label> <input type="text" name="sellingPrice" id="sellingPrice" readonly>
        <label for="productName">Product Name:</label> <input type="text" name="productName"
            value="<?php echo $mafuta ;?>" id="productName" required readonly> <label for="idNumber">ID Number:</label>
        <input type="text" name="idNumber" id="idNumber" required>
        <input type="submit" value="Submit">
    </form>
    <script>
    // Echo PHP variables into JavaScript
    var sellingprice = <?php echo $sellingPrice;
    ?>;
    var at = <?php echo $at;
    ?>;

    function calculateAndFill() {
        // Get values from the form
        var quantity = parseFloat(document.getElementById('quantity')
            .value); // Check if quantity is a valid number

        if (!isNaN(quantity)) {
            //  Calculate the result
            var result = (quantity * sellingprice) / at;
            console.log(result); // Set the result in the " Selling Price" input field
            document.getElementById('sellingPrice').value = result.toFixed(
                2); // Adjust to your formatting needs } else

            {
                // Handle the case where quantity is not a valid number document.getElementById('sellingPrice').value='' ;
            }
        }
    }
    </script>

    <body><?php
}

?>
        <?php
ob_start(); // Start output buffering

// Your existing PHP code goes here
// ...

$message = "Welcome Search for products!";
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
