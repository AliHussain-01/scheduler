<?php
require_once "config.php";
require_once "functions.php";

if(!isset($_GET['id'])){
    die("No Classroom ID specified.");
}

$classroomID = $_GET['id'];

// Fetch current classroom data
$sql = "SELECT * FROM Classrooms WHERE ClassroomID='$classroomID'";
$result = $conn->query($sql);
if($result->num_rows == 0){
    die("Classroom not found.");
}
$classroom = $result->fetch_assoc();

// Handle form submission
if(isset($_POST['updateClassroom'])){
    editClassroom($classroomID, $_POST);
    header("Location: classrooms.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Classroom</title>
	<link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
</head>
<body>
    <h1>Edit Classroom</h1>
    <form method="POST">
        ID: <input type="text" name="id" value="<?= htmlspecialchars($classroom['ClassroomID']) ?>" readonly><br>
        Building: <input type="text" name="building" value="<?= htmlspecialchars($classroom['Building']) ?>" required><br>
        Capacity: <input type="number" name="capacity" value="<?= $classroom['Capacity'] ?>" required><br>
        Multimedia (1/0): <input type="number" name="multimedia" min="0" max="1" value="<?= $classroom['MultimediaAvail'] ?>"><br>
        <button type="submit" name="updateClassroom">Update</button>
    </form>
    <p><a href="classrooms.php">Back to Manage Classrooms</a></p>
</body>
</html>
