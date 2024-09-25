<?php
include('db.php');

$request_id = $_GET['request_id'];
//echo $request_id;
// Update request status to 'accepted'
$update_query = "UPDATE participation_requests SET status = 'accepted' WHERE id = '$request_id'";
mysqli_query($conn, $update_query);

header("Location: dashb.php");
exit;
?>
