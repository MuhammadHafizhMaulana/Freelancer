<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="manageUsers.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="manageProjects.php">Manage Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="reports.php">Reports</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white" href="../proses/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5" style="min-height: 70vh;" >
        <h1 class="text-center mb-4">Welcome, Admin</h1>
        <div class="row">
            <!-- Total Users -->
            <div class="col-md-4">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text">
                            <?php
                            include '../proses/koneksi.php';
                            $query = "SELECT COUNT(*) as total FROM user";
                            $result = mysqli_query($connect, $query);
                            $data = mysqli_fetch_assoc($result);
                            echo $data['total'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Total Projects -->
            <div class="col-md-4">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Projects</h5>
                        <p class="card-text">
                            <?php
                            $query = "SELECT COUNT(*) as total FROM job";
                            $result = mysqli_query($connect, $query);
                            $data = mysqli_fetch_assoc($result);
                            echo $data['total'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Pending Approvals -->
            <div class="col-md-4">
                <div class="card bg-warning text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Approvals</h5>
                        <p class="card-text">
                            <?php
                            $query = "SELECT COUNT(*) as total FROM job WHERE status = 'complete'";
                            $result = mysqli_query($connect, $query);
                            $data = mysqli_fetch_assoc($result);
                            echo $data['total'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row text-center">
            <div class="col-md-6">
                <a href="manageUsers.php" class="btn btn-primary w-100 mb-3">Manage Users</a>
            </div>
            <div class="col-md-6">
                <a href="manageProjects.php" class="btn btn-primary w-100 mb-3">Manage Projects</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> Admin Dashboard - All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
