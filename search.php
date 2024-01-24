<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Member by ID</title>
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
        <h2>Search Member by ID</h2>
        <form action="" method="post">
            <label for="searchIdno">Enter IDNO:</label>
            <input type="text" name="searchIdno" id="searchIdno" required>
            <input type="submit" value="Search">
        </form>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "stock"; // Replace with your actual database name

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $searchIdno = $_POST["searchIdno"];

            $searchQuery = "SELECT * FROM registration WHERE IDNO = '$searchIdno'";
            $result = $conn->query($searchQuery);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h2>Member Details</h2>";
                echo "First Name: " . $row["firstname"] . "<br>";
                echo "Last Name: " . $row["lastname"] . "<br>";
                echo "IDNO: " . $row["IDNO"] . "<br>";
            } else {
                echo "No member found with the entered IDNO.";
            }
        }

        $conn->close();
        ?>
    </div>
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
