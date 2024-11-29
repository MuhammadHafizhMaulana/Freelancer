<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'worker'){
header('Location: index.php');
exit();
}

include './proses/koneksi.php';
    $id = $_GET['id'];
    $query = "SELECT * FROM `user` WHERE `id` = '$id' ";
    $sql = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($sql);

    if(!$data['foto_profile']){
        $fotoProfile = 'https://via.placeholder.com/150';
    } else {
        $fotoProfile = "./assets/foto_profile/" . $data['foto_profile'];
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .profile-header {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            padding: 30px 0;
            text-align: center;
        }
        .profile-card {
            margin-top: -50px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
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
                        <a class="nav-link" href="Profile.php">Profile</a>
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

    <!-- Profile Header -->
    <div class="profile-header">
        <h1>Your Profile</h1>
        <p>Manage your account and personal information</p>
    </div>

    <!-- Profile Card -->
    <div class="container" style="min-height: 60vh;" >
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-card">
                    <div class="mb-3 text-center">
                            <img src="<?= $fotoProfile ?>" alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
                            <br>
                    </div>
                        
                    <?php
                        // pesan jika sukses
                        if (isset($_GET['success']) && $_GET['success'] == 'foto') {
                            echo "<div class='alert alert-success'>Foto Profil Berhasil di Unggah</div>";
                        }
                        ?>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?=$data['nama']?>" disabled>
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
