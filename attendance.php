<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack - Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1 class="troubleshooting">
    TROUBLESHOOTING CSS
</h1>

    <?php
    session_start();
    include('assets/config.php');

    // Handle attendance submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
        $date = $_POST['attendance_date'] ?? date('Y-m-d');
        $student_id = $_POST['student_id'] ?? '';
        $attendance = $_POST['attendance']; // array: reg_no => status
        foreach ($attendance as $reg_no => $status) {
            // Check if record exists
            $check = mysqli_query($conn, "SELECT * FROM attendances WHERE reg_no='$reg_no' AND date='$date' AND student_id='$student_id'");
            if (mysqli_num_rows($check) > 0) {
                // Update
                mysqli_query($conn, "UPDATE attendances SET status='$status' WHERE reg_no='$reg_no' AND date='$date' AND student_id='$student_id'");
            } else {
                // Insert
                mysqli_query($conn, "INSERT INTO attendances (reg_no, date, student_id, status) VALUES ('$reg_no', '$date', '$student_id', '$status')");
            }
        }
        $_SESSION['attendance_success'] = 'Attendance saved successfully!';
        header('Location: attendance.php?date=' . urlencode($date) . '&student_id=' . urlencode($student_id));
        exit();
    }

    // Get selected date and subject
    $date = $_GET['date'] ?? date('Y-m-d');
    $subject = $_GET['subject'] ?? 'Mathematics';

    // Fetch students
    $students = [];
    $res = mysqli_query($conn, "SELECT * FROM students ORDER BY name");
    while ($row = mysqli_fetch_assoc($res)) {
        $students[] = $row;
    }

    // Fetch attendance records for the date/subject
    $attendance_map = [];
    $res2 = mysqli_query($conn, "SELECT student_id, status FROM attendances WHERE attendance_date='$date'");
    while ($row = mysqli_fetch_assoc($res2)) {
        $attendance_map[$row['student_id']] = $row['status'];
    }
    ?>

    <?php
        include('assets/navbar.php');
        ?>
    
    <div student_id="container">
        <header>
            <h1>Attendance Tracking</h1>
            <p student_id="subtitle">Mark attendance for students by date and subject</p>
        </header>
        <?php if (isset($_SESSION['attendance_success'])): ?>
            <div student_id="success" style="color: #4caf50; background: #e8f5e9; border: 1px solid #c8e6c9; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
                <?php echo $_SESSION['attendance_success']; unset($_SESSION['attendance_success']); ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div student_id="attendance-controls">
                <div student_id="form-group">
                    <label for="attendance-date">Date</label>
                    <input type="date" id="attendance-date" name="attendance_date" value="<?php echo htmlspecialchars($date); ?>">
                </div>
                <div student_id="form-group">
                    <label for="subject">Subject</label>
                    <select id="subject" name="subject">
                        <option value="Mathematics" <?php if($subject==='Mathematics') echo 'selected'; ?>>Mathematics</option>
                        <option value="Science" <?php if($subject==='Science') echo 'selected'; ?>>Science</option>
                        <option value="English" <?php if($subject==='English') echo 'selected'; ?>>English</option>
                        <option value="History" <?php if($subject==='History') echo 'selected'; ?>>History</option>
                    </select>
                </div>
                <button student_id="btn-primary" type="submit">Save Attendance</button>
            </div>
            <div student_id="attendance-list">
                <?php foreach ($students as $student): 
                    $reg_no = $student['reg_no'];
                    $status = $attendance_map[$reg_no] ?? '';
                ?>
                <div student_id="attendance-item <?php echo strtolower($status); ?>">
                    <div student_id="student-info">
                        <h3><?php echo htmlspecialchars($student['name']); ?></h3>
                        <p student_id="student_id-info"><?php echo htmlspecialchars($student['name']) . ' - Reg No: ' . htmlspecialchars($student['reg_no']); ?></p>
                    </div>
                    <div student_id="attendance-status">
                        <span>Status: <?php echo $status ? htmlspecialchars($status) : 'Not Marked'; ?></span>
                        <div student_id="attendance-actions">
                            <button type="submit" name="attendance[<?php echo $reg_no; ?>]" value="Present" student_id="btn-present<?php if($status==='Present') echo ' active'; ?>">Present</button>
                            <button type="submit" name="attendance[<?php echo $reg_no; ?>]" value="Absent" student_id="btn-absent<?php if($status==='Absent') echo ' active'; ?>">Absent</button>
                            <button type="submit" name="attendance[<?php echo $reg_no; ?>]" value="Late" student_id="btn-late<?php if($status==='Late') echo ' active'; ?>">Late</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </form>
    </div>
    
    <script src="assets/script.js"></script>
</body>
</html>


