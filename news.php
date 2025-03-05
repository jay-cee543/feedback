<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>News</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/news.css" rel="stylesheet">
    <link href="css/user.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- navbar pages -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="admin.login">
                <img src="image/1.jpg" alt="" width="50" height="50" class="d-inline-block align-text-center"> GINOONG SANAY
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.php">News Release</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <!-- Header -->
    <header class="custom-header-2 text-center py-5">
            <h2>Barangay Updates</h2>
    </header>

    
    <!-- Main Content -->
    <!-- Horizontal Scroll Section -->
        <section class="updates-section">
            <div class="container">
                <h2 class="section-title">Barangay Ordinance & Announcement</h2>
                <div class="scroll-container">
                    <div class="scroll-content">
                        <!-- Update 1 -->
                        <div class="card custom-card">
                            <img src="image/2.jpg" class="card-img-top" alt="Barangay clean-up drive">
                            <div class="card-body">
                                <h5 class="card-title"><b>Barangay Ordinance 1122</b></h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac nisi erat.</p>
                                <a href="announcement.blade.php" class="btn btn-success">Read More</a>
                            </div>
                        </div>
                        <!-- Update 2 -->
                        <div class="card custom-card">
                            <img src="image/2.jpg" class="card-img-top" alt="Community event">
                            <div class="card-body">
                                <h5 class="card-title"><b>MISSING alert </b></h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac nisi erat.</p>
                                <a href="announcement.blade.php" class="btn btn-success">Read More</a>
                            </div>
                        </div>
                        <!-- Update 3 -->
                        <div class="card custom-card">
                            <img src="image/2.jpg" class="card-img-top" alt="Barangay meeting">
                            <div class="card-body">
                                <h5 class="card-title"><b>AKAP PROGRAM</b></h5>
                                <p class="card-text">Join us as we bring the community together for exciting new projects and developments.</p>
                                <a href="announcement.blade.php" class="btn btn-success">Read More</a>
                            </div>
                        </div>
                        <!-- Update 4 -->
                        <div class="card custom-card">
                            <img src="image/2.jpg" class="card-img-top" alt="Community event">
                            <div class="card-body">
                                <h5 class="card-title"><b>DSWD LIST</b></h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac nisi erat.</p>
                                <a href="update2.html" class="btn btn-success">Read More</a>
                            </div>
                    </div>
                    <!-- Update 5 -->
                    <div class="card custom-card">
                            <img src="image/2.jpg" class="card-img-top" alt="Community event">
                            <div class="card-body">
                                <h5 class="card-title"><b>SAGIP BUHAY PROGRAM</b></h5>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ac nisi erat.</p>
                                <a href="update2.html" class="btn btn-success">Read More</a>
                            </div>
                </div>
            </div>
        </section>

 
   <!-- Pie Chart Section -->
    <section class="budget-allocation">
        <div class="container">
            <h2 class="section-title">Budget Allocation Breakdown</h2>
            <p class="text-center">This chart shows how the budget is allocated across different sectors:</p>

            <!-- Responsive Chart Container -->
            <div class="chart-container">
                <canvas id="budgetChart"></canvas>
            </div>
        </div>
    </section>

    <!-- bar Chart Section -->
    <section class="container">
            <h2 class="section-title">Project Completion Status</h2>
            <div class="chart-container">
                <canvas id="projectBarChart"></canvas>
            </div>
    </section>

    <!-- Project Timeline -->
    <div class="timeline-container">
        <h2 style="text-align: center; color: black; font-weight: bold;">Barangay Project Timeline</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-date">January 2024</div>
                    <h4>Project Initiation</h4>
                    <p>Initial planning and community consultations to define project goals and scope.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-date">April 2024</div>
                    <h4>Design Phase</h4>
                    <p>Finalizing designs based on community feedback and regulatory requirements.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-date">July 2024</div>
                    <h4>Construction Start</h4>
                    <p>Beginning of construction phase with initial groundwork and infrastructure setup.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <div class="timeline-date">December 2024</div>
                    <h4>Phase 1 Completion</h4>
                    <p>Completion of the first phase of construction, including basic amenities.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="js/news.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome for social media icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    
</body>
</html>