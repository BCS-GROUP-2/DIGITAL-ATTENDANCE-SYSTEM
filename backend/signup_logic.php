<?php
require('assets/config.php');

$name=$username=$email=$password="";
$nameErr=$usernameErr=$emailErr=$passwordErr="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user';
    $nameErr = $usernameErr = $emailErr = $passwordErr = "";

    if (empty($name)) {
        $nameErr = "Name is required";
    }elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    } elseif (strlen($name) < 3) {
        $nameErr = "Name must be at least 3 characters long";
    } elseif (strlen($name) > 50) {
        $nameErr = "Name must not exceed 50 characters";
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } elseif (strlen($email) > 100) {
        $emailErr = "Email must not exceed 100 characters";
    } else {
        $emailCheck = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($emailCheck) > 0) {
            $emailErr = "Email already exists";
        }
    }

    if (empty($username)) {
        $usernameErr = "Username is required";
    } elseif (strlen($username) < 3) {
        $usernameErr = "Username must be at least 3 characters long";
    } elseif (strlen($username) > 50) {
        $usernameErr = "Username must not exceed 50 characters";
    }elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        $usernameErr = "Only letters, numbers, and underscores allowed";
    } else {
        $usernameCheck = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($usernameCheck) > 0) {
            $usernameErr = "Username already exists";
        }
    }

    if (empty($password)) {
        $passwordErr = "Password is required";
    } elseif (strlen($password) < 6) {
        $passwordErr = "Password must be at least 6 characters long";
    }
    elseif (strlen($password) > 100) {
        $passwordErr = "Password must not exceed 100 characters";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $passwordErr = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $passwordErr = "Password must contain at least one lowercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $passwordErr = "Password must contain at least one number";
    } elseif (!preg_match("/[\W_]/", $password)) {
        $passwordErr = "Password must contain at least one special character";
    } elseif (preg_match("/\s/", $password)) {
        $passwordErr = "Password must not contain spaces";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($nameErr) && empty($emailErr) && empty($usernameErr) && empty($passwordErr)) {
        $sql = "INSERT INTO users (name, email, username, password, role) VALUES ('$name', '$email', '$username', '$password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: ../dashboard.php");
            exit();
        } else {
            session_start();
            $_SESSION['error'] = "Error: " . mysqli_error($conn);
            header("Location: ../signup.php");
            exit();
        }
    }
}
?>