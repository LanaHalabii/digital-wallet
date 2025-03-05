<?php 

$dbhost = "http://13.38.76.3/"; 
$dbuser = "root";         
$dbpassword = "Lana1234";             
$dbname = "digital_wallet";  

$conn = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";


?>