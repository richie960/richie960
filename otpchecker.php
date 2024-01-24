<?php
include('dbconnection.php');

$message = ''; // Variable to store messages for the user

// Check if OTP verification is successful
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the entered OTP
    $userEnteredOTP = filter_input(INPUT_POST, 'otp', FILTER_SANITIZE_STRING);

    if ($userEnteredOTP !== null && $userEnteredOTP !== false) {
        $checkOtpSql = "SELECT HouseNumber FROM login_details WHERE otp = ? LIMIT 1";
        $stmt = $db->prepare($checkOtpSql);

        // Bind parameters
        $stmt->bind_param("s", $userEnteredOTP);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $houseNumber = $row['HouseNumber'];

            // Redirect to another page with the HouseNumber and OTP in the URL
            header("Location: https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/index.php?houseNumber=$houseNumber&otp=$userEnteredOTP");
            exit;
        } else {
            $message = "Invalid OTP";
        }

        // Close the statement
        $stmt->close();
    } else {
        $message = "Invalid input";
    }
}

$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2980b9;
        }

        /* Loading styles */
        #loading-container {
            text-align: center;
        }

        #loading {
            width: 0;
            height: 30px;
            background-color: #00cc00;
            transition: width 0.5s ease-in-out, background-color 2s ease-in-out;
        }

        #contact-admin-link {
            color: #3498db;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div id="loading-container">
        <h2>Hang Tight! The OTP takes less than 1 minute...</h2>
        <div id="loading"></div>
    </div>

    <h2>Enter OTP</h2>

    <?php echo $message; // Display any messages ?>

    <form action="" method="post">
        <label for="otp">OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <button type="submit">Submit</button>
    </form>

    <p id="contact-admin">
        If it has not arrived yet, dial *456*9*5*5*1# (will outomatically take you to login page or)
        <span id="contact-admin-link">contact admin</span> using this <a id="whatsapp-link" href="#" target="_blank">link</a>.
    </p>

    <script>
        function simulateLoading() {
            let loadingElement = document.getElementById("loading");
            let width = 0;
            let colors = ["#00cc00", "#ff6600", "#ff3300", "#ff0000"];
            let colorIndex = 0;
            let duration = 90; // Duration in seconds
            let intervalDuration = (duration * 1000) / 100; // Interval duration for a smooth transition

            let interval = setInterval(function() {
                if (width >= 100) {
                    clearInterval(interval);
                    // Redirect to login page after completion
                    window.location.href = "https://kabaritacoltd.000webhostapp.com/kabarita/startbootstrap-sb-admin-2-master/login.html";
                } else {
                    width++;
                    loadingElement.style.width = width + "%";
                    if (width % 10 === 0) {
                        colorIndex = (colorIndex + 1) % colors.length;
                        loadingElement.style.backgroundColor = colors[colorIndex];
                    }
                }
            }, intervalDuration);
        }

        simulateLoading();

        // Make the contact admin link clickable
        document.getElementById("contact-admin-link").addEventListener("click", function() {
            window.location.href = "https://wa.me/254770467092?text=Hello! I need to change my phone number. I can't receive OTP. Please help! - Kabarita General Agency";
        });

        // Update the WhatsApp link with your admin's phone number
        const whatsappLink = document.getElementById("whatsapp-link");
        whatsappLink.href = "https://wa.me/254770467092?text=Hello! I need to change my phone number. I can't receive OTP. Please help! - Kabarita General Agency";
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