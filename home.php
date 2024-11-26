<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'worker'){
header('Location: index.php');
exit();
}

    include 'proses/koneksi.php';
    $id = $_SESSION['id'];
    $query = "SELECT * FROM `user` WHERE `id` = '$id' ";
    $sql = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($sql);

    include 'proses/koneksi.php';

    // Query untuk mengambil semua job
    $query = "SELECT * FROM `job` WHERE `status` = '' OR `status` IS NULL LIMIT 9 ";
    $sql = mysqli_query($connect, $query);

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
        .job{
            min-height: 50vh;
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
                        <a class="nav-link" href="myJobs.php">My Jobs</a>
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

    <!-- Job Section -->
    <div class="container job mt-4">
        <h2 class="text-center mb-4">Explore Jobs</h2>
        <div class="row">
            <?php
            if (mysqli_num_rows($sql) > 0) {
                // Menampilkan semua job
                while ($data = mysqli_fetch_assoc($sql)) {
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($data['nama_job']) . '</h5>
                                <p class="card-text">' . htmlspecialchars(mb_strimwidth($data['deskripsi'], 0, 100, '...')) . '</p>
                                <a href="detailJobs.php?id=' . $data['id'] . '" class="btn btn-primary">View Details</a>
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
        <!-- Tombol Lihat Semua Job -->
        <div class="text-center mt-4">
            <a href="jobs.php" class="btn btn-secondary">Lihat Semua Job</a>
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
