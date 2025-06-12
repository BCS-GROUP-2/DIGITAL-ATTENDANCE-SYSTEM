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
            
            <div class="divider"></div>
            
            <h2>LOGIN</h2>
            <br>

             <form action="backend/login.php" method="POST">
                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Enter username" required>

                    <span>
                        <?php if (isset($usernameErr)) echo $usernameErr; ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <span>
                        <?php if (isset($passwordErr)) echo $passwordErr; ?>
                    </span>
                </div>

                <div class="not_have_account">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>
                <div class="error-message">

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>