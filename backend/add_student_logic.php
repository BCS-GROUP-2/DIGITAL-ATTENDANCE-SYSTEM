<?php
session_start();
require('../assets/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $reg_no = trim($_POST['reg_no'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $dob = trim($_POST['dob'] ?? '');

    // Basic validation
    if (empty($name) || empty($age) || empty($gender) || empty($reg_no) || empty($class) || empty($dob)) {
        $_SESSION['student_error'] = "All fields are required.";
        header('Location: ../students.php');
        exit();
    } elseif (!is_numeric($age) || $age < 1 || $age > 120) {
        $_SESSION['student_error'] = "Invalid age.";
        header('Location: ../students.php');
        exit();
    } else {
        // Check for duplicate reg_no
        $check = mysqli_query($conn, "SELECT * FROM students WHERE reg_no='$reg_no'");
        if (mysqli_num_rows($check) > 0) {
            $_SESSION['student_error'] = "A student with this registration number already exists.";
            header('Location: ../students.php');
            exit();
        } else {
           $query = "INSERT INTO students (name, age, gender, reg_no, class, dob) VALUES ('$name', $age, '$gender', '$reg_no', '$class', '$dob')";
           if (mysqli_query($conn, $query)) {
               $_SESSION['student_success'] = "Student added successfully.";
               header('Location: ../students.php');
               exit();
           } else {
               $_SESSION['student_error'] = "Database error: " . mysqli_error($conn);
               header('Location: ../students.php');
               exit();
           }
        }
    }
} else {
    $_SESSION['student_error'] = "Invalid request method.";
    header('Location: ../students.php');
    exit();
}
