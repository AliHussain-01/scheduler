<?php
require_once "config.php"; 
require_once "functions.php";

// Handle Classroom Add/Delete
if (isset($_POST['addClassroom'])) {
    addClassroom($_POST);
    header("Location: classroom.php");
    exit;
}
if (isset($_GET['deleteClassroom'])) {
    deleteClassroom($_GET['deleteClassroom']);
    header("Location: classroom.php");
    exit;
}

// Fetch Classrooms
$classroomList = getClassrooms();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Classrooms</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= filemtime('assets/style.css') ?>">
    <style>
    /* Classroom card styling */
    .classroom-card {
        background: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 15px 20px;
        margin: 15px 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: 0.3s;
    }
    .classroom-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .classroom-card strong {
        display: block;
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
    }
    .classroom-card span {
        display: block;
        font-size: 14px;
        color: #555;
        margin: 2px 0;
    }
    .multimedia-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        margin-top: 8px;
    }
    .multimedia-yes { background: #28a745; color: white; }
    .multimedia-no { background: #dc3545; color: white; }
    .classroom-actions {
        margin-top: 12px;
    }
    .classroom-actions a {
        margin: 0 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }
    .classroom-actions a.edit { color: #17a2b8; }
    .classroom-actions a.delete { color: #dc3545; }
    </style>
</head>
<body>
    <h1>Manage Classrooms</h1>

    <nav>
        <a href="index.php">Dashboard</a>
        <a href="faculty.php">Faculty</a>
        <a href="courses.php">Courses</a> 
        <a href="classrooms.php">Classrooms</a> 
        <a href="schedule.php">Schedule</a>
    </nav>

    <section>
        <h2>Add Classroom</h2>
        <form method="POST" class="form-box">
            <label>ID: <input type="text" name="id" required></label>
            <label>Building: <input type="text" name="building" required></label>
            <label>Capacity: <input type="number" name="capacity" required></label>
            <label>Multimedia:
                <select name="multimedia">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </label>
            <button type="submit" name="addClassroom">Add Classroom</button>
        </form>
    </section>

    <section>
        <h2>All Classrooms</h2>
        <?php foreach ($classroomList as $r): ?>
            <div class="classroom-card">
                <strong><?= htmlspecialchars($r['ClassroomID']) ?></strong>
                <span>Building: <?= htmlspecialchars($r['Building']) ?></span>
                <span>Capacity: <?= $r['Capacity'] ?></span>
                <span>
                    <?php if ($r['MultimediaAvail']): ?>
                        <span class="multimedia-badge multimedia-yes">Multimedia: Yes</span>
                    <?php else: ?>
                        <span class="multimedia-badge multimedia-no">Multimedia: No</span>
                    <?php endif; ?>
                </span>
                <div class="classroom-actions">
                    <a href="editClassroom.php?id=<?= $r['ClassroomID'] ?>" class="edit">✏️ Edit</a> | 
                    <a href="classroom.php?deleteClassroom=<?= $r['ClassroomID'] ?>" class="delete" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</body>
</html>
