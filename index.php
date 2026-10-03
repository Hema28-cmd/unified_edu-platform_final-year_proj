<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unified Digital Education Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#">U‑EduPlatform</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="#solutions">Solutions</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>

                <!-- Login & Register Buttons -->
                <li class="nav-item ms-2">
                    <a class="btn btn-outline-primary px-4" href="public/login.php">Login</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-warning text-white px-4" href="public/register.php">Register</a>
                </li>
 
            </ul>
        </div>
    </div>
</nav>


<!-- Hero Section -->
<section class="hero bg-gradient text-dark text-center">
    <div class="container" style="padding-top: 120px;"> <!-- Added top padding -->
        <h1 class="display-4 fw-bold lh-base">A Unified Learning Experience<br>For Students, Teachers & Families</h1>
        <p class="lead mt-3 mb-5">All your academic tools in one platform — built to support the whole learning journey.</p>
        <a href="public/register.php" class="btn btn-warning btn-lg me-3">Get Started Free</a>
        <a href="#features" class="btn btn-outline-dark btn-lg explore-btn">
    Explore Features
</a>
        <div class="hero-image mt-5">
           <img src="assets/images/hero.png" alt="Hero Image" class="img-fluid shadow-lg rounded" style="max-width:320px;">
        </div>
    </div>
</section>
<!-- stat Section -->
<section id="stats" class="py-5">
    <div class="container">
        <div class="row g-4 text-center">

            <div class="col-md-4">
                <div class="stat-card stat-blue">
                    <h2>
                        <span class="counter" data-target="25">0</span>M+
                    </h2>
                    <p>Active Learners</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-green">
                    <h2>
                        <span class="counter" data-target="100">0</span>K+
                    </h2>
                    <p>Educators Worldwide</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-orange">
                    <h2>
                        <span class="counter" data-target="98">0</span>%
                    </h2>
                    <p>Satisfaction Rate</p>
                </div>
            </div>

        </div>
    </div>
</section>




<!-- Learning Levels Section -->
<section id="levels" class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-4">Learning for Every Stage</h2>
        <div class="row g-4 justify-content-center">

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-pink text-dark p-4 rounded shadow">
                    <img src="assets/images/kindergarten.png" alt="Kindergarten" class="img-fluid mb-3">
                    <h5>Kindergarten</h5>
                    <p>Fun activities to kickstart learning.</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-yellow text-dark p-4 rounded shadow">
                    <img src="assets/images/primary.png" alt="Primary School" class="img-fluid mb-3">
                    <h5>Primary School</h5>
                    <p>Engaging lessons to build foundational skills.</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-orange text-dark p-4 rounded shadow">
                    <img src="assets/images/secondary.png" alt="Secondary School" class="img-fluid mb-3">
                    <h5>Secondary School</h5>
                    <p>Structured courses to enhance knowledge.</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-purple text-dark p-4 rounded shadow">
                    <img src="assets/images/highschool.png" alt="High School" class="img-fluid mb-3">
                    <h5>High School</h5>
                    <p>Advanced lessons for critical thinking.</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-blue text-dark p-4 rounded shadow">
                    <img src="assets/images/undergraduate.png" alt="Undergraduate" class="img-fluid mb-3">
                    <h5>Undergraduate</h5>
                    <p>University-level courses and resources.</p>
                </div>
            </div>

            <div class="col-md-4 col-lg-2">
                <div class="level-card bg-green text-dark p-4 rounded shadow">
                    <img src="assets/images/postgraduate.png" alt="Post-Graduate" class="img-fluid mb-3">
                    <h5>Post-Graduate</h5>
                    <p>Advanced research and professional learning.</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Features Section -->
<section id="features" class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-4">Powerful Features for Every Learner</h2>
        <div class="row g-4">
            <div class="col-md-3 feature">
                <i class="bi bi-laptop-fill"></i>
                <h5>Interactive Lessons</h5>
                <p>Create, assign & engage with multimedia lessons.</p>
            </div>
            <div class="col-md-3 feature">
                <i class="bi bi-bar-chart-line"></i>
                <h5>Progress Analytics</h5>
                <p>Track student growth with detailed dashboards.</p>
            </div>
            <div class="col-md-3 feature">
                <i class="bi bi-robot"></i>
                <h5>AI Learning Path</h5>
                <p>Adaptive recommendations for every student.</p>
            </div>
            <div class="col-md-3 feature">
                <i class="bi bi-chat-dots-fill"></i>
                <h5>Communication Tools</h5>
                <p>Connect students, teachers & parents easily.</p>
            </div>
        </div>
    </div>
</section>

<!-- Solutions Section -->
<section id="solutions" class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold mb-5">Solutions Tailored to You</h2>
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-start">
                <h3>For Students</h3>
                <p>Tools that make learning intuitive, visual, and meaningful — encouraging progress every day.</p>
            </div>
            <div class="col-md-6">
               <img src="assets/images/students.png" alt="Students Learning" class="img-fluid rounded shadow">
            </div>
        </div>
        <div class="row g-4 align-items-center mt-5">
            <div class="col-md-6 order-md-2 text-start">
                <h3>For Teachers</h3>
                <p>Create engaging activities, access analytics, and support learning — all from one place.</p>
            </div>
            <div class="col-md-6 order-md-1">
                <img src="assets/images/teachers.png" alt="Teachers Tools" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="py-5 text-center">
    <div class="container">
        <h2 class="fw-bold mb-4">What Users Are Saying</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card p-4 shadow">
                    <p class="text-muted">“This platform transformed how we teach and engage families — it’s simple and powerful.”</p>
                    <h6 class="fw-bold mt-3">– Teacher</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 shadow">
                    <p class="text-muted">“My children thrive here — it keeps them motivated and organized!”</p>
                    <h6 class="fw-bold mt-3">– Parent</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 shadow">
                    <p class="text-muted">“The analytics help me track progress efficiently and clearly.”</p>
                    <h6 class="fw-bold mt-3">– Administrator</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-light text-center py-4">
    <p>© 2025 Unified Digital Education Platform – Empowering Learning Everywhere</p>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
