<?php
// admin_decision.php
include('db_connection.php');

// Function for admin to approve or decline requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $decision = $_POST['decision']; // accepted or declined

    // Update the request status
    $stmt = $db->prepare("UPDATE organizer_requests SET status = ? WHERE id = ?");
    $stmt->execute([$decision, $request_id]);

    // Fetch user ID from the request
    $user = $db->prepare("SELECT user_id FROM organizer_requests WHERE id = ?");
    $user->execute([$request_id]);
    $user_id = $user->fetchColumn();

    // Insert notification for the user
    $message = ($decision == 'accepted') ? 'Your request to become an organizer was accepted.' : 'Your request to become an organizer was declined.';
    $notify = $db->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $notify->execute([$user_id, $message]);

    echo "Request has been " . $decision;
}
?>
