<?php
require('../assets/config.php');

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
    }
    if (empty($email)) {
        $emailErr = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }
    if (empty($username)) {
        $usernameErr = "Username is required";
    }
    if (empty($password)) {
        $passwordErr = "Password is required";
    } elseif (strlen($password) < 6) {
        $passwordErr = "Password must be at least 6 characters long";
    }

    if (empty($nameErr) && empty($emailErr) && empty($usernameErr) && empty($passwordErr)) {
        $sql = "INSERT INTO users (name, email, username, password, role) VALUES ('$name', '$email', '$username', '$password', '$role')";
        
        if (mysqli_query($conn, $sql)) {
            echo "You signed up successfully, please login now.";
            header("Location: ../login.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Errors: <br>";
        echo $nameErr . "<br>";
        echo $emailErr . "<br>";
        echo $usernameErr . "<br>";
        echo $passwordErr . "<br>";
    }
}