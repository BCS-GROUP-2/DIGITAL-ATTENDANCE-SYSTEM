<?php
session_start();
include('assets/config.php');

if (!isset($_GET['id'])) {
    header('Location: students.php');
    exit();
}

$id = intval($_GET['id']); // Sanitize the ID from the URL

// This entire block handles POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Collect and sanitize POST data
    $name = trim($_POST['name'] ?? '');
    // If 'age' is not in your form, it will always be undefined.
    // If you plan to calculate age from DOB, don't try to get it from $_POST.
    // Remove it from the SQL query if it's not being set.
    // For now, let's keep it commented out and assume you won't use it in the query.
    // $age = trim($_POST['age'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $reg_no = trim($_POST['reg_no'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $dob = trim($_POST['dob'] ?? ''); // This will be the birth date from the form

    // 2. Perform validation (check if fields are empty)
    if (empty($name) || empty($reg_no) || empty($gender) || empty($class) || empty($dob)) {
        $_SESSION['student_error'] = "All fields are required.";
    } else {
        // 3. If validation passes, proceed with database operations
        //    a. Check for duplicate registration number
        $stmt_check = mysqli_prepare($conn, "SELECT id FROM students WHERE reg_no = ? AND id != ?");
        // Check if prepare was successful
        if ($stmt_check === false) {
            $_SESSION['student_error'] = "Database prepare error (check): " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($stmt_check, "si", $reg_no, $id); // 's' for string, 'i' for integer
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                $_SESSION['student_error'] = "A student with this registration number already exists.";
            } else {
                //    b. If no duplicate, proceed to update the student
                //       IMPORTANT: Use prepared statements for the UPDATE query too!
                //       Removed 'age' from the query as it's not present in your POST data.
                $stmt_update = mysqli_prepare($conn, "UPDATE students SET name = ?, gender = ?, reg_no = ?, class = ?, dob = ? WHERE id = ?");
                // Check if prepare was successful
                if ($stmt_update === false) {
                    $_SESSION['student_error'] = "Database prepare error (update): " . mysqli_error($conn);
                } else {
                    mysqli_stmt_bind_param($stmt_update, "sssssi", $name, $gender, $reg_no, $class, $dob, $id); // "sssssi" for 5 strings and 1 integer

                    if (mysqli_stmt_execute($stmt_update)) {
                        $_SESSION['student_success'] = "Student updated successfully.";
                        header('Location: students.php');
                        exit();
                    } else {
                        $_SESSION['student_error'] = "Database error: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt_update);
                }
            }
            mysqli_stmt_close($stmt_check);
        }
    }
}

// Fetch student data for displaying the form (this runs on GET and if POST fails)
$student = null;
$stmt_fetch = mysqli_prepare($conn, "SELECT * FROM students WHERE id = ?");
if ($stmt_fetch === false) {
    $_SESSION['student_error'] = "Database prepare error (fetch): " . mysqli_error($conn);
    header('Location: students.php');
    exit();
}
mysqli_stmt_bind_param($stmt_fetch, "i", $id);
mysqli_stmt_execute($stmt_fetch);
$res = mysqli_stmt_get_result($stmt_fetch);

if ($res && mysqli_num_rows($res) === 1) {
    $student = mysqli_fetch_assoc($res);
} else {
    $_SESSION['student_error'] = "Student not found or multiple students found with this ID.";
    header('Location: students.php');
    exit();
}
mysqli_stmt_close($stmt_fetch);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <?php if (isset($_SESSION['student_error'])): ?>
            <div class="error"><?php echo $_SESSION['student_error']; unset($_SESSION['student_error']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['student_success'])): ?>
            <div class="success"><?php echo $_SESSION['student_success']; unset($_SESSION['student_success']); ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="text" name="dob" value="<?php echo htmlspecialchars($student['dob'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" required>
                    <option value="Male" <?php if(isset($student['gender']) && $student['gender']==='Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if(isset($student['gender']) && $student['gender']==='Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if(isset($student['gender']) && $student['gender']==='Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Registration No</label>
                <input type="text" name="reg_no" value="<?php echo htmlspecialchars($student['reg_no'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Class</label>
                <input type="text" name="class" value="<?php echo htmlspecialchars($student['class'] ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn-primary">Update Student</button>
            <a href="students.php" class="btn-secondary">Students</a>
        </form>
    </div>
</body>
</html>