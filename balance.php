<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance Calculation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h2 {
            color: #333;
        }
        .summary {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Balance Calculation</h2>

    <?php
    include 'dbconnection.php';

    // Calculate total deposit
    $totalDepositQuery = "SELECT SUM(DefaultDeposit) AS total_deposit FROM default_deposits";
    $totalDepositResult = $db->query($totalDepositQuery);
    $totalDeposit = $totalDepositResult->fetch_assoc()['total_deposit'];

    // Calculate total amount
    $totalAmountQuery = "SELECT SUM(Amount) AS total_amount FROM transactions";
    $totalAmountResult = $db->query($totalAmountQuery);
    $totalAmount = $totalAmountResult->fetch_assoc()['total_amount'];

    // Calculate balance
    $balance = $totalDeposit - $totalAmount;

    $db->close();
    ?>

    <div class="summary">
        <p>Total Deposit: ksh
        <?php echo $totalDeposit; ?></p>
        <p>Total Amount: ksh
        <?php echo $totalAmount; ?></p>
        <p>Balance: ksh
        <?php echo $balance; ?></p>
    </div>
</body>
</html>
