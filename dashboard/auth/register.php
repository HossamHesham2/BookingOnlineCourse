<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: /fullstackProject/dashboard/admin/index.php');
        exit();
    } elseif ($_SESSION['role'] == 'instructor') {
        header('Location: /fullstackProject/dashboard/instructor/index.php');
        exit();
    }
}

include_once('../../public/backend/includes/conn.php');
include('../../public/backend/includes/function.php');

if (isset($_POST['submit'])) {
    $name = $_POST['frist_name'] . " " .  $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // تأكد من تطابق الباسورد قبل التشفير
    if ($_POST['password'] != $_POST['password-confirm']) {
        $_SESSION['error'] = 'Password not Match';
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $image = $_FILES['image'];
        $URL = uploadImageUser($image); // تأكد إن الدالة دي بترجع مسار صحيح للصورة

        $sql = "INSERT INTO users (name, email, phone, password, image)
                VALUES ('$name', '$email', '$phone', '$password', '$URL')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION['error'] = 'Register Success';
            header("Location: /fullstackProject/dashboard/auth/login.php");
            exit();
        } else {
            $_SESSION["error"] = "Register Failed: " . mysqli_error($conn);
        }
    }
}

include("../../public/backend/includes/header.php");
?>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand text-center py-3">
                        <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i> eLEARNING</h2>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <?php if (isset($_SESSION['error'])): ?>
                                    <div class="alert alert-info text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
                                <?php endif; ?>

                                <form method="POST" action="register.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="frist_name">First Name</label>
                                            <input id="frist_name" type="text" class="form-control" name="frist_name" required autofocus>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" class="form-control" name="last_name" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input id="phone" type="text" class="form-control" name="phone" required>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password">Password</label>
                                            <input id="password" type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2">Confirm Password</label>
                                            <input id="password2" type="password" class="form-control" name="password-confirm" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input type="file" class="form-control" name="image" id="image" accept="image/*" onchange="previewImage(event)" required>
                                    </div>
                                    <div class="mb-3 text-center">
                                        <img id="preview" src="#" alt="Image Preview" style="max-width: 250px; display: none; border: 1px solid #ccc; padding: 5px;" />
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree" required>
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                                    </div>

                                    <div class="mt-5 text-muted text-center">
                                        Have an account? <a href="login.php">Login</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>



<?php include("../../public/backend/includes/footer.php"); ?>
