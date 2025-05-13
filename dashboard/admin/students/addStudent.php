<?php
session_start();
include_once "../../../public/backend/includes/conn.php";
include_once "../../../public/backend/includes/function.php";

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    include "../../../public/backend/includes/header.php";

    if (isset($_POST['submit'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];
        $image = $_FILES['image'];
        $role = 'Student';

        $errors = [];

        if (empty($name)) {
            $errors[] = "Name is required.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        if (!preg_match("/^01[0-2,5]{1}[0-9]{8}$/", $phone)) {
            $errors[] = "Invalid phone number.";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters.";
        }

        if ($password !== $password_confirm) {
            $errors[] = "Passwords do not match.";
        }

        if ($image['error'] !== 0) {
            $errors[] = "Image upload failed.";
        }

        if (empty($errors)) {
            $URL = uploadImageStudent($image);
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO students (name, email, phone, password, image ) VALUES ('$name', '$email', '$phone', '$password_hashed', '$URL' )";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $_SESSION['success_message'] = 'Added Successfully';
                header("Location: /fullstackProject/dashboard/admin/students/viewStudents.php");
                exit();
            } else {
                $_SESSION['error'] = "Error executing INSERT query: " . mysqli_error($conn);
            }
        }
    }
?>

    <body id="page-top">
        <div id="wrapper">
            <?php include "../../../public/backend/includes/sidebar.php"; ?>

            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include "../../../public/backend/includes/navbar.php"; ?>
                    <div class="container-fluid">
                        <h2 class="section-title">Add New Student</h2>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="card">
                                    <form class="needs-validation" autocomplete="off" novalidate action="addStudent.php" enctype="multipart/form-data" method="post">
                                        <div class="card-header">
                                            <h4>Add Student</h4>
                                        </div>
                                        <?php if (!empty($errors)): ?>
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <?php foreach ($errors as $err): ?>
                                                        <li><?= $err ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Student Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input type="text" name="phone" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" name="password" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Confirm Password</label>
                                                <input type="password" name="password_confirm" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Upload New Image</label>
                                                    <input class="form-control" type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                                </div>

                                                <div class="mb-3 text-center">
                                                    <img id="preview" src="#" alt="Image Preview" style="max-width: 250px; display: none; border: 1px solid #ccc; padding: 5px;" />
                                                </div>
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
            </div>
        </div>

    </body>
<?php
} else {
    $_SESSION['error'] = 'Please Login First';
    header("Location: /fullstackProject/dashboard/auth/login.php");
    exit();
}
?>