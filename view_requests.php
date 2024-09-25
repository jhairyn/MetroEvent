<?php
// Assuming the user is an organizer and logged in
session_start();
include('db.php');

$organizer_id = $_SESSION['user_id'];

// Fetch events organized by the logged-in user
$events_query = "SELECT * FROM events WHERE organizer_id = '$organizer_id'";
$events = mysqli_query($conn, $events_query);

// Construct the SQL query to fetch pending participant requests
$requests_query = "SELECT r.id, u.name as user_name, e.title as event_name 
                   FROM participation_requests r 
                   JOIN users u ON r.user_id = u.id 
                   JOIN events e ON r.event_id = e.id 
                   WHERE e.organizer_id = '$organizer_id' AND r.status = 'pending'";

// Execute the SQL query on the MySQL connection ($conn) and store the result in $requests
$requests = mysqli_query($conn, $requests_query);

?>
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
                        <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">Pending Request/s</span></h1>
                    </div>
                    
                            <!-- Project Card 1-->
                            <div class="card overflow-hidden shadow rounded-4 border-0 mb-10">
                                <div class="card-body p-1">
                                  <div class="p-5">
                                            

                <!-- Back Button -->
                 <button onclick="history.back()" class="btn btn-secondary mb-3">Back</button>

             <?php if (mysqli_num_rows($requests) > 0): ?>
              <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Event Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($request = mysqli_fetch_assoc($requests)) { ?>
                        <tr>
                            <td><?php echo $request['user_name']; ?></td>
                            <td><?php echo $request['event_name']; ?></td>
                            <td>
                                <a href="approve_request.php?request_id=<?php echo $request['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                <a href="decline_requests.php?request_id=<?php echo $request['id']; ?>" class="btn btn-danger btn-sm">Decline</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending requests at the moment.</p>
        <?php endif; ?>
    </div>
                                                  
                                </div>
                            </div>
                            
    

</footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
