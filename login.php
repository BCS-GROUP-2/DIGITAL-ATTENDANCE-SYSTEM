<?php
session_start();
$username = isset($_SESSION['login_username']) ? $_SESSION['login_username'] : '';
$usernameErr = isset($_SESSION['usernameErr']) ? $_SESSION['usernameErr'] : '';
$passwordErr = isset($_SESSION['passwordErr']) ? $_SESSION['passwordErr'] : '';
unset($_SESSION['usernameErr'], $_SESSION['passwordErr'], $_SESSION['login_username']);

require('assets/config.php');

$username = $password = '';
$usernameErr = $passwordErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $usernameErr = "Username is required.";
    }
    if (empty($password)) {
        $passwordErr = "Password is required.";
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        try {
            if (!$result) {
                throw new Exception("Database query failed: " . mysqli_error($conn));
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            $passwordErr = "An error occurred while processing your request. Please try again later.";
        }
        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $passwordErr = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Login</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>EduTrack</h1>
            <p class="subtitle">Smart Digital Attendance System</p>
                        
            <h2>LOGIN</h2>

            <form class="login-form" action="" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>">
                    <span class="error">
                        <?php if (!empty($usernameErr)) echo htmlspecialchars($usernameErr); ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter password" >
                    <span class="error">
                        <?php if (!empty($passwordErr)) echo htmlspecialchars($passwordErr); ?>
                    </span>
                </div>

                <div class="dont_have_account">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>