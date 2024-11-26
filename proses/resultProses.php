<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login'){
    header('Location: index.php');
    exit;
}

include 'koneksi.php';

// Proses tombol Acc dan Decline
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['action'] ?? '';
    $newStatus = '';
    $id = $_POST['id'];

    if ($status === 'acc') {
        $newStatus = 'Waiting Payment';
    } elseif ($status === 'decline') {
        $newStatus = 'On Proses';
    }

    if ($newStatus) {
        // Update status proyek di database
        $updateStmt = $connect->prepare("UPDATE `job` SET status = ? WHERE id = ?");
        $updateStmt->bind_param("si", $newStatus, $id);
        $updateStmt->execute();

        // Redirect setelah update
        header("Location: ../client/lihatResult.php?id=$id");
        exit();
    }
}
?>