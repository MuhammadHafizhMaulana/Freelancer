<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $query = "DELETE FROM job WHERE id = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header('Location: ../admin/manageProjects.php?message=ProjectDeleted');
    } else {
        header('Location: ../admin/manageProjects.php?message=DeleteFailed');
    }
    exit();
}
?>
