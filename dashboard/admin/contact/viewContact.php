<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";

    $q = "SELECT * FROM contact_us";
    $r = mysqli_query($conn, $q);

    $row = mysqli_fetch_assoc($r)

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
                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div id="custom-alert" class="alert alert-success alert-dismissible fade show position-fixed" role="alert">
                                <?= $_SESSION['success_message'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php elseif (isset($_SESSION['error'])): ?>
                            <div id="custom-alert" class="alert alert-danger alert-dismissible fade show position-fixed" role="alert">
                                <?= $_SESSION['error'] ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>


                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Contact</h1>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">View Contact</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <tbody>
                                            <tr>
                                                <th>Description :</th>
                                                <td><?php
                                                    if (isset($row['description'])):
                                                        echo $row['description'];
                                                    endif;
                                                    ?></td>

                                            </tr>

                                            <tr>
                                                <th>Phone :</th>
                                                <td><?php
                                                    if (isset($row['phone'])):
                                                        echo $row['phone'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Email :</th>
                                                <td><?php
                                                    if (isset($row['email'])):
                                                        echo $row['email'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Address :</th>
                                                <td><?php
                                                    if (isset($row['address'])):
                                                        echo $row['address'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Facebook :</th>
                                                <td><?php
                                                    if (isset($row['facebook'])):
                                                        echo $row['facebook'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Youtube :</th>
                                                <td><?php
                                                    if (isset($row['youtube'])):
                                                        echo $row['youtube'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Instagram :</th>
                                                <td><?php
                                                    if (isset($row['instagram'])):
                                                        echo $row['instagram'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>
                                                <th>Linkedin :</th>
                                                <td><?php
                                                    if (isset($row['linkedin'])):
                                                        echo $row['linkedin'];
                                                    endif;
                                                    ?></td>

                                            </tr>
                                            <tr>

                                                <td colspan="2" class="text-center"><a href="editContact.php?id=<?= $row['id']; ?>" class="btn btn-primary bg-gradient-primary w-25"><i class="fa fa-edit"></i> Edit Contact </a></td>
                                            </tr>
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
        ```