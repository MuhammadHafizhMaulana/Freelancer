<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan direktori target sudah ada
    $targetDir = "../assets/file/";

    // Membuat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Fungsi untuk mengunggah file
    function uploadFile($fileInputName, $targetDir, $id, $suffix) {
        $uploadOk = 1;
        $fileType = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));

        // Ganti nama file sesuai ID dan suffix
        $newFileName = $id . "_" . $suffix . "." . $fileType;
        $targetFile = $targetDir . $newFileName;

        // Periksa apakah file adalah PDF atau format yang diizinkan
        if ($fileType != 'pdf') {
            echo "Maaf, hanya file PDF yang diperbolehkan.<br>";
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
                echo "File " . htmlspecialchars($newFileName) . " telah diunggah ke folder 'file'.<br>";
                return $newFileName;
            } else {
                echo "Maaf, ada kesalahan saat mengunggah file.<br>";
                return false;
            }
        }
        return false;    
    }

    // Fungsi untuk menyimpan nama file resume ke dalam database
    function uploadResumeToDatabase($resumeFileName, $id_job, $id_worker, $deskripsi, $price) {
        include 'koneksi.php';

        // Pastikan session_start() sudah dipanggil
        session_start();

        // Menyimpan nama file resume ke database
        $sql = "INSERT INTO lamaran (id_job, id_worker, resume, deskripsi, bid_price) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "iissi", $id_job, $id_worker, $resumeFileName, $deskripsi, $price);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Redirect jika berhasil
                header('Location: ../home.php?success=apply');
                exit(); // Pastikan eksekusi berhenti setelah redirect
            } else {
                echo "Tambah data lamaran gagal: " . mysqli_stmt_error($stmt); // Menampilkan error jika gagal
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
    $deskripsi = $_POST['deskripsi'];
    $price = $_POST['bid_price'];
    $id_worker = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : '';

    // Memanggil fungsi untuk mengunggah file resume
    if (isset($_FILES['resume'])) {
        $fileName = uploadFile('resume', $targetDir, $id_worker, 'resume');
        if ($fileName) {
            // Setelah berhasil upload, simpan nama file ke database
            uploadResumeToDatabase($fileName, $id_job, $id_worker, $deskripsi, $price);
        }
    } else {
        echo "Input tidak masuk";
    }
}
?>
