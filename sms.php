<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        section {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

    <header>
        <h1>Test Page</h1>
    </header>

    <section>
        <h2>Welcome to the test page!</h2>
        <p>This is a simple HTML and CSS example for testing purposes.</p>
    </section>

    <footer>
        <p>&copy; 2024 Test Page</p>
    </footer>

</body>
</html>

<?php
// Parameters
$partnerID = '8854';
$mobile = '0746465349';
$apikey = '70efa65617bcc559666d74e884c3abb6';
$shortcode = 'Savvy_sms';
$message = 'test';

// Construct the URL with parameters
$url = 'https://sms.savvybulksms.com/api/services/sendsms';
$url .= '?partnerID=' . urlencode($partnerID);
$url .= '&mobile=' . urlencode($mobile);
$url .= '&apikey=' . urlencode($apikey);
$url .= '&shortcode=' . urlencode($shortcode);
$url .= '&message=' . urlencode($message);

// Send an HTTP POST request to the URL
$response = file_get_contents($url);

// Check if the request was successful
if ($response !== false) {
  // Output the response message
  echo $response;
} else {
  // Failed to send message
  echo 'Failed to send message.';
}
?>
