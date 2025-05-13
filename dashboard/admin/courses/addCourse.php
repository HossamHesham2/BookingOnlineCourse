<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
include_once "../../../public/backend/includes/function.php";

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";

    $q = "SELECT * FROM courses";
    $r = mysqli_query($conn, $q);

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $cost = trim($_POST['cost']);
        $hours = trim($_POST['hours']);
        $category = $_POST['category'];
        $image = $_FILES['image'];
        $URL = uploadImageCourse($image);

        // Validation
        $errors = [];
        
        // Validate Name
        if (empty($name)) {
            $errors[] = 'Please enter the course name.';
        }

        // Validate Cost
        if (empty($cost)) {
            $errors[] = 'Please enter the course cost.';
        } elseif (!is_numeric($cost)) {
            $errors[] = 'The cost must be a valid number.';
        }

        // Validate Hours
        if (empty($hours)) {
            $errors[] = 'Please enter the number of hours.';
        } elseif (!is_numeric($hours)) {
            $errors[] = 'The number of hours must be a valid number.';
        }

        // Validate Category
        if (empty($category)) {
            $errors[] = 'Please select a category.';
        }

        // Validate Image
        if (empty($image['name'])) {
            $errors[] = 'Please upload an image.';
        }

        // If there are no validation errors, proceed with the insert
        if (empty($errors)) {
            $sql = "INSERT INTO courses (name, cost, hours, category, image) VALUES ('$name', '$cost', '$hours', '$category', '$URL')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success_message'] = 'Course added successfully';
                header("Location: /fullstackProject/dashboard/admin/courses/viewCourses.php");
                exit();
            } else {
                $_SESSION['error'] = "Error executing INSERT query: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = implode('<br>', $errors); // Display errors if validation fails
        }
    }
?>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include "../../../public/backend/includes/sidebar.php"; ?>
        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <?php include "../../../public/backend/includes/navbar.php"; ?>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    <h2 class="section-title">Add New Course</h2>

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="card">
                                <form class="needs-validation" novalidate="" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="post" id="add-course-form">
                                    <div class="card-header">
                                        <h4>Add Course</h4>
                                    </div>

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Course Name</label>
                                            <input type="text" name="name" class="form-control" required value="<?= isset($name) ? $name : '' ?>">
                                            <div class="invalid-feedback">
                                                Please enter the course name.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Cost</label>
                                            <input type="number" name="cost" class="form-control" required value="<?= isset($cost) ? $cost : '' ?>">
                                            <div class="invalid-feedback">
                                                Please enter the course cost.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hours</label>
                                            <input type="number" name="hours" class="form-control" required value="<?= isset($hours) ? $hours : '' ?>">
                                            <div class="invalid-feedback">
                                                Please enter the number of hours.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="form-control" name="category" required>
                                                <option disabled selected>Choose a category</option>
                                                <option value="Web development" <?= (isset($category) && $category == 'Web development') ? 'selected' : '' ?>>Web development</option>
                                                <option value="Marketing" <?= (isset($category) && $category == 'Marketing') ? 'selected' : '' ?>>Marketing</option>
                                                <option value="Content" <?= (isset($category) && $category == 'Content') ? 'selected' : '' ?>>Content</option>
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

                                        <div class="mb-3 text-center">
                                            <img id="preview" src="#" alt="Image Preview" style="max-width: 250px; display: none; border: 1px solid #ccc; padding: 5px;" />
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include "../../../public/backend/includes/footer.php"; ?>

          

<?php
} else {
    $_SESSION['error'] = 'Please Login First';
    header("Location: /fullstackProject/dashboard/auth/login.php");
    exit();
}
?>
