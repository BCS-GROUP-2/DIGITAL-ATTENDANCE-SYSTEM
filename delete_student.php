<?php
session_start();
include('assets/config.php');

if (!isset($_GET['id'])) {
    $_SESSION['student_error'] = 'No student specified.';
    header('Location: students.php');
    exit();
}

$id = intval($_GET['id']);

$query = "DELETE FROM students WHERE id=$id";
if (mysqli_query($conn, $query)) {
    $_SESSION['student_success'] = 'Student deleted successfully.';
} else {
    $_SESSION['student_error'] = 'Failed to delete student.';
}
header('Location: students.php');
exit();
