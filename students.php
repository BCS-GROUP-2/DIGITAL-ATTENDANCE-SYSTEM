<?php 
include('assets/config.php');

// Show success/error messages
session_start();
$success = isset($_SESSION['student_success']) ? $_SESSION['student_success'] : '';
$error = isset($_SESSION['student_error']) ? $_SESSION['student_error'] : '';
unset($_SESSION['student_success'], $_SESSION['student_error']);

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Students</title>
    <link rel="stylesheet" href="assets/styles.css">
    <style>
        .students-header-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        @media (max-width: 600px) {
            .students-header-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success" style="color: #4caf50; background: #e8f5e9; border: 1px solid #c8e6c9; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error" style="color: #f44336; background: #ffebee; border: 1px solid #ffcdd2; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="students-header-grid">
            <header style="margin-bottom:0;">
                <h1>Student Management</h1>
                <p class="subtitle">Manage student records and information</p>
            </header>
            <a href="add_student.php">
                <button class="btn-add-student" style="margin-top:0;max-width:200px;">Add Student</button>
            </a>
    </div>

        <div class="student-list">
            <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="student-card">
                <div class="student-info">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p class="class-info">
                        Class:
                        <?php echo htmlspecialchars($row['class']); ?>
                    </p>
                    <p>Reg. No.: <?php echo htmlspecialchars($row['reg_no']); ?></p>
                    <p>DOB: <?php echo htmlspecialchars($row['dob']); ?></p>
                </div>
                <div class="student-actions">
                    <a href="edit_student.php?id=<?php echo urlencode($row['id']); ?>">
                    <button class="btn-edit">Edit</button>
                    </a>
                    <a href="delete_student.php?id=<?php echo urlencode($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this student?');">
                    <button class="btn-delete">Delete</button>
                    </a>
                </div>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
            <p>No students found.</p>
            <?php endif; ?>
        </div>
        
        <?php
        include('assets/navbar.php');
        ?>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>