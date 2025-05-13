<?php
$current_path = $_SERVER['PHP_SELF'];
$course_active = strpos($current_path, '/fullstackProject/dashboard/admin/courses/') !== false;
$contact_active = strpos($current_path, '/fullstackProject/dashboard/admin/contact/') !== false;
$instructor_active = strpos($current_path, '/fullstackProject/dashboard/admin/instructors/') !== false;
$student_active = strpos($current_path, '/fullstackProject/dashboard/admin/students/') !== false;

include_once("conn.php");

if (isset($_SESSION["id"])) {
    $id = intval($_SESSION["id"]);
    $selectUser2 = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");

    if (!$selectUser2) {
        die("Query failed: " . mysqli_error($conn));
    }
} else {
    $_SESSION['error'] = 'Please Login First';
    header("Location: /fullstackProject/dashboard/auth/login.php");
    exit();
}

$resUser2 = mysqli_fetch_assoc($selectUser2);
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/fullstackProject/dashboard/admin/index.php">
        <div class="sidebar-brand-icon rounded-circle">
            <img src="<?= $resUser2['image'] ?>" alt="" width="30" class="rounded-circle">
        </div>
        <div class="sidebar-brand-text mx-3"><?= explode(' ', $resUser2['name'])[0] ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/index.php') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="/fullstackProject/dashboard/admin/index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Edit Interface
    </div>

    <!-- Nav Item - Courses Collapse Menu -->
    <li class="nav-item <?= $course_active ? 'active' : '' ?>">
        <a class="nav-link <?= !$course_active ? 'collapsed' : '' ?>" href="#" data-toggle="collapse"
            data-target="#collapseTwo" aria-expanded="<?= $course_active ? 'true' : 'false' ?>" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-book"></i>
            <span>Courses</span>
        </a>
        <div id="collapseTwo" class="collapse <?= $course_active ? 'show' : '' ?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Courses :</h6>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/courses/viewCourses.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/courses/viewCourses.php">View Courses</a>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/courses/addCourse.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/courses/addCourse.php">Add Courses</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Instructors Collapse Menu -->
    <li class="nav-item <?= $instructor_active ? 'active' : '' ?>">
        <a class="nav-link <?= !$instructor_active ? 'collapsed' : '' ?>" href="#" data-toggle="collapse"
            data-target="#collapseThree" aria-expanded="<?= $instructor_active ? 'true' : 'false' ?>" aria-controls="collapseThree">
            <i class="fas fa-fw fa-user"></i>
            <span>Instructors</span>
        </a>
        <div id="collapseThree" class="collapse <?= $instructor_active ? 'show' : '' ?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Instructors :</h6>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/instructors/viewInstructors.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/instructors/viewInstructors.php">View Instructors</a>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/instructors/addInstructor.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/instructors/addInstructor.php">Add Instructors</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - students Collapse Menu -->
    <li class="nav-item <?= $student_active ? 'active' : '' ?>">
        <a class="nav-link <?= !$student_active ? 'collapsed' : '' ?>" href="#" data-toggle="collapse"
            data-target="#collapseFour" aria-expanded="<?= $student_active ? 'true' : 'false' ?>" aria-controls="collapseFour">
            <i class="fas fa-fw fa-user"></i>
            <span>Students</span>
        </a>
        <div id="collapseFour" class="collapse <?= $student_active ? 'show' : '' ?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Students :</h6>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/students/viewStudents.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/students/viewStudents.php">View students</a>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/students/addStudent.php') !== false ? 'active' : '' ?>"
                    href="/fullstackProject/dashboard/admin/students/addStudent.php">Add Students</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Edit Contact us
    </div>

    <!-- Nav Item - Contact Collapse Menu -->
    <li class="nav-item <?= $contact_active ? 'active' : '' ?>">
        <a class="nav-link <?= !$contact_active ? 'collapsed' : '' ?>" href="#" data-toggle="collapse"
            data-target="#collapse3" aria-expanded="<?= $contact_active ? 'true' : 'false' ?>" aria-controls="collapse3">
            <i class="fas fa-fw fa-file-contract"></i>
            <span>Contacts</span>
        </a>
        <div id="collapse3" class="collapse <?= $contact_active ? 'show' : '' ?>" aria-labelledby="headingTwo"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Contacts :</h6>
                <a class="collapse-item <?= strpos($current_path, '/fullstackProject/dashboard/admin/contact/viewContact.php') !== false ? 'active' : '' ?> "
                    href="/fullstackProject/dashboard/admin/contact/viewContact.php">View Contacts</a>
            </div>
        </div>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>