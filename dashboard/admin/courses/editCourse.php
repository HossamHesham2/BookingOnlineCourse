<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
include_once "../../../public/backend/includes/function.php";
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid ID");
}
$id2 = $_GET['id'];
$query = "SELECT * FROM courses WHERE id = $id2"; // تأكد من استخدام $id في الاستعلام
$result = mysqli_query($conn, $query);
$rowCourse = mysqli_fetch_assoc($result);

if (!$rowCourse) {
    $_SESSION['error'] = "The course with ID = $id2 was not found.";
    header("Location: /fullstackProject/dashboard/admin/courses/viewCourses.php");
    exit();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";


    if (isset($_POST['submit'])) {


        $name = $_POST['name'];
        $cost = $_POST['cost'];
        $hours = $_POST['hours'];
        $category = $_POST['category'];
        $image = $_FILES['image'];
        $URL = uploadImageCourse($image);
        if ($URL) {
            $sql = "UPDATE `courses` SET `name`='$name', `cost`='$cost', `hours`='$hours', `category`='$category' , `image` = '$URL' WHERE id = $id2";
        } else {
            $sql = "UPDATE `courses` SET `name`='$name', `cost`='$cost', `hours`='$hours', `category`='$category'  WHERE id = $id2";
        }

        $updateResult = mysqli_query($conn, $sql);

        if ($updateResult) {
            if (mysqli_affected_rows($conn) > 0) {
                $_SESSION['success_message'] = 'Course updated successfully.';
            } else {
                $_SESSION['error'] = 'No changes were made.';
            }
            header("Location: /fullstackProject/dashboard/admin/courses/viewCourses.php");
            exit();
        } else {
            $error = "Error executing UPDATE query: " . mysqli_error($conn);
        }
    }

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
                        <h2 class="section-title">Edit Course : <?= $rowCourse['name'] ?></h2>

                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="card">
                        
                                    <form class="needs-validation" novalidate="" action="<?= $_SERVER['PHP_SELF']; ?>?id=<?= $_GET['id'] ?>" enctype="multipart/form-data" method="post" id="add-course-form">
                                        <div class="card-header">
                                            <h4>Add Course</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Course Name</label>
                                                <input type="text" name="name" class="form-control" required value="<?= $rowCourse['name']  ?>">
                                                <div class="invalid-feedback">
                                                    Please enter the course name.
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Cost</label>
                                                <input type="number" name="cost" class="form-control" required value="<?= $rowCourse['cost']  ?>">
                                                <div class="invalid-feedback">
                                                    Please enter the course cost.
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Hours</label>
                                                <input type="number" name="hours" class="form-control" required value="<?= $rowCourse['hours']   ?>">
                                                <div class="invalid-feedback">
                                                    Please enter the number of hours.
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Category</label>
                                                <select class="form-control" name="category" required>
                                                    <option disabled selected>Choose a category</option>
                                                    <option value="Web development" <?= ($rowCourse['category'] == 'Web development') ? 'selected' : '' ?>>Web development</option>
                                                    <option value="Marketing" <?= ($rowCourse['category'] == 'Marketing') ? 'selected' : '' ?>>Marketing</option>
                                                    <option value="Content" <?= ($rowCourse['category'] == 'Content') ? 'selected' : '' ?>>Content</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a category.
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Upload New Image</label>
                                                <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                                <div class="invalid-feedback">
                                                    Please upload an image.
                                                </div>
                                            </div>

                                            <div class="mb-3 ">
                                                <img id="preview"
                                                    src="<?= ($rowCourse['image']) ? $rowCourse['image'] : '#' ?>"
                                                    alt="Image Preview"
                                                    style="max-width: 250px; <?= ($rowCourse['image']) ? '' : 'display: none;' ?> border: 1px solid #ccc; padding: 5px;" />
                                            </div>

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





            <?php
        } else {
            $_SESSION['error'] = 'Please Login First';
            header("Location: /fullstackProject/dashboard/auth/login.php");
            exit();
        }

            ?>