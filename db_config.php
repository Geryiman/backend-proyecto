<?php
// backend/db_config.php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'transportes_aliance';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
