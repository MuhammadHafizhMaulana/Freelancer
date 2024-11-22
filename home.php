<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login'){
header('Location: index.php');
}

    include 'proses/koneksi.php';
    $id = $_SESSION['id'];
    $query = "SELECT * FROM `user` WHERE `id` = '$id' ";
    $sql = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($sql);

    // $query = "SELECT * FROM `pembiayaan` WHERE `id_user` = '$id' ";
    // $sql = mysqli_query($connect, $query);
    // $pembiayaan = mysqli_fetch_assoc($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .welcome-section {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            padding: 50px 0;
            text-align: center;
        }
        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
            transition: 0.3s;
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
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobs.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./proses/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="container">
            <h1>Welcome, <?= $data['nama'] ?></h1>
            <p>Find the best freelance jobs and opportunities just for you!</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mt-4">
        <h2 class="text-center mb-4">Explore Jobs</h2>
        <div class="row">
            <!-- Job Card 1 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Web Development</h5>
                        <p class="card-text">Looking for a web developer to create a modern website.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Job Card 2 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Graphic Design</h5>
                        <p class="card-text">Need a graphic designer for logo creation.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
            <!-- Job Card 3 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Content Writing</h5>
                        <p class="card-text">Hiring a writer to create SEO-friendly blog articles.</p>
                        <a href="#" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5">
        <div class="container py-3 text-center">
            <p>&copy; 2024 Freelancer. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
