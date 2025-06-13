<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    $_SESSION['error'] = "You must log in first.";
    exit();
}

require('./assets/config.php');
$query = "SELECT * FROM students ORDER BY id";
$result = mysqli_query($conn, $query);

$present_today = "SELECT * FROM attendances WHERE attendance_date = CURDATE() AND status = 'Present'";
$present_result = mysqli_query($conn, $present_today);

$absent_today = "SELECT * FROM attendances WHERE attendance_date = CURDATE() AND status = 'Absent'";
$absent_result = mysqli_query($conn, $absent_today);

if(isset($_POST['submit'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Dashboard</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Attendance Dashboard</h1>
            <p class="subtitle">Track and monitor student attendance with real-time insights</p>
        </header>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Students</h3>
                <p class="stat-number">
                    <?php
                    $total_students = mysqli_num_rows($result);
                    echo $total_students;
                    ?>
                </p>
                <p class="stat-desc">Enrolled this semester</p>
            </div>
            
            <div class="stat-card">
                <h3>Present Today</h3>
                <p class="stat-number">
                    <?php
                    $present_today = mysqli_num_rows($present_result);
                    echo $present_today;
                    ?>
                </p>
                <p class="stat-desc">
                    <?php
                    if ($total_students > 0) {
                        $attendance_rate = ($present_today / $total_students) * 100;
                        echo number_format($attendance_rate, 2) . '%';
                    } else {
                        echo '0%';
                    }
                    echo ' attendance rate';
                    ?>
                </p>
            </div>
            
            <div class="stat-card">
                <h3>Absent Today</h3>
                <p class="stat-number">
                    <?php
                    $absent_today = $total_students - $present_today;
                    echo $absent_today;
                    ?>
                </p>
                <p class="stat-desc">Missing students</p>
            </div>
        </div>
        
        
        <?php
        include('./assets/navbar.php');
        ?>

    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>