<?php

include('assets/config.php');

$successMsg = '';
$errorMsg = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $name = trim($_POST['name']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $reg_no = trim($_POST['reg_no']);
    $class = trim($_POST['class']);

    // Simple validation (you can expand this)
    if ($name && $gender && $dob && $reg_no && $class) {

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO students (name, gender, dob, reg_no, class) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $gender, $dob, $reg_no, $class);

        if ($stmt->execute()) {
            $successMsg = "Student added successfully!";
            header('Location: students.php'); // Redirect to students page after success
            exit();
        } else {
            $errorMsg = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $errorMsg = "Please fill in all fields.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Add Student</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <?php include('assets/navbar.php'); ?>
    <div class="login-container">
        <div class="login-card">
            <h2>ADD STUDENT</h2>
            <br>
            <?php if ($successMsg): ?>
                <div style="color: green; text-align: center; margin-bottom: 10px;"><?php echo $successMsg; ?></div>
            <?php elseif ($errorMsg): ?>
                <div style="color: red; text-align: center; margin-bottom: 10px;"><?php echo $errorMsg; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Student Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter student name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob">DOB</label>
                    <input type="text" id="dob" name="dob" placeholder="e.g., 15-01-2025" required>
                </div>
                <div class="form-group">
                    <label for="reg_no">Registration Number</label>
                    <input type="text" id="reg_no" name="reg_no" placeholder="e.g., 2024001" required>
                </div>
                <div class="form-group">
                    <label for="class">Student Class</label>
                    <input type="text" id="class" name="class" placeholder="e.g., 1A" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>


<style>
    .form-group label {
    display: block;
    text-align: left;
    margin-bottom: 5px;
}
</style>
