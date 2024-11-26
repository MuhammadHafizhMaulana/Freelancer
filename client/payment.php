<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login'){
header('Location: index.php');
}

include '../proses/koneksi.php';

// Mendapatkan ID proyek dari URL
$id = $_GET['id'] ?? null;

// Validasi ID
if (!$id) {
    die("ID proyek tidak ditemukan.");
}

// Menggunakan prepared statement untuk query proyek
$stmt = $connect->prepare("SELECT * FROM `job` WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$selected_categories = explode(',', $data['kategori']);
$price = $data['price'] * 5 / 100;
$totalPrice =  $data['price'] + $price ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .apply-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Freelancer Platform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="project.php">Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../proses/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h1>Payment</h1>
            <p>Complete the form below to complete payment</p>
        </div>
    </header>

    <!-- Job Apply Form -->
    <div class="container my-5">
        <div class="card apply-card">
            <div class="card-body">
                <h3 class="card-title"><?=$data['nama_job']?></h3>
                <p class="card-text text-muted">Total Budget: <strong><?=$totalPrice ?></strong></p>
                <p class="card-text text-muted">Posted on: <strong><?=$data['publish_date'] ?></strong></p>
                <p class="card-text text-muted">Deadline: <strong><?=$data['deadline_job'] ?></strong></p>

                <hr>

                <form action="../proses/paymentProses.php" method="post" id="applyForm" enctype="multipart/form-data">
                    <!-- Upload Bukti Pembayaran -->
                    <div class="form-group">
                        <label for="resume">Upload Bukti Pembayaran</label>
                        <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" required>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="id_job" name="id_job" value="<?php echo $data['id']; ?>" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
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
