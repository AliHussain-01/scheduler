<?php
require_once "config.php";
require_once "functions.php";

// Handle Add/Delete
if (isset($_POST['addCourse'])) {
    addCourse($_POST);
}
if (isset($_GET['deleteCourse'])) {
    deleteCourse($_GET['deleteCourse']);
    header("Location: courses.php");
    exit;
}

// Fetch Courses
$courseList = getCourses();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Courses</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
			background: #212529;   /* darker grey/black */
			color: #ffffff;
			font-weight: bold;
			font-size: 15px;
			padding: 12px;
			text-align: center;
        }
        table tr:hover {
            background: #fafafa;
        }

        .form-box {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 12px;
            background: #f9f9f9;
        }
        .form-box label {
            display: block;
            margin: 8px 0;
        }
        .form-box input, .form-box select {
            margin-left: 10px;
        }
        .form-box button {
            margin-top: 12px;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
        }
        .form-box button:hover {
            background: #0056b3;
        }

        .action-edit {
            color: #17a2b8;
            text-decoration: none;
            font-weight: bold;
        }
        .action-delete {
            color: #dc3545;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Manage Courses</h1>

<nav>
    <a href="index.php">Dashboard</a> 
    <a href="faculty.php">Faculty</a> 
    <a href="courses.php">Courses</a> 
    <a href="classrooms.php">Classrooms</a> 
    <a href="schedule.php">Schedule</a>
</nav>

<section>
    <h2>Add Course</h2>
    <form method="POST" class="form-box">
        <label>Code: <input type="text" name="code" required></label>
        <label>Title: <input type="text" name="title" required></label>
        <label>Enrollment: <input type="number" name="enrollment" required></label>
        <label>Multimedia Required:
            <select name="multimedia" required>
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </label>
        <button type="submit" name="addCourse">Add Course</button>
    </form>
</section>

<section>
    <h2>All Courses</h2>
    <table>
        <tr>
            <th>Code</th>
            <th>Title</th>
            <th>Enrollment</th>
            <th>Multimedia</th>
            <th>Action</th>
        </tr>
        <?php foreach ($courseList as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['CourseCode']) ?></td>
                <td><?= htmlspecialchars($c['CourseTitle']) ?></td>
                <td><?= htmlspecialchars($c['Enrollment']) ?></td>
                <td><?= $c['MultimediaReq'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="editCourse.php?code=<?= urlencode($c['CourseCode']) ?>" class="action-edit">✏️ Edit</a> | 
                    <a href="courses.php?deleteCourse=<?= urlencode($c['CourseCode']) ?>" class="action-delete" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

</body>
</html>
