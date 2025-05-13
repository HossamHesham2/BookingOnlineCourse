<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
include_once "../../../public/backend/includes/function.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ID");
}
$id = $_GET['id'];
$query = "SELECT * FROM contact_us WHERE id = $id"; // تأكد من استخدام $id في الاستعلام
$result = mysqli_query($conn, $query);
$rowContact = mysqli_fetch_assoc($result);
if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";


    if (isset($_POST['submit'])) {
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $facebook = mysqli_real_escape_string($conn, $_POST['facebook']);
        $youtube = mysqli_real_escape_string($conn, $_POST['youtube']);
        $instagram = mysqli_real_escape_string($conn, $_POST['instagram']);
        $linkedin = mysqli_real_escape_string($conn, $_POST['linkedin']);
        $id = (int) $_POST['id'];

        $sql = "UPDATE `contact_us` SET 
            `description`='$description', 
            `phone`='$phone',
            `email`='$email',
            `address`='$address',
            `facebook`='$facebook',
            `youtube`='$youtube',
            `instagram`='$instagram',
            `linkedin`='$linkedin'  
            WHERE id = $id";



        $updateResult = mysqli_query($conn, $sql);

        if ($updateResult) {
            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION['success_message'] = 'Contact updated successfully.';
            } else {
                $_SESSION['error'] = 'No changes were made.';
            }
            header("Location: /fullstackProject/dashboard/admin/contact/viewContact.php");
            exit();
        } else {
            $error = "Error executing UPDATE query: " . mysqli_error($conn);
        }
    }

?>

```
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
                    <h2 class="section-title">Edit Contact :</h2>

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="card">
                                <form class="needs-validation" novalidate="" action="editContact.php?id= <?= $rowContact['id'] ?>" method="post">
                                    <div class="card-header">
                                        <h4>Edit Contact</h4>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" name="id" class="form-control" required value="<?= $rowContact['id'] ?>" hidden>
                                    </div>
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label> Description</label>
                                            <textarea name="description" id="description" class="form-control" required><?= $rowContact['description'] ?></textarea>
                                            <div class="invalid-feedback">
                                                What's your Contact description?
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control" required value="<?= $rowContact['phone'] ?>">
                                            <div class="invalid-feedback">
                                                What's the phone of the Contact?
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>email</label>
                                            <input type="email" name="email" class="form-control" required value="<?= $rowContact['email'] ?>">
                                            <div class="invalid-feedback">
                                                What's the email of the Contact?
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="address" name="address" class="form-control" required value="<?= $rowContact['address'] ?>">
                                            <div class="invalid-feedback">
                                                What's the address of the Contact?
                                            </div>
                                            <div class="form-group">
                                                <label>facebook</label>
                                                <input type="facebook" name="facebook" class="form-control" required value="<?= $rowContact['facebook'] ?>">
                                                <div class="invalid-feedback">
                                                    What's the facebook of the Contact?
                                                </div>
                                                <div class="form-group">
                                                    <label>youtube</label>
                                                    <input type="youtube" name="youtube" class="form-control" required value="<?= $rowContact['youtube'] ?>">
                                                    <div class="invalid-feedback">
                                                        What's the youtube of the Contact?
                                                    </div>
                                                    <div class="form-group">
                                                        <label>instagram</label>
                                                        <input type="instagram" name="instagram" class="form-control" required value="<?= $rowContact['instagram'] ?>">
                                                        <div class="invalid-feedback">
                                                            What's the instagram of the Contact?
                                                        </div>
                                                        <div class="form-group">
                                                            <label>linkedin</label>
                                                            <input type="linkedin" name="linkedin" class="form-control" required value="<?= $rowContact['linkedin'] ?>">
                                                            <div class="invalid-feedback">
                                                                What's the linkedin of the Contact?
                                                            </div>


                                                            <div class="card-footer text-right">
                                                                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                            </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->

                <!-- End of Footer -->

            </div>
            <!-- End of Main Content -->

            <?php include "../../../public/backend/includes/footer.php";
            ?>
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
