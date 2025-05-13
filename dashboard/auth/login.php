<?php

session_start();

include_once "../../public/backend/includes/conn.php";
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header('Location: /fullstackProject/dashboard/admin/index.php');
        exit();
    } elseif ($_SESSION['role'] == 'instructor') {
        header('Location: /fullstackProject/dashboard/instructor/index.php');
        exit();
    }
}


if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"]; 

    $q = 'SELECT * FROM users WHERE email = "' . $email . '" LIMIT 1';
    $result = mysqli_query($conn, $q);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header('Location: /fullstackProject/dashboard/admin/index.php');
                exit();
            } elseif ($row['role'] == 'instructor') {
                header('Location: /fullstackProject/dashboard/instructor/index.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Email or password is incorrect';
            header('Location: /fullstackProject/dashboard/auth/login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Email or password is incorrect';
        header('Location: /fullstackProject/dashboard/auth/login.php');
        exit();
    }
}

?>



<?php

include("../../public/backend/includes/header.php");

?>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand text-center py-3">
                        <h1 class="m-0 text-primary"><i class="fa fa-book me-3"></i> eLEARNING</h1>

                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <?php if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger">
                                    <?= $_SESSION['error'] ?>
                                    <?php unset($_SESSION['error']) ?>

                                </div>
                            <?php } ?>

                            <div class="card-body">
                                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" value="<?php if (isset($_SESSION['email'])) {
                                                                                                        echo $_SESSION['email'];
                                                                                                    } ?>" name="email" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>



                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Don't have an account? <a href="register.php">Create One</a>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php

    include("../../public/backend/includes/footer.php");
    ?>