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
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .status {
            font-weight: bold;
        }
        .status.completed {
            color: green;
        }
        .status.ongoing {
            color: orange;
        }
        .status.pending {
            color: red;
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

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-center">Your Project History</h1>
            
        </div>
        
        <!-- List of Projects -->
        <?php
        include './proses/koneksi.php';
        $id = $_SESSION['id']; // Ambil ID client dari sesi login
        

        // Query untuk mengambil semua job
        $query = "SELECT * FROM `job` WHERE `id_worker` = '$id'";
        $sql = mysqli_query($connect, $query);

        if (mysqli_num_rows($sql) > 0) {
            // Menampilkan semua job
            while ($data = mysqli_fetch_assoc($sql)) {
                // Jika status tidak ada (null atau kosong), set ke 'Publish'
                $status = !$data['status'] ? 'Publish' : $data['status'];
        
                echo "
                <div class='card mb-3'>
                    <div class='card-body'>
                        <h5 class='card-title'>" . htmlspecialchars($data['nama_job']) . "</h5>
                        <p class='card-text'>" . htmlspecialchars($data['deskripsi']) . "</p>
                        <p class='card-text'><strong>Deal Price:</strong> " . htmlspecialchars($data['price']) . "</p>
                        <p class='card-text'><strong>Start Date:</strong> " . htmlspecialchars($data['start_date']) . "</p>
                        <p class='card-text'><strong>Deadline :</strong> " . htmlspecialchars($data['deadline_job']) . "</p>
                        <p class='card-text'><strong>Status :</strong> " . htmlspecialchars($data['status']) . "</p>
                        <a href='detailJobs.php?id=" . htmlspecialchars($data['id']) . "' class='btn btn-primary'>Lihat Detail</a>
                ";
        
                // Jika status adalah null, tambahkan tombol "View All Pelamar"
                if ($data['status'] === "On Proses") {
                    echo "<a href='uploadTugas.php?id=" . htmlspecialchars($data['id']) . "' class='btn btn-secondary'>Upload Tugas</a>";
                }
        
                echo "
                    </div>
                </div>
                ";
            }
        }
        else {
            // Jika tidak ada job
            echo "<p>Tidak ada job yang ditemukan.</p>";
        }
        ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
