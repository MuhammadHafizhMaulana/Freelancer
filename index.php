<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/index.css">
    </head>
<body>
    <div class="login-container text-center">
        <h1 class="mb-4">Login to Freelancer</h1>
        <form id="formLogin" action="./proses/loginProses.php" method="post" >
            <div class="mb-3">
                <input type="text" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="mt-3">
            <a href="register.php" class="link">Don't have an account? Register here</a>
        </div>
    </div>
</body>
</html>
