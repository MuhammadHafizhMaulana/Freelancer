<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !== 'login' || $_SESSION['role'] !== 'client'){
header('Location: ../index.php');
exit();
}

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Job/Project</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
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
                        <a class="nav-link active" href="project.php">Project</a>
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
        <h1 class="mb-4 text-center">Create a New Job/Project</h1>
        
        <form action="../proses/create_job_proses.php" method="post">
            <!-- Id Client -->
            <div class="form-group mb-3">
                <input type="hidden" class="form-control" id="id_client" name="id_client"
                value="<?= $_SESSION['id'] ?>" placeholder="Enter job title" required>
            </div>

            <!-- Job Title -->
            <div class="form-group mb-3">
                <label for="nama_job">Job Title</label>
                <input type="text" class="form-control" id="nama_job" name="nama_job" placeholder="Enter job title" required>
            </div>

            <!-- Job Description -->
            <div class="form-group mb-3">
                <label for="deskripsi">Job Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" placeholder="Describe the job or project" required></textarea>
            </div>

            <!-- Budget -->
             <!-- Budget Range -->
             <div class="mb-3">
                <label class="form-label">Budget Range</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="number" class="form-control" id="budget_min" name="budget_min" placeholder="Minimum Budget" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <input type="number" class="form-control" id="budget_max" name="budget_max" placeholder="Maximum Budget" min="0" required>
                    </div>
                </div>
                <small class="form-text text-muted">Specify the budget range in your local currency.</small>
            </div>
            
            <!-- Job Category -->
            <div class="form-group mb-3">
                <label>Job Categories (Select up to 5)</label>
                <div id="job_category_container">
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Web Development" id="web_dev" name="job_category[]">
                        <label class="form-check-label" for="web_dev">Web Development</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Graphic Design" id="graphic_design" name="job_category[]">
                        <label class="form-check-label" for="graphic_design">Graphic Design</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Writing" id="writing" name="job_category[]">
                        <label class="form-check-label" for="writing">Writing</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Marketing" id="marketing" name="job_category[]">
                        <label class="form-check-label" for="marketing">Marketing</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Data Entry" id="data_entry" name="job_category[]">
                        <label class="form-check-label" for="data_entry">Data Entry</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input category-checkbox" type="checkbox" value="Other" id="other" name="job_category[]">
                        <label class="form-check-label" for="other">Other</label>
                    </div>
                </div>
                <small id="category_alert" class="form-text text-danger"></small>
            </div>

            <!-- Detail -->
            <div class="form-group mb-3">
                <label for="deadline">Detail</label>
                <textarea class="form-control" id="detail" name="detail" rows="5" placeholder="Describe the detail of project" ></textarea>
            </div>

            <!-- Durasi -->
            <div class="form-group mb-3">
                <label for="deadline">Duration (day)</label>
                <input type="number" class="form-control" id="durasi" name="durasi" required>
            </div>

            <!-- Deadline Publish -->
            <div class="form-group mb-3">
                <label for="deadline">Deadline Publish</label>
                <input type="date" class="form-control" id="deadline" name="deadline_publish" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Create Job</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
