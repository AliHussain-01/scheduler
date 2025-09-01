<?php
require_once "config.php";
require_once "functions.php";

// Handle Faculty add/delete
if (isset($_POST['addFaculty'])) addFaculty($_POST);
if (isset($_GET['deleteFaculty'])) deleteFaculty($_GET['deleteFaculty']);

// Handle Faculty Preference add/delete
if (isset($_POST['addPref'])) {
    $facultyID = $_POST['facultyID'];
    $courseCode = $_POST['courseCode'];
    $day = $_POST['day'];
    $timeSlotID = $_POST['timeSlotID'];

    $allDays = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

    // Fetch all TimeSlots
    $timeSlots = [];
    $result = $conn->query("SELECT * FROM TimeSlots ORDER BY StartTime");
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $timeSlots[] = $row;
        }
    }

    // Expand selections
    $daysToInsert = ($day === "ALL") ? $allDays : [$day];
    $timeSlotsToInsert = ($timeSlotID === "ALL") ? $timeSlots : [$timeSlotID];

    foreach ($daysToInsert as $d) {
        foreach ($timeSlotsToInsert as $ts) {
            $slotID = is_array($ts) ? $ts['TimeSlotID'] : $ts;
            addFacultyPreference($facultyID, $courseCode, $d, $slotID);
        }
    }
    header("Location: faculty.php");
    exit;
}

if (isset($_GET['deletePref'])) {
    deleteFacultyPreference($_GET['deletePref']);
    header("Location: faculty.php");
    exit;
}

// Fetch faculty & timeslots
$facultyList = getFaculty();
$timeSlots = [];
$result = $conn->query("SELECT * FROM TimeSlots ORDER BY StartTime");
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $timeSlots[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faculty Management - Lecture Scheduler</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.1);
        }
        h1,h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            margin: 15px 0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        form input, form select, form button {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        form button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }
        form button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .preferences {
            background: #f1f7ff;
            padding: 12px;
            text-align: left;
            border-radius: 6px;
        }
        .preferences ul {
            list-style: none;
            padding: 0;
            margin: 8px 0;
        }
        .preferences li {
            margin: 5px 0;
            font-size: 14px;
        }
        .badge {
            background: #007bff;
            color: white;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            margin-right: 6px;
        }
        .action-links a {
            margin: 0 5px;
            text-decoration: none;
            color: #d9534f;
        }
        .action-links a.edit {
            color: #5bc0de;
        }
		.faculty-card {
			background: #f9f9f9;
			border: 1px solid #ddd;
			border-radius: 12px;
			margin-bottom: 25px;
			box-shadow: 0 2px 6px rgba(0,0,0,0.1);
			overflow: hidden;
		}

		.faculty-info {
			background: #e9ecef;   /* light grey background for faculty info */
			padding: 12px 15px;
			display: flex;
			flex-wrap: wrap;
			gap: 15px;
			justify-content: space-between;
			font-size: 14px;
			font-weight: 500;
		}

		.faculty-actions {
			margin-left: auto;
		}

		.preferences {
			background: #f1f7ff;   /* light blue background for preferences */
			padding: 15px;
		}

		.pref-table th {
			background: #007bff;
			color: white;
		}

		.pref-table td, .pref-table th {
			padding: 8px;
			border: 1px solid #ccc;
		}


    </style>
</head>
<body>
<div class="container">
    <h1>Faculty Management</h1>

    <nav>
        <a href="index.php">Dashboard</a>  
        <a href="faculty.php">Faculty</a>
        <a href="courses.php">Courses</a>
        <a href="classrooms.php">Classrooms</a>
        <a href="schedule.php">Schedule</a>
    </nav>

    <!-- Add Faculty -->
    <h2>Add Faculty</h2>
    <form method="POST">
        <input type="text" name="facultyID" placeholder="Faculty ID (optional)">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="department" placeholder="Department" required>
        <input type="text" name="designation" placeholder="Designation" required>
        <button type="submit" name="addFaculty">➕ Add Faculty</button>
    </form>

<!-- Faculty List -->
<h2>Faculty List</h2>

<?php if (empty($facultyList)): ?>
    <p>No faculty available.</p>
<?php else: ?>
    <?php foreach ($facultyList as $f): ?>
        <div class="faculty-card">
            <!-- Faculty Info Header -->
            <div class="faculty-info">
                <span><strong>ID:</strong> <?= htmlspecialchars($f['FacultyID']) ?></span>
                <span><strong>Name:</strong> <?= htmlspecialchars($f['Name']) ?></span>
                <span><strong>Department:</strong> <?= htmlspecialchars($f['Department']) ?></span>
                <span><strong>Designation:</strong> <?= htmlspecialchars($f['Designation']) ?></span>
                <div class="faculty-actions">
                    <a href="editFaculty.php?id=<?= $f['FacultyID'] ?>" class="edit-btn">✏️ Edit</a>
                    <a href="faculty.php?deleteFaculty=<?= $f['FacultyID'] ?>" 
                       onclick="return confirm('Delete this faculty?')" class="delete-btn">🗑️ Delete</a>
                </div>
            </div>

            <!-- Preferences Section -->
            <div class="preferences">
                <strong>Preferences:</strong>
                <?php $prefs = getFacultyPreferences($f['FacultyID']); ?>
                <?php if (!empty($prefs)): ?>
                    <table class="pref-table">
                        <tr>
                            <th>Day</th>
                            <th>Time Slot</th>
                            <th>Course Code</th>
                            <th>Action</th>
                        </tr>
                        <?php foreach ($prefs as $p): ?>
                            <tr>
                                <td><?= htmlspecialchars($p['Day']) ?></td>
                                <td><?= htmlspecialchars($p['TimeSlotID']) ?></td>
                                <td><?= htmlspecialchars($p['CourseCode']) ?></td>
                                <td>
                                    <a href="faculty.php?deletePref=<?= $p['PrefID'] ?>" 
                                       onclick="return confirm('Delete this preference?')">❌ Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>No preferences yet.</p>
                <?php endif; ?>

                <!-- Add Preference Form -->
                <form method="POST" class="add-pref-form">
                    <input type="hidden" name="facultyID" value="<?= $f['FacultyID'] ?>">
                    <input type="text" name="courseCode" placeholder="Course Code" required>
                    <select name="day" required>
                        <option value="">--Select Day--</option>
                        <option value="ALL">All Days</option>
                        <?php foreach (['Monday','Tuesday','Wednesday','Thursday','Friday'] as $d): ?>
                            <option value="<?= $d ?>"><?= $d ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="timeSlotID" required>
                        <option value="">--Select Time Slot--</option>
                        <option value="ALL">All Time Slots</option>
                        <?php foreach ($timeSlots as $ts): ?>
                            <option value="<?= $ts['TimeSlotID'] ?>">
                                <?= $ts['TimeSlotID'] ?> (<?= $ts['StartTime'] ?> - <?= $ts['EndTime'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" name="addPref">➕ Add Preference</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

    </table>
</div>
</body>
</html>
