<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display OrgAccountBalance</title>
</head>
<body>

<script>
    // Function to fetch and display OrgAccountBalance
    function displayOrgAccountBalance() {
        // Specify the path to your JSON file
        const jsonFilePath = 'C2bPesaResponse.json';

        // Fetch the JSON data
        fetch(jsonFilePath)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Check if there are records in the file
                if (Array.isArray(data) && data.length > 0) {
                    // Get the last record
                    const lastRecord = data[data.length - 1];

                    // Check if OrgAccountBalance exists in the last record
                    if (lastRecord.hasOwnProperty('OrgAccountBalance')) {
                        // Extract the OrgAccountBalance from the last record
                        const orgAccountBalance = lastRecord.OrgAccountBalance;

                        // Display the OrgAccountBalance
                        console.log('Current Organization Balance:', orgAccountBalance);

                        // You can display it on the webpage as well, for example, updating an HTML element
                        // document.getElementById('orgBalanceDisplay').textContent = orgAccountBalance;
                    } else {
                        console.log('OrgAccountBalance not found in the last record.');
                    }
                } else {
                    console.log('No records found in the JSON file.');
                }
            })
            .catch(error => {
                console.error('Error fetching or parsing JSON:', error);
            });
    }

    // Call the function to display OrgAccountBalance
    displayOrgAccountBalance();
</script>

</body>
</html>
