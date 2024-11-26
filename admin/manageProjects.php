<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include '../proses/koneksi.php'; // Pastikan koneksi database tersedia
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link active" href="manageProjects.php">Manage Projects</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Manage Projects</h1>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Project Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Client</th>
                        <th>Worker</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT 
                                job.id, 
                                job.nama_job, 
                                job.deskripsi, 
                                job.status, 
                                job.price,
                                client.nama AS client_name,
                                worker.nama AS worker_name
                            FROM 
                                job
                            JOIN 
                                user AS client ON job.id_client = client.id
                            LEFT JOIN 
                                user AS worker ON job.id_worker = worker.id;";
                    $result = mysqli_query($connect, $query);
                    $no = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_job']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['price'] ? $row['price'] : "-")  . "</td>";
                            echo "<td>" . htmlspecialchars($row['status'] ? $row['status'] : "Published") . "</td>";
                            echo "<td>" . htmlspecialchars($row['client_name'] ?$row['client_name'] : "-" ) . "</td>";
                            echo "<td>" . htmlspecialchars($row['worker_name'] ? $row['worker_name'] : "-" ) . "</td>";
                            echo "<td>";

                            // Tombol Pay jika status adalah Complete
                            if ($row['status'] === 'Complete') {
                                echo " <a href='payProject.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Pay</a>";
                            } else if ($row['status'] === 'Done'){
                                echo " <form action='deleteProject.php' method='POST' class='d-inline'>
                                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                       </form>";
                            }
                    
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                     else {
                        echo "<tr><td colspan='6' class='text-center text-danger'>No projects found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date('Y'); ?> Admin Dashboard - All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
