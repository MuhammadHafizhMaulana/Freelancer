<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'worker'){
header('Location: index.php');
exit();
}
include 'proses/koneksi.php';

// Mendapatkan ID proyek dari URL
$id = $_GET['id'] ?? null;

// Menggunakan prepared statement untuk query proyek
$stmt = $connect->prepare("SELECT * FROM `job` WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

if (!$project) {
    die("Proyek tidak ditemukan.");
} 

// Menggunakan prepared statement untuk query pekerja
$id_worker = $project['id_worker'];
$stmtWorker = $connect->prepare("SELECT * FROM `user` WHERE id = ?");
$stmtWorker->bind_param("i", $id_worker);
$stmtWorker->execute();
$resultWorker = $stmtWorker->get_result();
$worker = $resultWorker->fetch_assoc();
$namaPekerja = isset($worker['nama']) ? $worker['nama'] : '';
$fotoPekerja = isset($worker['foto_profile']) ? $worker['foto_profile'] : '';


// Menggunakan prepared statement untuk query client
$id_client = $project['id_client'];
$stmtClient = $connect->prepare("SELECT * FROM `user` WHERE id = ?");
$stmtClient->bind_param("i", $id_client);
$stmtClient->execute();
$resultClient = $stmtClient->get_result();
$client = $resultClient->fetch_assoc();

if (!$project) {
    echo "Proyek tidak ditemukan.";
    exit;
}

if(!$project['status']){
    $status = "published";
} else {
    $status = $project['status'];
    
}

// Memecah string tags menjadi array
$tags = explode(',', $project['kategori']);

// Dummy data pekerja dan owner
$owner = [
    'username' => 'tembokpermata0012',
    'rating' => 0.0,
    'points' => 0,
    'ranking' => 'No Ranking',
    'avatar' => 'owner_avatar.png', // Ganti dengan path file avatar
];

$worker = [
    'username' => 'galihboy',
    'rating' => 10.0,
    'points' => 206,
    'ranking' => '#2,458 dari 1,253,244',
    'avatar' => 'worker_avatar.png', // Ganti dengan path file avatar
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek - <?php echo htmlspecialchars($project['title']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .badge-status {
            background-color: #ffc107;
            color: #000;
            padding: 0.5em 1em;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .owner, .worker {
            text-align: center;
        }
        .owner img, .worker img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 1em;
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
                <p><strong>Finish Days:</strong> <?php echo htmlspecialchars($project['durasi'] ? $project['durasi'] : "" ); ?></p>
                <p><strong>Published Date:</strong> <?php echo htmlspecialchars($project['publish_date'] ? $project['publish_date'] : ""); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($project['start_date'] ?  $project['start_date'] : "-"); ?></p>
                <p><strong>Finish Date:</strong> <?php echo htmlspecialchars($project['finish_date'] ? $project['finish_date'] : "-"); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Project Status:</strong> <span class="badge-status"><?=$status?></span></p>
                <p><strong>Accepted Worker:</strong> <?php echo htmlspecialchars($project['id_worker'] ? $namaPekerja : '-'); ?></p>
                <p><strong>Accepted Budget:</strong> Rp <?php echo htmlspecialchars($project['price'] ?? '-'); ?></p>
                <p><strong>Project Ending:</strong> <?php echo htmlspecialchars($project['ending'] ?? '-'); ?></p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 owner">
                <h4>Project Owner</h4>
                <img src="../assets/foto_profile/<?php echo $client['foto_profile']; ?>" alt="Owner Avatar">
                <p><strong><?php echo htmlspecialchars($client['nama']); ?></strong></p>
                </div>
            <div class="col-md-6 worker">
                <h4>Accepted Worker</h4>
                <?php
                if (!$project['id_worker']) {
                    echo "Bid masih terbuka";
                ?>
                    <br>
                    <br>
                    <a href="apply.php?id=<?= $project['id']?>" class="btn btn-success">Place new bid</a>
                <?php
                } else {
                    ?>
                    <div>
                        <img src="../assets/foto_profile/<?php echo htmlspecialchars($fotoPekerja ?? 'default.png'); ?>" alt="Worker Avatar">
                        <p><strong><?php echo htmlspecialchars($namaPekerja ?? '-'); ?></strong></p>
                    </div>
                    <?php
                }
                ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
