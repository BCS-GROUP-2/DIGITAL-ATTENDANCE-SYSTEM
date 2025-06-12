<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    $_SESSION['error'] = "You must log in first.";
    exit();
}

require('./assets/config.php');
$query = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $query);
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
                <p class="stat-number">3</p>
                <p class="stat-desc">Enrolled this semester</p>
            </div>
            
            <div class="stat-card">
                <h3>Present Today</h3>
                <p class="stat-number">2</p>
                <p class="stat-desc">67% attendance rate</p>
            </div>
            
            <div class="stat-card">
                <h3>Absent Today</h3>
                <p class="stat-number">1</p>
                <p class="stat-desc">Missing students</p>
            </div>
            
            <div class="stat-card">
                <h3>Late Arrivals</h3>
                <p class="stat-number">0</p>
                <p class="stat-desc">Tardiness today</p>
            </div>
        </div>
        
        <div class="chart-container">
            <h2>Weekly Attendance Trends</h2>
            <div class="bar-chart">
                <div class="bar" style="height: 28%;"><span>28</span></div>
                <div class="bar" style="height: 21%;"><span>21</span></div>
                <div class="bar" style="height: 14%;"><span>14</span></div>
                <div class="bar" style="height: 7%;"><span>7</span></div>
                <div class="bar" style="height: 0%;"><span>0</span></div>
                <div class="x-axis">
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                </div>
            </div>
        </div>
        
        <div class="attendance-distribution">
            <h2>Today's Attendance Distribution</h2>
            <ul>
                <li>Present: 67%</li>
                <li>Late: 0%</li>
            </ul>
        </div>
        
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <ul>
                <li>Absent: 33%</li>
            </ul>
        </div>
        
        <nav class="main-nav">
            <button class="nav-btn active" onclick="location.href='dashboard.html'">Dashboard</button>
            <button class="nav-btn" onclick="location.href='students.html'">Students</button>
            <button class="nav-btn" onclick="location.href='attendance.html'">Attendance</button>
            <button class="nav-btn" onclick="location.href='login.php'">Logout</button>
        </nav>
    </div>
    
    <script src="script.js"></script>
</body>
</html>