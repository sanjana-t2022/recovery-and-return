<?php
$conn = new mysqli("localhost", "root", "Mysqlacc@407", "lost_and_found");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
