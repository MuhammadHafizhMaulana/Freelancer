<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sambungan ke koneksi
    include 'koneksi.php';

    // Inisialisasi data dari POST
    $nama = ucwords(strtolower($_POST['nama']));
    $email = $_POST['email'];
    $nomor = $_POST['nomor'];
    $passwordDefault = $_POST['password'];
    $role = $_POST['role'];

    // Validasi password dengan pola tertentu
    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()-_=+{};:,<.>])(?=.*[0-9]).{8,}$/';
    if (!preg_match($passwordPattern, $passwordDefault)) {
        header('Location: ../daftar.php?error=password');
        exit(); // Batalkan proses jika password tidak sesuai pola
    }

    // Validasi nomor HP dengan pola tertentu
    $nomorPattern = '/^[0-9]+$/';
    if (!preg_match($nomorPattern, $nomor)) {
        header('Location: ../registrasi.php?error=nomorFormat');
        exit(); // Batalkan proses jika nomor HP tidak sesuai pola
    }

    // Cek apakah nomor HP sudah ada di database
    $queryCheck = "SELECT COUNT(*) AS total FROM user WHERE nomor = ? OR `email` = ?";
    $stmtCheck = mysqli_prepare($connect, $queryCheck);
    mysqli_stmt_bind_param($stmtCheck, "ss", $nomor, $email); // Gunakan $email
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_bind_result($stmtCheck, $total);
    mysqli_stmt_fetch($stmtCheck);
    mysqli_stmt_close($stmtCheck);


    if ($total > 0) {
        // Jika nomor HP dan email sudah ada, batalkan proses
        header('Location: ../register.php?gagal=nomor');
        exit();
    }

    $password = password_hash($passwordDefault, PASSWORD_DEFAULT);

    // Persiapkan query dengan prepared statement
    $query = "INSERT INTO `user`(`nama`, `email`, `nomor`, `role`, `password` ) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);

    if ($stmt) {
        // Bind parameter ke placeholder
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $email, $nomor, $role, $password );

        // Jalankan prepared statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Ambil ID pengguna yang baru saja ditambahkan
            // Redirect jika berhasil
            header('Location: ../index.php?success=1');
            exit();
        } else {
            // Tampilkan pesan jika gagal
            echo "Tambah data user gagal: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Tampilkan pesan jika persiapan statement gagal
        echo "Error persiapan query user: " . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
} else {
    // Jika permintaan bukan dari metode POST
    echo 'method_not_allowed';
}
?>
