<?php
include 'db.php';
session_start();

$alertMessage = '';
$alertType = '';

// Check if the user is logged in and if their role is 'organizer'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'organizer') {
    echo "<div class='alert alert-danger'>Access denied!</div>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $organizer_id = $_SESSION['user_id'];

    // Insert event into the database using prepared statements
    $sql = "INSERT INTO events (title, description, date, location, organizer_id)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $title, $description, $date, $location, $organizer_id);

    if ($stmt->execute()) {
        // Display success alert and redirect using JavaScript
        echo "<script>
                alert('Event created successfully!');
                window.location.href = 'organiser_dashboard.php';
              </script>";
        exit();  // Make sure to exit after outputting the JavaScript
    } else {
        $alertMessage = "Error: " . $stmt->error;
        $alertType = "danger";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Event Creation</title>
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
                    <!-- Add navigation links if needed -->
                </div>
            </div>
        </nav>
        <!-- Event Creation Section-->
        <section class="py-5">
            <div class="container px-5 mb-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Create Event</span></h1>
                </div>

                <!-- Event Creation Form -->
                <div class="card overflow-hidden shadow rounded-4 border-0 mb-10">
                    <div class="card-body p-5">
                        <!-- Display success or error messages -->
                        <?php if ($alertMessage): ?>
                            <div class="alert alert-<?= $alertType; ?>">
                                <?= $alertMessage; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Event Form -->
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date">Date:</label>
                                <input type="datetime-local" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Location:</label>
                                <input type="text" id="location" name="location" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Event</button>
                            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
