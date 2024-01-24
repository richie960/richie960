<?php
include 'nav.php';
include 'dbconnection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 14px;
            line-height: 1.6;
            overflow-x: auto;
        }

        button {
            width: 100%;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <?php
        $searchResult = '';

        // Check if house number is provided in the URL
        if (isset($_GET['houseNumber'])) {
            $houseNumber = $_GET['houseNumber'];

            $filename = 'saveddata/transactions_data.txt';
            $displayedText = '';

            if (file_exists($filename)) {
                $searchWord = preg_quote($houseNumber, '/');
                $contextLines = 4;
                $handle = fopen($filename, 'r');

                if ($handle) {
                    $lines = file($filename);
                    $lineNumber = 0;

                    while (($line = fgets($handle)) !== false) {
                        $lineNumber++;

                        if (preg_match("/\b$searchWord\b/i", $line)) {
                            $displayedText .= "Match found \n  $lineNumber:\n";
                            $startIndex = max(0, $lineNumber - $contextLines - 1);
                            $endIndex = min(count($lines) - 1, $lineNumber + $contextLines - 1);

                            // Add extra spacing between matched lines for better readability
                            $displayedText .= implode("\n", array_slice($lines, $startIndex, $endIndex - $startIndex + 1));
                            $displayedText .= " \n \n";
                        }
                    }

                    fclose($handle);
                } else {
                    // Display an error message when unable to open the file
                    $searchResult = "<p>Error opening the file.</p>";
                }
            } else {
                // Display an error message when the file is not found
                $searchResult = "<p>File not found.</p>";
            }

            if (!empty($displayedText)) {
                // Output the text content
                echo "<pre>$displayedText</pre>";

                // Add the stylized "Go Back" button and define the goBack function
                echo '<button onclick="goBack()">Go Back</button>';

                echo '<script>';
                echo 'function goBack() {';
                echo '  window.history.back();';
                echo '}';
                echo '</script>';

                exit; // Exit to prevent further HTML rendering
            } else {
                // Display a message when no matches are found
                $searchResult = "<p>Give it about 2 minutes</p>";
            }
        }
        ?>
    </div>

</body>

</html>
