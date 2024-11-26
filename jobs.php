<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'worker'){
header('Location: index.php');
exit();
}
  include 'proses/koneksi.php';

    // Query untuk mengambil semua job
    $query = "SELECT * FROM `job` WHERE `status` = '' OR `status` IS NULL ";
    $sql = mysqli_query($connect, $query);

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
        <?php
        if (mysqli_num_rows($sql) > 0) {
            // Menampilkan semua job
            while ($data = mysqli_fetch_assoc($sql)) {
                echo '
        <!-- Job Card  -->
        <div class="col-md-4 mb-4">
            <div class="card job-card">
                <div class="card-body">
                    <h5 class="card-title">'. htmlspecialchars($data['nama_job']) .'</h5>
                    <p class="card-text">' . htmlspecialchars(mb_strimwidth($data['deskripsi'], 0, 100, '...')) . '</p>
                    <p class="text-muted">'. htmlspecialchars($data['budget']) .'</p>
                    <a href="detailJobs.php" class="btn btn-primary btn-sm">View Details</a>
                    <a href="apply.php?id='. $data['id'].'"class="btn btn-success btn-sm">Apply</a>
                </div>
            </div>
        </div>
        ';
        }
        } else {
            echo '<p class="text-center">Tidak ada job yang ditemukan.</p>';
        }
        ?>
                
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
