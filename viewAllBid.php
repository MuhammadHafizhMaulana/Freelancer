<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'worker'){
header('Location: ../index.php');
exit();
}

include './proses/koneksi.php'; // Pastikan file koneksi sudah disiapkan

// Ambil ID job dari parameter URL
$job_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

// Query untuk mengambil data dari tabel lamaran berdasarkan ID job
$sql = "SELECT lamaran.id_worker, lamaran.resume, lamaran.bid_price, lamaran.id, lamaran.status, lamaran.deskripsi, user.nama, user.nomor, user.id 
        FROM lamaran 
        JOIN user ON lamaran.id_worker = user.id 
        WHERE lamaran.id_job = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Daftar Pelamar</h1>
        <a href="detailJobs.php" class="btn btn-secondary mb-3">Kembali</a>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Bid Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><a href="userLain.php?id=<?= $row['id'] ?>"><?php echo htmlspecialchars($row['nama']); ?></a></td>
                            <td><?php echo htmlspecialchars($row['bid_price']); ?></td>
                            
                        </tr>

                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                Belum ada pelamar untuk job ini.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
