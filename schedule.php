<?php
require_once "config.php";
require_once "functions.php";

// Fetch schedule with joins for readable info
$sql = "
    SELECT s.Day, s.TimeSlotID, c.CourseCode, c.CourseTitle, f.Name AS FacultyName, s.ClassroomID, t.StartTime, t.EndTime
    FROM schedule s
    JOIN courses c ON s.CourseCode = c.CourseCode
    JOIN faculty f ON s.FacultyID = f.FacultyID
    JOIN timeslots t ON s.TimeSlotID = t.TimeSlotID
";
$result = $conn->query($sql);
$scheduleList = [];
if($result){
    while($row = $result->fetch_assoc()){
        // Store as array of courses per day per time slot
        $scheduleList[$row['Day']][$row['TimeSlotID']][] = $row;
    }
}

// Fetch all time slots in order
$timeSlotsRes = $conn->query("SELECT * FROM timeslots ORDER BY StartTime");
$timeSlots = [];
while($ts = $timeSlotsRes->fetch_assoc()){
    $timeSlots[$ts['TimeSlotID']] = $ts;
}

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lecture Schedule</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
        table { border-collapse: collapse; width: 100%; }
        td, th { border: 1px solid #000; padding: 5px; text-align: center; vertical-align: top; }
    </style>
</head>
<body>
<h1>Weekly Lecture Schedule</h1>
<nav>
    <a href="index.php">Dashboard</a> | 
    <a href="schedule.php">View Schedule</a>
</nav>

<form method="POST" style="margin: 10px 0;">
    <button type="submit" name="autoSchedule">Generate / Reset Schedule</button>
</form>

<script src="assets/script.js" defer></script>

<?php
// Handle auto-schedule
if(isset($_POST['autoSchedule'])){
    // Reset available slots
    $conn->query("UPDATE classrooms SET AvailableSlots='TS1,TS2,TS3,TS4,TS5,TS6'");
    // Clear existing schedule
    $conn->query("TRUNCATE TABLE schedule");
    // Generate new schedule
    generateSchedule($conn);
    echo "<p style='color:green;'>Schedule generated successfully!</p>";
    echo "<script>window.location.href='schedule.php';</script>";
    exit;
}
?>

<table>
    <tr>
        <th>Day / Time</th>
        <?php foreach($timeSlots as $ts): ?>
            <th><?= htmlspecialchars($ts['StartTime'].' - '.$ts['EndTime']) ?></th>
        <?php endforeach; ?>
    </tr>

    <?php foreach($days as $day): ?>
        <tr>
            <td><strong><?= $day ?></strong></td>
            <?php foreach($timeSlots as $tsID => $ts): ?>
                <td>
                    <?php
                    if(isset($scheduleList[$day][$tsID])){
                        foreach($scheduleList[$day][$tsID] as $s){
                            echo htmlspecialchars($s['CourseCode'] . " [" . $s['FacultyName'] . "]") . "<br>Room: " . htmlspecialchars($s['ClassroomID']) . "<hr>";
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
