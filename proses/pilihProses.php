<?php
include 'koneksi.php'; // Koneksi ke database

// Ambil data dari URL
$id_worker = isset($_GET['id_worker']) ? intval($_GET['id_worker']) : 0;
$id_job = isset($_GET['id_job']) ? intval($_GET['id_job']) : 0;
$id_lamaran = isset($_GET['id_lamaran']) ? intval($_GET['id_lamaran']) : 0;

if ($id_worker && $id_job && $id_lamaran) {
    // Mulai transaksi
    $connect->begin_transaction();

    try {
        // Ambil bid_price dari lamaran
        $sqlBidPrice = "SELECT bid_price FROM lamaran WHERE id = ?";
        $stmtBidPrice = $connect->prepare($sqlBidPrice);
        $stmtBidPrice->bind_param("i", $id_lamaran);
        $stmtBidPrice->execute();
        $stmtBidPrice->bind_result($bid_price);
        $stmtBidPrice->fetch();
        $stmtBidPrice->close();  // Menutup statement setelah mengambil data

        // Ambil data dari tabel job (misalnya job_title atau data lainnya)
        $sqlJob = "SELECT start_date, durasi FROM job WHERE id = ?";
        $stmtJob = $connect->prepare($sqlJob);
        $stmtJob->bind_param("i", $id_job);
        $stmtJob->execute();
        $stmtJob->bind_result($start_date, $durasi);
        $stmtJob->fetch();
        $stmtJob->close();  // Menutup statement setelah mengambil data

        // Update status lamaran
        $sqlLamaran = "UPDATE lamaran SET status = 'check' WHERE id_worker = ? AND id_job = ?";
        $stmtLamaran = $connect->prepare($sqlLamaran);
        $stmtLamaran->bind_param("ii", $id_worker, $id_job);
        $stmtLamaran->execute();

        // Hitung finish_date berdasarkan start_date dan durasi
        $finish_date = strtotime($start_date . " + $durasi days");  // Asumsi durasi dalam hari
        $finish_date = date('Y-m-d H:i:s', $finish_date);  // Ubah ke format tanggal yang sesuai

        // Update status pekerjaan dan set start_date
        $start_date = date('Y-m-d H:i:s');
        $sqlJob = "UPDATE job SET status = 'On Proses', start_date = ?, id_worker = ?, price = ?, finish_date = ? WHERE id = ?";
        $stmtJob = $connect->prepare($sqlJob);
        $stmtJob->bind_param("siisi", $start_date, $id_worker, $bid_price, $finish_date, $id_job );  // Bind start_date sebagai string dan id_worker, bid_price, id_job sebagai integer
        $stmtJob->execute();

        // Commit transaksi
        $connect->commit();

        echo "<script>alert('Pekerja berhasil dipilih, status diperbarui menjadi On Proses.'); window.location='../client/pelamar.php?id={$id_job}';</script>";
    } catch (Exception $e) {
        // Rollback jika ada kesalahan
        $connect->rollback();
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Data tidak valid.'); window.history.back();</script>";
}
?>
