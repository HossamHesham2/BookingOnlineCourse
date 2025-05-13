<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";

    $q = "SELECT * FROM courses";
    $r = mysqli_query($conn, $q);



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
                        <h1 class="h3 mb-2 text-gray-800">Courses</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">View Courses</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Cost</th>
                                                <th>Hours</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Cost</th>
                                                <th>Hours</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($r)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['cost']; ?></td>
                                                    <td><?php echo $row['hours']; ?></td>
                                                    <td><?php echo $row['category']; ?></td>
                                                    <td>
                                                        <a href="show.php?id=<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-secondary"><i class="fa fa-eye"></i></a>
                                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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