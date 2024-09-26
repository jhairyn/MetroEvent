<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Jhairyn D. Sobrevega</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Custom Google font-->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column h-100 bg-light">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html"><span class="fw-bolder text-primary">Emerging Technology</span></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        
                    </div>
                </div>
            </nav>
            <!-- Projects Section-->
            <section class="py-5">
                <div class="container px-5 mb-5">
                    <div class="text-center mb-5">
                        <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Dashboard</span></h1>
                    </div>
                    
                            <!-- Project Card 1-->
                            <div class="card overflow-hidden shadow rounded-4 border-0 mb-5">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center">
                                        <div class="p-10">
                                            <h2 class="fw-bolder">CREATE and MANAGE EVENTS, VIEW PARTICIPANTS.</h2>
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include 'db.php';

// Fetch all events from the database
$sql_events = "SELECT events.*, users.name AS organizer_name 
                FROM events 
                JOIN users ON events.organizer_id = users.id";
$result_events = $conn->query($sql_events);

echo $event['title'];
?>
<?php
ob_start();
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Include database connection
include 'db.php';

// Fetch all events from the database
$sql_events = "SELECT events.*, users.name AS organizer_name 
                FROM events 
                JOIN users ON events.organizer_id = users.id";
$result_events = $conn->query($sql_events);

echo $event['title'];

// Include Bootstrap CSS for styling
echo '<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
echo $_SESSION['role'];
echo '<style>
        .container {
            margin-top: 20px;
        }
        .dashboard-header {
            margin-bottom: 20px;
        }
        .nav-link {
            color: #007bff;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
    </style>';

// Role-based content display
echo '<div class="container">';
if ($_SESSION['role'] == 'admin') {
    echo '<div class="dashboard-header">';
    echo '<h2>Admin Dashboard</h2>';
    echo '<p>CREATE and MANAGE EVENTS, LIST OF PARTICIPANTS.</p>';
    echo '</div>';
    echo '<nav class="nav">';
    echo '<a class="nav-link" href="manage_users.php">Manage Users</a>';
    echo '<a class="nav-link" href="view_reports.php">View Reports</a>';
    echo '<a class="nav-link" href="settings.php">System Settings</a>';
    echo '</nav>';
} elseif ($_SESSION['role'] == 'organizer') {
    echo '<div class="dashboard-header">';
    echo '</div>';
    echo '<nav class="nav">';
    echo '<a class="nav-link" href="create_event.php">Create Event</a>';
    echo '<a class="nav-link" href="view_requests.php">Requests</a>';
    echo '<a class="nav-link" href="view_participants.php">View Participants</a>';
    echo '<form method="POST" action="logout.php">';
    echo '<button type="submit" class="btn btn-danger">Logout</button>';
    echo '</form>';
    echo '</nav>';

    // Display all events in a table
    echo '<h3>All Events</h3>';

    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Title</th>';
    echo '<th>Description</th>';
    echo '<th>Date</th>';
    echo '<th>Location</th>';
    echo '<th>Organizer</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($event = $result_events->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($event['title']) . '</td>';
        echo '<td>' . htmlspecialchars($event['description']) . '</td>';
        echo '<td>' . htmlspecialchars($event['date']) . '</td>';
        echo '<td>' . htmlspecialchars($event['location']) . '</td>';
        echo '<td>' . htmlspecialchars($event['organizer_name']) . '</td>';
        echo '<td>';
        echo '<a href="edit_event.php?id=' . $event['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
        echo '<form method="POST" action="delete_event.php" style="display:inline;" onsubmit="return confirmDelete();">';
        echo '<input type="hidden" name="event_id" value="' . $event['id'] . '">';
        echo '<button type="submit" class="btn btn-danger btn-sm">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="dashboard-header">';
    echo '<h2>User Dashboard</h2>';
    echo '<p>Explore upcoming events and manage your participation.</p>';
    echo '</div>';
    echo '<nav class="nav">';
    echo '<a class="nav-link" href="events.php">View Events</a>';
    echo '<a class="nav-link" href="my_participations.php">My Participations</a>';
    echo '<button type="submit" class="btn btn-info">Req. Organizer Role</button>'; 
    echo '<form method="POST" action="logout.php">';
    echo '<button type="submit" class="btn btn-danger">Logout</button>';
    echo '</form>';
    echo '</nav>';
}
echo '</div>';

// Logout Button
echo '<div class="container"></div>';

// Include Bootstrap JS and dependencies
echo '<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>';
echo '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>';
echo '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';

// JavaScript confirmation function
echo '<script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this event?");
        }
    </script>';

if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">';
    echo $_SESSION['error'];
    unset($_SESSION['error']);
    echo '</div>';
}

if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">';
    echo $_SESSION['message'];
    unset($_SESSION['message']);
    echo '</div>';
}
    ob_end_flush();
?>
                                        
                                </div>
                            </div>
                            
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
