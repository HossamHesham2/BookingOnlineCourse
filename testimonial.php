<?php
include("../fullstackProject/public/frontend/includes/header.php");
include_once("../fullstackProject/public/backend/includes/conn.php");

$qStudents = "SELECT * FROM students ";

$resStudents = mysqli_query($conn, $qStudents);

?>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <?php
    include("../fullstackProject/public/frontend/includes/navbar.php");
    ?>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Testimonial</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Testimonial</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <?php while ($rowStudents = mysqli_fetch_assoc($resStudents)): ?> <div class="testimonial-item text-center">
                        <img class="border rounded-circle p-2 mx-auto mb-3" src="<?= $rowStudents['image'] ?>" style="width: 80px; height: 80px;">
                        <h5 class="mb-0"><?= $rowStudents['name'] ?></h5>
                        <p>Profession</p>
                        <div class="testimonial-text bg-light text-center p-4">
                            <p class="mb-0">Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit diam amet diam et eos. Clita erat ipsum et lorem et sit.</p>
                        </div>
                    </div><?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <?php
    include("../fullstackProject/public/frontend/includes/footer.php");
    ?>