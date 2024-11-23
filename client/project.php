<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .status {
            font-weight: bold;
        }
        .status.completed {
            color: green;
        }
        .status.ongoing {
            color: orange;
        }
        .status.pending {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Freelancer Platform</a>
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
                        <a class="nav-link active" href="projects.php">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="../proses/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-center">Your Project History</h1>
            <!-- Button to Create a New Job -->
            <a href="create_job.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create a New Job
            </a>
        </div>
        
        <!-- List of Projects -->
        <div id="project-list">
            <!-- Example Project Card -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Project Title: <span class="text-light">Web Development Project</span></h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Build a responsive website for an e-commerce platform.</p>
                    <p><strong>Categories:</strong> Web Development, Graphic Design</p>
                    <p><strong>Budget:</strong> $500</p>
                    <p><strong>Status:</strong> <span class="status completed">Completed</span></p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5>Project Title: <span class="text-light">Content Writing for Blog</span></h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Write SEO-optimized articles for a tech blog.</p>
                    <p><strong>Categories:</strong> Writing, Marketing</p>
                    <p><strong>Budget:</strong> $200</p>
                    <p><strong>Status:</strong> <span class="status ongoing">Ongoing</span></p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5>Project Title: <span class="text-light">Data Entry Job</span></h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> Input customer data into the company’s CRM system.</p>
                    <p><strong>Categories:</strong> Data Entry</p>
                    <p><strong>Budget:</strong> $150</p>
                    <p><strong>Status:</strong> <span class="status pending">Pending</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
