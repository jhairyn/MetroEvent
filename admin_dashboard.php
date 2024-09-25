<?php
include 'db.php';
session_start();

if ($_SESSION['role'] != 'admin') {
    echo "<div class='alert alert-danger'>Access denied!</div>";
    exit;
}

// Fetch all pending organizer requests
$sql_organizer_requests = "SELECT * FROM users WHERE role = 'user'";
$organizer_requests = $conn->query($sql_organizer_requests);

// Fetch all pending participation requests
$sql_participation_requests = "SELECT participation_requests.*, users.name AS user_name, events.title AS event_title
                               FROM participation_requests
                               JOIN users ON participation_requests.user_id = users.id
                               JOIN events ON participation_requests.event_id = events.id
                               WHERE participation_requests.status = 'pending'";
$participation_requests = $conn->query($sql_participation_requests);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
        }
        .table-action-button {
            padding: 5px 10px;
            border-radius: 5px;
        }
        .btn-approve {
            background-color: #28a745;
            color: #fff;
            border: none;
        }
        .btn-approve:hover {
            background-color: #218838;
        }
        .btn-decline {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }
        .btn-decline:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>

        <!-- Organizer Requests -->
        <div class="card">
            <div class="card-header">
                Organizer Requests
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($request = $organizer_requests->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['name']); ?></td>
                            <td><?php echo htmlspecialchars($request['email']); ?></td>
                            <td>
                                <form method="POST" action="approve_organizer.php">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                                    <button type="submit" class="btn btn-approve table-action-button">Approve Organizer</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Participation Requests -->
        <div class="card mt-4">
            <div class="card-header">
                Participation Requests
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Event</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($request = $participation_requests->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($request['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($request['event_title']); ?></td>
                            <td>
                                <form method="POST" action="approve_participation.php">
                                    <input type="hidden" name="request_id" value="<?php echo htmlspecialchars($request['id']); ?>">
                                    <button type="submit" class="btn btn-approve table-action-button">Approve</button>
                                    <button type="submit" class="btn btn-decline table-action-button" formaction="decline_participation.php">Decline</button>
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
