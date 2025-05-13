<?php
include("../fullstackProject/public/frontend/includes/header.php");
include_once("../fullstackProject/public/frontend/includes/conn.php");
include_once("../fullstackProject/public/frontend/includes/function.php");

if (!isset($_SESSION["studentId"])) {
    header("Location: ../fullstackProject/index.php");
    exit();
}

$id = $_SESSION['studentId'];
$q = "SELECT * FROM students WHERE id = $id";
$r = mysqli_query($conn, $q);
$res = mysqli_fetch_assoc($r);

if (isset($_POST['save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $URL = isset($_FILES['image']) && $_FILES['image']['error'] == 0 ? uploadImageStudent($_FILES['image']) : $res['image'];

    $profileUpdate = "UPDATE students SET name = '$first_name $last_name', email = '$email', phone = '$phone', image = '$URL' WHERE id = $id";
    $updatep = mysqli_query($conn, $profileUpdate);

    $_SESSION[mysqli_affected_rows($conn) > 0 ? 'success_message' : 'error'] = mysqli_affected_rows($conn) > 0 ? 'Profile updated successfully.' : 'No changes were made.';
    header('Location: profile.php?id=' . $id);
    exit();
}

if (isset($_POST['reset'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if (password_verify($currentPassword, $res['password'])) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE students SET password = '$hashedPassword' WHERE id = $id";
            $_SESSION['success_message'] = mysqli_query($conn, $updatePasswordQuery) ? 'Password reset successfully.' : 'Error updating password.';
        } else {
            $_SESSION['error'] = 'New passwords do not match.';
        }
    } else {
        $_SESSION['error'] = 'Current password is incorrect.';
    }
    header('Location: profile.php?id=' . $id);
    exit();
}
?>

<body>
    <div id="spinner" class="show bg-white position-fixed w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <?php include("../fullstackProject/public/frontend/includes/navbar.php"); ?>

    <div class="container my-5">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <img src="<?= $res['image'] ?>" class="rounded-circle mb-3" width="120" height="120" alt="Profile Image">
                        <h5 class="card-title">Hi, <?= $res['name'] ?></h5>
                        <p class="card-text text-muted">Follow me on</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="btn btn-outline-danger btn-sm"><i class="fab fa-youtube"></i></a>
                            <a href="#" class="btn btn-outline-dark btn-sm"><i class="fab fa-github"></i></a>
                            <a href="#" class="btn btn-outline-warning btn-sm"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?= explode(' ', $res['name'])[0] ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?= explode(' ', $res['name'])[1] ?>" required>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $res['email'] ?>" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="<?= $res['phone'] ?>">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Upload Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                                    <div class="mt-2 text-center">
                                        <img id="preview" src="#" style="display:none; max-width:200px; border:1px solid #ccc; padding:5px;">
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button class="btn btn-primary" type="submit" name="save">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current-password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="confirm-password" class="form-control" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" name="reset" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("../fullstackProject/public/frontend/includes/footer.php"); ?>
    <script>
        function previewImage(event) {
            var output = document.getElementById('preview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
        }
    </script>