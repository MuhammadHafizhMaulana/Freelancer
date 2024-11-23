<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sambungan ke koneksi
    include 'koneksi.php';

    // Inisialisasi data dari POST
    $nama_job = ucwords(strtolower($_POST['nama_job']));
    $deskripsi = $_POST['deskripsi'];
    $deadline = $_POST['deadline'];
    $budget = $_POST['budget_min'] . "-" . $_POST['budget_max'];
    $job_category = $_POST['job_category'];
    $id_client = $_POST['id_client'];

     // Gabungkan kategori menjadi string untuk disimpan dalam database
     $kategori = implode(", ", $job_category);

    // Persiapkan query dengan prepared statement
    $query = "INSERT INTO `job`( `id_client`, `nama_job`, `deskripsi`, `budget`, `kategori`, `deadline` ) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);

    if ($stmt) {
        // Bind parameter ke placeholder
        mysqli_stmt_bind_param($stmt, "sssiss", $id_client, $nama_job, $deskripsi, $budget, $kategori, $deadline  );

        // Jalankan prepared statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Ambil ID pengguna yang baru saja ditambahkan
            // Redirect jika berhasil
            header('Location: ../client/home.php?success=1');
            exit();
        } else {
            // Tampilkan pesan jika gagal
            echo "Tambah data job gagal: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        // Tampilkan pesan jika persiapan statement gagal
        echo "Error persiapan query job: " . mysqli_error($connect);
    }

    // Tutup koneksi
    mysqli_close($connect);
} else {
    // Jika permintaan bukan dari metode POST
    echo 'method_not_allowed';
}
?>
