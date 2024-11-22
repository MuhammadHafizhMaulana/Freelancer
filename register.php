<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .registrasi-container {
            background: #ffffff33;
            backdrop-filter: blur(10px);
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 500px;
        }
        .btn-secondary:disabled {
            background-color: #ccc;
            border-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="registrasi-container">
        <h1 class="text-center mb-4">Registrasi</h1>
        <?php
        if (isset($_GET['gagal'])) {
            if ($_GET['gagal'] == "nomor") {
                echo "<div class='alert alert-danger'>Nomor HP atau Email telah terdaftar. Silahkan gunakan yang baru.</div>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan</div>";
            }
        }
        ?>
        <form action="proses/registrasi_proses.php" method="post" id="formRegistrasi">
            <div class="form-group mb-3">
                <label for="nama">Nama Lengkap</label>
                <input oninput="formValid()" type="text" class="form-control registrasi-form" id="nama" name="nama" placeholder="Nama Lengkap" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">E-mail</label>
                <input oninput="formValid()" type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
            </div>

            <div class="form-group mb-3">
                <label for="nomor">Nomor Telepon</label>
                <input oninput="formValid()" type="text" class="form-control registrasi-form" id="nomor" name="nomor" placeholder="Nomor Telepon" required>
                <div id="nomorAlert" class="form-text text-danger"></div>
            </div>
            
            <!-- Input Role -->
            <div class="form-group mb-3">
                <label for="role">Pilih Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="" disabled selected>-- Pilih Role Anda --</option>
                    <option value="client">Client</option>
                    <option value="worker">Worker</option>
                </select>
            </div>

            <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input oninput="formValid()" type="password" class="form-control registrasi-form" id="password" name="password" placeholder="Password" required>
                            <div id="passwordAlert" class="form-text text-danger"></div>
                        </div>
                        

            <button onclick="openSpinner()" id="submitButton" type="submit" disabled class="btn btn-secondary w-100">
                Registrasi
            </button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/loginDanDaftar.js"></script> 
</body>
</html>
