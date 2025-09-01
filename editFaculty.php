<?php
require_once "config.php";
require_once "functions.php";

if (!isset($_GET['id'])) {
    die("No Faculty ID specified.");
}

$facultyID = $_GET['id'];

// Fetch faculty data
$sql = "SELECT * FROM Faculty WHERE FacultyID='$facultyID'";
$result = $conn->query($sql);
if ($result->num_rows == 0) die("Faculty not found.");
$faculty = $result->fetch_assoc();

// Handle faculty update
if (isset($_POST['updateFaculty'])) {
    $newFacultyID = $_POST['facultyID'];
    // Edit function updated to allow changing FacultyID
    editFaculty($facultyID, $_POST);
    // Redirect to the updated faculty ID
    header("Location: editFaculty.php?id=" . urlencode($newFacultyID));
    exit;
}

// Handle adding a new preference
if (isset($_POST['addPref'])) {
    addFacultyPreference($facultyID, $_POST['courseCode'], $_POST['day'], $_POST['timeSlotID']);
    header("Location: editFaculty.php?id=$facultyID");
    exit;
}

// Handle deleting a preference
if (isset($_GET['deletePref'])) {
    deleteFacultyPreference($_GET['deletePref']);
    header("Location: editFaculty.php?id=$facultyID");
    exit;
}

// Handle editing a preference
if (isset($_POST['editPref'])) {
    editFacultyPreference($_POST['prefID'], $_POST['courseCode'], $_POST['day'], $_POST['timeSlotID']);
    header("Location: editFaculty.php?id=$facultyID");
    exit;
}

// Fetch faculty preferences
$prefs = getFacultyPreferences($facultyID);

// Fetch courses for dropdown
$courses = getCourses();

// Fetch time slots (skip break)
$timeSlots = [];
$tsResult = $conn->query("SELECT * FROM TimeSlots WHERE IsBreak=0 ORDER BY StartTime");
while ($row = $tsResult->fetch_assoc()) $timeSlots[] = $row;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
	<link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
</head>
<body>
    <h1>Edit Faculty</h1>

    <form method="POST">
        Faculty ID: <input type="text" name="facultyID" value="<?= htmlspecialchars($faculty['FacultyID']) ?>" required><br>
        Name: <input type="text" name="name" value="<?= htmlspecialchars($faculty['Name']) ?>" required><br>
        Department: <input type="text" name="department" value="<?= htmlspecialchars($faculty['Department']) ?>" required><br>
        Designation: <input type="text" name="designation" value="<?= htmlspecialchars($faculty['Designation']) ?>" required><br>
        <button type="submit" name="updateFaculty">Update Faculty</button>
    </form>

    <h2>Preferences</h2>
    <ul>
        <?php foreach ($prefs as $p): ?>
            <li>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="prefID" value="<?= $p['PrefID'] ?>">
                    Course: 
                    <select name="courseCode" required>
                        <?php foreach ($courses as $c): ?>
                            <option value="<?= $c['CourseCode'] ?>" <?= $c['CourseCode']==$p['CourseCode']?'selected':'' ?>>
                                <?= htmlspecialchars($c['CourseCode']) ?> - <?= htmlspecialchars($c['CourseTitle']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    Day:
                    <select name="day">
                        <option value="">--Select Day--</option>
                        <?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day): ?>
                            <option value="<?= $day ?>" <?= $day==$p['Day']?'selected':'' ?>><?= $day ?></option>
                        <?php endforeach; ?>
                    </select>
                    Time Slot:
                    <select name="timeSlotID">
                        <option value="">--Select--</option>
                        <?php foreach($timeSlots as $ts): ?>
                            <option value="<?= $ts['TimeSlotID'] ?>" <?= $ts['TimeSlotID']==$p['TimeSlotID']?'selected':'' ?>>
                                <?= $ts['TimeSlotID'] ?> (<?= $ts['StartTime'] ?> - <?= $ts['EndTime'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="editPref">Update</button>
                    <a href="editFaculty.php?id=<?= $facultyID ?>&deletePref=<?= $p['PrefID'] ?>" onclick="return confirm('Delete this preference?')">Delete</a>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Add New Preference</h3>
    <form method="POST">
        Course: 
        <select name="courseCode" required>
            <?php foreach ($courses as $c): ?>
                <option value="<?= $c['CourseCode'] ?>"><?= htmlspecialchars($c['CourseCode']) ?> - <?= htmlspecialchars($c['CourseTitle']) ?></option>
            <?php endforeach; ?>
        </select><br>
        Day:
        <select name="day">
            <option value="">--Select Day--</option>
            <?php foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day): ?>
                <option value="<?= $day ?>"><?= $day ?></option>
            <?php endforeach; ?>
        </select><br>
        Time Slot:
        <select name="timeSlotID">
            <option value="">--Select--</option>
            <?php foreach($timeSlots as $ts): ?>
                <option value="<?= $ts['TimeSlotID'] ?>"><?= $ts['TimeSlotID'] ?> (<?= $ts['StartTime'] ?> - <?= $ts['EndTime'] ?>)</option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit" name="addPref">Add Preference</button>
    </form>

    <p><a href="faculty.php">Back to Manage Faculty</a></p>
</body>
</html>
