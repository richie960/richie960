<?php
include 'nav.php';
include 'dbconnection.php';

$searchResult = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $houseNumber = $_POST['searchWord'];

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
        echo '<button onclick="goBack()" style="width: 150px; background-color: #3498db; color: #fff; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">';
        echo '<span class="arrow">&#8592;</span> Go Back';
        echo '</button>';
        
        echo '<script>';
        echo 'function goBack() {';
        echo '  window.history.back();';
        echo '}';
        echo '</script>';

        exit; // Exit to prevent further HTML rendering
    } else {
        // Display a message when no matches are found
        $searchResult = "<p>No matches found.</p>";
    }
}
?>

  <!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 3px;
            cursor: pointer;
        }

        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border: 1px solid #ddd;
            white-space: pre-wrap;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        .download-link {
            margin-top: 10px;
            font-size: 16px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
        }

        .download-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Search Results</h1>
    <form method="post">
        <label for="searchWord">Enter a house number to search receipt:</label>
        <input type="text" id="searchWord" name="searchWord" required>
        
        <button type="submit">Search</button>
    </form>
</div>
<div class="container">
    <?php

    if (!empty($searchResult)) {

        echo $searchResult;
    }
   
    ?>
    
</div>

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
</br>
<br>
</br>
<br>
<br>

<?php include 'footer.php';?>
</body>
<br

</html>
