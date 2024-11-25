<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login'){
header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .job-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .job-card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Freelancer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="myJobs.php">My Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="jobs.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./proses/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h1>Available Jobs</h1>
            <p>Browse and apply for jobs that match your skills</p>
        </div>
    </header>

    <!-- Job Listings -->
    <div class="container my-5">
        <div class="row">
            <!-- Job Card 1 -->
            <div class="col-md-4 mb-4">
                <div class="card job-card">
                    <div class="card-body">
                        <h5 class="card-title">Web Developer</h5>
                        <p class="card-text">Looking for a web developer with experience in HTML, CSS, and JavaScript. Duration: 3 months</p>
                        <p class="text-muted">Budget: $500</p>
                        <a href="detailJobs.php" class="btn btn-primary btn-sm">View Details</a>
                        <button class="btn btn-success btn-sm">Apply</button>
                    </div>
                </div>
            </div>
            <!-- Job Card 2 -->
            <div class="col-md-4 mb-4">
                <div class="card job-card">
                    <div class="card-body">
                        <h5 class="card-title">Graphic Designer</h5>
                        <p class="card-text">Seeking a creative graphic designer for branding and logo design. Duration: 1 month</p>
                        <p class="text-muted">Budget: $300</p>
                        <a href="job-detail.html?id=2" class="btn btn-primary btn-sm">View Details</a>
                        <button class="btn btn-success btn-sm">Apply</button>
                    </div>
                </div>
            </div>
            <!-- Job Card 3 -->
            <div class="col-md-4 mb-4">
                <div class="card job-card">
                    <div class="card-body">
                        <h5 class="card-title">Content Writer</h5>
                        <p class="card-text">Need a content writer for blog posts and articles on tech topics. Duration: 2 weeks</p>
                        <p class="text-muted">Budget: $150</p>
                        <a href="job-detail.html?id=3" class="btn btn-primary btn-sm">View Details</a>
                        <button class="btn btn-success btn-sm">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Freelancer. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
