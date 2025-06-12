<?php
include('backend/signup_logic.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Signup</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1>EduTrack</h1>
            <p class="subtitle">Smart Digital Attendance System</p>
            
            <div class="divider"></div>

            <h2>SIGNUP</h2>
            <br>

             <form action="" method="POST">
                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder="Enter Name" value="<?php echo htmlspecialchars($name); ?>">
                    <span class="error" id="nameError">
                        <?php if (!empty($nameErr)) echo '<div class="error">'.$nameErr.'</div>'; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Enter Email" value="<?php echo htmlspecialchars($email); ?>">
                    <span class="error" id="emailError">
                        <?php if (!empty($emailErr)) echo '<div class="error">'.$emailErr.'</div>'; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>">
                    <span class="error" id="usernameError">
                        <?php if (!empty($usernameErr)) echo '<div class="error">'.$usernameErr.'</div>'; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter password">
                    <span class="error" id="passwordError">
                        <?php if (!empty($passwordErr)) echo '<div class="error">'.$passwordErr.'</div>'; ?>
                    </span>
                </div>

                <div class="not_have_account">
                    <p>Already have an account? <a href="login.php">Log in</a></p>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Sign Up</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>