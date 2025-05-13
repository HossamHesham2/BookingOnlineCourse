<?php
include_once "../../../public/backend/includes/conn.php";
$id = $_GET['id'];
session_start();
if (isset($id)) {
    $q = "DELETE FROM users WHERE id = $id AND role = 'instructor'";
    $res = mysqli_query($conn, $q);
    $_SESSION['success_message'] = 'Instructor deleted successfully';
    header("Location: /fullstackProject/dashboard/admin/instructors/viewInstructors.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid course ID.";
}
