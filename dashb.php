<?php
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection (ensure your database credentials are correct in db.php)
include 'db.php';

// Fetch user role and details (assuming users table has 'id', 'name', and 'role' columns)
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT name, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $role);
$stmt->fetch();
$stmt->close();

// Store role in session
$_SESSION['role'] = $role;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Role Based Display</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Main Dashboard Container -->
<div class="container mt-5">
    <h1 class="text-center">Welcome, <?php echo htmlspecialchars($name); ?></h1>
    <h3 class="text-center">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></h3>
    
    <!-- Admin Dashboard -->
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <div class="dashboard-header">
            <h2>Admin Dashboard</h2>
            <p>CREATE and MANAGE EVENTS, LIST OF PARTICIPANTS.</p>
        </div>
        <nav class="nav">
            <a class="nav-link" href="manage_users.php">Manage Users</a>
            <a class="nav-link" href="view_reports.php">View Reports</a>
            <a class="nav-link" href="settings.php">System Settings</a>
        </nav>

    <!-- Organizer Dashboard -->
    <?php elseif ($_SESSION['role'] == 'organizer'): ?>
        <div class="dashboard-header">
            <h2>Organizer Dashboard</h2>
            <p>CREATE and MANAGE YOUR EVENTS.</p>
        </div>
        <nav class="nav">
            <a class="nav-link" href="create_event.php">Create Event</a>
            <a class="nav-link" href="view_requests.php">View Requests</a>
            <a class="nav-link" href="view_participants.php">View Participants</a>
        </nav>

        <!-- Fetch and Display Events for Organizer -->
        <h3>All Events</h3>
        <?php
        // Fetch all events from the database
        $sql_events = "SELECT events.*, users.name AS organizer_name 
                        FROM events 
                        JOIN users ON events.organizer_id = users.id 
                        WHERE organizer_id = ?";
        $stmt_events = $conn->prepare($sql_events);
        $stmt_events->bind_param("i", $user_id);
        $stmt_events->execute();
        $result_events = $stmt_events->get_result();
        ?>

        <!-- Display events in a table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Organizer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = $result_events->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                    <td><?php echo htmlspecialchars($event['description']); ?></td>
                    <td><?php echo htmlspecialchars($event['date']); ?></td>
                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                    <td><?php echo htmlspecialchars($event['organizer_name']); ?></td>
                    <td>
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="delete_event.php" style="display:inline;" onsubmit="return confirmDelete();">
                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

    <!-- Regular User Dashboard -->
    <?php else: ?>
        <div class="dashboard-header">
            <h2>User Dashboard</h2>
            <p>Explore upcoming events and manage your participation.</p>
        </div>
        <nav class="nav">
            <a class="nav-link" href="events.php">View Events</a>
            <a class="nav-link" href="my_participations.php">My Participations</a>
            <form method="POST" action="request_organizer.php">
                <button type="submit" class="btn btn-info">Request Organizer Role</button>
            </form>
        </nav>
    <?php endif; ?>

    <!-- Logout Button -->
    <form method="POST" action="logout.php">
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this event?");
    }
</script>

</body>
</html>

<?php
// Close database connection
$conn->close();
?>
