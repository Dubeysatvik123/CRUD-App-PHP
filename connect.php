<?php
$host     = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$database = getenv('DB_NAME') ?: 'crudapp';

$conn = mysqli_connect($host, $username, $password, $database, 3306);

if (!$conn) {
    die("Error in connection: " . mysqli_connect_error());
} else {
    // echo "Connection successful";
}
?>
