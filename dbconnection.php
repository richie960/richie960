<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'id21132835_root');
define('DB_PASSWORD', 'Kabarita@1');
define('DB_NAME', 'id21132835_mpesa');
try {
  $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
    echo "Connection failed";
  }
//  else 
   //echo "suceed";
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}