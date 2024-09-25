<?php
include 'db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    echo "Access denied!";
    exit;
}

$user_id = $_POST['user_id'];

// Update user role to organizer
$sql = "UPDATE users SET role = 'organizer' WHERE id = '$user_id'";
if ($conn->query($sql) === TRUE) {
    echo "Organizer approved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>
