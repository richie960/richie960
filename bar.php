<!DOCTYPE html>
<html>
<head>
    <title>Date Range</title>
    <style>
        .date-range {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
        }
        .date-label {
            font-weight: bold;
        }
        .date-range span {
            margin-right: 20px; /* Increase the margin for spacing */
        }
    </style>
</head>
<body>
    <h1>Date Range</h1>
    <div class="date-range">
        <?php
        // Specify the URL of the text file
        $fileUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt';

        // Fetch the contents of the file from the URL
        $fileContent = file_get_contents($fileUrl);

        // Initialize variables to track the first and last dates
        $firstDate = null;
        $lastDate = null;

        // Split the file content into lines
        $lines = explode("\n", $fileContent);

        foreach ($lines as $line) {
            // Match lines with a date format (e.g., "YYYY-MM-DD HH:MM:SS")
            if (preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $line, $matches)) {
                $date = $matches[0];

                // Initialize the first date if it hasn't been set
                if ($firstDate === null) {
                    $firstDate = $date;
                }

                // Update the last date for each matched line
                $lastDate = $date;
            }
        }

        // Convert the first and last dates to month names
        $startMonthName = date('M', strtotime($firstDate));
        $endMonthName = date('M', strtotime($lastDate));

        // Display the date range horizontally with month names
        echo "<span class='date-label'>$startMonthName:</span> $firstDate";
        echo "<span class='date-label'>$endMonthName:</span> $lastDate";
  
        ?>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction Summary</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
 
    <div style="width: 80%; margin: 0 auto;">
        <canvas id="transactionChart"></canvas>
    </div>

    <?php
    // Specify the URL of the text file
    $fileUrl = 'https://kabaritacoltd.000webhostapp.com/kabarita/saveddata/transactions_data.txt';

    // Fetch the contents of the file from the URL
    $fileContent = file_get_contents($fileUrl);

    // Define an array to store the amounts for each month
    $monthlyAmounts = [];

    // Split the file content into lines
    $lines = explode("\n", $fileContent);

    foreach ($lines as $line) {
        // Check if the line contains "Amount:"
        if (strpos($line, 'Amount:') !== false) {
            // Extract the amount value (assuming it's in the format "Amount: X.XX")
            $amount = (float)str_replace("Amount: ", "", $line);

            // Extract the year, month, and date using string manipulation
            $year = substr($line, 0, 4);
            $month = substr($line, 5, 2);
            $date = substr($line, 8, 2);
            
            // Combine year, month, and date to form YYYY-MM
            $formattedDate = "$year-$month-$date";

            // Debugging: Display the formatted date
          //  echo "Formatted Date: $formattedDate<br>";

            // Add the amount to the corresponding month in the array
            if (!isset($monthlyAmounts[$formattedDate])) {
                $monthlyAmounts[$formattedDate] = 0;
            }
            $monthlyAmounts[$formattedDate] += $amount;
                
        }
    }
    $formattedDates = array_map(function ($date) {
    return date('M d, Y', strtotime($date));
}, array_keys($monthlyAmounts));
    ?>

 <script>
    // Create a bar graph using Chart.js
    var ctx = document.getElementById('transactionChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($monthlyAmounts)); ?>,
            datasets: [{
                label: 'Total Amount',
                data: <?php echo json_encode(array_values($monthlyAmounts)); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Bar color
                borderColor: 'rgba(75, 192, 192, 1)', // Border color
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Amount'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
