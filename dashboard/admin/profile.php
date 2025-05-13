<?php
session_start();
include('../../public/backend/includes/conn.php');
include('../../public/backend/includes/function.php');
include('../../public/backend/includes/header.php');

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {

  $id = $_SESSION['id'];
  $q = "SELECT * FROM users WHERE id = $id";
  $r = mysqli_query($conn, $q);
  $res = mysqli_fetch_assoc($r);

  if (isset($_POST['save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
      $image = $_FILES['image'];
      $URL = uploadImageUser($image);
    } else {
      $URL = $res['image'];
    }

    $profileUpdate = "UPDATE users SET name = '$first_name $last_name', email = '$email', phone = '$phone', image = '$URL' WHERE id = $id";
    $updatep = mysqli_query($conn, $profileUpdate);
    if ($updatep) {
      if (mysqli_affected_rows($conn) > 0) {
        $_SESSION['success_message'] = 'Profile updated successfully.';
      } else {
        $_SESSION['error'] = 'No changes were made.';
      }
      header('Location: profile.php?id=' . $id);
      exit();
    }
  }

  if (isset($_POST['reset'])) {
    $currentPassword = $_POST['current-password'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    $userPasswordHash = $res['password'];

    if (password_verify($currentPassword, $userPasswordHash)) {
      if ($newPassword === $confirmPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = $id";
        if (mysqli_query($conn, $updatePasswordQuery)) {
          $_SESSION['success_message'] = 'Password reset successfully.';
        } else {
          $_SESSION['error'] = 'Error updating password.';
        }
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
<body id="page-top">
  <div id="wrapper">
    <?php include('../../public/backend/includes/sidebar.php'); ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include('../../public/backend/includes/navbar.php'); ?>
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

          <div class="section-body">
            <h2 class="section-title">Hi, <?= $res['name'] ?></h2>
            <p class="section-lead">Change information about yourself on this page.</p>
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card card-primary profile-widget">
                  <div class="profile-widget-header text-center">
                    <img alt="image" src="<?= $res['image'] ?>" class="rounded-circle imagecheck-figure profile-widget-picture w-25 py-3">
                  </div>
                  <div class="card-footer text-center">
                    <div class="font-weight-bold mb-2">Follow <?= $res['name'] ?> On</div>
                    <a href="#" class="btn  mr-1"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="btn  mr-1"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="btn mr-1"><i class="fab fa-github"></i></a>
                    <a href="#" class="btn "><i class="fab fa-instagram"></i></a>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card card-primary">
                  <form method="post" class="needs-validation" novalidate="" action="profile.php?id=<?= $id ?>" enctype="multipart/form-data">
                    <div class="card-header">
                      <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="form-group col-md-6 col-12">
                          <label>First Name</label>
                          <input type="text" name="first_name" class="form-control" value="<?= explode(' ', $res['name'])[0] ?>" required="">
                        </div>
                        <div class="form-group col-md-6 col-12">
                          <label>Last Name</label>
                          <input type="text" name="last_name" class="form-control" value="<?= explode(' ', $res['name'])[1] ?>" required="">
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-7 col-12">
                          <label>Email</label>
                          <input type="email" name="email" class="form-control" value="<?= $res['email'] ?>" required="">
                        </div>
                        <div class="form-group col-md-5 col-12">
                          <label>Phone</label>
                          <input type="text" name="phone" class="form-control" value="<?= $res['phone'] ?>">
                        </div>
                      </div>
                      <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="image" accept="image/*" onchange="previewImage(event)">
                        <label class="custom-file-label" for="image">Upload Image</label>
                      </div>
                      <div class="mb-3 text-center">
                        <img id="preview" src="#" alt="Image Preview" style="max-width: 250px; display: none; border: 1px solid #ccc; padding: 5px;" />
                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="submit" name="save">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-primary">
                  <div class="card-header">
                    <h4>Reset Password</h4>
                  </div>
                  <div class="card-body">
                    <p class="text-muted">We will update your password immediately.</p>
                    <form method="POST">
                      <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input id="current-password" type="password" class="form-control" name="current-password" required>
                      </div>
                      <div class="form-group">
                        <label for="password">New Password</label>
                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password" required>
                        <div id="pwindicator" class="pwindicator"><div class="bar"></div><div class="label"></div></div>
                      </div>
                      <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="confirm-password" required>
                      </div>
                      <div class="form-group">
                        <button type="submit" name="reset" class="btn btn-primary btn-lg btn-block">Reset Password</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div> <!-- End Row -->
          </div> <!-- End section-body -->
        </div> <!-- End container-fluid -->
      </div> <!-- End content -->



<?php
} else {
  $_SESSION['error'] = 'Please Login First';
  header("Location: /fullstackProject/dashboard/auth/login.php");
  exit();
}

include('../../public/backend/includes/footer.php');
?>
