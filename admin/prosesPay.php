<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: ../index.php');
    exit();
}

include '../proses/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['id'];
    
    // Periksa apakah file telah diunggah
    if (isset($_FILES['buktiTf']) && $_FILES['buktiTf']['error'] === 0) {
        $fileTmpName = $_FILES['buktiTf']['tmp_name'];
        $fileExtension = pathinfo($_FILES['buktiTf']['name'], PATHINFO_EXTENSION);
        
        // Tentukan nama file berdasarkan ID proyek
        $fileName = "payment_" . $projectId . "." . $fileExtension;
        $uploadDir = '../assets/paymentAdmin/';

        // Pastikan direktori tujuan ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Tentukan path lengkap file
        $filePath = $uploadDir . $fileName;

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($fileTmpName, $filePath)) {
            // Simpan ke database
            $query = "UPDATE job SET status = 'Done', paymentAdmintoWorker = ? WHERE id = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("si", $fileName, $projectId);
            if ($stmt->execute()) {
                header('Location: ./manageProjects.php?message=payment');
                exit();
            } else {
                echo "Database error: " . $connect->error;
            }
            $stmt->close();
        } else {
            echo "Failed to upload file.";
        }
    } else {
        echo "No file uploaded or there was an error.";
    }
}
?>
