<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan direktori target sudah ada
    $targetDir = "../assets/result/";

    // Membuat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Fungsi untuk mengunggah file
    function uploadFile($fileInputName, $targetDir, $id_job, $id, $suffix) {
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));

        // Ganti nama file sesuai ID dan suffix
        $newFileName = $id_job . "_" .$id . "_" . $suffix . "." . $fileType;
        $targetFile = $targetDir . $newFileName;

        // Format yang diizinkan
        $allowedTypes = ['pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx'];

        // Periksa apakah file adalah jenis yang diizinkan
    if (!in_array($fileType, $allowedTypes)) {
        echo "Maaf, hanya file dengan format berikut yang diperbolehkan: " . implode(', ', $allowedTypes) . ".<br>";
        $uploadOk = 0;
    }

        // Periksa ukuran file (maksimal 5MB)
        if ($_FILES[$fileInputName]["size"] > 5000000) {
            echo "Maaf, file terlalu besar. Maksimal 5MB.<br>";
            $uploadOk = 0;
        }

        // Cek apakah upload diperbolehkan
        if ($uploadOk == 0) {
            echo "Maaf, file tidak terunggah.<br>";
        } else {
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                echo "File " . htmlspecialchars($newFileName) . " telah diunggah ke folder 'result'.<br>";
                return $newFileName;
            } else {
                echo "Maaf, ada kesalahan saat mengunggah file.<br>";
                return false;
            }
        }
        return false;
    }

    // Fungsi untuk menyimpan nama file ke dalam database
    function uploadResultToDatabase($resultFileName, $status, $finish_date, $id_job ) {
        include 'koneksi.php';

        // Query untuk menyimpan result ke dalam kolom
        $sql = "UPDATE job SET result = ?, status = ?, finish_date =? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssi", $resultFileName,$status, $finish_date, $id_job);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Redirect jika berhasil
                header('Location: ../myJobs.php?success=uplod');
                exit(); // Pastikan eksekusi berhenti setelah redirect
            } else {
                echo "Tambah data result gagal: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal menyiapkan query: " . mysqli_error($connect);
        }

        // Tutup koneksi
        mysqli_close($connect);
    }

    // Ambil ID job dan worker dari form
    $id_job = isset($_POST['id_job']) ? htmlspecialchars($_POST['id_job']) : '';
    $id_worker = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : '';
    $finish_date = date('Y-m-d H:i:s');
    $status = "Verify";

    // Memanggil fungsi untuk mengunggah file result
    if (isset($_FILES['result'])) {
        $fileName = uploadFile('result', $targetDir,$id_job,  $id_worker, 'result');
        if ($fileName) {
            // Setelah berhasil upload, simpan nama file ke database
            uploadResultToDatabase($fileName, $status, $finish_date, $id_job);
        }
    } else {
        echo "Input file tidak ditemukan.";
    }
}
?>
