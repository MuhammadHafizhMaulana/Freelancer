<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail - Freelancer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .job-detail-card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .apply-btn {
            display: flex;
            justify-content: center;
            margin-top: 20px;
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
                        <a class="nav-link" href="logout.html">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h1>Job Detail</h1>
            <p>Explore the full details of this job opportunity</p>
        </div>
    </header>

    <!-- Job Detail -->
    <div class="container my-5">
        <div class="card job-detail-card">
            <div class="card-body">
                <h3 class="card-title">Web Developer</h3>
                <p class="card-text text-muted">Posted on: <strong>2024-11-22</strong></p>
                <hr>
                <h5>Job Description</h5>
                <p>
                    We are looking for an experienced web developer to build and maintain a responsive website. The ideal candidate should have knowledge of HTML, CSS, JavaScript, and basic PHP.
                </p>
                <h5>Requirements</h5>
                <ul>
                    <li>Proficiency in HTML, CSS, and JavaScript</li>
                    <li>Experience with responsive design</li>
                    <li>Basic understanding of PHP and MySQL</li>
                </ul>
                <h5>Budget and Duration</h5>
                <p><strong>Budget:</strong> $500</p>
                <p><strong>Duration:</strong> 3 months</p>
                <h5>Additional Details</h5>
                <p>
                    This project requires weekly updates and close collaboration with our design team. The website must be fully optimized for mobile devices and meet current accessibility standards.
                </p>
            </div>
        </div>

        <!-- Apply Button -->
        <div class="apply-btn">
            <a href="apply.php" class="btn btn-success btn-lg">
                Apply Now
            </a>
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
