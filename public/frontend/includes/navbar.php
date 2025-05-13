<nav class="navbar navbar-expand-lg navbar-light bg-white shadow sticky-top">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/fullstackProject/index.php">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-2"></i>eLEARNING</h2>
        </a>

        <!-- Toggle Button (Mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Items -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav navbar ms-auto  mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $currentNav == 'index.php' ? 'active' : '' ?>" href="/fullstackProject/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentNav == 'about.php' ? 'active' : '' ?>" href="/fullstackProject/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentNav == 'courses.php' ? 'active' : '' ?>" href="/fullstackProject/courses.php">Courses</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($currentNav, ['team.php', 'testimonial.php']) ? 'active' : '' ?>" href="#" data-bs-toggle="dropdown">
                        Pages
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= $currentNav == 'team.php' ? 'active' : '' ?>" href="/fullstackProject/team.php">Our Team</a></li>
                        <li><a class="dropdown-item <?= $currentNav == 'testimonial.php' ? 'active' : '' ?>" href="/fullstackProject/testimonial.php">Testimonial</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentNav == 'contact.php' ? 'active' : '' ?>" href="/fullstackProject/contact.php">Contact</a>
                </li>

                <!-- Check if Logged In -->
                <?php if (isset($_SESSION['studentName'])): ?>
                    <li class="nav-item dropdown d-flex align-items-center ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <img src="<?= $_SESSION['studentImage'] ?>" alt="Profile" class="rounded-circle" width="35" height="35" style="object-fit: cover;">
                            <span><?= $_SESSION['studentName'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/fullstackProject/profile.php?id=<?= $_SESSION['studentId'] ?>">Profile</a></li>
                            <li><a class="dropdown-item" href="/fullstackProject/public/frontend/includes/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-3">
                        <a class="btn btn-primary px-4 py-2 d-flex align-items-center  <?= $currentNav == 'login.php' ? 'active' : '' ?>" href="/fullstackProject/auth/login.php">
                            Join Now <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
