<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .apply-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Freelancer</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="jobs.php">Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h1>Apply for Job</h1>
            <p>Complete the form below to apply for this job</p>
        </div>
    </header>

    <!-- Job Apply Form -->
    <div class="container my-5">
        <div class="card apply-card">
            <div class="card-body">
                <h3 class="card-title">Web Developer</h3>
                <p class="card-text text-muted">Posted on: <strong>2024-11-22</strong></p>
                <hr>

                <form action="proses/apply_job_proses.php" method="post" id="applyForm">
                    <!-- Personal Information -->
                    <div class="form-group">
                        <label for="nama">Full Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Your Full Name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your E-mail" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor">Phone Number</label>
                        <input type="text" class="form-control" id="nomor" name="nomor" placeholder="Your Phone Number" required>
                    </div>

                    <!-- Upload Resume -->
                    <div class="form-group">
                        <label for="resume">Upload Your Resume (PDF, DOCX)</label>
                        <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.docx" required>
                    </div>

                    <!-- Cover Letter -->
                    <div class="form-group">
                        <label for="coverLetter">Cover Letter</label>
                        <textarea class="form-control" id="coverLetter" name="coverLetter" rows="4" placeholder="Write your cover letter here" required></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mt-3">Submit Application</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Freelancer. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
