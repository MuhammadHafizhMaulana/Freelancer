<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'client'){
header('Location: ../index.php');
exit();
}

include '../proses/koneksi.php';

// Mendapatkan ID proyek dari URL
$id = $_GET['id'] ?? null;

if ($id === null) {
    echo "Proyek tidak ditemukan.";
    exit;
}

// Menggunakan prepared statement untuk query proyek
$stmt = $connect->prepare("SELECT * FROM `job` WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    echo "Proyek tidak ditemukan.";
    exit;
}

// Mengambil file hasil dari folder assets/result
$resultFiles = array_diff(scandir('../assets/result/'), array('.', '..'));
$result = $project['result'];

// Menggunakan prepared statement untuk query pekerja
$id_worker = $project['id_worker'];
$stmtWorker = $connect->prepare("SELECT * FROM `user` WHERE id = ?");
$stmtWorker->bind_param("i", $id_worker);
$stmtWorker->execute();
$resultWorker = $stmtWorker->get_result();
$worker = $resultWorker->fetch_assoc();

// Menggunakan prepared statement untuk query client
$id_client = $project['id_client'];
$stmtClient = $connect->prepare("SELECT * FROM `user` WHERE id = ?");
$stmtClient->bind_param("i", $id_client);
$stmtClient->execute();
$resultClient = $stmtClient->get_result();
$client = $resultClient->fetch_assoc();

// Status project
$status = $project['status'] ?? "published"; // Default 'published' jika status kosong

// Memecah string tags menjadi array
$tags = explode(',', $project['kategori']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek - <?php echo htmlspecialchars($project['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge-status {
            background-color: #ffc107;
            color: #000;
            padding: 0.5em 1em;
            border-radius: 5px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
<?php
// Periksa apakah parameter success ada di URL
if (isset($_GET['success']) && $_GET['success'] =='result'): ?>
    <script>
        // Tampilkan alert menggunakan JavaScript
        alert("Tindakan berhasil dilakukan!");
    </script>
<?php endif; ?>
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

    <div class="container mt-4">
        <h2 class="text-danger mt-3"><?php echo htmlspecialchars($project['nama_job']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($project['deskripsi'])); ?></p>
        <div>
            <?php foreach ($tags as $tag): ?>
                <span class="badge bg-secondary"><?= htmlspecialchars(trim($tag)) ?></span>
            <?php endforeach; ?>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <p><strong>Published Budget:</strong> Rp <?php echo htmlspecialchars($project['budget']); ?></p>
                <p><strong>Finish Days:</strong> <?php echo htmlspecialchars($project['durasi']); ?></p>
                <p><strong>Published Date:</strong> <?php echo htmlspecialchars($project['publish_date']); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date']); ?></p>
                <p><strong>Finish Date:</strong> <?php echo htmlspecialchars($project['deadline_job']); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Project Status:</strong> <span class="badge-status"><?= htmlspecialchars($status); ?></span></p>
                <p><strong>Accepted Worker:</strong> <?php echo htmlspecialchars($worker['nama'] ?? 'Not assigned yet'); ?></p>
                <p><strong>Accepted Budget:</strong> Rp <?php echo htmlspecialchars($project['price'] ?? '-'); ?></p>
                <p><strong>Project Ending:</strong> <?php echo htmlspecialchars($project['ending'] ?? '-'); ?></p>
            </div>
        </div>

        <hr>

        <h4 class="text-primary">Hasil Proyek</h4>
        <?php if (!empty($result)): ?>
            <div class="list-group mb-3">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="assets/result/<?php echo htmlspecialchars($result); ?>" target="_blank" class="text-decoration-none text-info">
                        <?php echo htmlspecialchars($result); ?>
                    </a>
                    <?php if ($status == "Verify"): ?>
                    <div class="btn-group" role="group">
                        <form method="POST" action="../proses/resultProses.php" class="d-inline">
                            <input type="hidden" name="id" value="<?= $project['id'] ?>">
                            <button type="submit" name="action" value="acc" class="btn btn-success btn-sm">Accept</button>
                        </form>
                        <form method="POST" action="../proses/resultProses.php" class="d-inline">
                            <input type="hidden" name="id" value="<?= $project['id'] ?>">
                            <button type="submit" name="action" value="decline" class="btn btn-danger btn-sm">Decline</button>
                        </form>
                    </div>
                    <?php elseif ($status == "Waiting Payment"): ?>
                    <form method="POST" action="payment.php" class="d-inline">
                        <input type="hidden" name="id" value="<?= $projectId ?>">
                        <button class="btn btn-success btn-sm" disabled>Waiting for Payment</button>
                        <a href="payment.php?id=<?= $project['id'] ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Pay
                        </a>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No file available.</p>
        <?php endif; ?>

        <hr>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
