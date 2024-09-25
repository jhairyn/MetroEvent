<?php
// Connection to the database
include('db.php');

// Function to handle user requests to become an organizer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Check if the user already requested
    $checkRequest = $db->prepare("SELECT * FROM organizer_requests WHERE user_id = ?");
    $checkRequest->execute([$user_id]);

    if ($checkRequest->rowCount() > 0) {
        echo "You have already requested to become an organizer.";
    } else {
        // Insert the request
        $stmt = $db->prepare("INSERT INTO organizer_requests (user_id, status) VALUES (?, 'pending')");
        $stmt->execute([$user_id]);
        echo "Your request has been submitted.";
    }
}
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
    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html"><span class="fw-bolder text-primary">Emerging Technology</span></a>
                    
             </div>
                </div>   </nav>

                <div class="container px-5 my-5">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">HELLO USER!</span></h1>
                </div>
        <div class="card">
        <div class="card-header">
           Request to Become an Organizer
        </div><div class="card shadow border-0 rounded-4 mb-5">
                                <div class="card-body p-5">
                                    <div class="row align-items-center gx-5">
            <form method="POST" action="request_organizer.php">
        <input type="hidden" name="user_id" value="1"> <!-- Pass the user ID dynamically -->
        <button type="submit">Request to Become Organizer</button>
    </form>
               
        </div></div> </nav>

         <!-- Navigation-->
    
        <div class="card-header">
          <h3>Notifications</h3>
        </div><div class="card shadow border-0 rounded-4 mb-5">
                                <div class="card-body p-5">
                                    <div class="row align-items-center gx-5">
            <div id="notifications">
        <!-- Notifications will be dynamically loaded here -->
    </div> 

    <script>
        // Replace '1' with the actual logged-in user ID dynamically
        getNotifications(1); 
    </script>


        



                                            </div>
                </div></nav>

</body>
</html>