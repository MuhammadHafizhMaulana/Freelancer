<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan direktori target untuk menyimpan bukti pembayaran
    $targetDir = "../assets/payment/";

    // Membuat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Fungsi untuk mengunggah file bukti pembayaran
    function uploadPaymentProof($fileInputName, $targetDir, $id, $suffix) {
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($_FILES[$fileInputName]["name"], PATHINFO_EXTENSION));

        // Ganti nama file sesuai ID dan suffix
        $newFileName = $id . "_" . $suffix . "." . $imageFileType;
        $targetFile = $targetDir . $newFileName;

        // Periksa apakah file adalah gambar
        $check = getimagesize($_FILES[$fileInputName]["tmp_name"]);
        if ($check !== false) {
            echo "File " . $fileInputName . " adalah gambar - " . $check["mime"] . ".<br>";
        } else {
            echo "File " . $fileInputName . " bukan gambar.<br>";
            $uploadOk = 0;
        }

        // Periksa ukuran file (maksimal 2MB)
        if ($_FILES[$fileInputName]["size"] > 2000000) {
            echo "Maaf, file " . $fileInputName . " terlalu besar.<br>";
            $uploadOk = 0;
        }

        // Izinkan format file tertentu
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan untuk " . $fileInputName . ".<br>";
            $uploadOk = 0;
        }

        // Cek apakah upload diperbolehkan
        if ($uploadOk == 0) {
            echo "Maaf, file " . $fileInputName . " tidak terunggah.<br>";
        } else {
            if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
                echo "File " . htmlspecialchars($newFileName) . " telah diunggah ke folder 'payment/'.<br>";
                return $newFileName;
            } else {
                echo "Maaf, ada kesalahan saat mengunggah file " . $fileInputName . ".<br>";
                return false;
            }
        }
        return false;    
    }

    // Fungsi untuk menyimpan informasi bukti pembayaran ke database
    function savePaymentProofToDatabase($id_job, $paymentProofFileName) {
        include 'koneksi.php';

        // Pastikan session sudah dimulai
        session_start();

        // Simpan bukti pembayaran ke tabel `jobs`
        $sql = "UPDATE job SET payment = ?, status = 'Complete' WHERE id = ?";
        $stmt = mysqli_prepare($connect, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $paymentProofFileName, $id_job);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                header('Location: ../client/project.php?success=pay');
                // Redirect jika berhasil
                exit();
            } else {
                echo "Gagal menyimpan data pembayaran: " . mysqli_stmt_error($stmt); // Menampilkan error jika gagal
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal menyiapkan query: " . mysqli_error($connect);
        }

        // Tutup koneksi
        mysqli_close($connect);
    }

    // Ambil ID job dari sesi
    $id_job = isset($_POST['id_job']) ? htmlspecialchars($_POST['id_job']) : '';
    if (empty($id_job)) {
        echo "ID pekerjaan tidak valid.<br>";
        exit();
    }

    // Memanggil fungsi untuk mengunggah bukti pembayaran
    if (isset($_FILES['bukti_bayar'])) {
        $fileName = uploadPaymentProof('bukti_bayar', $targetDir, $id_job, 'bukti_bayar');
        if ($fileName) {
            // Setelah berhasil upload, simpan informasi ke database
            savePaymentProofToDatabase($id_job, $fileName);
        }
    } else {
        echo "Tidak ada file yang diunggah.";
    }
}
?>
