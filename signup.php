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

             <form action="backend/signup.php" method="POST">
                <div class="form-group">
                    <input type="text" id="name" name="name" placeholder="Enter Name" required>
                    <br>
                    <span class="error" id="nameError">
                        <?php if (isset($nameErr)) echo $nameErr; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                    <br>
                    <span class="error" id="emailError">
                        <?php if (isset($emailErr)) echo $emailErr; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="text" id="username" name="username" placeholder="Enter username" required>
                    <br>
                    <span class="error" id="usernameError">
                        <?php if (isset($usernameErr)) echo $usernameErr; ?>
                    </span>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <br>
                    <span class="error" id="passwordError">
                        <?php if (isset($passwordErr)) echo $passwordErr; ?>
                    </span>
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