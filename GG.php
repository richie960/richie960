<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display House Data</title>
    <style>
        .red-rectangle {
            width: 300px;
            height: 100px;
            background-color: red;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
    </style>
</head>
<body>
    <div id="dataContainer"></div>
<script>
    function fetchAndDisplayData() {
        fetch("fetch_house_information.php")
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error("Error fetching data: " + data.error);
                } else {
                    displayHouseData(data);
                }
            });
    }

    function getCurrentTimestamp() {
        const now = new Date();
        return now.toLocaleTimeString(); // Adjust the timestamp format as needed
    }

    function displayHouseData(data) {
        var container = document.getElementById("dataContainer");

        // Iterate through each data entry
        data.forEach(entry => {
            // Create a red rectangle div
            var div = document.createElement("div");
            div.className = "red-rectangle";

            // Set the content of the red rectangle with timestamp
            div.innerHTML = `<p>House Number: ${entry.houseNumber}</p>
                             <p>Amount: ${entry.Amount}</p>
                             <p>Remaining Amount: ${entry.remainingAmount}</p>
                             <p>Timestamp: ${getCurrentTimestamp()}</p>`;

            // Append the red rectangle to the container
            container.appendChild(div);

            // Set a timeout to remove the red rectangle after 5 seconds
            setTimeout(() => {
                container.removeChild(div);
            }, 5000);
        });
    }

    // Fetch and display data initially, then set an interval to fetch every 1 second
    fetchAndDisplayData();
    setInterval(fetchAndDisplayData, 30000);
</script>


  
</body>
</html>
