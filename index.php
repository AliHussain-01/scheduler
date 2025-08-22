<?php
require_once "config.php"; // Make sure this defines $conn
require_once "functions.php";

// Fetch TimeSlots for dropdown
$timeSlots = [];
$result = $conn->query("SELECT * FROM TimeSlots ORDER BY StartTime");
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $timeSlots[] = $row;
    }
}

// Handle form submissions
if(isset($_POST['addFaculty'])) addFaculty($_POST);
if(isset($_POST['addCourse'])) addCourse($_POST);
if(isset($_POST['addClassroom'])) addClassroom($_POST);

// Handle Faculty Preference Add/Delete
// ====
if(isset($_POST['addPref'])){
    $facultyID = $_POST['facultyID'];
    $courseCode = $_POST['courseCode'];
    $day = $_POST['day'];
    $timeSlotID = $_POST['timeSlotID'];

    $allDays = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

    // Get all time slots from DB
    $timeSlots = [];
    $result = $conn->query("SELECT TimeSlotID FROM TimeSlots ORDER BY StartTime");
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $timeSlots[] = $row['TimeSlotID'];
        }
    }

    // Determine which days and time slots to loop over
    $daysToInsert = ($day === "ALL") ? $allDays : [$day];
    $timeSlotsToInsert = ($timeSlotID === "ALL") ? $timeSlots : [$timeSlotID];

    // Insert each combination
    foreach($daysToInsert as $d){
        foreach($timeSlotsToInsert as $ts){
            addFacultyPreference($facultyID, $courseCode, $d, $ts);
        }
    }

    header("Location: index.php");
    exit;
}
// ====
if(isset($_GET['deletePref'])){
    deleteFacultyPreference($_GET['deletePref']);
    header("Location: index.php");
    exit;
}


// Handle delete requests
if(isset($_GET['deleteFaculty'])) deleteFaculty($_GET['deleteFaculty']);
if(isset($_GET['deleteCourse'])) deleteCourse($_GET['deleteCourse']);
if(isset($_GET['deleteClassroom'])) deleteClassroom($_GET['deleteClassroom']);

// Fetch data for display
$facultyList = getFaculty();
$courseList = getCourses();
$classroomList = getClassrooms();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lecture Scheduler Dashboard</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
</head>
<body>
<h1>Lecture Scheduler Dashboard</h1>

<nav>
    <a href="index.php">Dashboard</a> | 
    <a href="schedule.php">View Schedule</a>
</nav>

<!-- Faculty Management -->
<section>
    <h2>Faculty</h2>
    <form method="POST">
        Faculty ID: <input type="text" name="facultyID" placeholder="Optional, auto-generated if empty">
        Name: <input type="text" name="name" required>
        Department: <input type="text" name="department" required>
        Designation: <input type="text" name="designation" required>
        <button type="submit" name="addFaculty">Add Faculty</button>
    </form>

    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Department</th><th>Designation</th><th>Action</th></tr>
        <?php foreach($facultyList as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['FacultyID']) ?></td>
                <td><?= htmlspecialchars($f['Name']) ?></td>
                <td><?= htmlspecialchars($f['Department']) ?></td>
                <td><?= htmlspecialchars($f['Designation']) ?></td>
                <td>
                    <a href="editFaculty.php?id=<?= $f['FacultyID'] ?>">Edit</a> |
                    <a href="index.php?deleteFaculty=<?= $f['FacultyID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <strong>Preferences:</strong>
                   <div class="preferences-container">
						<ul class="preferences-list">
							<?php
							$prefs = getFacultyPreferences($f['FacultyID']);
							foreach($prefs as $p): ?>
								<li>
									<span class="badge"><?= $p['Day'] ?> (<?= $p['TimeSlotID'] ?>)</span>
									<?= htmlspecialchars($p['CourseCode']) ?>
									<a href="index.php?deletePref=<?= $p['PrefID'] ?>" onclick="return confirm('Delete preference?')">Delete</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>

                    <form method="POST">
                        <input type="hidden" name="facultyID" value="<?= $f['FacultyID'] ?>">
                        Course Code: <input type="text" name="courseCode" required><br>
                        Day:
						<select name="day">
							<option value="">--Select Day--</option>
							<option value="ALL">All Days</option>
							<?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $d): ?>
								<option value="<?= $d ?>"><?= $d ?></option>
							<?php endforeach; ?>
						</select><br>

						Time Slot:
						<select name="timeSlotID">
							<option value="">--Select--</option>
							<option value="ALL">All Time Slots</option>
							<?php foreach($timeSlots as $ts): ?>
								<option value="<?= $ts['TimeSlotID'] ?>"><?= $ts['TimeSlotID'] ?> (<?= $ts['StartTime'] ?> - <?= $ts['EndTime'] ?>)</option>
							<?php endforeach; ?>
						</select><br>
                        <button type="submit" name="addPref">Add Preference</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<!-- Courses Management -->
<section>
    <h2>Courses</h2>
    <form method="POST">
        Code: <input type="text" name="code" required>
        Title: <input type="text" name="title" required>
        Enrollment: <input type="number" name="enrollment" required>
        Multimedia (1/0): <input type="number" name="multimedia" min="0" max="1" value="0">
        <button type="submit" name="addCourse">Add Course</button>
    </form>

    <table border="1">
        <tr><th>Code</th><th>Title</th><th>Enrollment</th><th>Multimedia</th><th>Action</th></tr>
        <?php foreach($courseList as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['CourseCode']) ?></td>
                <td><?= htmlspecialchars($c['CourseTitle']) ?></td>
                <td><?= $c['Enrollment'] ?></td>
                <td><?= $c['MultimediaReq'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="editCourse.php?code=<?= $c['CourseCode'] ?>">Edit</a> |
                    <a href="index.php?deleteCourse=<?= $c['CourseCode'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<!-- Classrooms Management -->
<section>
    <h2>Classrooms</h2>
    <form method="POST">
        ID: <input type="text" name="id" required>
        Building: <input type="text" name="building" required>
        Capacity: <input type="number" name="capacity" required>
        Multimedia (1/0): <input type="number" name="multimedia" min="0" max="1" value="0">
        <button type="submit" name="addClassroom">Add Classroom</button>
    </form>

    <table border="1">
        <tr><th>ID</th><th>Building</th><th>Capacity</th><th>Multimedia</th><th>Action</th></tr>
        <?php foreach($classroomList as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['ClassroomID']) ?></td>
                <td><?= htmlspecialchars($r['Building']) ?></td>
                <td><?= $r['Capacity'] ?></td>
                <td><?= $r['MultimediaAvail'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="editClassroom.php?id=<?= $r['ClassroomID'] ?>">Edit</a> |
                    <a href="index.php?deleteClassroom=<?= $r['ClassroomID'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>

<section>
    <h2>Lecture Schedule</h2>
    <p><a href="schedule.php">Go to Schedule Page</a></p>
</section>

</body>
</html>
