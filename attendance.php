<?php
session_start();
include('assets/config.php');

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['attendance_date'] ?? date('Y-m-d');
    
    // First, delete any existing attendance for this date to prevent duplicates
    mysqli_query($conn, "DELETE FROM attendances WHERE attendance_date = '$date'");
    
    // Loop through all students
    $res = mysqli_query($conn, "SELECT * FROM students ORDER BY name");
    while ($student = mysqli_fetch_assoc($res)) {
        $name = $student['name'];
        $status = isset($_POST['status']);
        
        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO attendances (name, attendance_date, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $date, $status);
        $stmt->execute();
        $stmt->close();
    }
    
    $_SESSION['attendance_success'] = 'Attendance saved successfully!';
    header('Location: attendance.php');
    exit();
}

    // Get selected date and subject
    $date = $_GET['date'] ?? date('Y-m-d');

    // Fetch students
    $students = [];
    $res = mysqli_query($conn, "SELECT * FROM students ORDER BY name");
    while ($row = mysqli_fetch_assoc($res)) {
        $students[] = $row;
    }

    // Fetch attendance records for the date
    $attendance_map = [];
    $res2 = mysqli_query($conn, "SELECT name, status FROM attendances WHERE attendance_date='$date'");
    while ($row = mysqli_fetch_assoc($res2)) {
        $attendance_map[$row['name']] = $row['status'];
    }
    ?>

    <?php
        include('assets/navbar.php');
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Attendance</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    
    <div class="container">
        <header>
            <h1>Attendance Tracking</h1>
            <p class="subtitle">Mark attendance for students by date and subject</p>
        </header>
        <?php if (isset($_SESSION['attendance_success'])): ?>
            <div class="success" style="color: #4caf50; background: #e8f5e9; border: 1px solid #c8e6c9; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
                <?php echo $_SESSION['attendance_success']; unset($_SESSION['attendance_success']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="attendance-controls">
                <div class="form-group">
                    <label for="attendance-date">Date</label>
                    <input type="date" id="attendance-date" name="attendance_date" value="<?php echo htmlspecialchars($date); ?>">
                </div>
                <button class="btn-primary" type="submit">Save Attendance</button>
            </div>
            <div class="attendance-list">
                <?php foreach ($students as $student): 
                    $name = $student['name'];
                    $student_id = $student['id'];
                    $reg_no = $student['reg_no'];
                    $status = $attendance_map[$reg_no] ?? '';
                ?>
                <div class="attendance-item <?php echo strtolower($status); ?>">
                    <div class="student-info">
                        <h3><?php echo htmlspecialchars($student['name']); ?></h3>
                        <p class="student_id-info"><?php echo htmlspecialchars($student['class']) . ' - Reg No: ' . htmlspecialchars($student['reg_no']); ?></p>
                        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['id']); ?>">
                        <input type="hidden" name="attendance_date" value="<?php echo htmlspecialchars($date); ?>">
                    </div>
                    <!-- <div class="attendance-status">
                        <div class="attendance-actions">
                                <button style="padding: 5px;">
                                    <input type="checkbox" name="status" value="Present">
                                    <label for="present">Present</label>
                                </button>

                                <button style="padding: 5px;">
                                    <input type="checkbox" name="status" value="Absent">
                                    <label for="absent-">Absent</label>
                                </button>
                        </div>
                    </div> -->

                    <div class="attendance-actions">
                        <label>
                            <input type="radio" name="status[<?php echo htmlspecialchars($reg_no); ?>]" value="Present" 
                                <?php echo ($status === 'Present') ? 'checked' : ''; ?>> Present
                        </label>
                        <label>
                            <input type="radio" name="status[<?php echo htmlspecialchars($reg_no); ?>]" value="Absent" 
                                <?php echo ($status !== 'Present') ? 'checked' : ''; ?>> Absent
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>
