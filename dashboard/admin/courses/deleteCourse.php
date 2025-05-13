<?php
include_once "../../../public/backend/includes/conn.php";
$id = $_GET['id'];
session_start();
if (isset($id)) {
    $q = "DELETE FROM courses WHERE id = $id";
    $res = mysqli_query($conn, $q);
    $_SESSION['success_message'] = 'Course deleted successfully';
    header("Location: /fullstackProject/dashboard/admin/courses/viewCourses.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid course ID.";
}
