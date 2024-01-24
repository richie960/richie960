<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Landing Page</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
    }

    .button-container {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
    }

    .admin-button {
        padding: 15px 20px;
        font-size: 18px;
        text-decoration: none;
        color: #fff;
        background-color: #2196F3;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .admin-button:hover {
        background-color: #0b7dda;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Welcome to Admin Dashboard</h1>

        <div class="button-container">
            <a href="ADMIN.php" class="admin-button">UPDATE & MODIFY STOCK</a>
            <a href="register.php" class="admin-button">REGISTER SELLER</a>
            <a href="search.php" class="admin-button">EMPLOYEE DETAILS</a>
        </div>
    </div>
</body>

</html>