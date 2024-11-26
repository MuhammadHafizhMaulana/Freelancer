<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}

include '../proses/koneksi.php';

// Periksa apakah ID proyek tersedia
if (!isset($_GET['id'])) {
    echo "Project ID is missing!";
    exit();
}

$projectId = $_GET['id'];

// Ambil informasi proyek
$query = "SELECT * FROM job WHERE id = ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("i", $projectId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Project not found!";
    exit();
}

$project = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Pay for Project: <?php echo htmlspecialchars($project['nama_job']); ?></h2>
        <div class="card mt-4">
            <div class="card-body">
                <form action="prosesPay.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $project['id']; ?>">

                    <div class="mb-3">
                        <label for="buktiTf" class="form-label">Upload Bukti Transfer</label>
                        <input type="file" class="form-control" id="buktiTf" name="buktiTf" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                    <a href="manageProject.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
