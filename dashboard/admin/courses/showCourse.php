<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";
    $id = $_GET["id"];
    $q = "SELECT * FROM courses WHERE id = $id";
    $r = mysqli_query($conn, $q);
    $row = mysqli_fetch_array($r);


?>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php
            include "../../../public/backend/includes/sidebar.php";

            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php include "../../../public/backend/includes/navbar.php";
                    ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Course ID : <?= $row['id'] ?></h1>
                       <div class="row">
                        <div class="col-4 m-auto">
                        <div class="card  text-center" >
                            <img class="card-img-top" src="<?= $row['image'] ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Course Name: <?= $row['name'] ?></h5>
                                <p class="card-text">Course Cost : <?= $row['cost'] ?></p>
                                <p class="card-text">Course Hours : <?= $row['hours'] ?></p>
                                <p class="card-text">Course Category : <?= $row['category'] ?></p>
                                <a href="/fullstackProject/dashboard/admin/courses/viewCourses.php" class="btn btn-primary">Back</a>
                                <a href="/fullstackProject/dashboard/admin/courses/editCourse.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                            </div>
                        </div>
                        </div>
                       </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php include "../../../public/backend/includes/footer.php";
                ?>
                <!-- End of Footer -->

            </div>
            <!-- End of Main Content -->


            <script>
                setTimeout(() => {
                    const alert = document.getElementById('custom-alert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('hide');
                    }
                }, 3000);
            </script>




        <?php
    } else {
        $_SESSION['error'] = 'Please Login First';
        header("Location: /fullstackProject/dashboard/auth/login.php");
        exit();
    }

        ?>