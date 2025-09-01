<?php
require_once "config.php";

// -------------------------
// Faculty Functions
// -------------------------
function getFaculty() {
    global $conn;
    $result = $conn->query("SELECT * FROM Faculty");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function addFaculty($data) {
    global $conn;
    $facultyID = $conn->real_escape_string($data['facultyID'] ?? uniqid());
    $name = $conn->real_escape_string($data['name']);
    $department = $conn->real_escape_string($data['department']);
    $designation = $conn->real_escape_string($data['designation']);
    $conn->query("INSERT INTO Faculty (FacultyID, Name, Department, Designation) 
                  VALUES ('$facultyID', '$name', '$department', '$designation')");
}

function editFaculty($oldFacultyID, $data) {
    global $conn;
    $oldFacultyID = $conn->real_escape_string($oldFacultyID);
    $newFacultyID = $conn->real_escape_string($data['facultyID']);
    $name = $conn->real_escape_string($data['name']);
    $department = $conn->real_escape_string($data['department']);
    $designation = $conn->real_escape_string($data['designation']);

    $conn->query("UPDATE Faculty 
                  SET FacultyID='$newFacultyID', Name='$name', Department='$department', Designation='$designation' 
                  WHERE FacultyID='$oldFacultyID'");
    $conn->query("UPDATE preferences SET FacultyID='$newFacultyID' WHERE FacultyID='$oldFacultyID'");
}

function deleteFaculty($facultyID) {
    global $conn;
    $facultyID = $conn->real_escape_string($facultyID);
    $conn->query("DELETE FROM Faculty WHERE FacultyID='$facultyID'");
}

// -------------------------
// Courses Functions
// -------------------------
function getCourses() {
    global $conn;
    $result = $conn->query("SELECT * FROM Courses");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function addCourse($data) {
    global $conn;
    $code = $conn->real_escape_string($data['code']);
    $title = $conn->real_escape_string($data['title']);
    $enrollment = intval($data['enrollment']);
    $multimedia = intval($data['multimedia']);
    $conn->query("INSERT INTO Courses (CourseCode, CourseTitle, Enrollment, MultimediaReq) 
                  VALUES ('$code', '$title', $enrollment, $multimedia)");
}

function editCourse($courseCode, $data) {
    global $conn;
    $courseCode = $conn->real_escape_string($courseCode);
    $title = $conn->real_escape_string($data['title']);
    $enrollment = intval($data['enrollment']);
    $multimedia = intval($data['multimedia']);
    $conn->query("UPDATE Courses SET CourseTitle='$title', Enrollment=$enrollment, MultimediaReq=$multimedia 
                  WHERE CourseCode='$courseCode'");
}

function deleteCourse($courseCode) {
    global $conn;
    $courseCode = $conn->real_escape_string($courseCode);
    $conn->query("DELETE FROM Courses WHERE CourseCode='$courseCode'");
}

// -------------------------
// Classrooms Functions
// -------------------------
function getClassrooms() {
    global $conn;
    $result = $conn->query("SELECT * FROM Classrooms");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function addClassroom($data) {
    global $conn;
    $id = $conn->real_escape_string($data['id']);
    $building = $conn->real_escape_string($data['building']);
    $capacity = intval($data['capacity']);
    $multimedia = intval($data['multimedia']);
    $check = $conn->query("SELECT * FROM Classrooms WHERE ClassroomID='$id'");
    if($check->num_rows > 0){
        echo "<p style='color:red;'>Classroom ID already exists!</p>";
        return;
    }
    $conn->query("INSERT INTO Classrooms (ClassroomID, Building, Capacity, MultimediaAvail) 
                  VALUES ('$id', '$building', $capacity, $multimedia)");
}

function editClassroom($classroomID, $data) {
    global $conn;
    $classroomID = $conn->real_escape_string($classroomID);
    $building = $conn->real_escape_string($data['building']);
    $capacity = intval($data['capacity']);
    $multimedia = intval($data['multimedia']);
    $conn->query("UPDATE Classrooms SET Building='$building', Capacity=$capacity, MultimediaAvail=$multimedia 
                  WHERE ClassroomID='$classroomID'");
}

function deleteClassroom($classroomID) {
    global $conn;
    $classroomID = $conn->real_escape_string($classroomID);
    $conn->query("DELETE FROM Classrooms WHERE ClassroomID='$classroomID'");
}

// -------------------------
// Faculty Preferences
// -------------------------
function getFacultyPreferences($facultyID) {
    global $conn;
    $facultyID = $conn->real_escape_string($facultyID);
    $result = $conn->query("SELECT * FROM preferences WHERE FacultyID='$facultyID' ORDER BY PrefID");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

function addFacultyPreference($facultyID, $courseCode, $day = NULL, $timeSlotID = NULL) {
    global $conn;
    $facultyID = $conn->real_escape_string($facultyID);
    $courseCode = $conn->real_escape_string($courseCode);
    $day = $day ? "'".$conn->real_escape_string($day)."'" : "NULL";
    $timeSlotID = $timeSlotID ? "'".$conn->real_escape_string($timeSlotID)."'" : "NULL";
    $conn->query("INSERT INTO preferences (FacultyID, CourseCode, Day, TimeSlotID) 
                  VALUES ('$facultyID', '$courseCode', $day, $timeSlotID)");
}

function editFacultyPreference($prefID, $courseCode, $day = NULL, $timeSlotID = NULL) {
    global $conn;
    $prefID = intval($prefID);
    $courseCode = $conn->real_escape_string($courseCode);
    $day = $day ? "'".$conn->real_escape_string($day)."'" : "NULL";
    $timeSlotID = $timeSlotID ? "'".$conn->real_escape_string($timeSlotID)."'" : "NULL";
    $conn->query("UPDATE preferences SET CourseCode='$courseCode', Day=$day, TimeSlotID=$timeSlotID WHERE PrefID=$prefID");
}

function deleteFacultyPreference($prefID) {
    global $conn;
    $prefID = intval($prefID);
    $conn->query("DELETE FROM preferences WHERE PrefID=$prefID");
}
function generateSchedule($conn){
    // 1. Fetch courses and their enrollment/multimedia requirement
    $courses = [];
    $res = $conn->query("SELECT * FROM courses ORDER BY CourseCode");
    while($c = $res->fetch_assoc()) $courses[] = $c;

    // 2. Fetch faculty preferences
    $prefs = [];
    $res = $conn->query("SELECT * FROM preferences ORDER BY CreatedAt ASC");
    while($p = $res->fetch_assoc()) {
        $prefs[$p['CourseCode']][] = $p;
    }

    // 3. Fetch classrooms
    $classrooms = [];
    $res = $conn->query("SELECT * FROM classrooms");
    while($r = $res->fetch_assoc()) {
        $r['AvailableSlots'] = explode(',', $r['AvailableSlots']);
        $classrooms[] = $r;
    }

    // 4. Define time slots excluding TS4 (break)
    $timeSlots = ['TS1','TS2','TS3','TS5','TS6'];
    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

    // Track courses already assigned per day
    $assignedCourses = [];

    // 5. Schedule courses based on preferences
    foreach($courses as $course){
        $courseCode = $course['CourseCode'];
        if(!isset($prefs[$courseCode])){
            continue; // no preferences, skip
        }

        // Sort by designation (Professor > Associate Professor > Assistant Professor > Lecturer)
        usort($prefs[$courseCode], function($a,$b) use ($conn){
            $rank = ['Professor'=>4,'Associate Professor'=>3,'Assistant Professor'=>2,'Lecturer'=>1];
            $fa = $conn->query("SELECT Designation FROM faculty WHERE FacultyID='{$a['FacultyID']}'")->fetch_assoc()['Designation'];
            $fb = $conn->query("SELECT Designation FROM faculty WHERE FacultyID='{$b['FacultyID']}'")->fetch_assoc()['Designation'];
            return $rank[$fb] - $rank[$fa]; // higher designation first
        });

        foreach($prefs[$courseCode] as $pref){
            $prefDay = $pref['Day'];
            $prefTime = $pref['TimeSlotID'];

            // Handle ALL slots for day
            $possibleDays = $prefDay=='ALL' ? $days : [$prefDay];
            $possibleTimes = $prefTime=='ALL' ? $timeSlots : [$prefTime];

            foreach($possibleDays as $day){
                // Skip if this course already scheduled for this day
                if(isset($assignedCourses[$courseCode][$day])) continue;

                foreach($possibleTimes as $ts){
                    if($ts === 'TS4') continue; // skip break

                    // Find available classroom
                    foreach($classrooms as &$room){
                        if(in_array($ts, $room['AvailableSlots']) && $room['Capacity'] >= $course['Enrollment']){
                            // Assign course
                            $stmt = $conn->prepare("INSERT INTO schedule (CourseCode, FacultyID, ClassroomID, Day, TimeSlotID) VALUES (?,?,?,?,?)");
                            $stmt->bind_param("sssss", $courseCode, $pref['FacultyID'], $room['ClassroomID'], $day, $ts);
                            $stmt->execute();
                            $stmt->close();

                            // Mark course as scheduled for this day
                            $assignedCourses[$courseCode][$day] = true;

                            // Remove the slot from available slots
                            $key = array_search($ts, $room['AvailableSlots']);
                            unset($room['AvailableSlots'][$key]);
                            $room['AvailableSlots'] = array_values($room['AvailableSlots']);

                            // Update classroom in DB
                            $conn->query("UPDATE classrooms SET AvailableSlots='".implode(',', $room['AvailableSlots'])."' WHERE ClassroomID='{$room['ClassroomID']}'");

                            break 3; // move to next course
                        }
                    }
                }
            }
        }
    }
}



// -------------------------
// Schedule
// -------------------------
function getSchedule() {
    global $conn;
    $result = $conn->query("SELECT * FROM Schedule");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

if(isset($_POST['autoSchedule'])){
    $conn->query("UPDATE classrooms SET AvailableSlots='TS1,TS2,TS3,TS4,TS5,TS6'");
    $conn->query("TRUNCATE TABLE schedule");
    generateSchedule($conn);
    echo "<p style='color:green; text-align:center;'>Schedule generated successfully!</p>";
    echo "<script>window.location.href='schedule.php';</script>";
    exit;
}

if(isset($_POST['resetSchedule'])){
    $conn->query("UPDATE classrooms SET AvailableSlots='TS1,TS2,TS3,TS4,TS5,TS6'");
    $conn->query("TRUNCATE TABLE schedule");
    echo "<p style='color:red; text-align:center;'>Schedule has been reset to default (empty).</p>";
    echo "<script>window.location.href='schedule.php';</script>";
    exit;
}

?>
