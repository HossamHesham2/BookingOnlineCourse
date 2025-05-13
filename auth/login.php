<?php
include_once("../public/frontend/includes/conn.php");
include("../public/frontend/includes/header.php");

if (!isset($_SESSION['logined'])) {
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM students WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password, $row['password'])) {
                $_SESSION['studentEmail'] = $email;
                $_SESSION['studentName'] = $row['name'];
                $_SESSION['studentId'] = $row['id'];
                $_SESSION['studentImage'] = $row['image'];
                $_SESSION['logined'] = $row['logined'];
                header("Location: /fullstackProject/index.php");
                exit;
            } else {
                $_SESSION['errorStudent'] = "Password is incorrect.";
                header("Location: /fullstackProject/auth/login.php");
                exit;
            }
        } else {
            $_SESSION['errorStudent'] = "Email not found.";
            header("Location: /fullstackProject/auth/login.php");
            exit;
        }
    }
?>


    <body>



        <!-- Navbar Start -->

        <?php
        include_once("../public/frontend/includes/navbar.php");
        ?>
        <!-- Navbar End -->
        <!-- Header Start -->
        <section>
            <div class="container-fluid">

                <div class="row my-5 justify-content-center">
                    <div class="col-sm-6 col-lg-6 col-md-6 text-black">



                        <div class="d-flex align-items-center justify-content-center border shadow   ">

                            <form style="width: 23rem;" method="post" action="login.php">
                                <h3 class="fw-normal mb-3 mt-5 pb-3" style="letter-spacing: 1px; color: #06BBCC;">Log in</h3>
                                <?php if (isset($_SESSION['success_message'])): ?>
                                    <div id="custom-alert" class="alert alert-success alert-dismissible fade show " role="alert">
                                        <?= $_SESSION['success_message'] ?>

                                        <?php unset($_SESSION['success_message']); ?>
                                    </div>
                                <?php elseif (isset($_SESSION['errorStudent'])): ?>
                                    <div id="custom-alert" class="alert alert-danger alert-dismissible fade show " role="alert">
                                        <?= $_SESSION['errorStudent'] ?>

                                        <?php unset($_SESSION['errorStudent']); ?>

                                    </div>
                                <?php else :
                                    echo '';
                                endif; ?>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form2Example18">Email address</label>
                                    <input type="email" value="<?= isset($_SESSION['email']) ? $_SESSION['email'] : '' ?> "
                                        id="form2Example18" name="email" class="form-control form-control-lg" required />
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form2Example28">Password</label>
                                    <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" required />
                                </div>

                                <div class="pt-1 mb-4">
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn  btn-lg btn-block" style="background-color: #06BBCC; color: #fff;" name="login" type="submit">Login</button>
                                </div>

                                <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                                <p>Don't have an account? <a href="register.php" style=" color: #06BBCC;">Register here</a></p>

                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- Header End -->


        <!-- 404 Start -->

        <!-- 404 End -->


        <!-- Footer Start -->
    <?php
} else {
    header("Location: /fullstackProject/index.php");
}
include("../public/frontend/includes/footer.php");
    ?>