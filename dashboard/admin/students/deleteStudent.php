<?php
include_once "../../../public/backend/includes/conn.php";
$id = $_GET['id'];
session_start();
if (isset($id)) {
    $q = "DELETE FROM students WHERE id = $id ";
    $res = mysqli_query($conn, $q);
    $_SESSION['success_message'] = 'Student deleted successfully';
    header("Location: /fullstackProject/dashboard/admin/students/viewStudents.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid course ID.";
}
