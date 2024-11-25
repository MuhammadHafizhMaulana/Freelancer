<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan direktori target sudah ada
    $targetDir = "../assets/foto_profile/";

    // Membuat folder jika belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Fungsi untuk mengunggah file
    function uploadFile($fileInputName, $targetDir, $id, $suffix) {
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
                echo "File " . htmlspecialchars($newFileName) . " telah diunggah ke folder 'foto_profile/'.<br>";
                return $newFileName;
            } else {
                echo "Maaf, ada kesalahan saat mengunggah file " . $fileInputName . ".<br>";
                return false;
            }
        }
        return false;    
    }

    // Fungsi untuk menyimpan nama file ke dalam database
    function uploadImageToDatabase($imageFileName) {
        include 'koneksi.php';
    
        // Pastikan session_start() sudah dipanggil
        session_start();
    
        // Ambil ID pengguna dari sesi
        $id = $_SESSION['id'];
    
        // Menyimpan nama file gambar ke database
        $sql = "UPDATE user SET foto_profile = ? WHERE id = ?";
        $stmt = mysqli_prepare($connect, $sql);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $imageFileName, $id);
            $result = mysqli_stmt_execute($stmt);
    
            if ($result) {
                // Menggunakan prepared statement untuk query proyek
                $stament = $connect->prepare("SELECT * FROM `user` WHERE id = ?");
                $stament->bind_param("i", $id);
                $stament->execute();
                $result = $stament->get_result(); // Perbaikan: gunakan $stament
                $data = $result->fetch_assoc();
    
                // Redirect berdasarkan role
                if ($data['role'] === "worker") {
                    header('Location: ./../profile.php?success=1'); // Redirect jika berhasil
                    exit(); // Pastikan eksekusi berhenti setelah redirect
                } else if ($data['role'] === "client") {
                    header('Location: ./../client/profile.php?success=1'); // Redirect jika berhasil
                    exit(); // Pastikan eksekusi berhenti setelah redirect
                }
            } else {
                echo "Tambah data user gagal: " . mysqli_stmt_error($stmt); // Menampilkan error jika gagal
            }
    
            mysqli_stmt_close($stmt);
        } else {
            echo "Gagal menyiapkan query: " . mysqli_error($connect);
        }
    
        // Tutup koneksi
        mysqli_close($connect);
    }
    

    // Ambil ID pengguna dari sesi
    $id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : '';

    // Memanggil fungsi untuk mengunggah file
    if (isset($_FILES['foto_profile'])) {
        $fileName = uploadFile('foto_profile', $targetDir, $id, 'profile');
        if ($fileName) {
            // Setelah berhasil upload, simpan nama file ke database
            uploadImageToDatabase($fileName);
        }
    } else {
        echo "Input tidak masuk";
    }
}
?>
