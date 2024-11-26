<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'client'){
header('Location: ../index.php');
exit();
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
$project = $result->fetch_assoc();
// Memisahkan budget menjadi min dan max
$budgetParts = explode('-', $project['budget']);
$budget_min = trim($budgetParts[0] ?? 0);
$budget_max = trim($budgetParts[1] ?? 0);

$selected_categories = explode(',', $project['kategori']);

// Menentukan apakah elemen input harus dinonaktifkan
$disabled = $project['status'] ? 'disabled' : ''; 

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

// Proses update data jika form disubmit

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek - <?php echo htmlspecialchars($project['nama_job']); ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-primary">Edit Proyek</h2>
        <form method="POST" action="../proses/editJob.php">
            <div class="mb-3">
                <label for="nama_job" class="form-label">Nama Proyek</label>
                <input type="text" class="form-control" id="nama_job" name="nama_job" value="<?php echo htmlspecialchars($project['nama_job']); ?>" <?= $disabled; ?> required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required <?= $disabled; ?> ><?php echo htmlspecialchars($project['deskripsi']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="budget" class="form-label">Budget Min</label>
                <input type="number" class="form-control" id="budget_min" name="budget_min" value="<?php echo htmlspecialchars($budget_min); ?>" required <?= $disabled; ?> >
            </div>
            <div class="mb-3">
                <label for="budget" class="form-label">Budget Max</label>
                <input type="number" class="form-control" id="budget_max" name="budget_max" value="<?php echo htmlspecialchars($budget_max); ?>" required <?= $disabled; ?> >
            </div>
            <div class="mb-3">
                <label for="durasi" class="form-label">Durasi (Hari)</label>
                <input type="number" class="form-control" id="durasi" name="durasi" value="<?php echo htmlspecialchars($project['durasi']); ?>" required <?= $disabled; ?> >
            </div>
           <!-- Job Category -->
            <div class="form-group mb-3">
                <label>Job Categories (Select up to 5)</label>
                <div id="job_category_container">
                    <?php
                    // Daftar kategori
                    $categories = [
                        'Web Development',
                        'Graphic Design',
                        'Writing',
                        'Marketing',
                        'Data Entry',
                        'Other'
                    ];

                    // Loop untuk membuat checkbox
                    foreach ($categories as $category) {
                        // Periksa apakah kategori dipilih
                        $isChecked = in_array($category, $selected_categories) ? 'checked' : '';
                    ?>
                        <div class="form-check">
                            <input class="form-check-input category-checkbox" type="checkbox" 
                                value="<?php echo htmlspecialchars($category); ?>" 
                                id="<?php echo strtolower(str_replace(' ', '_', $category)); ?>" 
                                name="kategori[]" <?php echo $isChecked; ?> <?= $disabled; ?> >
                            <label class="form-check-label" for="<?php echo strtolower(str_replace(' ', '_', $category)); ?>">
                                <?php echo htmlspecialchars($category); ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <small id="category_alert" class="form-text text-danger"></small>
            </div>
            <div class="mb-3">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $project['id']; ?>" required>
            </div>
             <!-- Tombol Submit -->
            <?php if (!$project['status']): ?>
                <button type="submit" class="btn btn-primary">Update Project</button>
                <a href="project.php" class="btn btn-secondary">Kembali</a>
            <?php else: ?>
                <p class="text-danger"><em>Proyek ini tidak dapat diubah karena status sudah ditentukan.</em></p>
                <a href="project.php" class="btn btn-secondary">Kembali</a>
                <?php
                if($project['status'] == "Verify" || $project['status'] == "Waiting Payment" ) {?>
                    <a href="lihatResult.php?id=<?=$project['id']?>" class="btn btn-success">View Result</a>
                <?php
                }
                ?>
            <?php endif; ?>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
