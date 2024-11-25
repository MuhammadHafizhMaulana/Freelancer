<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sambungan ke koneksi
    include 'koneksi.php';

    $nama_job = $_POST['nama_job'];
    $id = $_POST['id'];
    $deskripsi = $_POST['deskripsi'];
    $budget = $_POST['budget'];
    $durasi = $_POST['durasi'];
    $status = $_POST['status'];
    $budget = implode(" - ", [$_POST['budget_min'],$_POST['budget_max']] );
    $publish_date = date('Y-m-d H:i:s');

    // Update data proyek di database
    $updateStmt = $connect->prepare(
        "UPDATE `job` SET nama_job = ?, deskripsi = ?, budget = ?, durasi = ?, publish_date = ?, status = ? WHERE id = ?"
    );
    $updateStmt->bind_param("sssissi", $nama_job, $deskripsi, $budget, $durasi, $publish_date, $status, $id);
    if ($updateStmt->execute()) {
        // Refresh data
        header("Location: ../client/detailJob.php?id=$id ");
    } else {
        echo "<div class='alert alert-danger'>Gagal memperbarui data.</div>";
    }
}

?>