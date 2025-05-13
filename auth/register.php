    <?php
    include_once("../public/frontend/includes/conn.php");
    include_once("../public/frontend/includes/function.php");
    include_once("../public/frontend/includes/header.php");
    if (!isset($_SESSION['logined'])) {

        if (isset($_POST['register'])) {
            $name = $_POST['first_name'] . " " .  $_POST['last_name'];
            $email      = $_POST['email'];
            $password   = $_POST['password'];
            $confirm    = $_POST['confirm_password'];
            $phone      = $_POST['phone'];
            $image      = $_FILES['image'];
            $URL = uploadImageStudent($image);
            if ($password !== $confirm) {
                echo "<div class='alert alert-danger text-center'>Password Not Match</div>";
                return;
            }

            // 3. تشفير كلمة المرور
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO students (name, email, password, phone, image) 
        VALUES ('$name', '$email', '$hashed_password', '$phone', '$URL')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['studentEmail'] = $email;

                header(header: "Location: /fullstackProject/auth/login.php");
                exit;
            } else {
                echo "<div class='alert alert-danger text-center'>فشل في التسجيل.</div>";
            }
        }
    ?>

        <body>

            <?php include_once("../public/frontend/includes/navbar.php"); ?>

            <section>
                <div class="container-fluid">
                    <div class="row my-5 justify-content-center">
                        <div class="col-sm-6 col-lg-6 col-md-6 text-black">

                            <div class="d-flex align-items-center justify-content-center border shadow">

                                <form style="width: 25rem;" method="POST" enctype="multipart/form-data">

                                    <h3 class="fw-normal mb-3 mt-5 pb-3" style="letter-spacing: 1px; color: #06BBCC;">Register</h3>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" required />
                                    </div>

                                    <div class="form-outline mb-4">
                                        <label class="form-label">Upload Image</label>
                                        <input type="file" name="image" class="form-control form-control-lg" accept="image/*" required />
                                    </div>

                                    <div class="pt-1 mb-4">
                                        <button class="btn btn-lg btn-block" style="background-color: #06BBCC; color: #fff;" type="submit" name="register">Register</button>
                                    </div>

                                    <p class="small mb-5 pb-lg-2">Already have an account?<a style="color: #06BBCC;" href="login.php"> Login</a></p>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </section>

        <?php
    } else {
        header("Location: /fullstackProject/index.php");
    }
    include("../public/frontend/includes/footer.php"); ?>