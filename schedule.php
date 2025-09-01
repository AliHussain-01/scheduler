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
        $scheduleList[$row['Day']][$row['TimeSlotID']][] = $row;
    }
}

$timeSlotsRes = $conn->query("SELECT * FROM timeslots ORDER BY StartTime");
$timeSlots = [];
while($ts = $timeSlotsRes->fetch_assoc()){
    $timeSlots[$ts['TimeSlotID']] = $ts;
}

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lecture Schedule</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
        h1 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 26px;
            color: #343a40;
        }

        form {
            text-align: center;
            margin-bottom: 25px;
        }

        button {
            background: #007bff;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        button:hover {
            background: #0056b3;
        }

        button[name="resetSchedule"] {
            background: #dc3545;
        }

        button[name="resetSchedule"]:hover {
            background: #b02a37;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        th {
            background: #212529;
            color: #fff;
            padding: 14px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
            font-size: 13px;
            vertical-align: top;
        }

        tr:nth-child(even) td {
            background: #f8f9fa;
        }

        tr:hover td {
            background: #eef2f7;
        }

        td strong {
            color: #343a40;
        }

        hr {
            border: none;
            border-top: 1px solid #dee2e6;
            margin: 6px 0;
        }
    </style>
</head>
<body>
    <h1>Weekly Lecture Schedule</h1>

    <nav>
        <a href="index.php">Dashboard</a>
        <a href="faculty.php">Faculty</a>
        <a href="courses.php">Courses</a>
        <a href="classrooms.php">Classrooms</a>
        <a href="schedule.php">Schedule</a>
    </nav>

    <form method="POST">
        <button type="submit" name="autoSchedule">Generate / Reset Schedule</button>
        <button type="submit" name="resetSchedule">Reset to Default (No Schedule)</button>
    </form>



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
