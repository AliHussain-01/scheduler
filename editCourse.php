<?php
require_once "config.php";
require_once "functions.php";

if(!isset($_GET['code'])){
    die("No Course Code specified.");
}

$courseCode = $_GET['code'];

// Fetch current course data
$sql = "SELECT * FROM Courses WHERE CourseCode='$courseCode'";
$result = $conn->query($sql);
if($result->num_rows == 0){
    die("Course not found.");
}
$course = $result->fetch_assoc();

// Handle form submission
if(isset($_POST['updateCourse'])){
    editCourse($courseCode, $_POST);
    header("Location: courses.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
	<link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
</head>
<body>
    <h1>Edit Course</h1>
    <form method="POST">
        Code: <input type="text" name="code" value="<?= htmlspecialchars($course['CourseCode']) ?>" readonly><br>
        Title: <input type="text" name="title" value="<?= htmlspecialchars($course['CourseTitle']) ?>" required><br>
        Enrollment: <input type="number" name="enrollment" value="<?= $course['Enrollment'] ?>" required><br>
        Multimedia (1/0): <input type="number" name="multimedia" min="0" max="1" value="<?= $course['MultimediaReq'] ?>"><br>
        <button type="submit" name="updateCourse">Update</button>
    </form>
    <p><a href="courses.php">Back to Manage Course</a></p>
</body>
</html>
