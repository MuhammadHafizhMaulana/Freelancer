<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'client'){
header('Location: ../index.php');
exit();
}

include '../proses/koneksi.php'; // Pastikan file koneksi sudah disiapkan

// Ambil ID job dari parameter URL
$job_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

// Query untuk mengambil data dari tabel lamaran berdasarkan ID job
$sql = "SELECT lamaran.id_worker, lamaran.resume, lamaran.bid_price, lamaran.id, lamaran.status, lamaran.deskripsi, user.nama, user.nomor 
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
        <a href="project.php" class="btn btn-secondary mb-3">Kembali</a>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Resume</th>
                        <th>Bid Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = $result->fetch_assoc()): 
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                            <td>
                                <a href="../assets/file/<?php echo htmlspecialchars($row['resume']); ?>" 
                                target="_blank" class="btn btn-sm btn-primary">Lihat Resume</a>
                            </td>
                            <td><?php echo htmlspecialchars($row['bid_price']); ?></td>
                            <td>
                                <!-- Tombol Pilih atau Check -->
                                <?php if ($row['status'] == 'check') : ?>
                                    <!-- Jika status 'check', tampilkan tombol Check -->
                                    <a href="javascript:void(0);" class="btn btn-sm btn-warning">Check</a>
                                    <a href="https://wa.me/<?php echo '62' . substr($row['nomor'], 1); ?>" target="_blank" class="btn btn-sm btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat" viewBox="0 0 16 16">
  <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
</svg></a>
                                <?php else : ?>
                                    <!-- Jika status bukan 'check', tampilkan tombol Pilih -->
                                    <a href="../proses/pilihProses.php?id_worker=<?php echo htmlspecialchars($row['id_worker']); ?>&id_job=<?php echo $job_id; ?>&id_lamaran=<?php echo $row['id']; ?>"
                                    class="btn btn-sm btn-success">Pilih</a>
                                <?php endif; ?>
                            </td>
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
